<?php

/**
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author daniel
 * @copyright 2020 daniel
 * @licence MIT
 * @version 2.4.0
 * @link https://www.xnova.nat.cu
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");

require 'includes/classes/class.FlyingFleetsTable.php';

function ShowFleetLogPage()
{
	global $LNG;
	
		
	$id	= HTTP::_GP('id', 0);	
	$orderBy		= "fleet_id";

	/*fleet.*, 
	pstart.name as startPlanetName,
	ptarget.name as targetPlanetName,
	ustart.username as startUserName,
	utarget.username as targetUserName 
	FROM ".LOG_FLEETS." fleet 
	LEFT JOIN ".PLANETS." pstart ON pstart.id = fleet_start_id
	LEFT JOIN ".PLANETS." ptarget ON ptarget.id = fleet_end_id
	LEFT JOIN ".USERS." ustart ON ustart.id = fleet_owner
	LEFT JOIN ".USERS." utarget ON utarget.id = fleet_target_owner WHERE fleet_universe = ".Universe::getEmulated()." AND fleet_mission = 1 AND fleet_target_owner = 752 AND fleet_end_id = 2319 GROUP BY fleet_id ORDER BY ".$orderBy.";");*/
	$fleetResult	= $GLOBALS['DATABASE']->query("SELECT 
	fleet.*, 
	pstart.name as startPlanetName,
	ptarget.name as targetPlanetName,
	ustart.username as startUserName,
	utarget.username as targetUserName 
	FROM ".LOG_FLEETS." fleet 
	LEFT JOIN ".PLANETS." pstart ON pstart.id = fleet_start_id
	LEFT JOIN ".PLANETS." ptarget ON ptarget.id = fleet_end_id
	LEFT JOIN ".USERS." ustart ON ustart.id = fleet_owner
	LEFT JOIN ".USERS." utarget ON utarget.id = fleet_target_owner WHERE fleet_universe = ".Universe::getEmulated()." AND fleet_target_owner = 46 AND fleet_mission = 4 ORDER BY ".$orderBy." DESC LIMIT 10000;");
	
	$FleetList	= array();
	
	while($fleetRow = $GLOBALS['DATABASE']->fetch_array($fleetResult)) {
		$shipList		= array();
		$shipArray		= array_filter(explode(';', $fleetRow['fleet_array']));
		foreach($shipArray as $ship) {
			$shipDetail		= explode(',', $ship);
			$shipList[$shipDetail[0]]	= $shipDetail[1];
		}
		
		$FleetList[]	= array(
			'fleetID'				=> $fleetRow['fleet_id'],
			'lock'					=> !empty($fleetRow['lock']),
			'count'					=> $fleetRow['fleet_amount'],
			'error'					=> !$fleetRow['error'],
			'ships'					=> $shipList,
			'state'					=> $fleetRow['fleet_mess'],
			'starttime'				=> _date($LNG['php_tdformat'], $fleetRow['start_time'], $USER['timezone']),
			'arrivaltime'			=> _date($LNG['php_tdformat'], $fleetRow['fleet_start_time'], $USER['timezone']),
			'stayhour'				=> round(($fleetRow['fleet_end_stay'] - $fleetRow['fleet_start_time']) / 3600),
			'staytime'				=> $fleetRow['fleet_start_time'] !== $fleetRow['fleet_end_stay'] ? _date($LNG['php_tdformat'], $fleetRow['fleet_end_stay'], $USER['timezone']) : 0,
			'endtime'				=> _date($LNG['php_tdformat'], $fleetRow['fleet_end_time'], $USER['timezone']),
			'missionID'				=> $fleetRow['fleet_mission'],
			'acsID'					=> $fleetRow['fleet_group'],
			'acsName'				=> $fleetRow['acsName'],
			'startUserID'			=> $fleetRow['fleet_owner'],
			'startUserName'			=> $fleetRow['startUserName'],
			'startPlanetID'			=> $fleetRow['fleet_start_id'],
			'startPlanetName'		=> $fleetRow['startPlanetName'],
			'startPlanetGalaxy'		=> $fleetRow['fleet_start_galaxy'],
			'startPlanetSystem'		=> $fleetRow['fleet_start_system'],
			'startPlanetPlanet'		=> $fleetRow['fleet_start_planet'],
			'startPlanetType'		=> $fleetRow['fleet_start_type'],
			'targetUserID'			=> $fleetRow['fleet_target_owner'],
			'targetUserName'		=> $fleetRow['targetUserName'],
			'targetPlanetID'		=> $fleetRow['fleet_end_id'],
			'targetPlanetName'		=> $fleetRow['targetPlanetName'],
			'targetPlanetGalaxy'	=> $fleetRow['fleet_end_galaxy'],
			'targetPlanetSystem'	=> $fleetRow['fleet_end_system'],
			'targetPlanetPlanet'	=> $fleetRow['fleet_end_planet'],
			'targetPlanetType'		=> $fleetRow['fleet_end_type'],
			'resource'				=> array(
				901	=> $fleetRow['fleet_resource_metal'],
				902	=> $fleetRow['fleet_resource_crystal'],
				903	=> $fleetRow['fleet_resource_deuterium'],
				921	=> $fleetRow['fleet_resource_darkmatter'],
			),
		);
	}
	
	
	$GLOBALS['DATABASE']->free_result($fleetResult);
	
	$template			= new template();
	$template->loadscript('styles/assets/js/plugins/forms/selects/select2.min.js');
	$template->loadscript('styles/assets/js/plugins/tables/datatables/datatables.min.js');
	$template->loadscript('styles/assets/js/core/app.js');
	$template->loadscript('styles/assets/js/pages/datatables_advanced.js');
	$template->assign_vars(array(
		'FleetList'			=> $FleetList,
		'pageactiveshow'	=> HTTP::_GP('page', "", true),
	));
	$template->show('FleetLog.tpl');
	
}
