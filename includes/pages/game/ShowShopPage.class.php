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

class ShowShopPage extends AbstractGamePage
{
	public static $requireModule = 0;
	function __construct()
	{
		parent::__construct();
	}

	function show()
	{
			global $USER, $LNG, $PLANET ;
		$db	 = Database::get();
				$config = Config::get();

		if($USER['id'] != 1)
			$this->printMessage("Esta página se encuentra desabilitada, inténtelo mas tarde.", true, array('game.php?page=overview', 2));

		$sql = "SELECT * FROM %%BONUS%%";
		$bonus = $db->select($sql);


		$sql = "SELECT %%PURCHASEB%%.fecha, %%BONUS%%.* FROM %%PURCHASEB%%,%%BONUS%% WHERE user_id = :user AND %%PURCHASEB%%.bono_id = %%BONUS%%.id ORDER BY %%PURCHASEB%%.fecha DESC limit 1";
		$mypurchase = $db->selectSingle($sql,array(
			':user' => $USER['id'] 
		));

		$aviable = true;
		if($mypurchase!=null)
		{
			$now = time();
			$min = $mypurchase['min_time']*24*60*60;
			$dif = $now-$mypurchase['fecha'];
			$aviable = ($dif > $min)?true:false;
		}

		$bono		= HTTP::_GP('bono', '');
		$id		= $USER['id'];

		$msg = '';
		if($bono)
		{
			if($aviable)
			{
				$sql="INSERT INTO %%PURCHASEB%% SET 
					`user_id`=:id, 
					`bono_id`=:bono, 
					`fecha`=:fecha;
					";
				$db->insert($sql,array(
					':id'=>$id,
					':bono'=>$bono,
					':fecha'=>time()
				));
				HTTP::redirectTo('game.php?page=shop&mode=waiting');				
			}
			else
			{
				$msg = 'No seas malandro no puedes comprar';
			}	
		}
		$min = $mypurchase['min_time']*24*60*60;
		$tiempo = $min+$mypurchase['fecha'];


		$this->assign(array(
			'bonus' => $bonus,
			'latest' =>$mypurchase,
			'aviable' =>$aviable,
			'msg'	=>$msg,
			'tiempo'	=>_date($LNG['php_tdformat'], $tiempo, $USER['timezone']),

		));
		$this->display('page.shop.default.tpl');
	}

	function waiting()
	{
		global $USER, $LNG, $PLANET ;
		$db	 = Database::get();
		$config = Config::get();		
		
		$this->assign(array(
		));
		$this->display('page.shop.succes.tpl');
	}
}
