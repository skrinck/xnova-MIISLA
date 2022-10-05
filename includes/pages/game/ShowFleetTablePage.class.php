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


class ShowFleetTablePage extends AbstractGamePage
{
	public static $requireModule = MODULE_FLEET_TABLE;

	function __construct() 
	{
		parent::__construct();
	}
	
	public function createACS($fleetID, $fleetData) {
		global $USER;
		
		$rand 			= mt_rand(100000, 999999999);
		$acsName	 	= 'AG'.$rand;
		$acsCreator		= $USER['id'];

        $db = Database::get();
        $sql = "INSERT INTO %%AKS%% SET name = :acsName, ankunft = :time, target = :target;";
        $db->insert($sql, array(
            ':acsName'	=> $acsName,
            ':time'		=> $fleetData['fleet_start_time'],
			':target'	=> $fleetData['fleet_end_id']
        ));

        $acsID	= $db->lastInsertId();

        $sql = "INSERT INTO %%USERS_ACS%% SET acsID = :acsID, userID = :userID;";
        $db->insert($sql, array(
            ':acsID'	=> $acsID,
            ':userID'	=> $acsCreator
        ));

        $sql = "UPDATE %%FLEETS%% SET fleet_group = :acsID WHERE fleet_id = :fleetID;";
        $db->update($sql, array(
            ':acsID'	=> $acsID,
            ':fleetID'	=> $fleetID
        ));

		return array(
			'name' 			=> $acsName,
			'id' 			=> $acsID,
		);
	}
	
	public function loadACS($fleetData) {
		global $USER;
		
		$db = Database::get();
        $sql = "SELECT id, name FROM %%USERS_ACS%% INNER JOIN %%AKS%% ON acsID = id WHERE userID = :userID AND acsID = :acsID;";
        $acsResult = $db->selectSingle($sql, array(
            ':userID'   => $USER['id'],
            ':acsID'    => $fleetData['fleet_group']
        ));

		return $acsResult;
	}
	
	public function getACSPageData($fleetID)
	{
		global $USER, $LNG;
		
		$db = Database::get();

        $sql = "SELECT fleet_start_time, fleet_end_id, fleet_group, fleet_mess FROM %%FLEETS%% WHERE fleet_id = :fleetID;";
        $fleetData = $db->selectSingle($sql, array(
            ':fleetID'  => $fleetID
        ));

        if ($db->rowCount() != 1)
			return array();

		if ($fleetData['fleet_mess'] == 1 || $fleetData['fleet_start_time'] <= TIMESTAMP)
			return array();
				
		if ($fleetData['fleet_group'] == 0)
			$acsData	= $this->createACS($fleetID, $fleetData);
		else
			$acsData	= $this->loadACS($fleetData);
	
		if (empty($acsData))
			return array();
			
		$acsName	= HTTP::_GP('acsName', '', UTF8_SUPPORT);
		if(!empty($acsName)) {
			if(!PlayerUtil::isNameValid($acsName))
			{
				$this->sendJSON($LNG['fl_acs_newname_alphanum']);
			}
			
			$sql = "UPDATE %%AKS%% SET name = :acsName WHERE id = :acsID;";
            $db->update($sql, array(
                ':acsName'  => $acsName,
                ':acsID'    => $acsData['id']
            ));
            $this->sendJSON(false);
		}
		
		$invitedUsers	= array();

        $sql = "SELECT id, username FROM %%USERS_ACS%% INNER JOIN %%USERS%% ON userID = id WHERE acsID = :acsID;";
        $userResult = $db->select($sql, array(
            ':acsID'    => $acsData['id']
        ));

        foreach($userResult as $userRow)
		{
			$invitedUsers[$userRow['id']]	= $userRow['username'];
		}

		$newUser		= HTTP::_GP('username', '', UTF8_SUPPORT);
		$statusMessage	= "";
		if(!empty($newUser))
		{
			$sql = "SELECT id FROM %%USERS%% WHERE universe = :universe AND username = :username;";
            $newUserID = $db->selectSingle($sql, array(
                ':universe' => Universe::current(),
                ':username' => $newUser
            ), 'id');

            if(empty($newUserID)) {
				$statusMessage			= $LNG['fl_player']." ".$newUser." ".$LNG['fl_dont_exist'];
			} elseif(isset($invitedUsers[$newUserID])) {
				$statusMessage			= $LNG['fl_player']." ".$newUser." ".$LNG['fl_already_invited'];
			} else {
				$statusMessage			= $LNG['fl_player']." ".$newUser." ".$LNG['fl_add_to_attack'];
				
				$sql = "INSERT INTO %%USERS_ACS%% SET acsID = :acsID, userID = :newUserID;";
                $db->insert($sql, array(
                    ':acsID'        => $acsData['id'],
                    ':newUserID'    => $newUserID
                ));

                $invitedUsers[$newUserID]	= $newUser;
				
				$inviteTitle			= $LNG['fl_acs_invitation_title'];
				$inviteMessage 			= $LNG['fl_player'] . $USER['username'] . $LNG['fl_acs_invitation_message'];
				PlayerUtil::sendMessage($newUserID, $USER['id'], $USER['username'], 1, $inviteTitle, $inviteMessage, TIMESTAMP);
			}
		}
		
		return array(
			'invitedUsers'	=> $invitedUsers,
			'acsName'		=> $acsData['name'],
			'mainFleetID'	=> $fleetID,
			'statusMessage'	=> $statusMessage,
		);
	}
	
	public function show()
	{
		global $USER, $PLANET, $reslist, $resource, $LNG, $pricelist;
		
		$acsData			= array();

		$userGroupShip			= array();
		$FleetID			= HTTP::_GP('fleetID', 0);
		$GetAction			= HTTP::_GP('action', "");

		/*$token = HTTP::_GP('secret', '');


		if ($token != Flash::getToken()) {
			HTTP::redirectTo('index.php?code=4');
		}*/

        $db = Database::get();

		$this->tplObj->loadscript('flotten.js');
		
		if(!empty($FleetID) && !IsVacationMode($USER))
		{
			switch($GetAction){
				case "sendfleetback":
					FleetFunctions::SendFleetBack($USER, $FleetID);
				break;
				case "acs":
					$acsData	= $this->getACSPageData($FleetID);
				break;
				case "unlock":
					FleetFunctions::unlock($FleetID);
				break;
			}
		}
		
		//$techExpedition      = FleetFunctions::getExpeditionLimit($USER);
		$techExpedition      = $USER[$resource[124]];

		if ($techExpedition >= 1)
		{
			$activeExpedition   = FleetFunctions::GetCurrentFleets($USER['id'], 15, true);
			$maxExpedition 		= floor(sqrt($techExpedition));
		}
		else
		{
			$activeExpedition 	= 0;
			$maxExpedition 		= 0;
		}

		$maxFleetSlots	= FleetFunctions::GetMaxFleetSlots($USER);

		$targetGalaxy	= HTTP::_GP('galaxy', (int) $PLANET['galaxy']);
		$targetSystem	= HTTP::_GP('system', (int) $PLANET['system']);
		$targetPlanet	= HTTP::_GP('planet', (int) $PLANET['planet']);
		$targetType		= HTTP::_GP('planettype', (int) $PLANET['planet_type']);
		$targetMission	= HTTP::_GP('target_mission', 0);

	$sql = "SELECT f.*, e.* FROM %%FLEETS%% as f LEFT JOIN %%FLEETS_EVENT%% as e ON f.fleet_id = e.fleetID WHERE fleet_owner = :userID AND fleet_mission <> 10 ORDER BY fleet_end_time ASC;";
        $fleetResult = $db->select($sql, array(
            ':userID'   => $USER['id']
        ));

        $activeFleetSlots	= $db->rowCount();

		$FlyingFleetList	= array();
		
		foreach ($fleetResult as $fleetsRow)
		{
			$FleetList[$fleetsRow['fleet_id']] = FleetFunctions::unserialize($fleetsRow['fleet_array']);
			
			if($fleetsRow['fleet_mission'] == 4 && $fleetsRow['fleet_mess'] == FLEET_OUTWARD)
			{
				$returnTime	= $fleetsRow['fleet_start_time'];
			}
			else
			{
				$returnTime	= $fleetsRow['fleet_end_time'];
			}
			
			$FlyingFleetList[]	= array(
				'id'			=> $fleetsRow['fleet_id'],
				'mission'		=> $fleetsRow['fleet_mission'],
				'state'			=> $fleetsRow['fleet_mess'],
				'startGalaxy'	=> $fleetsRow['fleet_start_galaxy'],
				'startSystem'	=> $fleetsRow['fleet_start_system'],
				'startPlanet'	=> $fleetsRow['fleet_start_planet'],
				'startTime'		=> _date($LNG['php_tdformat'], $fleetsRow['fleet_start_time'], $USER['timezone']),
				'endGalaxy'		=> $fleetsRow['fleet_end_galaxy'],
				'endSystem'		=> $fleetsRow['fleet_end_system'],
				'endPlanet'		=> $fleetsRow['fleet_end_planet'],
				'endTime'		=> _date($LNG['php_tdformat'], $fleetsRow['fleet_end_time'], $USER['timezone']),
				'amount'		=> pretty_number($fleetsRow['fleet_amount']),
				'returntime'	=> $returnTime,
				'resttime'		=> $returnTime - TIMESTAMP,
				'FleetList'		=> $FleetList[$fleetsRow['fleet_id']],
				'lock'			=> $fleetsRow['lock'],
			);
		}
		
		$FleetsOnPlanet	= array();
		$FleetsOnPlanetBattle	= array();
		$elementPlanetBattle	= array(204,205,206,207,215,213,211,214,216,218);
		$FleetsOnPlanetTransport	= array();
		$elementPlanetTransport	= array(202,203,217);
		$FleetsOnPlanetProcessorcs	= array();
		$elementPlanetProcessorcs	= array(209,219);
		$FleetsOnPlanetSpecial	= array();
		$elementPlanetSpecial	= array(208,210,220);
		
		foreach($reslist['fleet'] as $FleetID)
		{
			if ($PLANET[$resource[$FleetID]] == 0)
				continue;
				
			$FleetsOnPlanet[]	= array(
				'id'	=> $FleetID,
				'speed'	=> FleetFunctions::GetFleetMaxSpeed($FleetID, $USER),
				'count'	=> $PLANET[$resource[$FleetID]],
			);
		}

		foreach($elementPlanetBattle as $FleetID)
		{
			if ($PLANET[$resource[$FleetID]] == 0)
				continue;
				
			$FleetsOnPlanetBattle[]	= array(
				'id'	=> $FleetID,
				'speed'	=> FleetFunctions::GetFleetMaxSpeed($FleetID, $USER),
				'count'	=> $PLANET[$resource[$FleetID]],
			);
		}
		
		foreach($elementPlanetTransport as $FleetID)
		{
			if ($PLANET[$resource[$FleetID]] == 0)
				continue;
				
			$FleetsOnPlanetTransport[]	= array(
				'id'	=> $FleetID,
				'speed'	=> FleetFunctions::GetFleetMaxSpeed($FleetID, $USER),
				'count'	=> $PLANET[$resource[$FleetID]],
			);
		}
		
		foreach($elementPlanetProcessorcs as $FleetID)
		{
			if ($PLANET[$resource[$FleetID]] == 0)
				continue;
				
			$FleetsOnPlanetProcessorcs[]	= array(
				'id'	=> $FleetID,
				'speed'	=> FleetFunctions::GetFleetMaxSpeed($FleetID, $USER),
				'count'	=> $PLANET[$resource[$FleetID]],
			);
		}
		
		foreach($elementPlanetSpecial as $FleetID)
		{
			if ($PLANET[$resource[$FleetID]] == 0)
				continue;
				
			$FleetsOnPlanetSpecial[]	= array(
				'id'	=> $FleetID,
				'speed'	=> FleetFunctions::GetFleetMaxSpeed($FleetID, $USER),
				'count'	=> $PLANET[$resource[$FleetID]],
			);
		}

		$sql	= 'SELECT * FROM %%FLEETS_GROUP%% WHERE ownerId = :userId;';
		$userGroupShips = $db->select($sql, array(
			':userId'	=> $USER['id']
		));
		
		$groupStartId = 0;
		foreach($userGroupShips as $userShip){
			
		$shipInfo[$userShip['groupId']] = FleetFunctions::unserialize($userShip['fleetData']);
		
		$userGroupShip[]	= array(
				'FleetList'		=> $shipInfo[$userShip['groupId']],
				'groupName'		=> $userShip['groupName'],
				'groupId'		=> $groupStartId,
				'groupIdDel'		=> $userShip['groupId'],
			);
		$groupStartId++;
		}
		
		$showproce = 0;
		if($targetMission == 15 || $targetMission == 1 || $targetMission == 18){
		$showproce = 1;	
		}
		
		$showattack = 0;
		if($targetMission == 11){
		$showattack = 1;	
		}
		
		$showtrans = 0;
		if($targetMission == 11){
		$showtrans = 1;	
		}
		
		$showrecyc = 0;
		if($targetMission == 11){
		$showrecyc = 1;	
		}

		$gouvernor_attack = 0;
		if($USER['dm_attack'] > TIMESTAMP){
		$gouvernor_attack = GubPriceAPSTRACT(701, $USER['dm_attack_level'], 'dm_attack');
		}
			
		$gouvernor_shield = 0;
		if($USER['dm_defensive'] > TIMESTAMP){
		$gouvernor_shield = GubPriceAPSTRACT(702, $USER['dm_defensive_level'], 'dm_defensive');
		}


		$activeAsteroids	= FleetFunctions::GetCurrentFleets($USER['id'], 16, true);
		$asteroid =	Config::get($USER['universe'])->max_asteroid;
		$maxAsteroids		= FleetFunctions::getAsteroidLimit($USER);

		$activeMOFound	= FleetFunctions::GetCurrentFleets($USER['id'], 11, true);
		$MOFound =	Config::get($USER['universe'])->max_dm_missions;
		$maxMOFound		= floor(Config::get($USER['universe'])->max_dm_missions + floor($USER[$resource[124]] / 2));

		$sql	= 'SELECT * FROM %%FLEETS_GROUP%% WHERE ownerId = :userId;';
		$userGroupShips = $db->select($sql, array(
			':userId'	=> $USER['id']
		));
		
		$groupStartId = 0;
		foreach($userGroupShips as $userShip){
			
		$shipInfo[$userShip['groupId']] = FleetFunctions::unserialize($userShip['fleetData']);
		
		$userGroupShip[]	= array(
				'FleetList'		=> $shipInfo[$userShip['groupId']],
				'groupName'		=> $userShip['groupName'],
				'groupId'		=> $groupStartId,
				'groupIdDel'		=> $userShip['groupId'],
			);
		$groupStartId++;
		}
		
		
		$this->assign(array(
			'FleetsOnPlanet'		=> $FleetsOnPlanet,
			'userGroupShip'					=> $userGroupShip,
			'showproce'						=> $showproce,
			'showrecyc'						=> $showrecyc,
			'showtrans'						=> $showtrans, 
			'showattack'					=> $showattack,
			'FleetsOnPlanetBattle'			=> $FleetsOnPlanetBattle,
			'FleetsOnPlanetTransport'		=> $FleetsOnPlanetTransport,
			'FleetsOnPlanetProcessorcs'		=> $FleetsOnPlanetProcessorcs,
			'FleetsOnPlanetSpecial'			=> $FleetsOnPlanetSpecial,
			'FlyingFleetList'		=> $FlyingFleetList,
			'activeExpedition'		=> $activeExpedition,
			'maxExpedition'			=> $maxExpedition,
			'activeMOFound'			=> $activeMOFound,
			'maxMOFound'			=> $maxMOFound,
			'activeAsteroids'		=> $activeAsteroids,
			'maxAsteroids'			=> $maxAsteroids,
			'Asteroid'				=> $asteroid,
			'moduleAsteroide'		=> ($USER['asteroid_mine_tech']/5),
			'moduleMOFound'			=> ($USER[$resource[124]]/2),
			'MOFound'				=> $MOFound,
			'activeFleetSlots'		=> $activeFleetSlots,
			'maxFleetSlots'			=> $maxFleetSlots,
			'targetGalaxy'			=> $targetGalaxy,
			'targetSystem'			=> $targetSystem,
			'targetPlanet'			=> $targetPlanet,
			'targetType'			=> $targetType,
			'targetMission'			=> $targetMission,
			'acsData'				=> $acsData,
			'userGroupShips'		=> count($userGroupShips),
			'userGroupShip'			=> $userGroupShip,
			'isVacation'			=> IsVacationMode($USER),
			//'bonusAttack'			=> $USER[$resource[109]] * 10 + $gouvernor_attack-10 + $USER['factor']['Attack'] * 100,
			//'bonusDefensive'		=> $USER[$resource[110]] * 10 + $gouvernor_shield-10 + $USER['factor']['Defensive'] * 100,
			//'bonusShield'			=> $USER[$resource[111]] * 10 + $gouvernor_shield-10 + $USER['factor']['Shield'] * 100,
			'bonusAttack'			=> $USER[$resource[109]] + $gouvernor_attack + $USER['rpg_amiral'],
			'bonusDefensive'		=> $USER[$resource[110]] + $gouvernor_shield + $USER['rpg_amiral'],
			'bonusShield'			=> $USER[$resource[111]] + $gouvernor_shield + $USER['rpg_amiral'],
			'bonusCombustion'		=> $USER[$resource[115]] * 10,
			'bonusImpulse'			=> $USER[$resource[117]] * 20,
			'bonusHyperspace'		=> $USER[$resource[118]] * 30,			
			'secret'				=>Flash::createToken(),
		));
		
		$this->display('page.fleetTable.default.tpl');
	}
}
