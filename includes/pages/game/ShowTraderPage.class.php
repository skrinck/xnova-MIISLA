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


class ShowTraderPage extends AbstractGamePage
{
	public static $requireModule = MODULE_TRADER;

	function __construct() 
	{
		parent::__construct();
	}
	
	public static $Charge = array(
		901	=> array(901 => 1, 902 => 2, 903 => 4),
		902	=> array(901 => 0.5, 902 => 1, 903 => 2),
		903	=> array(901 => 0.25, 902 => 0.5, 903 => 1),
	);
	
	public function show() 
	{
		global $LNG, $USER, $resource;

		$darkmatter_cost_trader	= Config::get()->darkmatter_cost_trader;

		$this->assign(array(
			'tr_cost_dm_trader'		=> sprintf($LNG['tr_cost_dm_trader'], pretty_number($darkmatter_cost_trader), $LNG['tech'][921]),
			'charge'				=> self::$Charge,
			'resource'				=> $resource,
			'requiredDarkMatter'	=> $USER['darkmatter'] < $darkmatter_cost_trader ? sprintf($LNG['tr_not_enought'], $LNG['tech'][921]) : false,
		));
		
		$this->display("page.trader.default.tpl");
	}
		
	function trade()
	{
		global $USER, $LNG;
		
		if ($USER['darkmatter'] < Config::get()->darkmatter_cost_trader) {
			$this->redirectTo('game.php?page=trader');
		}
		
		$resourceID	= HTTP::_GP('resource', 0);
		
		if(!in_array($resourceID, array_keys(self::$Charge))) {
			$this->printMessage($LNG['invalid_action'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=trader'
			)));
		}
		
		$tradeResources	= array_values(array_diff(array_keys(self::$Charge[$resourceID]), array($resourceID)));
		$this->tplObj->loadscript("trader.js");
		$this->assign(array(
			'tradeResourceID'	=> $resourceID,
			'tradeResources'	=> $tradeResources,
			'charge' 			=> self::$Charge[$resourceID],
		));

		$this->display('page.trader.trade.tpl');
	}
	
	function send()
	{
		global $USER, $PLANET, $LNG, $resource;
		
		if ($USER['darkmatter'] < Config::get()->darkmatter_cost_trader) {
			$this->redirectTo('game.php?page=trader');
		}
		
		$resourceID	= HTTP::_GP('resource', 0);
		
		if(!in_array($resourceID, array_keys(self::$Charge))) {
			$this->printMessage($LNG['invalid_action'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=trader'
			)));
		}

		$getTradeResources	= HTTP::_GP('trade', array());
		
		$tradeResources		= array_values(array_diff(array_keys(self::$Charge[$resourceID]), array($resourceID)));
		$tradeSum 			= 0;

		$sum=0;
		// $PLANET[$resource[$resourceID]]//  a comparar
		foreach($tradeResources as $tradeRessID)
		{
			$tradeAmount	= max(0, round((float) $getTradeResources[$tradeRessID]));

			$sum+= $tradeAmount * self::$Charge[$resourceID][$tradeRessID];
		}
		
		if($sum>$PLANET[$resource[$resourceID]])
		{
			$this->printMessage(sprintf($LNG['tr_not_enought'], $LNG['tech'][$resourceID]), array(array(
						'label'	=> $LNG['sys_back'],
						'url'	=> 'game.php?page=trader'
					)));
			//exit;
		}
		
		foreach($tradeResources as $tradeRessID)
		{
			// if(!isset($getTradeResources[$tradeRessID]))
			// {
			// 	continue;
			// }
			$tradeAmount	= max(0, round((float) $getTradeResources[$tradeRessID]));

			if(empty($tradeAmount) || !isset(self::$Charge[$resourceID][$tradeRessID]))
			{
				continue;  
			}
			

			if(isset($PLANET[$resource[$resourceID]]))
			{
				$usedResources	= $tradeAmount * self::$Charge[$resourceID][$tradeRessID];
				
				if($usedResources > $PLANET[$resource[$resourceID]])
				{
					$this->printMessage(sprintf($LNG['tr_not_enought'], $LNG['tech'][$resourceID]), array(array(
						'label'	=> $LNG['sys_back'],
						'url'	=> 'game.php?page=trader'
					)));
				}
				else
				{
					$tradeSum	  						+= $tradeAmount;
					$PLANET[$resource[$resourceID]]		-= $usedResources;
				}
				
			}
			elseif(isset($USER[$resource[$resourceID]]))
			{
				if($resourceID == 921)
				{
					$USER[$resource[$resourceID]]	-= Config::get()->darkmatter_cost_trader;
				}
				
				$usedResources	= $tradeAmount * self::$Charge[$resourceID][$tradeRessID];
				
				if($usedResources > $USER[$resource[$resourceID]])
				{
					$this->printMessage(sprintf($LNG['tr_not_enought'], $LNG['tech'][$resourceID]), array(array(
						'label'	=> $LNG['sys_back'],
						'url'	=> 'game.php?page=trader'
					)));
				}
				else
				{

					$tradeSum	  						+= $tradeAmount;
					$USER[$resource[$resourceID]]		-= $usedResources;
				}
				
				if($resourceID == 921)
				{
					$USER[$resource[$resourceID]]	+= Config::get()->darkmatter_cost_trader;
				}
			}
			else
			{
				throw new Exception('Unknown resource ID #'.$resourceID);
			}
			
			if(isset($PLANET[$resource[$tradeRessID]]))
			{
				$PLANET[$resource[$tradeRessID]]	+= $tradeAmount;
			}
			elseif(isset($USER[$resource[$tradeRessID]]))
			{
				$USER[$resource[$tradeRessID]]		+= $tradeAmount;
			}
			else
			{
				throw new Exception('Unknown resource ID #'.$tradeRessID);
			}
		}
		
		if ($tradeSum > 0)
		{
			$USER[$resource[921]]	-= Config::get()->darkmatter_cost_trader;
		}
		
		$this->printMessage($LNG['tr_exchange_done'], array(array(
			'label'	=> $LNG['sys_forward'],
			'url'	=> 'game.php?page=trader'
		)));
	}
}
