<?php

/**
 *   Bonus Mod for 2Moons  2.6
 *   by Jekill 2020
 *   Update YamilRH <ireadigos@gmail.com>
 *
 * @package PGames
 * @package Moon Dark
 * @author Jekill <spacewarinfo@gmail.com>
 * @version 0.1.1
 * @link https://www.miisla.nat.cu
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");

function ShowOcationalBonusPage() {

	$action	= HTTP::_GP('action', '');

	switch ($action) {
		case 'save':
			save_bonus_data();
		break;

		case 'cancel':
			cancel_bonus();
		break;
		
		default:
			show();
		break;
	}
}

function show(){
	$template	= new template();

	$sql = "SELECT * FROM %%OBONUS%%";

	$bonus_data = Database::get()->select($sql);
	$all_bonus = array();

	foreach ($bonus_data as $row => $data) {
		$all_bonus[] = array(
			'id' 		=> $data['id'],
			'name' 		=> translate_tag($data['name'])['name'],
			'desc' 		=> translate_tag($data['name'])['desc'],
			'procent'	=> $data['procent'],
			'start'		=> ($data['start_time']==0)?0:date("d/m/Y H\h:i\m:s\s", $data['start_time']),
			'end'		=> ($data['end_time']==0)?0:date("d/m/Y H\h:i\m:s\s", $data['end_time']),
			'status'	=> ($data['start_time'] <= TIMESTAMP && $data['end_time'] > TIMESTAMP)?true:false,
		);
	}
	$template		= new template();
	$template->loadscript('filterlist.js');
		$template->loadscript('styles/assets/js/core/app.js');	
		$template->loadscript('styles/assets/js/plugins/tables/datatables/datatables.min.js');	
		$template->loadscript('styles/assets/js/plugins/forms/selects/select2.min.js');	
		$template->loadscript('styles/assets/js/pages/datatables_advanced.js');
	$template->assign_vars(array(
		'all_bonus'		=> $all_bonus,
		'now'			=> TIMESTAMP,
	));

	$template->show('OcationalBonusPage.tpl');
}

function save_bonus_data(){

	global $USER, $LNG;

	$item_bonus	= HTTP::_GP('bonus', '');

	$minutes	= HTTP::_GP('minutes', 0);
	$hours		= HTTP::_GP('hours', 0);
	$days		= HTTP::_GP('days', 0);

	$procent	= HTTP::_GP('procent', 0);

	$minutes 	= ($minutes > 0) ? ($minutes * 60): 0;
	$hours 		= ($hours > 0) ? ($hours * 3600): 0;
	$days 		= ($days > 0) ? (($days * 3600) * 24): 0;

	if($procent == 0){
		$template	= new template();
		$template->message('El porciento debe ser mayor que 0', 'admin.php?page=obonus');
	}


	$all_time 	= $minutes + $hours + $days;

	$sql = "UPDATE ".OBONUS." SET start_time = ".TIMESTAMP.", end_time = ".(TIMESTAMP + $all_time).", procent = ".$procent." WHERE id = ".$item_bonus;

	$bonus_data = $GLOBALS['DATABASE']->query($sql);
	/**
	*MIO
	**/

	$time = TIMESTAMP+$all_time;
	$sttime = _date($LNG['php_tdformat'], $time, $USER['timezone']);
	$bonus = $LNG['obonus'][$item_bonus];

			$Message="Estimado {USERNAME}, le anunciamos que ha sido activado el bonus de ".$bonus." al ".$procent."%  hasta el ".$sttime;
			$From    	= '<span style="color:#666600">System</span>';
			$pmSubject 	= '<span style="color:#666600">Bonus</span>';
			$pmMessage 	= '<span style="color:#666600">'.$Message.'</span>';
			$USERS		= $GLOBALS['DATABASE']->query("SELECT `id`, `username` FROM ".USERS." WHERE `universe` = '".Universe::getEmulated()."';");
			while($UserData = $GLOBALS['DATABASE']->fetch_array($USERS))
			{
				$sendMessage = str_replace('{USERNAME}', $UserData['username'], $pmMessage);
				PlayerUtil::sendMessage($UserData['id'], 0, $From, 200, $pmSubject, $sendMessage, TIMESTAMP, NULL, 1, Universe::getEmulated());
			}

	HTTP::redirectTo('admin.php?page=obonus');
}

function cancel_bonus(){
	$item_bonus	= HTTP::_GP('bonus', 1);

	$sql = "UPDATE ".OBONUS." SET end_time = 0 WHERE id =".$item_bonus;

	$bonus_data = $GLOBALS['DATABASE']->query($sql);

	HTTP::redirectTo('admin.php?page=obonus');
}

function translate_tag($tag){

	$text_mod = array('name' =>'', 'desc' => '');

	if($tag == 'mine'){
		$text_mod['name'] = 'Producción de Minas';
		$text_mod['desc'] = 'Un aumento en la producción de las minas.';
	}elseif($tag == 'mo'){
		$text_mod['name'] = 'Materia Oscura';
		$text_mod['desc'] = 'Incremento de la posibilidad de encontrar MO en expediciones.';
	}

	return $text_mod;
}

function translate_id($id){

	$text_mod = array('name' =>'', 'desc' => '');

	if($id == 1){
		$text_mod['name'] = 'Producción de Minas';
		$text_mod['desc'] = 'Un aumento en la producción de las minas.';
	}elseif($id == 2){
		$text_mod['name'] = 'Materia Oscura';
		$text_mod['desc'] = 'Incremento de la posibilidad de encontrar MO en expediciones.';
	}

	return $text_mod;
}
