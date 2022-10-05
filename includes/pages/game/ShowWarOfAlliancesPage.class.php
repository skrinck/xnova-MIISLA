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

class ShowWarOfAlliancesPage extends AbstractGamePage
{
//	public static $requireModule = 0;
public static $requireModule = MODULE_TOURNEY_WOA;


	public function __construct(){
		parent::__construct();
	}

	private function check_inscription(){
		global $USER;

		if($USER['ally_id']!=0 && $USER['ally_id']!=''){
			$db	 = Database::get();

			$sql	= 'SELECT * FROM %%ALLIANCE%% WHERE id = :allianceId;';
			$allianceData = $db->selectSingle($sql, array(
				':allianceId'	=> $USER['ally_id']
			));

			if($allianceData['ally_owner'] == $USER['id']){
				if($allianceData['ally_members']>1){
					$sql	= 'UPDATE %%ALLIANCE%% SET ally_in_tournament="1" WHERE id = :allianceId;';
					$allianceData = $db->update($sql, array(
						':allianceId'	=> $USER['ally_id']
					));

					$sql	= 'SELECT * FROM %%USERS%% WHERE ally_id = "'.$USER['ally_id'].'";';
					$users = $db->select($sql);

					foreach ($users as $row => $data) {
						$query = "INSERT INTO %%TWOAU%% SET user_id=".$data['id'].", t_battles='".serialize(array())."', lost_points=0, alliance_id=".$USER['ally_id'].";";

						$db->insert($query);
					}
				}
			}
		}
	}

	public function show(){
		global $USER;
		
		$config			= Config::get();

		if($_POST){
			$this->check_inscription();
		}

		$PlanetRess	= new ResourceUpdate();
		$db	 = Database::get();

		//if(!isset($config->activate_war_of_alliance))
		//	$this->install_tournament();

		$sql	= 'SELECT * FROM %%ALLIANCE%% WHERE id = :allianceId;';
		$allianceData = $db->selectSingle($sql, array(
			':allianceId'	=> $USER['ally_id']
		));

		if($config->activate_war_of_alliance && $config->tournament_end_time >= TIMESTAMP){
			if($config->tournament_strat_time>=TIMESTAMP){
				$this->not_yet();
			}else{
				$this->tournament();
			}
		}else{
			$this->not_tournament();
		}
	}

	private function not_yet(){
		global $USER;

		$config			= Config::get();

		$PlanetRess	= new ResourceUpdate();
		$db	 = Database::get();

		$sql	= 'SELECT * FROM %%ALLIANCE%% WHERE id = :allianceId;';
		$allianceData = $db->selectSingle($sql, array(
			':allianceId'	=> $USER['ally_id']
		));


		$this->assign(array(
			'i'			=> 0,
			'activo'   => ($config->activate_war_of_alliance),
			'time'   => ($config->tournament_strat_time),
			'inscribed'	=> ($allianceData['ally_in_tournament']=='1')
		));

		$this->display('page.warofalliances.default.tpl');
	}

	private function tournament(){
		global $USER;

		$config			= Config::get();

		$PlanetRess	= new ResourceUpdate();
		$db	 = Database::get();


		$sql	= 'SELECT * FROM %%ALLIANCE%% WHERE ally_in_tournament = "1" ORDER BY ally_tournament_total_destroy ASC;';
		$alliances = $db->select($sql);

		$in_tournament = array();

		foreach ($alliances as $row => $data) {
			$in_tournament[] = array(
				'id'			=> $data['id'],
				'name'			=> $data['ally_name'],
				'tag'			=> $data['ally_tag'],
				'total_destroy'	=> $data['ally_tournament_total_destroy'],
				'members'		=> $data['ally_members'],
			);
		}


		$sql	= 'SELECT t.*, u.`username`, a.`ally_name` FROM %%TWOAU%% AS t 
					LEFT JOIN %%USERS%% AS u ON u.`id`=t.`user_id`
					LEFT JOIN %%ALLIANCE%% AS a ON a.`id`=t.`alliance_id`
					ORDER BY lost_points ASC;';
		$users_ally = $db->select($sql);

		$user_tournament = array();

		foreach ($users_ally as $row => $data) {
			$battles = unserialize($data['t_battles']);

			$total_lost = 0;

			foreach ($battles as $key => $battle) {
				foreach ($battle['lost_ships'] as $ship => $amount) {
					$total_lost += $amount;
				}
			}

			$user_tournament[] = array(
				'id'			=> $data['user_id'],
				'name'			=> $data['username'],
				'total_lost'	=> $total_lost,
				'ally_name'		=> $data['ally_name'],
			);
		}


		$this->assign(array(
			'i'			=> 0,
			'alliances' => $in_tournament,
			'users'   	=> $user_tournament,
		));

		$this->display('page.warofalliances.tournament.tpl');
	}

	private function not_tournament(){
		global $USER;

		$config			= Config::get();

		$PlanetRess	= new ResourceUpdate();
		$db	 = Database::get();

		$sql	= 'SELECT * FROM %%ALLIANCE%% WHERE id = :allianceId;';
		$allianceData = $db->selectSingle($sql, array(
			':allianceId'	=> $USER['ally_id']
		));


		$this->assign(array(
			'i'			=> 0,
			'text'   => 'Actualmente el mod War Of Alliances se encuentra inactivo. Regresa en otro momento y si crees que es un error, contacta con un administrador.',
		));

		$this->display('page.warofalliances.no_tournament.tpl');
	}

	private function install_tournament(){
		global $USER;

		$db = Database::get();

		$query = "SELECT * FROM %%CONFIG%% WHERE uni=".$USER['universe'];
		$check = $db->select($query);

		if(!isset($check['activate_war_of_alliance'])){
			$db->nativeQuery("ALTER TABLE %%CONFIG%% 
				ADD COLUMN `activate_war_of_alliance` enum('0','1') NOT NULL DEFAULT '0' AFTER `max_save_coords`,
				ADD COLUMN `tournament_strat_time` int(11) NOT NULL DEFAULT 0 AFTER `activate_war_of_alliance`,
				ADD COLUMN `tournament_end_time` int(11) NOT NULL DEFAULT 0 AFTER `tournament_strat_time`,
			");
			$db->nativeQuery("ALTER TABLE %%ALLIANCE%% 
				ADD COLUMN `ally_in_tournament` enum('0','1') NOT NULL DEFAULT '0' AFTER `ally_events`,
				ADD COLUMN `ally_tournament_units_destroyed` int(11) NOT NULL DEFAULT 0 AFTER `ally_in_tournament`,
				ADD COLUMN `ally_tournament_total_destroy` int(11) NOT NULL DEFAULT 0 AFTER `ally_tournament_units_destroyed`,
			");
			//tournament_users
			$db->nativeQuery("CREATE TABLE IF NOT EXISTS %%TWOAU%% 
				`id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				`user_id` int(11) NOT NULL DEFAULT 0,
				`t_battles` text,
				`lost_points` int(11) NOT NULL DEFAULT 0,
				`alliance_id` int(11) NOT NULL DEFAULT 0,
			");
			//tournament
			$db->nativeQuery("CREATE TABLE IF NOT EXISTS %%TWOA%% 
				`id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				`total_alliances` int(11) NOT NULL DEFAULT 0,
				`alliances_winers` text,
			");
		}
	}
}
