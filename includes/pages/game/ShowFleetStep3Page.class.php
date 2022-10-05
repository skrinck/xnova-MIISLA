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

class ShowFleetStep3Page extends AbstractGamePage
{
	public static $requireModule = MODULE_FLEET_TABLE;

	function __construct() 
	{
		parent::__construct();
	}
	
	public function show()
	{
		global $USER, $PLANET, $resource, $LNG;
			
		if (IsVacationMode($USER)) {
			FleetFunctions::GotoFleetPage(0);
		}
		
		$targetMission 			= HTTP::_GP('mission', 3);
		$TransportMetal			= max(0, round(HTTP::_GP('metal', 0.0)));
		$TransportCrystal		= max(0, round(HTTP::_GP('crystal', 0.0)));
		$TransportDeuterium		= max(0, round(HTTP::_GP('deuterium', 0.0)));
		$stayTime 				= HTTP::_GP('staytime', 0);
		$token					= HTTP::_GP('token', '');
		$captcha				= HTTP::_GP('captcha', '');
		$captcha_code			= HTTP::_GP('captcha_code', '');

		$config					= Config::get();
		
		if ($targetMission == 15) {
			$db = Database::get();
	        $sql = "SELECT COUNT(id) as checking FROM uni1_captcha_code WHERE captcha = :captcha_code AND code = :captcha;";
	        $CaptchaData = $db->selectSingle($sql, array(
	            ':captcha' => $captcha,
	            ':captcha_code' => $captcha_code
	        ));

	        if ($CaptchaData["checking"] == 0) {
	        	$this->printMessage($LNG['fl_error_captcha'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			    )));
				//@session_destroy();
				return;
	        }
	    }

		if (!isset($_SESSION['fleet'][$token])) {
			FleetFunctions::GotoFleetPage(1);
		}
			
		if ($_SESSION['fleet'][$token]['time'] < TIMESTAMP - 600) {
			unset($_SESSION['fleet'][$token]);
			FleetFunctions::GotoFleetPage(0);
		}

		$formData		= $_SESSION['fleet'][$token];
        unset($_SESSION['fleet'][$token]);

		$distance		= $formData['distance'];
		$targetGalaxy	= $formData['targetGalaxy'];
		$targetSystem	= $formData['targetSystem'];
		$targetPlanet	= $formData['targetPlanet'];
		$targetType		= $formData['targetType'];
		$fleetGroup		= $formData['fleetGroup'];
		$fleetArray  	= $formData['fleet'];
		$fleetStorage	= $formData['fleetRoom'];
		$fleetSpeed		= $formData['fleetSpeed'];

		$ownPlanet		= $formData['ownPlanet'];

		if($ownPlanet != $PLANET['id']){

			/*$config = Config::get(Universe::current());
			$db = Database::get();
			$sql	= 'INSERT INTO %%BANNED%% SET who = :who, theme= :theme, `time` = :systime , longer = 2147483647 , author= :autor , email = :email , universe = :universe;';
				$db->insert($sql, array(
					':who'	=> $USER['username'],
					':theme' => 'Movimiento ilegal de flota, no se aceptan a este tipo de usuarios',
					':systime' => time(),
					':autor' => "System",
					':email' => $config->smtp_sendmail,
					':universe'	=> Universe::current()
				));
			$sql	= "UPDATE %%USERS%% SET bana = 1, banaday = 2147483647 WHERE id = :userId;";
					$db->update($sql, array(
					':userId'       => $USER['id']
				));*/

			$this->printMessage($LNG['fl_own_planet_error'], array(array(
			'label'	=> $LNG['sys_back'],
			'url'	=> 'game.php?page=fleetTable'
		    )));
			//@session_destroy();
			return;
		}
		
		if($targetMission != 2)
		{
			$fleetGroup	= 0;
		}
			
		if ($PLANET['galaxy'] == $targetGalaxy && $PLANET['system'] == $targetSystem && $PLANET['planet'] == $targetPlanet && $PLANET['planet_type'] == $targetType)
		{
			$this->printMessage($LNG['fl_error_same_planet'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}

		if ($targetGalaxy < 1 || $targetGalaxy > $config->max_galaxy || 
			$targetSystem < 1 || $targetSystem > $config->max_system || 
			$targetPlanet < 1 || $targetPlanet > ($config->max_planets + 1) ||
			($targetType !== 1 && $targetType !== 2 && $targetType !== 3)) {
			$this->printMessage($LNG['fl_invalid_target'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}

		

//check aliansa mode by hirako
        if ($targetMission == 3){
            $db = Database::get();
            $sql = "SELECT id_owner
                FROM %%PLANETS%% WHERE
                galaxy = :targetGalaxy AND
                system = :targetSystem AND
                planet = :targetPlanet  AND
                planet_type = :targetType;";
                
                $target_owner = $db->selectSingle($sql, array(
                ':targetGalaxy' => $targetGalaxy,
                ':targetSystem' => $targetSystem,
                ':targetPlanet' => $targetPlanet,
                ':targetType' => (($targetType == 2) ? 1 : $targetType),
            ));
            
            $sql1 = "SELECT ally_id FROM %%USERS%% where id = :user_id;";
            $owner_ally = $db->selectSingle($sql1, array(
                ':user_id'     =>$USER['id'],
            ));
            $sql2 = "SELECT ally_id FROM %%USERS%% where id = :user_id;";
            $target_ally = $db->selectSingle($sql2, array(
                ':user_id'     =>$target_owner['id_owner'],
            ));
            
            
            
            $sql3    = "SELECT d.level, d.accept, d.id FROM %%DIPLO%% as d WHERE (:owner = d.owner_1 AND :target = d.owner_2 ) OR (:owner = d.owner_2 AND :target = d.owner_1 );";
            
            $DiploResult    = $db->select($sql3, array(
            ':owner'        => $owner_ally['ally_id'],
            ':target'        => $target_ally['ally_id']
            ));
            
            $com_pact=0;
            foreach ($DiploResult as $diplo){
                if($diplo['level']==3 && $diplo['accept']==1)$com_pact=$diplo['id'];
            }
            
            if($owner_ally['ally_id'] != $target_ally['ally_id'] && !$com_pact){
                $this->printMessage($LNG['fl_no_same_alliance'], array(array(
                'label'    => $LNG['sys_back'],
                'url'    => 'game.php?page=fleetTable'
            )));
                
            }
        }
            
        //en fix



			if ($targetMission == 3 && $TransportMetal + $TransportCrystal + $TransportDeuterium < 1)
		{
			$this->printMessage($LNG['fl_no_noresource'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}
		
		$ActualFleets		= FleetFunctions::GetCurrentFleets($USER['id']);
		
		if (FleetFunctions::GetMaxFleetSlots($USER) <= $ActualFleets)
		{
			$this->printMessage($LNG['fl_no_slots'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}
		
		$ACSTime = 0;

        $db = Database::get();

        if(!empty($fleetGroup))
		{
            $sql = "SELECT ankunft FROM %%USERS_ACS%% INNER JOIN %%AKS%% ON id = acsID
			WHERE acsID = :acsID AND :maxFleets > (SELECT COUNT(*) FROM %%FLEETS%% WHERE fleet_group = :acsID);";
            $ACSTime = $db->selectSingle($sql, array(
                ':acsID'        => $fleetGroup,
                ':maxFleets'    => $config->max_fleets_per_acs,
            ), 'ankunft');

            if (empty($ACSTime)) {
				$fleetGroup	= 0;
				$targetMission	= 1;
			}
		}

	$sql = "SELECT id, id_owner, der_metal, der_crystal, destruyed, ally_deposit, gal6mod FROM %%PLANETS%% WHERE universe = :universe AND galaxy = :targetGalaxy AND system = :targetSystem AND planet = :targetPlanet AND planet_type = :targetType;";
        $targetPlanetData = $db->selectSingle($sql, array(
            ':universe'     => Universe::current(),
            ':targetGalaxy' => $targetGalaxy,
            ':targetSystem' => $targetSystem,
            ':targetPlanet' => $targetPlanet,
            ':targetType' => ($targetType == 2 ? 1 : $targetType),
        ));

		if ($targetMission == 7)
		{
			if (!empty($targetPlanetData)) {
				$this->printMessage($LNG['fl_target_exists'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}
			
			if ($targetType != 1) {
				$this->printMessage($LNG['fl_only_planets_colonizable'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}
		}
		
	//	if ($targetMission == 7 || $targetMission == 15)
	//	{
	//		$targetPlanetData	= array('id' => 0, 'id_owner' => 0, 'planettype' => 1);
	//	}
		if ($targetMission == 7 || $targetMission == 15 || $targetMission == 16 || $targetMission == 19)
		{
			$targetPlanetData	= array('id' => 0, 'id_owner' => 0, 'planettype' => 1, 'der_metal' => 0, 'der_crystal' => 0, 'gal6mod' => 0);
		}
		else
		{
			if ($targetPlanetData["destruyed"] != 0) {
				$this->printMessage($LNG['fl_no_target'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}
				
			if (empty($targetPlanetData)) {
				$this->printMessage($LNG['fl_no_target'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}
		}
		
		foreach ($fleetArray as $Ship => $Count)
		{
			if ($Count > $PLANET[$resource[$Ship]]) {
				$this->printMessage($LNG['fl_not_all_ship_avalible'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}
		}
		
		if ($targetMission == 11)
		{
			$activeExpedition	= FleetFunctions::GetCurrentFleets($USER['id'], 11, true);
			$maxExpedition		= FleetFunctions::getDMMissionLimit($USER);

			if ($activeExpedition >= $maxExpedition) {
				$this->printMessage($LNG['fl_no_expedition_slot'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}
		}
		elseif ($targetMission == 15)
		{		
			$activeExpedition	= FleetFunctions::GetCurrentFleets($USER['id'], 15, true);
			$maxExpedition		= FleetFunctions::getExpeditionLimit($USER);
			
			if ($activeExpedition >= $maxExpedition) {
				$this->printMessage($LNG['fl_no_expedition_slot'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}
		}
		elseif ($targetMission == 16)
		{
		
			$activeAsteroids	= FleetFunctions::GetCurrentFleets($USER['id'], 16, true);
			$maxAsteroids		= FleetFunctions::getAsteroidLimit($USER);

			if ($activeAsteroids >= $maxAsteroids) {
				$this->printMessage($LNG['fl_no_asteroid_slot'], true, array('game.php?page=fleetTable', 2));
			}
		}

		$usedPlanet	= isset($targetPlanetData['id_owner']);
		$myPlanet	= $usedPlanet && $targetPlanetData['id_owner'] == $USER['id'];
		$targetPlayerData	= array();

		if($targetMission == 7 || $targetMission == 15 || $targetMission == 19) {
			$targetPlayerData	= array(
				'id'				=> 0,
				'onlinetime'		=> TIMESTAMP,
				'ally_id'			=> 0,
				'urlaubs_modus'		=> 0,
				'authattack'		=> 0,
				'total_points'		=> 0,
			);
		} elseif($myPlanet) {
			$targetPlayerData	= $USER;
		} elseif(!empty($targetPlanetData['id_owner'])) {
            $sql = "SELECT user.id, user.onlinetime, user.ally_id, user.urlaubs_modus, user.banaday, user.authattack,
                stat.total_points
                FROM %%USERS%% as user
                LEFT JOIN %%STATPOINTS%% as stat ON stat.id_owner = user.id AND stat.stat_type = '1'
                WHERE user.id = :ownerID;";

			$targetPlayerData = $db->selectSingle($sql, array(
                ':ownerID'  => $targetPlanetData['id_owner']
            ));
		}

		if(empty($targetPlayerData))
		{
			$this->printMessage($LNG['fl_empty_target'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}
		
		$MisInfo		     	= array();		
		$MisInfo['galaxy']     	= $targetGalaxy;		
		$MisInfo['system'] 	  	= $targetSystem;	
		$MisInfo['planet'] 	  	= $targetPlanet;		
		$MisInfo['planettype'] 	= $targetType;	
		$MisInfo['IsAKS']		= $fleetGroup;
		$MisInfo['Ship'] 		= $fleetArray;		
		
		$availableMissions		= FleetFunctions::GetFleetMissions($USER, $MisInfo, $targetPlanetData);
		
		if (!in_array($targetMission, $availableMissions['MissionSelector'])) {
			$this->printMessage($LNG['fl_invalid_mission'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}
		
		if ($targetMission != 8 && IsVacationMode($targetPlayerData)) {
			$this->printMessage($LNG['fl_target_exists'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}
		
		if($targetMission == 1 || $targetMission == 2 || $targetMission == 9) {
			if(FleetFunctions::CheckBash($targetPlanetData['id']))
			{
				$this->printMessage($LNG['fl_bash_protection'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}
		}

		
		
		if($targetMission == 1 || $targetMission == 2 || $targetMission == 5 || $targetMission == 6 || $targetMission == 9)
		{
			if(Config::get()->adm_attack == 1 && $targetPlayerData['authattack'] > $USER['authlevel'])
			{
				$this->printMessage($LNG['fl_admin_attack'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}


			$sql	= 'SELECT total_points
			FROM %%STATPOINTS%%
			WHERE id_owner = :userId AND stat_type = :statType';

			$USER	+= Database::get()->selectSingle($sql, array(
				':userId'	=> $USER['id'],
				':statType'	=> 1
			));
		
			$IsNoobProtec	= CheckNoobProtec($USER, $targetPlayerData, $targetPlayerData);
			
			if ($IsNoobProtec['NoobPlayer'])
			{
				$this->printMessage($LNG['fl_player_is_noob'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}
			
			if ($IsNoobProtec['StrongPlayer']) {
				$this->printMessage($LNG['fl_player_is_strong'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}
		}

	//	if ($targetMission == 1){

			/**
		*Fix para que no se atquen los aliados
		**/
/*
			$db = Database::get();

            $sql = "SELECT id_owner
                FROM %%PLANETS%% WHERE
                galaxy = :targetGalaxy AND
                system = :targetSystem AND
                planet = :targetPlanet  AND
                planet_type = :targetType;";
                
                $target_owner = $db->selectSingle($sql, array(
                ':targetGalaxy' => $targetGalaxy,
                ':targetSystem' => $targetSystem,
                ':targetPlanet' => $targetPlanet,
                ':targetType' => (($targetType == 2) ? 1 : $targetType),
            ));
			$sql1 = "SELECT ally_id FROM %%USERS%% where id = :user_id;";
            $owner_ally = $db->selectSingle($sql1, array(
                ':user_id'     =>$USER['id'],
            ));
            $sql2 = "SELECT ally_id FROM %%USERS%% where id = :user_id;";
            $target_ally = $db->selectSingle($sql2, array(
                ':user_id'     =>$target_owner['id_owner'],
            ));
                        
            $sql3    = "SELECT d.level, d.accept, d.id FROM %%DIPLO%% as d WHERE (:owner = d.owner_1 AND :target = d.owner_2 ) OR (:owner = d.owner_2 AND :target = d.owner_1 );";
            
            $DiploResult    = $db->select($sql3, array(
            ':owner'        => $owner_ally['ally_id'],
            ':target'        => $target_ally['ally_id']
            ));
            
            $com_pact=0;
            foreach ($DiploResult as $diplo){
                if($diplo['level']!=5 && $diplo['accept']==1)$com_pact=$diplo['id'];
            }

            $sql4 = "SELECT COUNT(*) as state FROM %%BUDDY%%
				WHERE id NOT IN (SELECT id FROM %%BUDDY_REQUEST%% WHERE %%BUDDY_REQUEST%%.id = %%BUDDY%%.id) AND
				(owner = :ownerID AND sender = :userID) OR (owner = :userID AND sender = :ownerID);";
                $buddy = $db->selectSingle($sql4, array(
                    ':ownerID'  => $targetPlayerData['id'],
                    ':userID'   => $USER['id']
                ), 'state');

			if ($com_pact || $buddy || $targetPlayerData['ally_id'] == $USER['ally_id']) {
			$this->printMessage($LNG['fl_bash_yamil'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}
		}*/
		/**
		*end Fix
		**/

		if ($targetMission == 5)
		{	
			if($targetPlayerData['ally_id'] != $USER['ally_id']) {
				$sql = "SELECT COUNT(*) as state FROM %%BUDDY%%
				WHERE id NOT IN (SELECT id FROM %%BUDDY_REQUEST%% WHERE %%BUDDY_REQUEST%%.id = %%BUDDY%%.id) AND
				(owner = :ownerID AND sender = :userID) OR (owner = :userID AND sender = :ownerID);";
                $buddy = $db->selectSingle($sql, array(
                    ':ownerID'  => $targetPlayerData['id'],
                    ':userID'   => $USER['id']
                ), 'state');

	               if($buddy == 0) {
					$this->printMessage($LNG['fl_no_same_alliance'], array(array(
						'label'	=> $LNG['sys_back'],
						'url'	=> 'game.php?page=fleetTable'
					)));
				}
			}
		}

		$fleetMaxSpeed 	= FleetFunctions::GetFleetMaxSpeed($fleetArray, $USER);
		$SpeedFactor    = FleetFunctions::GetGameSpeedFactor();
		$duration      	= FleetFunctions::GetMissionDuration($fleetSpeed, $fleetMaxSpeed, $distance, $SpeedFactor, $USER);
		$consumption   	= FleetFunctions::GetFleetConsumption($fleetArray, $duration, $distance, $USER, $SpeedFactor);
	
		if ($PLANET[$resource[903]] < $consumption) {
			$this->printMessage($LNG['fl_not_enough_deuterium'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}
		
		$StayDuration    = 0;
		
		if($targetMission == 5 || $targetMission == 11 || $targetMission == 15)
		{
			if(!isset($availableMissions['StayBlock'][$stayTime]))
			{
				$this->printMessage($LNG['fl_hold_time_not_exists'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}
			
			$StayDuration    = round($availableMissions['StayBlock'][$stayTime] * 3600, 0);
		}
		
		$fleetStorage		-= $consumption;
		
		$fleetResource	= array(
			901	=> min($TransportMetal, floor($PLANET[$resource[901]])),
			902	=> min($TransportCrystal, floor($PLANET[$resource[902]])),
			903	=> min($TransportDeuterium, floor($PLANET[$resource[903]] - $consumption)),
		);
		
		$StorageNeeded		= array_sum($fleetResource);
		
		if ($StorageNeeded > $fleetStorage)
		{
			$this->printMessage($LNG['fl_not_enough_space'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}
		
		$PLANET[$resource[901]]	-= $fleetResource[901];
		$PLANET[$resource[902]]	-= $fleetResource[902];
		$PLANET[$resource[903]]	-= $fleetResource[903] + $consumption;

		$fleetStartTime		= $duration + TIMESTAMP;
		$timeDifference		= round(max(0, $fleetStartTime - $ACSTime));
		
		if($fleetGroup != 0)
		{
			if($timeDifference != 0)
			{
				FleetFunctions::setACSTime($timeDifference, $fleetGroup);
			}
			else
			{
				$fleetStartTime		= $ACSTime;
			}
		}
		
		$fleetStayTime		= $fleetStartTime + $StayDuration;
		$fleetEndTime		= $fleetStayTime + $duration;
		
		FleetFunctions::sendFleet($fleetArray, $targetMission, $USER['id'], $PLANET['id'], $PLANET['galaxy'],
			$PLANET['system'], $PLANET['planet'], $PLANET['planet_type'], $targetPlanetData['id_owner'],
			$targetPlanetData['id'], $targetGalaxy, $targetSystem, $targetPlanet, $targetType, $fleetResource,
			$fleetStartTime, $fleetStayTime, $fleetEndTime, $fleetGroup);
		
		foreach ($fleetArray as $Ship => $Count)
		{
			$fleetList[$LNG['tech'][$Ship]]	= $Count;
		}

		$this->tplObj->gotoside('game.php?page=fleetTable');
		$this->assign(array(
			'targetMission'		=> $targetMission,
			'distance'			=> $distance,
			'consumption'		=> $consumption,
			'from'				=> $PLANET['galaxy'] .":". $PLANET['system']. ":". $PLANET['planet'],
			'destination'		=> $targetGalaxy .":". $targetSystem .":". $targetPlanet,
			'fleetStartTime'	=> _date($LNG['php_tdformat'], $fleetStartTime, $USER['timezone']),
			'fleetEndTime'		=> _date($LNG['php_tdformat'], $fleetEndTime, $USER['timezone']),
			'MaxFleetSpeed'		=> $fleetMaxSpeed,
			'FleetList'			=> $fleetArray,
		));
		
		$this->display('page.fleetStep3.default.tpl');
	}
}
