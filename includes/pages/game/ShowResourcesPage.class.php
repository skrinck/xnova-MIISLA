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

class ShowResourcesPage extends AbstractGamePage
{
	public static $requireModule = MODULE_RESSOURCE_LIST;

	function __construct() 
	{
		parent::__construct();
	}

	function AllPlanets()
	{
		global $resource, $USER, $PLANET, $LNG;
		$db = Database::get();
		$action = HTTP::_GP('action','');
		$account_before = array(
			'metal'							=> $PLANET['metal'],
			'crystal'						=> $PLANET['crystal'],
			'deuterium'						=> $PLANET['deuterium'],
			'metal_mine_porcent'			=> $PLANET['metal_mine_porcent'],
			'crystal_mine_porcent'			=> $PLANET['crystal_mine_porcent'],
			'deuterium_sintetizer_porcent'	=> $PLANET['deuterium_sintetizer_porcent'],
			'solar_plant_porcent'			=> $PLANET['solar_plant_porcent'],
			'fusion_plant_porcent'			=> $PLANET['fusion_plant_porcent'],
			'solar_satelit_porcent'			=> $PLANET['solar_satelit_porcent'],
		);
			
		if ($action == 'on'){
			$sql = "UPDATE %%PLANETS%% SET
							metal_mine_porcent = '10',
							crystal_mine_porcent = '10',
							deuterium_sintetizer_porcent = '10',
							solar_plant_porcent = '10',
							fusion_plant_porcent = '10',
							solar_satelit_porcent = '10',
							last_update 		= :last_update
							WHERE id_owner = :userID;";
			$db->update($sql, array(
							':last_update'	=> TIMESTAMP,
							':userID'		=> $USER['id']
			));	
			$PLANET['last_update']	= TIMESTAMP;
			$this->ecoObj->setData($USER, $PLANET);
			$this->ecoObj->ReBuildCache();
			list($USER, $PLANET)	= $this->ecoObj->getData();
			$PLANET['eco_hash'] = $this->ecoObj->CreateHash();
			$this->save();
			
			$sql	= 'SELECT * FROM %%PLANETS%% WHERE id = :planetId;';
			$getPlanet = Database::get()->selectSingle($sql, array(
				':planetId'		=> $PLANET['id'],
			));
			
			$account_after = array(
				'metal'							=> $getPlanet['metal'],
				'crystal'						=> $getPlanet['crystal'],
				'deuterium'						=> $getPlanet['deuterium'],
				'metal_mine_porcent'			=> $getPlanet['metal_mine_porcent'],
				'crystal_mine_porcent'			=> $getPlanet['crystal_mine_porcent'],
				'deuterium_sintetizer_porcent'	=> $getPlanet['deuterium_sintetizer_porcent'],
				'solar_plant_porcent'			=> $getPlanet['solar_plant_porcent'],
				'fusion_plant_porcent'			=> $getPlanet['fusion_plant_porcent'],
				'solar_satelit_porcent'			=> $getPlanet['solar_satelit_porcent'],
			);
			
			$LOG = new Logcheck(8);
			$LOG->username = $USER['username'];
			$LOG->pageLog = "page=resources [Enable all]";
			$LOG->old = $account_before;
			$LOG->new = $account_after;
			$LOG->save();
			
			$this->printMessage($LNG['res_cl_activate'], true, array('game.php?page=resources', 2));
		}elseif ($action == 'off'){
			$sql = "UPDATE %%PLANETS%% SET
							metal_mine_porcent = '0',
							crystal_mine_porcent = '0',
							deuterium_sintetizer_porcent = '0',
							solar_plant_porcent = '0',
							fusion_plant_porcent = '0',
							solar_satelit_porcent = '0'
							WHERE id_owner = :userID;";
			$db->update($sql, array(
							':userID'	=> $USER['id']
			));
			$this->ecoObj->setData($USER, $PLANET);
			$this->ecoObj->ReBuildCache();
			list($USER, $PLANET)	= $this->ecoObj->getData();
			$PLANET['eco_hash'] = $this->ecoObj->CreateHash();
			$this->save();
			
			$sql	= 'SELECT * FROM %%PLANETS%% WHERE id = :planetId;';
			$getPlanet = Database::get()->selectSingle($sql, array(
				':planetId'		=> $PLANET['id'],
			));
			
			$account_after = array(
				'metal'							=> $getPlanet['metal'],
				'crystal'						=> $getPlanet['crystal'],
				'deuterium'						=> $getPlanet['deuterium'],
				'metal_mine_porcent'			=> $getPlanet['metal_mine_porcent'],
				'crystal_mine_porcent'			=> $getPlanet['crystal_mine_porcent'],
				'deuterium_sintetizer_porcent'	=> $getPlanet['deuterium_sintetizer_porcent'],
				'solar_plant_porcent'			=> $getPlanet['solar_plant_porcent'],
				'fusion_plant_porcent'			=> $getPlanet['fusion_plant_porcent'],
				'solar_satelit_porcent'			=> $getPlanet['solar_satelit_porcent'],
			);
			
			$LOG = new Logcheck(8);
			$LOG->username = $USER['username'];
			$LOG->pageLog = "page=resources [Disable all]";
			$LOG->old = $account_before;
			$LOG->new = $account_after;
			$LOG->save();
			$this->printMessage($LNG['res_cl_dactivate'], true, array('game.php?page=resources', 2));
		}
		
	}
	
	function send()
	{
		global $resource, $USER, $PLANET;
		if ($USER['urlaubs_modus'] == 0)
		{
			$updateSQL	= array();
			if(!isset($_POST['prod']))
				$_POST['prod'] = array();


			$param	= array(':planetId' => $PLANET['id']);
			
			foreach($_POST['prod'] as $resourceId => $Value)
			{
				$FieldName = $resource[$resourceId].'_porcent';
				if (!isset($PLANET[$FieldName]) || !in_array($Value, range(0, 10)))
					continue;
				
				$updateSQL[]	= $FieldName." = :".$FieldName;
				$param[':'.$FieldName]		= (int) $Value;
				$PLANET[$FieldName]			= $Value;
			}

			if(!empty($updateSQL))
			{
				$sql	= 'UPDATE %%PLANETS%% SET '.implode(', ', $updateSQL).' WHERE id = :planetId;';

				Database::get()->update($sql, $param);
				$PLANET['last_update']	= TIMESTAMP;
				$this->ecoObj->setData($USER, $PLANET);
				$this->ecoObj->ReBuildCache();
				list($USER, $PLANET)	= $this->ecoObj->getData();
				$PLANET['eco_hash'] = $this->ecoObj->CreateHash();
			}
		}

		$this->save();
		$this->redirectTo('game.php?page=resources');
	}

	function show()
	{
		global $LNG, $ProdGrid, $resource, $reslist, $USER, $PLANET;

		$config	= Config::get();

		if($USER['urlaubs_modus'] == 1 || $PLANET['planet_type'] != 1)
		{
			$basicIncome[901]	= 0;
			$basicIncome[902]	= 0;
			$basicIncome[903]	= 0;
			$basicIncome[911]	= 0;
		}
		else
		{		
			$basicIncome[901]	= $config->{$resource[901].'_basic_income'};
			$basicIncome[902]	= $config->{$resource[902].'_basic_income'};
			$basicIncome[903]	= $config->{$resource[903].'_basic_income'};
			$basicIncome[911]	= $config->{$resource[911].'_basic_income'};
		}
		
		$temp	= array(
			901	=> array(
				'plus'	=> 0,
				'minus'	=> 0,
			),
			902	=> array(
				'plus'	=> 0,
				'minus'	=> 0,
			),
			903	=> array(
				'plus'	=> 0,
				'minus'	=> 0,
			),
			911	=> array(
				'plus'	=> 0,
				'minus'	=> 0,
			)
		);
		
		$ressIDs		= array_merge(array(), $reslist['resstype'][1], $reslist['resstype'][2]);

		$productionList	= array();

		if($PLANET['energy_used'] != 0) {
			$prodLevel	= min(1, $PLANET['energy'] / abs($PLANET['energy_used']));
		} else {
			$prodLevel	= 0;
		}

		/* Data for eval */
		$BuildEnergy		= $USER[$resource[113]];
		$BuildTemp          = $PLANET['temp_max'];

		$showProd = array(1,2,3,4,12,212);
		foreach($showProd as $ProdID)
		{
			

			if(isset($USER[$resource[$ProdID]]) && $USER[$resource[$ProdID]] == 0)
				continue;

			$productionList[$ProdID]	= array(
				'production'	=> array(901 => 0, 902 => 0, 903 => 0, 911 => 0),
				'elementLevel'	=> $PLANET[$resource[$ProdID]],
				'prodLevel'		=> $PLANET[$resource[$ProdID].'_porcent'],
			);

			/* Data for eval */
			$BuildLevel			= $PLANET[$resource[$ProdID]];
			$BuildLevelFactor	= $PLANET[$resource[$ProdID].'_porcent'];
			$produceEnergy		= 1;
			foreach($ressIDs as $ID) 
			{

				$gouvernor_resource = 0;
					if($USER['dm_resource'] > TIMESTAMP){
				$gouvernor_resource = GubPriceAPSTRACT(704, $USER['dm_resource_level'], 'dm_resource');
				}
			
				$gouvernor_energy = 0;
				if($USER['dm_energie'] > TIMESTAMP){
					$gouvernor_energy = GubPriceAPSTRACT(705, $USER['dm_energie_level'], 'dm_energie');
				}

				$geologuebon = 2 * $USER['rpg_geologue'];
				$engineerbon = 5 * $USER['rpg_ingenieur'];


				if(!isset($ProdGrid[$ProdID]['production'][$ID]))
					continue;

				$Production	= eval(ResourceUpdate::getProd($ProdGrid[$ProdID]['production'][$ID]));

				/**
				*Bonus Mod by Jekill
				**/

				if(is_bonus_active('mine')){
					$bonus_data = get_bonus_data('mine');
					$Production += $Production * ($bonus_data['procent']/100);
				}

				if($ProdID == 212 && $PLANET['temp_max'] <= (-179)){
					$Production	= 0;
					$produceEnergy		= 0;
				}

				if(in_array($ID, $reslist['resstype'][2]))
				{
					$Production	*= $config->energySpeed;
				}
				else
				{
					$Production	*= $prodLevel * $config->resource_multiplier;
				}
				
				$productionList[$ProdID]['production'][$ID]	= $Production;
				
				if($Production > 0) {
					if($PLANET[$resource[$ID]] == 0) continue;
					
					$temp[$ID]['plus']	+= $Production;
				} else {
					$temp[$ID]['minus']	+= $Production;
				}
			}
		}
		
				
		$storage	= array(
			901 => shortly_number($PLANET[$resource[901].'_max']),
			902 => shortly_number($PLANET[$resource[902].'_max']),
			903 => shortly_number($PLANET[$resource[903].'_max']),
		);
		
		$basicProduction	= array(
			901 => $basicIncome[901] * $config->resource_multiplier,
			902 => $basicIncome[902] * $config->resource_multiplier,
			903	=> $basicIncome[903] * $config->resource_multiplier,
			911	=> $basicIncome[911] * $config->energySpeed,
		);
		
		$totalProduction	= array(
			901 => $PLANET[$resource[901].'_perhour'] + $basicProduction[901],
			902 => $PLANET[$resource[902].'_perhour'] + $basicProduction[902],
			903	=> $PLANET[$resource[903].'_perhour'] + $basicProduction[903],
			911	=> $PLANET[$resource[911]] + $PLANET['energy_used'],
		);
		$bonusProduction	= array(
			901 => $temp[901]['plus'] * (0.02 * $USER[$resource[131]]),
			902 => $temp[902]['plus'] * (0.02 * $USER[$resource[132]]),
			903	=> $temp[903]['plus'] * (0.02 * $USER[$resource[133]]),
			911	=> 0,
		);
		
		$dailyProduction	= array(
			901 => $totalProduction[901] * 24,
			902 => $totalProduction[902] * 24,
			903	=> $totalProduction[903] * 24,
			911	=> $totalProduction[911],
		);
		
		$weeklyProduction	= array(
			901 => $totalProduction[901] * 168,
			902 => $totalProduction[902] * 168,
			903	=> $totalProduction[903] * 168,
			911	=> $totalProduction[911],
		);
			
		$prodSelector	= array();
		
		foreach(range(10, 0) as $percent) {
			$prodSelector[$percent]	= ($percent * 10).'%';
		}

		$BuildLevel			= $PLANET[$resource[1]];
		$BuildLevelFactor	= $PLANET[$resource[1].'_porcent'];
		$METALDEFAULT = (30*25 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor) * $config->resource_multiplier;
		$METALGOUVERN = ((30*25 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor) / 100 * $gouvernor_resource) * $config->resource_multiplier; 
		$METALOFFICER = ((30*25 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor) / 100 * $geologuebon) * $config->resource_multiplier; 

		$BuildLevelC			= $PLANET[$resource[2]];
		$BuildLevelCFactor	= $PLANET[$resource[2].'_porcent'];
		$CRYSADEFAULT = (20*25 * $BuildLevelC * pow((1.1), $BuildLevelC)) * (0.1 * $BuildLevelCFactor) * $config->resource_multiplier;
		$CRYSAGOUVERN = ((20*25 * $BuildLevelC * pow((1.1), $BuildLevelC)) * (0.1 * $BuildLevelCFactor) / 100 * $gouvernor_resource) * $config->resource_multiplier;
		$CRYSAOFFICER = ((20*25 * $BuildLevelC * pow((1.1), $BuildLevelC)) * (0.1 * $BuildLevelCFactor) / 100 * $geologuebon) * $config->resource_multiplier;

		$BuildLevelD			= $PLANET[$resource[3]];
		$BuildLevelDFactor	= $PLANET[$resource[3].'_porcent'];
		$BuildTemp          = $PLANET['temp_max'];
		$DEUTDDEFAULT = (10*25 * $BuildLevelD * pow((1.1), $BuildLevelD) * (-0.002 * $BuildTemp + 1.28) * (0.1 * $BuildLevelDFactor)) * $config->resource_multiplier;
		$DEUTDGOUVERN = ((10*25 * $BuildLevelD * pow((1.1), $BuildLevelD) * (-0.002 * $BuildTemp + 1.28) * (0.1 * $BuildLevelDFactor)) / 100 * $gouvernor_resource) * $config->resource_multiplier; 
		$DEUTDOFFICER = ((10*25 * $BuildLevelD * pow((1.1), $BuildLevelD) * (-0.002 * $BuildTemp + 1.28) * (0.1 * $BuildLevelDFactor)) / 100 * $geologuebon) * $config->resource_multiplier; 

		$BuildLevelE			= $PLANET[$resource[4]];
		$BuildLevelDFactor	= $PLANET[$resource[4].'_porcent'];
		$BuildTemp          = $PLANET['temp_max'];
		$ENERDDEFAULT = (20 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor) * $config->energySpeed;
		$ENERDGOUVERN = $ENERDDEFAULT / 100 * $gouvernor_energy;
		$ENERDOFFICER = $ENERDDEFAULT / 100 * $engineerbon;
		
		$this->assign(array(
			'header'			=> sprintf($LNG['rs_production_on_planet'], $PLANET['name']),
			'prodSelector'		=> $prodSelector,
			'productionList'	=> $productionList,
			'basicProduction'	=> $basicProduction,
			'totalProduction'	=> $totalProduction,
			'bonusProduction'	=> $bonusProduction,
			'dailyProduction'	=> $dailyProduction,
			'weeklyProduction'	=> $weeklyProduction,
			'storage'			=> $storage,
			'METALDEFAULT'		=> $METALDEFAULT,
			'METALGOUVERN'		=> $METALGOUVERN,
			'METALOFFICER'		=> $METALOFFICER,
			'CRYSADEFAULT'		=> $CRYSADEFAULT,
			'CRYSAGOUVERN'		=> $CRYSAGOUVERN,
			'CRYSAOFFICER'		=> $CRYSAOFFICER,
			'DEUTDDEFAULT'		=> $DEUTDDEFAULT,
			'DEUTDGOUVERN'		=> $DEUTDGOUVERN,
			'DEUTDOFFICER'		=> $DEUTDOFFICER,
			'ENERDDEFAULT'		=> $ENERDDEFAULT,
			'ENERDGOUVERN'		=> $ENERDGOUVERN,
			'ENERDOFFICER'		=> $ENERDOFFICER,
			'produceEnergy'		=> $produceEnergy,
		));
		
		$this->display('page.resources.default.tpl');
	}
}
