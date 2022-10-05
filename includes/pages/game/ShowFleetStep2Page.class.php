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

class ShowFleetStep2Page extends AbstractGamePage
{
	public static $requireModule = MODULE_FLEET_TABLE;

	function __construct() 
	{
		parent::__construct();
	}

	
	public function show()
	{
		global $USER, $PLANET, $LNG;
	
		$this->tplObj->loadscript('flotten.js');

		
		$targetGalaxy  				= HTTP::_GP('galaxy', 0);
		$targetSystem   			= HTTP::_GP('system', 0);
		$targetPlanet   			= HTTP::_GP('planet', 0);
		$targetType 				= HTTP::_GP('type', 0);
		$targetMission 				= HTTP::_GP('target_mission', 0);
		$fleetSpeed  				= HTTP::_GP('speed', 0);		
		$fleetGroup 				= HTTP::_GP('fleet_group', 0);
		$token						= HTTP::_GP('token', '');

		/*$token = HTTP::_GP('secret', '');


		if ($token != Flash::getToken()) {
			HTTP::redirectTo('index.php?code=4');
		}*/

		if (!isset($_SESSION['fleet'][$token]))
		{
			FleetFunctions::GotoFleetPage();
		}

		$fleetArray    				= $_SESSION['fleet'][$token]['fleet'];

        $db = Database::get();
	$sql = "SELECT id, id_owner, der_metal, der_crystal, der_deuterium, gal6mod FROM %%PLANETS%% WHERE universe = :universe AND galaxy = :targetGalaxy AND system = :targetSystem AND planet = :targetPlanet AND planet_type = '1';";
        $targetPlanetData = $db->selectSingle($sql, array(
            ':universe' => Universe::current(),
            ':targetGalaxy' => $targetGalaxy,
            ':targetSystem' => $targetSystem,
            ':targetPlanet' => $targetPlanet
        ));

	if($targetType == 2 && $targetPlanetData['der_metal'] == 0 && $targetPlanetData['der_crystal'] == 0 && $targetPlanetData['gal6mod'] == 0)
		{
			$this->printMessage($LNG['fl_error_empty_derbis'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}

		//MODS Asteroid
		if($targetType == 16 && $targetPlanetData['der_metal'] == 0 && $targetPlanetData['der_crystal'] == 0 && $targetPlanetData['der_deuterium'] == 0 && $targetPlanetData['gal6mod'] == 1)
		{
			$this->printMessage($LNG['fl_error_empty_derbis'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}

		$MisInfo		     		= array();		
		$MisInfo['galaxy']     		= $targetGalaxy;		
		$MisInfo['system'] 	  		= $targetSystem;	
		$MisInfo['planet'] 	  		= $targetPlanet;		
		$MisInfo['planettype'] 		= $targetType;	
		$MisInfo['IsAKS']			= $fleetGroup;
		$MisInfo['Ship'] 			= $fleetArray;		
		
		$MissionOutput	 			= FleetFunctions::GetFleetMissions($USER, $MisInfo, $targetPlanetData);
		
		if(empty($MissionOutput['MissionSelector']))
		{
			$this->printMessage($LNG['fl_empty_target'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}
		
		$GameSpeedFactor   		 	= FleetFunctions::GetGameSpeedFactor();		
		$MaxFleetSpeed 				= FleetFunctions::GetFleetMaxSpeed($fleetArray, $USER);
		$distance      				= FleetFunctions::GetTargetDistance(array($PLANET['galaxy'], $PLANET['system'], $PLANET['planet']), array($targetGalaxy, $targetSystem, $targetPlanet));
		$duration      				= FleetFunctions::GetMissionDuration($fleetSpeed, $MaxFleetSpeed, $distance, $GameSpeedFactor, $USER);
		$consumption				= FleetFunctions::GetFleetConsumption($fleetArray, $duration, $distance, $USER, $GameSpeedFactor);
		
		if($consumption > $PLANET['deuterium'])
		{
			$this->printMessage($LNG['fl_not_enough_deuterium'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}
		
		if(!FleetFunctions::CheckUserSpeed($fleetSpeed))
		{
			FleetFunctions::GotoFleetPage(0);
		}
		
		$_SESSION['fleet'][$token]['speed']			= $MaxFleetSpeed;
		$_SESSION['fleet'][$token]['distance']		= $distance;
		$_SESSION['fleet'][$token]['targetGalaxy']	= $targetGalaxy;
		$_SESSION['fleet'][$token]['targetSystem']	= $targetSystem;
		$_SESSION['fleet'][$token]['targetPlanet']	= $targetPlanet;
		$_SESSION['fleet'][$token]['targetType']	= $targetType;
		$_SESSION['fleet'][$token]['fleetGroup']	= $fleetGroup;
		$_SESSION['fleet'][$token]['fleetSpeed']	= $fleetSpeed;
		
		$_SESSION['fleet'][$token]['ownPlanet']		= $PLANET['id'];
		
		if(!empty($fleet_group))
			$targetMission	= 2;

		$fleetData	= array(
			'fleetroom'			=> floatToString($_SESSION['fleet'][$token]['fleetRoom']),
			'consumption'		=> floatToString($consumption),
		);
		
		$db = Database::get();
        $sql = "SELECT * FROM uni1_captcha_code ORDER BY RAND() LIMIT 1;";
        $CaptchaData = $db->selectSingle($sql);

  

		$this->tplObj->execscript('calculateTransportCapacity();');
		$this->assign(array(
			'fleetdata'						=> $fleetData,
			'consumption'					=> floatToString($consumption),
			'mission'						=> $targetMission,
			'galaxy'			 			=> $PLANET['galaxy'],
			'system'			 			=> $PLANET['system'],
			'planet'			 			=> $PLANET['planet'],
			'type'			 				=> $PLANET['planet_type'],
			'MissionSelector' 				=> $MissionOutput['MissionSelector'],
			'StaySelector' 					=> $MissionOutput['StayBlock'],
			'fl_dm_alert_message'			=> sprintf($LNG['fl_dm_alert_message'], $LNG['type_mission_11'], $LNG['tech'][921]),
			'fl_continue'					=> $LNG['fl_continue'],
			'token' 						=> $token,
			'captcha' 						=> $CaptchaData['captcha']
		));
		
		$this->display('page.fleetStep2.default.tpl');
	}
}
