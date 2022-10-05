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

require_once 'includes/classes/cronjob/CronjobTask.interface.php';

class WoATournament implements CronjobTask
{
	function run()
	{
		$this->get_tournament_status();
	}

	private function get_tournament_status(){
		$config	= Config::get(ROOT_UNI);

		if($config->activate_war_of_alliance && $config->tournament_end_time <= TIMESTAMP){
			$new_start_time = strtotime('+3 days');
			$new_end_time = strtotime('+10 days');
			$query = "UPDATE %%CONFIG%% SET tournament_strat_time=$new_start_time, tournament_end_time=$new_end_time WHERE uni=".ROOT_UNI;
			Database::get()->update($query);

			$this->terminate_turnament();
		}elseif($config->activate_war_of_alliance && $config->tournament_strat_time <= TIMESTAMP){

			Database::get()->nativeQuery("TRUNCATE TABLE %%TWOAU%%");
		}
	}

	private function alliance_end_tournament(){
		
		$query = "UPDATE %%ALLIANCE%% SET ally_in_tournament='0', ally_tournament_units_destroyed=0, ally_tournament_total_destroy=0";
		Database::get()->update($query);		
	}

	private function terminate_turnament(){
		$query = "SELECT * FROM %%ALLIANCE%% WHERE ally_in_tournament='1' ORDER BY ally_tournament_total_destroy ASC;";
		$aliances = Database::get()->select($query);

		$total_resources = 0;

		foreach ($aliances as $row => $data) {
			$total_resources += round($data['ally_tournament_total_destroy']);
		}

		$resources_for_winners = array(
			1 => $total_resources,
			2 => $total_resources * 0.6,
			3 => $total_resources * 0.3,
		);

		$winners = 1;
		$alliance_winners = array();
		$total_alliances = 0;

		foreach ($aliances as $row => $data) {
			$metal 		= round(($resources_for_winners[$winners] * 0.6)/$data['ally_members']);
			$crystal 	= round(($resources_for_winners[$winners] * 0.3)/$data['ally_members'])*2;
			$deuterium 	= round(($resources_for_winners[$winners] * 0.1)/$data['ally_members'])*3;
			$total_alliances++;

			if($winners<=3){
				$alliance_winners[] = array(
					'ally_id'	=> $data['id'],
					'name'		=> $data['ally_name'],
					'tag'		=> $data['ally_tag'],
				);

				$users = "SELECT * FROM %%USERS%% WHERE ally_id=".$data['id'].";";
				$users = Database::get()->select($users);

				foreach ($users as $urow => $udata) {
					Database::get()->update("UPDATE %%PLANETS%% SET metal=metal+$metal, crystal=crystal+$crystal, deuterium=deuterium+$deuterium WHERE id=".$udata['id_planet'].";");
				}
			}	
			$winners++;			
		}
		
		Database::get()->insert("INSERT INTO %%TWOA%% SET alliances_winers='".serialize($alliance_winners)."', total_alliances=".$total_alliances.";");
		

		$this->alliance_end_tournament();
	}
}