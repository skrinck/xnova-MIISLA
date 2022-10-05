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

class ShowOverviewPage extends AbstractGamePage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}
	
	private function GetTeamspeakData()
	{
		global $USER, $LNG;

		$config = Config::get();

		if ($config->ts_modon == 0)
		{
			return false;
		}
		
		Cache::get()->add('teamspeak', 'TeamspeakBuildCache');
		$tsInfo	= Cache::get()->getData('teamspeak', false);
		
		if(empty($tsInfo))
		{
			return array(
				'error'	=> $LNG['ov_teamspeak_not_online']
			);
		}

		$url = '';

		switch($config->ts_version)
		{
			case 2:
				$url = 'teamspeak://%s:%s?nickname=%s';
			break;
			case 3:
				$url = 'ts3server://%s?port=%d&amp;nickname=%s&amp;password=%s';
			break;
		}
		
		return array(
			'url'		=> sprintf($url, $config->ts_server, $config->ts_tcpport, $USER['username'], $tsInfo['password']),
			'current'	=> $tsInfo['current'],
			'max'		=> $tsInfo['maxuser'],
			'error'		=> false,
		);
	}

	private function GetFleets() {
		global $USER, $PLANET;
		require_once 'includes/classes/class.FlyingFleetsTable.php';
		$fleetTableObj = new FlyingFleetsTable;
		$fleetTableObj->setUser($USER['id']);
		$fleetTableObj->setPlanet($PLANET['id']);
		return $fleetTableObj->renderTable();
	}
	
	function savePlanetAction()
	{
		global $USER, $PLANET, $LNG;
		$password =	HTTP::_GP('password', '', true);
		if (!empty($password))
		{
			$db = Database::get();
            $sql = "SELECT COUNT(*) as state FROM %%FLEETS%% WHERE
                      (fleet_owner = :userID AND (fleet_start_id = :planetID OR fleet_start_id = :lunaID)) OR
                      (fleet_target_owner = :userID AND (fleet_end_id = :planetID OR fleet_end_id = :lunaID));";
            $IfFleets = $db->selectSingle($sql, array(
                ':userID'   => $USER['id'],
                ':planetID' => $PLANET['id'],
                ':lunaID'   => $PLANET['id_luna']
            ), 'state');

            if ($IfFleets > 0)
				exit(json_encode(array('message' => $LNG['ov_abandon_planet_not_possible'])));
			elseif ($USER['id_planet'] == $PLANET['id'])
				exit(json_encode(array('message' => $LNG['ov_principal_planet_cant_abanone'])));
			elseif (PlayerUtil::cryptPassword($password) != $USER['password'])
				exit(json_encode(array('message' => $LNG['ov_wrong_pass'])));
			else
			{
				if($PLANET['planet_type'] == 1) {
					$sql = "UPDATE %%PLANETS%% SET destruyed = :time WHERE id = :planetID;";
                    $db->update($sql, array(
                        ':time'   => TIMESTAMP + 86400,
                        ':planetID' => $PLANET['id'],
                    ));
                    $sql = "DELETE FROM %%PLANETS%% WHERE id = :lunaID;";
                    $db->delete($sql, array(
                        ':lunaID' => $PLANET['id_luna']
                    ));
                } else {
                    $sql = "UPDATE %%PLANETS%% SET id_luna = 0 WHERE id_luna = :planetID;";
                    $db->update($sql, array(
                        ':planetID' => $PLANET['id'],
                    ));
                    $sql = "DELETE FROM %%PLANETS%% WHERE id = :planetID;";
                    $db->delete($sql, array(
                        ':planetID' => $PLANET['id'],
                    ));
                }
				
				$PLANET['id']	= $USER['id_planet'];
				exit(json_encode(array('ok' => true, 'message' => $LNG['ov_planet_abandoned'])));
			}
		}
	}
		
	function show()
	{
		global $LNG, $PLANET, $USER, $resource, $reslist;
		
		$AdminsOnline 	= array();
		$chatOnline 	= array();
		$AllPlanets		= array();
		$Moon 			= array();
		$RefLinks		= array();

        $db = Database::get();
		 //by rayco
		$allConstr = [];
		
		foreach($USER['PLANETS'] as $ID => $CPLANET)
		{		

			 //by rayco mostrar todas las contrucciones
			if ($CPLANET['b_building'] - TIMESTAMP > 0) {
				$Queue			= unserialize($CPLANET['b_building_id']);
				$allConstr[]	= array(
					'id'		=> $Queue[0][0],
					'level'		=> $Queue[0][1],
					'timeleft'	=> $CPLANET['b_building'] - TIMESTAMP,
					'time'		=> $CPLANET['b_building'],
					'starttime'	=> pretty_time($CPLANET['b_building'] - TIMESTAMP),
					'planet'=>$CPLANET
				);
			}
			 //by rayco mostrar todas las contrucciones
			if ($ID == $PLANET['id'] || $CPLANET['planet_type'] == 3)
				continue;

			if (!empty($CPLANET['b_building']) && $CPLANET['b_building'] > TIMESTAMP) {
				$Queue				= unserialize($CPLANET['b_building_id']);
				$BuildPlanet		= $LNG['tech'][$Queue[0][0]]." (".$Queue[0][1].")<br><span style=\"color:#7F7F7F;\">(".pretty_time($Queue[0][3] - TIMESTAMP).")</span>";
			} else {
				$BuildPlanet     = $LNG['ov_free'];
			}
			
			$AllPlanets[] = array(
				'id'	=> $CPLANET['id'],
				'name'	=> $CPLANET['name'],
				'image'	=> $CPLANET['image'],
				'build'	=> $BuildPlanet,
			);
		}
		
		if ($PLANET['id_luna'] != 0) {
			$sql = "SELECT id, name FROM %%PLANETS%% WHERE id = :lunaID;";
            $Moon = $db->selectSingle($sql, array(
                ':lunaID'   => $PLANET['id_luna']
            ));
        }
			
		if ($PLANET['b_building'] - TIMESTAMP > 0) {
			$Queue			= unserialize($PLANET['b_building_id']);
			$buildInfo['buildings']	= array(
				'id'		=> $Queue[0][0],
				'level'		=> $Queue[0][1],
				'timeleft'	=> $PLANET['b_building'] - TIMESTAMP,
				'time'		=> $PLANET['b_building'],
				'starttime'	=> pretty_time($PLANET['b_building'] - TIMESTAMP),
			);
		}
		else {
			$buildInfo['buildings']	= false;
		}

//by linkin seperar defensa de naves
		$Ship = array('hangar', 'defense');

		foreach ($Ship as $ShipQueue) {
			if (!empty($PLANET['b_'.$ShipQueue.'_id'])) {

				$Queue	= unserialize($PLANET['b_'.$ShipQueue.'_id']);
				$time	= BuildFunctions::getBuildingTime($USER, $PLANET, $Queue[0][0]) * $Queue[0][1];
					$buildInfo[$ShipQueue]	= array(
						'id'		=> $Queue[0][0],
						'level'		=> $Queue[0][1],
						'timeleft'	=> $time - $PLANET['b_'.$ShipQueue],
						'time'		=> $time,
						'starttime'	=> pretty_time($time - $PLANET['b_'.$ShipQueue]),
					);

				} else {
					$buildInfo[$ShipQueue]	= false;

				}
		}

		if (!empty($PLANET['b_hangar_id'])) {
			$Queue	= unserialize($PLANET['b_hangar_id']);
			$time	= BuildFunctions::getBuildingTime($USER, $PLANET, $Queue[0][0]) * $Queue[0][1];
			$buildInfo['fleet']	= array(
				'id'		=> $Queue[0][0],
				'level'		=> $Queue[0][1],
				'timeleft'	=> $time - $PLANET['b_hangar'],
				'time'		=> $time,
				'starttime'	=> pretty_time($time - $PLANET['b_hangar']),
			);
		}
		else {
			$buildInfo['fleet']	= false;
		}
		
		if ($USER['b_tech'] - TIMESTAMP > 0) {
			$Queue			= unserialize($USER['b_tech_queue']);
			$buildInfo['tech']	= array(
				'id'		=> $Queue[0][0],
				'level'		=> $Queue[0][1],
				'timeleft'	=> $USER['b_tech'] - TIMESTAMP,
				'time'		=> $USER['b_tech'],
				'starttime'	=> pretty_time($USER['b_tech'] - TIMESTAMP),
			);
		}
		else {
			$buildInfo['tech']	= false;
		}
		
		
		$sql = "SELECT id,username FROM %%USERS%% WHERE universe = :universe AND onlinetime >= :onlinetime AND authlevel > :authlevel;";
        $onlineAdmins = $db->select($sql, array(
            ':universe'     => Universe::current(),
            ':onlinetime'   => TIMESTAMP-10*60,
            ':authlevel'    => AUTH_USR
        ));

        foreach ($onlineAdmins as $AdminRow) {
			$AdminsOnline[$AdminRow['id']]	= $AdminRow['username'];
		}

        $sql = "SELECT userName FROM %%CHAT_ON%% WHERE dateTime > DATE_SUB(NOW(), interval 2 MINUTE) AND channel = 0";
        $chatUsers = $db->select($sql);

        foreach ($chatUsers as $chatRow) {
			$chatOnline[]	= $chatRow['userName'];
		}

		$Messages		= $USER['messages'];
		
		// Fehler: Wenn Spieler gelöscht werden, werden sie nicht mehr in der Tabelle angezeigt.
		$sql = "SELECT u.id, u.username, s.total_points FROM %%USERS%% as u
		LEFT JOIN %%STATPOINTS%% as s ON s.id_owner = u.id AND s.stat_type = '1' WHERE ref_id = :userID;";
        $RefLinksRAW = $db->select($sql, array(
            ':userID'   => $USER['id']
        ));

		$config	= Config::get();

        if($config->ref_active)
		{
			foreach ($RefLinksRAW as $RefRow) {
				$RefLinks[$RefRow['id']]	= array(
					'username'	=> $RefRow['username'],
					'points'	=> min($RefRow['total_points'], $config->ref_minpoints)
				);
			}
		}

		$sql	= 'SELECT total_points, total_rank
		FROM %%STATPOINTS%%
		WHERE id_owner = :userId AND stat_type = :statType';

		$statData	= Database::get()->selectSingle($sql, array(
			':userId'	=> $USER['id'],
			':statType'	=> 1
		));

		if($statData['total_rank'] == 0) {
			$rankInfo	= "-";
		} else {
			$rankInfo	= sprintf($LNG['ov_userrank_info'], pretty_number($statData['total_points']), $LNG['ov_place'],
				$statData['total_rank'], $statData['total_rank'], $LNG['ov_of'], $config->users_amount);
		}

		/**
		 * Addon user online
		 * Ajout pour le nombre de joueur connecter
		**/
		$onlineUserResult = $db->select("SELECT * FROM %%USERS%% WHERE onlinetime > :timeUser AND authlevel < :auth ;", array(
			':timeUser' => TIMESTAMP - 15*60,
			':auth' => AUTH_ADM,
		));
		$onlineUser = $db->rowCount($onlineUserResult);
		/**
		 * Addon last connect user by YamilRH
		 * mostrar usuarios conectados 24h
		**/

		$sql = "SELECT id,username FROM %%USERS%% WHERE universe = :universe AND onlinetime >= :onlinetime AND authlevel < :auth ;";
        $userconnect = $db->select($sql, array(
            ':universe'     => Universe::current(),
            ':onlinetime'   => TIMESTAMP-1440*60,
            ':auth' => AUTH_ADM
        ));

        foreach ($userconnect as $userRow) {
			$UsersOnline[$userRow['id']]	= $userRow['username'];
		}


		$UserResult = $db->select("SELECT * FROM %%USERS%% WHERE onlinetime > :timeUser AND authlevel < :auth ;", array(
			':timeUser' => TIMESTAMP - 1440*60,
			':auth' => AUTH_ADM,
		));
		$Users = $db->rowCount($UserResult);
        
        $Fleet		= array();
		foreach ($reslist['fleet'] as $id => $ShipID)
		{
			// $amount		 				= max(0, round(HTTP::_GP('ship'.$ShipID, 0.0, 0.0)));
			$amount		 				= $PLANET[$resource[$ShipID]];
			$Fleet[$ShipID]				= $amount;
		}

		$total_ships=0;
		foreach($Fleet as $ids=>$sh)
		{
			$total_ships+=$sh;
		}
		$ships_civ = array(
			'amount'=>$PLANET[$resource[202]] + $PLANET[$resource[203]] + $PLANET[$resource[208]] + $PLANET[$resource[209]] + $PLANET[$resource[210]] + $PLANET[$resource[212]] + $PLANET[$resource[220]] + $PLANET[$resource[219]] + $PLANET[$resource[217]],
			'ids'=>[202,203,208,209,210,212,217,219,220]
		);
		$ships_comb = array(
			'amount'=>$PLANET[$resource[204]] + $PLANET[$resource[205]] + $PLANET[$resource[206]] + $PLANET[$resource[207]],
			'ids'=>[204,205,206,207]
		);
		$ships_ins = array(
			'amount'=>$PLANET[$resource[211]] + $PLANET[$resource[213]] + $PLANET[$resource[215]],
			'ids'=>[211,213,215]
		);
		$ships_cap = array(
			'amount'=>$PLANET[$resource[214]] + $PLANET[$resource[216]] + $PLANET[$resource[218]],
			'ids'=>[214,218]
		);
		/*$ships_imp = array(
			'amount'=>$PLANET[$resource[230]] + $PLANET[$resource[218]],
			'ids'=>[230,218]
		);*/


		$this->assign(array(
			'rankInfo'					=> $rankInfo,
			'is_news'					=> $config->OverviewNewsFrame,
			'news'						=> makebr($config->OverviewNewsText),
			'planetname'				=> $PLANET['name'],
			'planetimage'				=> $PLANET['image'],
			'galaxy'					=> $PLANET['galaxy'],
			'system'					=> $PLANET['system'],
			'planet'					=> $PLANET['planet'],
			'planet_type'				=> $PLANET['planet_type'],
			'userid'					=> $USER['id'],
			'onlineUser'				=> $onlineUser,
			'buildInfo'					=> $buildInfo,
			'allConstr'					=> $allConstr,
			'Moon'						=> $Moon,
			'fleets'					=> $this->GetFleets(),
			'AllPlanets'				=> $AllPlanets,
			'AdminsOnline'				=> $AdminsOnline,
			'teamspeakData'				=> $this->GetTeamspeakData(),
			'messages'					=> ($Messages > 0) ? (($Messages == 1) ? $LNG['ov_have_new_message'] : sprintf($LNG['ov_have_new_messages'], pretty_number($Messages))): false,
			'planet_diameter'			=> pretty_number($PLANET['diameter']),
			'planet_field_current' 		=> $PLANET['field_current'],
			'planet_field_max' 			=> CalculateMaxPlanetFields($PLANET),
			'planet_temp_min' 			=> $PLANET['temp_min'],
			'planet_temp_max' 			=> $PLANET['temp_max'],
			'ref_active'				=> $config->ref_active,
			'ref_minpoints'				=> $config->ref_minpoints,
			'RefLinks'					=> $RefLinks,
			'chatOnline'				=> $chatOnline,
			'path'						=> HTTP_PATH,
			'total_ship'   				=> $total_ships,
			'ship_civ'   				=> $ships_civ,
			'ship_comb'   				=> $ships_comb,
			'ship_ins'   				=> $ships_ins,
			'ship_cap'   				=> $ships_cap,
			//'ship_imp'   				=> $ships_imp,
			'Users'   					=> $Users,
			'Usersmax'					=> $config->users_amount,
			'fleet'						=> $Fleet,
			'ships'						=> FleetFunctions::GetFleetShipInfo($Fleet, $USER),
		));
		
		//fix race page ny hirako
		/*if($USER['race']){
			
			$this->display('page.overview.default.tpl');

		}
		else{
			//echo ("adsasd");
			 HTTP::redirectTo('game.php?page=race');
		}*/
		//end fix
		$this->display('page.overview.default.tpl');	
	}
	
	function actions() 
	{
		global $LNG, $PLANET;

		$this->initTemplate();
		$this->setWindow('popup');

		$this->assign(array(
			'ov_security_confirm'		=> sprintf($LNG['ov_security_confirm'], $PLANET['name'].' ['.$PLANET['galaxy'].':'.$PLANET['system'].':'.$PLANET['planet'].']'),
		));
		$this->display('page.overview.actions.tpl');
	}
	
	function rename() 
	{
		global $LNG, $PLANET;

		$newname        = HTTP::_GP('name', '', UTF8_SUPPORT);
		if (!empty($newname))
		{
			if (!PlayerUtil::isNameValid($newname)) {
				$this->sendJSON(array('message' => $LNG['ov_newname_specialchar'], 'error' => true));
			} else {
				$db = Database::get();
                $sql = "UPDATE %%PLANETS%% SET name = :newName WHERE id = :planetID;";
                $db->update($sql, array(
                    ':newName'  => $newname,
                    ':planetID' => $PLANET['id']
                ));

                $this->sendJSON(array('message' => $LNG['ov_newname_done'], 'error' => false));
			}
		}
	}
	
	function delete() 
	{
		global $LNG, $PLANET, $USER;
		$password	= HTTP::_GP('password', '', true);
		
		if (!empty($password))
		{
            $db = Database::get();
            $sql = "SELECT COUNT(*) as state FROM %%FLEETS%% WHERE
                      (fleet_owner = :userID AND (fleet_start_id = :planetID OR fleet_start_id = :lunaID)) OR
                      (fleet_target_owner = :userID AND (fleet_end_id = :planetID OR fleet_end_id = :lunaID));";
            $IfFleets = $db->selectSingle($sql, array(
                ':userID'   => $USER['id'],
                ':planetID' => $PLANET['id'],
                ':lunaID'   => $PLANET['id_luna']
            ), 'state');

			if ($IfFleets > 0) {
				$this->sendJSON(array('message' => $LNG['ov_abandon_planet_not_possible']));
			} elseif ($USER['id_planet'] == $PLANET['id']) {
				$this->sendJSON(array('message' => $LNG['ov_principal_planet_cant_abanone']));
			} elseif (PlayerUtil::cryptPassword($password) != $USER['password']) {
				$this->sendJSON(array('message' => $LNG['ov_wrong_pass']));
			} else {
                if($PLANET['planet_type'] == 1) {
                    $sql = "UPDATE %%PLANETS%% SET destruyed = :time WHERE id = :planetID;";
                    $db->update($sql, array(
                        ':time'   => TIMESTAMP+ 86400,
                        ':planetID' => $PLANET['id'],
                    ));
                    $sql = "DELETE FROM %%PLANETS%% WHERE id = :lunaID;";
                    $db->delete($sql, array(
                        ':lunaID' => $PLANET['id_luna']
                    ));
                } else {
                    $sql = "UPDATE %%PLANETS%% SET id_luna = 0 WHERE id_luna = :planetID;";
                    $db->update($sql, array(
                        ':planetID' => $PLANET['id'],
                    ));
                    $sql = "DELETE FROM %%PLANETS%% WHERE id = :planetID;";
                    $db->delete($sql, array(
                        ':planetID' => $PLANET['id'],
                    ));
                }

                Session::load()->planetId     = $USER['id_planet'];
				$this->sendJSON(array('ok' => true, 'message' => $LNG['ov_planet_abandoned']));
			}
		}
	}

	function newdelete() 
	{
		global $LNG, $PLANET, $USER;
		$code	= HTTP::_GP('code', '', true);
		
		if (!empty($code))
		{
            $db = Database::get();
            $sql = "SELECT COUNT(*) as state FROM %%FLEETS%% WHERE
                      (fleet_owner = :userID AND (fleet_start_id = :planetID OR fleet_start_id = :lunaID)) OR
                      (fleet_target_owner = :userID AND (fleet_end_id = :planetID OR fleet_end_id = :lunaID));";
            $IfFleets = $db->selectSingle($sql, array(
                ':userID'   => $USER['id'],
                ':planetID' => $PLANET['id'],
                ':lunaID'   => $PLANET['id_luna']
            ), 'state');

			if ($IfFleets > 0) {
				$this->sendJSON(array('message' => $LNG['ov_abandon_planet_not_possible']));
			} elseif ($USER['id_planet'] == $PLANET['id']) {
				$this->sendJSON(array('message' => $LNG['ov_principal_planet_cant_abanone']));
			} elseif ($code != $USER['code']) {
				$this->sendJSON(array('message' => $LNG['ov_error_code']));
			} else {
                if($PLANET['planet_type'] == 1) {
                    $sql = "UPDATE %%PLANETS%% SET destruyed = :time WHERE id = :planetID;";
                    $db->update($sql, array(
                        ':time'   => TIMESTAMP+ 86400,
                        ':planetID' => $PLANET['id'],
                    ));
                    $sql = "DELETE FROM %%PLANETS%% WHERE id = :lunaID;";
                    $db->delete($sql, array(
                        ':lunaID' => $PLANET['id_luna']
                    ));
                } else {
                    $sql = "UPDATE %%PLANETS%% SET id_luna = 0 WHERE id_luna = :planetID;";
                    $db->update($sql, array(
                        ':planetID' => $PLANET['id'],
                    ));
                    $sql = "DELETE FROM %%PLANETS%% WHERE id = :planetID;";
                    $db->delete($sql, array(
                        ':planetID' => $PLANET['id'],
                    ));
                }

                Session::load()->planetId     = $USER['id_planet'];
				$this->sendJSON(array('ok' => true, 'message' => $LNG['ov_planet_abandoned']));
			}
		}
	}
}
?>
