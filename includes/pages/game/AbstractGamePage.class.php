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

abstract class AbstractGamePage
{
	/**
	 * reference of the template object
	 * @var template
	 */
	protected $tplObj;

	/**
	 * reference of the template object
	 * @var ResourceUpdate
	 */
	protected $ecoObj;
	protected $window;
	protected $allianceData1;
	protected $disableEcoSystem = false;

	protected function __construct() {

		if(!AJAX_REQUEST)
		{
			$this->setWindow('full');
			if(!$this->disableEcoSystem)
			{
				$this->ecoObj	= new ResourceUpdate();
				$this->ecoObj->CalcResource();
			}
			$this->initTemplate();
		} else {
			$this->setWindow('ajax');
		}
	}

	protected function initTemplate() {
		if(isset($this->tplObj))
			return true;

		$this->tplObj	= new template;
		list($tplDir)	= $this->tplObj->getTemplateDir();
		$this->tplObj->setTemplateDir($tplDir.'game/');
		return true;
	}

	protected function setWindow($window) {
		$this->window	= $window;
	}

	protected function getWindow() {
		return $this->window;
	}

	protected function getQueryString() {
		$queryString	= array();
		$page			= HTTP::_GP('page', '');

		if(!empty($page)) {
			$queryString['page']	= $page;
		}

		$mode			= HTTP::_GP('mode', '');
		if(!empty($mode)) {
			$queryString['mode']	= $mode;
		}

		return http_build_query($queryString);
	}

	protected function getCronjobsTodo()
	{
		require_once 'includes/classes/Cronjob.class.php';

		$this->assign(array(
			'cronjobs'		=> Cronjob::getNeedTodoExecutedJobs()
		));
	}

	protected function getNavigationData()
	{
		global $PLANET, $LNG, $USER, $THEME, $resource, $reslist;

		$config			= Config::get();
		$db 			= Database::get();

		$pbs=HTTP::_GP('chpb', '0');
		if($pbs)
		{
			$sql = "UPDATE %%USERS%% SET showbarpl = !showbarpl  WHERE id = :id;";
			$db->update($sql, array(
				':id' => $USER['id']
			));
			HTTP::redirectTo('game.php?'.$this->getQueryString());
		}
		
		$PlanetSelect	= array();

		if(isset($USER['PLANETS'])) {
			$USER['PLANETS']	= getPlanets($USER);
		}

		foreach($USER['PLANETS'] as $PlanetQuery)
		{
			$PlanetSelect[$PlanetQuery['id']]	= $PlanetQuery['name'].(($PlanetQuery['planet_type'] == 3) ? " (" . $LNG['fcm_moon'] . ")":"")." [".$PlanetQuery['galaxy'].":".$PlanetQuery['system'].":".$PlanetQuery['planet']."]";
		}

		/*$resourceTable	= array();
		$resourceSpeed	= $config->resource_multiplier;
		foreach($reslist['resstype'][1] as $resourceID)
		{
			$resourceTable[$resourceID]['name']			= $resource[$resourceID];
			$resourceTable[$resourceID]['current']		= $PLANET[$resource[$resourceID]];
			$resourceTable[$resourceID]['max']			= $PLANET[$resource[$resourceID].'_max'];
			if($USER['urlaubs_modus'] == 1 || $PLANET['planet_type'] != 1)
			{
				$resourceTable[$resourceID]['production']	= $PLANET[$resource[$resourceID].'_perhour'];
			}
			else
			{
				$resourceTable[$resourceID]['production']	= $PLANET[$resource[$resourceID].'_perhour'] + $config->{$resource[$resourceID].'_basic_income'} * $resourceSpeed;
			}
		}

		foreach($reslist['resstype'][2] as $resourceID)
		{
			$resourceTable[$resourceID]['name']			= $resource[$resourceID];
			$resourceTable[$resourceID]['used']			= $PLANET[$resource[$resourceID].'_used'];
			$resourceTable[$resourceID]['max']			= $PLANET[$resource[$resourceID]];
		}

		foreach($reslist['resstype'][3] as $resourceID)
		{
			$resourceTable[$resourceID]['name']			= $resource[$resourceID];
			$resourceTable[$resourceID]['current']		= $USER[$resource[$resourceID]];
		}
*/

		//Навигация - ресурсы
		$resourceTable	= array();
		$resourceSpeed	= $config->resource_multiplier;
        //Перебор $reslist['resstype'][1]
		foreach($reslist['resstype'][1] as $resourceID)
		{
			$resourceTable[$resourceID]['name']			    = $resource[$resourceID];
			$resourceTable[$resourceID]['current']		    = $PLANET[$resource[$resourceID]];
			$resourceTable[$resourceID]['max']			    = $PLANET[$resource[$resourceID].'_max'];
			$resourceTable[$resourceID]['percent']			= round($PLANET[$resource[$resourceID]] * 100 / $PLANET[$resource[$resourceID].'_max']);
			
			if($PLANET['planet_type'] == 1){
                $resourceTable[$resourceID]['information']		= pretty_number($PLANET[$resource[$resourceID].'_perhour']+ $config->{$resource[$resourceID].'_basic_income'} * $resourceSpeed);
                $resourceTable[$resourceID]['informationd']	    = pretty_number(($PLANET[$resource[$resourceID].'_perhour']+ $config->{$resource[$resourceID].'_basic_income'} * $resourceSpeed) *24);
                $resourceTable[$resourceID]['informationz']		= pretty_number(($PLANET[$resource[$resourceID].'_perhour']+ $config->{$resource[$resourceID].'_basic_income'} * $resourceSpeed) * 24 * 7);
			}else{
                $resourceTable[$resourceID]['information']		= 0;
                $resourceTable[$resourceID]['informationd']		= 0;
                $resourceTable[$resourceID]['informationz']		= 0;
			}
			if($USER['urlaubs_modus'] == 1 || $PLANET['planet_type'] != 1)
			{
				$resourceTable[$resourceID]['production']	= $PLANET[$resource[$resourceID].'_perhour'];
			}
			else
			{
				$resourceTable[$resourceID]['production']	= $PLANET[$resource[$resourceID].'_perhour'] + $config->{$resource[$resourceID].'_basic_income'} * $resourceSpeed;
			}
		}
        //Перебор $reslist['resstype'][2]
		foreach($reslist['resstype'][2] as $resourceID)
		{
            $resourceTable[$resourceID]['name']			= $resource[$resourceID];
			$resourceTable[$resourceID]['used']			= $PLANET[$resource[$resourceID]] + $PLANET[$resource[$resourceID].'_used'];
			$resourceTable[$resourceID]['max']			= $PLANET[$resource[$resourceID]];
			$resourceTable[$resourceID]['percent']		= round(($PLANET[$resource[$resourceID]] + $PLANET[$resource[$resourceID].'_used']) * 100 / max(1,$PLANET[$resource[$resourceID]]));
		}
        //Перебор $reslist['resstype'][3]
		foreach($reslist['resstype'][3] as $resourceID)
		{
			$resourceTable[$resourceID]['name']			= $resource[$resourceID];
			$resourceTable[$resourceID]['current']		= $USER[$resource[$resourceID]];	
		}

		
		/**
		 * Addition for moving planet with arrows
		 * Ajout pour le déplacement de planète avec les flèches
		**/
		$previousPlanet = $db->selectSingle("SELECT id FROM %%PLANETS%% WHERE id < :planetID AND id_owner = :userID AND destruyed = '0' ORDER BY id DESC LIMIT 1 ;", array(':planetID' => $PLANET['id'], ':userID' => $USER['id']));
		$nextPlanet = $db->selectSingle("SELECT id FROM %%PLANETS%% WHERE id > :planetID AND id_owner = :userID AND destruyed = '0' ORDER BY id ASC LIMIT 1 ;", array(':planetID' => $PLANET['id'], ':userID' => $USER['id']));

		/**
		 * MIO añadir ranking global by yamilrh
		 *
		**/

		$sql4	= 'SELECT total_points, total_rank
		FROM %%STATPOINTS%%
		WHERE id_owner = :userId AND stat_type = :statType';

		$statData	= Database::get()->selectSingle($sql4, array(
			':userId'	=> $USER['id'],
			':statType'	=> 1
		));

		/**
		 * Addon user online
		 * MIO añadir useronline global by yamilrh
		**/
		$onlineUserResult = $db->select("SELECT * FROM %%USERS%% WHERE onlinetime > :timeUser AND authlevel < :auth ;", array(
			':timeUser' => TIMESTAMP - 15*60,
			':auth' => AUTH_ADM,
		));
		$onlineUser = $db->rowCount($onlineUserResult);

		/**
		 * Addon user online
		 * MIO añadir ranking global by yamilrh
		**/
		$sql3	= 'SELECT total_points, total_rank
		FROM %%STATPOINTS%%
		WHERE id_owner = :userId AND stat_type = :statType';

		$statData	= Database::get()->selectSingle($sql3, array(
			':userId'	=> $USER['id'],
			':statType'	=> 1
		));

		if($statData['total_rank'] == 0) {
			$rankGlobal	= "-";
		} else {
			$rankGlobal	=  $statData['total_rank'];
		}

		/**
		 * Addon user online
		 * MIO añadir userbanner by yamilrh
		**/

		$sql1 = 'SELECT user.username, user.wons, user.loos, user.draws,
		stat.total_points, stat.total_rank,
		planet.name, planet.galaxy, planet.system, planet.planet, config.game_name,
		config.users_amount, config.ttf_file
		FROM %%USERS%% as user, %%STATPOINTS%% as stat, %%PLANETS%% as planet, %%CONFIG%% as config
		WHERE user.id = :userId AND stat.stat_type = :statType AND stat.id_owner = :userId
		AND planet.id = user.id_planet AND config.uni = user.universe;';

		$ydata = Database::get()->selectSingle($sql1, array(
			':userId'	=> $USER['id'],
			':statType'	=> 1
		));

		$totaly	= $ydata['wons'] + $ydata['loos'] + $ydata['draws'];
		$quote	= $totaly != 0 ? $ydata['wons'] / $totaly * 100 : 0;
		$yploos	= $totaly != 0 ? $ydata['loos'] / $totaly * 100 : 0;
		$ypdraws	= $totaly != 0 ? $ydata['draws'] / $totaly * 100 : 0;


		/**
		 * Addon user online
		 * MIO añadir batallas by yamilrh
		**/
		$sql2	= "SELECT SUM(wons) as wons, SUM(loos) as loos, SUM(draws) as draws, SUM(kbmetal) as kbmetal, SUM(kbcrystal) as kbcrystal, SUM(lostunits) as lostunits, SUM(desunits) as desunits FROM %%USERS%% as user WHERE user.id = :userId;";
		$statisticResult = $db->selectSingle($sql2, array(
			':userId'	=> $USER['id']
		));


		$themeSettings	= $THEME->getStyleSettings();
		
			// rayco
		$result2=getPlanets($USER);
		$Result=[];
		$v=1;
		foreach($PlanetSelect as $order=>$val2)
		{
			foreach($result2 as $item)
			{
				if($order == $item['id'])
				{
					$item['coord']='['.explode('[',$val2)[1];
					$Result[]=$item;
					break;
				}
			}
		}

		// endrayco

		/**
		*Mod bonus by YamilRH
		**/
		$sql = "SELECT * FROM %%OBONUS%% WHERE start_time < :now_time AND end_time > :now_time;";

		$bonus_data = Database::get()->select($sql, array(
		':now_time'		=> TIMESTAMP,
   		));
   		$b_active = (Database::get()->rowCount($bonus_data) > 0);

   		$sql1 = "SELECT procent FROM %%OBONUS%% WHERE start_time < :now_time AND end_time > :now_time;";

		$bonus_data1 = $db->select($sql1, array(
		':now_time'		=> TIMESTAMP,
   		));
		$all_bonus = array();

		foreach ($bonus_data1 as $row => $data) {
		$all_bonus[] = array(
			'procent'	=> $data['procent'],
			);
		}

			$sql	= 'SELECT COUNT(*) as state FROM %%PLANETS%% WHERE `id_owner` = :userId AND `planet_type` = 1 AND `destruyed` = 0;';
			$currentPlanetCountTable	= $db->selectSingle($sql, array(
				':userId'		=> $USER['id'],
			), 'state');
			$maxPlanetCount		= PlayerUtil::maxPlanetCount($USER);

/**
		*Mod Statics Users
		**/

		$UsersInactive = $db->select("SELECT * FROM %%USERS%% WHERE onlinetime < :timeUser AND authlevel < :auth ;", array(
			':timeUser' => TIMESTAMP - INACTIVE,
			':auth' => AUTH_ADM,
		));
		$UsersI = $db->rowCount($UsersInactive);



		$UserVacation = $db->select("SELECT * FROM %%USERS%% WHERE urlaubs_modus = :MV AND authlevel < :auth ;", array(
			':MV' => 1,
			':auth' => AUTH_ADM,
		));
		$UsersMV = $db->rowCount($UserVacation);

		$UserBan = $db->select("SELECT * FROM %%USERS%% WHERE bana = :B AND authlevel < :auth ;", array(
			':B' => 1,
			':auth' => AUTH_ADM,
		));
		$UsersB = $db->rowCount($UserBan);


		/*
		**Mod alliance
		**
		*/

		$rankList	= array();

		$db = Database::get();
		$sql = "SELECT rankID, rankName FROM %%ALLIANCE_RANK%% WHERE allianceId = :AllianceID";
		$rankResult = $db->select($sql, array(
			':AllianceID'	=> $this->allianceData1['id']
		));

		foreach($rankResult as $rankRow)
			$rankList[$rankRow['rankID']]	= $rankRow['rankName'];

		//$db	= Database::get();

		$sql	= 'SELECT * FROM %%ALLIANCE%% WHERE id = :allianceId;';
		$this->allianceData1 = $db->selectSingle($sql, array(
			':allianceId'	=> $USER['ally_id']
		));

		$memberList	= array();

		$sql = "SELECT DISTINCT u.id, u.username,u.galaxy, u.system, u.planet, u.ally_register_time, u.onlinetime, u.ally_rank_id, s.total_points FROM %%USERS%% u LEFT JOIN %%STATPOINTS%% as s ON s.stat_type = '1' AND s.id_owner = u.id WHERE ally_id = :AllianceID;";
		$memberListResult = $db->select($sql, array(
			':AllianceID'	=> $this->allianceData1['id']
		));

		foreach ($memberListResult as $memberListRow)
		{
			if ($this->allianceData1['ally_owner'] == $memberListRow['id'])
				$memberListRow['ally_rankName'] = empty($this->allianceData1['ally_owner_range']) ? $LNG['al_founder_rank_text'] : $this->allianceData1['ally_owner_range'];
			elseif ($memberListRow['ally_rank_id'] != 0 && isset($rankList[$memberListRow['ally_rank_id']]))
				$memberListRow['ally_rankName'] = $rankList[$memberListRow['ally_rank_id']];
			else
				$memberListRow['ally_rankName'] = $LNG['al_new_member_rank_text'];

			$memberList[$memberListRow['id']]	= array(
				'username'		=> $memberListRow['username'],
				'galaxy'		=> $memberListRow['galaxy'],
				'system'		=> $memberListRow['system'],
				'planet'		=> $memberListRow['planet'],
				'register_time'	=> _date($LNG['php_tdformat'], $memberListRow['ally_register_time'], $USER['timezone']),
				'points'		=> $memberListRow['total_points'],
				'rankName'		=> $memberListRow['ally_rankName'],
				'onlinetime'	=> floor((TIMESTAMP - $memberListRow['onlinetime']) / 60),
				'rankID'		=> $memberListRow['ally_rank_id'],
				'kickQuestion'	=> sprintf($LNG['al_kick_player'], $memberListRow['username'])
			);
		}


$session    = Session::load();
		if(!$session->isValidSession()){
			$session->delete();
			exit();
		}

		$ataks 	 = HTTP::_GP('ataks', 0);
		$spio	 = HTTP::_GP('spio', 0);
		$unic	 = HTTP::_GP('unic', 0);
		$rakets	 = HTTP::_GP('rakets', 0);
		//ATTACK PART
		$totalAttacks = 0;
		$sql	= 'SELECT COUNT(fleet_id) as fleet_id FROM %%FLEETS%% WHERE fleet_target_owner = :userId AND fleet_mission = :missionID AND fleet_mess = :mesID';
		$totalAttacks	= Database::get()->selectSingle($sql, array(
		':userId'	=> $session->userId,
		':missionID'	=> 1,
		':mesID'	=> 0
		), 'fleet_id');
		if($totalAttacks != 0){
			$totalAttacks = $totalAttacks;	
		}
		//END ATTACK PART

		//unic PART
		$unicAttacks = 0;
		$sql	= 'SELECT COUNT(fleet_id) as fleet_id FROM %%FLEETS%% WHERE fleet_target_owner = :userId AND fleet_mission = :missionID AND fleet_mess = :mesID';
		$unicAttacks	= Database::get()->selectSingle($sql, array(
			':userId'	=> $session->userId,
			':missionID'	=> 9,
			':mesID'	=> 0
		), 'fleet_id');
		if($unicAttacks != 0){
			$unicAttacks = $unicAttacks;	
		}
		//END unic PART

		//ROCKET PART
		$totalRockets = 0;
		$sql	= 'SELECT COUNT(fleet_id) as fleet_id FROM %%FLEETS%% WHERE fleet_target_owner = :userId AND fleet_mission = :missionID AND fleet_mess = :mesID';
		$totalRockets	= Database::get()->selectSingle($sql, array(
			':userId'	=> $session->userId,
			':missionID'	=> 10,
			':mesID'	=> 0
		), 'fleet_id');
		if($totalRockets != 0){
			$totalRockets = $totalRockets;	
		}
		//END ROCKET PART

		//SPIO PART
		$totalSpio = 0;
		$sql	= 'SELECT COUNT(fleet_id) as fleet_id FROM %%FLEETS%% WHERE fleet_target_owner = :userId AND fleet_mission = :missionID AND fleet_mess = :mesID';
		$totalSpio	= Database::get()->selectSingle($sql, array(
			':userId'	=> $session->userId,
			':missionID'	=> 6,
			':mesID'	=> 0
		), 'fleet_id');
		if($totalSpio != 0){
			$totalSpio = $totalSpio;	
		}
		//END SPIO PART

		//END ICON PART
		$attackActive = "";
		if ($totalAttacks > 0){
			$attackActive = "active_indicator";
		}
		$spioActive = "";
		if ($totalSpio > 0){
			$spioActive = "active_indicator";
		}
		$unicActive = "";
		if ($unicAttacks > 0){
			$unicActive = "active_indicator";
		}
		$rocketActive = "";
		if ($totalRockets > 0){
			$rocketActive = "active_indicator";
		}

		$varAttack = $totalAttacks > 0 ? $LNG['customm_1_1'] : $LNG['customm_1'];
		$varSpied  = $totalSpio > 0 ? $LNG['customm_4_1'] : $LNG['customm_4'];
		$varCaptu  = $unicAttacks > 0 ? $LNG['customm_2_1'] : $LNG['customm_2'];
		$varRocke  = $totalRockets > 0 ? $LNG['customm_5_1'] : $LNG['customm_5'];

		$arr = array('ataks'=>"".$totalAttacks."",'spio'=>"".$totalSpio."",'unic'=>"".$unicAttacks."",'rakets'=>"".$totalRockets."",'ajax'=>"1",'ICOFLEET'=>"<div id='attack' class='indicator ".$attackActive." tooltip' data-tooltip-content='".$varAttack."'><div class='icoi'></div></div><div id='destruction' class='indicator ".$unicActive." tooltip' data-tooltip-content='".$LNG['customm_3']."'><div class='icoi'></div></div><div id='espionage' class='indicator ".$spioActive." tooltip' data-tooltip-content='".$varSpied."' href='game.php?page=overview'><div class='icoi'></div></div><div id='rocket' class='indicator ".$rocketActive." tooltip' data-tooltip-content='".$varRocke."'><div class='icoi'></div></div>");
		//echo json_encode($attackActive);exit();

		$this->assign(array(
			'PlanetSelect'		=> $PlanetSelect,
			'new_message' 		=> $USER['messages'],
			'vacation'			=> $USER['urlaubs_modus'] ? _date($LNG['php_tdformat'], $USER['urlaubs_until'], $USER['timezone']) : false,
			'delete'			=> $USER['db_deaktjava'] ? sprintf($LNG['tn_delete_mode'], _date($LNG['php_tdformat'], $USER['db_deaktjava'] + ($config->del_user_manually * 86400)), $USER['timezone']) : false,
			'darkmatter'		=> $USER['darkmatter'],
			'current_pid'		=> $PLANET['id'],
			'image'				=> $PLANET['image'],
			'resourceTable'		=> $resourceTable,
			'shortlyNumber'		=> $themeSettings['TOPNAV_SHORTLY_NUMBER'],
			'closed'			=> !$config->game_disable,
			'hasBoard'			=> filter_var($config->forum_url, FILTER_VALIDATE_URL),
			//'hasBoard'			=> filter_var(HTTP::redirectTo($config->forum_url)),
			'hasAdminAccess'	=> !empty(Session::load()->adminAccess),
			'hasGate'			=> $PLANET[$resource[43]] > 0,
			'username'			=> $USER['username'],
			'previousPlanet'	=> $previousPlanet['id'],
			'nextPlanet'		=> $nextPlanet['id'],
			'ranking'			=> $statData['total_points'],
			'onlineUser'				=> $onlineUser,
			'maxfleetcount'				=> FleetFunctions::GetCurrentFleets($USER['id']),
			'fleetmax'					=> FleetFunctions::GetMaxFleetSlots($USER),
			'rankGlobal'				=> $rankGlobal,
			'pointsGlobal'				=> shortly_number($statData['total_points']),
			'totalGlobal'               => shortly_number($totaly, 0),
			'winsGlobal'				=> pretty_number(shortly_number($quote, 2)),
			'yploos'					=> pretty_number(shortly_number($yploos, 2)),
			'ypdraws'					=> pretty_number(shortly_number($ypdraws, 2)),
			'yfightwon'					=> $statisticResult['wons'],
			'yfightlose'					=> $statisticResult['loos'],
			'yfightdraw'					=> $statisticResult['draws'],
			'yunitsshot'					=> pretty_number($statisticResult['desunits']),
			'yunitslose'					=> pretty_number($statisticResult['lostunits']),
			'ydermetal'					=> pretty_number($statisticResult['kbmetal']),
			'ydercrystal'				=> pretty_number($statisticResult['kbcrystal']),
			'sider'						=>$Result,
			'barplan'					=>$USER['showbarpl'],
			'BMO'						=> is_bonus_active('mo'),
			'BMine'						=> is_bonus_active('mine'),
			'b_active'					=> $b_active,
			'all_bonus'					=>	$all_bonus,
			'tourneyEnd'				=> config::get()->tourneyEnd - TIMESTAMP,		
			'currentPlanetCountTable'		=> $currentPlanetCountTable,	
			'maxPlanetCount'				=> $maxPlanetCount,
			'bonus_time'		=> $USER['bonus_time'],
		        'bonus_time_rest'   => _date('d.m.Y H:i:s', ($USER['bonus_time']), $USER['timezone']),
			'Usersmax'					=>	$config->users_amount,
			'UsersMV'					=>	$UsersMV,
			'UsersI'					=>	$UsersI,
			'UsersB'					=>	$UsersB,
			'memberList'				=> $memberList,
			//'ally_name' 					=> $this->allianceData1['ally_name'],
			'alliance'					=>$USER['ally_id'],
			'totalAttacks'			=> $totalAttacks,
			'totalRockets'			=> $totalRockets,
			'totalSpio'				=> $totalSpio,
			'unicAttacks'			=> $unicAttacks,
			'attackActive'			=> $attackActive,			'sirena'				=> $USER['sirena'] / 10,
			'new_message' 			=> $USER['messages'],
		));
	}

	protected function getPageData()
	{
		global $USER, $THEME, $LNG;

$db	= Database::get();

		if($this->getWindow() === 'full') {
			$this->getNavigationData();
			$this->getCronjobsTodo();
			$this->Achievements();
		}

		$dateTimeServer		= new DateTime("now");
		if(isset($USER['timezone'])) {
			try {
				$dateTimeUser	= new DateTime("now", new DateTimeZone($USER['timezone']));
			} catch (Exception $e) {
				$dateTimeUser	= $dateTimeServer;
			}
		} else {
			$dateTimeUser	= $dateTimeServer;
		}

		$logID = $db->lastInsertId(); 
		$sql = "INSERT INTO %%TRACKING%% SET userId = :userId, userName = :userName, pageVisited = :pageVisited, time = :time, trackMode = 1;";
		$db->insert($sql, array(
			':userId'		=> $USER['id'],
			':userName'		=> empty($USER['username']) ? $USER['username'] : $USER['username'],
			':pageVisited'	=> empty($this->getQueryString()) ? 'game.php' : $this->getQueryString(),
			':time'			=> TIMESTAMP
		));

		$config	= Config::get();

		$this->assign(array(
			'vmode'				=> $USER['urlaubs_modus'],
			'authlevel'			=> $USER['authlevel'],
			'userID'			=> $USER['id'],
			'bodyclass'			=> $this->getWindow(),
			'game_name'			=> $config->game_name,
			'uni_name'			=> $config->uni_name,
			'ga_active'			=> $config->ga_active,
			'ga_key'			=> $config->ga_key,
			'debug'				=> $config->debug,
			'VERSION'			=> $config->VERSION,
			'date'				=> explode("|", date('Y\|n\|j\|G\|i\|s\|Z', TIMESTAMP)),
			'isPlayerCardActive' => isModuleAvailable(MODULE_PLAYERCARD),
			'REV'				=> substr($config->VERSION, -4),
			'Offset'			=> $dateTimeUser->getOffset() - $dateTimeServer->getOffset(),
			'queryString'		=> $this->getQueryString(),
			'themeSettings'		=> $THEME->getStyleSettings(),
		));
	}
	protected function printMessage($message, $redirectButtons = NULL, $redirect = NULL, $fullSide = true)
	{
		$this->assign(array(
			'message'			=> $message,
			'redirectButtons'	=> $redirectButtons,
		));

		if(isset($redirect)) {
			$this->tplObj->gotoside($redirect[0], $redirect[1]);
		}

		if(!$fullSide) {
			$this->setWindow('popup');
		}

		$this->display('error.default.tpl');
	}

	protected function dangerMessage($message, $redirectButtons = NULL, $redirect = NULL, $fullSide = true)
	{
		$this->assign(array(
			'message'			=> $message,
			'redirectButtons'	=> $redirectButtons,
		));

		if(isset($redirect)) {
			$this->tplObj->gotoside($redirect[0], $redirect[1]);
		}

		if(!$fullSide) {
			$this->setWindow('popup');
		}

		$this->display('danger.default.tpl');
	}

	protected function successMessage($message, $redirectButtons = NULL, $redirect = NULL, $fullSide = true)
	{
		$this->assign(array(
			'message'			=> $message,
			'redirectButtons'	=> $redirectButtons,
		));

		if(isset($redirect)) {
			$this->tplObj->gotoside($redirect[0], $redirect[1]);
		}

		if(!$fullSide) {
			$this->setWindow('popup');
		}

		$this->display('success.default.tpl');
	}

	protected function save() {
		if(isset($this->ecoObj)) {
			$this->ecoObj->SavePlanetToDB();
		}
	}

	protected function assign($array, $nocache = true) {
		$this->tplObj->assign_vars($array, $nocache);
	}

	protected function display($file) {
		global $THEME, $LNG, $USER;

		$this->save();

		if($this->getWindow() !== 'ajax') {
			$this->getPageData();
		}

		$this->assign(array(
			'foto'			=> $USER['foto'],
			'lang'    		=> $LNG->getLanguage(),
			'dpath'			=> $THEME->getTheme(),
			'scripts'		=> $this->tplObj->jsscript,
			'execscript'	=> implode("\n", $this->tplObj->script),
			'basepath'		=> PROTOCOL.HTTP_HOST.HTTP_BASE,
			'servertime'	=> _date("M D d H:i:s", TIMESTAMP, $USER['timezone']),
		));

		$this->assign(array(
			'LNG'			=> $LNG,
		), false);

		$this->tplObj->display('extends:layout.'.$this->getWindow().'.tpl|'.$file);
		exit;
	}

	protected function sendJSON($data) {
		$this->save();
		echo json_encode($data);
		exit;
	}

	protected function redirectTo($url) {
		$this->save();
		HTTP::redirectTo($url);
		exit;
	}

	protected function Achievements()
	{
		global $USER, $THEME, $LNG;
		
		//ACHIEVEMENT COMMON PEACE
		if ($USER['peacefull_exp_level'] >= (5 * $USER['achievement_common_1']) + 5){
			$peace_reward_am = 200;
			$peace_reward_points = 100;
			$next_am_peace = min(20000,round($peace_reward_am * pow(1.08, $USER['achievement_common_1'])));
			$next_points_peace = min(20000,round($peace_reward_points * pow(1.08, $USER['achievement_common_1'])));
			$next_level = $USER['achievement_common_1'] + 1;
			$sql	= "UPDATE %%USERS%% SET achievement_common_1 = achievement_common_1 + :achievement_common_1, achievement_common_1_points = achievement_common_1_points + :achievement_common_1_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			database::get()->update($sql, array(
				':achievement_common_1'	=> 1,
				':achievement_common_1_points'	=> $next_points_peace,
				':achievement_point'	=> $next_points_peace,
				':darkmatter'	=> $next_am_peace,
				':userId'				=> $USER['id']

			));
			$msg = '<a href="game.php?page=achievement&amp;group=general#ach_level"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_level.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_18'], pretty_number($next_level)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($next_am_peace).' '.$LNG['tech'][921].' <br> '.pretty_number($next_points_peace).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($USER['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
		//END
		//ACHIEVEMENT COMMON COMBAT
		if ($USER['combat_exp_level'] >= (5 * $USER['achievement_common_2']) + 5){
			$combat_reward_am = 400;
			$combat_reward_points = 200;
			$next_am_combat = min(20000,round($combat_reward_am * pow(1.09, $USER['achievement_common_2'])));
			$next_points_combat = min(20000,round($combat_reward_points * pow(1.09, $USER['achievement_common_2'])));
			$next_level = $USER['achievement_common_2'] + 1;
			$sql	= "UPDATE %%USERS%% SET achievement_common_2 = achievement_common_2 + :achievement_common_2, achievement_common_2_points = achievement_common_2_points + :achievement_common_2_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			database::get()->update($sql, array(
				':achievement_common_2'	=> 1,
				':achievement_common_2_points'	=> $next_points_combat,
				':achievement_point'	=> $next_points_combat,
				':darkmatter'	=> $next_am_combat,
				':userId'				=> $USER['id']

			));
			$msg = '<a href="game.php?page=achievement&amp;group=general#ach_batle_level"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_batle_level.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_20'], pretty_number($next_level)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($next_am_combat).' '.$LNG['tech'][921].' <br> '.pretty_number($next_points_combat).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($USER['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
		//END
		//ACHIEVEMENT BUILD METAL
		$sql	= 'SELECT metal_mine FROM %%PLANETS%% WHERE id_owner = :id_owner ORDER BY metal_mine DESC LIMIT :limit';
		//$sql	= 'SELECT metal_mine FROM %%PLANETS%% WHERE id_owner = :id_owner ORDER BY metal_mine DESC LIMIT 1';
		$onlineDatas	= Database::get()->selectSingle($sql, array(
			':id_owner'	=> $USER['id'],
			':limit'	=> 1
		));
		if ($onlineDatas['metal_mine'] >= (3 * $USER['achievement_build_1']) + 3){
			$metal_reward_am = 7;
			$metal_reward_points = 1;
			$next_level = $USER['achievement_build_1'] + 1;
			$metal_reward_am = min(20000,round($metal_reward_am * pow(1.35, $USER['achievement_build_1'])));
			$metal_reward_points = min(20000,round($metal_reward_points * pow(1.35, $USER['achievement_build_1'])));
			$sql = "UPDATE %%USERS%% SET achievement_build_1 = achievement_build_1 + :achievement_build_1, achievement_build_1_points = achievement_build_1_points + :achievement_build_1_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			Database::get()->update($sql, array(
				':achievement_build_1'	=> 1,
				':achievement_build_1_points'	=> $metal_reward_points,
				':achievement_point'	=> $metal_reward_points,
				':darkmatter'	=> $metal_reward_am,
				':userId'				=> $USER['id']

			));
			$msg = '<a href="game.php?page=achievement&amp;group=build#ach_mine_metal"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_mine_metal.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_75'], pretty_number($next_level)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($metal_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($metal_reward_points).' '.$LNG['achiev_13'].'</a>';
			//$msg = 'testo';
			PlayerUtil::sendMessage($USER['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
		//END
		//ACHIEVEMENT BUILD CRYSTAL
		$sql	= 'SELECT crystal_mine FROM %%PLANETS%% WHERE id_owner = :id_owner ORDER BY crystal_mine DESC LIMIT :limit';
		$onlineDatas	= Database::get()->selectSingle($sql, array(
			':id_owner'	=> $USER['id'],
			':limit'	=> 1
		));
		if ($onlineDatas['crystal_mine'] >= (3 * $USER['achievement_build_2']) + 3){
			$metal_reward_am = 7;
			$metal_reward_points = 1;
			$next_level = $USER['achievement_build_2'] + 1;
			$metal_reward_am = min(20000,round($metal_reward_am * pow(1.36, $USER['achievement_build_2'])));
			$metal_reward_points = min(20000,round($metal_reward_points * pow(1.385, $USER['achievement_build_2'])));
			$sql	= "UPDATE %%USERS%% SET achievement_build_2 = achievement_build_2 + :achievement_build_2, achievement_build_2_points = achievement_build_2_points + :achievement_build_2_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			database::get()->update($sql, array(
				':achievement_build_2'	=> 1,
				':achievement_build_2_points'	=> $metal_reward_points,
				':achievement_point'	=> $metal_reward_points,
				':darkmatter'	=> $metal_reward_am,
				':userId'				=> $USER['id']

			));
			$msg = '<a href="game.php?page=achievement&amp;group=build#ach_crystal_mine"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_crystal_mine.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_76'], pretty_number($next_level)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($metal_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($metal_reward_points).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($USER['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
		//END
		//ACHIEVEMENT BUILD DEUTERIUM
		$sql	= 'SELECT deuterium_sintetizer FROM %%PLANETS%% WHERE id_owner = :id_owner ORDER BY deuterium_sintetizer DESC LIMIT :limit';
		$onlineDatas	= Database::get()->selectSingle($sql, array(
			':id_owner'	=> $USER['id'],
			':limit'	=> 1
		));
		if ($onlineDatas['deuterium_sintetizer'] >= (3 * $USER['achievement_build_3']) + 3){
			$metal_reward_am = 7;
			$metal_reward_points = 2;
			$next_level = $USER['achievement_build_3'] + 1;
			$metal_reward_am = min(20000,round($metal_reward_am * pow(1.40, $USER['achievement_build_3'])));
			$metal_reward_points = min(20000,round($metal_reward_points * pow(1.3834, $USER['achievement_build_3'])));
			$sql	= "UPDATE %%USERS%% SET achievement_build_3 = achievement_build_3 + :achievement_build_3, achievement_build_3_points = achievement_build_3_points + :achievement_build_3_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			database::get()->update($sql, array(
				':achievement_build_3'	=> 1,
				':achievement_build_3_points'	=> $metal_reward_points,
				':achievement_point'	=> $metal_reward_points,
				':darkmatter'	=> $metal_reward_am,
				':userId'				=> $USER['id']

			));
			$msg = '<a href="game.php?page=achievement&amp;group=build#ach_deuterium_sintetizer"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_deuterium_sintetizer.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_77'], pretty_number($next_level)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($metal_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($metal_reward_points).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($USER['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
		//END
		//ACHIEVEMENT BUILD UNIVERSITY
		$sql	= 'SELECT university FROM %%PLANETS%% WHERE id_owner = :id_owner ORDER BY university DESC LIMIT :limit';
		$onlineDatas	= Database::get()->selectSingle($sql, array(
			':id_owner'	=> $USER['id'],
			':limit'	=> 1
		));
		if ($onlineDatas['university'] >= (2 * $USER['achievement_build_7']) + 2){
			$metal_reward_am = 80;
			$metal_reward_points = 30;
			$next_level = $USER['achievement_build_7'] + 1;
			$metal_reward_am = min(20000,round($metal_reward_am * pow(1.55, $USER['achievement_build_7'])));
			$metal_reward_points = min(20000,round($metal_reward_points * pow(1.55, $USER['achievement_build_7'])));
			$sql	= "UPDATE %%USERS%% SET achievement_build_7 = achievement_build_7 + :achievement_build_7, achievement_build_7_points = achievement_build_7_points + :achievement_build_7_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			database::get()->update($sql, array(
				':achievement_build_7'	=> 1,
				':achievement_build_7_points'	=> $metal_reward_points,
				':achievement_point'	=> $metal_reward_points,
				':darkmatter'	=> $metal_reward_am,
				':userId'				=> $USER['id']

			));
			$msg = '<a href="game.php?page=achievement&amp;group=build#ach_university"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_university.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_81'], pretty_number($next_level)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($metal_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($metal_reward_points).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($USER['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
		//END
		//ACHIEVEMENT BUILD LUNAR
		$sql	= 'SELECT mondbasis FROM %%PLANETS%% WHERE id_owner = :id_owner ORDER BY mondbasis DESC LIMIT :limit';
		$onlineDatas	= Database::get()->selectSingle($sql, array(
			':id_owner'	=> $USER['id'],
			':limit'	=> 1
		));
		if ($onlineDatas['mondbasis'] >= (2 * $USER['achievement_build_8']) + 2){
			$metal_reward_am = 35;
			$metal_reward_points = 6;
			$next_level = $USER['achievement_build_8'] + 1;
			$metal_reward_am = min(20000,round($metal_reward_am * pow(1.30, $USER['achievement_build_8'])));
			$metal_reward_points = min(20000,round($metal_reward_points * pow(1.315, $USER['achievement_build_8'])));
			$sql	= "UPDATE %%USERS%% SET achievement_build_8 = achievement_build_8 + :achievement_build_8, achievement_build_8_points = achievement_build_8_points + :achievement_build_8_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			database::get()->update($sql, array(
				':achievement_build_8'	=> 1,
				':achievement_build_8_points'	=> $metal_reward_points,
				':achievement_point'	=> $metal_reward_points,
				':darkmatter'	=> $metal_reward_am,
				':userId'				=> $USER['id']

			));
			$msg = '<a href="game.php?page=achievement&amp;group=build#ach_mondbasis"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_mondbasis.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_82'], pretty_number($next_level)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($metal_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($metal_reward_points).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($USER['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
		//END
		//ACHIEVEMENT BUILD PHAKANX
		$sql	= 'SELECT phalanx FROM %%PLANETS%% WHERE id_owner = :id_owner ORDER BY phalanx DESC LIMIT :limit';
		$onlineDatas	= Database::get()->selectSingle($sql, array(
			':id_owner'	=> $USER['id'],
			':limit'	=> 1
		));
		if ($onlineDatas['phalanx'] >= (2 * $USER['achievement_build_9']) + 2){
			$metal_reward_am = 80;
			$metal_reward_points = 8;
			$next_level = $USER['achievement_build_9'] + 1;
			$metal_reward_am = min(20000,round($metal_reward_am * pow(1.40, $USER['achievement_build_9'])));
			$metal_reward_points = min(20000,round($metal_reward_points * pow(1.40, $USER['achievement_build_9'])));
			$sql	= "UPDATE %%USERS%% SET achievement_build_9 = achievement_build_9 + :achievement_build_9, achievement_build_9_points = achievement_build_9_points + :achievement_build_9_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			database::get()->update($sql, array(
				':achievement_build_9'	=> 1,
				':achievement_build_9_points'	=> $metal_reward_points,
				':achievement_point'	=> $metal_reward_points,
				':darkmatter'	=> $metal_reward_am,
				':userId'				=> $USER['id']

			));
			$msg = '<a href="game.php?page=achievement&amp;group=build#ach_phalanx"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_phalanx.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_83'], pretty_number($next_level)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($metal_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($metal_reward_points).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($USER['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
		//END
		//ACHIEVEMENT BUILD TERRAFORMER
		$sql	= 'SELECT terraformer FROM %%PLANETS%% WHERE id_owner = :id_owner ORDER BY terraformer DESC LIMIT :limit';
		$onlineDatas	= Database::get()->selectSingle($sql, array(
			':id_owner'	=> $USER['id'],
			':limit'	=> 1
		));
		if ($onlineDatas['terraformer'] >= (2 * $USER['achievement_build_10']) + 2){
			$metal_reward_am = 40;
			$metal_reward_points = 7;
			$next_level = $USER['achievement_build_10'] + 1;
			$metal_reward_am = min(20000,round($metal_reward_am * pow(1.30, $USER['achievement_build_10'])));
			$metal_reward_points = min(20000,round($metal_reward_points * pow(1.315, $USER['achievement_build_10'])));
			$sql	= "UPDATE %%USERS%% SET achievement_build_10 = achievement_build_10 + :achievement_build_10, achievement_build_10_points = achievement_build_10_points + :achievement_build_10_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			database::get()->update($sql, array(
				':achievement_build_10'	=> 1,
				':achievement_build_10_points'	=> $metal_reward_points,
				':achievement_point'	=> $metal_reward_points,
				':darkmatter'	=> $metal_reward_am,
				':userId'				=> $USER['id']

			));
			$msg = '<a href="game.php?page=achievement&amp;group=build#ach_terraformer"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_terraformer.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_84'], pretty_number($next_level)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($metal_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($metal_reward_points).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($USER['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
		//END
		
		//ACHIEVEMENT TECH SPY
		if ($USER['spy_tech'] >= (3 * $USER['achievement_tech_1']) + 3){
			$metal_reward_am = 70;
			$metal_reward_points = 55;
			$next_level = $USER['achievement_tech_1'] + 1;
			$metal_reward_am = min(20000,round($metal_reward_am * pow(1.30, $USER['achievement_tech_1'])));
			$metal_reward_points = min(20000,round($metal_reward_points * pow(1.30, $USER['achievement_tech_1'])));
			$sql	= "UPDATE %%USERS%% SET achievement_tech_1 = achievement_tech_1 + :achievement_tech_1, achievement_tech_1_points = achievement_tech_1_points + :achievement_tech_1_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			database::get()->update($sql, array(
				':achievement_tech_1'	=> 1,
				':achievement_tech_1_points'	=> $metal_reward_points,
				':achievement_point'	=> $metal_reward_points,
				':darkmatter'	=> $metal_reward_am,
				':userId'				=> $USER['id']

			));
			$msg = '<a href="game.php?page=achievement&amp;group=tech#ach_spy_tech"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_spy_tech.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_105'], pretty_number($next_level)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($metal_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($metal_reward_points).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($USER['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
		//END
		//ACHIEVEMENT TECH COMPUTER
		if ($USER['computer_tech'] >= (3 * $USER['achievement_tech_2']) + 3){
			$metal_reward_am = 70;
			$metal_reward_points = 55;
			$next_level = $USER['achievement_tech_2'] + 1;
			$metal_reward_am = min(20000,round($metal_reward_am * pow(1.30, $USER['achievement_tech_2'])));
			$metal_reward_points = min(20000,round($metal_reward_points * pow(1.30, $USER['achievement_tech_2'])));
			$sql	= "UPDATE %%USERS%% SET achievement_tech_2 = achievement_tech_2 + :achievement_tech_2, achievement_tech_2_points = achievement_tech_2_points + :achievement_tech_2_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			database::get()->update($sql, array(
				':achievement_tech_2'	=> 1,
				':achievement_tech_2_points'	=> $metal_reward_points,
				':achievement_point'	=> $metal_reward_points,
				':darkmatter'	=> $metal_reward_am,
				':userId'				=> $USER['id']

			));
			$msg = '<a href="game.php?page=achievement&amp;group=tech#ach_computer_tech"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_computer_tech.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_106'], pretty_number($next_level)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($metal_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($metal_reward_points).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($USER['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
		//END
		//ACHIEVEMENT TECH COMBAT TECH
		if ($USER['military_tech'] >= (2 * $USER['achievement_tech_3']) + 2 && $USER['defence_tech'] >= (2 * $USER['achievement_tech_3']) + 2 && $USER['shield_tech'] >= (2 * $USER['achievement_tech_3']) + 2){
			$metal_reward_am = 20;
			$metal_reward_points = 15;
			$next_level = $USER['achievement_tech_3'] + 1;
			$metal_reward_am = min(20000,round($metal_reward_am * pow(1.30, $USER['achievement_tech_3'])));
			$metal_reward_points = min(20000,round($metal_reward_points * pow(1.30, $USER['achievement_tech_3'])));
			$sql	= "UPDATE %%USERS%% SET achievement_tech_3 = achievement_tech_3 + :achievement_tech_3, achievement_tech_3_points = achievement_tech_3_points + :achievement_tech_3_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			database::get()->update($sql, array(
				':achievement_tech_3'	=> 1,
				':achievement_tech_3_points'	=> $metal_reward_points,
				':achievement_point'	=> $metal_reward_points,
				':darkmatter'	=> $metal_reward_am,
				':userId'				=> $USER['id']

			));
			$msg = '<a href="game.php?page=achievement&amp;group=tech#ach_war_tech"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_war_tech.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_107'], pretty_number($next_level)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($metal_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($metal_reward_points).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($USER['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
		//END
		//ACHIEVEMENT TECH EXPEDITION
		if ($USER['expedition_tech'] >= (4 * $USER['achievement_tech_4']) + 4){
			$metal_reward_am = 65;
			$metal_reward_points = 45;
			$next_level = $USER['achievement_tech_4'] + 1;
			$metal_reward_am = min(20000,round($metal_reward_am * pow(1.55, $USER['achievement_tech_4'])));
			$metal_reward_points = min(20000,round($metal_reward_points * pow(1.55, $USER['achievement_tech_4'])));
			$sql	= "UPDATE %%USERS%% SET achievement_tech_4 = achievement_tech_4 + :achievement_tech_4, achievement_tech_4_points = achievement_tech_4_points + :achievement_tech_4_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			database::get()->update($sql, array(
				':achievement_tech_4'	=> 1,
				':achievement_tech_4_points'	=> $metal_reward_points,
				':achievement_point'	=> $metal_reward_points,
				':darkmatter'	=> $metal_reward_am,
				':userId'				=> $USER['id']

			));
			$msg = '<a href="game.php?page=achievement&amp;group=tech#ach_expedition_tech"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_expedition_tech.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_108'], pretty_number($next_level)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($metal_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($metal_reward_points).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($USER['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
		//END
		//ACHIEVEMENT TECH GRAVITON
		if ($USER['graviton_tech'] >= (4 * $USER['achievement_tech_5']) + 4 && $USER['achievement_tech_5'] < 20){
			$metal_reward_am = 35;
			$metal_reward_points = 25;
			$next_level = $USER['achievement_tech_5'] + 1;
			$metal_reward_am = min(20000,round($metal_reward_am * pow(1.40, $USER['achievement_tech_5'])));
			$metal_reward_points = min(20000,round($metal_reward_points * pow(1.40, $USER['achievement_tech_5'])));
			$sql	= "UPDATE %%USERS%% SET achievement_tech_5 = achievement_tech_5 + :achievement_tech_5, achievement_tech_5_points = achievement_tech_5_points + :achievement_tech_5_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			database::get()->update($sql, array(
				':achievement_tech_5'	=> 1,
				':achievement_tech_5_points'	=> $metal_reward_points,
				':achievement_point'	=> $metal_reward_points,
				':darkmatter'	=> $metal_reward_am,
				':userId'				=> $USER['id']
			));
			$msg = '<a href="game.php?page=achievement&amp;group=tech#ach_gravity_tech"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_gravity_tech.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_109'], pretty_number($next_level)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($metal_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($metal_reward_points).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($USER['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
		//END
		//ACHIEVEMENT TECH GUNS
		if ($USER['laser_tech'] >= (2 * $USER['achievement_tech_6']) + 2 && $USER['ionic_tech'] >= (2 * $USER['achievement_tech_6']) + 2 && $USER['buster_tech'] >= (2 * $USER['achievement_tech_6']) + 2){
			$metal_reward_am = 45;
			$metal_reward_points = 30;
			$next_level = $USER['achievement_tech_6'] + 1;
			$metal_reward_am = min(20000,round($metal_reward_am * pow(1.40, $USER['achievement_tech_6'])));
			$metal_reward_points = min(20000,round($metal_reward_points * pow(1.40, $USER['achievement_tech_6'])));
			$sql	= "UPDATE %%USERS%% SET achievement_tech_6 = achievement_tech_6 + :achievement_tech_6, achievement_tech_6_points = achievement_tech_6_points + :achievement_tech_6_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			database::get()->update($sql, array(
				':achievement_tech_6'	=> 1,
				':achievement_tech_6_points'	=> $metal_reward_points,
				':achievement_point'	=> $metal_reward_points,
				':darkmatter'	=> $metal_reward_am,
				':userId'				=> $USER['id']
			));
			$msg = '<a href="game.php?page=achievement&amp;group=tech#ach_gun_tech"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_gun_tech.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_110'], pretty_number($next_level)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($metal_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($metal_reward_points).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($USER['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
		//END
		//ACHIEVEMENT TECH ENERGY
		if ($USER['energy_tech'] >= (3 * $USER['achievement_tech_7']) + 3){
			$metal_reward_am = 30;
			$metal_reward_points = 20;
			$next_level = $USER['achievement_tech_7'] + 1;
			$metal_reward_am = min(20000,round($metal_reward_am * pow(1.45, $USER['achievement_tech_7'])));
			$metal_reward_points = min(20000,round($metal_reward_points * pow(1.45, $USER['achievement_tech_7'])));
			$sql	= "UPDATE %%USERS%% SET achievement_tech_7 = achievement_tech_7 + :achievement_tech_7, achievement_tech_7_points = achievement_tech_7_points + :achievement_tech_7_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			database::get()->update($sql, array(
				':achievement_tech_7'	=> 1,
				':achievement_tech_7_points'	=> $metal_reward_points,
				':achievement_point'	=> $metal_reward_points,
				':darkmatter'	=> $metal_reward_am,
				':userId'				=> $USER['id']
			));
			$msg = '<a href="game.php?page=achievement&amp;group=tech#ach_energy_tech"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_energy_tech.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_111'], pretty_number($next_level)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($metal_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($metal_reward_points).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($USER['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
		//END
		//ACHIEVEMENT TECH SPEED
		if ($USER['combustion_tech'] >= (2 * $USER['achievement_tech_9']) + 2 && $USER['impulse_motor_tech'] >= (2 * $USER['achievement_tech_9']) + 2 && $USER['hyperspace_motor_tech'] >= (2 * $USER['achievement_tech_9']) + 2){
			$metal_reward_am = 25;
			$metal_reward_points = 20;
			$next_level = $USER['achievement_tech_9'] + 1;
			$metal_reward_am = min(20000,round($metal_reward_am * pow(1.40, $USER['achievement_tech_9'])));
			$metal_reward_points = min(20000,round($metal_reward_points * pow(1.40, $USER['achievement_tech_9'])));
			$sql	= "UPDATE %%USERS%% SET achievement_tech_9 = achievement_tech_9 + :achievement_tech_9, achievement_tech_9_points = achievement_tech_9_points + :achievement_tech_9_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			database::get()->update($sql, array(
				':achievement_tech_9'	=> 1,
				':achievement_tech_9_points'	=> $metal_reward_points,
				':achievement_point'	=> $metal_reward_points,
				':darkmatter'	=> $metal_reward_am,
				':userId'				=> $USER['id']
			));
			$msg = '<a href="game.php?page=achievement&amp;group=tech#ach_motor_tech"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_motor_tech.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_113'], pretty_number($next_level)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($metal_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($metal_reward_points).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($USER['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
		//END
		//ACHIEVEMENT TECH PROD
		if ($USER['metal_proc_tech'] >= (2 * $USER['achievement_tech_10']) + 2 && $USER['crystal_proc_tech'] >= (2 * $USER['achievement_tech_10']) + 2 && $USER['deuterium_proc_tech'] >= (2 * $USER['achievement_tech_10']) + 2){
			$metal_reward_am = 20;
			$metal_reward_points = 13;
			$next_level = $USER['achievement_tech_10'] + 1;
			$metal_reward_am = min(20000,round($metal_reward_am * pow(1.30, $USER['achievement_tech_10'])));
			$metal_reward_points = min(20000,round($metal_reward_points * pow(1.30, $USER['achievement_tech_10'])));
			$sql	= "UPDATE %%USERS%% SET achievement_tech_10 = achievement_tech_10 + :achievement_tech_10, achievement_tech_10_points = achievement_tech_10_points + :achievement_tech_10_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			database::get()->update($sql, array(
				':achievement_tech_10'	=> 1,
				':achievement_tech_10_points'	=> $metal_reward_points,
				':achievement_point'	=> $metal_reward_points,
				':darkmatter'	=> $metal_reward_am,
				':userId'				=> $USER['id']
			));
			$msg = '<a href="game.php?page=achievement&amp;group=tech#ach_mining_tech"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_mining_tech.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_114'], pretty_number($next_level)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($metal_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($metal_reward_points).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($USER['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
		//END
		
	}


	public function getAllianceTag($allianceID){
		$db	= Database::get();
		$sql	= 'SELECT * FROM %%ALLIANCE%% WHERE id = :allianceID;';
		$diploRow = $db->selectSingle($sql, array(
			':allianceID'		=> $allianceID,
		));
		return $diploRow['ally_tag'];
	}


}
