<?php

/**
 *   Bonus Mod for 2Moons  2.0
 *   by Jekill 2020
 *
 *
 * @package PGames
 * @author Jekill <spacewarinfo@gmail.com>
 * @version 0.1.0
 * @link https://www.parallelgames.cubava.cu
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");

function ShowTournamentPage() {
	if($_POST)
		save_tournament();
	else
		show();
}

function show(){

	$template		= new template();
	$template->loadscript('styles/assets/js/plugins/forms/selects/select2.min.js');
	$template->loadscript('styles/assets/js/plugins/forms/styling/uniform.min.js');
	$template->loadscript('styles/assets/js/plugins/forms/styling/switchery.min.js');
	$template->loadscript('styles/assets/js/plugins/forms/styling/switch.min.js');
	$template->loadscript('styles/assets/js/core/app.js');
	$template->loadscript('styles/assets/js/pages/form_layouts.js');
	$template->loadscript('styles/assets/js/pages/form_checkboxes_radios.js');

	$sql = "SELECT * FROM %%CONFIG%% WHERE uni=".ROOT_UNI;

	$tournament_data = Database::get()->selectSingle($sql);

	$tournament = array(
		'status'=> $tournament_data['activate_war_of_alliance'],
		'ships'	=> unserialize($tournament_data['tournament_ships']),
	);
	

	$template->assign_vars(array(
		'tournament'		=> $tournament,
	));

	$template->show('TournamentPage.tpl');
}

function save_tournament(){
	global $reslist;

	$ships_	= HTTP::_GP('ships', '');
	$status 	= '0';

	if(isset($_POST['status']) && $_POST['status']=='on'){
		$status = '1';
	}


	$ships = array();

	foreach (explode(';',$ships_) as $value) {
		$temp = explode(',', $value);
		foreach ($temp as $item => $mis ) {
			
			if(!empty($mis[0]))
				$ships[$temp[0]] = $temp[1];
		}
	}

	$tships =$ships;

	foreach ($reslist['fleet'] as $ship) {
		$tships[$ship] = (isset($ships[$ship]))?$ships[$ship]:0;
	}

	$query = "UPDATE %%CONFIG%% SET activate_war_of_alliance='".$status."', tournament_ships='".serialize($tships)."' WHERE uni=".ROOT_UNI;

	Database::get()->update($query);

	HTTP::redirectTo('admin.php?page=tournament');
}