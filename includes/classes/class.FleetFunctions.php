<?php

/**
 *  2Moons 
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
 */

class FleetFunctions 
{
	static $allowedSpeed	= array(10 => 100, 9 => 90, 8 => 80, 7 => 70, 6 => 60, 5 => 50, 4 => 40, 3 => 30, 2 => 20, 1 => 10);

	private $allianceData;
	
	private static function GetShipConsumption($Ship, $Player)
	{
		global $pricelist;

		return (($Player['impulse_motor_tech'] >= 5 && $Ship == 202) || ($Player['hyperspace_motor_tech'] >= 8 && $Ship == 211)) ? $pricelist[$Ship]['consumption2'] : $pricelist[$Ship]['consumption'];
	}

	private static function OnlyShipByID($Ships, $ShipID)
	{
		return isset($Ships[$ShipID]) && count($Ships) === 1;
	}

	private static function GetShipSpeed($Ship, $Player)
	{
		global $pricelist;
		
		$techSpeed	= $pricelist[$Ship]['tech'];
		
		if($techSpeed == 4) {
			$techSpeed = $Player['impulse_motor_tech'] >= 5 ? 2 : 1;
		}
		if($techSpeed == 5) {
			$techSpeed = $Player['hyperspace_motor_tech'] >= 8 ? 3 : 2;
		}
			
		
		switch($techSpeed)
		{
			case 1:
				$speed	= $pricelist[$Ship]['speed'] * (1 + (0.1 * $Player['combustion_tech']));
			break;
			case 2:
				$speed	= $pricelist[$Ship]['speed'] * (1 + (0.2 * $Player['impulse_motor_tech']));
			break;
			case 3:
				$speed	= $pricelist[$Ship]['speed'] * (1 + (0.3 * $Player['hyperspace_motor_tech']));
			break;
			default:
				$speed	= 0;
			break;
		}

		return $speed;
	}
	
	public static function getExpeditionLimit($USER)
	{
		return floor(sqrt($USER[$GLOBALS['resource'][124]]));
	}
	
	public static function getDMMissionLimit($USER)
	{
		//return Config::get($USER['universe'])->max_dm_missions;
		return floor(Config::get($USER['universe'])->max_dm_missions + floor($USER[$GLOBALS['resource'][124]] / 2));
	}

	public static function getAsteroidLimit($USER)
	{
		return floor(Config::get($USER['universe'])->max_asteroid + floor($USER[$GLOBALS['resource'][150]] / 5));
	}

	public static function getSaveCoordLimit($USER)
	{
		return floor(Config::get($USER['universe'])->max_save_coords + floor($USER[$GLOBALS['resource'][151]] / 2));
	}

	public static function getMissileRange($Level)
	{
		return max(($Level * 5) - 1, 0);
	}
	
	public static function CheckUserSpeed($speed)
	{
		return isset(self::$allowedSpeed[$speed]);
	}

	public static function GetTargetDistance($start, $target)
	{
		if ($start[0] != $target[0])
			return abs($start[0] - $target[0]) * 20000;
		
		if ($start[1] != $target[1])
			return abs($start[1] - $target[1]) * 95 + 2700;
		
		if ($start[2] != $target[2])
			return abs($start[2] - $target[2]) * 5 + 1000;

		return 5;
	}

	public static function GetMissionDuration($SpeedFactor, $MaxFleetSpeed, $Distance, $GameSpeed, $USER)
	{
		$SpeedFactor	= (3500 / ($SpeedFactor * 0.1));
		$SpeedFactor	*= pow($Distance * 10 / $MaxFleetSpeed, 0.5);
		$SpeedFactor	+= 10;
		$SpeedFactor	/= $GameSpeed;
		
		$gouvernor_fly = 0;
		if($USER['dm_fleettime'] > TIMESTAMP){
			$gouvernor_fly = GubPriceAPSTRACT(707, $USER['dm_fleettime_level'], 'dm_fleettime');
		}
			
		if($gouvernor_fly > 0)
		{
			$SpeedFactor	*= max(0, 1 + $gouvernor_fly/100*-1);
		}
		
		return max($SpeedFactor, MIN_FLEET_TIME);
	}
 
	public static function GetMIPDuration($startSystem, $targetSystem)
	{
		$Distance = abs($startSystem - $targetSystem);
		$Duration = max(round((30 + 60 * $Distance) / self::GetGameSpeedFactor()), MIN_FLEET_TIME);
		
		return $Duration;
	}

	public static function GetGameSpeedFactor()
	{
		return Config::get()->fleet_speed / 2500;
	}
	
	public static function GetMaxFleetSlots($USER)
	{
		global $resource;
		return 1 + $USER[$resource[108]] + $USER['factor']['FleetSlots'];
	}

	public static function GetFleetRoom($Fleet)
	{
		global $pricelist, $USER;
		$FleetRoom 				= 0;
		foreach ($Fleet as $ShipID => $amount)
		{
			$FleetRoom		   += $pricelist[$ShipID]['capacity'] * $amount * (1 + $USER['factor']['ShipStorage']);
		}
		return $FleetRoom;
	}
	
	public static function GetFleetMaxSpeed ($Fleets, $Player)
	{
		if(empty($Fleets)) {
			return 0;
		}

		$FleetArray = (!is_array($Fleets)) ? array($Fleets => 1) : $Fleets;
		$speedalls 	= array();
		
		foreach ($FleetArray as $Ship => $Count) {
			$speedalls[$Ship] = self::GetShipSpeed($Ship, $Player);
		}
		
		return min($speedalls);
	}

	public static function GetFleetConsumption($FleetArray, $MissionDuration, $MissionDistance, $Player, $GameSpeed)
	{
		$consumption = 0;

		foreach ($FleetArray as $Ship => $Count)
		{
			$ShipSpeed          = self::GetShipSpeed($Ship, $Player);
			$ShipConsumption    = self::GetShipConsumption($Ship, $Player);
			
			//$spd                = 35000 / (round($MissionDuration, 0) * $GameSpeed - 10) * sqrt($MissionDistance * 10 / $ShipSpeed);
			$spd                = 35000 / max($MissionDuration * $GameSpeed - 10, 1) * sqrt($MissionDistance * 10 / $ShipSpeed);
			$basicConsumption   = $ShipConsumption * $Count;
			$consumption        += $basicConsumption * $MissionDistance / 35000 * (($spd / 10) + 1) * (($spd / 10) + 1);
		}
		return (round($consumption) + 1);
	}

	public static function GetFleetMissions($USER, $MisInfo, $Planet)
	{
		global $resource;
		$Missions	= self::GetAvailableMissions($USER, $MisInfo, $Planet);
		$stayBlock	= array();

		$haltSpeed	= Config::get($USER['universe'])->halt_speed;

		if (in_array(15, $Missions)) {
			for($i = 1;$i <= $USER[$resource[124]];$i++)
			{
				$stayBlock[$i]	= round($i / $haltSpeed, 2);
			}
		}
		elseif(in_array(11, $Missions)) 
		{
			$stayBlock = array(1 => 1);
		}
		elseif(in_array(5, $Missions)) 
		{
			$stayBlock = array(1 => 1, 2 => 2, 4 => 4, 8 => 8, 12 => 12, 16 => 16, 32 => 32);
		}
		
		return array('MissionSelector' => $Missions, 'StayBlock' => $stayBlock);
	}

	/*
	 *
	 * Unserialize an Fleetstring to an array
	 *
	 * @param string
	 *
	 * @return array
	 *
	 */

	public static function unserialize($fleetAmount)
	{
		$fleetTyps		= explode(';', $fleetAmount);

		$fleetAmount	= array();

		foreach ($fleetTyps as $fleetTyp)
		{
			$temp = explode(',', $fleetTyp);

			if (empty($temp[0])) continue;

			if (!isset($fleetAmount[$temp[0]]))
			{
				$fleetAmount[$temp[0]] = 0;
			}

			$fleetAmount[$temp[0]] += $temp[1];
		}

		return $fleetAmount;
	}

	public static function GetACSDuration($acsId)
	{
		if(empty($acsId))
		{
			return 0;
		}

		$sql			= 'SELECT ankunft FROM %%AKS%% WHERE id = :acsId;';
		$acsEndTime 	= Database::get()->selectSingle($sql, array(
			':acsId'	=> $acsId
		), 'ankunft');
		
		return empty($acsEndTime) ? $acsEndTime - TIMESTAMP : 0;
	}
	
	public static function setACSTime($timeDifference, $acsId)
	{
		if(empty($acsId))
		{
			throw new InvalidArgumentException('Missing acsId on '.__CLASS__.'::'.__METHOD__);
		}

		$db		= Database::get();

		$sql	= 'UPDATE %%AKS%% SET ankunft = ankunft + :time WHERE id = :acsId;';
		$db->update($sql, array(
			':time'		=> $timeDifference,
			':acsId'	=> $acsId,
		));

		$sql	= 'UPDATE %%FLEETS%%, %%FLEETS_EVENT%% SET
		fleet_start_time = fleet_start_time + :time,
		fleet_end_stay   = fleet_end_stay + :time,
		fleet_end_time   = fleet_end_time + :time,
		time             = time + :time
		WHERE fleet_group = :acsId AND fleet_id = fleetID;';

		$db->update($sql, array(
			':time'		=> $timeDifference,
			':acsId'	=> $acsId,
		));

        return true;
	}

	public static function GetCurrentFleets($userId, $fleetMission = 10, $thisMission = false)
	{
		if($thisMission)
		{
			$sql = 'SELECT COUNT(*) as state
			FROM %%FLEETS%%
			WHERE fleet_owner = :userId
			AND fleet_mission = :fleetMission;';
		}
		else
		{
			$sql = 'SELECT COUNT(*) as state
			FROM %%FLEETS%%
			WHERE fleet_owner = :userId
			AND fleet_mission != :fleetMission;';
		}

		$ActualFleets = Database::get()->selectSingle($sql, array(
			':userId'		=> $userId,
			':fleetMission'	=> $fleetMission,
		));
		return $ActualFleets['state'];
	}	
	
	public static function SendFleetBack($USER, $FleetID)
	{
		$db				= Database::get();

		$sql			= 'SELECT start_time, fleet_start_time, fleet_mission, fleet_group, fleet_owner, fleet_mess FROM %%FLEETS%% WHERE fleet_id = :fleetId;';
		$fleetResult	= $db->selectSingle($sql, array(
			':fleetId'	=> $FleetID,
		));

		if ($fleetResult['fleet_owner'] != $USER['id'] || $fleetResult['fleet_mess'] == 1)
		{
			return false;
		}

		$sqlWhere	= 'fleet_id';

		if($fleetResult['fleet_mission'] == 1 && $fleetResult['fleet_group'] != 0)
		{
			$sql		= 'SELECT COUNT(*) as state FROM %%USERS_ACS%% WHERE acsID = :acsId;';
			$isInGroup	= $db->selectSingle($sql, array(
				':acsId'	=> $fleetResult['fleet_group'],
			), 'state');

			if($isInGroup)
			{
				$sql = 'DELETE %%AKS%%, %%USERS_ACS%%
				FROM %%AKS%%
				LEFT JOIN %%USERS_ACS%% ON acsID = %%AKS%%.id
				WHERE %%AKS%%.id = :acsId;';

				$db->delete($sql, array(
					':acsId'	=> $fleetResult['fleet_group']
			  	));
				
				$FleetID	= $fleetResult['fleet_group'];
				$sqlWhere	= 'fleet_group';
			}
		}
		
		if($fleetResult['fleet_mission'] == 5 && $fleetResult['fleet_mess'] == FLEET_HOLD){
			$fleetEndTime	= ($fleetResult['fleet_start_time'] - $fleetResult['start_time']) + TIMESTAMP;
		}else{
			$fleetEndTime	= (TIMESTAMP - $fleetResult['start_time']) + TIMESTAMP;
		}
		
		$sql	= 'UPDATE %%FLEETS%%, %%FLEETS_EVENT%% SET
		fleet_group			= :fleetGroup,
		fleet_end_stay		= :endStayTime,
		fleet_end_time		= :endTime,
		fleet_mess			= :fleetState,
		hasCanceled			= :hasCanceled,
		time				= :endTime
		WHERE '.$sqlWhere.' = :id AND fleet_id = fleetID;';

		$db->update($sql, array(
			':id'			=> $FleetID,
			':endStayTime'	=> TIMESTAMP,
			':endTime'		=> $fleetEndTime,
			':fleetGroup'	=> 0,
			':hasCanceled'	=> 1,
			':fleetState'	=> FLEET_RETURN
		));

		$sql	= 'UPDATE %%LOG_FLEETS%% SET
		fleet_end_stay	= :endStayTime,
		fleet_end_time	= :endTime,
		fleet_mess		= :fleetState,
		fleet_state		= 2
		WHERE '.$sqlWhere.' = :id;';

		$db->update($sql, array(
			':id'			=> $FleetID,
			':endStayTime'	=> TIMESTAMP,
			':endTime'		=> $fleetEndTime,
			':fleetState'	=> FLEET_RETURN
		));

		return true;
	}
	
	public static function GetFleetShipInfo($FleetArray, $Player)
	{
		$FleetInfo	= array();
		foreach ($FleetArray as $ShipID => $Amount) {
			$FleetInfo[$ShipID]	= array('consumption' => self::GetShipConsumption($ShipID, $Player), 'speed' => self::GetFleetMaxSpeed($ShipID, $Player), 'amount' => floatToString($Amount));
		}
		return $FleetInfo;
	}
	
	public static function GotoFleetPage($Code = 0)
	{	
global $LNG;
		echo(Config::get()->debug);
		if(Config::get()->debug == 0)
		{
			$temp = debug_backtrace();
			HTTP::redirectTo('game.php?page=fleetTable&code='.$Code);
			//echo str_replace($_SERVER["DOCUMENT_ROOT"],'.',$temp[0]['file'])." on ".$temp[0]['line']. " | Code: ".$Code." | Error: ".(isset($LNG['fl_send_error'][$Code]) ? $LNG['fl_send_error'][$Code] : '');
			//exit;
		}
		
		echo($Code);
		//HTTP::redirectTo('game.php?page=fleetTable&code='.$Code);
	}
	
public static function GetAvailableMissions($USER, $MissionInfo, $GetInfoPlanet)

	{	

		$db = Database::get();

		$id	= HTTP::_GP('id', 0);

        $sql = "SELECT ally_id FROM %%USERS%% WHERE id = :id;";
        $UserAllianceId = $db->selectSingle($sql, array(
            ':id'	=> $id
        ), 'ally_id');

		$YourPlanet				= (!empty($GetInfoPlanet['id_owner']) && $GetInfoPlanet['id_owner'] == $USER['id']) ? true : false;
		$UsedPlanet				= (!empty($GetInfoPlanet['id_owner'])) ? true : false;
		$availableMissions		= array();
		
		if ((!$UsedPlanet || $YourPlanet) && isModuleAvailable(MODULE_MISSION_SAVE)) {
			$availableMissions[]	= 19;
		}
		if ($MissionInfo['planet'] == (Config::get($USER['universe'])->max_planets + 1) && isModuleAvailable(MODULE_MISSION_EXPEDITION) && !isset($MissionInfo['Ship'][210]))
			$availableMissions[]	= 15;	
		elseif ($MissionInfo['planettype'] == 2) {
			if ((isset($MissionInfo['Ship'][209]) || isset($MissionInfo['Ship'][219])) && isModuleAvailable(MODULE_MISSION_RECYCLE) && !($GetInfoPlanet['der_metal'] == 0 && $GetInfoPlanet['der_crystal'] == 0) && $GetInfoPlanet['gal6mod'] == 0)
				$availableMissions[]	= 8;
		} else {
			if (!$UsedPlanet) {
				if (isset($MissionInfo['Ship'][208]) && $MissionInfo['planettype'] == 1 && isModuleAvailable(MODULE_MISSION_COLONY))
					$availableMissions[]	= 7;
				if((isset($MissionInfo['Ship'][209]) || isset($MissionInfo['Ship'][219])) && $MissionInfo['planettype'] == 1 && $GetInfoPlanet['gal6mod'] == 1)
					$availableMissions[]	= 16;
			} else {
				//if(isModuleAvailable(MODULE_MISSION_TRANSPORT))
//				if(isModuleAvailable(MODULE_MISSION_TRANSPORT) && $YourPlanet  && !isset($MissionInfo['Ship'][210]))
				if(isModuleAvailable(MODULE_MISSION_TRANSPORT)  && !isset($MissionInfo['Ship'][210]))
					$availableMissions[]	= 3;
					
				if (!$YourPlanet && self::OnlyShipByID($MissionInfo['Ship'], 210) && isModuleAvailable(MODULE_MISSION_SPY))
					$availableMissions[]	= 6;

				if (!$YourPlanet) {
					if(isModuleAvailable(MODULE_MISSION_ATTACK) && $GetInfoPlanet['id_owner'] != NO_ATACK && $USER['id'] != NO_ATACK)
						$availableMissions[]	= 1;
//					if(isModuleAvailable(MODULE_MISSION_HOLD) && $YourPlanet)
					if(isModuleAvailable(MODULE_MISSION_HOLD))
						$availableMissions[]	= 5;}
						
				elseif(isModuleAvailable(MODULE_MISSION_STATION)) {
					$availableMissions[]	= 4;}
					
				if (!empty($MissionInfo['IsAKS']) && !$YourPlanet && isModuleAvailable(MODULE_MISSION_ATTACK) && isModuleAvailable(MODULE_MISSION_ACS))
					$availableMissions[]	= 2;

				if (!$YourPlanet && $MissionInfo['planettype'] == 3 && isset($MissionInfo['Ship'][214]) && isModuleAvailable(MODULE_MISSION_DESTROY))
					$availableMissions[]	= 9;

				if ($YourPlanet && $MissionInfo['planettype'] == 3 && self::OnlyShipByID($MissionInfo['Ship'], 220) && isModuleAvailable(MODULE_MISSION_DARKMATTER))
					$availableMissions[]	= 11;
			}
		}
		
		return $availableMissions;
	}
	
	public static function CheckBash($Target)
	{
		global $USER;

		if(!BASH_ON)
		{
			return false;
		}

		$sql	= 'SELECT COUNT(*) as state
		FROM %%LOG_FLEETS%%
		WHERE fleet_owner = :fleetOwner
		AND fleet_end_id = :fleetEndId
		AND fleet_state != :fleetState
		AND fleet_start_time > :fleetStartTime
		AND fleet_mission IN (1,2,9);';

		$Count	= Database::get()->selectSingle($sql, array(
			':fleetOwner'		=> $USER['id'],
			':fleetEndId'		=> $Target,
			':fleetState'		=> 2,
			':fleetStartTime'	=> (TIMESTAMP - BASH_TIME),
		));

		//fix by hirako no bash on war pact
        $db = Database::get();
        $sql3    = 'SELECT id_owner FROM %%PLANETS%% WHERE id = :fleetEndId;';
        $id_target = $db->selectSingle($sql3, array(
            ':fleetEndId'        => $Target,
        ));
        
        $sql1 = "SELECT ally_id FROM %%USERS%% where id = :user_id;";
        $owner_ally = $db->selectSingle($sql1, array(
                ':user_id'     =>$USER['id'],
            ));
        $sql2 = "SELECT ally_id FROM %%USERS%% where id = :user_id;";
        $target_ally = $db->selectSingle($sql2, array(
                ':user_id'     =>$id_target['id_owner'],
            ));
        
        $sql4 = "SELECT Count(*) as war FROM %%DIPLO%% WHERE level =5 AND accept = 1 AND ((:owner = owner_1 AND :target = owner_2 ) OR (:owner = owner_2 AND :target = owner_1 ));";
            
            $war_pact    = $db->selectSingle($sql4, array(
            ':owner'        => $owner_ally['ally_id'],
            ':target'        => $target_ally['ally_id'],
            ));
        
        if($war_pact['war']>0)return false;
        //end fix

		return $Count['state'] >= BASH_COUNT;
	}

	public static function unlock($FleetID)
	{
		$db = Database::get();

		$sql = "UPDATE %%FLEETS%% SET fleet_busy = 0 WHERE fleet_id = :fleet_id AND fleet_universe = :fleet_universe;";
		$db->update($sql, array(
			':fleet_id'			=> $FleetID,
			':fleet_universe'	=> Universe::current()
		));

		$sql = "UPDATE %%FLEETS_EVENT%% SET `lock` = NULL WHERE `fleetID` = :fleetID;";

		$db->update($sql, array(
			':fleetID'	=> $FleetID,
		));

		return true;
	}


	public static function sendFleet($fleetArray, $fleetMission, $fleetStartOwner, $fleetStartPlanetID,
		$fleetStartPlanetGalaxy, $fleetStartPlanetSystem, $fleetStartPlanetPlanet, $fleetStartPlanetType,
		$fleetTargetOwner, $fleetTargetPlanetID, $fleetTargetPlanetGalaxy, $fleetTargetPlanetSystem,
		$fleetTargetPlanetPlanet, $fleetTargetPlanetType, $fleetResource, $fleetStartTime, $fleetStayTime,
		$fleetEndTime, $fleetGroup = 0, $missileTarget = 0, $consumption = 0)
	{
		global $resource;
		$fleetShipCount	= array_sum($fleetArray);
		$fleetData		= array();

		$db				= Database::get();

		$params			= array(':planetId'	=> $fleetStartPlanetID);

		$planetQuery	= array();
		
		if($consumption > 0){
			$planetQuery[] = $resource[903]." = ".$resource[903]." - :".$resource[903];
			$params[':'.$resource[903]]	= $consumption;
		}

		foreach($fleetArray as $ShipID => $ShipCount) {
			$fleetData[]	= $ShipID.','.floatToString($ShipCount);
			$planetQuery[]	= $resource[$ShipID]." = ".$resource[$ShipID]." - :".$resource[$ShipID];

			$params[':'.$resource[$ShipID]]	= floatToString($ShipCount);
		}

		$sql	= 'UPDATE %%PLANETS%% SET '.implode(', ', $planetQuery).' WHERE id = :planetId;';

		$db->update($sql, $params);

		$sql	= 'INSERT INTO %%FLEETS%% SET
		fleet_owner					= :fleetStartOwner,
		fleet_target_owner			= :fleetTargetOwner,
		fleet_mission				= :fleetMission,
		fleet_amount				= :fleetShipCount,
		fleet_array					= :fleetData,
		fleet_universe				= :universe,
		fleet_start_time			= :fleetStartTime,
		fleet_end_stay				= :fleetStayTime,
		fleet_end_time				= :fleetEndTime,
		fleet_start_id				= :fleetStartPlanetID,
		fleet_start_galaxy			= :fleetStartPlanetGalaxy,
		fleet_start_system			= :fleetStartPlanetSystem,
		fleet_start_planet			= :fleetStartPlanetPlanet,
		fleet_start_type			= :fleetStartPlanetType,
		fleet_end_id				= :fleetTargetPlanetID,
		fleet_end_galaxy			= :fleetTargetPlanetGalaxy,
		fleet_end_system			= :fleetTargetPlanetSystem,
		fleet_end_planet			= :fleetTargetPlanetPlanet,
		fleet_end_type				= :fleetTargetPlanetType,
		fleet_resource_metal		= :fleetResource901,
		fleet_resource_crystal		= :fleetResource902,
		fleet_resource_deuterium	= :fleetResource903,
		fleet_group					= :fleetGroup,
		fleet_target_obj			= :missileTarget,
		start_time					= :timestamp;';

		$db->insert($sql, array(
			':fleetStartOwner'			=> $fleetStartOwner,
			':fleetTargetOwner'			=> $fleetTargetOwner,
			':fleetMission'				=> $fleetMission,
			':fleetShipCount'			=> $fleetShipCount,
			':fleetData'				=> implode(';', $fleetData),
			':fleetStartTime'			=> $fleetStartTime,
			':fleetStayTime'			=> $fleetStayTime,
			':fleetEndTime'				=> $fleetEndTime,
			':fleetStartPlanetID'		=> $fleetStartPlanetID,
			':fleetStartPlanetGalaxy'	=> $fleetStartPlanetGalaxy,
			':fleetStartPlanetSystem'	=> $fleetStartPlanetSystem,
			':fleetStartPlanetPlanet'	=> $fleetStartPlanetPlanet,
			':fleetStartPlanetType'		=> $fleetStartPlanetType,
			':fleetTargetPlanetID'		=> $fleetTargetPlanetID,
			':fleetTargetPlanetGalaxy'	=> $fleetTargetPlanetGalaxy,
			':fleetTargetPlanetSystem'	=> $fleetTargetPlanetSystem,
			':fleetTargetPlanetPlanet'	=> $fleetTargetPlanetPlanet,
			':fleetTargetPlanetType'	=> $fleetTargetPlanetType,
			':fleetResource901'			=> $fleetResource[901],
			':fleetResource902'			=> $fleetResource[902],
			':fleetResource903'			=> $fleetResource[903],
			':fleetGroup'				=> $fleetGroup,
			':missileTarget'			=> $missileTarget,
			':timestamp'				=> TIMESTAMP,
			':universe'	   				=> Universe::current(),
		));

		$fleetId	= $db->lastInsertId();

		$sql	= 'INSERT INTO %%FLEETS_EVENT%% SET fleetID	= :fleetId, `time` = :endTime;';
		$db->insert($sql, array(
			':fleetId'	=> $fleetId,
			':endTime'	=> $fleetStartTime
		));

		$sql	= 'INSERT INTO %%LOG_FLEETS%% SET
		fleet_id					= :fleetId,
		fleet_owner					= :fleetStartOwner,
		fleet_target_owner			= :fleetTargetOwner,
		fleet_mission				= :fleetMission,
		fleet_amount				= :fleetShipCount,
		fleet_array					= :fleetData,
		fleet_universe				= :universe,
		fleet_start_time			= :fleetStartTime,
		fleet_end_stay				= :fleetStayTime,
		fleet_end_time				= :fleetEndTime,
		fleet_start_id				= :fleetStartPlanetID,
		fleet_start_galaxy			= :fleetStartPlanetGalaxy,
		fleet_start_system			= :fleetStartPlanetSystem,
		fleet_start_planet			= :fleetStartPlanetPlanet,
		fleet_start_type			= :fleetStartPlanetType,
		fleet_end_id				= :fleetTargetPlanetID,
		fleet_end_galaxy			= :fleetTargetPlanetGalaxy,
		fleet_end_system			= :fleetTargetPlanetSystem,
		fleet_end_planet			= :fleetTargetPlanetPlanet,
		fleet_end_type				= :fleetTargetPlanetType,
		fleet_resource_metal		= :fleetResource901,
		fleet_resource_crystal		= :fleetResource902,
		fleet_resource_deuterium	= :fleetResource903,
		fleet_group					= :fleetGroup,
		fleet_target_obj			= :missileTarget,
		start_time					= :timestamp;';

		$db->insert($sql, array(
			':fleetId'					=> $fleetId,
			':fleetStartOwner'			=> $fleetStartOwner,
			':fleetTargetOwner'			=> $fleetTargetOwner,
			':fleetMission'				=> $fleetMission,
			':fleetShipCount'			=> $fleetShipCount,
			':fleetData'				=> implode(';', $fleetData),
			':fleetStartTime'			=> $fleetStartTime,
			':fleetStayTime'			=> $fleetStayTime,
			':fleetEndTime'				=> $fleetEndTime,
			':fleetStartPlanetID'		=> $fleetStartPlanetID,
			':fleetStartPlanetGalaxy'	=> $fleetStartPlanetGalaxy,
			':fleetStartPlanetSystem'	=> $fleetStartPlanetSystem,
			':fleetStartPlanetPlanet'	=> $fleetStartPlanetPlanet,
			':fleetStartPlanetType'		=> $fleetStartPlanetType,
			':fleetTargetPlanetID'		=> $fleetTargetPlanetID,
			':fleetTargetPlanetGalaxy'	=> $fleetTargetPlanetGalaxy,
			':fleetTargetPlanetSystem'	=> $fleetTargetPlanetSystem,
			':fleetTargetPlanetPlanet'	=> $fleetTargetPlanetPlanet,
			':fleetTargetPlanetType'	=> $fleetTargetPlanetType,
			':fleetResource901'			=> $fleetResource[901],
			':fleetResource902'			=> $fleetResource[902],
			':fleetResource903'			=> $fleetResource[903],
			':fleetGroup'				=> $fleetGroup,
			':missileTarget'			=> $missileTarget,
			':timestamp'				=> TIMESTAMP,
			':universe'	   				=> Universe::current(),
		));
	}


}
