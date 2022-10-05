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

function getFactors($USER, $Type = 'basic', $TIME = NULL) {
	global $resource, $pricelist, $reslist, $fractionList;
	if(empty($TIME))
		$TIME	= TIMESTAMP;
	
	$bonusList	= BuildFunctions::getBonusList();
	$factor		= ArrayUtil::combineArrayWithSingleElement($bonusList, 0);
	
	foreach($reslist['bonus'] as $elementID) {
		$bonus = $pricelist[$elementID]['bonus'];
		
		if (isset($PLANET[$resource[$elementID]])) {
			$elementLevel = $PLANET[$resource[$elementID]];
		} elseif (isset($USER[$resource[$elementID]])) {
			$elementLevel = $USER[$resource[$elementID]];
		} else {
			continue;
		}
		
		if(in_array($elementID, $reslist['dmfunc'])) {
			if(DMExtra($elementLevel, $TIME, false, true)) {
				continue;
			}
			
			foreach($bonusList as $bonusKey)
			{
				$factor[$bonusKey]	+= $bonus[$bonusKey][0];
			}
		} else {
			foreach($bonusList as $bonusKey)
			{
				$factor[$bonusKey]	+= $elementLevel * $bonus[$bonusKey][0];
			}
		}
	}
	
	return $factor;
}

function timeElapsedString($ptime){
    $diff = time() - $ptime;
    $calc_times = array();
    $timeleft   = array();

    // Prepare array, depending on the output we want to get.
    $calc_times[] = array('Año',   'Años',   31557600);
    $calc_times[] = array('Mese',  'Meses',  2592000);
    $calc_times[] = array('Día',    'Días',    86400);
    $calc_times[] = array('Hora',   'Horas',   3600);
    $calc_times[] = array('Minuto', 'Minutos', 60);
    $calc_times[] = array('Segundo', 'Segundos', 1);

    foreach ($calc_times AS $timedata){
        list($time_sing, $time_plur, $offset) = $timedata;

        if ($diff >= $offset){
            $left = floor($diff / $offset);
            $diff -= ($left * $offset);
            $timeleft[] = "{$left} " . ($left == 1 ? $time_sing : $time_plur);
        }
    }

    return $timeleft ? (time() > $ptime ? null : '-') . implode(' ', $timeleft)." ago" : "Justo ahora";
}

function encrypt_decrypt($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'commentforhofs';
    $secret_iv = 'xterium';

    // hash
    $key = hash('sha256', $secret_key);
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}

function userStatus($data, $noobprotection = false)
{
	global $USER;
	$Array = array();
	$db 	= Database::get();

	/*print_r($USER);
	exit;*/

	/*if (isset($data['']) && $data['id'] < AUTH_ADM) {
		$Array[] = 'staff';
	}*/
	$sql =  "SELECT * FROM %%BUDDY%% WHERE (sender = :userID AND owner = :targetID) OR (sender = :targetID AND owner = :userID);";
		$isFriend = $db->selectSingle($sql, array(
			':userID'		=> $USER['id'],
			':targetID'		=> $data['id']
		));

	if (!empty($isFriend))
	{
		//$Class		 	= "gl-username-longinactive";
		$Array[] = 'friend';
	}

	//$eventid = ['','','','','','','','','','','','','','','','','','','',''];
	//$eventid = ['1614','1331'];

		/*$sql2	= 'SELECT id,username
		FROM %%USERS%%
		WHERE stat_type = :statType AND %%USERS%%.id = id';

		$eventi	= Database::get()->select($sql2, array(
			':statType'	=> 1
		));

		$event=[];
		foreach($eventi as $item)
		{
			$event[$item['username']] = $item['id'];
		}
	$eventid = 1614;
    if ($USER['id'] == $eventid) {
	 	$Array[] = 'event';
	 }*/

	if (isset($data['banaday']) && $data['banaday'] > TIMESTAMP) {
		$Array[] = 'banned';
	}

	if (isset($data['urlaubs_modus']) && $data['urlaubs_modus'] == 1) {
		$Array[] = 'vacation';
	}

	if (isset($data['onlinetime']) && $data['onlinetime'] < TIMESTAMP - INACTIVE_LONG) {
		$Array[] = 'longinactive';
	}

	if (isset($data['onlinetime']) && $data['onlinetime'] < TIMESTAMP - INACTIVE) {
		$Array[] = 'inactive';
	}

	if ($noobprotection && $noobprotection['NoobPlayer']) {
		$Array[] = 'noob';
	}

	if ($noobprotection && $noobprotection['StrongPlayer']) {
		$Array[] = 'strong';
	}
	
	if ($USER['username'] == $data['username']) {
	 	$Array[] = 'member';
	 }
	
	if(isset($data['authlevel']))
	if($data['authlevel']>0)
		$Array[] = 'rol'.$data['authlevel'];

	return $Array;
}

function getPlanets($USER)
{
	if(isset($USER['PLANETS']))
		return $USER['PLANETS'];

	$order = $USER['planet_sort_order'] == 1 ? "DESC" : "ASC" ;

	$sql = "SELECT id, name, galaxy, system, planet, planet_type, image, b_building, b_building_id
			FROM %%PLANETS%% WHERE id_owner = :userId AND destruyed = :destruyed ORDER BY ";

	switch($USER['planet_sort'])
	{
		case 0:
			$sql	.= 'id '.$order;
			break;
		case 1:
			$sql	.= 'galaxy, system, planet, planet_type '.$order;
			break;
		case 2:
			$sql	.= 'name '.$order;
			break;
	}

	$planetsResult = Database::get()->select($sql, array(
		':userId'		=> $USER['id'],
		':destruyed'	=> 0
   	));
	
	$planetsList = array();

	foreach($planetsResult as $planetRow) {
		$planetsList[$planetRow['id']]	= $planetRow;
	}

	return $planetsList;
}

function get_timezone_selector() {
	// New Timezone Selector, better support for changes in tzdata (new russian timezones, e.g.)
	// http://www.php.net/manual/en/datetimezone.listidentifiers.php
	
	$timezones = array();
	$timezone_identifiers = DateTimeZone::listIdentifiers();

	foreach($timezone_identifiers as $value )
	{
		if ( preg_match( '/^(America|Antartica|Arctic|Asia|Atlantic|Europe|Indian|Pacific)\//', $value ) )
		{
			$ex		= explode('/',$value); //obtain continent,city
			$city	= isset($ex[2])? $ex[1].' - '.$ex[2]:$ex[1]; //in case a timezone has more than one
			$timezones[$ex[0]][$value] = str_replace('_', ' ', $city);
		}
	}
	return $timezones; 
}

function locale_date_format($format, $time, $LNG = NULL)
{
	// Workaround for locale Names.

	if(!isset($LNG)) {
		global $LNG;
	}
	
	$weekDay	= date('w', $time);
	$months		= date('n', $time) - 1;
	
	$format     = str_replace(array('D', 'M'), array('$D$', '$M$'), $format);
	$format		= str_replace('$D$', addcslashes($LNG['week_day'][$weekDay], 'A..z'), $format);
	$format		= str_replace('$M$', addcslashes($LNG['months'][$months], 'A..z'), $format);
	
	return $format;
}

function _date($format, $time = null, $toTimeZone = null, $LNG = NULL)
{
	if(!isset($time))
	{
		$time	= TIMESTAMP;
	}

	if(isset($toTimeZone))
	{
		$date = new DateTime();
		if(method_exists($date, 'setTimestamp'))
		{	// PHP > 5.3			
			$date->setTimestamp((int) $time);
		} else {
			// PHP < 5.3
			$tempDate = getdate((int) $time);
			$date->setDate($tempDate['year'], $tempDate['mon'], $tempDate['mday']);
			$date->setTime($tempDate['hours'], $tempDate['minutes'], $tempDate['seconds']);
		}
		
		$time	-= $date->getOffset();
		try {
			$date->setTimezone(new DateTimeZone($toTimeZone));
		} catch (Exception $e) {
			
		}
		$time	+= $date->getOffset();
	}
	
	$format	= locale_date_format($format, (int)$time, $LNG);
	return date($format, (int)$time);
}

function ValidateAddress($address) {
	
	if(function_exists('filter_var')) {
		return filter_var($address, FILTER_VALIDATE_EMAIL) !== FALSE;
	} else {
		/*
			Regex expression from swift mailer (http://swiftmailer.org)
			RFC 2822
		*/
		return preg_match('/^(?:(?:(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?(?:[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_\{\}\|~]+(\.[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_\{\}\|~]+)*)+(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?)|(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?"((?:(?:[ \t]*(?:\r\n))?[ \t])?(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21\x23-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])))*(?:(?:[ \t]*(?:\r\n))?[ \t])?"(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?))@(?:(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?(?:[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_\{\}\|~]+(\.[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_\{\}\|~]+)*)+(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?)|(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?\[((?:(?:[ \t]*(?:\r\n))?[ \t])?(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x5A\x5E-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])))*?(?:(?:[ \t]*(?:\r\n))?[ \t])?\](?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?)))$/D', $address);
	}
}

function message($mes, $dest = "", $time = "3", $topnav = false)
{
	require_once('includes/classes/class.template.php');
	$template = new template();
	$template->message($mes, $dest, $time, !$topnav);
	exit;
}

function CalculateMaxPlanetFields($planet)
{
	global $resource;
	return $planet['field_max'] + ($planet[$resource[33]] * FIELDS_BY_TERRAFORMER) + ($planet[$resource[41]] * FIELDS_BY_MOONBASIS_LEVEL);
}

function pretty_time($seconds)
{
	global $LNG;
	
	$day	= floor($seconds / 86400);
	$hour	= floor($seconds / 3600 % 24);
	$minute	= floor($seconds / 60 % 60);
	$second	= floor($seconds % 60);

	$time  = '';

	if($day > 0) {
		$time .= sprintf('%d%s ', $day, $LNG['short_day']);
	}

	return $time.sprintf('%02d%s %02d%s %02d%s',
		$hour, $LNG['short_hour'],
		$minute, $LNG['short_minute'],
		$second, $LNG['short_second']
	);
}

function pretty_fly_time($seconds)
{
	$hour	= floor($seconds / 3600);
	$minute	= floor($seconds / 60 % 60);
	$second	= floor($seconds % 60);

	return sprintf('%02d:%02d:%02d', $hour, $minute, $second);
}

function GetStartAddressLink($FleetRow, $FleetType = '')
{
	return '<a href="game.php?page=galaxy&amp;galaxy='.$FleetRow['fleet_start_galaxy'].'&amp;system='.$FleetRow['fleet_start_system'].'" class="'. $FleetType .'">['.$FleetRow['fleet_start_galaxy'].':'.$FleetRow['fleet_start_system'].':'.$FleetRow['fleet_start_planet'].']</a>';
}

function GetTargetAddressLink($FleetRow, $FleetType = '')
{
	return '<a href="game.php?page=galaxy&amp;galaxy='.$FleetRow['fleet_end_galaxy'].'&amp;system='.$FleetRow['fleet_end_system'].'" class="'. $FleetType .'">['.$FleetRow['fleet_end_galaxy'].':'.$FleetRow['fleet_end_system'].':'.$FleetRow['fleet_end_planet'].']</a>';
}

function BuildPlanetAddressLink($CurrentPlanet)
{
	return '<a href="game.php?page=galaxy&amp;galaxy='.$CurrentPlanet['galaxy'].'&amp;system='.$CurrentPlanet['system'].'">['.$CurrentPlanet['galaxy'].':'.$CurrentPlanet['system'].':'.$CurrentPlanet['planet'].']</a>';
}

function pretty_number($n, $dec = 0)
{
	return number_format(floatToString($n, $dec), $dec, ',', '.');
}

function GetUserByID($userId, $GetInfo = "*")
{
	if(is_array($GetInfo))
	{
		$GetOnSelect = implode(', ', $GetInfo);
	}
	else
	{
		$GetOnSelect = $GetInfo;
	}

	$sql = 'SELECT '.$GetOnSelect.' FROM %%USERS%% WHERE id = :userId';

	$User = Database::get()->selectSingle($sql, array(
		':userId'	=> $userId
	));

	return $User;
}

// funcion paralistar el usuario y dar todo los planetas
function getUserByIdR($id)
{
	$db		= Database::get();
	$sql	= 'SELECT * FROM %%USERS%% WHERE `id` = :userId;';

	$senderUser		= $db->selectSingle($sql, array(
		':userId'	=> $id,
	));
	$sql	= 'SELECT planet_factor FROM %%CONFIG%% WHERE `uni` = :univ;';

	$config		= $db->selectSingle($sql, array(
		':univ'	=> $senderUser['universe'],
	));
	$senderUser['factor']['Planets']=$config['planet_factor'];

	return $senderUser; 
}
// funcion que cuenta la cantidad de planetas por usuario
function getCountPlanet($id)
{
	$db		= Database::get();
	$sql	= 'SELECT count(id) as cant FROM %%PLANETS%% WHERE `id_owner` = :userId AND planet_type=1;';

	$senderUser		= $db->selectSingle($sql, array(
		':userId'	=> $id,
	));

	return $senderUser['cant']; 
}

//funcion para llamar al id de usuario
function getIdCurrentUser()
{

	global $USER;
	return $USER['id'];
}

// funcion para llamar usuario del id anterior
function getCurrentUserFull()
{
	global $USER;
	return $USER;
}





function makebr($text)
{
    // XHTML FIX for PHP 5.3.0
	// Danke an Meikel
	
    $BR = "<br>\n";
    return (version_compare(PHP_VERSION, "5.3.0", ">=")) ? nl2br($text, false) : strtr($text, array("\r\n" => $BR, "\r" => $BR, "\n" => $BR)); 
}


function CheckNoobProtec($OwnerPlayer, $TargetPlayer, $Player)
{
	$config	= Config::get();
	if(
		$config->noobprotection == 0 
		|| $config->noobprotectiontime == 0 
		|| $config->noobprotectionmulti == 0 
		|| $Player['banaday'] > TIMESTAMP
		|| $Player['onlinetime'] < TIMESTAMP - INACTIVE
	) {
		return array('NoobPlayer' => false, 'StrongPlayer' => false);
	}
	
	return array(
		'NoobPlayer' => (
			// WAHR: 
			//	Wenn Spieler mehr als 25000 Punkte hat UND
			//	Wenn ZielSpieler weniger als 80% der Punkte des Spieler hat.
			//	ODER weniger als 5.000 hat.
			
			// Addional Comment: Letzteres ist eigentlich sinnfrei, bitte testen.a
			//($TargetPlayer['total_points'] <= $config->noobprotectiontime) && // Default: 25.000
			($OwnerPlayer['total_points'] > $TargetPlayer['total_points'] * $config->noobprotectionmulti)
		), 
		'StrongPlayer' => (
			// WAHR: 
			//	Wenn Spieler weniger als 5000 Punkte hat UND
			//	Mehr als das funfache der eigende Punkte hat
			
			//($OwnerPlayer['total_points'] < $config->noobprotectiontime) && // Default: 5.000
			($OwnerPlayer['total_points'] * $config->noobprotectionmulti < $TargetPlayer['total_points'])
		),
	);
}




function shortly_number($number, $decial = NULL)
{
	$negate	= $number < 0 ? -1 : 1;
	$number	= abs($number);
    $unit	= array("", "K", "M", "B", "T", "Q", "Q+", "S", "S+", "O", "N");
	$key	= 0;
	
	if($number >= 1000000) {
		++$key;
		while($number >= 1000000)
		{
			++$key;
			$number = $number / 1000000;
		}
	} elseif($number >= 1000) {
		++$key;
		$number = $number / 1000;
	}
	
	$decial	= !is_numeric($decial) ? ((int) (((int)$number != $number) && $key != 0 && $number != 0 && $number < 100)) : $decial;
	return pretty_number($negate * $number, $decial).$unit[$key];
}

function floatToString($number, $Pro = 0, $output = false){
	return $output ? str_replace(",",".", sprintf("%.".$Pro."f", $number)) : sprintf("%.".$Pro."f", $number);
}

function isModuleAvailable($ID)
{
	global $USER;
	$modules	= explode(';', Config::get()->moduls);

	if(!isset($modules[$ID]))
	{
		$modules[$ID] = 1;
	}

	return $modules[$ID] == 1 || (isset($USER['authlevel']) && $USER['authlevel'] > AUTH_USR);
}

function ClearCache()
{
	$DIRS	= array('cache/', 'cache/templates/');
	foreach($DIRS as $DIR) {
		$FILES = array_diff(scandir($DIR), array('..', '.', '.htaccess'));
		foreach($FILES as $FILE) {
			if(is_dir(ROOT_PATH.$DIR.$FILE))
				continue;
				
			unlink(ROOT_PATH.$DIR.$FILE);
		}
	}


	$template = new template();
	$template->clearAllCache();


	require_once 'includes/classes/Cronjob.class.php';
	Cronjob::reCalculateCronjobs();

	$sql	= 'UPDATE %%PLANETS%% SET eco_hash = :ecoHash;';
	Database::get()->update($sql, array(
		':ecoHash'	=> ''
	));
	clearstatcache();

	/* does no work on git.

	// Find currently Revision

	$REV = 0;

	$iterator = new RecursiveDirectoryIterator(ROOT_PATH);
	foreach(new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST) as $file) {
		if (false == $file->isDir()) {
			$CONTENT	= file_get_contents($file->getPathname());
			
			preg_match('!\$'.'Id: [^ ]+ ([0-9]+)!', $CONTENT, $match);
			
			if(isset($match[1]) && is_numeric($match[1]))
			{
				$REV	= max($REV, $match[1]);
			}
		}
	}
	
	$config->VERSION	= $version[0].'.'.$version[1].'.'.$REV;
	*/

	$config		= Config::get();
	$version	= explode('.', $config->VERSION);
	$config->VERSION	= $version[0].'.'.$version[1].'.'.'git';
	$config->save();
	
}

function allowedTo($side)
{
	global $USER;
	return ($USER['authlevel'] == AUTH_ADM || (isset($USER['rights']) && $USER['rights'][$side] == 1));
}

function isactiveDMExtra($Extra, $Time) {
	return $Time - $Extra <= 0;
}

function DMExtra($Extra, $Time, $true, $false) {
	return isactiveDMExtra($Extra, $Time) ? $true : $false;
}

function getRandomString() {
	return md5(uniqid());
}

function isVacationMode($USER)
{
	return ($USER['urlaubs_modus'] == 1) ? true : false;
}

function clearGIF() {
	header('Cache-Control: no-cache');
	header('Content-type: image/gif');
	header('Content-length: 43');
	header('Expires: 0');
	echo("\x47\x49\x46\x38\x39\x61\x01\x00\x01\x00\x80\x00\x00\x00\x00\x00\x00\x00\x00\x21\xF9\x04\x01\x00\x00\x00\x00\x2C\x00\x00\x00\x00\x01\x00\x01\x00\x00\x02\x02\x44\x01\x00\x3B");
	exit;
}

/*
 * Handler for exceptions
 *
 * @param object
 * @return Exception
 */
function exceptionHandler($exception)
{
	/** @var $exception ErrorException|Exception */

	if(!headers_sent()) {
		if (!class_exists('HTTP', false)) {
			require_once('includes/classes/HTTP.class.php');
		}
		
		HTTP::sendHeader('HTTP/1.1 503 Service Unavailable');
	}

	if(method_exists($exception, 'getSeverity')) {
		$errno	= $exception->getSeverity();
	} else {
		$errno	= E_USER_ERROR;
	}
	
	$errorType = array(
		E_ERROR				=> 'ERROR',
		E_WARNING			=> 'WARNING',
		E_PARSE				=> 'PARSING ERROR',
		E_NOTICE			=> 'NOTICE',
		E_CORE_ERROR		=> 'CORE ERROR',
		E_CORE_WARNING   	=> 'CORE WARNING',
		E_COMPILE_ERROR		=> 'COMPILE ERROR',
		E_COMPILE_WARNING	=> 'COMPILE WARNING',
		E_USER_ERROR		=> 'USER ERROR',
		E_USER_WARNING		=> 'USER WARNING',
		E_USER_NOTICE		=> 'USER NOTICE',
		E_STRICT			=> 'STRICT NOTICE',
		E_RECOVERABLE_ERROR	=> 'RECOVERABLE ERROR'
	);
	
	if(file_exists(ROOT_PATH.'install/VERSION'))
	{
		$VERSION	= file_get_contents(ROOT_PATH.'install/VERSION').' (FILE)';
	}
	else
	{
		$VERSION	= 'UNKNOWN';
	}
	$gameName	= '-';
	
	if(MODE !== 'INSTALL')
	{
		try
		{
			include_once 'includes/classes/Config.class.php';
			$config		= Config::get();
			$gameName	= $config->game_name;
			$VERSION	= $config->VERSION;
		} catch(ErrorException $e) {
		}
	}
	
	
	$DIR		= MODE == 'INSTALL' ? '..' : '.';
	ob_start();
	echo '<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="de" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="de" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="de" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="de" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="de" class="no-js"> <!--<![endif]-->
<head>
	<title>'.$gameName.' - '.$errorType[$errno].'</title>
	<meta name="generator" content="2Moons '.$VERSION.'">
	<!-- 
		This website is powered by 2Moons '.$VERSION.'
		2Moons is a free Space Browsergame initially created by Jan Kröpke and licensed under GNU/GPL.
		2Moons is copyright 2009-2013 of Jan Kröpke. Extensions are copyright of their respective owners.
		Information and contribution at http://2moons.cc/
	-->
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="'.$DIR.'/styles/resource/css/base/boilerplate.css?v='.$VERSION.'">
	<link rel="stylesheet" type="text/css" href="'.$DIR.'/styles/resource/css/ingame/main.css?v='.$VERSION.'">
	<link rel="stylesheet" type="text/css" href="'.$DIR.'/styles/resource/css/base/jquery.css?v='.$VERSION.'">
	<link rel="stylesheet" type="text/css" href="'.$DIR.'/styles/theme/gow/formate.css?v='.$VERSION.'">
	<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
	<script type="text/javascript">
	var ServerTimezoneOffset = -3600;
	var serverTime 	= new Date(2012, 2, 12, 14, 43, 36);
	var startTime	= serverTime.getTime();
	var localTime 	= serverTime;
	var localTS 	= startTime;
	var Gamename	= document.title;
	var Ready		= "Fertig";
	var Skin		= "'.$DIR.'/styles/theme/gow/";
	var Lang		= "de";
	var head_info	= "Information";
	var auth		= 3;
	var days 		= ["So","Mo","Di","Mi","Do","Fr","Sa"] 
	var months 		= ["Jan","Feb","Mar","Apr","Mai","Jun","Jul","Aug","Sep","Okt","Nov","Dez"] ;
	var tdformat	= "[M] [D] [d] [H]:[i]:[s]";
	var queryString	= "";

	setInterval(function() {
		serverTime.setSeconds(serverTime.getSeconds()+1);
	}, 1000);
	</script>
	<script type="text/javascript" src="'.$DIR.'/scripts/base/jquery.js?v=2123"></script>
	<script type="text/javascript" src="'.$DIR.'/scripts/base/jquery.ui.js?v=2123"></script>
	<script type="text/javascript" src="'.$DIR.'/scripts/base/jquery.cookie.js?v=2123"></script>
	<script type="text/javascript" src="'.$DIR.'/scripts/base/jquery.fancybox.js?v=2123"></script>
	<script type="text/javascript" src="'.$DIR.'/scripts/base/jquery.validationEngine.js?v=2123"></script>
	<script type="text/javascript" src="'.$DIR.'/scripts/base/tooltip.js?v=2123"></script>
	<script type="text/javascript" src="'.$DIR.'/scripts/game/base.js?v=2123"></script>
</head>
<body id="overview" class="full">
<table width="960">
	<tr>
		<th>'.$errorType[$errno].'</th>
	</tr>
	<tr>
		<td class="left">
			<b>Message: </b>'.$exception->getMessage().'<br>
			<b>File: </b>'.$exception->getFile().'<br>
			<b>Line: </b>'.$exception->getLine().'<br>
			<b>URL: </b>'.PROTOCOL.HTTP_HOST.$_SERVER['REQUEST_URI'].'<br>
			<b>PHP-Version: </b>'.PHP_VERSION.'<br>
			<b>PHP-API: </b>'.php_sapi_name().'<br>
			<b>2Moons Version: </b>'.$VERSION.'<br>
			<b>Debug Backtrace:</b><br>'.makebr(htmlspecialchars($exception->getTraceAsString())).'
		</td>
	</tr>
</table>
</body>
</html>';

	echo str_replace(array('\\', ROOT_PATH, substr(ROOT_PATH, 0, 15)), array('/', '/', 'FILEPATH '), ob_get_clean());
	
	$errorText	= date("[d-M-Y H:i:s]", TIMESTAMP).' '.$errorType[$errno].': "'.strip_tags($exception->getMessage())."\"\r\n";
	$errorText	.= 'File: '.$exception->getFile().' | Line: '.$exception->getLine()."\r\n";
	$errorText	.= 'URL: '.PROTOCOL.HTTP_HOST.$_SERVER['REQUEST_URI'].' | Version: '.$VERSION."\r\n";
	$errorText	.= "Stack trace:\r\n";
	$errorText	.= str_replace(ROOT_PATH, '/', htmlspecialchars(str_replace('\\', '/',$exception->getTraceAsString())))."\r\n";
	
	if(is_writable('includ/errores/'.date('Y_m_d').'_error.log'))
	{
		file_put_contents('includes/errores/'.date('Y_m_d').'_error.log', $errorText, FILE_APPEND);
	}
}
/*
 *
 * @throws ErrorException
 *
 * @return bool If its an hidden error.
 *
 */
function errorHandler($errno, $errstr, $errfile, $errline)
{
    if (!($errno & error_reporting())) {
        return false;
    }
	
	throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

// "workaround" for PHP version pre 5.3.0
if (!function_exists('array_replace_recursive'))
{
    function array_replace_recursive()
    {
        if (!function_exists('recurse')) {
            function recurse($array, $array1)
            {
                foreach ($array1 as $key => $value)
                {
                    // create new key in $array, if it is empty or not an array
                    if (!isset($array[$key]) || (isset($array[$key]) && !is_array($array[$key])))
                    {
                        $array[$key] = array();
                    }

                    // overwrite the value in the base array
                    if (is_array($value))
                    {
                        $value = recurse($array[$key], $value);
                    }
                    $array[$key] = $value;
                }
                return $array;
            }
        }

        // handle the arguments, merge one by one
        $args = func_get_args();
        $array = $args[0];
        if (!is_array($array))
        {
            return $array;
        }
        $count = count($args);
        for ($i = 1; $i < $count; ++$i)
        {
            if (is_array($args[$i]))
            {
                $array = recurse($array, $args[$i]);
            }
        }
        return $array;
    }
}
function BotAdd(){
}

/**
*Bonus by Jekill
**/
function is_bonus_active($bonus){

	$sql = "SELECT * FROM %%OBONUS%% WHERE name=:bonus AND start_time < :now_time AND end_time > :now_time;";

	$bonus_data = Database::get()->select($sql, array(
		':now_time'		=> TIMESTAMP,
		':bonus'		=> $bonus
   	));

	return (Database::get()->rowCount($bonus_data) > 0);
}

function get_bonus_data($bonus){

	$sql = "SELECT * FROM %%OBONUS%% WHERE name=:bonus;";

	$bonus_data = Database::get()->selectSingle($sql, array(
		':bonus'		=> $bonus
   	));

	return $bonus_data;
}

/**
*Minis Torneos
**/
function tournement($playerId, $tourneyEvent, $addUnits){
	$sql = "SELECT * FROM %%TOURNEY%% WHERE tourneyEvent = :tourneyId;";
	$tourneyInfo = database::get()->selectSingle($sql, array(
		':tourneyId'	=> $tourneyEvent,
	));
	$sql = "SELECT * FROM %%TOURNEYPARTICI%% WHERE tourneyJoin = :tourneyId AND playerId = :playerId;";
	$tourneyCheck = database::get()->selectSingle($sql, array(
		':tourneyId'	=> $tourneyInfo['tourneyId'],
		':playerId'		=> $playerId
	));
	if(!empty($tourneyCheck) && config::get()->tourneyEnd >= TIMESTAMP){	
		$sql	= 'UPDATE %%TOURNEYPARTICI%% SET tourneyUnits = tourneyUnits + :tourneyUnits WHERE tourneyJoin = :tourneyJoin AND playerId = :playerId;';
		database::get()->update($sql, array(
			':tourneyUnits'	=> $addUnits,
			':tourneyJoin'	=> $tourneyInfo['tourneyId'],
			':playerId'		=> $playerId,
		));
	}
}

function getUserAlly($ID) {

	$db	= Database::get();
	$sql	= "SELECT * FROM %%ALLIANCE%% WHERE id = :ID;";
	$UserAlly = $db->selectSingle($sql, array(
			':ID'	=> $ID
	));
	
	return  $UserAlly;
}

function getUsername($ID) {
	$username = '';
	
	$db	= Database::get();
	$sql	= "SELECT username FROM %%USERS%% WHERE id = :userID;";
	$userNameResult = $db->selectSingle($sql, array(
			':userID'	=> $ID
	));
	
	return empty($userNameResult['username']) ? $userNameResult['username'] : $userNameResult['username'];
}


/*Notify*/
function GetFromDatabase($table, $tableIndex, $tableId, $GetInfo = "*")
{
	if(is_array($GetInfo))
	{
		$GetOnSelect = implode(', ', $GetInfo);
	}
	else
	{
		$GetOnSelect = $GetInfo;
	}

	$sql = 'SELECT '.$GetOnSelect.' FROM %%'.$table.'%% WHERE '.$tableIndex.' = :tableId';

	$Data = Database::get()->selectSingle($sql, array(
		':tableId'	=> $tableId
	));

	return $Data;
}

//function requires curl
function checkProxy($ip){
		$contactEmail="ireadigos@gmail.com"; //you must change this to your own email address
		$timeout=5; //by default, wait no longer than 5 secs for a response
		$banOnProbability=0.99; //if getIPIntel returns a value higher than this, function returns true, set to 0.99 by default
		
		//init and set cURL options
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

		//if you're using custom flags (like flags=m), change the URL below
		curl_setopt($ch, CURLOPT_URL, "http://check.getipintel.net/check.php?ip=$ip&contact=$contactEmail");
		$response=curl_exec($ch);
		
		curl_close($ch);

		
		
		if ($response > $banOnProbability) {
				return true;
			} else {
			if ($response < 0 || strcmp($response, "") == 0 ) {
				//The server returned an error, you might want to do something
				//like write to a log file or email yourself
				//This could be true due to an invalid input or you've exceeded
				//the number of allowed queries. Figure out why this is happening
				//because you aren't protected by the system anymore
				//Leaving this section blank is dangerous because you assume
				//that you're still protected, which is incorrect
				//and you might think GetIPIntel isn't accurate anymore
				//which is also incorrect.

				//failure to implement error handling is bad for the both of us

			}
				return false;
		}
}

function GubPriceAPSTRACT($Element, $Level, $ElementName){
	$UpLevel		= $Level;
	$db	= Database::get();
	$sql	= 'SELECT * FROM %%GOUVERNORS%% WHERE gouvernorId = :gouvernorId;';
	$GOUVERNORS = $db->selectSingle($sql, array(
	':gouvernorId'	=> $Element
	));
			
	$MathBonus = floor($GOUVERNORS['gouvernorDefault'] * $GOUVERNORS['gouvernorFactor'] + ($GOUVERNORS['gouvernorBonuslevel'] * floor($UpLevel / $GOUVERNORS['gouvernorDivider']) * $GOUVERNORS['gouvernorFactor']));
  	
	return $MathBonus;
}
