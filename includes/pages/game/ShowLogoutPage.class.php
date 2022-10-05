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


class ShowLogoutPage extends AbstractGamePage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
		$this->setWindow('popup');
	}
	
	function show() 
	{


        global $USER;
        
        $sql    = 'SELECT * FROM %%BUDDY%% WHERE (sender = :userId AND buddyType = 1) OR (owner = :userId AND buddyType = 1);';
        $getFriends = database::get()->select($sql, array(
            ':userId'       => $USER['id'],
        ));
        
        foreach($getFriends as $friend){
            if($friend['sender'] == $USER['id'])
                $friendId = $friend['owner'];
            else
                $friendId = $friend['sender'];
            
            $sql = "SELECT COUNT(*) as count FROM %%BUDDY_REQUEST%% WHERE id = :id;";
            $isRequest = database::get()->selectSingle($sql, array(
                ':id'  => $friend['id']
            ), 'count');
            
            if($isRequest)
                continue;
            
            $friendData = GetFromDatabase('USERS', 'id', $friendId, array('lang', 'username'));
            $LNGD = new Language($friendData['lang']);
            $LNGD->includeData(array('L18N', 'BANNER', 'CUSTOM', 'INGAME', 'MODs'));

            $sql = "INSERT INTO %%NOTIF%% SET userId = :userId, timestamp = :timestamp, noText = :noText, noImage = :noImage, isType = :isType;";
            database::get()->insert($sql, array(
                ':userId'       => $friendId,
                ':timestamp'    => TIMESTAMP,
                ':noText'       => sprintf($LNGD['backNotification_2'], $USER['username']),
                ':noImage'      => $USER['foto'],
                ':isType'       => 2
            ));
        }

		Session::load()->delete();
		$this->display('page.logout.default.tpl');
	}
}
