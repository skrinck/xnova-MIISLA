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


class ShowPlayerCardPage extends AbstractGamePage
{
    public static $requireModule = MODULE_PLAYERCARD;
	
	protected $disableEcoSystem = true;

	function __construct() 
	{
		parent::__construct();
	}
	
	function show()
	{
		global $USER, $LNG;
		
		$this->setWindow('popup');
		$this->initTemplate();

		$db = Database::get();

		$PlayerID 	= HTTP::_GP('id', 0);

		$sql = "SELECT 
				u.username, u.foto, u.galaxy, u.system, u.planet, u.wons, u.loos, u.draws, u.kbmetal, u.kbcrystal, u.lostunits, u.desunits, u.ally_id, u.achievement_common_1, u.achievement_common_2, u.achievement_build_1, u.achievement_build_2, u.achievement_build_3, u.achievement_build_4, u.achievement_build_5, u.achievement_build_6, u.achievement_build_7, u.achievement_build_8, u.achievement_build_9, u.achievement_build_10, u.achievement_fleet_1, u.achievement_fleet_2, u.achievement_fleet_3, u.achievement_fleet_4, u.achievement_fleet_5, u.achievement_fleet_6, u.achievement_fleet_7, u.achievement_varia_1, u.achievement_varia_2, u.achievement_varia_3, u.achievement_varia_4, u.achievement_varia_5, u.achievement_varia_6, u.achievement_varia_7, u.achievement_varia_8, u.achievement_tech_1, u.achievement_tech_2, u.achievement_tech_3, u.achievement_tech_4, u.achievement_tech_5, u.achievement_tech_6, u.achievement_tech_7, u.achievement_tech_8, u.achievement_tech_9, u.achievement_tech_10,
				p.name,
				s.tech_rank, s.tech_points, s.build_rank, s.build_points, s.defs_rank, s.defs_points, s.fleet_rank, s.fleet_points, s.total_rank, s.total_points,
				a.ally_name
				FROM %%USERS%% u
				INNER JOIN %%PLANETS%% p ON p.id = u.id_planet
				LEFT JOIN %%STATPOINTS%% s ON s.id_owner = u.id AND s.stat_type = 1
				LEFT JOIN %%ALLIANCE%% a ON a.id = u.ally_id
				WHERE u.id = :playerID AND u.universe = :universe;";
		$query = $db->selectSingle($sql, array(
			':universe'	=> Universe::current(),
			':playerID'	=> $PlayerID
		));

		$totalfights = $query['wons'] + $query['loos'] + $query['draws'];
		
		if ($totalfights == 0) {
			$siegprozent                = 0;
			$loosprozent                = 0;
			$drawsprozent               = 0;
		} else {
			$siegprozent                = 100 / $totalfights * $query['wons'];
			$loosprozent                = 100 / $totalfights * $query['loos'];
			$drawsprozent               = 100 / $totalfights * $query['draws'];
		}

		if ($query['lostunits'] == 0 || $query['desunits'] == 0) {
            $damageCoefficient = 0;
            $damageDes = 50;
            $damageLost = 50;
		} else {
            $damageCoefficient = $query['desunits']/$query['lostunits'];
            $damageDes = ($query['desunits']/($query['desunits'] + $query['lostunits'])) * 100;
            $damageLost = ($query['lostunits']/($query['desunits'] + $query['lostunits'])) * 100;
		}

	
		$this->assign(array(
			'id'			=> $PlayerID,
			'yourid'		=> $USER['id'],
			'name'			=> $query['username'],
			'homeplanet'	=> $query['name'],
			'galaxy'		=> $query['galaxy'],
			'system'		=> $query['system'],
			'planet'		=> $query['planet'],
			'allyid'		=> $query['ally_id'],
			'tech_rank'     => pretty_number($query['tech_rank']),
			'tech_points'   => pretty_number($query['tech_points']),
			'build_rank'    => pretty_number($query['build_rank']),
			'build_points'  => pretty_number($query['build_points']),
			'defs_rank'     => pretty_number($query['defs_rank']),
			'defs_points'   => pretty_number($query['defs_points']),
			'fleet_rank'    => pretty_number($query['fleet_rank']),
			'fleet_points'  => pretty_number($query['fleet_points']),
			'total_rank'    => pretty_number($query['total_rank']),
			'total_points'  => pretty_number($query['total_points']),
			'allyname'		=> $query['ally_name'],
			'playerdestory' => sprintf($LNG['pl_destroy'], $query['username']),
			'wons'          => pretty_number($query['wons']),
			'loos'          => pretty_number($query['loos']),
			'draws'         => pretty_number($query['draws']),
			'kbmetal'       => pretty_number($query['kbmetal']),
			'kbcrystal'     => pretty_number($query['kbcrystal']),
			'lostunits'     => pretty_number($query['lostunits']),
			'desunits'      => pretty_number($query['desunits']),
			'totalfights'   => pretty_number($totalfights),
			'siegprozent'   => round($siegprozent, 2),
			'loosprozent'   => round($loosprozent, 2),
			'drawsprozent'  => round($drawsprozent, 2),
			'useravatar' 				=> $USER['foto'],
			'useravatar1' 				=> $query['foto'],
			'achievement_common_1'  	=> pretty_number($query['achievement_common_1']),
			'achievement_common_2'   	=> pretty_number($query['achievement_common_2']),
			'achievement_build_1'   	=> pretty_number($query['achievement_build_1']),
			'achievement_build_2'   	=> pretty_number($query['achievement_build_2']),
			'achievement_build_3'   	=> pretty_number($query['achievement_build_3']),
			'achievement_build_4'   	=> pretty_number($query['achievement_build_4']),
			'achievement_build_5'   	=> pretty_number($query['achievement_build_5']),
			'achievement_build_6'   	=> pretty_number($query['achievement_build_6']),
			'achievement_build_7'   	=> pretty_number($query['achievement_build_7']),
			'achievement_build_8'   	=> pretty_number($query['achievement_build_8']),
			'achievement_build_9'   	=> pretty_number($query['achievement_build_9']),
			'achievement_build_10'  	=> pretty_number($query['achievement_build_10']),
			'achievement_tech_1'  		=> pretty_number($query['achievement_tech_1']),
			'achievement_tech_2'  		=> pretty_number($query['achievement_tech_2']),
			'achievement_tech_3'  		=> pretty_number($query['achievement_tech_3']),
			'achievement_tech_4'  		=> pretty_number($query['achievement_tech_4']),
			'achievement_tech_5'  		=> pretty_number($query['achievement_tech_5']),
			'achievement_tech_6'  		=> pretty_number($query['achievement_tech_6']),
			'achievement_tech_7'  		=> pretty_number($query['achievement_tech_7']),
			'achievement_tech_8'  		=> pretty_number($query['achievement_tech_8']),
			'achievement_tech_9'  		=> pretty_number($query['achievement_tech_9']),
			'achievement_tech_10'  		=> pretty_number($query['achievement_tech_10']),
			'achievement_fleet_1'   	=> pretty_number($query['achievement_fleet_1']),
			'achievement_fleet_2'   	=> pretty_number($query['achievement_fleet_2']),
			'achievement_fleet_3'   	=> pretty_number($query['achievement_fleet_3']),
			'achievement_fleet_4'   	=> pretty_number($query['achievement_fleet_4']),
			'achievement_fleet_5'   	=> pretty_number($query['achievement_fleet_5']),
			'achievement_fleet_6'   	=> pretty_number($query['achievement_fleet_6']),
			'achievement_fleet_7'   	=> pretty_number($query['achievement_fleet_7']),
			'achievement_varia_1'   	=> pretty_number($query['achievement_varia_1']),
			'achievement_varia_2'   	=> pretty_number($query['achievement_varia_2']),
			'achievement_varia_3'   	=> pretty_number($query['achievement_varia_3']),
			'achievement_varia_4'   	=> pretty_number($query['achievement_varia_4']),
			'achievement_varia_5'   	=> pretty_number($query['achievement_varia_5']),
			'achievement_varia_6'   	=> pretty_number($query['achievement_varia_6']),
			'achievement_varia_7'   	=> pretty_number($query['achievement_varia_7']),
			'achievement_varia_8'   	=> pretty_number($query['achievement_varia_8']),
			'achievement_common_1_title'=> sprintf($LNG['achiev_18'], $query['achievement_common_1']),
			'achievement_common_2_title'=> sprintf($LNG['achiev_20'], $query['achievement_common_2']),
			'achievement_build_1_title' => sprintf($LNG['achiev_75'], $query['achievement_build_1']),
			'achievement_build_2_title' => sprintf($LNG['achiev_76'], $query['achievement_build_2']),
			'achievement_build_3_title' => sprintf($LNG['achiev_77'], $query['achievement_build_3']),
			'achievement_build_4_title' => sprintf($LNG['achiev_78'], $query['achievement_build_4']),
			'achievement_build_5_title' => sprintf($LNG['achiev_79'], $query['achievement_build_5']),
			'achievement_build_6_title' => sprintf($LNG['achiev_80'], $query['achievement_build_6']),
			'achievement_build_7_title' => sprintf($LNG['achiev_81'], $query['achievement_build_7']),
			'achievement_build_8_title' => sprintf($LNG['achiev_82'], $query['achievement_build_8']),
			'achievement_build_9_title' => sprintf($LNG['achiev_83'], $query['achievement_build_9']),
			'achievement_build_10_title'=> sprintf($LNG['achiev_84'], $query['achievement_build_10']),
			'achievement_tech_1_title'	=> sprintf($LNG['achiev_105'], $query['achievement_tech_1']),
			'achievement_tech_2_title'	=> sprintf($LNG['achiev_106'], $query['achievement_tech_2']),
			'achievement_tech_3_title'	=> sprintf($LNG['achiev_107'], $query['achievement_tech_3']),
			'achievement_tech_4_title'	=> sprintf($LNG['achiev_108'], $query['achievement_tech_4']),
			'achievement_tech_5_title'	=> sprintf($LNG['achiev_109'], $query['achievement_tech_5']),
			'achievement_tech_6_title'	=> sprintf($LNG['achiev_110'], $query['achievement_tech_6']),
			'achievement_tech_7_title'	=> sprintf($LNG['achiev_111'], $query['achievement_tech_7']),
			'achievement_tech_8_title'	=> sprintf($LNG['achiev_112'], $query['achievement_tech_8']),
			'achievement_tech_9_title'	=> sprintf($LNG['achiev_113'], $query['achievement_tech_9']),
			'achievement_tech_10_title'	=> sprintf($LNG['achiev_114'], $query['achievement_tech_10']),
			'achievement_fleet_1_title' => sprintf($LNG['achiev_177'], $query['achievement_fleet_1']),
			'achievement_fleet_2_title' => sprintf($LNG['achiev_178'], $query['achievement_fleet_2']),
			'achievement_fleet_3_title' => sprintf($LNG['achiev_179'], $query['achievement_fleet_3']),
			'achievement_fleet_4_title' => sprintf($LNG['achiev_180'], $query['achievement_fleet_4']),
			'achievement_fleet_5_title' => sprintf($LNG['achiev_181'], $query['achievement_fleet_5']),
			'achievement_fleet_6_title' => sprintf($LNG['achiev_182'], $query['achievement_fleet_6']),
			'achievement_fleet_7_title' => sprintf($LNG['achiev_183'], $query['achievement_fleet_7']),
			'achievement_varia_1_title' => sprintf($LNG['achiev_145'], $query['achievement_varia_1']),
			'achievement_varia_2_title' => sprintf($LNG['achiev_146'], $query['achievement_varia_2']),
			'achievement_varia_3_title' => sprintf($LNG['achiev_147'], $query['achievement_varia_3']),
			'achievement_varia_4_title' => sprintf($LNG['achiev_148'], $query['achievement_varia_4']),
			'achievement_varia_5_title' => sprintf($LNG['achiev_149'], $query['achievement_varia_5']),
			'achievement_varia_6_title' => sprintf($LNG['achiev_150'], $query['achievement_varia_6']),
			'achievement_varia_7_title' => sprintf($LNG['achiev_151'], $query['achievement_varia_7']),
			'achievement_varia_8_title' => sprintf($LNG['achiev_152'], $query['achievement_varia_8']),
			'damageCoef'    => round($damageCoefficient, 2),
            'damageDes'     => $damageDes,
            'damageLost'    => $damageLost,
		));
		
		
		$this->display('page.playerCard.default.tpl');
	}
}

