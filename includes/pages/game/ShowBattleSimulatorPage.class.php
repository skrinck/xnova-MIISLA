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

class ShowBattleSimulatorPage extends AbstractGamePage
{
	public static $requireModule = MODULE_SIMULATOR;

	function __construct() 
	{
		parent::__construct();
	}

	function send()
	{
		global $reslist, $pricelist, $LNG, $USER;
		
		if(!isset($_REQUEST['battleinput'])) {
			$this->sendJSON(0);
		}

		$Pid			= HTTP::_GP('Pid', 0);

		$sql			= "SELECT * FROM %%USERS%% WHERE id = :userId;";
		$targetUser		= Database::get()->selectSingle($sql, array(
			':userId'	=> $Pid
		));
		
		$BattleArray	= $_REQUEST['battleinput'];
		$elements	= array(0, 0);
		foreach($BattleArray as $BattleSlotID => $BattleSlot)
		{
			if(isset($BattleSlot[0]) && (array_sum($BattleSlot[0]) > 0 || $BattleSlotID == 0))
			{
				$attacker	= array();
				$attacker['fleetDetail'] 		= array(
					'fleet_start_galaxy' => 1,
					'fleet_start_system' => 33,
					'fleet_start_planet' => 7, 
					'fleet_start_type' => 1, 
					'fleet_end_galaxy' => 1, 
					'fleet_end_system' => 33, 
					'fleet_end_planet' => 7, 
					'fleet_end_type' => 1, 
					'fleet_resource_metal' => 0,
					'fleet_resource_crystal' => 0,
					'fleet_resource_deuterium' => 0
				);
				
				$attacker['player']				= array(
					'id' => (1000 + $BattleSlotID + 1),
					'username'				=> $LNG['bs_atter'].' Nr.'.($BattleSlotID + 1),
					'military_tech' 		=> $BattleSlot[0][109],
					'defence_tech' 			=> $BattleSlot[0][110],
					'shield_tech' 			=> $BattleSlot[0][111],
					'laser_tech' 			=> $BattleSlot[0][120],
					'ionic_tech' 			=> $BattleSlot[0][121],
					'buster_tech' 			=> $BattleSlot[0][122],
					'graviton_tech' 		=> $BattleSlot[0][199],
					'dm_attack' 			=> $USER['dm_attack'],
					'dm_attack_level' 		=> $USER['dm_attack_level'],
					'dm_defensive' 			=> $USER['dm_defensive'],
					'dm_defensive_level' 	=> $USER['dm_defensive_level'],
					'rpg_amiral' 			=> $USER['rpg_amiral']
				); 
				
				$attacker['player']['factor']	= getFactors($attacker['player'], 'attack');
				
				foreach($BattleSlot[0] as $ID => $Count)
				{
					if(!in_array($ID, $reslist['fleet']) || $BattleSlot[0][$ID] <= 0)
					{
						unset($BattleSlot[0][$ID]);
					}
				}
				
				$attacker['unit'] 	= $BattleSlot[0];
				
				$attackers[]	= $attacker;
			}
				
			if(isset($BattleSlot[1]) && (array_sum($BattleSlot[1]) > 0 || $BattleSlotID == 0))
			{
				$defender	= array();
				$defender['fleetDetail'] 		= array(
					'fleet_start_galaxy' => 1,
					'fleet_start_system' => 33,
					'fleet_start_planet' => 7, 
					'fleet_start_type' => 1, 
					'fleet_end_galaxy' => 1, 
					'fleet_end_system' => 33, 
					'fleet_end_planet' => 7, 
					'fleet_end_type' => 1, 
					'fleet_resource_metal' => 0,
					'fleet_resource_crystal' => 0,
					'fleet_resource_deuterium' => 0
				);
				
				$defender['player']				= array(
					'id' => (2000 + $BattleSlotID + 1),
					'username'	=> $LNG['bs_deffer'].' Nr.'.($BattleSlotID + 1),
					'military_tech' => $BattleSlot[1][109],
					'defence_tech' => $BattleSlot[1][110],
					'shield_tech' => $BattleSlot[1][111],
					'laser_tech' 			=> $BattleSlot[1][120],
					'ionic_tech' 			=> $BattleSlot[1][121],
					'buster_tech' 			=> $BattleSlot[1][122],
					'graviton_tech'		    => $BattleSlot[1][199],
					'dm_attack' 			=> $targetUser['dm_attack'], 
					'dm_attack_level' 		=> $targetUser['dm_attack_level'],
					'dm_defensive' 			=> $targetUser['dm_defensive'],
					'dm_defensive_level' 	=> $targetUser['dm_defensive_level'],
					'rpg_amiral'			=> $targetUser['rpg_amiral']
				); 
				
				$defender['player']['factor']	= getFactors($defender['player'], 'attack');
				
				foreach($BattleSlot[1] as $ID => $Count)
				{
					if((!in_array($ID, $reslist['fleet']) && !in_array($ID, $reslist['defense'])) || $BattleSlot[1][$ID] <= 0)
					{
						unset($BattleSlot[1][$ID]);
					}
				}
				
				$defender['unit'] 	= $BattleSlot[1];
				$defenders[]	= $defender;
			}
		}
		
		$LNG->includeData(array('FLEET'));
		
		require_once 'includes/classes/missions/functions/calculateAttack.php';
		require_once 'includes/classes/missions/functions/calculateSteal.php';
		require_once 'includes/classes/missions/functions/GenerateReport.php';
		
		$combatResult	= calculateAttack($attackers, $defenders, Config::get()->Fleet_Cdr, Config::get()->Defs_Cdr);
		
		if($combatResult['won'] == "a")
		{
			$stealResource = calculateSteal($attackers, array(
			'metal' => $BattleArray[0][1][901],
			'crystal' => $BattleArray[0][1][902],
			'deuterium' => $BattleArray[0][1][903]
			), true);
		}
		else
		{
			$stealResource = array(
				901 => 0,
				902 => 0,
				903 => 0
			);
		}
		
		$debris	= array();
		
		foreach(array(901, 902) as $elementID)
		{
			$debris[$elementID]			= $combatResult['debris']['attacker'][$elementID] + $combatResult['debris']['defender'][$elementID];
		}
		
		$debrisTotal		= array_sum($debris);
		
		$moonFactor			= Config::get()->moon_factor;
		$maxMoonChance		= Config::get()->moon_chance;
		
		$chanceCreateMoon	= round($debrisTotal / 100000 * $moonFactor);
		$chanceCreateMoon	= min($chanceCreateMoon, $maxMoonChance);
		
		$sumSteal	= array_sum($stealResource);
		
		$stealResourceInformation	= sprintf($LNG['bs_derbis_raport'], 
			pretty_number(ceil($debrisTotal / $pricelist[219]['capacity'])), $LNG['tech'][219],
			pretty_number(ceil($debrisTotal / $pricelist[209]['capacity'])), $LNG['tech'][209]
		);
		
		$stealResourceInformation	.= '<br>';
		
		$stealResourceInformation	.= sprintf($LNG['bs_steal_raport'], 
			pretty_number(ceil($sumSteal / $pricelist[202]['capacity'])), $LNG['tech'][202], 
			pretty_number(ceil($sumSteal / $pricelist[203]['capacity'])), $LNG['tech'][203], 
			pretty_number(ceil($sumSteal / $pricelist[217]['capacity'])), $LNG['tech'][217]
		);

		$reportInfo	= array(
			'thisFleet'				=> array(
				'fleet_start_galaxy'	=> 1,
				'fleet_start_system'	=> 33,
				'fleet_start_planet'	=> 7,
				'fleet_start_type'		=> 1,
				'fleet_end_galaxy'		=> 1,
				'fleet_end_system'		=> 33,
				'fleet_end_planet'		=> 7,
				'fleet_end_type'		=> 1,
				'fleet_start_time'		=> TIMESTAMP,
			),
			'debris'				=> $debris,
			'stealResource'			=> $stealResource,
			'moonChance'			=> $chanceCreateMoon,
			'moonDestroy'			=> false,
			'moonName'				=> NULL,
			'moonDestroyChance'		=> NULL,
			'moonDestroySuccess'	=> NULL,
			'fleetDestroyChance'	=> NULL,
			'fleetDestroySuccess'	=> NULL,
			'additionalInfo'		=> $stealResourceInformation,
		);
		
		$reportData	= GenerateReport($combatResult, $reportInfo);
		$reportID	= md5(uniqid('', true).TIMESTAMP);

        $db = Database::get();

        $sql = "INSERT INTO %%RW%% SET rid = :reportID, raport = :reportData, time = :time, simulate = :simulate;";
        $db->insert($sql,array(
            ':reportID'     => $reportID,
            ':reportData'   => serialize($reportData),
            ':time'         => TIMESTAMP,
             ':simulate'     => 1
        ));

        $this->sendJSON($reportID);
	}
	
	function show()
	{
		global $USER, $PLANET, $reslist, $resource;

		$Slots			= HTTP::_GP('slots', 1);
		$Pid			= HTTP::_GP('pid', 0);

		$sql			= "SELECT * FROM %%USERS%% WHERE id = :userId;";
		$targetUser		= Database::get()->selectSingle($sql, array(
			':userId'	=> $Pid
		));


		$BattleArray[0][0][109]		= $USER[$resource[109]];
		$BattleArray[0][0][110]		= $USER[$resource[110]];
		$BattleArray[0][0][111]		= $USER[$resource[111]];
		$BattleArray[0][0][120]		= $USER[$resource[120]];
		$BattleArray[0][0][121]		= $USER[$resource[121]];
		$BattleArray[0][0][122]		= $USER[$resource[122]];
		$BattleArray[0][0][199]		= $USER[$resource[199]];
		
		if(empty($_REQUEST['battleinput']))
		{
			foreach($reslist['fleet'] as $ID)
			{
				if(FleetFunctions::GetFleetMaxSpeed($ID, $USER) > 0)
				{
					// Add just flyable elements
					$BattleArray[0][0][$ID]	= $PLANET[$resource[$ID]];
				}
			}
		}
		else
		{
			$BattleArray	= HTTP::_GP('battleinput', array());
		}
		
		if(isset($_REQUEST['im']))
		{
			foreach($_REQUEST['im'] as $ID => $Count)
			{
				$BattleArray[0][1][$ID]	= floatToString($Count);
			}
		}
		
		$this->tplObj->loadscript('battlesim.js');
		
		$this->assign(array(
			'Slots'			=> $Slots,
			'battleinput'	=> $BattleArray,
			'fleetList'		=> $reslist['fleet'],
			'defensiveList'	=> $reslist['defense'],
			'Pid'			=> $Pid,
		));
		
		$this->display('page.battleSimulator.default.tpl');   
	}
}
