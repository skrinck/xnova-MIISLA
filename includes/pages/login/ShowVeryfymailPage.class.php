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

class ShowVeryfymailPage extends AbstractLoginPage
{
	public static $requireModule = 0;

	function __construct()
	{
		parent::__construct();
	}

	function show()
	{
		$db = Database::get();

		$user	= HTTP::_GP('id', 0);


		$error = '';
		if($_POST){
			$code	= HTTP::_GP('code', '');

			$sql = "SELECT id, code_email as code FROM %%USERS%% WHERE universe = :universe AND id = :id;";
			$loginData = $db->selectSingle($sql, array(
				':universe'	=> Universe::current(),
				':id'	=> $user
			));

		
			if($code == $loginData['code']){
				$session	= Session::create();
				$session->userId		= (int) $loginData['id'];
				$session->adminAccess	= 0;
				$session->save();

				HTTP::redirectTo('game.php');	
			}

			$error = 'Bad Code';

		}

		$this->assign(array(
			'id' =>$user
		));
		
		$this->display('page.verifymail.tpl');

	}

}