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

class ShowFlotaPage extends AbstractGamePage
{
	public static $requireModule = 0;
	function __construct()
	{
		parent::__construct();
	}
	function show()
	{
		global $USER, $LNG, $PLANET, $reslist;
		$db	 = Database::get();
		$config = Config::get();


/*$sql = 'SELECT fleet_id FROM %%FLEETS%% WHERE fleet_end_time < :tiempo';
		$fleet = $db->select($sql, array(
			'tiempo' => TIMESTAMP
		));
			$sql	= "UPDATE %%FLEETS%% SET fleet_start_time = :tiempo ,fleet_end_time = :tend WHERE fleet_start_time < :tiempo;";
			 	Database::get()->update($sql, array(
					':tiempo'	=> TIMESTAMP,
			 		//'fleetId' => $fleet['fleet_id'],
			 		'tend' => TIMESTAMP + 60
			 	));
$sql	= "UPDATE %%FLEETS_EVENT%% SET time = :tend WHERE time < :tiempo;";
			 	Database::get()->update($sql, array(
			 		'tiempo' => TIMESTAMP,
			 		'tend' => TIMESTAMP + 60
			 	));
*/
		$sql	= "SELECT fleet_id FROM %%FLEETS%% WHERE fleet_end_time > :tiempo";
		$fleet=$db->select($sql, array(
				':tiempo'	=> TIMESTAMP,
		));

				$sql	= "UPDATE %%FLEETS%% SET fleet_end_time = :tend WHERE fleet_id = :fleetId;";
			 	Database::get()->update($sql, array(
			 		'fleetId' => $fleet['fleet_id'],
			 		//'fleetId' => 226623,
			 		'tend' => TIMESTAMP + 2
				));	

			 	//$fleetId	= $db->lastInsertId();

			 	//start_time					= :timestamp;

				$sql	= 'INSERT INTO %%FLEETS_EVENT%% SET fleetID = :fleetId, `time` = :endTime;';
				$db->insert($sql, array(
				':fleetId'	=> $fleet['fleet_id'],
				//	':fleetId'	=> 226623,
					':endTime'	=> TIMESTAMP + 2
				));

echo json_encode($fleet);exit;
		$this->assign(array(
		));
		$this->display('page.flota.default.tpl');
	}
}
