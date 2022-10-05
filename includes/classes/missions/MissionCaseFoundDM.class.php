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

class MissionCaseFoundDM extends MissionFunctions implements Mission
{
	const CHANCE = 40; 
	const CHANCE_SHIP = 0.49; 
	const MIN_FOUND = 1500; 
	const MAX_FOUND = 4278; 
	const MAX_CHANCE = 35; 
		
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{
		$this->setState(FLEET_HOLD);
		$this->SaveFleet();
	}
	
	function EndStayEvent()
	{
		$LNG	= $this->getLanguage(NULL, $this->_fleet['fleet_owner']);
		$chance	= mt_rand(0, 100);
		if($chance <= min(self::MAX_CHANCE, (self::CHANCE + $this->_fleet['fleet_amount'] * self::CHANCE_SHIP))) {

			/**
			*Bonus Mod by Jekill
			**/
			$max_found = self::MAX_FOUND;

			if(is_bonus_active('mo')){
				$bonus_data = get_bonus_data('mo');
				$max_found = self::MAX_FOUND + (self::MAX_FOUND * ($bonus_data['procent']/100));
			}
			
			$FoundDark 	= mt_rand(self::MIN_FOUND, self::MAX_FOUND);
			$this->UpdateFleet('fleet_resource_darkmatter', $FoundDark);
			$Message 	= $LNG['sys_expe_found_dm_'.mt_rand(1, 3).'_'.mt_rand(1, 2).''];
			if($FoundDark > 0){
						tournement($this->_fleet['fleet_owner'], 1, $FoundDark); //Mayor MO
						//tournement($this->_fleet['fleet_owner'], 7, 1); //Mayor MO
						tournement($this->_fleet['fleet_owner'], 5, 1); //mas expediciones exitosas
					}
		} else {
			$Message 	= $LNG['sys_expe_nothing_'.mt_rand(1, 9)];
		}
		$this->setState(FLEET_RETURN);
		$this->SaveFleet();

		PlayerUtil::sendMessage($this->_fleet['fleet_owner'], 0, $LNG['sys_mess_tower'], 15,
			$LNG['sys_expe_report'], $Message, $this->_fleet['fleet_end_stay'], NULL, 1, $this->_fleet['fleet_universe']);
	}
	
	function ReturnEvent()
	{
		$LNG	= $this->getLanguage(NULL, $this->_fleet['fleet_owner']);
		if($this->_fleet['fleet_resource_darkmatter'] > 0)
		{
			$message	= sprintf($LNG['sys_expe_back_home_with_dm'],
				$LNG['tech'][921],
				pretty_number($this->_fleet['fleet_resource_darkmatter']),
				$LNG['tech'][921]
			);

			$this->UpdateFleet('fleet_array', '220,0;');
		}
		else
		{
			$message	= $LNG['sys_expe_back_home_without_dm'];
		}

		PlayerUtil::sendMessage($this->_fleet['fleet_owner'], 0, $LNG['sys_mess_tower'], 4, $LNG['sys_mess_fleetback'],
			$message, $this->_fleet['fleet_end_time'], NULL, 1, $this->_fleet['fleet_universe']);

		$this->RestoreFleet();
	}
}