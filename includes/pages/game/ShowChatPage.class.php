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

class ShowChatPage extends AbstractGamePage
{
	public static $requireModule = MODULE_CHAT;

	function __construct() 
	{
		parent::__construct();
	}
	
	function show() 
	{
		$action	= HTTP::_GP('action', '');
		if($action == 'alliance') {
			$this->setWindow('popup');
			$this->initTemplate();
		}
		
		$this->display('page.chat.default.tpl');
	}
}
