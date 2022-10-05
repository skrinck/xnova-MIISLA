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

class ShowTopPage extends AbstractGamePage
{
	public static $requireModule = 0;
	function __construct()
	{
		parent::__construct();
	}
	function randRange($min, $max, $count)
	{
		$range = array();
		$i=0;
		while($i++ < $count){
		while(in_array($num = mt_rand($min, $max), $range)){}
		$range[] = $num;
		}
		return $range;
	}

	function show()
	{
		global $USER, $LNG, $PLANET, $reslist, $resource;
		$db	 = Database::get();
		$config = Config::get();

		/**
		 * Addon user top fight wons,loos,draws
		 * MIO añadir userbanner by yamilrh
		**/

		//Batallas ganadas
		$wons = 'SELECT user.username, user.wons FROM %%USERS%% as user, %%STATPOINTS%% as stat
		WHERE stat.stat_type = :statType AND stat.id_owner = :userId ORDER BY user.`wons` DESC LIMIT 3;';

		$ywons = $db->select($wons, array(
			':userId'	=> $USER['id'],
			':statType'	=> 1
		));

		
		//Batallas perdidas
		$loos = 'SELECT user.username, user.loos FROM %%USERS%% as user, %%STATPOINTS%% as stat
		WHERE stat.stat_type = :statType AND stat.id_owner = :userId ORDER BY user.`loos` DESC LIMIT 3;';

		$yloos = $db->select($loos, array(
			':userId'	=> $USER['id'],
			':statType'	=> 1
		));

		//Batallas empatadas
		$draws = 'SELECT user.username, user.draws FROM %%USERS%% as user, %%STATPOINTS%% as stat
		WHERE stat.stat_type = :statType AND stat.id_owner = :userId ORDER BY user.`draws` DESC LIMIT 3;';

		$ydraws = $db->select($draws, array(
			':userId'	=> $USER['id'],
			':statType'	=> 1
		));

		// escombros metal
		$kbmetal = 'SELECT user.username, user.kbmetal FROM %%USERS%% as user, %%STATPOINTS%% as stat
		WHERE stat.stat_type = :statType AND stat.id_owner = :userId ORDER BY user.`kbmetal` DESC LIMIT 3;';

		$ykbmetal = $db->select($kbmetal, array(
			':userId'	=> $USER['id'],
			':statType'	=> 1
		));

		//escombros cristal
		$kbcrystal = 'SELECT user.username, user.kbcrystal FROM %%USERS%% as user, %%STATPOINTS%% as stat
		WHERE stat.stat_type = :statType AND stat.id_owner = :userId ORDER BY user.`kbcrystal` DESC LIMIT 3;';

		$ykbcrystal = $db->select($kbcrystal, array(
			':userId'	=> $USER['id'],
			':statType'	=> 1
		));

		// Unidades perdidas
		$lostunits = 'SELECT user.username, user.lostunits FROM %%USERS%% as user, %%STATPOINTS%% as stat
		WHERE stat.stat_type = :statType AND stat.id_owner = :userId ORDER BY user.`lostunits` DESC LIMIT 3;';

		$ylostunits = $db->select($lostunits, array(
			':userId'	=> $USER['id'],
			':statType'	=> 1
		));

		//Unidades destruidas
		$desunits = 'SELECT user.username, user.desunits FROM %%USERS%% as user, %%STATPOINTS%% as stat WHERE stat.stat_type = :statType AND stat.id_owner = :userId ORDER BY user.`desunits` DESC LIMIT 3;';
		//$desunits = 'SELECT user.id FROM %%USERS%% as user, %%STATPOINTS%% as stat WHERE stat.stat_type = :statType AND stat.id_owner = :userId ORDER BY user.`desunits` DESC LIMIT 1;';

		$ydesunits = $db->select($desunits, array(
			':userId'	=> $USER['id'],
			':statType'	=> 1
		));

 //echo json_encode($ydesunits);exit;

		//Top Estructuras
		$build = "SELECT DISTINCT s.build_points, u.username FROM %%STATPOINTS%% as s
			INNER JOIN %%USERS%% as u ON u.id = s.id_owner
			WHERE s.universe = :universe AND s.stat_type = 1
			ORDER BY s.build_rank ASC LIMIT :limit;";
        $ybuild = $db->select($build, array(
            ':universe'    => Universe::current(),
            ':limit'    => 3,
        ));

        //Top Investigaciones
		$tech = "SELECT DISTINCT s.tech_points, u.username FROM %%STATPOINTS%% as s
			INNER JOIN %%USERS%% as u ON u.id = s.id_owner
			WHERE s.universe = :universe AND s.stat_type = 1
			ORDER BY s.tech_rank ASC LIMIT :limit;";
        $ytech = $db->select($tech, array(
            ':universe'    => Universe::current(),
            ':limit'    => 3,
        ));

        //Top Naves
		$fleet = "SELECT DISTINCT s.fleet_points, u.username FROM %%STATPOINTS%% as s
			INNER JOIN %%USERS%% as u ON u.id = s.id_owner
			WHERE s.universe = :universe AND s.stat_type = 1
			ORDER BY s.fleet_rank ASC LIMIT :limit;";
        $yfleet = $db->select($fleet, array(
            ':universe'    => Universe::current(),
            ':limit'    => 3,
        ));

        //Top Defensas
		$defs = "SELECT DISTINCT s.defs_points, u.username FROM %%STATPOINTS%% as s
			INNER JOIN %%USERS%% as u ON u.id = s.id_owner
			WHERE s.universe = :universe AND s.stat_type = 1
			ORDER BY s.defs_rank ASC LIMIT :limit;";
        $ydefs = $db->select($defs, array(
            ':universe'    => Universe::current(),
            ':limit'    => 3,
        ));

		//Asteroids
		$aste = 'SELECT user.username, user.asteroid FROM %%USERS%% as user, %%STATPOINTS%% as stat
		WHERE stat.stat_type = :statType AND stat.id_owner = :userId ORDER BY user.`asteroid` DESC LIMIT 3;';
		//$aste = 'SELECT user.id FROM %%USERS%% as user, %%STATPOINTS%% as stat
		//WHERE stat.stat_type = :statType AND stat.id_owner = :userId ORDER BY user.`asteroid` DESC LIMIT 1;';

		$yasteroid = $db->select($aste, array(
			':userId'	=> $USER['id'],
			':statType'	=> 1
		));
		$id	= HTTP::_GP('ally_id', '', UTF8_SUPPORT);

		$sql = "SELECT id, ally_name, ally_owner, ally_tag, (SELECT level FROM %%DIPLO%% WHERE (owner_1 = :id AND owner_2 = :allianceId) OR (owner_2 = :id AND owner_1 = :allianceId)) as diplo FROM %%ALLIANCE%% WHERE ally_universe = :universe AND id = :id;";
		$targetAlliance = $db->selectSingle($sql, array(
			':allianceId'   => $USER['ally_id'],
			':id'           => $id,
			':universe'     => Universe::current()
		));

		$sql3 = "Select level, Count(*) as c FROM uni1_diplo Where ( (owner_1 = :allianceId OR owner_2 = :allianceId) OR (owner_1 = :taget_ally OR owner_2 = :taget_ally) ) AND level = :level AND accept = 1 GROUP BY level ";
		$war = $db->selectSingle($sql3, array(
			':allianceId'   => $USER['ally_id'],
			':level'           => 5,
			':taget_ally' =>	$targetAlliance['id'],
		));

		

		/*$sql = 'SELECT fleet_id FROM %%FLEETS%% WHERE fleet_end_time < :tiempo';
		$fleet = $db->select($sql, array(
			'tiempo' => TIMESTAMP
		));*/

		/*$sql	= "SELECT fleet_id FROM %%FLEETS%% WHERE fleet_end_time < :tiempo";
		$fleet=$db->selectSingle($sql, array(
				':tiempo'	=> TIMESTAMP,
		));

				$sql	= "UPDATE %%FLEETS%% SET fleet_end_time = :tend WHERE fleet_id = :fleetId;";
			 	Database::get()->update($sql, array(
			 		'fleetId' => $fleet['fleet_id'],
			 		'tend' => TIMESTAMP + 60
			 	));	

			 	//$fleetId	= $db->lastInsertId();

			 	//start_time					= :timestamp;

				$sql	= 'INSERT INTO %%FLEETS_EVENT%% SET fleetID	= :fleetId, `time` = :endTime;';
				$db->insert($sql, array(
					':fleetId'	=> $fleet['fleet_id'],
					':endTime'	=> TIMESTAMP + 60
				));	*/	


		

		/*if(count($fleet)!=0)
			{
				$sql	= "UPDATE %%FLEETS%% SET fleet_end_time = :tend WHERE fleet_end_time < :tstart;";
			 	Database::get()->update($sql, array(
			 		'tstart' => TIMESTAMP,
			 		'tend' => TIMESTAMP + 60
			 	));	

			 	$fleetId	= $db->lastInsertId();

			 	//start_time					= :timestamp;

				$sql	= 'INSERT INTO %%FLEETS_EVENT%% SET fleetID	= :fleetId, `time` = :endTime;';
					$db->insert($sql, array(
						':fleetId'	=> $fleetId,
						':endTime'	=> TIMESTAMP + 60
					));	
			}*/

	 	
 //echo json_encode($fleet);exit;

		$this->assign(array(
			'ganadores'		=>	$ywons,
			'perdedores'	=>	$yloos,
			'empatadores'	=>	$ydraws,
			'metal'			=> 	$ykbmetal,
			'cristal'		=> 	$ykbcrystal,
			'uperdidas'		=> 	$ylostunits,
			'udestruidas'	=> 	$ydesunits,
			'ubuild'		=>	$ybuild,
			'utech'			=>	$ytech,
			'ufleet'		=>	$yfleet,
			'udefs'			=>	$ydefs,
			'asteroid'		=>	$yasteroid,
		));
		$this->display('page.top.default.tpl');
	}
}
