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


class ShowOfficierPage extends AbstractGamePage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}
	
	public function UpdateExtra($Element)
	{
		global $PLANET, $USER, $resource, $pricelist;
		
		$costResources		= BuildFunctions::getElementPrice($USER, $PLANET, $Element);
			
		if (!BuildFunctions::isElementBuyable($USER, $PLANET, $Element, $costResources)) {
			return;
		}
			
		$USER[$resource[$Element]]	= max($USER[$resource[$Element]], TIMESTAMP) + $pricelist[$Element]['time'];
			
		if(isset($costResources[901])) { $PLANET[$resource[901]]	-= $costResources[901]; }
		if(isset($costResources[902])) { $PLANET[$resource[902]]	-= $costResources[902]; }
		if(isset($costResources[903])) { $PLANET[$resource[903]]	-= $costResources[903]; }
		if(isset($costResources[921])) { $USER[$resource[921]]		-= $costResources[921]; }

		$sql	= 'UPDATE %%USERS%% SET
				'.$resource[$Element].' = :newTime
				WHERE
				id = :userId;';

		Database::get()->update($sql, array(
			':newTime'	=> $USER[$resource[$Element]],
			':userId'	=> $USER['id']
		));
	}

	public function UpdateOfficier($Element)
	{
		global $USER, $PLANET, $resource, $pricelist;
		
		$costResources		= BuildFunctions::getElementPrice($USER, $PLANET, $Element);
			
		if (!BuildFunctions::isTechnologieAccessible($USER, $PLANET, $Element) 
			|| !BuildFunctions::isElementBuyable($USER, $PLANET, $Element, $costResources) 
			|| $pricelist[$Element]['max'] <= $USER[$resource[$Element]]) {
			return;
		}
		
		$USER[$resource[$Element]]	+= 1;
		
		if(isset($costResources[901])) { $PLANET[$resource[901]]	-= $costResources[901]; }
		if(isset($costResources[902])) { $PLANET[$resource[902]]	-= $costResources[902]; }
		if(isset($costResources[903])) { $PLANET[$resource[903]]	-= $costResources[903]; }
		if(isset($costResources[921])) { $USER[$resource[921]]		-= $costResources[921]; }

		$sql	= 'UPDATE %%USERS%% SET
		'.$resource[$Element].' = :newTime
		WHERE
		id = :userId;';

		Database::get()->update($sql, array(
			':newTime'	=> $USER[$resource[$Element]],
			':userId'	=> $USER['id']
		));
	}
	
	public function show()
	{
		global $USER, $PLANET, $resource, $reslist, $LNG, $pricelist;
		
		$updateID	  = HTTP::_GP('id', 0);
				
		if (!empty($updateID) && $_SERVER['REQUEST_METHOD'] === 'POST' && $USER['urlaubs_modus'] == 0)
		{
			if(isModuleAvailable(MODULE_OFFICIER) && in_array($updateID, $reslist['officier'])) {
				$this->UpdateOfficier($updateID);
			} elseif(isModuleAvailable(MODULE_DMEXTRAS) && in_array($updateID, $reslist['dmfunc'])) {
				$this->UpdateExtra($updateID);
			}
		}
		
		$darkmatterList	= array();
		$officierList	= array();
		
		/*if(isModuleAvailable(MODULE_DMEXTRAS))
		{
			foreach($reslist['dmfunc'] as $Element)
			{
				if($USER[$resource[$Element]] > TIMESTAMP) {
					$this->tplObj->execscript("GetOfficerTime(".$Element.", ".($USER[$resource[$Element]] - TIMESTAMP).");");
				}
					if($Element == 709 && $USER[$resource[708]]> 0 OR $Element == 708 && $USER[$resource[709]]> 0)
					continue;
			
				$costResources		= BuildFunctions::getElementPrice($USER, $PLANET, $Element);
				$buyable			= BuildFunctions::isElementBuyable($USER, $PLANET, $Element, $costResources);
				$costOverflow		= BuildFunctions::getRestPrice($USER, $PLANET, $Element, $costResources);
				$elementBonus		= BuildFunctions::getAvalibleBonus($Element);

				$darkmatterList[$Element]	= array(
					'timeLeft'			=> max($USER[$resource[$Element]] - TIMESTAMP, 0),
					'costResources'		=> $costResources,
					'buyable'			=> $buyable,
					'time'				=> $pricelist[$Element]['time'],
					'costOverflow'		=> $costOverflow,
					'elementBonus'		=> $elementBonus,
				);
			}
		}*/
		
		if(isModuleAvailable(MODULE_OFFICIER))
		{
			foreach($reslist['officier'] as $Element)
			{
				if (!BuildFunctions::isTechnologieAccessible($USER, $PLANET, $Element))
					continue;
				/**
				* Cambiar facciones por oficiales
				* by YamilRH
				**/
				//if($Element == 619 && $USER[$resource[618]]> 0 OR $Element == 620 && $USER[$resource[618]]> 0 OR $Element == 618 && $USER[$resource[619]]> 0 OR $Element == 620 && $USER[$resource[619]]> 0 OR $Element == 618 && $USER[$resource[620]]> 0 OR $Element == 619 && $USER[$resource[620]]> 0)
				//	continue;  
					
				$costResources		= BuildFunctions::getElementPrice($USER, $PLANET, $Element);
				$buyable			= BuildFunctions::isElementBuyable($USER, $PLANET, $Element, $costResources);
				$costOverflow		= BuildFunctions::getRestPrice($USER, $PLANET, $Element, $costResources);
				$elementBonus		= BuildFunctions::getAvalibleBonus($Element);
				
				$officierList[$Element]	= array(
					'level'				=> $USER[$resource[$Element]],
					'maxLevel'			=> $pricelist[$Element]['max'],
					'costResources'		=> $costResources,
					'buyable'			=> $buyable,
					'costOverflow'		=> $costOverflow,
					'elementBonus'		=> $elementBonus,
				);
			}
		}
		
		$this->assign(array(
			'officierList'		=> $officierList,
			'darkmatterList'	=> $darkmatterList,
			'of_dm_trade'		=> sprintf($LNG['of_dm_trade'], $LNG['tech'][921]),
		));
		
		$this->display('page.officier.default.tpl');
	}
}