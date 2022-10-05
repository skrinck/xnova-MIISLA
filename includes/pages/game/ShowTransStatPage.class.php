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

class ShowTransStatPage extends AbstractGamePage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}
	
	function show() 
	{
		global $resource, $USER, $PLANET;

		$db = Database::get();

		$sql = "SELECT * FROM %%TRANSSTAT%% WHERE sender = :user";

		$ComercioQuery = $db->select($sql, array(
			':user' => $USER['id'],
		));

		$ComercioSend = array();

		foreach ($ComercioQuery as $ComercioRow) {
			
			$ComercioSend[] = array(
				'recipient' => $ComercioRow['recipient'],
				'sendM' 	=> $ComercioRow['send_metal'],
				'sendC' 	=> $ComercioRow['send_crystal'],
				'sendD' 	=> $ComercioRow['send_deuterium'],
				'devoM' 	=> $ComercioRow['devo_metal'],
				'devoC' 	=> $ComercioRow['devo_crystal'],
				'devoD' 	=> $ComercioRow['devo_deuterium'],
				'difM'		=> $ComercioRow['send_metal'] - $ComercioRow['devo_metal'],
				'difC'		=> $ComercioRow['send_crystal'] - $ComercioRow['devo_crystal'],
				'difD'		=> $ComercioRow['send_deuterium'] - $ComercioRow['devo_deuterium'],
			);

		}

		$sql = "SELECT * FROM %%TRANSSTAT%% WHERE recipient = :user";

		$ComercioQuery = $db->select($sql, array(
			':user' => $USER['id'],
		));

		$ComercioRecipient = array();

		foreach ($ComercioQuery as $ComercioRow) {
			
			$ComercioRecipient[] = array(
				'send' 		=> $ComercioRow['sender'],
				'sendM' 	=> $ComercioRow['send_metal'],
				'sendC' 	=> $ComercioRow['send_crystal'],
				'sendD' 	=> $ComercioRow['send_deuterium'],
				'devoM' 	=> $ComercioRow['devo_metal'],
				'devoC' 	=> $ComercioRow['devo_crystal'],
				'devoD' 	=> $ComercioRow['devo_deuterium'],
				'difM'		=> $ComercioRow['send_metal'] - $ComercioRow['devo_metal'],
				'difC'		=> $ComercioRow['send_crystal'] - $ComercioRow['devo_crystal'],
				'difD'		=> $ComercioRow['send_deuterium'] - $ComercioRow['devo_deuterium'],
			);

		}

		$this->assign(array(
			'ComercioSend' 		=> $ComercioSend,
			'ComercioRecipient' => $ComercioRecipient,
		));

		$this->display('page.transstat.default.tpl');
	}
}
