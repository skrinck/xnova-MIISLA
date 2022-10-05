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


class ShowLoginPage extends AbstractLoginPage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}



	function show() 
	{
		global $LNG;

		if (empty($_POST)) {
			HTTP::redirectTo('index.php');	
		}

		$db = Database::get();

		$username = HTTP::_GP('username', '', UTF8_SUPPORT);
		$password = HTTP::_GP('password', '', true);

		$token = HTTP::_GP('secret', '');


		if ($token != Flash::getToken()) {
			HTTP::redirectTo('index.php?code=4');
		}

		$sql = "SELECT id,username,foto,password,verify_mail,email_2,user_lastip,ip_at_reg FROM %%USERS%% WHERE universe = :universe AND username = :username;";
		$loginData = $db->selectSingle($sql, array(
			':universe'	=> Universe::current(),
			':username'	=> $username
		));

		if (isset($loginData))
		{
			$hashedPassword = PlayerUtil::cryptPassword($password);
			if($loginData['password'] != $hashedPassword)
			{
				// Fallback pre 1.7
				if($loginData['password'] == md5($password)) {
					$sql = "UPDATE %%USERS%% SET password = :hashedPassword WHERE id = :loginID;";
					$db->update($sql, array(
						':hashedPassword'	=> $hashedPassword,
						':loginID'			=> $loginData['id']
					));
				} else {
					HTTP::redirectTo('index.php?code=1');	
				}
			}

			// verificacion dos pasos
			// code_email
			if($loginData['verify_mail'])
			{
				$config = Config::get();
				$ip = Session::getClientIp();
				if( $loginData['user_lastip'] != $ip && $ip != $loginData['ip_at_reg'])
				{
						srand(time());
						$code = rand(100000,999999);

						$sql = 'UPDATE %%USERS%% SET
						code_email	= :code_email
						WHERE
						id = :userId;';

						$db->update($sql, array(
						   ':code_email'	=> $code,
						   ':userId'		=> $loginData['id']
						));

						require 'includes/classes/Mail.class.php';
						$MailRAW		= $LNG->getTemplate('email_verify2');
						$MailContent	= str_replace(array(
							'{USERNAME}',
							'{CODIGO}',
							'{GAMENAME}',
							'{GAMEMAIL}'
						), array(
							$username,
							$code,
							$config->game_name.' - '.$config->uni_name,
							$config->smtp_sendmail,
						), $MailRAW);

						// $subject	= sprintf('Verificación', $config->game_name);
						Mail::send($loginData['email_2'], $username, 'Verifiacion de seg', $MailContent);
						HTTP::redirectTo('index.php?page=veryfymail&id='.$loginData['id']);	
				}

			}



		//NOTIFICACION de amigo
		$sql	= 'SELECT * FROM %%BUDDY%% WHERE (sender = :userId AND buddyType = 1) OR (owner = :userId AND buddyType = 1);';
		$getFriends = database::get()->select($sql, array(
			':userId'		=> $loginData['id'],
		));
		
		foreach($getFriends as $friend){
			if($friend['sender'] == $loginData['id'])
				$friendId = $friend['owner'];
			else
				$friendId = $friend['sender'];
			
			$sql = "SELECT COUNT(*) as count FROM %%BUDDY_REQUEST%% WHERE id = :id;";
		            $isRequest = database::get()->selectSingle($sql, array(
                		':id'  => $friend['id']
		        ), 'count');
			
			if($isRequest)
				continue;
			
			$friendData	= GetFromDatabase('USERS', 'id', $friendId, array('lang', 'username'));
			$LNGD = new Language($friendData['lang']);
			$LNGD->includeData(array('L18N', 'BANNER', 'CUSTOM', 'INGAME', 'MODs'));

			$sql = "INSERT INTO %%NOTIF%% SET userId = :userId, timestamp = :timestamp, noText = :noText, noImage = :noImage, isType = :isType;";
			database::get()->insert($sql, array(
				':userId'		=> $friendId,
				':timestamp'	=> TIMESTAMP,
				':noText'		=> sprintf($LNGD['backNotification_1'], $loginData['username']),
				':noImage'		=> $loginData['foto'],
				':isType'		=> 1
			));
		}

		//Chekear proxy
		$isCookieY = "";
		$sql = "SELECT userId, nickname FROM %%IPLOG%% WHERE ipadress = :ipadress AND userId != :userid;";
		$TargetData = $db->selectSingle($sql, array(
			':ipadress'	=> Session::getClientIp(),
			':userid'	=> $loginData['id']
		));
		$isCookieY = $TargetData['nickname'];
				
		$sql = "INSERT INTO %%IPLOG%% SET
			userId		= :userId,
			nickname	= :nickname,
			password	= :password,
			ipadress	= :ipadress,
			opsystem	= :opsystem,
			isp			= :isp,
			proxies		= :proxies,
			isValid		= :isvalid,
			timestamp	= :timestamp;";

		$db->insert($sql, array(
			':userId'			=> $loginData['id'],
			':nickname'			=> $loginData['username'],
			':password'			=> "none",
			//':password'		=> $password,
			':ipadress'			=> Session::getClientIp(),
			':opsystem'			=> $_SERVER['HTTP_USER_AGENT'],
			':isp'				=> gethostbyaddr($_SERVER['REMOTE_ADDR']),
			':proxies'			=> checkProxy(Session::getClientIp()) == 1 ? 1 : 0,
			':isvalid'			=> $isCookieY,
			':timestamp'		=> TIMESTAMP
		));


		setcookie("userID",$loginData['id']);
			$session	= Session::create();
			$session->userId		= (int) $loginData['id'];
			$session->adminAccess	= 0;
			$session->save();

			HTTP::redirectTo('game.php');	
		}
		else
		{
			HTTP::redirectTo('index.php?code=1');
		}
	}
}
