<?php

/**
 * 2Moons
 * by Jan-Otto Kröpke and Danter14 2009-2018
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2018 Danter14 <danter14000@gmail.com>
 *@copyright 2020 YamilRH <ireadigos@gmail.com>
 * @licence MIT
 * @version 2.6.0
 * @link https://github.com/jkroepke/2Moons
 **/

if (isset($_POST['GLOBALS']) || isset($_GET['GLOBALS'])) {
	exit('You cannot set the GLOBALS-array from outside the script.');
}

$composerAutoloader = __DIR__.'/../vendor/autoload.php';

if (file_exists($composerAutoloader)) {
    require $composerAutoloader;
}

if (function_exists('mb_internal_encoding')) {
	mb_internal_encoding("UTF-8");
}

ignore_user_abort(true);
error_reporting(E_ALL & ~E_STRICT);

// If date.timezone is invalid
date_default_timezone_set(@date_default_timezone_get());

ini_set('display_errors', 1);
header('Content-Type: text/html; charset=UTF-8');
define('TIMESTAMP',	time());
	
require 'includes/constants.php';

ini_set('log_errors', 'On');
ini_set('error_log', ROOT_PATH.'errores/'.date('Y_m_d').'_error.log');

require 'includes/GeneralFunctions.php';
set_exception_handler('exceptionHandler');
set_error_handler('errorHandler');

// if(!is_dir(CACHE_PATH.'sessions'))
//     mkdir(CACHE_PATH.'sessions',0755);
    
// ini_set('session.save_path', CACHE_PATH.'sessions');
// ini_set('upload_tmp_dir', CACHE_PATH.'sessions');

require 'includes/classes/ArrayUtil.class.php';
require 'includes/classes/Cache.class.php';
require 'includes/classes/Database.class.php';
require 'includes/classes/Config.class.php';
require 'includes/classes/class.FleetFunctions.php';
require 'includes/classes/HTTP.class.php';
require 'includes/classes/Language.class.php';
require 'includes/classes/PlayerUtil.class.php';
require 'includes/classes/Session.class.php';
require 'includes/classes/Universe.class.php';
require 'includes/classes/Limit.class.php';

require 'includes/classes/class.theme.php';
require 'includes/classes/class.template.php';

require 'includes/classes/class.Flash.php';

// Say Browsers to Allow ThirdParty Cookies (Thanks to morktadela)
HTTP::sendHeader('P3P', 'CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
define('AJAX_REQUEST', HTTP::_GP('ajax', 0));

$THEME		= new Theme();

if (MODE === 'INSTALL')
{
	return;
}

if(!file_exists('includes/config.php') || filesize('includes/config.php') === 0) {
	HTTP::redirectTo('install/index.php');
}

try {
    $sql	= "SELECT dbVersion FROM %%SYSTEM%%;";

    $dbVersion	= Database::get()->selectSingle($sql, array(), 'dbVersion');

    $dbNeedsUpgrade = $dbVersion < DB_VERSION_REQUIRED;
} catch (Exception $e) {
    $dbNeedsUpgrade = true;
}

if ($dbNeedsUpgrade) {
    HTTP::redirectTo('install/index.php?mode=upgrade');
}

if(defined('DATABASE_VERSION') && DATABASE_VERSION === 'OLD')
{
	/* For our old Admin panel */
	require 'includes/classes/Database_BC.class.php';
	$DATABASE	= new Database_BC();
	
	$dbTableNames	= Database::get()->getDbTableNames();
	$dbTableNames	= array_combine($dbTableNames['keys'], $dbTableNames['names']);
	
	foreach($dbTableNames as $dbAlias => $dbName)
	{
		define(substr($dbAlias, 2, -2), $dbName);
	}	
}

$config = Config::get();
date_default_timezone_set($config->timezone);

if (MODE === 'INGAME' || MODE === 'ADMIN' || MODE === 'CRON')
{
	$session	= Session::load();

	if(!$session->isValidSession())
	{
	    $session->delete();
		HTTP::redirectTo('index.php?code=3');
	}

	require 'includes/vars.php';
	require 'includes/classes/class.BuildFunctions.php';
	require 'includes/classes/class.PlanetRessUpdate.php';
	
	if(!AJAX_REQUEST && MODE === 'INGAME' && isModuleAvailable(MODULE_FLEET_EVENTS)) {
		require('includes/FleetHandler.php');
	}
	
	$db		= Database::get();

	$sql	= "SELECT 
	user.*,
	COUNT(message.message_id) as messages
	FROM %%USERS%% as user
	LEFT JOIN %%MESSAGES%% as message ON message.message_owner = user.id AND message.message_unread = :unread
	WHERE user.id = :userId
	GROUP BY message.message_owner;";
	
	$USER	= $db->selectSingle($sql, array(
		':unread'	=> 1,
		':userId'	=> $session->userId
	));
	
	if(empty($USER))
	{
		HTTP::redirectTo('index.php?code=3');
	}
	
	$LNG	= new Language($USER['lang']);
	$LNG->includeData(array('L18N', 'INGAME', 'TECH', 'CUSTOM', 'FRACTION', 'MODs'));
	$THEME->setUserTheme($USER['dpath']);
	
	if($config->game_disable == 0 && $USER['authlevel'] == AUTH_USR) {
		ShowErrorPage::printError($LNG['sys_closed_game'].'<br><br>'.$config->close_reason, false);
	}

	if($USER['bana'] == 1) {
		ShowErrorPage::printError("<font size=\"6px\">".$LNG['css_account_banned_message']."</font><br><br>".sprintf($LNG['css_account_banned_expire'], _date($LNG['php_tdformat'], $USER['banaday'], $USER['timezone']))."<br><br>".$LNG['css_goto_homeside'], false);
	}
	
	if (MODE === 'INGAME')
	{

		require 'includes/classes/class.Logcheck.php';
		$universeAmount	= count(Universe::availableUniverses());
		if(Universe::current() != $USER['universe'] && $universeAmount > 1)
		{
			HTTP::redirectToUniverse($USER['universe']);
		}

		$session->selectActivePlanet();

		$sql	= "SELECT * FROM %%PLANETS%% WHERE id = :planetId;";
		$PLANET	= $db->selectSingle($sql, array(
			':planetId'	=> $session->planetId,
		));

		if(empty($PLANET))
		{
			$sql	= "SELECT * FROM %%PLANETS%% WHERE id = :planetId;";
			$PLANET	= $db->selectSingle($sql, array(
				':planetId'	=> $USER['id_planet'],
			));
			
			if(empty($PLANET))
			{
				throw new Exception("Main Planet does not exist!");
			}
			else
			{
				$session->planetId = $USER['id_planet'];
			}
		}
		
		$USER['factor']		= getFactors($USER);
		$USER['PLANETS']	= getPlanets($USER);
	}
	elseif (MODE === 'ADMIN')
	{
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		
		$USER['rights']		= unserialize($USER['rights']);
		$LNG->includeData(array('ADMIN', 'CUSTOM'));
	}
}
elseif(MODE === 'LOGIN')
{
	$LNG	= new Language();
	$LNG->getUserAgentLanguage();
	$LNG->includeData(array('L18N', 'INGAME', 'PUBLIC', 'CUSTOM'));
}
elseif(MODE === 'CHAT')
{
	$session	= Session::load();

	if(!$session->isValidSession())
	{
		HTTP::redirectTo('index.php?code=3');
	}
}


// funcion para devolver la imagen con el rango del usuario para llamarla solo
// {imageRango($RangeInfo.points)}
// donde $RangeInfo.points son los puntos 
///styles/theme/gow/gebaeude/{$ID}.gif
function imageRango($puntos)
{
	if($puntos<=900000)
		return '<img src="./styles/theme/gow/rangos/s1.png" class="tooltip" data-tooltip-content="Novato">';

	if($puntos>900000 && $puntos<=2000000)
		return '<img src="./styles/theme/gow/rangos/s2.png" class="tooltip" data-tooltip-content="Piloto Inexperto">';

	if($puntos>2000000 && $puntos<=4000000)
		return '<img src="./styles/theme/gow/rangos/s3.png" class="tooltip" data-tooltip-content="Piloto">';

	if($puntos>4000000 && $puntos<=6000000)
		return '<img src="./styles/theme/gow/rangos/s4.png" class="tooltip" data-tooltip-content="Piloto Intermedio">';

	if($puntos>6000000 && $puntos<=8000000)
		return '<img src="./styles/theme/gow/rangos/s5.png" class="tooltip" data-tooltip-content="Piloto Medio">';

	if($puntos>8000000 && $puntos<=10000000)
		return '<img src="./styles/theme/gow/rangos/s6.png" class="tooltip" data-tooltip-content="Piloto Avanzado">';

	if($puntos>10000000 && $puntos<=30000000)
		return '<img src="./styles/theme/gow/rangos/s7.png" class="tooltip" data-tooltip-content="Cazador">';

	if($puntos>30000000 && $puntos<=50000000)
		return '<img src="./styles/theme/gow/rangos/s8.png" class="tooltip" data-tooltip-content="Cazador Intermedio">';

	if($puntos>50000000 && $puntos<=70000000)
		return '<img src="./styles/theme/gow/rangos/s9.png" class="tooltip" data-tooltip-content="Cazador Medio">';

	if($puntos>70000000 && $puntos<=90000000)
		return '<img src="./styles/theme/gow/rangos/s10.png" class="tooltip" data-tooltip-content="Cazador Avanzado">';

	if($puntos>90000000 && $puntos<=200000000)
		return '<img src="./styles/theme/gow/rangos/s11.png" class="tooltip" data-tooltip-content="Furia-Oscura">';

	if($puntos>200000000 && $puntos<=400000000)
		return '<img src="./styles/theme/gow/rangos/s12.png" class="tooltip" data-tooltip-content="Escurridizo">';

	if($puntos>400000000 && $puntos<=600000000)
		return '<img src="./styles/theme/gow/rangos/s13.png" class="tooltip" data-tooltip-content="Asesino">';

	if($puntos>600000000 && $puntos<=800000000)
		return '<img src="./styles/theme/gow/rangos/s14.png" class="tooltip" data-tooltip-content="Sniper">';

	if($puntos>800000000 && $puntos<=900000000)
		return '<img src="./styles/theme/gow/rangos/s15.png" class="tooltip" data-tooltip-content="Depredador">';

	if($puntos>900000000)
		return '<img src="./styles/theme/gow/rangos/s16.png " class="tooltip" data-tooltip-content="Despedazador">';

	/*if($puntos>50 && $puntos<=100)905.639.663
		return '<img src="./styles/theme/gow/rangos/s1.gif" class="tooltip" data-tooltip-content="">';*/
}


function imageApodo($puntos)
{
	if($puntos<=900000)
		return '<img src="./styles/theme/gow/rangos/s1.png" class="tooltip" data-tooltip-content="Rango: Novato">';

	if($puntos>900000 && $puntos<=2000000)
		return '<img src="./styles/theme/gow/rangos/s2.png" class="tooltip" data-tooltip-content="Rango: Piloto Inexperto">';

	if($puntos>2000000 && $puntos<=4000000)
		return '<img src="./styles/theme/gow/rangos/s3.png" class="tooltip" data-tooltip-content="Rango: Piloto">';

	if($puntos>4000000 && $puntos<=6000000)
		return '<img src="./styles/theme/gow/rangos/s4.png" class="tooltip" data-tooltip-content="Rango: Piloto Intermedio">';

	if($puntos>6000000 && $puntos<=8000000)
		return '<img src="./styles/theme/gow/rangos/s5.png" class="tooltip" data-tooltip-content="Rango: Piloto Medio">';

	if($puntos>8000000 && $puntos<=10000000)
		return '<img src="./styles/theme/gow/rangos/s6.png" class="tooltip" data-tooltip-content="Rango: Piloto Avanzado">';

	if($puntos>10000000 && $puntos<=30000000)
		return '<img src="./styles/theme/gow/rangos/s7.png" class="tooltip" data-tooltip-content="Rango: Cazador">';

	if($puntos>30000000 && $puntos<=50000000)
		return '<img src="./styles/theme/gow/rangos/s8.png" class="tooltip" data-tooltip-content="Rango: Cazador Intermedio">';

	if($puntos>50000000 && $puntos<=70000000)
		return '<img src="./styles/theme/gow/rangos/s9.png" class="tooltip" data-tooltip-content="Rango: Cazador Medio">';

	if($puntos>70000000 && $puntos<=90000000)
		return '<img src="./styles/theme/gow/rangos/s10.png" class="tooltip" data-tooltip-content="Rango: Cazador Avanzado">';

	if($puntos>90000000 && $puntos<=200000000)
		return '<img src="./styles/theme/gow/rangos/s11.png" class="tooltip" data-tooltip-content="Rango: Furia-Oscura">';

	if($puntos>200000000 && $puntos<=400000000)
		return '<img src="./styles/theme/gow/rangos/s12.png" class="tooltip" data-tooltip-content="Rango: Escurridizo">';

	if($puntos>400000000 && $puntos<=600000000)
		return '<img src="./styles/theme/gow/rangos/s13.png" class="tooltip" data-tooltip-content="Rango: Asesino">';

	if($puntos>600000000 && $puntos<=800000000)
		return '<img src="./styles/theme/gow/rangos/s14.png" class="tooltip" data-tooltip-content="Rango: Sniper">';

	if($puntos>800000000 && $puntos<=900000000)
		return '<img src="./styles/theme/gow/rangos/s15.png" class="tooltip" data-tooltip-content="Rango: Depredador">';

	if($puntos>900000000)
		return '<img src="./styles/theme/gow/rangos/s16.png " class="tooltip" data-tooltip-content="Rango: Despedazador">';

	/*if($puntos>50 && $puntos<=100)905.639.663
		return '<img src="./styles/theme/gow/rangos/s1.gif" class="tooltip" data-tooltip-content="Rango: ">';*/
}

function imageRaptor($puntos)
{
	if($puntos<=900000)
		return '<img src="./styles/theme/gow/rangos/s1.png" class="tooltip" width="65px" heith="65px" data-tooltip-content="Rango: Novato">';

	if($puntos>900000 && $puntos<=2000000)
		return '<img src="./styles/theme/gow/rangos/s2.png" class="tooltip" width="65px" heith="65px"  data-tooltip-content="Rango: Piloto Inexperto">';

	if($puntos>2000000 && $puntos<=4000000)
		return '<img src="./styles/theme/gow/rangos/s3.png" class="tooltip" width="65px" heith="65px"  data-tooltip-content="Rango: Piloto">';

	if($puntos>4000000 && $puntos<=6000000)
		return '<img src="./styles/theme/gow/rangos/s4.png" class="tooltip" width="65px" heith="65px"  data-tooltip-content="Rango: Piloto Intermedio">';

	if($puntos>6000000 && $puntos<=8000000)
		return '<img src="./styles/theme/gow/rangos/s5.png" class="tooltip" width="65px" heith="65px"  data-tooltip-content="Rango: Piloto Medio">';

	if($puntos>8000000 && $puntos<=10000000)
		return '<img src="./styles/theme/gow/rangos/s6.png" class="tooltip" width="65px" heith="65px"  data-tooltip-content="Rango: Piloto Avanzado">';

	if($puntos>10000000 && $puntos<=30000000)
		return '<img src="./styles/theme/gow/rangos/s7.png" class="tooltip" width="65px" heith="65px"  data-tooltip-content="Rango: Cazador">';

	if($puntos>30000000 && $puntos<=50000000)
		return '<img src="./styles/theme/gow/rangos/s8.png" class="tooltip" width="65px" heith="65px"  data-tooltip-content="Rango: Cazador Intermedio">';

	if($puntos>50000000 && $puntos<=70000000)
		return '<img src="./styles/theme/gow/rangos/s9.png" class="tooltip" width="65px" heith="65px"  data-tooltip-content="Rango: Cazador Medio">';

	if($puntos>70000000 && $puntos<=90000000)
		return '<img src="./styles/theme/gow/rangos/s10.png" class="tooltip" width="65px" heith="65px"  data-tooltip-content="Rango: Cazador Avanzado">';

	if($puntos>90000000 && $puntos<=200000000)
		return '<img src="./styles/theme/gow/rangos/s11.png" class="tooltip" width="65px" heith="65px"  data-tooltip-content="Rango: Furia-Oscura">';

	if($puntos>200000000 && $puntos<=400000000)
		return '<img src="./styles/theme/gow/rangos/s12.png" class="tooltip" width="65px" heith="65px"  data-tooltip-content="Rango: Escurridizo">';

	if($puntos>400000000 && $puntos<=600000000)
		return '<img src="./styles/theme/gow/rangos/s13.png" class="tooltip" width="65px" heith="65px"  data-tooltip-content="Rango: Asesino">';

	if($puntos>600000000 && $puntos<=800000000)
		return '<img src="./styles/theme/gow/rangos/s14.png" class="tooltip" width="65px" heith="65px"  data-tooltip-content="Rango: Sniper">';

	if($puntos>800000000 && $puntos<=900000000)
		return '<img src="./styles/theme/gow/rangos/s15.png" class="tooltip" width="65px" heith="65px"  data-tooltip-content="Rango: Depredador">';

	if($puntos>900000000)
		return '<img src="./styles/theme/gow/rangos/s16.png " class="tooltip" width="65px" heith="65px"  data-tooltip-content="Rango: Despedazador">';

	/*if($puntos>50 && $puntos<=100)905.639.663
		return '<img src="./styles/theme/gow/rangos/s1.gif" class="tooltip" data-tooltip-content="Rango: ">';*/
}

function imageAlianza($puntos)
{
	if($puntos<=500000)
		return '<img src="./styles/theme/gow/rangos/alianza/ach_wons_day.png" class="tooltip" data-tooltip-content="Rango: Novato">';

	if($puntos>500000 && $puntos<=900000)
		return '<img src="./styles/theme/gow/rangos/alianza/ach_wons_em_1_day.png" class="tooltip" data-tooltip-content="Rango: Piloto Inexperto">';

	if($puntos>900000 && $puntos<=10000000)
		return '<img src="./styles/theme/gow/rangos/alianza/ach_wons_em_2_day.png" class="tooltip" data-tooltip-content="Rango: Piloto">';

	if($puntos>10000000 && $puntos<=90000000)
		return '<img src="./styles/theme/gow/rangos/alianza/ach_wons_em_3_day.png" class="tooltip" data-tooltip-content="Rango: Piloto Intermedio">';

	if($puntos>90000000 && $puntos<=100000000)
		return '<img src="./styles/theme/gow/rangos/alianza/ach_wons_em_4_day.png" class="tooltip" data-tooltip-content="Rango: Piloto Medio">';

	if($puntos>100000000 && $puntos<=900000000)
		return '<img src="./styles/theme/gow/rangos/alianza/ach_wons_em_5_day.png" class="tooltip" data-tooltip-content="Rango: Piloto Avanzado">';
	
	if($puntos>900000000)
		return '<img src="./styles/theme/gow/rangos/alianza/ach_wons_em_6_day.png " class="tooltip" data-tooltip-content="Rango: Despedazador">';

	/*if($puntos>50 && $puntos<=100)905.639.663
		return '<img src="./styles/theme/gow/rangos/s1.gif" class="tooltip" data-tooltip-content="Rango: ">';*/
}

	function imageRace($razas)
	    {
	        if($razas==1)
	            return '<img src="./styles/theme/gow/img/race/1.png" class="tooltip" data-tooltip-content="Pirata">';
	        if($razas==2)
	            return '<img src="./styles/theme/gow/img/race/2.png" class="tooltip" data-tooltip-content="Minero">';
	        if($razas==3)
	            return '<img src="./styles/theme/gow/img/race/3.png" class="tooltip" data-tooltip-content="Descubridor">';
	        if($razas==4)
	            return '<img src="./styles/theme/gow/img/race/4.png" class="tooltip" data-tooltip-content="Investigador">';

	    }

	    

	    function imageTOP($unidades)
	    {
	    	global $USER, $LNG;
	    	$db 	= Database::get();
	    	//Unidades destruidas
        	$desunits = 'SELECT user.desunits FROM %%USERS%% as user, %%STATPOINTS%% as stat WHERE stat.stat_type = :statType AND stat.id_owner = :userId ORDER BY user.`desunits` DESC LIMIT 1;';

        	$ydesunit = $db->select($desunits, array(
	            ':userId'   => $USER['id'],
	            ':statType' => 1
        	));

	        if($unidades == $ydesunit)
	            return '<img src="./styles/theme/gow/premios/fama.png" class="tooltip" data-tooltip-content="Mas unidad destruidas">';
	    	}

function getLanguageUser($language = NULL, $userID = NULL)
{
	if(is_null($language) && !is_null($userID))
	{
		$sql		= 'SELECT lang FROM %%USERS%% WHERE id = :userId;';
		$language	= Database::get()->selectSingle($sql, array(
			':userId' => $userID
		), 'lang');
	}
	
	$LNG		= new Language($language);
	$LNG->includeData(array('L18N', 'FLEET', 'TECH', 'CUSTOM', 'MODs'));
	return $LNG;
}
/*Logros Diarios*/

/*Expedicion exitosa cada 24h*/
function achievementSuccesDaily($ownerUser, $startId){	

		$sql	= "UPDATE %%USERS%% SET achievement_daily_2_succes = achievement_daily_2_succes + 1 WHERE id = :userId;";
		Database::get()->update($sql, array(
			':userId'						=> $ownerUser['id']
		));
		
		$actualWins 			= $ownerUser['achievement_daily_2_succes'] + 1;
		$actualNeeded 			= round(5 * pow(2.40, $ownerUser['achievement_daily_2']));
		$fighter_lvl 			= $ownerUser['achievement_daily_2'] + 1;
		$fighter_reward_am 		= round(100 * pow(1.25, $ownerUser['achievement_daily_2']));
		$fighter_reward_points 	= round(50 * pow(1.30, $ownerUser['achievement_daily_2']));
		
		if($actualWins >= $actualNeeded){
			$sql	= "UPDATE %%USERS%% SET achievement_daily_2 = achievement_daily_2 + 1, achievement_daily_2_points = achievement_daily_2_points + :achievement_daily_2_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			Database::get()->update($sql, array(
				':achievement_daily_2_points'	=> $fighter_reward_points,
				':achievement_point'			=> $fighter_reward_points,
				':darkmatter'					=> $fighter_reward_am,
				':userId'						=> $ownerUser['id']
			));
			
			$LNG		= getLanguageUser(NULL, $ownerUser['id']);
			$msg = '<a href="game.php?page=achievement&amp;group=daily#ach_expedition_day"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_expedition_day.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_51'], pretty_number($fighter_lvl)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($fighter_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($fighter_reward_points).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($ownerUser['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
	}

	function succesDailyAchievement($userID, $ownerUser, $targetUser, $combatResult, $i){
		$sql		= "SELECT MAX(total_points) as total FROM %%STATPOINTS%% WHERE `stat_type` = 1 AND `universe` = 1 AND id_owner = :id_owner;";
		$topPoints	= database::get()->selectSingle($sql, array(
			':id_owner'	=> $userID
		), 'total');

		if(500000000 < $topPoints)
			$maxFactorDestroy		= 120000000000;
		elseif(200000000 < $topPoints && 50000000 >= $topPoints)
			$maxFactorDestroy		= 60000000000;
		elseif(50000000 < $topPoints && 200000000 >= $topPoints)
			$maxFactorDestroy		= 30000000000;
		else
			$maxFactorDestroy		= 15000000000;
		
		$result = false;
		if($i == 1 && $combatResult['won'] == 'a'){			
			if(($combatResult['unitLost']['defender'] >= $maxFactorDestroy && $ownerUser['ally_id'] != $targetUser['ally_id']) || ($combatResult['unitLost']['defender'] >= $maxFactorDestroy && $ownerUser['ally_id'] == 0 && $targetUser['ally_id'] == 0)){
				$sql	= "UPDATE %%USERS%% SET achievement_daily_1_succes = achievement_daily_1_succes + 1 WHERE id = :userId;";
				database::get()->update($sql, array(
					':userId'	=> $userID
				));
				
				$actualWins 			= $ownerUser['achievement_daily_1_succes'] + 1;
				$actualNeeded 			= round(5 * pow(2.40, $ownerUser['achievement_daily_1']));
				$fighter_lvl 			= $ownerUser['achievement_daily_1'] + 1;
				$fighter_reward_am 		= round(150 * pow(1.20, $ownerUser['achievement_daily_1']));
				$fighter_reward_points 	= round(75 * pow(1.25, $ownerUser['achievement_daily_1']));
				if($actualWins >= $actualNeeded){ 
					$sql	= "UPDATE %%USERS%% SET achievement_daily_1 = achievement_daily_1 + :achievement_daily_1, achievement_daily_1_points = achievement_daily_1_points + :achievement_daily_1_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
					database::get()->update($sql, array(
						':achievement_daily_1'			=> 1,
						':achievement_daily_1_points'	=> $fighter_reward_points,
						':achievement_point'			=> $fighter_reward_points,
						':darkmatter'					=> $fighter_reward_am,
						':userId'						=> $userID
					));
					
					$LNG		= getLanguageUser(NULL, $userID);
					$msg = '<a href="game.php?page=achievement&amp;group=daily#ach_wons_day"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_wons_day.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_47'], pretty_number($fighter_lvl)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($fighter_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($fighter_reward_points).' '.$LNG['achiev_13'].'</a>';
					PlayerUtil::sendMessage($ownerUser['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
				}
				$result = true;
			}
		}elseif($i == 2 && $combatResult['won'] == 'r'){			
			if(($combatResult['unitLost']['attacker'] >= $maxFactorDestroy && $ownerUser['ally_id'] != $targetUser['ally_id']) || ($combatResult['unitLost']['attacker'] >= $maxFactorDestroy && $ownerUser['ally_id'] == 0 && $targetUser['ally_id'] == 0)){
				$sql	= "UPDATE %%USERS%% SET achievement_daily_1_succes = achievement_daily_1_succes + 1 WHERE id = :userId;";
				database::get()->update($sql, array(
					':userId'	=> $userID
				));
				
				$actualWins 			= $targetUser['achievement_daily_1_succes'] + 1;
				$actualNeeded 			= round(5 * pow(2.40, $targetUser['achievement_daily_1']));
				$fighter_lvl 			= $targetUser['achievement_daily_1'] + 1;
				$fighter_reward_am 		= round(150 * pow(1.20, $targetUser['achievement_daily_1']));
				$fighter_reward_points 	= round(75 * pow(1.25, $targetUser['achievement_daily_1']));
				if($actualWins >= $actualNeeded){
					$sql	= "UPDATE %%USERS%% SET achievement_daily_1 = achievement_daily_1 + :achievement_daily_1, achievement_daily_1_points = achievement_daily_1_points + :achievement_daily_1_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
					database::get()->update($sql, array(
						':achievement_daily_1'			=> 1,
						':achievement_daily_1_points'	=> $fighter_reward_points,
						':achievement_point'			=> $fighter_reward_points,
						':darkmatter'					=> $fighter_reward_am,
						':userId'						=> $userID
					));
					$LNG		= getLanguageUser(NULL, $userID);
					$msg = '<a href="game.php?page=achievement&amp;group=daily#ach_wons_day"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_wons_day.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_47'], pretty_number($fighter_lvl)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($fighter_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($fighter_reward_points).' '.$LNG['achiev_13'].'</a><br><br>';
					PlayerUtil::sendMessage($ownerUser['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
				}
			}
			$result = true;
		}
		return $result;
	}

/*Logros Diversos*/
/*Expedición exitosa general*/
	function achievementSuccesVaria($ownerUser){
		$sql	= "UPDATE %%USERS%% SET achievement_varia_5_success = achievement_varia_5_success + 1 WHERE id = :userId;";
		Database::get()->update($sql, array(
			':userId'	=> $ownerUser['id']
		));
		$actualWins 			= $ownerUser['achievement_varia_5_success'] + 1;
		$actualNeeded 			= round(10 * pow(1.40, $ownerUser['achievement_varia_5']));
		$fighter_lvl 			= $ownerUser['achievement_varia_5'] + 1;
		$fighter_reward_am 		= round(150 * pow(1.08, $ownerUser['achievement_varia_5']));
		$fighter_reward_points 	= round(50 * pow(1.08, $ownerUser['achievement_varia_5']));
		
		if($actualWins >= $actualNeeded){
			$sql	= "UPDATE %%USERS%% SET achievement_varia_5 = achievement_varia_5 + 1, achievement_varia_5_points = achievement_varia_5_points + :achievement_varia_5_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			Database::get()->update($sql, array(
				':achievement_varia_5_points'	=> $fighter_reward_points,
				':achievement_point'			=> $fighter_reward_points,
				':darkmatter'					=> $fighter_reward_am,
				':userId'						=> $ownerUser['id']
			));
			
			$LNG		= getLanguageUser(NULL, $ownerUser['id']);
			$msg = '<a href="game.php?page=achievement&amp;group=varia#ach_expedition"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_expedition.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_149'], pretty_number($fighter_lvl)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($fighter_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($fighter_reward_points).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($ownerUser['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
	}


	/*Combate general*/
	function succesFighterAchievement($userID, $ownerUser, $targetUser, $combatResult, $i, $attackStatus){
	$result = false;
	if($attackStatus == 'wons' && $targetUser['onlinetime'] > TIMESTAMP - 7 * 24 * 3600 && $i == 1){
		$sql	= "UPDATE %%USERS%% SET achievement_varia_1_success = achievement_varia_1_success + 1 WHERE id = :userId;";
		database::get()->update($sql, array(
			':userId'	=> $userID
		));
		
		$sql	= "SELECT * FROM %%USERS%% WHERE id = :userId;";
		$userUpdated = database::get()->selectSingle($sql, array(
			':userId'	=> $userID
		));
		
		$actualWins 			= $userUpdated['achievement_varia_1_success'];
		$actualNeeded 			= round(50 * pow(1.905, $userUpdated['achievement_varia_1']));
		$fighter_lvl 			= $userUpdated['achievement_varia_1'];
		$fighter_reward_am 		= floor(300 * pow(1.05, $userUpdated['achievement_varia_1']));
		$fighter_reward_points 	= floor(150 * pow(1.05, $userUpdated['achievement_varia_1']));
		if($actualWins >= $actualNeeded){
			$sql	= "UPDATE %%USERS%% SET achievement_varia_1 = achievement_varia_1 + 1, achievement_varia_1_points = achievement_varia_1_points + :achievement_varia_1_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			database::get()->update($sql, array(
				':achievement_varia_1_points'	=> $fighter_reward_points,
				':achievement_point'			=> $fighter_reward_points,
				':darkmatter'					=> $fighter_reward_am, 
				':userId'						=> $userID
			));
			$LNG		= getLanguageUser(NULL, $userID);
			
			$msg = '<a href="game.php?page=achievement&amp;group=varia#ach_wons"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_wons.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_145'], pretty_number($fighter_lvl)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($fighter_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($fighter_reward_points).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($ownerUser['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
		$result = true;
	}elseif($attackStatus == 'loos' && $i == 2){
		$sql	= "UPDATE %%USERS%% SET achievement_varia_1_success = achievement_varia_1_success + 1 WHERE id = :userId;";
		database::get()->update($sql, array(
			':userId'	=> $userID
		));
		
		$sql	= "SELECT * FROM %%USERS%% WHERE id = :userId;";
		$userUpdated = database::get()->selectSingle($sql, array(
			':userId'	=> $userID
		));
		
		$actualWins 			= $userUpdated['achievement_varia_1_success'] + 1;
		$actualNeeded 			= round(50 * pow(1.905, $userUpdated['achievement_varia_1']));
		$fighter_lvl 			= $userUpdated['achievement_varia_1'] + 1;
		$fighter_reward_am 		= floor(300 * pow(1.05, $userUpdated['achievement_varia_1']));
		$fighter_reward_points 	= floor(150 * pow(1.05, $userUpdated['achievement_varia_1']));
		if($actualWins >= $actualNeeded){
			$sql	= "UPDATE %%USERS%% SET achievement_varia_1 = achievement_varia_1 + 1, achievement_varia_1_points = achievement_varia_1_points + :achievement_varia_1_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
			database::get()->update($sql, array(
				':achievement_varia_1_points'	=> $fighter_reward_points,
				':achievement_point'			=> $fighter_reward_points,
				':darkmatter'					=> $fighter_reward_am,
				':userId'						=> $userID
			));
			$LNG		= getLanguageUser(NULL, $userID);
			
			$msg = '<a href="game.php?page=achievement&amp;group=varia#ach_wons"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_wons.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_145'], pretty_number($fighter_lvl)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($fighter_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($fighter_reward_points).' '.$LNG['achiev_13'].'</a>';
			PlayerUtil::sendMessage($ownerUser['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}
		$result = true;
	}
	return $result;
}


function achievementMoonCreate($ownerUser){
	$sql	= "UPDATE %%USERS%% SET achievement_varia_3_success = achievement_varia_3_success + 1 WHERE id = :userId;";
	database::get()->update($sql, array(
		':userId'	=> $ownerUser['id']
	));
			
	$actualWins 		=  $ownerUser['achievement_varia_3_success'] + 1;
	$actualNeeded 		=  round(3 * pow(1.30, $ownerUser['achievement_varia_3']));
	$fighter_lvl 		=  $ownerUser['achievement_varia_3'] + 1;
	$fighter_reward_am 	= floor(200 * pow(1.10, $ownerUser['achievement_varia_3']));
	$fighter_reward_points = floor(100 * pow(1.10, $ownerUser['achievement_varia_3']));
	if($actualWins == $actualNeeded){
		$sql	= "UPDATE %%USERS%% SET achievement_varia_3 = achievement_varia_3 + 1, achievement_varia_3_success = 0, achievement_varia_3_points = achievement_varia_3_points + :achievement_varia_3_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
		database::get()->update($sql, array(
			':achievement_varia_3_points'	=> $fighter_reward_points,
			':achievement_point'			=> $fighter_reward_points,
			':darkmatter'					=> $fighter_reward_am,
			':userId'						=> $ownerUser['id']
		));
		$LNG			= getLanguageUser(NULL,$ownerUser['id']);
		$msg = '<a href="game.php?page=achievement&amp;group=varia#ach_creation_moons"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_creation_moons.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_147'], pretty_number($fighter_lvl)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($fighter_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($fighter_reward_points).' '.$LNG['achiev_13'].'</a>';
		PlayerUtil::sendMessage($ownerUser['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
	}
}

function achievementMoonDestroy($ownerUser){
	$sql	= "UPDATE %%USERS%% SET achievement_varia_2_success = achievement_varia_2_success + 1 WHERE id = :userId;";
	database::get()->update($sql, array(
		':userId'	=> $ownerUser['id']
	));
						
	$actualWins 		=  $ownerUser['achievement_varia_2_success'] + 1;
	$actualNeeded 		=  round(3 * pow(1.30, $ownerUser['achievement_varia_2']));
	$fighter_lvl 		=  $ownerUser['achievement_varia_2'] + 1;
	$fighter_reward_am 	= floor(500 * pow(1.10, $ownerUser['achievement_varia_2']));
	$fighter_reward_points = floor(250 * pow(1.10, $ownerUser['achievement_varia_2']));
	if($actualWins == $actualNeeded){
		$sql	= "UPDATE %%USERS%% SET achievement_varia_2 = achievement_varia_2 + 1, achievement_varia_2_success = 0, achievement_varia_2_points = achievement_varia_2_points + :achievement_varia_2_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
		database::get()->update($sql, array(
			':achievement_varia_2_points'	=> $fighter_reward_points,
			':achievement_point'			=> $fighter_reward_points,
			':darkmatter'					=> $fighter_reward_am,
			':userId'						=> $ownerUser['id']
		));
		$LNG			= getLanguageUser(NULL,$ownerUser['id']);
		$msg = '<a href="game.php?page=achievement&amp;group=varia#ach_destroyer_moons"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_destroyer_moons.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_146'], pretty_number($fighter_lvl)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($fighter_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($fighter_reward_points).' '.$LNG['achiev_13'].'</a>';
		PlayerUtil::sendMessage($ownerUser['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
	}
}

/*Buscado de Materi Oscura*/
function achievementDarkmatter($ownerUser, $Size){			
	$sql	= "UPDATE %%USERS%% SET achievement_varia_6_success = achievement_varia_6_success + :achievement_varia_6_success WHERE id = :userId;";
	Database::get()->update($sql, array(
		':achievement_varia_6_success'	=> $Size,
		':userId'						=> $ownerUser['id']
	));
	$actualWins				= $ownerUser['achievement_varia_6_success'] + $Size;
	$actualNeeded 			= round(50000 * pow(1.11, $ownerUser['achievement_varia_6']));
	$fighter_lvl 			= $ownerUser['achievement_varia_6'] + 1;
	$fighter_reward_am 		= round(33 * pow(1.0373, $ownerUser['achievement_varia_6']));
	$fighter_reward_points 	= round(20 * pow(1.030, $ownerUser['achievement_varia_6']));
	
	if($actualWins >= $actualNeeded){
		$sql	= "UPDATE %%USERS%% SET achievement_varia_6 = achievement_varia_6 + 1, achievement_varia_6_points = achievement_varia_6_points + :achievement_varia_6_points, achievement_point = achievement_point + :achievement_point, darkmatter = darkmatter + :darkmatter, achievement_varia_6_success = 0 WHERE id = :userId;";
		Database::get()->update($sql, array(
			':achievement_varia_6_points'	=> $fighter_reward_points,
			':achievement_point'			=> $fighter_reward_points,
			':darkmatter'					=> $fighter_reward_am,
			':userId'						=> $ownerUser['id']
		));
		
		$LNG		= getLanguageUser(NULL,$ownerUser['id']);
		
		$msg = '<a href="game.php?page=achievement&amp;group=varia#ach_found_tm"><img alt="" style="float:left; width:60px; margin-right:6px;" src="styles/theme/gow/achiev/ach_found_tm.png">'.$LNG['achiev_25'].': <span class="achiev_mes_head">'.sprintf($LNG['achiev_150'], pretty_number($fighter_lvl)).'</span><br> '.$LNG['achiev_26'].':<br> '.pretty_number($fighter_reward_am).' '.$LNG['tech'][921].' <br> '.pretty_number($fighter_reward_points).' '.$LNG['achiev_13'].'</a>';
		PlayerUtil::sendMessage($ownerUser['id'], 0, 'System', 200, 'Achievements' , $msg, TIMESTAMP, NULL, 1, Universe::getEmulated());
	}
	
	$sql	= "SELECT * FROM %%USERS%% WHERE id = :userId;";
	$newUserInfoQuery = Database::get()->selectSingle($sql, array(
		':userId'	=> $ownerUser['id']
	));
	
	if($newUserInfoQuery['achievement_varia_6_success'] >= round(50000 * pow(1.11, $newUserInfoQuery['achievement_varia_6'])))
		$this->achievementDarkmatter($newUserInfoQuery, 0);
	
	
}



?>
