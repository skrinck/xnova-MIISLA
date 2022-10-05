<?php

/**
 *  2Moons
 *   by Yamil Readigos Hurtado 2019-2020
 *   by Rayco Garcia Fernandez 2020
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons Moon Dark
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @author Yamil Readigos Hurtado <ireadigos@gmail.com>
 * @author Rayco Garcia Fernandez <rayco.garcia13@nauta.cu>
 * @copyright 2020 YamilRH
 * @copyright 2020 Yamil Readigos Hurtado <ireadigos@gmail.com>
 * @licence MIT
 * @version 2.6
 * @link https://www.miisla.nat.cu
 */

class ShowFleetPage extends AbstractGamePage
{
	public static $requireModule = 0;
	function __construct()
	{
		parent::__construct();
	}
	function show()
	{
			global $USER, $LNG, $PLANET;
				$db	 = Database::get();
				$config = Config::get();

				$fleetGroup = HTTP::_GP('group', 1);
				$fleetGroupOK = array(1,2,3,4,5,7,8,9);


				$orderBy		= "fleet_id";

			$fleetResult	= $db->query("SELECT 
			fleet.*,
			event.`lock`,
			COUNT(event.fleetID) as error,
			pstart.name as startPlanetName,
			ptarget.name as targetPlanetName,
			ustart.username as startUserName,
			utarget.username as targetUserName,
			acs.name as acsName
			FROM %%FLEETS%% fleet
			LEFT JOIN ".FLEETS_EVENT." event ON fleetID = fleet_id
			LEFT JOIN ".PLANETS." pstart ON pstart.id = fleet_start_id
			LEFT JOIN ".PLANETS." ptarget ON ptarget.id = fleet_end_id
			LEFT JOIN ".USERS." ustart ON ustart.id = fleet_owner
			LEFT JOIN ".USERS." utarget ON utarget.id = fleet_target_owner
			LEFT JOIN ".AKS." acs ON acs.id = fleet_group
			WHERE fleet_universe = ".Universe::getEmulated()."
			GROUP BY event.fleetID
			ORDER BY ".$orderBy.";");
			
			$FleetList	= array();
			
			while($fleetRow = $db->fetch_array($fleetResult)) {
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
						922	=> $fleetRow['fleet_resource_antimatter'],
					),
				);
			}
		
			$this->assign(array(
				'fleetGroup'	=> $fleetGroup,
			));
			$this->display('page.fleet.default.tpl');
		}
}