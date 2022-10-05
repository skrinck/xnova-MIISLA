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

class ShowDisclaimerPage extends AbstractLoginPage
{
	public static $requireModule = 0;

    function __construct()
    {
        parent::__construct();
        $this->setWindow('light');
    }
	
	function show() 
	{
		global $LNG;

		$sql = "SELECT user, rank, address, email, phone, text FROM %%DISCLAIMER%% ORDER BY id ASC;";
		$disclaimerResult = Database::get()->select($sql);

		$disclaimerList	= array();
		
		foreach ($disclaimerResult as $disclaimerRow)
		{
			$disclaimerList[]	= array(
				'user' 			=> $disclaimerRow['user'],
				'rank' 			=> $disclaimerRow['rank'],
				'address'		=> $disclaimerRow['address'],
				'email' 		=> $disclaimerRow['email'],
				'phone' 		=> $disclaimerRow['phone'],
				'text' 			=> $disclaimerRow['text'],
			);
		}
		
		$this->assign(array(
			'disclaimerList'	=> $disclaimerList,
		));
		
		$this->display('page.disclaimer.default.tpl');
	}
}