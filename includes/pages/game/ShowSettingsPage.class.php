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

class ShowSettingsPage extends AbstractGamePage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}
	
	public function show()
	{
		global $USER, $LNG;
		if($USER['urlaubs_modus'] == 1)
		{
			$this->assign(array(
				'vacationUntil'			=> _date($LNG['php_tdformat'], $USER['urlaubs_until'], $USER['timezone']),
				'db_deaktjava'				=> $USER['db_deaktjava'],
				'canVacationDisbaled'	=> $USER['urlaubs_until'] < TIMESTAMP,
			));
			
			$this->display('page.settings.vacation.tpl');
		}
		else
		{
			$this->assign(array(
				'Selectors'			=> array(
					'timezones' => get_timezone_selector(), 
					'Sort' => array(
						0 => $LNG['op_sort_normal'], 
						1 => $LNG['op_sort_koords'],
						2 => $LNG['op_sort_abc']), 
					'SortUpDown' => array(
						0 => $LNG['op_sort_up'], 
						1 => $LNG['op_sort_down']
					),
					'planetOption' => array(
						0 => $LNG['gather_opt_1'], 
						1 => $LNG['gather_opt_2'],
						2 => $LNG['gather_opt_3']
					),
					'sirena' => array(
						0 => $LNG['sirena_opt_0'], 
						1 => $LNG['sirena_opt_1'],
						2 => $LNG['sirena_opt_2'],
						3 => $LNG['sirena_opt_3'],
						4 => $LNG['sirena_opt_4'],
						5 => $LNG['sirena_opt_5'],
						6 => $LNG['sirena_opt_6'],
						7 => $LNG['sirena_opt_7'],
						8 => $LNG['sirena_opt_8'],
						9 => $LNG['sirena_opt_9'],
						10 => $LNG['sirena_opt_10']
					),
					'Skins' => Theme::getAvalibleSkins(), 
					'lang' => $LNG->getAllowedLangs(false)
					),
				'adminProtection'	=> $USER['authattack'],	
				'userAuthlevel'		=> $USER['authlevel'],
				'changeNickTime'	=> ($USER['uctime'] + USERNAME_CHANGETIME) - TIMESTAMP,
				'username'			=> $USER['username'],
				'code'			=> $USER['code'],
				'email'				=> $USER['email'],
				'permaEmail'		=> $USER['verify_mail'],
				'userLang'			=> $USER['lang'],
				'theme'				=> $USER['dpath'],
				'planetSort'		=> $USER['planet_sort'],
				'planetOrder'		=> $USER['planet_sort_order'],
				'spycount'			=> $USER['spio_anz'],
				'fleetActions'		=> $USER['settings_fleetactions'],
				'timezone'			=> $USER['timezone'],
				'db_deaktjava'			=> $USER['db_deaktjava'],
				'queueMessages'		=> $USER['hof'],
				'spyMessagesMode'	=> $USER['spyMessagesMode'],
				'galaxySpy' 		=> $USER['settings_esp'],
				'galaxyBuddyList' 	=> $USER['settings_bud'],
				'galaxyMissle' 		=> $USER['settings_mis'],
				'galaxyMessage' 	=> $USER['settings_wri'],
				'blockPM' 			=> $USER['settings_blockPM'],
				'userid'		 	=> $USER['id'],
				'factor2'		 	=> $USER['verify_mail'],
				'ref_active'		=> Config::get()->ref_active,
				'SELF_URL'          => PROTOCOL.HTTP_HOST.HTTP_ROOT,
				//'foto'				=> $USER['foto'],
				'avatarssd' 		=> $USER['foto'],
				'gatheroptions'		=> $USER['gatheroptions'],
				'sirenas' 			=> $USER['sirena'],
			));
			
			$this->display('page.settings.default.tpl');
		}
	}

private function CheckVMode()
	{
		global $USER, $PLANET;

		if(!empty($USER['b_tech']) || !empty($PLANET['b_building']) || !empty($PLANET['b_hangar']) || !empty($PLANET['b_defense']))
			return false;

		$db = Database::get();

		$sql = "SELECT COUNT(*) as state FROM %%FLEETS%% WHERE fleet_owner = :userID OR
                      (fleet_owner = :userID AND (fleet_start_id = :planetID OR fleet_start_id = :lunaID)) OR
                      (fleet_target_owner = :userID AND hasCanceled != 1);";
            $fleets = $db->selectSingle($sql, array(
                ':userID'   => $USER['id'],
                ':planetID' => $PLANET['id'],
                ':lunaID'   => $PLANET['id_luna']
            ), 'state');

		if($fleets != 0)
			return false;

		$sql = "SELECT * FROM %%PLANETS%% WHERE id_owner = :userID AND id != :planetID AND destruyed = 0;";
		$query = $db->select($sql, array(
			':userID'	=> $USER['id'],
			':planetID'	=> $PLANET['id']
		));

		foreach($query as $CPLANET)
		{
			list($USER, $CPLANET)	= $this->ecoObj->CalcResource($USER, $CPLANET, true);
		
			if(!empty($USER['b_tech']) || !empty($PLANET['b_building']) || !empty($PLANET['b_hangar']) || !empty($PLANET['b_defense']))
				return false;
			
			unset($CPLANET);
		}

		return true;
	}

	public function send()
	{
		global $USER;
		if($USER['urlaubs_modus'] == 1) {
			$this->sendVacation();
		} else {
			$this->sendDefault();
		}
	}

	private function sendVacation() 
	{
		global $USER, $LNG; $PLANET;
		
		$delete		= HTTP::_GP('delete', 0);
		$vacation	= HTTP::_GP('vacation', 0);
		
		$db = Database::get();
		
		if($vacation == 1 && $USER['urlaubs_until'] <= TIMESTAMP) {
			$sql = "UPDATE %%USERS%% SET
                        urlaubs_modus = '0',
                        urlaubs_until = '0',
			urlaubs_next_allowed = :timestamp
                        WHERE id = :userID;";
            $db->update($sql, array(
                ':userID'    => $USER['id'],
		':timestamp'			=> TIMESTAMP + 120*3600,
            ));
            
            
            //fix mv

            $sql = "UPDATE %%PLANETS%% SET
                        last_update = :timestamp,
                        energy_used = '0',
			energy = '0',
                        metal_mine_porcent = '0',
                        crystal_mine_porcent = '0',
                        deuterium_sintetizer_porcent = '0',
                        solar_plant_porcent = '0',
                        fusion_plant_porcent = '0',
                        solar_satelit_porcent = '0'
                        WHERE id_owner = :userID;";
            $db->update($sql, array(
                ':userID'        => $USER['id'],
                ':timestamp'    => TIMESTAMP
            ));
            
            $PLANET['last_update'] = TIMESTAMP;
            
            require 'includes/classes/class.statbuilder.php';
			$stat	= new Statbuilder();
			$stat->MakeStats();
            
           /* $sql2="Select * from %%PLANETS%% WHERE id_owner = :userID;";
            $planets = $db->select($sql2, array(
                ':userID'        => $USER['id'],
            ));
            
            foreach($planets as $planet){
                $this->ecoObj->setData($USER, $planet);
                $this->ecoObj->ReBuildCache();
                list($USER, $planet)    = $this->ecoObj->getData();
                $planet['eco_hash'] = $this->ecoObj->CreateHash();
            }*/

			$this->printMessage($LNG['op_options_changed'], true, array('game.php?page=resources', 2));
            
            
            //end fix
            
        }

        if($delete == 1) {
			$sql	= "UPDATE %%USERS%% SET db_deaktjava = :timestamp WHERE id = :userID;";
			$db->update($sql, array(
				':userID'		=> $USER['id'],
				':timestamp'	=> TIMESTAMP
			));
		} else {
			$sql	= "UPDATE %%USERS%% SET db_deaktjava = 0 WHERE id = :userID;";
			$db->update($sql, array(
				':userID'	=> $USER['id'],
			));
		}
		
		$this->printMessage($LNG['op_options_changed'], array(array(
			'label'	=> $LNG['sys_forward'],
			'url'	=> 'game.php?page=settings'
		)));
	}
	
	private function sendDefault()
	{
		global $USER, $LNG, $THEME;
		
		$adminprotection	= HTTP::_GP('adminprotection', 0);
		
		$username			= HTTP::_GP('username', $USER['username'], UTF8_SUPPORT);
		$code				= HTTP::_GP('code', 0);
		$password			= HTTP::_GP('password', '');
		
		$newpassword		= HTTP::_GP('newpassword', '');
		$newpassword2		= HTTP::_GP('newpassword2', '');
		
		$email				= HTTP::_GP('email', $USER['email']);
		
		$timezone			= HTTP::_GP('timezone', '');	
		$language			= HTTP::_GP('language', '');	
		
		$planetSort			= HTTP::_GP('planetSort', 0);	
		$planetOrder		= HTTP::_GP('planetOrder', 0);
		//$gatheroptions		= HTTP::_GP('gatherOptions', 0);
				
		$theme				= HTTP::_GP('theme', $THEME->getThemeName());	
	
		$queueMessages		= HTTP::_GP('queueMessages', 0);	
		$spyMessagesMode	= HTTP::_GP('spyMessagesMode', 0);
		$sirena				= HTTP::_GP('sirena', 0);

		$spycount			= HTTP::_GP('spycount', 1.0);	
		$fleetactions		= HTTP::_GP('fleetactions', 5);	
		
		$galaxySpy			= HTTP::_GP('galaxySpy', 0);	
		$galaxyMessage		= HTTP::_GP('galaxyMessage', 0);	
		$galaxyBuddyList	= HTTP::_GP('galaxyBuddyList', 0);	
		$galaxyMissle		= HTTP::_GP('galaxyMissle', 0);
		$blockPM			= HTTP::_GP('blockPM', 0);
		
		$vacation			= HTTP::_GP('vacation', 0);	
		$delete				= HTTP::_GP('delete', 0);
		
		$factor2				= HTTP::_GP('factor2', 0);
		$foto		        = HTTP::_GP('foto', '');
		$gatheroptions		= HTTP::_GP('gatherOptions', $USER['gatheroptions']);
		$gatherOptionsType	= implode(',', HTTP::_GP('gatherOptionsType', array()));
		if(!is_numeric(str_replace(',', '', $gatherOptionsType)) && !empty($gatherOptionsType)){
			$gatherOptionsType = "";
		}
		
		// Vertify
		
		// Vertify
		
		define('TARGET', 'media/avatars/'); // Repertoire cible
		define('MAX_SIZE', 500000); // Taille max en octets du fichier
		define('WIDTH_MAX', 800); // Largeur max de l'image en pixels
		define('HEIGHT_MAX', 800); // Hauteur max de l'image en pixels
		// Tableaux de donnees
		$tabExt = array('jpg','png','jpeg', 'gif'); // Extensions autorisees

		$infosImg = array();
		// Variables
		$extension = '';
		$message = '';
		$nomImage = '';
		$Message = '';
		
		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			if( !empty($_FILES['fichier']['name']) )
			{
				$fichier = basename($_FILES['fichier']['name']);
				$extension = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
				if(in_array(strtolower($extension),$tabExt))
				{
					$infosImg = getimagesize($_FILES['fichier']['tmp_name']);
					if($infosImg[2] >= 1 && $infosImg[2] <= 14)
					{
						if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE))
						{
							if(isset($_FILES['fichier']['error'])&& UPLOAD_ERR_OK === $_FILES['fichier']['error'])
							{
								$nomImage = md5(uniqid()) .'.'. $extension;
								if(move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET.$nomImage))
								{
									
									$sql = "UPDATE %%USERS%% SET foto = :foto WHERE id = :userID;";
									database::get()->update($sql, array(
										':foto'	=> $nomImage,
										':userID'	=> $USER['id']
									));
									//$this->printMessage("<span class='vert'>".$LNG['NOUVEAUTE_176']."</span>", true, array('game.php?page=settings', 2));
								}
								else
								{
									//$this->printMessage("<span class='rouge'>".$LNG['NOUVEAUTE_177']."</span>", true, array('game.php?page=settings', 2));
								}
							}
							else
							{
								//$this->printMessage("<span class='rouge'>".$LNG['NOUVEAUTE_178']."</span>", true, array('game.php?page=settings', 2));
							}
						}
						else
						{
							//$this->printMessage("<span class='rouge'>".$LNG['NOUVEAUTE_179']."</span>", true, array('game.php?page=settings', 2));
						}
					}
					else
					{
						//$this->printMessage("<span class='rouge'>".$LNG['NOUVEAUTE_180']."</span>", true, array('game.php?page=settings', 2));
					}
				}
				else
				{
					//$this->printMessage("<span class='rouge'>".$LNG['NOUVEAUTE_181']."</span>", true, array('game.php?page=settings', 2));
				}
			}
			else
			{
				//$this->printMessage("<span class='rouge'>".$LNG['NOUVEAUTE_182']."</span>", true, array('game.php?page=settings', 2));
			}
		}
		// 
		
		$adminprotection	= ($adminprotection == 1 && $USER['authlevel'] != AUTH_USR) ? $USER['authlevel'] : 0;
		
		$spycount			= min(max(round($spycount), 1), 4294967295);
		$fleetactions		= min(max($fleetactions, 1), 99);
		//$code		= min(max($code, 6), 6);
		
		$language			= array_key_exists($language, $LNG->getAllowedLangs(false)) ? $language : $LNG->getLanguage();		
		$theme				= array_key_exists($theme, Theme::getAvalibleSkins()) ? $theme : $THEME->getThemeName();
		
		$db = Database::get();

		/*if ($USER['code'] != 6) {
			$this->printMessage($LNG['op_code_fail'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=settings'
				)));
			return;
		}*/
		/*}else{
			$sql	= "UPDATE %%USERS%% SET code = :vcode WHERE id = :userID;";
			$db->update($sql, array(
				':userID'	=> $USER['id'],
				':code'	=> $code
			));
		}*/
		/*if($code != 0 || $code != ''){
			if(!is_null($USER['code']) || strlen($code) != 6){
				$this->printMessage($LNG['op_code_fail'], array(array(
						'label'	=> $LNG['sys_back'],
						'url'	=> 'game.php?page=settings'
					)));
				return;
			}else{
				$sql	= "UPDATE %%USERS%% SET code = :code WHERE id = :userID;";

				$db->update($sql, array(
					':userID'	=> $USER['id'],
					':code'		=> $code
				));
			}
		}*/
			
		
		if (!empty($username) && $USER['username'] != $username)
		{
			if (!PlayerUtil::isNameValid($username))
			{
				$this->printMessage($LNG['op_user_name_no_alphanumeric'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=settings'
				)));
			}
			elseif($USER['uctime'] >= TIMESTAMP - USERNAME_CHANGETIME)
			{
				$this->printMessage($LNG['op_change_name_pro_week'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=settings'
				)));
			}
			else
			{
				$sql = "SELECT
					(SELECT COUNT(*) FROM %%USERS%% WHERE universe = :universe AND username = :username) +
					(SELECT COUNT(*) FROM %%USERS_VALID%% WHERE universe = :universe AND username = :username)
				AS count";
				$Count = $db->selectSingle($sql, array(
					':universe'	=> Universe::current(),
					':username'	=> $username
				), 'count');

				if (!empty($Count)) {
					$this->printMessage(sprintf($LNG['op_change_name_exist'], $username), array(array(
						'label'	=> $LNG['sys_back'],
						'url'	=> 'game.php?page=settings'
					)));
				} else {
					$sql = "UPDATE %%USERS%% SET username = :username, uctime = :timestamp WHERE id = :userID;";
					$db->update($sql, array(
						':username'	=> $username,
						':userID'	=> $USER['id'],
						':timestamp'=> TIMESTAMP
					));

					Session::load()->delete();
				}
			}
		}
		
		if (!empty($newpassword) && PlayerUtil::cryptPassword($password) == $USER["password"] && $newpassword == $newpassword2)
		{
			$newpass 	 = PlayerUtil::cryptPassword($newpassword);
			$sql = "UPDATE %%USERS%% SET password = :newpass WHERE id = :userID;";
			$db->update($sql, array(
				':newpass'	=> $newpass,
				':userID'	=> $USER['id']
			));
			Session::load()->delete();
		}

		if (!empty($email) && $email != $USER['email'])
		{
			if(PlayerUtil::cryptPassword($password) != $USER['password'])
			{
				$this->printMessage($LNG['op_need_pass_mail'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=settings'
				)));
			}
			elseif(!ValidateAddress($email))
			{
				$this->printMessage($LNG['op_not_vaild_mail'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=settings'
				)));
			}
			else
			{
				$sql = "SELECT
							(SELECT COUNT(*) FROM %%USERS%% WHERE id != :userID AND universe = :universe AND (email = :email OR email_2 = :email)) +
							(SELECT COUNT(*) FROM %%USERS_VALID%% WHERE universe = :universe AND email = :email)
						as count";
				$Count = $db->selectSingle($sql, array(
					':universe'	=> Universe::current(),
					':userID'	=> $USER['id'],
					':email'	=> $email
				), 'count');

				if (!empty($Count)) {
					$this->printMessage(sprintf($LNG['op_change_mail_exist'], $email), array(array(
						'label'	=> $LNG['sys_back'],
						'url'	=> 'game.php?page=settings'
					)));
				} else {
					$sql	= "UPDATE %%USERS%% SET email = :email, setmail = :time WHERE id = :userID;";
					$db->update($sql, array(
						':email'	=> $email,
						':time'		=> (TIMESTAMP + 604800),
						':userID'	=> $USER['id']
					));
				}
			}
		}		
			
		
		if ($vacation == 1)
		{
			if(!$this->CheckVMode())
			{
				$this->printMessage($LNG['op_cant_activate_vacation_mode'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=settings'
				)));
			}elseif($USER['urlaubs_next_allowed'] > TIMESTAMP){
				$this->printMessage('Debes esperar 5 días para volver activar el Modo Vacaciones', true, array('game.php?page=settings', 2));
			}
			else
			{
				$sql = "UPDATE %%USERS%% SET urlaubs_modus = '1', urlaubs_until = :time WHERE id = :userID";
				$db->update($sql, array(
					':userID'	=> $USER['id'],
					':time'		=> (TIMESTAMP + Config::get()->vmode_min_time),
				));

				$sql = "UPDATE %%PLANETS%% SET energy_used = '0', energy = '0', metal_mine_porcent = '0', crystal_mine_porcent = '0', deuterium_sintetizer_porcent = '0', solar_plant_porcent = '0', fusion_plant_porcent = '0', solar_satelit_porcent = '0', metal_perhour = '0', crystal_perhour = '0', deuterium_perhour = '0' WHERE id_owner = :userID;";
				$db->update($sql, array(
					':userID'	=> $USER['id'],
				));
			}
		}

		if($delete == 1) {
			$sql	= "UPDATE %%USERS%% SET db_deaktjava = :timestamp WHERE id = :userID;";
			$db->update($sql, array(
				':userID'	=> $USER['id'],
				':timestamp'	=> TIMESTAMP
			));
		} else {
			$sql	= "UPDATE %%USERS%% SET db_deaktjava = 0 WHERE id = :userID;";
			$db->update($sql, array(
				':userID'	=> $USER['id'],
			));
		}

		$sql =  "UPDATE %%USERS%% SET
		dpath					= :theme,
		timezone				= :timezone,
		planet_sort				= :planetSort,
		planet_sort_order		= :planetOrder,
		spio_anz				= :spyCount,
		settings_fleetactions	= :fleetActions,
		settings_esp			= :galaxySpy,
		settings_wri			= :galaxyMessage,
		settings_bud			= :galaxyBuddyList,
		settings_mis			= :galaxyMissle,
		settings_blockPM		= :blockPM,
		authattack				= :adminProtection,
		lang					= :language,
		hof						= :queueMessages,
		spyMessagesMode			= :spyMessagesMode,
		verify_mail				= :factor2,
		foto					= :foto,
		gatheroptions			= :gatheroptions,
		gatherOptionsType		= :gatherOptionsType,
		sirena					= :sirena
		WHERE id = :userID;";
		$db->update($sql, array(
			':theme'			=> $theme,
			':timezone'			=> $timezone,
			':planetSort'		=> $planetSort,
			':planetOrder'		=> $planetOrder,
			':gatheroptions'	=> $gatheroptions,
			':spyCount'			=> $spycount,
			':fleetActions'		=> $fleetactions,
			':galaxySpy'		=> $galaxySpy,
			':galaxyMessage'	=> $galaxyMessage,
			':galaxyBuddyList'	=> $galaxyBuddyList,
			':galaxyMissle'		=> $galaxyMissle,
			':blockPM'			=> $blockPM,
			':adminProtection'	=> $adminprotection,
			':language'			=> $language,
			':queueMessages'	=> $queueMessages,
			':spyMessagesMode'	=> $spyMessagesMode,
			':factor2'			=> $factor2,
			':foto'	            => $foto,
			':gatherOptionsType'=> $gatherOptionsType,
			':sirena'			=> $sirena,
			':userID'			=> $USER['id']
		));
		
		$this->printMessage($LNG['op_options_changed'], array(array(
			'label'	=> $LNG['sys_forward'],
			'url'	=> 'game.php?page=settings'
		)));
	}
}
