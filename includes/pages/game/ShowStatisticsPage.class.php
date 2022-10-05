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

class ShowStatisticsPage extends AbstractGamePage
{
    public static $requireModule = MODULE_STATISTICS;

	function __construct() 
	{
		parent::__construct();
	}

    function show()
    {
        global $USER, $LNG;

        $who   	= HTTP::_GP('who', 1);
        $type  	= HTTP::_GP('type', 1);
        $range 	= HTTP::_GP('range', 1);

        switch ($type)
        {
            case 2:
                $Order   = "fleet_rank";
                $Points  = "fleet_points";
                $Rank    = "fleet_rank";
                $OldRank = "fleet_old_rank";
            break;
            case 3:
                $Order   = "tech_rank";
                $Points  = "tech_points";
                $Rank    = "tech_rank";
                $OldRank = "tech_old_rank";
            break;
            case 4:
                $Order   = "build_rank";
                $Points  = "build_points";
                $Rank    = "build_rank";
                $OldRank = "build_old_rank";
            break;
            case 5:
                $Order   = "defs_rank";
                $Points  = "defs_points";
                $Rank    = "defs_rank";
                $OldRank = "defs_old_rank";
            break;
            default:
                $Order   = "total_rank";
                $Points  = "total_points";
                $Rank    = "total_rank";
                $OldRank = "total_old_rank";
            break;
        }

        $RangeList  = array();

		$db 	= Database::get();
		$config	= Config::get();

        switch($who)
        {
            case 1:
                $MaxUsers 	= $config->users_amount;
                $range		= min($range, $MaxUsers);
                $LastPage 	= max(1, ceil($MaxUsers / 100));

                for ($Page = 0; $Page < $LastPage; $Page++)
                {
                    $PageValue      				= ($Page * 100) + 1;
                    $PageRange      				= $PageValue + 99;
                    $Selector['range'][$PageValue] 	= $PageValue."-".$PageRange;
                }

                $start = max(floor(($range - 1) / 100) * 100, 0);

				if ($config->stat == 2) {
					$sql = "SELECT DISTINCT s.*, u.id, u.username, u.authlevel, u.ally_id, u.banaday, u.urlaubs_modus, u.onlinetime, u.race, u.torneo, u.top1, u.top2, u.top3, u.desunits, a.ally_name, a.ally_members, a.ally_tag, a.ally_fraction_id, a.ally_fraction_level, (a.ally_owner=u.id) as is_leader, a.ally_owner_range FROM %%STATPOINTS%% as s
					INNER JOIN %%USERS%% as u ON u.id = s.id_owner
					LEFT JOIN %%ALLIANCE%% as a ON a.id = s.id_ally
					WHERE s.universe = :universe AND s.stat_type = 1 AND u.authlevel < :authLevel
					ORDER BY ".$Order." ASC LIMIT :offset, :limit;";
					$query = $db->select($sql, array(
						':universe'	=> Universe::current(),
						':authLevel'=> $config->stat_level,
						':offset'	=> $start,
						':limit'	=> 100,
					));
				} else {
					$sql = "SELECT DISTINCT s.*, u.id, u.username, u.authlevel, u.ally_id, u.banaday, u.urlaubs_modus, u.onlinetime, u.race, u.torneo, u.top1, u.top2, u.top3, u.desunits, a.ally_name, a.ally_members, a.ally_tag, a.ally_fraction_id, a.ally_fraction_level, (a.ally_owner=u.id) as is_leader, a.ally_owner_range FROM %%STATPOINTS%% as s
					INNER JOIN %%USERS%% as u ON u.id = s.id_owner
					LEFT JOIN %%ALLIANCE%% as a ON a.id = s.id_ally
					WHERE s.universe = :universe AND s.stat_type = 1
					ORDER BY " . $Order . " ASC LIMIT :offset, :limit;";
                    $query = $db->select($sql, array(
                        ':universe'    => Universe::current(),
                        ':offset'    => $start,
                        ':limit'    => 100,
                    ));
                }

                $RangeList    = array();

                try {
                    $USER    += $db->selectSingle('SELECT total_points FROM %%STATPOINTS%% WHERE id_owner = :userId', array(
                        ':userId'    => $USER['id'],
                    ));
                } catch (Exception $e) {
                    $USER['total_points'] = 0;
                }

               /* try {
                    $USER    += $db->selectSingle('SELECT race FROM %%USERS%% WHERE id_owner = :userId', array(
                        ':userId'    => $USER['id'],
                    ));
                } catch (Exception $e) {
                    $USER['race'] = 0;
                }*/


                foreach ($query as $StatRow) {
                    $IsNoobProtec = CheckNoobProtec($USER, $StatRow, $StatRow);
                    $Class                 = userStatus($StatRow, $IsNoobProtec);

                    $RangeList[]    = array(
                        'id'        => $StatRow['id'],
                        'name'        => $StatRow['username'],
                        'class'        => $Class,
                        'is_leader'    => $StatRow['is_leader'],
                        'ally_owner_range'    => $StatRow['ally_owner_range'],
                        'points'    => pretty_number($StatRow[$Points]),
                        'allyid'    => $StatRow['ally_id'],
                        'rank'        => $StatRow[$Rank],
                        'allyname'    => $StatRow['ally_name'],
                        'members'   => $StatRow['ally_members'],
                        'allytag'   => $StatRow['ally_tag'],
                        'ally_fraction_id'  => $StatRow['ally_fraction_id'],
                        'ally_fraction_level'   => $StatRow['ally_fraction_level'],
                        'ally_fraction_name'    => $LNG['all_frac_'.$StatRow['ally_fraction_id']],
                        'ranking'    => $StatRow[$OldRank] - $StatRow[$Rank],
                        'ranking'   => $StatRow[$OldRank] - $StatRow[$Rank],
                        'rankfleet'     => pretty_number($StatRow['fleet_rank']),
                        'rankbuild'     => pretty_number($StatRow['build_rank']),
                        'rankdefs'      => pretty_number($StatRow['defs_rank']),
                        'ranktech'      => pretty_number($StatRow['tech_rank']),
                        'point'         => $StatRow['total_points'],
                        'race'         => $StatRow['race'],
                        'torneo'         => $StatRow['torneo'],
                        'top1'         => $StatRow['top1'],
                        'top2'         => $StatRow['top2'],
                        'top3'         => $StatRow['top3'],
                        'desunits'         => $StatRow['desunits'],
                    );
                }

            break;
            case 2:
                $sql = "SELECT COUNT(*) as state FROM %%ALLIANCE%% WHERE `ally_universe` = :universe;";
				$MaxAllys = $db->selectSingle($sql, array(
					':universe'	=> Universe::current(),
				), 'state');

				$range		= min($range, $MaxAllys);
                $LastPage 	= max(1, ceil($MaxAllys / 100));
				
                for ($Page = 0; $Page < $LastPage; $Page++)
                {
                    $PageValue      				= ($Page * 100) + 1;
                    $PageRange      				= $PageValue + 99;
                    $Selector['range'][$PageValue] 	= $PageValue."-".$PageRange;
                }

                $start = max(floor(($range - 1) / 100) * 100, 0);

                $sql = 'SELECT DISTINCT s.*, a.id, a.ally_members, a.ally_name, a.ally_tag, a.ally_fraction_id, a.ally_fraction_level FROM %%STATPOINTS%% as s
                INNER JOIN %%ALLIANCE%% as a ON a.id = s.id_owner
                WHERE universe = :universe AND stat_type = 2
                ORDER BY '.$Order.' ASC LIMIT :offset, :limit;';
				$query = $db->select($sql, array(
					':universe'	=> Universe::current(),
					':offset'	=> $start,
					':limit'	=> 100,
				));



				foreach ($query as $StatRow)
                {
                    $RangeList[]	= array(
                        'id'		=> $StatRow['id'],
                        'name'		=> $StatRow['ally_name'],
                        'members'	=> $StatRow['ally_members'],
                        'rank'		=> $StatRow[$Rank],
                        'mppoints'	=> pretty_number(floor($StatRow[$Points] / $StatRow['ally_members'])),
                        'points'	=> pretty_number($StatRow[$Points]),
                        'ranking'   => $StatRow[$OldRank] - $StatRow[$Rank],
                        'ypoint'	=> $StatRow[$Points],
                        'ally_fraction_id'  => $StatRow['ally_fraction_id'],
                        'ally_fraction_level'   => $StatRow['ally_fraction_level'],
                        'ally_fraction_name'    => $LNG['all_frac_'.$StatRow['ally_fraction_id']],
                    );
                }

                

            break;
        }

        $Selector['who'] 	= array(1 => $LNG['st_player'], 2 => $LNG['st_alliance']);
        $Selector['type']	= array(1 => $LNG['st_points'], 2 => $LNG['st_fleets'], 3 => $LNG['st_researh'], 4 => $LNG['st_buildings'], 5 => $LNG['st_defenses']);

	$sql =  "SELECT nextTime FROM %%CRONJOBS%% WHERE cronjobID = :cronId;";
        $nextTime = $db->selectSingle($sql, array(
            ':cronId'           => 2
        ), 'nextTime');

    //Unidades destruidas
        //$desunits = 'SELECT user.username, user.desunits FROM %%USERS%% as user, %%STATPOINTS%% as stat WHERE stat.stat_type = :statType AND stat.id_owner = :userId ORDER BY user.`desunits` DESC LIMIT 1;';
        $desunits = 'SELECT * FROM %%USERS%% as user, %%STATPOINTS%% as stat WHERE stat.stat_type = :statType AND stat.id_owner = :userId ORDER BY `desunits` DESC LIMIT 1;';

        $ydesunits = $db->select($desunits, array(
           ':userId'   => $USER['id'],
            ':statType' => 1
        ));

        foreach ($ydesunits as $yRow)
            {
                $ydesunitsList[]    = array(
                    'id'        => $yRow['id'],
                );
            }

       //echo json_encode($ydesunits);exit;


		require_once 'includes/classes/Cronjob.class.php';

        $this->assign(array(
            'ydesunitsList'                  => $ydesunitsList,
            'Selectors'                => $Selector,
            'who'                    => $who,
            'type'                    => $type,
            'range'                    => floor(($range - 1) / 100) * 100 + 1,
            'RangeList'                => $RangeList,
            'CUser_ally'            => $USER['ally_id'],
            'CUser_id'                => $USER['id'],
            'stat_date'                => _date($LNG['php_tdformat'], Cronjob::getLastExecutionTime('statistic'), $USER['timezone']),
            'ShortStatus'               => array(
                'vacation'                  => $LNG['gl_short_vacation'],
                'banned'                    => $LNG['gl_short_ban'],
                'inactive'                  => $LNG['gl_short_inactive'],
                'longinactive'              => $LNG['gl_short_long_inactive'],
                'noob'                      => $LNG['gl_short_newbie'],
                'strong'                    => $LNG['gl_short_strong'],
                'enemy'                     => $LNG['gl_short_enemy'],
                'friend'                    => $LNG['gl_short_friend'],
                'member'                    => $LNG['gl_short_member'],
                'rol1'                      => $LNG['gl_short_rol1'],
                'rol2'                      => $LNG['gl_short_rol2'],
                'rol3'                      => $LNG['gl_short_rol3'],
            ),
	'nextStatUpdate'      => abs(TIMESTAMP - $nextTime),
            //Unidades destruidas
            
        ));

       // print_r($StatRow['username']);exit;

        $this->display('page.statistics.default.tpl');
    }
}
