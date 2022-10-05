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

class ShowBuildingsPage extends AbstractGamePage
{	
	public static $requireModule = MODULE_BUILDING;

	function __construct() 
	{
		parent::__construct();
	}
	
	private function CancelBuildingFromQueue()
	{
		global $PLANET, $USER, $resource, $LNG;
		$CurrentQueue  = unserialize($PLANET['b_building_id']);
		if (empty($CurrentQueue))
		{
			$PLANET['b_building_id']	= '';
			$PLANET['b_building']		= 0;
			return false;
		}
	
		$Element             	= $CurrentQueue[0][0];
        $BuildLevel          	= $CurrentQueue[0][1];
		$BuildMode          	= $CurrentQueue[0][4];
		
		$costResources			= BuildFunctions::getElementPrice($USER, $PLANET, $Element, $BuildMode == 'destroy', $BuildLevel);

			$account_before = array(
				'darkmatter'			=> $USER['darkmatter'],
				'antimatter'			=> $USER['antimatter'],
				'metal'					=> $PLANET['metal'],
				'crystal'				=> $PLANET['crystal'],
				'deuterium'				=> $PLANET['deuterium'],
				'building'				=> $LNG['tech'][$Element]." ".$PLANET[$resource[$Element]],
				//'building'				=> $LNG['tech'][$Element],
			);


		if(isset($costResources[901])) { $PLANET[$resource[901]]	+= $costResources[901]; }
		if(isset($costResources[902])) { $PLANET[$resource[902]]	+= $costResources[902]; }
		if(isset($costResources[903])) { $PLANET[$resource[903]]	+= $costResources[903]; }
		if(isset($costResources[921])) { $USER[$resource[921]]		+= $costResources[921]; }
		array_shift($CurrentQueue);
		if (count($CurrentQueue) == 0) {
			$PLANET['b_building']    	= 0;
			$PLANET['b_building_id'] 	= '';
		} else {
			$BuildEndTime	= TIMESTAMP;
			$NewQueueArray	= array();
			foreach($CurrentQueue as $ListIDArray) {
				if($Element == $ListIDArray[0])
					continue;
					
				$BuildEndTime       += BuildFunctions::getBuildingTime($USER, $PLANET, $ListIDArray[0], $costResources, $ListIDArray[4] == 'destroy');
				$ListIDArray[3]		= $BuildEndTime;
				$NewQueueArray[]	= $ListIDArray;					


				$account_after = array(
					'darkmatter'			=> isset($costResources[921]) ? $costResources[921] : 0,
					'antimatter'			=> isset($costResources[922]) ? $costResources[922] : 0,
					'metal'					=> isset($costResources[901]) ? $costResources[901] : 0,
					'crystal'				=> isset($costResources[902]) ? $costResources[902] : 0,
					'deuterium'				=> isset($costResources[903]) ? $costResources[903] : 0,
					'building'				=> $LNG['tech'][$Element]." ".$BuildLevel,
				);

			$LOG = new Logcheck(25);
			$LOG->username = $USER['username'];
			$LOG->pageLog = "page=buildings [".$PLANET['galaxy'].":".$PLANET['system'].":".$PLANET['planet']."] [Desmontar]";
			$LOG->old = $account_before;
			$LOG->new = $account_after;
			$LOG->save();


			}
			
			if(!empty($NewQueueArray)) {
				$PLANET['b_building']    	= TIMESTAMP;
				$PLANET['b_building_id'] 	= serialize($NewQueueArray);
				$this->ecoObj->setData($USER, $PLANET);
				$this->ecoObj->SetNextQueueElementOnTop();
				list($USER, $PLANET)		= $this->ecoObj->getData();
			} else {
				$PLANET['b_building']    	= 0;
				$PLANET['b_building_id'] 	= '';
			}
		}
		return true;
	}

	private function RemoveBuildingFromQueue($QueueID)
	{
		global $USER, $PLANET;
		if ($QueueID <= 1 || empty($PLANET['b_building_id'])) {
            return false;
        }

		$CurrentQueue  = unserialize($PLANET['b_building_id']);
		$ActualCount   = count($CurrentQueue);
		if($ActualCount <= 1) {
			return $this->CancelBuildingFromQueue();
        }

        if ($QueueID - $ActualCount >= 2) {
            // Avoid race conditions
            return;
        }


        //fixed cancel estrcturas
		$Element		= $CurrentQueue[$QueueID - 1][0];
		$BuildEndTime	= $CurrentQueue[$QueueID - 2][3];
		unset($CurrentQueue[$QueueID - 1]);
		$NewQueueArray	= array();
		foreach($CurrentQueue as $ID => $ListIDArray)
		{				
			if ($ID < $QueueID - 1) {
				$NewQueueArray[]	= $ListIDArray;
			} else {
				if($Element == $ListIDArray[0] || empty($ListIDArray[0]))
					continue;

				$BuildEndTime       += BuildFunctions::getBuildingTime($USER, $PLANET, $ListIDArray[0], NULL, $ListIDArray[4] == 'destroy', $ListIDArray[2]);
				$ListIDArray[3]		= $BuildEndTime;
				$NewQueueArray[]	= $ListIDArray;				
			}
		}

		if(!empty($NewQueueArray))
			$PLANET['b_building_id'] = serialize($NewQueueArray);
		else
			$PLANET['b_building_id'] = "";

        return true;
	}

	private function AddBuildingToQueue($Element, $AddMode = true)
	{
		global $PLANET, $USER, $resource, $reslist, $pricelist, $LNG;
		
		if(!in_array($Element, $reslist['allow'][$PLANET['planet_type']])
			|| !BuildFunctions::isTechnologieAccessible($USER, $PLANET, $Element) 
			|| ($Element == 31 && $USER["b_tech_planet"] != 0) 
			|| (($Element == 15 || $Element == 21) && !empty($PLANET['b_hangar_id']))
			|| (!$AddMode && $PLANET[$resource[$Element]] == 0)
		)
			return;
		
		$CurrentQueue  		= unserialize($PLANET['b_building_id']);

				
		if (!empty($CurrentQueue)) {
			$ActualCount	= count($CurrentQueue);
		} else {
			$CurrentQueue	= array();
			$ActualCount	= 0;
		}
		
		$CurrentMaxFields  	= CalculateMaxPlanetFields($PLANET);

		$config	= Config::get();

		if (($config->max_elements_build != 0 && $ActualCount == $config->max_elements_build)
			|| ($AddMode && $PLANET["field_current"] >= ($CurrentMaxFields - $ActualCount)))
		{
			return;
		}
	
		$BuildMode 			= $AddMode ? 'build' : 'destroy';
		$BuildLevel			= $PLANET[$resource[$Element]] + (int) $AddMode;
		
		if($ActualCount == 0)
		{
			if($pricelist[$Element]['max'] < $BuildLevel)
				return;

			$costResources		= BuildFunctions::getElementPrice($USER, $PLANET, $Element, !$AddMode, $BuildLevel);
			
			if(!BuildFunctions::isElementBuyable($USER, $PLANET, $Element, $costResources))
				return;

			$account_before = array(
				'darkmatter'			=> $USER['darkmatter'],
				'antimatter'			=> $USER['antimatter'],
				'metal'					=> $PLANET['metal'],
				'crystal'				=> $PLANET['crystal'],
				'deuterium'				=> $PLANET['deuterium'],
				'building'				=> $LNG['tech'][$Element]." ".$PLANET[$resource[$Element]],
				//'building'				=> $LNG['tech'][$Element],
			);


			
			if(isset($costResources[901])) { $PLANET[$resource[901]]	-= $costResources[901]; }
			if(isset($costResources[902])) { $PLANET[$resource[902]]	-= $costResources[902]; }
			if(isset($costResources[903])) { $PLANET[$resource[903]]	-= $costResources[903]; }
			if(isset($costResources[921])) { $USER[$resource[921]]		-= $costResources[921]; }
			
			$elementTime    			= BuildFunctions::getBuildingTime($USER, $PLANET, $Element, $costResources);
			$BuildEndTime				= TIMESTAMP + $elementTime;
			
			$PLANET['b_building_id']	= serialize(array(array($Element, $BuildLevel, $elementTime, $BuildEndTime, $BuildMode)));
			$PLANET['b_building']		= $BuildEndTime;


			$account_after = array(
				'darkmatter'			=> isset($costResources[921]) ? $costResources[921] : 0,
				'antimatter'			=> isset($costResources[922]) ? $costResources[922] : 0,
				'metal'					=> isset($costResources[901]) ? $costResources[901] : 0,
				'crystal'				=> isset($costResources[902]) ? $costResources[902] : 0,
				'deuterium'				=> isset($costResources[903]) ? $costResources[903] : 0,
				'building'				=> $LNG['tech'][$Element]." ".$BuildLevel,
			);

			$LOG = new Logcheck(25);
			$LOG->username = $USER['username'];
			$LOG->pageLog = "page=buildings [".$PLANET['galaxy'].":".$PLANET['system'].":".$PLANET['planet']."] [Ampliar]";
			$LOG->old = $account_before;
			$LOG->new = $account_after;
			$LOG->save();


		} else {
			$addLevel = 0;
			foreach($CurrentQueue as $QueueSubArray)
			{
				if($QueueSubArray[0] != $Element)
					continue;
					
				if($QueueSubArray[4] == 'build')
					$addLevel++;
				else
					$addLevel--;
			}
			
			$BuildLevel					+= $addLevel;
			
			if(!$AddMode && $BuildLevel == 0)
				return;
				
			if($pricelist[$Element]['max'] < $BuildLevel)
				return;
				
			$elementTime    			= BuildFunctions::getBuildingTime($USER, $PLANET, $Element, NULL, !$AddMode, $BuildLevel);
			$BuildEndTime				= $CurrentQueue[$ActualCount - 1][3] + $elementTime;
			$CurrentQueue[]				= array($Element, $BuildLevel, $elementTime, $BuildEndTime, $BuildMode);
			$PLANET['b_building_id']	= serialize($CurrentQueue);		
		}

	}

	private function getQueueData()
	{
		global $LNG, $PLANET, $USER;
		
		$scriptData		= array();
		$quickinfo		= array();
		
		if ($PLANET['b_building'] == 0 || $PLANET['b_building_id'] == "")
			return array('queue' => $scriptData, 'quickinfo' => $quickinfo);
		
		$buildQueue		= unserialize($PLANET['b_building_id']);
		
		foreach($buildQueue as $BuildArray) {
			if ($BuildArray[3] < TIMESTAMP)
				continue;
			
			$quickinfo[$BuildArray[0]]	= $BuildArray[1];
			
			$scriptData[] = array(
				'element'	=> $BuildArray[0], 
				'level' 	=> $BuildArray[1], 
				'time' 		=> $BuildArray[2], 
				'resttime' 	=> ($BuildArray[3] - TIMESTAMP), 
				'destroy' 	=> ($BuildArray[4] == 'destroy'), 
				'endtime' 	=> _date('U', $BuildArray[3], $USER['timezone']),
				'display' 	=> _date($LNG['php_tdformat'], $BuildArray[3], $USER['timezone']),
			);
		}
		
		return array('queue' => $scriptData, 'quickinfo' => $quickinfo);
	}

	///aceleracion de estructuras
	private function FastBuildingFromQueue()
	{
		global $PLANET, $USER, $resource;	
		$CurrentQueue  = unserialize($PLANET['b_building_id']);	
		if (empty($CurrentQueue)){
			$PLANET['b_building_id']	= '';
			$PLANET['b_building']		= 0;
			return;		
		}
		$Element				 = $CurrentQueue[0][0];
		$BuildMode			  = $CurrentQueue[0][4];
		$fast				   = $resource[$Element];
		if ($PLANET['planet_type']==3){  
			$NeededDm		   = (7000*(($PLANET['b_building']-TIMESTAMP)/3600));
		}else{ 
			$NeededDm		   = (5000*(($PLANET['b_building']-TIMESTAMP)/3600));
		}
		if($NeededDm < 10)
			$NeededDm=10;
		if ($USER['darkmatter'] >= $NeededDm){
			$USER['darkmatter']				-= $NeededDm;
			if ($BuildMode == 'destroy'){
				$PLANET['field_current'] -=1;
				$PLANET[$resource[$Element]] -= 1;
				$sql = "UPDATE %%PLANETS%% SET ".$fast." = ".$fast." - 1 WHERE id = :planetId;";
			}
			else{
				$PLANET['field_current'] +=1;
				$PLANET[$resource[$Element]] += 1;
				$sql = "UPDATE %%PLANETS%% SET ".$fast." = ".$fast." + 1 WHERE id = :planetId;";
			}
			Database::get()->update($sql, array(':planetId'	=> $PLANET['id']));
			array_shift($CurrentQueue);
			if (count($CurrentQueue) == 0) {
				$PLANET['b_building']		= 0;
				$PLANET['b_building_id']	 = '';
			}else{
				$BuildEndTime	= TIMESTAMP;
				$NewQueueArray	= array();
				foreach($CurrentQueue as $ListIDArray) {
					if($Element == $ListIDArray[0])
						continue;
					$BuildEndTime	   += BuildFunctions::getBuildingTime($USER, $PLANET, $ListIDArray[0], NULL, $ListIDArray[4] == 'destroy');
					$ListIDArray[3]		= $BuildEndTime;
					$NewQueueArray[]	= $ListIDArray;					
				}
				if(!empty($NewQueueArray)) {
					$PLANET['b_building']		= TIMESTAMP;
					$PLANET['b_building_id']	 = serialize($NewQueueArray);
					$this->ecoObj->setData($USER, $PLANET);
					$this->ecoObj->SetNextQueueElementOnTop();
					list($USER, $PLANET)		= $this->ecoObj->getData();
				}else{
					$PLANET['b_building']		= 0;
					$PLANET['b_building_id']	 = '';
				}
			}
			 return true;
		}
	} 
	///akii

	public function show()
	{
		global $ProdGrid, $LNG, $resource, $reslist, $PLANET, $USER, $pricelist;
		
		$TheCommand		= HTTP::_GP('cmd', '');

		// wellformed buildURLs
		if(!empty($TheCommand) && $_SERVER['REQUEST_METHOD'] === 'POST' && $USER['urlaubs_modus'] == 0)
		{
			$Element     	= HTTP::_GP('building', 0);
			$ListID      	= HTTP::_GP('listid', 0);
			switch($TheCommand)
			{
				case 'cancel':
					$this->CancelBuildingFromQueue();
				break;
				case 'remove':
					$this->RemoveBuildingFromQueue($ListID);
				break;
				case 'insert':
					$this->AddBuildingToQueue($Element, true);
				break;
				case 'destroy':
					$this->AddBuildingToQueue($Element, false);
				break;
				case 'fast':
					$this->FastBuildingFromQueue();
				break; 
			}
			
			$this->redirectTo('game.php?page=buildings');
		}

		$config				= Config::get();

		$queueData	 		= $this->getQueueData();
		$Queue	 			= $queueData['queue'];
		$QueueCount			= count($Queue);
		$CanBuildElement 	= isVacationMode($USER) || $config->max_elements_build == 0 || $QueueCount < $config->max_elements_build;
		$CurrentMaxFields   = CalculateMaxPlanetFields($PLANET);
		
		$RoomIsOk 			= $PLANET['field_current'] < ($CurrentMaxFields - $QueueCount);
				
		$BuildEnergy		= $USER[$resource[113]];
		$BuildLevelFactor   = 10;
		$BuildTemp          = $PLANET['temp_max'];

        $BuildInfoList      = array();

		$ElementsAll			= array_merge($reslist['allow'][$PLANET['planet_type']]);
		

		
		foreach($ElementsAll as $Element)
		{
			if (!BuildFunctions::isTechnologieAccessible($USER, $PLANET, $Element))
				continue;

			//$infoEnergy	= "";
			
			if(isset($queueData['quickinfo'][$Element]))
			{
				$levelToBuild	= $queueData['quickinfo'][$Element];
			}
			else
			{
				$levelToBuild	= $PLANET[$resource[$Element]];
			}
			
			

			foreach(array_merge($reslist['resstype'][1], $reslist['resstype'][2]) as $res)
            { 
                $info_production[''.$res.'']	= "";
                
                if(in_array($Element, $reslist['prod']))
                {
                	
                	$gouvernor_resource = 0;
					if($USER['dm_resource'] > TIMESTAMP){
						$gouvernor_resource = GubPriceAPSTRACT(704, $USER['dm_resource_level'], 'dm_resource');
					}
				
					$gouvernor_energy = 0;
					if($USER['dm_energie'] > TIMESTAMP){
						$gouvernor_energy = GubPriceAPSTRACT(705, $USER['dm_energie_level'], 'dm_energie');
					}
			//		
					$geologuebon = 2 * $USER['rpg_geologue'];
					$engineerbon = 5 * $USER['rpg_ingenieur'];

                    $BuildLevel	= $PLANET[$resource[$Element]];
                    $Need		= eval(ResourceUpdate::getProd($ProdGrid[$Element]['production'][''.$res.'']));
                                        
                    $BuildLevel	= $levelToBuild + 1;
                    $Prod		= eval(ResourceUpdate::getProd($ProdGrid[$Element]['production'][''.$res.'']));
					
                    $require	= $Prod - $Need;
                    
                    if(in_array($res, $reslist['resstype'][1])){
                        $require	= round($require * $config->resource_multiplier);
                    }
                    if(in_array($res, $reslist['resstype'][2])){
                        $require	= round($require * $config->energySpeed);
                    }

                    
                    if($require < 0) {
                        if($Need < 0){$info_production[''.$res.'']	= sprintf($LNG['bd_need_engine'], abs($require));}
                    } else {
                        if($Need > 0){$info_production[''.$res.'']	= sprintf($LNG['bd_more_engine'], abs($require));}
                    }
                }
            }
            
            foreach($reslist['resstype'][1] as $res)
            { 
                $info_storage[''.$res.'']	= "";
                
                if(in_array($Element, $reslist['storage']))
                {
                    $BuildLevel	= $PLANET[$resource[$Element]];
                    $Need		= eval(ResourceUpdate::getProd($ProdGrid[$Element]['storage'][''.$res.'']));
                                        
                    $BuildLevel	= $levelToBuild + 1;
                    $Prod		= eval(ResourceUpdate::getProd($ProdGrid[$Element]['storage'][''.$res.'']));
					
                    $require	= round(($Prod - $Need) * $config->storage_multiplier);
                    
                    if($require < 0) {
                        //if($Need < 0){$info_storage[''.$res.'']	= sprintf($LNG['bd_need_engine'], pretty_number(abs($require)));}
                        if($Need < 0){$info_storage[''.$res.'']	= sprintf($LNG['bd_need_engine'], abs($require));}
                    } else {
                        if($Need > 0){$info_storage[''.$res.'']	= sprintf($LNG['bd_more_engine'], abs($require));}
                    }
                }
            }
			
			$costResources		= BuildFunctions::getElementPrice($USER, $PLANET, $Element, false, $levelToBuild+1);
			$costOverflow		= BuildFunctions::getRestPrice($USER, $PLANET, $Element, $costResources);
			$elementTime    	= BuildFunctions::getBuildingTime($USER, $PLANET, $Element, $costResources);
			$destroyResources	= BuildFunctions::getElementPrice($USER, $PLANET, $Element, true);
			$destroyTime		= BuildFunctions::getBuildingTime($USER, $PLANET, $Element, $destroyResources);
			$destroyOverflow	= BuildFunctions::getRestPrice($USER, $PLANET, $Element, $destroyResources);
			$buyable			= $QueueCount != 0 || BuildFunctions::isElementBuyable($USER, $PLANET, $Element, $costResources);

			$BuildInfoList[$Element]	= array(
				'level'				=> $PLANET[$resource[$Element]],
				'maxLevel'			=> $pricelist[$Element]['max'],
				//'infoEnergy'		=> $infoEnergy,
				'costResources'		=> $costResources,
				'costOverflow'		=> $costOverflow,
				'elementTime'    	=> $elementTime,
				'destroyResources'	=> $destroyResources,
				'destroyTime'		=> $destroyTime,
				'destroyOverflow'	=> $destroyOverflow,
				'buyable'			=> $buyable,
				'levelToBuild'		=> $levelToBuild,
				'ressources'		    => array_merge($reslist['resstype'][1], $reslist['resstype'][2]),
                'storage'		        => $reslist['resstype'][1],
			);

			foreach(array_merge($reslist['resstype'][1], $reslist['resstype'][2]) as $res)
            { 
                $class_production = 5000;
                $id_class_production = $res + $class_production;
                
                $BuildInfoList[$Element]	+= array(
                    ''.$id_class_production.''	    => $info_production[''.$res.''],
                    'class_production'	            => $class_production,
                );
            }
            
            foreach($reslist['resstype'][1] as $res)
            {   
                $class_storage = 5100;
                $id_class_storage = $res + $class_storage;
                
                $BuildInfoList[$Element]	+= array(
                    ''.$id_class_storage.''	    => $info_storage[''.$res.''],
                    'class_storage'	            => $class_storage,
                );
            }
		}


		///Mod de acelracón by YamilRH

		if ($PLANET['planet_type']==3){
			$dm_fast = floor(7000*($PLANET['b_building']-TIMESTAMP)/3600);
		}
		else{
			$dm_fast = floor(5000*($PLANET['b_building']-TIMESTAMP)/3600);
		} 
		//aki

		
		if ($QueueCount != 0) {
			$this->tplObj->loadscript('buildlist.js');
		}
		
		$this->assign(array(
			'BuildInfoList'		=> $BuildInfoList,
			//'elementListDefault'			=> $elementListDefault,
			//'elementListDefault1'			=> $elementListDefault1,
			//'elementListDefault2'			=> $elementListDefault2,
			'CanBuildElement'	=> $CanBuildElement,
			'RoomIsOk'			=> $RoomIsOk,
			'Queue'				=> $Queue,
			'need_dm'			=> $dm_fast,
			'isBusy'			=> array('shipyard' => !empty($PLANET['b_hangar_id']), 'defense' => !empty($PLANET['b_defense_id']), 'research' => $USER['b_tech_planet'] != 0),
			'HaveMissiles'		=> (bool) $PLANET[$resource[503]] + $PLANET[$resource[502]],
		));

		/*print_r($BuildInfoList);
		exit;*/
			
		$this->display('page.buildings.default.tpl');
	}
}
