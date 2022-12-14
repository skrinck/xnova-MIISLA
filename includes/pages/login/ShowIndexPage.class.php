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

class ShowIndexPage extends AbstractLoginPage
{
	function __construct() 
	{
		parent::__construct();
		$this->setWindow('light');
	}
	
	function show() 
	{
		global $LNG;
		$AdminsOnline 	= array();
		$db = Database::get();
		
		/*$session	= Session::load();

		if($session->isValidSession())
            {
                HTTP::redirectTo('/game.php');
            }*/
		
		$referralID		= HTTP::_GP('ref', 0);
		if(!empty($referralID))
		{
			$this->redirectTo('index.php?page=register&referralID='.$referralID);
		}
	
		$universeSelect	= array();
		
		foreach(Universe::availableUniverses() as $uniId)
		{
			$config = Config::get($uniId);
			$universeSelect[$uniId]	= $config->uni_name.($config->game_disable == 0 ? $LNG['uni_closed'] : '');
		}
		
		$Code	= HTTP::_GP('code', 0);
		$loginCode	= false;
		if(isset($LNG['login_error_'.$Code]))
		{
			$loginCode	= $LNG['login_error_'.$Code];
		}

        $sql = "SELECT date, title, text, user FROM %%NEWS%% ORDER BY id DESC LIMIT 2;";
        $newsResult = Database::get()->select($sql);

        $newsList	= array();

        foreach ($newsResult as $newsRow)
        {
            $newsList[]	= array(
                'title' => $newsRow['title'],
                'from' 	=> sprintf($LNG['news_from'], _date($LNG['php_tdformat'], $newsRow['date']), $newsRow['user']),
                'text' 	=> makebr($newsRow['text']),
            );
        }

        $this->assign(array(
            'newsList'	=> $newsList,
        ));


        $sql = "SELECT id,username FROM %%USERS%% WHERE universe = :universe AND onlinetime >= :onlinetime AND authlevel > :authlevel;";
        $onlineAdmins = $db->select($sql, array(
            ':universe'     => Universe::current(),
            ':onlinetime'   => TIMESTAMP-10*60,
            ':authlevel'    => AUTH_USR
        ));

        foreach ($onlineAdmins as $AdminRow) {
			$AdminsOnline[$AdminRow['id']]	= $AdminRow['username'];
		}

		$config				= Config::get();
		$this->assign(array(
			'universeSelect'		=> $universeSelect,
			'code'					=> $loginCode,
			'AdminsOnline'				=> $AdminsOnline,
			'descHeader'			=> sprintf($LNG['loginWelcome'], $config->game_name),
			'descText'				=> sprintf($LNG['loginServerDesc'], $config->game_name),
            'gameInformations'      => explode("\n", $LNG['gameInformations']),
			'loginInfo'				=> sprintf($LNG['loginInfo'], '<a href="index.php?page=rules">'.$LNG['menu_rules'].'</a>'),
			'token'					=>Flash::createToken()
		));
		
		$this->display('page.index.default.tpl');
	}
}
