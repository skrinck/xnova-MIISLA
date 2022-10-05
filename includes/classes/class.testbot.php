<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 0.1 (2011-07-03)
 * @link http://code.google.com/p/2moons/
 */

define('MICRO', microtime(true));
set_time_limit(0);

# Includes 
require_once('includes/classes/class.BuildFunctions.php');
require_once('includes/classes/ArrayUtil.class.php');
require_once('includes/classes/class.PlanetRessUpdate.php');
require_once('includes/pages/game/ShowResearchPage.class.php');
require_once('includes/pages/game/ShowShipyardPage.class.php');
require_once('includes/pages/game/ShowBuildingsPage.class.php');
require_once('includes/classes/class.FleetFunctions.php');
require_once('includes/classes/class.botminer.php');
require_once('includes/classes/class.botdefault.php');
require_once('includes/classes/class.botkrieger.php');
require_once('includes/classes/class.bothaendler.php');
require_once('includes/classes/class.botforscher.php');

# Action Classes
class FleetActions extends FleetFunctions
{
	function __construct(){}
}

class BuildActions extends ShowBuildingsPage
{
	function __construct(){}
}

class ResearchActions extends ShowResearchPage
{
	function __construct(){}
}

class ShipyardActions extends ShowShipyardPage
{
	function __construct(){}
}

$BUILD		= new BuildActions();
$RESEARCH	= new ResearchActions();
$SHIPYARD	= new ShipyardActions();
$FLEET		= new FleetActions();

class TestBot
{

		const VERSION = '0.1';
	
	# BOTS RUNTIME Settings
	
	const BOTS_MAX_PER_CALL		= 50;
	const BOTS_MAX_TRY_COLONIZE	= 10;
		# BOTS Online times
	const BOTS_ACTIVE_FROM	= 0;
	const BOTS_ACTIVE_TO	= 24;
	
	# BOTS Online times
	const BOTS_ALLOW_SAVE	= 0; 
	const BOTS_SAVE_FROM	= 22;
	const BOTS_SAVE_TO		= 6; 
	
	/*  Buildable IDs
		Syntax: array(BuildID => Chance)
	*/
	
	public static $MineIDs	= array(
		1 => 50,
		2 => 30, 
		3 => 20,
	);
	
	public static $EnergyIDs	= array(
		4 => 90,
		12 => 10,
	);
	
	public static $StorageIDs	= array(
		22 => 50,
		23 => 30, 
		24 => 20, 
	);
	
	public static $SpecialIDs	= array(
		6 => 8,
		14 => 20,
		15 => 10,
		21 => 17,
		31 => 16,
		33 => 11,
		34 => 10,
		44 => 8,
	);
	
	public static $MoonIDs	= array(
		14 => 20,
		21 => 17,
		31 => 16,
		34 => 10,
		41 => 10,
		42 => 7,
		43 => 1,
		44 => 8,
	);
	
	public static $TechBasicIDs	= array(
		106 => 12, 
		108 => 20, 
		109 => 20, 
		110 => 20, 
		111 => 4, 
		113 => 12, 
		114 => 9,
		124 => 8, 
	);
	
	public static $TechSpeedIDs	= array(
		115 => 8, 
		117 => 8, 
		118 => 11,
	);
	
	public static $TechEcoIDs	= array(
		131 => 20, 
		132 => 20, 
		133 => 20, 
	);
	
	public static $TechSpecialIDs	= array(
		120 => 12, 
		121 => 7, 
		122 => 5, 
		123 => 7, 
		199 => 1
	);
	
	public static $FleetBasicIDs	= array(
		202 => 200,
		203 => 150, 
		208 => 1, 
		209 => 500, 
		210 => 20, 
		212 => 300,
		217	=> 150,
		219	=> 150,
		220	=> 150,
	);
	
	public static $FleetAttackIDs	= array(
		204 => 345, 
		205 => 100, 
		206 => 30, 
		207 => 500, 
		211 => 200, 
		213 => 100,
		214 => 50, 
		215 => 150, 
		218 => 200, 
	);
	
	public static $DefBasicIDs	= array(
		401 => 150,
		402 => 150, 
		403 => 110,
		404 => 70,
		406 => 50,
		502 => 50,
	);
	
	public static $DefShieldIDs	= array(
		407 => 1,
		408 => 1,
	);

	static public function playBot($Bot)
	{

		$bot=NUll;
		switch ($Bot['race']) {
			case '1':
			 $bot	= new BotForscher($Bot);
			break;
			case '2':
			 $bot	= new BotMiner($Bot);
			break;			
			case '3':
			 $bot	= new BotKrieger($Bot);
			break;			
			case '4':
			 $bot	= new BotHaendler($Bot);
			break;
			default:
			$bot = new BotDefault($Bot);
			break;

		}
       
		$bot->Play();
	}
	
	static function getBots()
	{
		$Hour	= date('G', TIMESTAMP);
		if(self::BOTS_ACTIVE_FROM > $Hour || self::BOTS_ACTIVE_TO <= $Hour)
			return false;
			
		self::log("Iniciando Bot");
		$Bots = self::getDB()->select("SELECT DISTINCT SQL_BIG_RESULT b.id as bot_id, b.player, b.last_time, b.every_time, b.last_planet, u.* FROM %%BOTS%% b INNER JOIN %%USERS%% u ON u.`id` = b.player WHERE b.`last_time` + b.`every_time` * 60 < ".TIMESTAMP." GROUP BY b.id ORDER BY RAND() LIMIT ".self::BOTS_MAX_PER_CALL.";");	
		$nBots = self::getDB()->rowCount();
		self::log("Listo. Bot Encontrados: ". $nBots);
		if($nBots != 0) {
			$i=0;
            while($i<$nBots) {
                self::playBot($Bots[$i]);
                $i++;
            }
        }
	}

	static function getDB()
	{
		return Database::get();
	}
	
	static function getName()
	{
		$Name	= file(ROOT_PATH.'botnames.txt');
		return $Name[array_rand($Name)]; 
	}
	
	function __construct($Bot)
	{
        $this->USER 			= $Bot;
        $this->USER['factor'] 	= getFactors($this->USER);
        $this->COUNT			= array('PLANETS' => 0, 'MOONS' => 0);
	}

	static function log($LOG){
        if (function_exists('logging')) {
            logging('bot', $LOG);
        } else {
            $handle = fopen(ROOT_PATH.'includes/'.date('Y_m_d').'_bot.log', 'a+');
            if ($handle !== false) {
                fwrite($handle, '['.date('H:i:s').'] '.$LOG."\n");
                fflush($handle);
                fclose($handle);
            }
        }
	}
	
	function randomNum($Min, $Max)
	{
		return mt_rand($Min, $Max);
	}
	
	function setGlobal() 
	{	
		$GLOBALS['USER']	= $this->USER;
		$GLOBALS['PLANET']	= $this->PLANET;
	}
	
	function getGlobal() 
	{	
		$this->USER		= $GLOBALS['USER'];
		$this->PLANET	= $GLOBALS['PLANET'];
	}

	function saveBot()
	{
		self::log("Salvar Bot");
		self::getDB()->update("UPDATE %%USERS%% u, %%BOTS%% b SET 
		u.`onlinetime` = ".TIMESTAMP.", 
		u.`user_lastip` = '127.0.0.1', 
		b.`last_time` = ".TIMESTAMP.", 
		b.`last_planet` = ".$this->PLANET['id']." 
		WHERE 
		u.`id` = ".$this->USER['id']." AND 
		b.`id` = ".$this->USER['bot_id'].";");
	}
		
	function getPlanet()
	{
		$this->PLANET	= self::getDB()->selectSingle("SELECT * FROM %%PLANETS%% WHERE `id` > ".$this->USER['last_planet']." AND `id_owner` = ".$this->USER['id']." ORDER BY `id` LIMIT 1;");
		if(empty($this->PLANET))
			$this->PLANET	= self::getDB()->selectSingle("SELECT * FROM %%PLANETS%% WHERE `id` = '".$this->USER['id_planet']."';");
	}
	
	function getPlanetResource($ID)
	{
		return $this->PLANET[$GLOBALS['resource'][$ID]];
	}
	
	function getUserResource($ID)
	{
		return $this->USER[$GLOBALS['resource'][$ID]];
	}
	
	function getChance($Cache)
	{
		return $this->randomNum(1, 100) <= $Cache;
	}
	
	function getChanceValue($Value)
	{
		return $this->randomNum(1, $Value);
	}
	
	function getRandomList($List)
	{
		return array_rand($List);
	}
	
	function getMultiplyRandomList($Chances, $Lists)
	{
		$Chance		= array();
		foreach($Chances as $Key => $Value)
			$Chance[$Key]	= $this->getChanceValue($Value);
			
		$MaxChance	= max($Chance);
		
		return $Lists[array_search($MaxChance, $Chance)];
	}
	
	
	
	/** BUILD FUNCTIONS **/

	function AddBuildingToQueue($Element) {
			global $LNG;
		$this->LOG("Estructura: ".$Element);
		$this->LOG("Estructura: ".print_r($LNG['tech'][$Element]));
        $this->setGlobal();
        BuildFunctions::addBuildingToQueue($Element);
		$this->getGlobal();
	}
	
	
	
	function GetBuildQueueInfo()
	{
		$CurrentQueue  = unserialize($this->PLANET['b_building_id']);

		if (!empty($CurrentQueue))
			return count($CurrentQueue);
		else
			return 0;
	}
	
	/** TECH BUILD FUNCTIONS **/


	
	function CheckLabSettingsInQueue()
	{
		global $RESEARCH;
		$this->setGlobal();
		return BuildFunctions::CheckLabSettingsInQueue();
	}
	
	function ResearchBuild($Element)
	{
		global $RESEARCH;
		$this->setGlobal();
		$this->LOG("Investigacion: ".$Element);
        BuildFunctions::addResearchToQueue($Element);
		//$GLOBALS['RESEARCH']->AddBuildingToQueue($Element);
        $this->getGlobal();
	}
	
	function GetTechQueueInfo()
	{
        $CurrentQueue  = unserialize($this->USER['b_tech_queue']);

		if (!empty($CurrentQueue))
			return count($CurrentQueue);
		else
			return 0;
	}
	
	/** FLEET BUILD FUNCTIONS **/

	
	
	function GetMaxConstructibleElements($USER, $PLANET, $Element)
	{
		global $SHIPYARD;
		$this->setGlobal();
		return BuildFunctions::getMaxConstructibleElements($USER, $PLANET, $Element);
	}
	
	function HangarBuild($Element, $Count)
	{
		global $SHIPYARD;
		$this->setGlobal();
        BuildFunctions::addShipsToQueue(array($Element => $Count));
		$this->getGlobal();
	}

	function GetHangerQueueInfo()
	{
		$CurrentQueue  = unserialize($this->PLANET['b_hangar_id']);

		if (!empty($CurrentQueue))
			return count($CurrentQueue);
		else
			return 0;
	}

	/** FLEET FUNCTIONS **/	

	function SendFleet($FleetData)
	{
		$FleetData				= array_merge(array(		
			'mission'		=> 3,
			'galaxy'		=> 0,
			'system'		=> 0,
			'planet'		=> 0,
			'planettype'	=> 0,
			'fleetgroup'	=> 0,
			'speed'			=> 10,
			'metal'			=> 0,
			'crystal'		=> 0,
			'deuterium'		=> 0,
			'holdingtime'	=> 0,
			'fleet'			=> array(),
		), $FleetData);
		
		$mission 				= $FleetData['mission'];
		$galaxy     			= $FleetData['galaxy'];
		$system     			= $FleetData['system'];
		$planet     			= $FleetData['planet'];
		$planettype 			= $FleetData['planettype'];
		$fleet_group		 	= $FleetData['fleetgroup'];
		$GenFleetSpeed		 	= $FleetData['speed'];
		$TransportMetal			= $FleetData['metal'];
		$TransportCrystal		= $FleetData['crystal'];
		$TransportDeuterium		= $FleetData['deuterium'];
		$holdingtime 			= $FleetData['holdingtime'];
		$rawfleetarray			= $FleetData['fleet'];
	
		if ($planettype != 1 && $planettype != 3)
			return false;
			
		if ($this->PLANET['galaxy'] == $galaxy && $this->PLANET['system'] == $system && $this->PLANET['planet'] == $planet && $this->PLANET['planet_type'] == $planettype)
			return false;

		if ($galaxy > $CONF['max_galaxy'] || $galaxy < 1 || $system > $CONF['max_system'] || $system < 1 || $planet > ($CONF['max_planets'] + 1) || $planet < 1)
			return false;
			
		if (empty($mission))
			return false;
			
		$ActualFleets		= parent::GetCurrentFleets($USER['id']);
		
		if (parent::GetMaxFleetSlots($USER) <= $ActualFleets)
			return false;
			
		$fleet_group_mr = 0;
		if(!empty($fleet_group) && $mission == 2)
		{
			$aks_count_mr = $db->uniquequery("SELECT COUNT(*) as state FROM ".AKS." WHERE `id` = '".$fleet_group."' AND `eingeladen` LIKE '%".$USER['id']."%';");
			if ($aks_count_mr['state'] > 0)
				$fleet_group_mr = $fleet_group;
			else
				$mission = 1;
		}
				
		$ActualFleets 		= parent::GetCurrentFleets($USER['id']);
		
		$TargetPlanet  		= $db->uniquequery("SELECT `id`, `id_owner`,`destruyed`,`ally_deposit` FROM ".PLANETS." WHERE `universe` = '".$UNI."' AND `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND `planet` = '".$planet."' AND `planet_type` = '".($planettype == 2 ? 1 : $planettype)."';");

		if (($mission != 15 && $TargetPlanet["destruyed"] != 0) || ($mission != 15 && $mission != 7 && empty($TargetPlanet['id_owner'])))
			return false;

		$MyDBRec       		= $USER;

		$FleetArray  		= parent::GetFleetArray($rawfleetarray);
		
		if (!is_array($FleetArray))
			return false;
				
		$FleetStorage        = 0;
		$FleetShipCount      = 0;
		$fleet_array         = "";
		$FleetSubQRY         = "";
		
		foreach ($FleetArray as $Ship => $Count)
		{
			if ($Count > $this->PLANET[$resource[$Ship]] || $Count < 0)
				return false;
				
			$FleetStorage    += $pricelist[$Ship]["capacity"] * $Count;
			$FleetShipCount  += $Count;
			$fleet_array     .= $Ship .",". $Count .";";
			$FleetSubQRY     .= "`".$resource[$Ship] . "` = `".$resource[$Ship]."` - '".floattostring($Count)."', ";
		}

		$error              = 0;
		$fleetmission       = $mission;

		$YourPlanet = false;
		$UsedPlanet = false;
	
		if ($mission == 11)
		{
			$maxexpde = parent::GetCurrentFleets($USER['id'], 11);

			if ($maxexpde >= $CONF['max_dm_missions'])
				return false;
		}
		elseif ($mission == 15)
		{
			$MaxExpedition = $USER[$resource[124]];

			if ($MaxExpedition == 0)
				return false;
							
			$ExpeditionEnCours	= parent::GetCurrentFleets($USER['id'], 15);
			$EnvoiMaxExpedition = floor(sqrt($MaxExpedition));
			
			if ($ExpeditionEnCours >= $EnvoiMaxExpedition)
				return false;
		}

		$YourPlanet 	= (isset($TargetPlanet['id_owner']) && $TargetPlanet['id_owner'] == $USER['id']) ? true : false;
		$UsedPlanet 	= (isset($TargetPlanet['id_owner'])) ? true : false;

		$HeDBRec 		= ($YourPlanet) ? $MyDBRec : GetUserByID($TargetPlanet['id_owner'], array('id','onlinetime','ally_id', 'urlaubs_modus', 'banaday', 'authattack'));

		if ($HeDBRec['urlaubs_modus'] && $mission != 8)
				return false;
		
		if(!$YourPlanet && ($mission == 1 || $mission == 2 || $mission == 5 || $mission == 6 || $mission == 9))
		{
			if($CONF['adm_attack'] == 1 && $UsedPlanet['authattack'] > $USER['authlevel'])
				return false;
			
			$UserPoints    	= $USER;
			$User2Points  	= $db->uniquequery("SELECT `total_points` FROM ".STATPOINTS." WHERE `stat_type` = '1' AND `id_owner` = '".$HeDBRec['id']."';");
		
			$IsNoobProtec	= CheckNoobProtec($UserPoints, $User2Points, $HeDBRec);
			
			if ($IsNoobProtec['NoobPlayer'])
				return false;
			elseif ($IsNoobProtec['StrongPlayer'])
				return false;
		}

		if ($mission == 5)
		{
			
			if ($TargetPlanet['ally_deposit'] < 1)
				return false;
			
			$buddy	= $db->uniquequery("SELECT COUNT(*) as state FROM ".BUDDY." WHERE `active` = '1' AND (`owner` = '".$HeDBRec['id']."' AND `sender` = '".$MyDBRec['id']."') OR (`owner` = '".$MyDBRec['id']."' AND `sender` = '".$HeDBRec['id']."');");
						
			if($HeDBRec['ally_id'] != $MyDBRec['ally_id'] && $buddy['state'] == 0)
				return false;
		}
		if(!parent::CheckUserSpeed($GenFleetSpeed) || !array_key_exists($mission, parent::GetAvailableMissions(array('CurrentUser' => $USER,'galaxy' => $galaxy, 'system' => $system, 'planet' => $planet, 'planettype' => $planettype, 'IsAKS' => $fleet_group, 'Ship' => $FleetArray))))
			return false;


		$MaxFleetSpeed 	= parent::GetFleetMaxSpeed($FleetArray, $USER);
		$SpeedFactor    = parent::GetGameSpeedFactor();
		$distance      	= parent::GetTargetDistance($this->PLANET['galaxy'], $galaxy, $this->PLANET['system'], $system, $this->PLANET['planet'], $planet);
		$duration      	= parent::GetMissionDuration($GenFleetSpeed, $MaxFleetSpeed, $distance, $SpeedFactor, $USER);
		$consumption   	= parent::GetFleetConsumption($FleetArray, $duration, $distance, $MaxFleetSpeed, $USER, $SpeedFactor);
			
		$fleet['start_time'] = $duration + TIMESTAMP;
		
		if ($mission == 15)
		{
			$StayDuration    = (max($holdingtime, 1) * 3600) / $CONF['halt_speed'];
			$StayTime        = $fleet['start_time'] + $StayDuration;
		}
		elseif ($mission == 5)
		{
			$StayDuration    = $holdingtime * 3600;
			$StayTime        = $fleet['start_time'] + $StayDuration;
		}
		elseif ($mission == 11)
		{
			$StayDuration    = 3600 / $CONF['halt_speed'];
			$StayTime        = $fleet['start_time'] + $StayDuration;
		}
		else
		{
			$StayDuration    = 0;
			$StayTime        = 0;
		}

		$fleet['end_time']   = $StayDuration + (2 * $duration) + TIMESTAMP;


		$FleetStorage       -= $consumption;
		
		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		
		$TransportMetal		 = min($TransportMetal, $this->PLANET['metal']);
		$TransportCrystal 	 = min($TransportCrystal, $this->PLANET['crystal']);
		$TransportDeuterium  = min($TransportDeuterium, ($this->PLANET['deuterium'] - $consumption));

		$StorageNeeded   	 = $TransportMetal + $TransportCrystal + $TransportDeuterium;
		
		$StockMetal      	 = $this->PLANET['metal'];
		$StockCrystal    	 = $this->PLANET['crystal'];
		$StockDeuterium  	 = $this->PLANET['deuterium'];
		$StockDeuterium 	-= $consumption;

		if ($this->PLANET['deuterium'] < $consumption)
			return false;
		
		if ($StorageNeeded > $FleetStorage)
			return false;
				
		$this->PLANET['metal']		-= $TransportMetal;
		$this->PLANET['crystal']		-= $TransportCrystal;
		$this->PLANET['deuterium']	-= ($TransportDeuterium + $consumption);
				
		if ($fleet_group_mr != 0)
		{
			$AksStartTime = $db->uniquequery("SELECT MAX(`fleet_start_time`) AS Start FROM ".FLEETS." WHERE `fleet_group` = '".$fleet_group_mr."' AND '".$CONF['max_fleets_per_acs']."' > (SELECT COUNT(*) FROM ".FLEETS." WHERE `fleet_group` = '".$fleet_group_mr."');");
			if (isset($AksStartTime)) 
			{
				if ($AksStartTime['Start'] >= $fleet['start_time'])
				{
					$fleet['end_time'] 	   += $AksStartTime['Start'] - $fleet['start_time'];
					$fleet['start_time'] 	= $AksStartTime['Start'];
				}
				else
				{
					$SQLFleets = "UPDATE ".FLEETS." SET ";
					$SQLFleets .= "`fleet_start_time` = '".$fleet['start_time']."', ";
					$SQLFleets .= "`fleet_end_time` = fleet_end_time + '".($fleet['start_time'] - $AksStartTime['Start'])."' ";
					$SQLFleets .= "WHERE ";
					$SQLFleets .= "`fleet_group` = '".$fleet_group_mr."';";
					$db->query($SQLFleets);
					$fleet['end_time'] 	    += $fleet['start_time'] - $AksStartTime['Start'];
				}
			} else {
				$mission	= 1;
			}
		}
		
		$QryInsertFleet  = "LOCK TABLE ".FLEETS." WRITE, ".PLANETS." WRITE;
							INSERT INTO ".FLEETS." SET 
							`fleet_owner` = '".$USER['id']."', 
							`fleet_mission` = '".$mission."',
							`fleet_amount` = '".$FleetShipCount."',
						    `fleet_array` = '".$fleet_array."',
						    `fleet_universe` = '".$UNI."',
							`fleet_start_time` = '".$fleet['start_time']."',
							`fleet_start_id` = '".$this->PLANET['id']."',
							`fleet_start_galaxy` = '".$this->PLANET['galaxy']."',
							`fleet_start_system` = '".$this->PLANET['system']."',
							`fleet_start_planet` = '".$this->PLANET['planet']."',
							`fleet_start_type` = '".$this->PLANET['planet_type']."',
							`fleet_end_time` = '".$fleet['end_time']."',
							`fleet_end_stay` = '".$StayTime."',
							`fleet_end_id` = '".(int)$TargetPlanet['id']."',
							`fleet_end_galaxy` = '".$galaxy."',
							`fleet_end_system` = '".$system."',
							`fleet_end_planet` = '".$planet."',
							`fleet_end_type` = '".$planettype."',
							`fleet_resource_metal` = '".floattostring($TransportMetal)."',
							`fleet_resource_crystal` = '".floattostring($TransportCrystal)."',
							`fleet_resource_deuterium` = '".floattostring($TransportDeuterium)."',
							`fleet_target_owner` = '".(($planettype == 2) ? 0 : (int)$TargetPlanet['id_owner'])."',
							`fleet_group` = '".$fleet_group_mr."',
							`start_time` = '".TIMESTAMP."';
							UPDATE `".PLANETS."` SET
							".substr($FleetSubQRY,0,-2)."
							WHERE
							`id` = ". $this->PLANET['id'] ." LIMIT 1;
							UNLOCK TABLES;";


		$db->multi_query($QryInsertFleet);
		return true;
	}
	
	function PlanetCount()
	{
		global $FLEET;
		
		if(!isset($this->USER['planets']))
			$this->USER['planets']	= self::getDB()->countquery("SELECT COUNT(*) FROM ".PLANETS." WHERE `id_owner` = ".$this->USER['id']." AND `planet_type` = '1' AND `destruyed` = 0;");
			
		return $this->USER['planets'];
	}
	
	function isFleetSlotFree()
	{
		global $FLEET;
		
		if(!isset($this->USER['slots'])) {
            $this->USER['slots']    = FleetFunctions::GetMaxFleetSlots($this->USER) - FleetFunctions::GetCurrentFleets($this->USER['id']);
        }
			
		return $this->USER['slots'];
	}
	
	function Colonizeable()
	{
		if($this->getPlanetResource(208) == 0)
			return false;
			
		$iPlanetCount 	= $this->PlanetCount();
		$MaxPlanets		= MaxPlanets($this->getUserResource(124), $this->PLANET['universe']);
		
		return $iPlanetCount < $MaxPlanets && $this->isFleetSlotFree();
	}
	
	function getCoords()
	{
		global $resource, $pricelist, $CONF;
		$PlanetCount		= $this->PlanetCount();
		
		$GalaxyAmplitude	= ceil($PlanetCount / 2);
		$GalaxyMin			= max($this->PLANET['galaxy'] - $Amplitude, 1);
		$GalaxyMax			= min($this->PLANET['galaxy'] + $Amplitude, $CONF['max_galaxy']);
		
		$SystemAmplitude	= ceil($PlanetCount / 1);
		$SystemMin			= max($this->PLANET['system'] - $Amplitude, 1);
		$SystemMax			= min($this->PLANET['system'] + $Amplitude, $CONF['max_galaxy']);
		
		$PlanetMin			= 1;
		$PlanetMax			= $CONF['max_planets'];
		
		$i					= 0;
		
		do {
			$Galaxy		= $this->randomNum($GalaxyMin, $GalaxyMax);
			$System		= $this->randomNum($SystemMin, $SystemMax);
			$Planet		= $this->randomNum($PlanetMin, $PlanetMax);
			
			if($i >= self::BOTS_MAX_TRY_COLONIZE)
				return false;

			$i++;
		} while(CheckPlanetIfExist($Galaxy, $System, $Planet, $this->USER['universe']));
		
		return array('galaxy' => $Galaxy, 'system' => $System, 'planet' => $Planet);
	}
	
	function Colonize()
	{
		$Coords	= $this->getCoords();
		if(!$Coords)
			return;
			
		$this->SendFleet(array(		
			'mission'		=> 3,
			'galaxy'		=> $Coords['galaxy'],
			'system'		=> $Coords['sysstem'],
			'planet'		=> $Coords['planet'],
			'planettype'	=> 1,
			'fleetgroup'	=> 0,
			'speed'			=> 10,
			'metal'			=> 0,
			'crystal'		=> 0,
			'deuterium'		=> 0,
			'holdingtime'	=> 0,
			'fleet'			=> array(208 => 1),
		));
	}
		
	function SaveFleets()
	{
		$Coords	= $this->getSaveCoords();
		$this->SendFleet(array(		
			'mission'		=> 7,
			'galaxy'		=> $Coords['galaxy'],
			'system'		=> $Coords['sysstem'],
			'planet'		=> $Coords['planet'],
			'planettype'	=> 1,
			'fleet'			=> array(208 => 1),
		));
	}
	
	function getSaveCoords()
	{
		$Bots = self::getDB()->query("");
	}
}