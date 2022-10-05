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

set_time_limit(0);

# Includes 
require_once('includes/classes/class.BuildFunctions.php');
require_once('includes/classes/ArrayUtil.class.php');
require_once('includes/classes/class.PlanetRessUpdate.php');
require_once('includes/pages/game/ShowResearchPage.class.php');
require_once('includes/pages/game/ShowShipyardPage.class.php');
require_once('includes/pages/game/ShowBuildingsPage.class.php');
require_once('includes/classes/class.FleetFunctions.php');




class BotForscher extends TestBot
{

	
	# BOTS QUEUE Settings
	const BOTS_MAX_ELEMENTS_BUILDS		= 3;
	const BOTS_MAX_ELEMENTS_TECH		= 1;
	const BOTS_MAX_ELEMENTS_SHIPYARD	= 10;
	
	# BOTS QUEUE Settings
	const BOTS_MAX_TRY_BUILDS_ECO		= 5;
	const BOTS_MAX_TRY_BUILDS_SPECIAL	= 7;
	const BOTS_MAX_TRY_BUILDS_STORAGE	= 3;
	const BOTS_MAX_TRY_TECH				= 10;
	const BOTS_MAX_TRY_SHIPYARD			= 10;
	


	# CHANCE IN PERCENT
	const CHANCE_BUILD			= 100;	
	const CHANCE_BUILD_ECO		= 40; # Chance of Mines
	const CHANCE_BUILD_SPECIAL	= 40; # Another Builds
	const CHANCE_BUILD_NEXT		= 100;
	
	const CHANCE_TECH			= 100;
	const CHANCE_TECH_BASIC		= 40;
	const CHANCE_TECH_ECO		= 40;
	const CHANCE_TECH_SPEED		= 40;
	const CHANCE_TECH_SPECIAL	= 40;
	const CHANCE_TECH_NEXT		= 100;
	
	const CHANCE_SHIPYARD				= 100;
	const CHANCE_SHIPYARD_FLEET_BASIC	= 30;
	const CHANCE_SHIPYARD_FLEET_ATTACK	= 25;
	const CHANCE_SHIPYARD_DEF_BASIC		= 30;
	const CHANCE_SHIPYARD_DEF_SHIELD	= 15;
	const CHANCE_SHIPYARD_NEXT			= 100; 

	const CHANCE_EXPO_START		= 100;
	const CHANCE_EXPO_NORMAL	= 100;
	const CHANCE_EXPO_DM		= 100;
	
	const CHANCE_FLEETS_COLONIZE		= 100;
	const CHANCE_FLEETS_RES_TO_OWN_MOON	= 100; 
	const CHANCE_FLEETS_RES_TO_PLANET	= 100;

	const CHANCE_FLEETS_SAVE			= 100; 
	const CHANCE_FLEETS_SAVE_TF			= 100; 
	const CHANCE_FLEETS_SAVE_BUILD		= 100; 
	const CHANCE_FLEETS_SAVE_TRANSPORT	= 100; 
	const CHANCE_FLEETS_SAVE_JUMPGATE	= 100; 
	
	
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



function Play() 
	{
        $this->getPlanet();
        $PlanetRess = new ResourceUpdate();
        list($this->USER, $this->PLANET)	= $PlanetRess->CalcResource($this->USER, $this->PLANET);
        if($this->getChance(self::CHANCE_BUILD))
		{
			self::log("Success Chance: Build");
			if($this->getChance(self::CHANCE_BUILD_ECO)) {
				$this->BuildEco();
            }else self::log("no built");
		
			if($this->getPlanetResource(4) <= 5 && $this->getChance(self::CHANCE_BUILD_SPECIAL)) {
				$this->BuildSpecialBuildings();
            }
		}
		
		self::log("Lab Level: ".$this->getPlanetResource(31));

		if($this->getPlanetResource(31) > 0 && $this->getChance(self::CHANCE_TECH))
		{
			self::log("Success Chance: Tech");
			$this->ResearchTechs();
		}
		
		self::log("Roboter Level: ".$this->getPlanetResource(14));
		self::log("Shipyard Level: ".$this->getPlanetResource(21));
		
		if($this->getPlanetResource(21) > 0 && $this->getChance(self::CHANCE_SHIPYARD))
		{
			self::log("Success Chance: Shipyard");
			$this->BuildShipyard();
		}
		
		if($this->getChance(self::CHANCE_FLEETS_COLONIZE))
		{
			if($this->Colonizeable()) {
				$this->Colonize();
			}
		}
			
/* 		if(self::BOTS_ALLOW_SAVE && (self::BOTS_SAVE_FROM <= $Hour || self::BOTS_SAVE_TO > $Hour) && $this->getChance(self::CHANCE_FLEETS_SAVE)) {
			$this->SaveFleets();
		} */
		
		$PlanetRess->SavePlanetToDB($this->USER, $this->PLANET);
		$this->saveBot();
	}
	



	function BuildEco()
	{
		global $resource;
		$this->BuildStores();
		
		self::log("Buildtype: Eco");
		$ActualCount	= $this->GetBuildQueueInfo();
        $EnergyChance = 1;
        if (abs($this->PLANET['energy_used']) > 0) {
            $EnergyChance = $this->PLANET['energy'] / abs($this->PLANET['energy_used']);
        }
		$Chance			= 20 + $EnergyChance * 60;
        $Try			= 1;
		
		do {
			if($ActualCount >= self::BOTS_MAX_ELEMENTS_BUILDS || $Try >= self::BOTS_MAX_TRY_BUILDS_ECO)
				break;
			
			$Try++;
			
			if($this->getChance($Chance))
				$List		= self::$MineIDs;
			else
				$List		= self::$EnergyIDs;
				
			$Element	= $this->getRandomList($List);

            if(
				$this->getChance($List[$Element]) || 
				($Element == 12 && $this->getPlanetResource(4) < self::$EnergyIDs[4] - 10) || 
				!BuildFunctions::IsTechnologieAccessible($this->USER, $this->PLANET, $Element) ||
				!BuildFunctions::IsElementBuyable($this->USER, $this->PLANET, $Element)
			) continue;

            $this->AddBuildingToQueue($Element);
			$ActualCount++;
		} while($this->getChance(self::CHANCE_BUILD_NEXT));
	}
	
	function BuildSpecialBuildings()
	{
		global $resource;
		$ActualCount	= $this->GetBuildQueueInfo();
		self::log("Buildtype: Special");

		$Try			= 1;
		
		do {			
			if($ActualCount >= self::BOTS_MAX_ELEMENTS_BUILDS || $Try >= self::BOTS_MAX_TRY_BUILDS_SPECIAL)
				break;
			
			$Try++;
			
			$Element	= $this->getRandomList(self::$SpecialIDs);
			
			if(
				$this->getChance(self::$SpecialIDs[$Element]) || 
				!BuildFunctions::IsTechnologieAccessible($this->USER, $this->PLANET, $Element) ||
				!BuildFunctions::IsElementBuyable($this->USER, $this->PLANET, $Element)
			) continue;

            $this->AddBuildingToQueue($Element);
			$ActualCount++;
		} while($this->getChance(self::CHANCE_BUILD_NEXT));
	}
	
	function BuildStores()
	{
		global $resource;

		$ActualCount	= $this->GetBuildQueueInfo();
		self::log("Buildtype: Storage");
		
		$RessourceWrapper	= array(
			22	=> 'metal',
			23	=> 'crystal',
			24	=> 'deuterium'
		);
		
		$Try			= 1;
		
		do {
            self::BOTS_MAX_ELEMENTS_BUILDS;
            self::BOTS_MAX_TRY_BUILDS_STORAGE;


			if($ActualCount >= self::BOTS_MAX_ELEMENTS_BUILDS || $Try >= self::BOTS_MAX_TRY_BUILDS_STORAGE) {
                break;
            }
			
			$Try++;

            $Element	= $this->getRandomList(self::$StorageIDs);

            if(
				$this->getChance(self::$StorageIDs[$Element]) || 
				$this->PLANET[$RessourceWrapper[$Element]] >= $this->PLANET[$RessourceWrapper[$Element].'_max'] * 0.95 ||
				!BuildFunctions::IsTechnologieAccessible($this->USER, $this->PLANET, $Element) ||
				!BuildFunctions::IsElementBuyable($this->USER, $this->PLANET, $Element)
			) {
                continue;
            }

            $this->AddBuildingToQueue($Element);
			$ActualCount++;
		} while($this->getChance(self::CHANCE_TECH_NEXT));
	}



		function ResearchTechs()
	{
        global $resource, $RESEARCH;
        if (!$this->CheckLabSettingsInQueue()) {
			return false;
        }

        $ActualCount	= $this->GetTechQueueInfo();

		$Try			= 1;
		
		do {
            if($ActualCount >= self::BOTS_MAX_ELEMENTS_TECH || $Try >= self::BOTS_MAX_TRY_TECH)
				break;
			
			$Try++;

            $List	= $this->getMultiplyRandomList(array(
				self::CHANCE_TECH_BASIC,
				self::CHANCE_TECH_ECO,
				self::CHANCE_TECH_SPEED,
				self::CHANCE_TECH_SPECIAL,
			), array(
				self::$TechBasicIDs,
				self::$TechEcoIDs,
				self::$TechSpeedIDs,
				self::$TechSpecialIDs,
			));

            $Element	= $this->getRandomList($List);


			if(
				$this->getChance($List[$Element]) || 
				!BuildFunctions::IsTechnologieAccessible($this->USER, $this->PLANET, $Element) ||
				!BuildFunctions::IsElementBuyable($this->USER, $this->PLANET, $Element)
			) {
                continue;
            }

            $this->ResearchBuild($Element);
			$ActualCount++;
		} while($this->getChance(self::CHANCE_BUILD_NEXT));
		
	}


	function BuildShipyard()
	{
		global $resource, $reslist, $SHIPYARD;
		$ActualCount	= $this->GetHangerQueueInfo();
		
		$Try			= 1;
		
		do {
			if($ActualCount >= self::BOTS_MAX_ELEMENTS_SHIPYARD || $Try >= self::BOTS_MAX_TRY_SHIPYARD)
				break;
			
			$Try++;

            $List	= $this->getMultiplyRandomList(array(
				self::CHANCE_SHIPYARD_FLEET_BASIC,
				self::CHANCE_SHIPYARD_FLEET_ATTACK,
				self::CHANCE_SHIPYARD_DEF_BASIC,
				self::CHANCE_SHIPYARD_DEF_SHIELD,
			), array(
				self::$FleetBasicIDs,
				self::$FleetAttackIDs,
				self::$DefBasicIDs,
				self::$DefShieldIDs,
			));
			
			$Element = $this->getRandomList($List);
			if(!$this->getChance($List[$Element]) || !BuildFunctions::IsTechnologieAccessible($this->USER, $this->PLANET, $Element)) {
                continue;
            }

            $MaxElements = $this->GetMaxConstructibleElements($this->USER, $this->PLANET, $Element);

            $Mode	= $this->randomNum(0, 20);
            $Count = 1;

			if($Mode === 20)
				$Count = $this->randomNum(0, 10);
			elseif($Mode >= 18)
				$Count = $this->randomNum(10, 20);
			elseif($Mode >= 16)
				$Count = $this->randomNum(20, 30);
			elseif($Mode >= 13)
				$Count = $this->randomNum(30, 40);
			elseif($Mode >= 9)
				$Count = $this->randomNum(40, 60);
			elseif($Mode >= 6)
				$Count = $this->randomNum(60, 70);
			elseif($Mode >= 4)
				$Count = $this->randomNum(70, 80);
			elseif($Mode >= 2)
				$Count = $this->randomNum(80, 90);
			elseif($Mode >= 1)
				$Count = $this->randomNum(90, 100);

            $MaxFactor		= array();
            $MaxFactor[]	= round(3600 / BuildFunctions::GetBuildingTime($this->USER, $this->PLANET, $Element));
            $MaxFactor[]	= $MaxElements * $Count;

            $this->HangarBuild($Element, min($MaxFactor));
			$ActualCount++;
		} while($this->getChance(self::CHANCE_SHIPYARD_NEXT));
	}






















}