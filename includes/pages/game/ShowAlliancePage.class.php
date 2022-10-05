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

class ShowAlliancePage extends AbstractGamePage
{
	public static $requireModule = MODULE_ALLIANCE;


	//fix by hirako time to change alliance  d*h*m*s
	//$config = Config::get(Universe::getEmulated());
	private $alliance_change_time=3*24*60*60;

	private $allianceData;
	private $ranks;
	private $rights;
	private $hasAlliance = false;
	private $hasApply = false;
	public $availableRanks	= array(
		'MEMBERLIST',
		'ONLINESTATE',
		'TRANSFER',
		'SEEAPPLY',
		'MANAGEAPPLY',
		'ROUNDMAIL',
		'ADMIN',
		'KICK',
		'DIPLOMATIC',
		'RANKS',
		'MANAGEUSERS',
		'EVENTS',
		'PLANETS',
		'BANK',
		'BANKISSUE',
	);

	function __construct()
	{
		global $USER;
		parent::__construct();
		$this->hasAlliance	= $USER['ally_id'] != 0;
		$this->hasApply		= $this->isApply();
		if($this->hasAlliance && !$this->hasApply) {
			$this->setAllianceData($USER['ally_id']);
		}
	}

	private function setAllianceData($allianceId)
	{
		global $USER;
		$db	= Database::get();

		$sql	= 'SELECT * FROM %%ALLIANCE%% WHERE id = :allianceId;';
		$this->allianceData = $db->selectSingle($sql, array(
			':allianceId'	=> $allianceId
		));

		if($USER['ally_id'] == $allianceId)
		{
			if ($this->allianceData['ally_owner'] == $USER['id']) {
				$this->rights	= array_combine($this->availableRanks, array_fill(0, count($this->availableRanks), true));
			} elseif($USER['ally_rank_id'] != 0) {
				$sql	= 'SELECT '.implode(', ', $this->availableRanks).' FROM %%ALLIANCE_RANK%% WHERE allianceId = :allianceId AND rankID = :ally_rank_id;';
				$this->rights = $db->selectSingle($sql, array(
					':allianceId'		=> $allianceId,
					':ally_rank_id'		=> $USER['ally_rank_id'],
				));
			}

			if(!isset($this->rights)) {
				$this->rights	= array_combine($this->availableRanks, array_fill(0, count($this->availableRanks), false));
			}

			if(isset($this->tplObj))
			{
				$this->assign(array(
					'rights'		=> $this->rights,
					'AllianceOwner'	=> $this->allianceData['ally_owner'] == $USER['id'],
				));
			}
		}
	}

	private function isApply()
	{
		global $USER;
		$db	= Database::get();
		$sql = "SELECT COUNT(*) as count FROM %%ALLIANCE_REQUEST%% WHERE userId = :userId;";
		return $db->selectSingle($sql, array(
			':userId'	=> $USER['id']
		), 'count');
	}


	function fraction(){	
		global $LNG, $USER;
		
		$authorised = array(1,2,3);
		$fraction	= HTTP::_GP('fraction', 0);
		if($this->allianceData['ally_fraction_id'] != 0){
			$fraction	= $this->allianceData['ally_fraction_id'];	
		}
		
		if($this->allianceData['ally_owner'] != $USER['id'] && $this->allianceData['ally_fraction_id'] == 0) {
			$this->redirectToHome();
		}elseif(!in_array($fraction, $authorised)){
			$this->printMessage($LNG['invalid_action'], true, array('game.php?page=alliance', 2));
		}
		
		$sql	= 'SELECT * FROM %%ALLIANCEFRACTIONS%% WHERE ally_fraction_id = :ally_fraction_id;';
		$FRACTIONS = Database::get()->selectSingle($sql, array(
		':ally_fraction_id'	=> $fraction
		));
		
		 $this->tplObj->assign_vars(array(
			'ally_fraction_armement'			=> $FRACTIONS['ally_fraction_armement']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_in_armement'			=> $FRACTIONS['ally_fraction_in_armement']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_in_armor'			=> $FRACTIONS['ally_fraction_in_armor']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_in_shields'			=> $FRACTIONS['ally_fraction_in_shields']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_fleet_speed'			=> $FRACTIONS['ally_fraction_fleet_speed']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_thief_resource'		=> $FRACTIONS['ally_fraction_thief_resource']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_combat_exp_pla'		=> $FRACTIONS['ally_fraction_combat_exp_pla']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_teleporter'			=> $FRACTIONS['ally_fraction_teleporter']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_def_debris'			=> $FRACTIONS['ally_fraction_def_debris']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_defense_restore'		=> $FRACTIONS['ally_fraction_defense_restore']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_armor'				=> $FRACTIONS['ally_fraction_armor']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_shields'				=> $FRACTIONS['ally_fraction_shields']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_fleet_capa'			=> $FRACTIONS['ally_fraction_fleet_capa']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_fuel'				=> $FRACTIONS['ally_fraction_fuel']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_upgrade_acti'		=> $FRACTIONS['ally_fraction_upgrade_acti']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_combat_exp_expe'		=> $FRACTIONS['ally_fraction_combat_exp_expe']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_ally_point'			=> $FRACTIONS['ally_fraction_ally_point']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_resource_prod'		=> $FRACTIONS['ally_fraction_resource_prod']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_energy_prod'			=> $FRACTIONS['ally_fraction_energy_prod']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_upgrade_find'		=> $FRACTIONS['ally_fraction_upgrade_find']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_resource_after_fight'=> $FRACTIONS['ally_fraction_resource_after_fight']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_peace_exp'			=> $FRACTIONS['ally_fraction_peace_exp']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_expe_speed'			=> $FRACTIONS['ally_fraction_expe_speed']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_fleet_price'			=> $FRACTIONS['ally_fraction_fleet_price']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_research_price'		=> $FRACTIONS['ally_fraction_research_price']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_defe_price'			=> $FRACTIONS['ally_fraction_defe_price']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_build_price'			=> $FRACTIONS['ally_fraction_build_price']*$this->allianceData['ally_fraction_level'],
			'ally_fraction_credits'				=> $this->allianceData['alliance_storage_stardust'],
			'ally_fraction_levels'				=> $this->allianceData['ally_fraction_level'],
			'ally_fraction_credits_insu'		=> $this->allianceData['ally_fraction_level']+1,
			'ally_fractions_4'					=> $this->allianceData['ally_fraction_id'] == 0 ? sprintf($LNG['ally_fractions_4'], 1) : sprintf($LNG['ally_fractions_4'], $this->allianceData['ally_fraction_level']+1),
			'ally_fractions_5'					=> $this->allianceData['ally_fraction_id'] == 0 ? sprintf($LNG['ally_fractions_5'], 1, 1) : sprintf($LNG['ally_fractions_5'], $this->allianceData['ally_fraction_level']+1, $this->allianceData['ally_fraction_level']+1 - $this->allianceData['alliance_storage_stardust']),
		));	 
		
			if($fraction == 1){
				$this->display('page.alliance.fraction1.tpl');
			}elseif($fraction == 2){
				$this->display('page.alliance.fraction2.tpl');
			}elseif($fraction == 3){
				$this->display('page.alliance.fraction3.tpl');
			}
	}

	function fractionup(){	
		global $LNG, $USER;

		$fraction	= $this->allianceData['ally_fraction_id'] == 0 ? HTTP::_GP('id', 0) : $this->allianceData['ally_fraction_id'];	
		
		if($this->allianceData['ally_fraction_level']+1 > 100){
			$this->printMessage("Max level reached", true, array('game.php?page=alliance&mode=fraction', 2));
		}elseif($this->allianceData['ally_fraction_level']+1 > $this->allianceData['alliance_storage_stardust']){
			$this->printMessage("Not enough stardust in the alliance bank", true, array('game.php?page=alliance&mode=fraction', 2));
		}elseif($this->allianceData['ally_fraction_level'] == 0 && $this->allianceData['ally_owner'] != $USER['id']){
			$this->printMessage("The leader have to select a fraction first", true, array('game.php?page=alliance&mode=fraction', 2));
		}else{			
			if($this->allianceData['ally_fraction_level'] == 0){
				$sql	= 'UPDATE %%ALLIANCE%% SET ally_fraction_id = :ally_fraction_id WHERE id = :id;';
				Database::get()->update($sql, array(
					':ally_fraction_id'	=> $fraction,
					':id'				=> $this->allianceData['id']
				));
			}
			$sql	= 'UPDATE %%ALLIANCE%% SET ally_fraction_level = ally_fraction_level + 1, alliance_storage_stardust = alliance_storage_stardust - :alliance_storage_stardust WHERE id = :id;';
			Database::get()->update($sql, array(
				':alliance_storage_stardust'	=> $this->allianceData['ally_fraction_level']+1,
				':id'							=> $this->allianceData['id']
			));
			
			$this->printMessage("Fraction raised 1 level", true, array('game.php?page=alliance&mode=fraction', 2));
		}
	}


	function adminPlanets()
	{
		global $USER, $LNG, $resource;
		
		if(!$this->rights['PLANETS']) {
			$this->redirectToHome();
		}

		$i = 0;
		
		$sql	= 'SELECT * FROM %%PLANETS%% WHERE isAlliancePlanet = :isAlliancePlanet AND destruyed = 0;';
		$getAlliance = database::get()->select($sql, array(
			':isAlliancePlanet'		=> $this->allianceData['id'],
		));
		
		$priceMetal     = 15 + (15 * count($getAlliance));
		$priceCrystal   = 7 + (7 * count($getAlliance));
		$priceDeuterium = 3 + (3 * count($getAlliance));
		$priceStellarDu = 0 + (10 * count($getAlliance));
		
		$managePlanets = array();
		
		foreach($getAlliance as $allyPlanet){
			$i++;
			$managePlanets[$allyPlanet['id']] = array(
				'planetName'	=> $allyPlanet['name'],
				'planetGalaxy'	=> $allyPlanet['galaxy'],
				'planetSystem'	=> $allyPlanet['system'],
				'planetPlanet'	=> $allyPlanet['planet'],
				'planetRanking'	=> $i,
			);
		}
		
		$this->assign(array(
			'planetRanking'	=> $i,
			'managePlanets'	=> $managePlanets,
			'priceMetal'	=> $priceMetal,
			'priceCrystal'	=> $priceCrystal,
			'priceDeuterium'=> $priceDeuterium,
			'priceStellarDu'=> $priceStellarDu,
			'playerStarDust'=> $this->allianceData['alliance_storage_stardust'],
		));

		$this->display('page.alliance.planets.tpl');
	}
	
	function adminPlanetsSend()
	{
		global $USER, $LNG, $resource;
		
		if(!$this->rights['PLANETS']) {
			$this->redirectToHome();
		}
		
		$sql	= 'SELECT COUNT(*) as count FROM %%PLANETS%% WHERE isAlliancePlanet = :isAlliancePlanet AND destruyed = 0;';
		$getAlliance = database::get()->select($sql, array(
			':isAlliancePlanet'		=> $this->allianceData['id'],
		));
		
		if($getAlliance['count'] >= 3){
			$this->printMessage('Each alliance can have at maximum 3 alliance planets.', true, array('game.php?page=alliance&mode=admin&action=planets', 2));
		}
		
		$priceMetal     = 15 + (15 * $getAlliance['count']);
		$priceCrystal   = 7 + (7 * $getAlliance['count']);
		$priceDeuterium = 3 + (3 * $getAlliance['count']);
		$priceStellarDu = 0 + (10 * $getAlliance['count']);
		
		if($this->allianceData['alliance_storage_metal'] < $priceMetal || $this->allianceData['alliance_storage_crystal'] < $priceCrystal || $this->allianceData['alliance_storage_deuterium'] < $priceDeuterium || $this->allianceData['alliance_storage_stardust'] < $priceStellarDu){
			$this->printMessage('Insuficient resources.', true, array('game.php?page=alliance&mode=admin&action=planets', 2));
		}else{
			$shortcut_galaxy = HTTP::_GP('shortcut_galaxy',0);		
			$shortcut_system = HTTP::_GP('shortcut_system',0);	
			$shortcut_planet = HTTP::_GP('shortcut_planet',0);	
			
			$checkPosition	= PlayerUtil::checkPosition(Universe::current(), $shortcut_galaxy, $shortcut_system, $shortcut_planet);
			$isPositionFree	= PlayerUtil::isPositionFree(Universe::current(), $shortcut_galaxy, $shortcut_system, $shortcut_planet);
			
			if(empty($shortcut_galaxy) || empty($shortcut_system) || empty($shortcut_planet)){
				$this->printMessage('You need to enter the coordinates where you want to create the alliance planet', true, array('game.php?page=alliance&mode=admin&action=planets', 2));
			}else{
				if(!$checkPosition){
					$this->printMessage('You are not allowed to create the alliance planet on these coordinates.', true, array('game.php?page=alliance&mode=admin&action=planets', 2));
				}elseif(!$isPositionFree){
					$this->printMessage('There is already a planet on the selected coordinates.', true, array('game.php?page=alliance&mode=admin&action=planets', 2));
				}else{				
					$sql	= "UPDATE %%ALLIANCE%% SET alliance_storage_metal = alliance_storage_metal - :alliance_storage_metal, alliance_storage_crystal = alliance_storage_crystal - :alliance_storage_crystal, alliance_storage_deuterium = alliance_storage_deuterium - :alliance_storage_deuterium, alliance_storage_stardust = alliance_storage_stardust - :alliance_storage_stardust WHERE id = :allianceId;";
					database::get()->update($sql, array(
						':alliance_storage_metal'		=> $priceMetal,
						':alliance_storage_crystal'		=> $priceCrystal,
						':alliance_storage_deuterium'	=> $priceDeuterium,
						':alliance_storage_stardust'	=> $priceStellarDu,
						':allianceId'					=> $this->allianceData['id']
					));
					
					PlayerUtil::createAlliancePlanet($shortcut_galaxy, $shortcut_system, $shortcut_planet, Universe::current(), $this->allianceData['ally_owner'], $LNG['fcp_colony'], 0, $this->allianceData['id']);
					
					$this->printMessage('The alliance planet is created.', true, array('game.php?page=alliance&mode=admin&action=planets', 2));
				}
			}
		}
		
		$this->printMessage('An error happened. Please try again', true, array('game.php?page=alliance&mode=admin&action=planets', 2));
	}


	//Alliance Storage
	function storage()
	{
		global $USER, $LNG;
		
		if(!$this->rights['BANK']) {
			$this->redirectToHome();
		}
		
		$this->tplObj->loadscript('jquery.countdown.js');
		$this->assign(array(
			'stellar_ores'					=> $USER['stardust'],
			'alliance_storage_metal'		=> $this->allianceData['alliance_storage_metal'],
			'alliance_storage_crystal'		=> $this->allianceData['alliance_storage_crystal'],
			'alliance_storage_deuterium'	=> $this->allianceData['alliance_storage_deuterium'],
			'alliance_storage_stardust'		=> $this->allianceData['alliance_storage_stardust'],
			'deposit_active' 				=> ((!empty($USER['alliance_storage_deposit']) && $USER['alliance_storage_deposit'] > TIMESTAMP) ? ($USER['alliance_storage_deposit'] - TIMESTAMP) : 0),
			'widraw_active' 				=> ((!empty($USER['alliance_storage_widraw']) && $USER['alliance_storage_widraw'] > TIMESTAMP) ? ($USER['alliance_storage_widraw'] - TIMESTAMP) : 0),
		));

		$this->display('page.alliance.storage.tpl');
	}


	function put()
	{
		global $USER, $LNG, $resource;
				
		if(!$this->rights['BANK']) {
			$this->redirectToHome();
		}

		$cost = 0;
		for($i = 0; $i < $USER[$resource[125]]; $i++)
		{
			$cost 	= 2000 * pow(2,$USER[$resource[125]] + $i);
		}
		
		$premium_bank = 1;
		if($USER['prem_bank_ally'] > 0 && $USER['prem_bank_ally_days'] > TIMESTAMP){
			$premium_bank = $USER['prem_bank_ally'];
		}
		
		$this->tplObj->loadscript('trader1.js'); 
		$this->assign(array(
			'cost' => $cost * $premium_bank,	
		));

		$this->display('page.alliance.put.tpl');
	}
	
	function putStardustAll()
	{
		global $USER, $LNG, $resource, $PLANET;
		
		if(!$this->rights['BANK']) {
			$this->redirectToHome();
		}
		
		if($USER['stardust'] > 0){
			$account_before = array(
				'stardust'				=> $USER['stardust'],
				'stellar_ore_alliance'	=> $this->allianceData['alliance_storage_stardust'],
				'ally_name'				=> $this->allianceData['ally_name'],
			);
			$sql	= "UPDATE %%ALLIANCE%% SET  alliance_storage_stardust = alliance_storage_stardust + :alliance_storage_stardust WHERE id = :allianceId;";
			database::get()->update($sql, array(
				':alliance_storage_stardust'	=> $USER['stardust'],
				':allianceId'	=> $this->allianceData['id']
			));
			$sql	= "UPDATE %%USERS%% SET stardust = stardust - :stardust WHERE id = :userId;";
			database::get()->update($sql, array(
				':stardust'     => $USER['stardust'],
				':userId'       => $USER['id']
			));
			
			$sql	= 'SELECT stardust FROM %%USERS%% WHERE id = :userId;';
			$getUser = database::get()->selectSingle($sql, array(
				':userId'		=> $USER['id'],
			));
			
			$sql	= 'SELECT alliance_storage_stardust FROM %%ALLIANCE%% WHERE id = :id;';
			$getAlliance = database::get()->selectSingle($sql, array(
				':id'		=> $this->allianceData['id'],
			));
			
			$account_after = array(
				'stardust'			    => $getUser['stardust'],
				'stellar_ore_alliance'	=> $getAlliance['alliance_storage_stardust'],
				'ally_name'				=> $this->allianceData['ally_name'],
			);
			
			$LOG = new Logcheck(12);
			$LOG->username = empty($USER['customNick']) ? $USER['username'] : $USER['customNick'];
			$LOG->pageLog = "page=alliance [Add Stellar All]";
			$LOG->old = $account_before;
			$LOG->new = $account_after;
			$LOG->save();
			
			$this->printMessage('Stardust added', true, array('game.php?page=alliance&mode=storage', 2));
		}else{
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/jc/game.php?page=alliance&mode=storage');
		}
		
	}
	
	function putStardust()
	{
		global $USER, $LNG, $resource, $PLANET;
		
		if(!$this->rights['BANK']) {
			$this->redirectToHome();
		}
		
		if($USER['stardust'] > 0){
			$account_before = array(
				'stardust'				=> $USER['stardust'],
				'stellar_ore_alliance'	=> $this->allianceData['alliance_storage_stardust'],
				'ally_name'				=> $this->allianceData['ally_name'],
			);
			$sql	= "UPDATE %%ALLIANCE%% SET  alliance_storage_stardust = alliance_storage_stardust + :alliance_storage_stardust WHERE id = :allianceId;";
			database::get()->update($sql, array(
				':alliance_storage_stardust'	=> 1,
				':allianceId'	=> $this->allianceData['id']
			));
			$sql	= "UPDATE %%USERS%% SET stardust = stardust - 1 WHERE id = :userId;";
			database::get()->update($sql, array(
				':userId'       => $USER['id']
			));
			
			$sql	= 'SELECT stardust FROM %%USERS%% WHERE id = :userId;';
			$getUser = database::get()->selectSingle($sql, array(
				':userId'		=> $USER['id'],
			));
			
			$sql	= 'SELECT alliance_storage_stardust FROM %%ALLIANCE%% WHERE id = :id;';
			$getAlliance = database::get()->selectSingle($sql, array(
				':id'		=> $this->allianceData['id'],
			));
			
			$account_after = array(
				'stardust'			    => $getUser['stardust'],
				'stellar_ore_alliance'	=> $getAlliance['alliance_storage_stardust'],
				'ally_name'				=> $this->allianceData['ally_name'],
			);
			
			$LOG = new Logcheck(12);
			$LOG->username = empty($USER['customNick']) ? $USER['username'] : $USER['customNick'];
			$LOG->pageLog = "page=alliance [Add Stellar Ore]";
			$LOG->old = $account_before;
			$LOG->new = $account_after;
			$LOG->save();
			
			$this->printMessage('Stardust added', true, array('game.php?page=alliance&mode=storage', 2));
		}else{
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/jc/game.php?page=alliance&mode=storage');
		}
		
	}
	
	function isStardust()
	{
		global $USER, $LNG, $resource, $PLANET;
		
		if (!$this->rights['BANK']) {
			$this->redirectToHome();
		}
		
		if($this->allianceData['alliance_storage_stardust'] > 0){
			
			$account_before = array(
				'stardust'				=> $USER['stardust'],
				'stellar_ore_alliance'	=> $this->allianceData['alliance_storage_stardust'],
				'ally_name'				=> $this->allianceData['ally_name'],
			);
			$sql	= "UPDATE %%ALLIANCE%% SET  alliance_storage_stardust = alliance_storage_stardust - 1 WHERE id = :allianceId;";
			database::get()->update($sql, array(
				':allianceId'	=> $this->allianceData['id']
			));
			$sql	= "UPDATE %%USERS%% SET stardust = stardust + 1 WHERE id = :userId;";
			database::get()->update($sql, array(
				':userId'       => $USER['id']
			));
			
			$sql	= 'SELECT stardust FROM %%USERS%% WHERE id = :userId;';
			$getUser = database::get()->selectSingle($sql, array(
				':userId'		=> $USER['id'],
			));
			
			$sql	= 'SELECT alliance_storage_stardust FROM %%ALLIANCE%% WHERE id = :id;';
			$getAlliance = database::get()->selectSingle($sql, array(
				':id'		=> $this->allianceData['id'],
			));
			
			$account_after = array(
				'stardust'				=> $getUser['stardust'],
				'stellar_ore_alliance'	=> $getAlliance['alliance_storage_stardust'],
				'ally_name'				=> $this->allianceData['ally_name'],
			);
			
			$LOG = new Logcheck(12);
			$LOG->username = empty($USER['customNick']) ? $USER['username'] : $USER['customNick'];
			$LOG->pageLog = "page=alliance [Remove Stellar Ore]";
			$LOG->old = $account_before;
			$LOG->new = $account_after;
			$LOG->save();
			$this->printMessage('Stellar ore obtained', true, array('game.php?page=alliance&mode=storage', 2));
		}else{
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/jc/game.php?page=alliance&mode=storage');
		}
		
		
	}
	
	function putsend()
	{
		global $USER, $LNG, $resource, $PLANET;
		
		//if($USER['id'] != 1)
			//$this->printMessage('You can only widraw resource at this moment.', true, array('game.php?page=alliance', 2));
		
		if(!$this->rights['BANK']) {
			$this->redirectToHome();
		}
		
		$metal = HTTP::_GP('resource901',0);		
        $crystal = HTTP::_GP('resource902',0);	
        $deuterium = HTTP::_GP('resource903',0);	
		
		$account_before = array(
			'metal'							=> $PLANET['metal'],
			'crystal'						=> $PLANET['crystal'],
			'deuterium'						=> $PLANET['deuterium'],
			'alliance_storage_metal'		=> $this->allianceData['alliance_storage_metal'],
			'alliance_storage_crystal'		=> $this->allianceData['alliance_storage_crystal'],
			'alliance_storage_deuterium'	=> $this->allianceData['alliance_storage_deuterium'],
			'ally_name'						=> $this->allianceData['ally_name'],
			'Input_Metal'					=> $metal,
			'Input_Crystal'					=> $crystal,
			'Input_Deuterium'				=> $deuterium,
		);
		
		$cost = 0;
		for($i = 0; $i < $USER[$resource[125]]; $i++)
		{
			$cost 	= 2000 * pow(2,$USER[$resource[125]] + $i);
		}
		
		$premium_bank = 1;
		if($USER['prem_bank_ally'] > 0 && $USER['prem_bank_ally_days'] > TIMESTAMP){
			$premium_bank = $USER['prem_bank_ally'];
		}
		if ($USER[$resource[125]] == 0) {
			$this->printMessage("Debes investigar la Tecnología Brotherhood", true, array('game.php?page=alliance&mode=storage', 2));
			die();
		}elseif($metal < 0|| $crystal < 0  || $deuterium < 0){
			$this->printMessage($LNG['moon_hack'], true, array('game.php?page=alliance&mode=storage', 2));
			die();
		//}elseif($metal == 0|| $crystal == 0  || $deuterium == 0){
		//	$this->printMessage("Debe ingresar recursos", true, array('game.php?page=alliance&mode=storage', 2));
		//	die();
        }elseif($PLANET['metal'] < $metal || $PLANET['crystal'] < $crystal  || $PLANET['deuterium'] < $deuterium){
			$this->printMessage("You dont have enough resources", true, array('game.php?page=alliance&mode=storage', 2));
			die();
        }elseif($metal + $crystal + $deuterium > $cost * $premium_bank){
			$this->printMessage("Maximum values are not respected", true, array('game.php?page=alliance&mode=storage', 2));
			die();
        }elseif($USER['alliance_storage_deposit'] > TIMESTAMP){
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/jc/game.php?page=alliance&mode=storage');
			die();
        }else{
			$db	= Database::get();
			$PLANET['metal'] -= $metal;
			$PLANET['crystal'] -= $crystal;
			$PLANET['deuterium'] -= $deuterium;
			
			$sql	= "UPDATE %%ALLIANCE%% SET alliance_storage_metal = alliance_storage_metal + :alliance_storage_metal, alliance_storage_crystal = alliance_storage_crystal + :alliance_storage_crystal, alliance_storage_deuterium = alliance_storage_deuterium + :alliance_storage_deuterium WHERE id = :allianceId;";
			$db->update($sql, array(
				':alliance_storage_metal'	=> $metal,
				':alliance_storage_crystal'	=> $crystal,
				':alliance_storage_deuterium'	=> $deuterium,
				':allianceId'	=> $this->allianceData['id']
			));
			
			$sql	= "UPDATE %%USERS%% SET alliance_storage_deposit = :alliance_storage_deposit WHERE id = :userId;";
			$db->update($sql, array(
				':alliance_storage_deposit'	=> TIMESTAMP + (12 * 60 * 60),
				':userId'	=> $USER['id']
			));
			
			$sql	= "UPDATE %%PLANETS%% SET  metal = metal - :metal, crystal = crystal - :crystal, deuterium = deuterium - :deuterium WHERE id = :planetId;";
			$db->update($sql, array(
				':metal'	=> $metal,
				':crystal'	=> $crystal,
				':deuterium'	=> $deuterium,
				':planetId'	=> $PLANET['id']
			));
			
			$sql	= "SELECT * FROM %%STORAGEPERS%% WHERE userId = :userId;";
			$isLogPresent = database::get()->selectSingle($sql, array(
				':userId'	=> $USER['id']
			));
			
			if(empty($isLogPresent)){
				$sql = "INSERT INTO %%STORAGEPERS%% SET userId = :userId, metal = :metal, crystal = :crystal, deuterium = :deuterium;";
				database::get()->insert($sql, array(
					':userId'			=> $USER['id'],
					':metal'			=> $metal,
					':crystal'			=> $crystal,
					':deuterium'		=> $deuterium,
				));
			}else{
				$sql = "UPDATE %%STORAGEPERS%% SET metal = metal + :metal, crystal = crystal + :crystal, deuterium = deuterium + :deuterium WHERE userId = :userId;";
				database::get()->update($sql, array(
					':metal'			=> $metal,
					':crystal'			=> $crystal,
					':deuterium'		=> $deuterium,
					':userId'			=> $USER['id'],
				));
			}
		
			$sql = "INSERT INTO %%STORAGELOGS%% SET allyID = :allyID, userID = :userID, planetid = :planetid, metal = :metal, crystal = :crystal, deuterium = :deuterium, time = :time, type = 1;";
			$db->insert($sql, array(
				':allyID'			=> $this->allianceData['id'],
				':userID'			=> $USER['id'],
				':planetid'			=> $PLANET['id'],
				':metal'			=> $metal,
				':crystal'			=> $crystal,
				':deuterium'		=> $deuterium,
				':time'				=> TIMESTAMP,
			));
			
			$sql	= 'SELECT metal, crystal, deuterium FROM %%PLANETS%% WHERE id = :userId;';
			$getPlanet = database::get()->selectSingle($sql, array(
				':userId'		=> $PLANET['id'],
			));
			
			$sql	= 'SELECT alliance_storage_metal, alliance_storage_crystal, alliance_storage_deuterium FROM %%ALLIANCE%% WHERE id = :id;';
			$getAlliance = database::get()->selectSingle($sql, array(
				':id'		=> $this->allianceData['id'],
			));
			
			$account_after = array(
				'metal'							=> $getPlanet['metal'],
				'crystal'						=> $getPlanet['crystal'],
				'deuterium'						=> $getPlanet['deuterium'],
				'alliance_storage_metal'		=> $getAlliance['alliance_storage_metal'],
				'alliance_storage_crystal'		=> $getAlliance['alliance_storage_crystal'],
				'alliance_storage_deuterium'	=> $getAlliance['alliance_storage_deuterium'],
				'ally_name'						=> $this->allianceData['ally_name'],
				'Input_Metal'					=> $metal,
				'Input_Crystal'					=> $crystal,
				'Input_Deuterium'				=> $deuterium,
			);
			
			$LOG = new Logcheck(12);
			$LOG->username = empty($USER['customNick']) ? $USER['username'] : $USER['customNick'];
			$LOG->pageLog = "page=alliance [Add resources]";
			$LOG->old = $account_before;
			$LOG->new = $account_after;
			$LOG->save();
					
			$this->printMessage("Ressource are put in the vault", true, array('game.php?page=alliance&mode=storage', 2));	
		}
	}
	
	function vlyat()
	{
		global $USER, $LNG, $resource;
		
		if (!$this->rights['BANK']) {
			$this->redirectToHome();
		}
		
		$cost = 0;
		for($i = 0; $i < $USER[$resource[125]]; $i++)
		{
			$cost 	= 2000 * pow(2,$USER[$resource[125]] + $i);
		}
		$premium_bank = 1;
		if($USER['prem_bank_ally'] > 0 && $USER['prem_bank_ally_days'] > TIMESTAMP){
			$premium_bank = $USER['prem_bank_ally'];
		}
		
		$sql	= "SELECT * FROM %%STORAGEPERS%% WHERE userId = :userId;";
		$isLogPresent = database::get()->selectSingle($sql, array(
			':userId'	=> $USER['id']
		));
			
		$this->tplObj->loadscript('trader.js'); 
		$this->assign(array(
			'cost' => $cost * $premium_bank,	
			'metalDep' => empty($isLogPresent) ? 0 : $isLogPresent['metal'],	
			'crystalDep' => empty($isLogPresent) ? 0 : $isLogPresent['crystal'],	
			'deuteDep' => empty($isLogPresent) ? 0 : $isLogPresent['deuterium'],	
		));

		$this->display('page.alliance.vlyat.tpl');
	}
	
	function vlyatsend()
	{
		global $USER, $LNG, $resource, $PLANET;

		if (!$this->rights['BANK']) {
			$this->redirectToHome();
		}
		
		$metal = HTTP::_GP('resource901',0);		
        $crystal = HTTP::_GP('resource902',0);	
        $deuterium = HTTP::_GP('resource903',0);	
		
		$account_before = array(
			'metal'							=> $PLANET['metal'],
			'crystal'						=> $PLANET['crystal'],
			'deuterium'						=> $PLANET['deuterium'],
			'alliance_storage_metal'		=> $this->allianceData['alliance_storage_metal'],
			'alliance_storage_crystal'		=> $this->allianceData['alliance_storage_crystal'],
			'alliance_storage_deuterium'	=> $this->allianceData['alliance_storage_deuterium'],
			'ally_name'						=> $this->allianceData['ally_name'],
			'Input_Metal'					=> $metal,
			'Input_Crystal'					=> $crystal,
			'Input_Deuterium'				=> $deuterium,
		);
		
		$cost = 0;
		for($i = 0; $i < $USER[$resource[125]]; $i++)
		{
			$cost 	= 2000 * pow(2,$USER[$resource[125]] + $i);

		}
		
		$premium_bank = 1;
		if($USER['prem_bank_ally'] > 0 && $USER['prem_bank_ally_days'] > TIMESTAMP){
			$premium_bank = $USER['prem_bank_ally'];
		}
		
		$sql	= "SELECT * FROM %%STORAGEPERS%% WHERE userId = :userId;";
		$isLogPresent = database::get()->selectSingle($sql, array(
			':userId'	=> $USER['id']
		));
		
		if(empty($isLogPresent))
			$isLogPresent = array("metal" => 0, "crystal" => 0, "deuterium" => 0);
		
		if ($USER[$resource[125]] == 0) {
			$this->printMessage("Debes investigar la Tecnología Brotherhood", true, array('game.php?page=alliance&mode=storage', 2));
			die();
		}elseif($metal < 0 || $crystal < 0  || $deuterium < 0){
			$this->printMessage($LNG['moon_hack'], true, array('game.php?page=alliance&mode=vlyat', 2));
			die();
		}elseif($metal == 0 || $crystal == 0  || $deuterium == 0){
			$this->printMessage("Debe ingresar recursos", true, array('game.php?page=alliance&mode=vlyat', 2));
			die();
        }elseif($metal + $crystal + $deuterium > $cost * $premium_bank){
			$this->printMessage("Maximum values are not respected", true, array('game.php?page=alliance&mode=vlyat', 2));
			die();
        }elseif($isLogPresent['metal'] < $metal || $isLogPresent['crystal'] < $crystal  || $isLogPresent['deuterium'] < $deuterium){
			$this->printMessage("You are trying to widraw more resource then you have deposit in the bank !", true, array('game.php?page=alliance&mode=vlyat', 2));
			die();
        }elseif($this->allianceData['alliance_storage_metal'] < $metal || $this->allianceData['alliance_storage_crystal'] < $crystal  || $this->allianceData['alliance_storage_deuterium'] < $deuterium){
			$this->printMessage("There is not enough resource in the bank", true, array('game.php?page=alliance&mode=vlyat', 2));
			die();
        }elseif($USER['alliance_storage_widraw'] > TIMESTAMP){
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/jc/game.php?page=alliance');
			die();
        }else{
			$db	= Database::get();
			$PLANET['metal'] += $metal;
			$PLANET['crystal'] += $crystal;
			$PLANET['deuterium'] += $deuterium;
			
			$sql	= "UPDATE %%ALLIANCE%% SET alliance_storage_metal = alliance_storage_metal - :alliance_storage_metal, alliance_storage_crystal = alliance_storage_crystal - :alliance_storage_crystal, alliance_storage_deuterium = alliance_storage_deuterium - :alliance_storage_deuterium WHERE id = :allianceId;";
			$db->update($sql, array(
				':alliance_storage_metal'	=> $metal,
				':alliance_storage_crystal'	=> $crystal,
				':alliance_storage_deuterium'	=> $deuterium,
				':allianceId'	=> $this->allianceData['id']
			));
		
			$sql	= "UPDATE %%USERS%% SET alliance_storage_widraw = :alliance_storage_widraw WHERE id = :userId;";
			$db->update($sql, array(
				':alliance_storage_widraw'	=> TIMESTAMP + (12 * 60 * 60),
				':userId'	=> $USER['id']
			));
		
			$sql	= "UPDATE %%PLANETS%% SET  metal = metal + :metal, crystal = crystal + :crystal, deuterium = deuterium + :deuterium WHERE id = :planetId;";
			$db->update($sql, array(
				':metal'	=> $metal,
				':crystal'	=> $crystal,
				':deuterium'	=> $deuterium,
				':planetId'	=> $PLANET['id']
			));
			
			$sql = "INSERT INTO %%STORAGELOGS%% SET allyID = :allyID, userID = :userID, planetid = :planetid, metal = :metal, crystal = :crystal, deuterium = :deuterium, time = :time, type = :type;";

			$db->insert($sql, array(
				':allyID'		=> $this->allianceData['id'],
				':userID'		=> $USER['id'],
				':planetid'		=> $PLANET['id'],
				':metal'		=> $metal,
				':crystal'		=> $crystal,
				':deuterium'	=> $deuterium,
				':time'			=> TIMESTAMP,
				':type'			=> 2
			));
			
			$sql	= 'SELECT metal, crystal, deuterium FROM %%PLANETS%% WHERE id = :userId;';
			$getPlanet = database::get()->selectSingle($sql, array(
				':userId'		=> $PLANET['id'],
			));
			
			$sql	= 'SELECT alliance_storage_metal, alliance_storage_crystal, alliance_storage_deuterium FROM %%ALLIANCE%% WHERE id = :id;';
			$getAlliance = database::get()->selectSingle($sql, array(
				':id'		=> $this->allianceData['id'],
			));
			
			$account_after = array(
				'metal'							=> $getPlanet['metal'],
				'crystal'						=> $getPlanet['crystal'],
				'deuterium'						=> $getPlanet['deuterium'],
				'alliance_storage_metal'		=> $getAlliance['alliance_storage_metal'],
				'alliance_storage_crystal'		=> $getAlliance['alliance_storage_crystal'],
				'alliance_storage_deuterium'	=> $getAlliance['alliance_storage_deuterium'],
				'ally_name'						=> $this->allianceData['ally_name'],
				'Input_Metal'					=> $metal,
				'Input_Crystal'					=> $crystal,
				'Input_Deuterium'				=> $deuterium,
			);
			
			$LOG = new Logcheck(12);
			$LOG->username = empty($USER['customNick']) ? $USER['username'] : $USER['customNick'];
			$LOG->pageLog = "page=alliance [Widraw resources]";
			$LOG->old = $account_before;
			$LOG->new = $account_after;
			$LOG->save();
					
			$this->printMessage("You received the requested resources", true, array('game.php?page=alliance&mode=storage', 2));
		}
	}
	
	function issue()
	{
		global $USER, $LNG;
		
		if (!$this->rights['BANKISSUE']) {
			$this->redirectToHome();
		}
		
		$Userlist	= "";
		$db	= Database::get();
		$sql	= "SELECT id_planet, username FROM %%USERS%% WHERE ally_id = :allianceId ORDER BY `username` ASC;";
		$allianceResult = $db->select($sql, array(
			':allianceId'	=> $this->allianceData['id']
		));
		
		$sql	= "SELECT id, name, galaxy, system, planet FROM %%PLANETS%% WHERE isAlliancePlanet = :isAlliancePlanet ORDER BY `name` ASC;";
		$alliancePlanets = $db->select($sql, array(
			':isAlliancePlanet'	=> $this->allianceData['id']
		));
		
		foreach($alliancePlanets as $searchRow){
			$Userlist	.= "<option value=\"".$searchRow['id']."\">".$searchRow['name']." [".$searchRow['galaxy'].":".$searchRow['system'].":".$searchRow['planet']."]</option>";	
		}
		
		/* foreach($allianceResult as $searchRow){
			$useNameA = empty($searchRow['customNick']) ? $searchRow['username'] : $searchRow['customNick'];
			$Userlist	.= "<option value=\"".$searchRow['id_planet']."\">".$useNameA."</option>";	
		} */
	
		$this->tplObj->loadscript('trader.js');
		$this->tplObj->loadscript('filterlist.js');
		$this->tplObj->assign_vars(array(
			'Userlist'			=> $Userlist,
			'alliance_storage_metal'			=> $this->allianceData['alliance_storage_metal'],
			'alliance_storage_crystal'			=> $this->allianceData['alliance_storage_crystal'],
			'alliance_storage_deuterium'			=> $this->allianceData['alliance_storage_deuterium'],
		));
		
		$this->display('page.alliance.issue.tpl');
	}
	
	function logStorageStardust()
	{
		global $USER, $LNG;
		if (!$this->rights['BANK']) {
			$this->redirectToHome();
		}
		
		$Userlist	= array();
		$db	= Database::get();
		$sql	= "SELECT * FROM `uni1_storages_logs_star` WHERE allyID = :allianceId;";
		$allianceResult = $db->select($sql, array(
			':allianceId'	=> $this->allianceData['id']
		));
		
		foreach($allianceResult as $searchRow){
			$sql	= "SELECT * FROM `uni1_storages_logs_star` WHERE allyID = :allyId AND userID = :userID AND time > :time AND type = :type;";
			$allianceResult = $db->select($sql, array(
				':userID'	=> $searchRow['userID'],
				':time'		=> TIMESTAMP - (31*24*3600),
				':allyId'	=> $this->allianceData['id'],
				':type'		=> 'Deposit'
			));	
			$sql	= "SELECT * FROM `uni1_storages_logs_star` WHERE allyID = :allyId AND userID = :userID AND time > :time AND type = :type;";
			$allianceResultBis = $db->select($sql, array(
				':userID'	=> $searchRow['userID'],
				':time'		=> TIMESTAMP - (7*24*3600),
				':allyId'	=> $this->allianceData['id'],
				':type'		=> 'Widraw'
			));	
			$Userlist[$searchRow['userID']]	= array(
				'deposit'		=> count($allianceResult),
				'widraw'		=> count($allianceResultBis),
				'nameP'			=> getUsername($searchRow['userID']),	
			);
		}
		

		$this->assign(array(
		'Userlist' => $Userlist,
		));

		$this->display('page.logstorage.stardust.tpl');
	}
	
	function logstorage()
	{
		global $USER, $LNG;
		if (!$this->rights['BANK']) {
			$this->redirectToHome();
		}
		
		$Userlist	= array();
		$time = HTTP::_GP('time',0);	
		$db	= Database::get();
		$sql	= "SELECT * FROM %%STORAGELOGS%% WHERE allyID = :allianceId;";
		$allianceResult = $db->select($sql, array(
			':allianceId'	=> $this->allianceData['id']
		));
		
		foreach($allianceResult as $searchRow){
			if($time == 1){
				$sql	= "SELECT SUM(metal) as metal, SUM(crystal) as crystal, SUM(deuterium) as deuterium, time, userID FROM %%STORAGELOGS%% WHERE allyID = :allyId AND userID = :userID AND time > :time AND type = :type AND isdeleted = 0;";
				$allianceResult = $db->selectSingle($sql, array(
					':userID'	=> $searchRow['userID'],
					':time'		=> TIMESTAMP - (31*24*3600),
					':allyId'	=> $this->allianceData['id'],
					':type'		=> 1
				));	
				$sql	= "SELECT SUM(metal) as metal, SUM(crystal) as crystal, SUM(deuterium) as deuterium, time, userID FROM %%STORAGELOGS%% WHERE allyID = :allyId AND userID = :userID AND time > :time AND type = :type AND isdeleted = 0;";
				$allianceResultBis = $db->selectSingle($sql, array(
					':userID'	=> $searchRow['userID'],
					':time'		=> TIMESTAMP - (31*24*3600),
					':allyId'	=> $this->allianceData['id'],
					':type'		=> 2
				));	
			}elseif($time == 2){
				$sql	= "SELECT SUM(metal) as metal, SUM(crystal) as crystal, SUM(deuterium) as deuterium, time, userID FROM %%STORAGELOGS%% WHERE allyID = :allyId AND userID = :userID AND time > :time AND type = :type AND isdeleted = 0;";
				$allianceResult = $db->selectSingle($sql, array(
					':userID'	=> $searchRow['userID'],
					':time'		=> TIMESTAMP - (7*24*3600),
					':allyId'	=> $this->allianceData['id'],
					':type'		=> 1
				));	
				$sql	= "SELECT SUM(metal) as metal, SUM(crystal) as crystal, SUM(deuterium) as deuterium, time, userID FROM %%STORAGELOGS%% WHERE allyID = :allyId AND userID = :userID AND time > :time AND type = :type AND isdeleted = 0;";
				$allianceResultBis = $db->selectSingle($sql, array(
					':userID'	=> $searchRow['userID'],
					':time'		=> TIMESTAMP - (7*24*3600),
					':allyId'	=> $this->allianceData['id'],
					':type'		=> 2
				));	
			}elseif($time == 3){
				$sql	= "SELECT SUM(metal) as metal, SUM(crystal) as crystal, SUM(deuterium) as deuterium, time, userID FROM %%STORAGELOGS%% WHERE allyID = :allyId AND userID = :userID AND time > :time AND type = :type AND isdeleted = 0;";
				$allianceResult = $db->selectSingle($sql, array(
					':userID'	=> $searchRow['userID'],
					':time'		=> TIMESTAMP - (24*3600),
					':allyId'	=> $this->allianceData['id'],
					':type'		=> 1
				));
				$sql	= "SELECT SUM(metal) as metal, SUM(crystal) as crystal, SUM(deuterium) as deuterium, time, userID FROM %%STORAGELOGS%% WHERE allyID = :allyId AND userID = :userID AND time > :time AND type = :type AND isdeleted = 0;";
				$allianceResultBis = $db->selectSingle($sql, array(
					':userID'	=> $searchRow['userID'],
					':time'		=> TIMESTAMP - (24*3600),
					':allyId'	=> $this->allianceData['id'],
					':type'		=> 2
				));	
			}else{
				$sql	= "SELECT SUM(metal) as metal, SUM(crystal) as crystal, SUM(deuterium) as deuterium, time, userID FROM %%STORAGELOGS%% WHERE allyID = :allyId AND userID = :userID AND time > :time AND type = :type AND isdeleted = 0;";
				$allianceResult = $db->selectSingle($sql, array(
					':userID'	=> $searchRow['userID'],
					':time'		=> TIMESTAMP - (31*24*3600),
					':allyId'	=> $this->allianceData['id'],
					':type'		=> 1
				));	
				$sql	= "SELECT SUM(metal) as metal, SUM(crystal) as crystal, SUM(deuterium) as deuterium, time, userID FROM %%STORAGELOGS%% WHERE allyID = :allyId AND userID = :userID AND time > :time AND type = :type AND isdeleted = 0;";
				$allianceResultBis = $db->selectSingle($sql, array(
					':userID'	=> $searchRow['userID'],
					':time'		=> TIMESTAMP - (31*24*3600),
					':allyId'	=> $this->allianceData['id'],
					':type'		=> 2
				));	
			}
			
			$Userlist[$searchRow['userID']]	= array(
				'metal'				=> $allianceResult['metal'],
				'crystal'			=> $allianceResult['crystal'],
				'deuterium'			=> $allianceResult['deuterium'],
				'metalBis'				=> $allianceResultBis['metal'],
				'crystalBis'			=> $allianceResultBis['crystal'],
				'deuteriumBis'			=> $allianceResultBis['deuterium'],
				'nameP'			=> getUsername($searchRow['userID']),
			);
		}
		
		$this->assign(array(
			'Userlist' => $Userlist,
			'timeShow' => $time,
		));

		$this->display('page.alliance.logstorage.tpl');
	}
	
	function logStorageFull()
	{
		global $USER, $LNG;
		if (!$this->rights['BANK']) {
			$this->redirectToHome();
		}
		
		$Userlist	= array();
		$time = HTTP::_GP('time',0);	
		$db	= Database::get();
		$sql	= "SELECT DISTINCT userID FROM %%STORAGELOGS%% WHERE allyID = :allianceId;";
		$allianceResult = $db->select($sql, array(
			':allianceId'	=> $this->allianceData['id']
		));
		
		foreach($allianceResult as $searchRow){
			$sql	= "SELECT SUM(metal) as metal, SUM(crystal) as crystal, SUM(deuterium) as deuterium, userID FROM %%STORAGELOGS%% WHERE allyID = :allyId AND userID = :userID AND type = :type;";
			$allianceResult = $db->selectSingle($sql, array(
				':userID'	=> $searchRow['userID'],
				':allyId'	=> $this->allianceData['id'],
				':type'		=> 1
			));	
			$sql	= "SELECT SUM(metal) as metal, SUM(crystal) as crystal, SUM(deuterium) as deuterium, userID FROM %%STORAGELOGS%% WHERE allyID = :allyId AND userID = :userID AND type = :type;";
			$allianceResultBis = $db->selectSingle($sql, array(
				':userID'	=> $searchRow['userID'],
				':allyId'	=> $this->allianceData['id'],
				':type'		=> 2
			));	
			
			$Userlist[$searchRow['userID']]	= array(
				'metal'				=> $allianceResult['metal'],
				'crystal'			=> $allianceResult['crystal'],
				'deuterium'			=> $allianceResult['deuterium'],
				'metalBis'			=> $allianceResultBis['metal'],
				'crystalBis'		=> $allianceResultBis['crystal'],
				'deuteriumBis'		=> $allianceResultBis['deuterium'],
				'nameP'				=> getUsername($searchRow['userID']),
			);
		}
		
		$this->assign(array(
			'Userlist' => $Userlist,
		));

		$this->display('page.alliance.logstoragefull.tpl');
	}
	
	function logstoragereset()
	{
		global $USER, $LNG;
		if (!$this->rights['ADMIN']) {
			$this->redirectToHome();
		}
			
		$sql = "UPDATE %%STORAGELOGS%% SET isdeleted = 1 WHERE allyID = :allyID;";
		database::get()->update($sql, array(
			':allyID'	=> $this->allianceData['id']
		));
		
		$this->printMessage($LNG['al_storage_logs_reset_success'], true, array('game.php?page=alliance&mode=logstorage', 3));	
	}

	

	function info()
	{
		global $LNG, $USER;

		$allianceId = HTTP::_GP('id', 0);

		$statisticData	= array();
		$diplomaticmaticData	= false;
		//mio stats
		$AllyMembers	= false;
		$MembersWons	= false;
		$MembersLoos	= false;
		$MembersDraws	= false;
		$Membersdesunits	= false;
		$Memberslostunits	= false;
		$Memberskbmetal	= false;
		$Memberskbcrystal	= false;

		$this->setAllianceData($allianceId);

		if(!isset($this->allianceData))
		{
			$this->printMessage($LNG['al_not_exists'], true, array('game.php?page=alliance', 2));
		}

		require 'includes/classes/BBCode.class.php';

		if ($this->allianceData['ally_diplo'] == 1)
		{
			$diplomaticmaticData	= $this->getDiplomatic();
		}

		if ($this->allianceData['ally_stats'] == 1)
		{
			$sql	= 'SELECT SUM(wons) as wons, SUM(loos) as loos, SUM(draws) as draws, SUM(kbmetal) as kbmetal,
            SUM(kbcrystal) as kbcrystal, SUM(lostunits) as lostunits, SUM(desunits) as desunits
            FROM %%USERS%% WHERE ally_id = :allyID;';

			$statisticResult = Database::get()->selectSingle($sql, array(
				':allyID'	=> $this->allianceData['id']
			));

			$statisticData	= array(
				'totalfight'	=> $statisticResult['wons'] + $statisticResult['loos'] + $statisticResult['draws'],
				'fightwon'		=> $statisticResult['wons'],
				'fightlose'		=> $statisticResult['loos'],
				'fightdraw'		=> $statisticResult['draws'],
				'unitsshot'		=> pretty_number($statisticResult['desunits']),
				'unitslose'		=> pretty_number($statisticResult['lostunits']),
				'dermetal'		=> pretty_number($statisticResult['kbmetal']),
				'dercrystal'	=> pretty_number($statisticResult['kbcrystal']),
			);
		}

		$sql	= 'SELECT total_points
		FROM %%STATPOINTS%%
		WHERE id_owner = :userId AND stat_type = :statType';

		$userPoints	= Database::get()->selectSingle($sql, array(
			':userId'	=> $USER['id'],
			':statType'	=> 1
		), 'total_points');

		//
		//By YamilRH mostrar lista de miembros alliance
		//

		$sql = "SELECT id,username FROM %%USERS%% WHERE universe = :universe AND ally_id = :AllianceID;";
        $membersAlly = Database::get()->select($sql, array(
            ':universe'     => Universe::current(),
            ':AllianceID'	=> $this->allianceData['id']
        ));

        foreach ($membersAlly as $AllyRow) {
			$AllyMembers[$AllyRow['id']]	= $AllyRow['username'];
		}

		$sql	= 'SELECT * FROM %%USERS%% WHERE ally_id = :allyID ORDER BY `wons` DESC LIMIT 1';
		$statisticMembersWons = Database::get()->select($sql, array(
			':allyID'	=> $this->allianceData['id']
		));

		foreach ($statisticMembersWons as $statisticRow) {
			$MembersWons[$statisticRow['id']]	= $statisticRow['username'];
		}

		$sql	= 'SELECT * FROM %%USERS%% WHERE ally_id = :allyID ORDER BY `loos` DESC LIMIT 1';
		$statisticMembersLoos = Database::get()->select($sql, array(
			':allyID'	=> $this->allianceData['id']
		));

		foreach ($statisticMembersLoos as $statisticRow) {
			$MembersLoos[$statisticRow['id']]	= $statisticRow['username'];
		}

		$sql	= 'SELECT * FROM %%USERS%% WHERE ally_id = :allyID ORDER BY `draws` DESC LIMIT 1';
		$statisticMembersDraws = Database::get()->select($sql, array(
			':allyID'	=> $this->allianceData['id']
		));

		foreach ($statisticMembersDraws as $statisticRow) {
			$MembersDraws[$statisticRow['id']]	= $statisticRow['username'];
		}

		$sql	= 'SELECT * FROM %%USERS%% WHERE ally_id = :allyID ORDER BY `desunits` DESC LIMIT 1';
		$statisticMembersdesunits = Database::get()->select($sql, array(
			':allyID'	=> $this->allianceData['id']
		));

		foreach ($statisticMembersdesunits as $statisticRow) {
			$Membersdesunits[$statisticRow['id']]	= $statisticRow['username'];
		}

		$sql	= 'SELECT * FROM %%USERS%% WHERE ally_id = :allyID ORDER BY `lostunits` DESC LIMIT 1';
		$statisticMemberslostunits = Database::get()->select($sql, array(
			':allyID'	=> $this->allianceData['id']
		));

		foreach ($statisticMemberslostunits as $statisticRow) {
			$Memberslostunits[$statisticRow['id']]	= $statisticRow['username'];
		}

		$sql	= 'SELECT * FROM %%USERS%% WHERE ally_id = :allyID ORDER BY `kbmetal` DESC LIMIT 1';
		$statisticMemberskbmetal = Database::get()->select($sql, array(
			':allyID'	=> $this->allianceData['id']
		));

		foreach ($statisticMemberskbmetal as $statisticRow) {
			$Memberskbmetal[$statisticRow['id']]	= $statisticRow['username'];
		}
		$sql	= 'SELECT * FROM %%USERS%% WHERE ally_id = :allyID ORDER BY `kbcrystal` DESC LIMIT 1';
		$statisticMemberskbcrystal = Database::get()->select($sql, array(
			':allyID'	=> $this->allianceData['id']
		));

		foreach ($statisticMemberskbcrystal as $statisticRow) {
			$Memberskbcrystal[$statisticRow['id']]	= $statisticRow['username'];
		}
		
		$sql	= 'SELECT * FROM %%ALLIANCEFRACTIONS%% WHERE ally_fraction_id = :ally_fraction_id;';
		$FRACTIONS = database::get()->selectSingle($sql, array(
			':ally_fraction_id'	=> $this->allianceData['ally_fraction_id']
		));

		$this->assign(array(
			'ALLFRACTION'					=> $FRACTIONS,
			'user_allyId'					=> $USER['ally_id'],
			'AllyMembers'					=> $AllyMembers,
			'StatMembersWons'				=> $MembersWons,
			'StatMembersLoos'				=> $MembersLoos,
			'StatMembersDraws'				=> $MembersDraws,
			'StatMembersdesunits'			=> $Membersdesunits,
			'StatMemberslostunits'			=> $Memberslostunits,
			'StatMemberskbmetal'			=> $Memberskbmetal,
			'StatMemberskbcrystal'			=> $Memberskbcrystal,
			'diplomaticData'				=> $diplomaticmaticData,
			'statisticData'					=> $statisticData,
			'ally_description' 				=> BBCode::parse($this->allianceData['ally_description']),
			'ally_id'	 					=> $this->allianceData['id'],
			'ally_image' 					=> $this->allianceData['ally_image'],
			'ally_web'						=> $this->allianceData['ally_web'],
			'ally_member_scount' 			=> $this->allianceData['ally_members'],
			'ally_max_members' 				=> $this->allianceData['ally_max_members'],
			'ally_name' 					=> $this->allianceData['ally_name'],
			'ally_tag' 						=> $this->allianceData['ally_tag'],
			'ally_stats' 					=> $this->allianceData['ally_stats'],
			'ally_diplo' 					=> $this->allianceData['ally_diplo'],
			'ally_fraction_id'				=> $this->allianceData['ally_fraction_id'],
            'ally_fraction_level'			=> $this->allianceData['ally_fraction_level'],
            'ally_fraction_name'			=> $LNG['all_frac_'.$this->allianceData['ally_fraction_id']],
			'ally_request'              	=> !$this->hasAlliance && !$this->hasApply && $this->allianceData['ally_request_notallow'] == 0 && $this->allianceData['ally_max_members'] > $this->allianceData['ally_members'],
			'ally_request_min_points'		=> $userPoints >= $this->allianceData['ally_request_min_points'],
			'ally_request_min_points_info'  => sprintf($LNG['al_requests_min_points'], pretty_number($this->allianceData['ally_request_min_points'])),
		));

		$this->display('page.alliance.info.tpl');
	}

	function show()
	{
		/*if($this->hasAlliance) {
			$this->homeAlliance();
		} elseif($this->hasApply) {
			$this->applyWaitScreen();
		} else {
			$this->createSelection();
		}*/
		//fix by hirako time to change alliance
		global $USER, $LNG;
		if($this->hasAlliance) {
			$this->homeAlliance();
		} else if($USER['ally_date']+$this->alliance_change_time>=TIMESTAMP){
			$tiempo = $USER['ally_date']+$this->alliance_change_time;
			$this->printMessage("Todavia no se ha cumplido el tiempo requerido para cambiar de alianza <br>Fecha: <b>"._date($LNG['php_tdformat'], $tiempo, $USER['timezone'])."</b> ", array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> '?page=alliance'
			)));
		}

		elseif($this->hasApply) {
			$this->applyWaitScreen();
		} else {
			$this->createSelection();
		}
	}

	private function redirectToHome()
	{
		$this->redirectTo('game.php?page=alliance');
	}

	private function getAction()
	{
		return HTTP::_GP('action', '');
	}

	private function applyWaitScreen()
	{
		global $USER, $LNG;

		$db	= Database::get();
		$sql	= "SELECT a.ally_tag FROM %%ALLIANCE_REQUEST%% r INNER JOIN %%ALLIANCE%% a ON a.id = r.allianceId WHERE r.userId = :userId;";
		$allianceResult = $db->selectSingle($sql, array(
			':userId'	=> $USER['id_planet']
		));

		$this->assign(array(
			'request_text'	=> sprintf($LNG['al_request_wait_message'], $allianceResult['ally_tag']),
		));

		$this->display('page.alliance.applyWait.tpl');
	}

	//ALLIANCE DEVELOPMENT
	function development()
	{
		global $USER, $LNG;
		
		$var1 = round(3 * pow(1.15, $this->allianceData['total_alliance_production'] + 1));
		$var2 = round(3 * pow(1.25, $this->allianceData['total_alliance_speed']));
		$var3 = round(3 * pow(1.20, $this->allianceData['total_alliance_power'] + 1));
		$var4 = floor(1 * pow(1.20, $this->allianceData['total_alliance_buildings'] + 1));
		$var5 = floor(1 * pow(1.20, $this->allianceData['total_alliance_research'] + 1));
		$var6 = floor(1 * pow(1.20, $this->allianceData['total_alliance_conv_fleet'] + 1));
		$var7 = floor(1 * pow(1.20, $this->allianceData['total_alliance_conv_def'] + 1));

		$this->assign(array(
			'alliance_points'	=> $this->allianceData['total_alliance_points'],
			'allyidchecl'	=> $this->allianceData['id'],
			'points1001'	=> $var1,
			'points1002'	=> $var2,
			'points1003'	=> $var3,
			'points1004'	=> $var4,
			'points1005'	=> $var5,
			'points1006'	=> $var6,
			'points1007'	=> $var7,
			'points1007'	=> $var7,
			'points1001L'	=> sprintf($LNG['allian_35'], $var1),
			'points1002L'	=> sprintf($LNG['allian_35'], $var2),
			'points1003L'	=> sprintf($LNG['allian_35'], $var3),
			'points1004L'	=> sprintf($LNG['allian_35'], $var4),
			'points1005L'	=> sprintf($LNG['allian_35'], $var5),
			'points1006L'	=> sprintf($LNG['allian_35'], $var6),
			'points1007L'	=> sprintf($LNG['allian_35'], $var7),
			'points1001B'	=> $this->allianceData['total_alliance_production'],
			'points1002B'	=> $this->allianceData['total_alliance_speed'],
			'points1003B'	=> $this->allianceData['total_alliance_power'] / 2,
			'points1004B'	=> $this->allianceData['total_alliance_buildings'],
			'points1005B'	=> $this->allianceData['total_alliance_research'],
			'points1006B'	=> $this->allianceData['total_alliance_conv_fleet'],
			'points1007B'	=> $this->allianceData['total_alliance_conv_def'],
		));

		$this->display('page.devlopment.alliance.tpl');
	}
	
	function up()
	{
		global $USER, $LNG;
		$id		= HTTP::_GP('id', 0);
		$pkt	= $this->allianceData['total_alliance_points'];
		$var1 = round(3 * pow(1.15, $this->allianceData['total_alliance_production'] + 1));
		$var2 = round(3 * pow(1.25, $this->allianceData['total_alliance_speed']));
		$var3 = round(3 * pow(1.20, $this->allianceData['total_alliance_power'] + 1));
		$var4 = floor(1 * pow(1.20, $this->allianceData['total_alliance_buildings'] + 1));
		$var5 = floor(1 * pow(1.20, $this->allianceData['total_alliance_research'] + 1));
		$var6 = floor(1 * pow(1.20, $this->allianceData['total_alliance_conv_fleet'] + 1));
		$var7 = floor(1 * pow(1.20, $this->allianceData['total_alliance_conv_def'] + 1));
		
		if($id == 1001 && $pkt >= $var1){
			$sql	= "UPDATE %%ALLIANCE%% SET total_alliance_production = total_alliance_production + :userLevel, total_alliance_points = total_alliance_points - :points WHERE id = :allyId;";
			Database::get()->update($sql, array(
			':userLevel'	=> 1,
			':points'	=> $var1,
			':allyId'		=> $this->allianceData['id']
			));
		}elseif($id == 1002 && $pkt >= $var2){
			$sql	= "UPDATE %%ALLIANCE%% SET total_alliance_speed = total_alliance_speed + :userLevel, total_alliance_points = total_alliance_points - :points WHERE id = :allyId;";
			Database::get()->update($sql, array(
			':userLevel'	=> 1,
			':points'	=> $var2,
			':allyId'		=> $this->allianceData['id']
			));
		}elseif($id == 1003 && $pkt >= $var3){
			$sql	= "UPDATE %%ALLIANCE%% SET total_alliance_power = total_alliance_power + :userLevel, total_alliance_points = total_alliance_points - :points WHERE id = :allyId;";
			Database::get()->update($sql, array(
			':userLevel'	=> 1,
			':points'	=> $var3,
			':allyId'		=> $this->allianceData['id']
			));
		}elseif($id == 1004 && $pkt >= $var4){
			$sql	= "UPDATE %%ALLIANCE%% SET total_alliance_buildings = total_alliance_buildings + :userLevel, total_alliance_points = total_alliance_points - :points WHERE id = :allyId;";
			Database::get()->update($sql, array(
			':userLevel'	=> 1,
			':points'	=> $var4,
			':allyId'		=> $this->allianceData['id']
			));
		}elseif($id == 1005 && $pkt >= $var5){
			$sql	= "UPDATE %%ALLIANCE%% SET total_alliance_research = total_alliance_research + :userLevel, total_alliance_points = total_alliance_points - :points WHERE id = :allyId;";
			Database::get()->update($sql, array(
			':userLevel'	=> 1,
			':points'	=> $var5,
			':allyId'		=> $this->allianceData['id']
			));
		}elseif($id == 1006 && $pkt >= $var6){
			$sql	= "UPDATE %%ALLIANCE%% SET total_alliance_conv_fleet = total_alliance_conv_fleet + :userLevel, total_alliance_points = total_alliance_points - :points WHERE id = :allyId;";
			Database::get()->update($sql, array(
			':userLevel'	=> 1,
			':points'	=> $var6,
			':allyId'		=> $this->allianceData['id']
			));
		}elseif($id == 1007 && $pkt >= $var7){
			$sql	= "UPDATE %%ALLIANCE%% SET total_alliance_conv_def = total_alliance_conv_def + :userLevel, total_alliance_points = total_alliance_points - :points WHERE id = :allyId;";
			Database::get()->update($sql, array(
			':userLevel'	=> 1,
			':points'	=> $var7,
			':allyId'		=> $this->allianceData['id']
			));
		}else{
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/game.php?page=alliance&mode=development');
		}
		
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/game.php?page=alliance&mode=development');
	}
	//ALLIANCE DEVELOPMENT


	private function createSelection()
	{
		global $USER, $LNG;
		$db	= Database::get();
		$sql	= "SELECT * FROM %%ALLIANCE%%";
		$allianceResult = $db->select($sql, array(
		));
		$Userlist = array();
		foreach($allianceResult as $searchRow){
		
		$Userlist[$searchRow['id']]	= array(
				'image'				=> $searchRow['ally_image'],
				'name'				=> $searchRow['ally_name'],
				'tag'				=> $searchRow['ally_tag'],
				'ally_members'				=> $searchRow['ally_members'],
				'ally_max_members'				=> $searchRow['ally_max_members'],
				'ally_fraction_id'	=> $searchRow['ally_fraction_id'],
                'ally_fraction_level'	=> $searchRow['ally_fraction_level'],
                'ally_fraction_name'	=> $LNG['all_frac_'.$searchRow['ally_fraction_id']],
			);
			
		}
		
		$this->assign(array(
		'Userlist' => $Userlist,
		));
		
		$this->display('page.alliance.createSelection.tpl');
	}

	function search()
	{
		global $LNG;
		if($this->hasApply) {
			$this->redirectToHome();
		}

		$searchText	= HTTP::_GP('searchtext', '', UTF8_SUPPORT);
		$searchList	= array();

		if (!empty($searchText))
		{
			$db	= Database::get();
			$sql	= "SELECT id, ally_name, ally_tag, ally_members, ally_max_members, ally_image, ally_fraction_id, ally_fraction_level
			FROM %%ALLIANCE%%
			WHERE ally_universe = :universe AND ally_name LIKE :searchtext
			ORDER BY (
			  IF(ally_name = :searchtextt, 1, 0) + IF(ally_name LIKE :searchtext, 1, 0)
			) DESC,ally_name ASC LIMIT 25;";
		
		

			$searchResult	= $db->select($sql, array(
				':universe' => Universe::current(),
				':searchtextt' => $searchText,
				':searchtext' => '%'.$searchText.'%'
			));

			foreach($searchResult as $searchRow)
			{
				$searchList[]	= array(
					'id'		=> $searchRow['id'],
					'tag'		=> $searchRow['ally_tag'],
					'members'	=> $searchRow['ally_members'],
					'max_members'	=> $searchRow['ally_max_members'],
					'name'		=> $searchRow['ally_name'],
					'ally_image'		=> $searchRow['ally_image'],
					'ally_fraction_id'	=> $searchRow['ally_fraction_id'],
					'ally_fraction_level'	=> $searchRow['ally_fraction_level'],
					'ally_fraction_name'	=> $LNG['all_frac_'.$searchRow['ally_fraction_id']],
				);
			}
		}

		$this->assign(array(
			'searchText'	=> $searchText,
			'searchList'	=> $searchList,
		));

		$this->display('page.alliance.search.tpl');
	}

	function apply()
	{
		//fix by hirako time to change alliance
		global $LNG, $USER;
		if($USER['ally_date']+$this->alliance_change_time>=TIMESTAMP){
			$this->printMessage("Todavia no se ha cumplido el tiempo requerido para cambiar de alianza", array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> '?page=alliance'
			)));
		}

		if($this->hasApply) {
			$this->redirectToHome();
		}

		$text		= HTTP::_GP('text' , '', true);
		$allianceId	= HTTP::_GP('id', 0);

		$db 	= Database::get();
		$sql	= "SELECT ally_tag, ally_request, ally_request_notallow FROM %%ALLIANCE%% WHERE id = :allianceId AND ally_universe = :universe;";
		$allianceResult = $db->selectSingle($sql, array(
			':allianceId'	=> $allianceId,
			':universe'     => Universe::current()
		));

		if (!isset($allianceResult)) {
			$this->redirectToHome();
		}

		if($allianceResult['ally_request_notallow'] == 1)
		{
			$this->printMessage($LNG['al_alliance_closed'], array(array(
				'label'	=> $LNG['sys_forward'],
				'url'	=> '?page=alliance'
			)));
		}

		if (!empty($text))
		{
			$sql = "INSERT INTO %%ALLIANCE_REQUEST%% SET
                allianceId	= :allianceId,
                text		= :text,
                time		= :time,
                userId		= :userId;";

			$db->insert($sql, array(
				':allianceId'	=> $allianceId,
				':text'			=> $text,
				':time'			=> TIMESTAMP,
				':userId'		=> $USER['id']
			));

			$this->printMessage($LNG['al_request_confirmation_message'], array(array(
				'label'	=> $LNG['sys_forward'],
				'url'	=> '?page=alliance'
			)));
		}

		$this->assign(array(
			'allyid'			=> $allianceId,
			'applytext'			=> $allianceResult['ally_request'],
			'al_write_request'	=> sprintf($LNG['al_write_request'], $allianceResult['ally_tag']),
		));

		$this->display('page.alliance.apply.tpl');
	}

	function cancelApply()
	{
		global $LNG, $USER;

		if(!$this->hasApply) {
			$this->redirectToHome();
		}

		$db = Database::get();
		$sql	= "SELECT a.ally_tag FROM %%ALLIANCE_REQUEST%% r INNER JOIN %%ALLIANCE%% a ON a.id = r.allianceId WHERE r.userId = :userId;";
		$allyTag = $db->selectSingle($sql, array(
			':userId'	=> $USER['id']
		), 'ally_tag');

		$sql = "DELETE FROM %%ALLIANCE_REQUEST%% WHERE userId = :userId;";
		$db->delete($sql, array(
			':userId'	=> $USER['id']
		));

		$this->printMessage(sprintf($LNG['al_request_deleted'], $allyTag), array(array(
			'label'	=> $LNG['sys_forward'],
			'url'	=> '?page=alliance'
		)));
	}

	function create()
	{
		global $USER, $LNG;

		if($this->hasApply) {
			$this->redirectToHome();
		}
			//if($USER['id'] != 1)
			//$this->printMessage("Esta página se encuentra desabilitada, inténtelo mas tarde.", true, array('game.php?page=overview', 2));

		$sql	= 'SELECT total_points
		FROM %%STATPOINTS%%
		WHERE id_owner = :userId AND stat_type = :statType';

		$userPoints	= Database::get()->selectSingle($sql, array(
			':userId'	=> $USER['id'],
			':statType'	=> 1
		), 'total_points');

		$min_points = Config::get()->alliance_create_min_points;

		if($userPoints >= $min_points)
		{
			$action    = $this->getAction();
			if($action == "send") {
				$this->createAlliance();
			} else {
				$this->display('page.alliance.create.tpl');
			}
		}
		else
		{
			$diff_points 	= $min_points - $userPoints;
			$messageText	= sprintf($LNG['al_make_ally_insufficient_points'],
				pretty_number($min_points), pretty_number($diff_points));

			$this->printMessage($messageText, array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> '?page=alliance'
			)));
		}
	}

	private function createAlliance()
	{
		$action	= $this->getAction();
		if($action == "send") {
			$this->createAllianceProcessor();
		} else {
			$this->display('page.alliance.create.tpl');
		}
	}

	private function createAllianceProcessor()
	{
		global $USER, $LNG;
		$allianceTag	= HTTP::_GP('atag' , '', UTF8_SUPPORT);
		$allianceName	= HTTP::_GP('aname', '', UTF8_SUPPORT);

		if (empty($allianceTag)) {
			$this->printMessage($LNG['al_tag_required'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> '?page=alliance&mode=create'
			)));
		}

		if (empty($allianceName)) {
			$this->printMessage($LNG['al_name_required'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> '?page=alliance&mode=create'
			)));
		}

		if (!PlayerUtil::isNameValid($allianceName) || !PlayerUtil::isNameValid($allianceTag)) {
			$this->printMessage($LNG['al_newname_specialchar'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> '?page=alliance&mode=create'
			)));
		}

		$db		= Database::get();

		$sql	= 'SELECT COUNT(*) as count FROM %%ALLIANCE%% WHERE ally_universe = :universe
        AND (ally_tag = :allianceTag OR ally_name = :allianceName);';

		$allianceCount = $db->selectSingle($sql, array(
			':universe'	=> Universe::current(),
			':allianceTag' => $allianceTag,
			':allianceName' => $allianceName
		), 'count');

		if ($allianceCount != 0) {
			$this->printMessage(sprintf($LNG['al_already_exists'], $allianceName), array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> '?page=alliance&mode=create'
			)));
		}

		$sql	= "INSERT INTO %%ALLIANCE%% SET ally_name = :allianceName, ally_tag = :allianceTag, ally_owner = :userId,
        ally_owner_range = :allianceOwnerRange, ally_members = 1, ally_register_time = :time, ally_universe = :universe;";
		$db->insert($sql, array(
			':allianceName'			=> $allianceName,
			':allianceTag'			=> $allianceTag,
			':userId'			    => $USER['id'],
			':allianceOwnerRange'	=> $LNG['al_default_leader_name'],
			':time'                 => TIMESTAMP,
			':universe'             => Universe::current(),
		));

		$allianceId = $db->lastInsertId();

		$sql	= "UPDATE %%USERS%% SET ally_id	= :allianceId, ally_rank_id	= 0, ally_register_time = :time WHERE id = :userId;";
		$db->update($sql, array(
			':allianceId'	=> $allianceId,
			':time'			=> TIMESTAMP,
			':userId'       => $USER['id']
		));

		$sql	= "UPDATE %%STATPOINTS%% SET id_ally = :allianceId WHERE id_owner = :userId;";
		$db->update($sql, array(
			':allianceId'	=> $allianceId,
			':userId'       => $USER['id']
		));

		$this->printMessage(sprintf($LNG['al_created'], $allianceName.' ['.$allianceTag.']'), array(array(
			'label'	=> $LNG['sys_forward'],
			'url'	=> '?page=alliance'
		)));
	}

	private function getDiplomatic()
	{
		$Return	= array();
		$db = Database::get();

		$sql	= "SELECT d.level, d.accept, d.accept_text, d.id, a.id as ally_id, a.ally_name, a.ally_tag, d.owner_1, d.owner_2 FROM %%DIPLO%% as d INNER JOIN %%ALLIANCE%% as a ON IF(:allianceId = d.owner_1, a.id = d.owner_2, a.id = d.owner_1) WHERE :allianceId = d.owner_1 OR :allianceId = d.owner_2;";
		$DiploResult	= $db->select($sql, array(
			':allianceId'		=> $this->allianceData['id'],
		));

		foreach($DiploResult as $CurDiplo)
		{
			if($CurDiplo['accept'] == 0 && $CurDiplo['owner_2'] == $this->allianceData['id'])
				$Return[5][$CurDiplo['id']] = array($CurDiplo['ally_name'], $CurDiplo['ally_id'], $CurDiplo['level'], $CurDiplo['accept_text'], $CurDiplo['ally_tag']);
			elseif($CurDiplo['accept'] == 0 && $CurDiplo['owner_1'] == $this->allianceData['id'])
				$Return[6][$CurDiplo['id']] = array($CurDiplo['ally_name'], $CurDiplo['ally_id'], $CurDiplo['level'], $CurDiplo['accept_text'], $CurDiplo['ally_tag']);
			else
				$Return[$CurDiplo['level']][$CurDiplo['id']] = array($CurDiplo['ally_name'], $CurDiplo['ally_id'], $CurDiplo['owner_1'], $CurDiplo['ally_tag']);
		}
		return $Return;
	}

	private function homeAlliance()
	{
		global $USER, $LNG;

		require 'includes/classes/BBCode.class.php';

		$db	= Database::get();

		if ($this->allianceData['ally_owner'] == $USER['id']) {
			$rankName	= ($this->allianceData['ally_owner_range'] != '') ? $this->allianceData['ally_owner_range'] : $LNG['al_founder_rank_text'];
		} elseif ($USER['ally_rank_id'] != 0) {
			$sql	= "SELECT rankName FROM %%ALLIANCE_RANK%% WHERE rankID = :UserRankID;";
			$rankName = $db->selectSingle($sql, array(
				':UserRankID'	=> $USER['ally_rank_id']
			),'rankName');
		}

		if (empty($rankName)) {
			$rankName	= $LNG['al_new_member_rank_text'];
		}

		$sql	= "SELECT SUM(wons) as wons, SUM(loos) as loos, SUM(draws) as draws, SUM(kbmetal) as kbmetal, SUM(kbcrystal) as kbcrystal, SUM(lostunits) as lostunits, SUM(desunits) as desunits FROM %%USERS%% WHERE ally_id = :AllianceID;";
		$statisticResult = $db->selectSingle($sql, array(
			':AllianceID'	=> $this->allianceData['id']
		));

		$sql = "SELECT COUNT(*) as count FROM %%ALLIANCE_REQUEST%% WHERE allianceId = :AllianceID;";
		$ApplyCount = $db->selectSingle($sql, array(
			':AllianceID'	=> $this->allianceData['id']
		),'count');

		$ally_events = array();

		if(!empty($this->allianceData['ally_events']))
		{
			$sql = "SELECT id, username FROM %%USERS%% WHERE ally_id = :AllianceID;";
			$result = $db->select($sql, array(
				':AllianceID'	=> $this->allianceData['id']
			));


			require_once('includes/classes/class.FlyingFleetsTable.php');
			$FlyingFleetsTable = new FlyingFleetsTable;

			$this->tplObj->loadscript('overview.js');

			foreach($result as $row)
			{
				$FlyingFleetsTable->setUser($row['id']);
				$FlyingFleetsTable->setMissions($this->allianceData['ally_events']);
				$ally_events[$row['username']] = $FlyingFleetsTable->renderTable();
			}

			$ally_events = array_filter($ally_events);
		}

		//friend ally events
		$db = Database::get();

		$sql	= "SELECT * from %%DIPLO%% where (owner_1 = :allianceId or owner_2 = :allianceId) and accept = 1 and level = 2";
		$ally_pact	= $db->select($sql, array(
			':allianceId'		=> $this->allianceData['id'],
		));
		$ally_pact_events = NULL;
		if (isset($ally_pact)&&isset($ally_pact[0])) {
			$ally_pact_id= $ally_pact[0]["owner_1"]==$this->allianceData['id']?$ally_pact[0]["owner_2"]:$ally_pact[0]['owner_1'];

		if(!empty($this->allianceData['ally_events']))
		{
			$sql = "SELECT id, username FROM %%USERS%% WHERE ally_id = :AllianceID;";
			$result = $db->select($sql, array(
				':AllianceID'	=> $ally_pact_id
			));


			require_once('includes/classes/class.FlyingFleetsTable.php');
			$FlyingFleetsTable = new FlyingFleetsTable;

			$this->tplObj->loadscript('overview.js');

			foreach($result as $row)
			{
				$FlyingFleetsTable->setUser($row['id']);
				$FlyingFleetsTable->setMissions($this->allianceData['ally_events']);
				$ally_pact_events[$row['username']] = $FlyingFleetsTable->renderTable();
			}

			$ally_pact_events = array_filter($ally_pact_events);
		}


		}
		
		//end fix
		//
		

		$sql	= 'SELECT * FROM %%ALLIANCEFRACTIONS%% WHERE ally_fraction_id = :ally_fraction_id;';
		$FRACTIONS = database::get()->selectSingle($sql, array(
			':ally_fraction_id'	=> $this->allianceData['ally_fraction_id']
		));

		$sql	= 'SELECT * FROM %%PLANETS%% WHERE isAlliancePlanet = :isAlliancePlanet AND destruyed = 0;';
		$getAlliance = database::get()->select($sql, array(
			':isAlliancePlanet'		=> $this->allianceData['id'],
		));
		
		$managePlanets = array();
		
		foreach($getAlliance as $allyPlanet){
			$managePlanets[$allyPlanet['id']] = array(
				'planetName'	=> $allyPlanet['name'],
				'planetGalaxy'	=> $allyPlanet['galaxy'],
				'planetSystem'	=> $allyPlanet['system'],
				'planetPlanet'	=> $allyPlanet['planet'],
			);
		}

		$this->assign(array(
			'managePlanets'				=> $managePlanets,
			'ALLFRACTION'				=> $FRACTIONS,
			'DiploInfo'					=> $this->getDiplomatic(),
			'ally_web'					=> $this->allianceData['ally_web'],
			'ally_tag'	 				=> $this->allianceData['ally_tag'],
			'ally_members'	 			=> $this->allianceData['ally_members'],
			'ally_max_members'	 		=> $this->allianceData['ally_max_members'],
			'ally_name'					=> $this->allianceData['ally_name'],
			'ally_image'				=> $this->allianceData['ally_image'],
			'ally_description'			=> BBCode::parse($this->allianceData['ally_description']),
			'ally_text' 				=> BBCode::parse($this->allianceData['ally_text']),
			'rankName'					=> $rankName,
			'requests'					=> sprintf($LNG['al_new_requests'], $ApplyCount),
			'applyCount'				=> $ApplyCount,
			'totalfight'				=> $statisticResult['wons'] + $statisticResult['loos'] + $statisticResult['draws'],
			'fightwon'					=> $statisticResult['wons'],
			'fightlose'					=> $statisticResult['loos'],
			'fightdraw'					=> $statisticResult['draws'],
			'unitsshot'					=> pretty_number($statisticResult['desunits']),
			'unitslose'					=> pretty_number($statisticResult['lostunits']),
			'dermetal'					=> pretty_number($statisticResult['kbmetal']),
			'dercrystal'				=> pretty_number($statisticResult['kbcrystal']),
			'isOwner'					=> $this->allianceData['ally_owner'] == $USER['id'],
			'ally_events'				=> $ally_events,
			'ally_pact_events'			=> $ally_pact_events,
			'ally_fraction_id'			=> $this->allianceData['ally_fraction_id'],
            'ally_fraction_level'		=> $this->allianceData['ally_fraction_level'],
            'ally_fraction_name'		=> $LNG['all_frac_'.$this->allianceData['ally_fraction_id']],
			'alliance_points'			=> $this->allianceData['total_alliance_points'],
			'PLANETRIGHT'				=> !$this->rights['ADMIN'] ? 0 : 1,
		));

		$this->display('page.alliance.home.tpl');
	}

	public function memberList()
	{
		global $USER, $LNG;
		if (!$this->rights['MEMBERLIST']) {
			$this->redirectToHome();
		}

		$rankList	= array();

		$db = Database::get();
		$sql = "SELECT rankID, rankName FROM %%ALLIANCE_RANK%% WHERE allianceId = :AllianceID";
		$rankResult = $db->select($sql, array(
			':AllianceID'	=> $this->allianceData['id']
		));

		foreach($rankResult as $rankRow)
			$rankList[$rankRow['rankID']]	= $rankRow['rankName'];

		$memberList	= array();

		$sql = "SELECT DISTINCT u.id, u.username,u.galaxy, u.system, u.planet, u.ally_register_time, u.onlinetime, u.ally_rank_id, s.total_points FROM %%USERS%% u LEFT JOIN %%STATPOINTS%% as s ON s.stat_type = '1' AND s.id_owner = u.id WHERE ally_id = :AllianceID;";
		$memberListResult = $db->select($sql, array(
			':AllianceID'	=> $this->allianceData['id']
		));

		foreach ($memberListResult as $memberListRow)
		{
			if ($this->allianceData['ally_owner'] == $memberListRow['id'])
				$memberListRow['ally_rankName'] = empty($this->allianceData['ally_owner_range']) ? $LNG['al_founder_rank_text'] : $this->allianceData['ally_owner_range'];
			elseif ($memberListRow['ally_rank_id'] != 0 && isset($rankList[$memberListRow['ally_rank_id']]))
				$memberListRow['ally_rankName'] = $rankList[$memberListRow['ally_rank_id']];
			else
				$memberListRow['ally_rankName'] = $LNG['al_new_member_rank_text'];

			$memberList[$memberListRow['id']]	= array(
				'username'		=> $memberListRow['username'],
				'galaxy'		=> $memberListRow['galaxy'],
				'system'		=> $memberListRow['system'],
				'planet'		=> $memberListRow['planet'],
				'register_time'	=> _date($LNG['php_tdformat'], $memberListRow['ally_register_time'], $USER['timezone']),
				'points'		=> $memberListRow['total_points'],
				//'rankName'		=> $memberListRow['ally_rankName'],
				'onlinetime'	=> floor((TIMESTAMP - $memberListRow['onlinetime']) / 60),
			);
		}

		$this->assign(array(
			'memberList'		=> $memberList,
			'al_users_list'		=> sprintf($LNG['al_users_list'], count($memberList)),
		));

		$this->display('page.alliance.memberList.tpl');
	}

	public function close()
	{
		global $USER;

		$db = Database::get();
		//fix by hirako time to change alliance
		$sql	= "UPDATE %%USERS%% SET ally_id = 0, ally_register_time = 0, ally_date=".time()." WHERE id = :UserID;";
		$db->update($sql, array(
			':UserID'			=> $USER['id'],
			//':AllianceID'			=> isset($this->allianceData['id'])
		));

		$sql	= "UPDATE %%USERS%% SET ally_id = 0, ally_register_time = 0 WHERE id = :UserID;";
		$db->update($sql, array(
			':UserID'			=> $USER['id']
		));

		$sql	= "UPDATE %%STATPOINTS%% SET id_ally = 0 WHERE id_owner = :UserID AND stat_type = 1;";
		$db->update($sql, array(
			':UserID'			=> $USER['id']
		));

		$sql	= "UPDATE %%ALLIANCE%% SET ally_members = (SELECT COUNT(*) FROM %%USERS%% WHERE ally_id = :AllianceID) WHERE id = :AllianceID;";
		$db->update($sql, array(
			':AllianceID'			=> $this->allianceData['id']
		));

		$this->redirectTo('game.php?page=alliance');
	}

	public function circular()
	{
		global $LNG, $USER;

		if (!$this->rights['ROUNDMAIL'])
			$this->redirectToHome();

		$action	= HTTP::_GP('action', '');

		if ($action == "send")
		{
			$rankId		= HTTP::_GP('rankID', 0);
			$subject 	= HTTP::_GP('subject', '', true);
			$text 		= HTTP::_GP('text', $LNG['mg_no_subject'], true);

			if(empty($text)) {
				$this->sendJSON(array('message' => $LNG['mg_empty_text'], 'error' => true));
			}

			$db = Database::get();

			if($rankId == 0) {
				$sql	= 'SELECT id, username FROM %%USERS%% WHERE ally_id = :AllianceID;';
				$sendUsersResult	= $db->select($sql, array(
					':AllianceID'	=> $this->allianceData['id'],
				));
			} else {
				$sql	= 'SELECT id, username FROM %%USERS%% WHERE ally_id = :AllianceID AND ally_rank_id = :RankID;';
				$sendUsersResult	= $db->select($sql, array(
					':AllianceID'	=> $this->allianceData['id'],
					':RankID'	    => $rankId
				));
			}

			$sendList 	= $LNG['al_circular_sended'];
			$title		= $LNG['al_circular_alliance'].$this->allianceData['ally_tag'];
			$text		= sprintf($LNG['al_circular_front_text'], $USER['username'])."\r\n".$text;

			foreach ($sendUsersResult as $sendUsersRow)
			{
				PlayerUtil::sendMessage($sendUsersRow['id'], $USER['id'], $title, 2, $subject, makebr($text), TIMESTAMP);
				$sendList	.= "\n".$sendUsersRow['username'];
			}

			$this->sendJSON(array('message' => $sendList, 'error' => false));
		}

		$this->initTemplate();
		$this->setWindow('popup');
		$RangeList[]	= $LNG['al_all_players'];

		if (is_array($this->ranks))
		{
			foreach($this->ranks as $id => $array)
			{
				$RangeList[$id + 1]	= $array['name'];
			}
		}

		$this->assign(array(
			'RangeList'						=> $RangeList,
		));

		$this->display('page.alliance.circular.tpl');
	}

	public function admin()
	{
		global $LNG;

		$action		= HTTP::_GP('action', 'overview');
		$methodName	= 'admin'.ucwords($action);

		if(!is_callable(array($this, $methodName))) {
			ShowErrorPage::printError($LNG['page_doesnt_exist']);
		}

		$this->{$methodName}();
	}

	protected function adminOverview()
	{
		global $LNG;
		$send 		= HTTP::_GP('send', 0);
		$textMode  	= HTTP::_GP('textMode', 'external');

		if ($send)
		{
			$db = Database::get();

			$this->allianceData['ally_owner_range'] 		= HTTP::_GP('owner_range', '', true);
			$this->allianceData['ally_web'] 				= filter_var(HTTP::_GP('web', ''), FILTER_VALIDATE_URL);
			$this->allianceData['ally_image'] 				= filter_var(HTTP::_GP('image', ''), FILTER_VALIDATE_URL);
			$this->allianceData['ally_request_notallow'] 	= HTTP::_GP('request_notallow', 0);
			$this->allianceData['ally_max_members'] 		= max(HTTP::_GP('ally_max_members', ''), $this->allianceData['ally_members']);
			$this->allianceData['ally_request_min_points']  = HTTP::_GP('request_min_points', 0);
			$this->allianceData['ally_stats'] 				= HTTP::_GP('stats', 0);
			$this->allianceData['ally_diplo'] 				= HTTP::_GP('diplo', 0);
			$this->allianceData['ally_events'] 				= implode(',', HTTP::_GP('events', array(0)));

			$new_ally_tag 	= HTTP::_GP('ally_tag', $this->allianceData['ally_tag'], UTF8_SUPPORT);
			$new_ally_name	= HTTP::_GP('ally_name', $this->allianceData['ally_name'], UTF8_SUPPORT);

			if(!empty($new_ally_tag) && $this->allianceData['ally_tag'] != $new_ally_tag)
			{
				$sql = "SELECT COUNT(*) as count FROM %%ALLIANCE%% WHERE ally_universe = :universe AND ally_tag = :NewAllianceTag;";
				$allianceCount = $db->selectSingle($sql, array(
					':universe'	        => Universe::current(),
					':NewAllianceTag'   => $new_ally_tag
				), 'count');

				if($allianceCount != 0)
				{
					$this->printMessage(sprintf($LNG['al_already_exists'], $new_ally_tag), array(array(
						'label'	=> $LNG['sys_back'],
						'url'	=> 'game.php?page=alliance&mode=admin'
					)));
				}
				else
				{
					$this->allianceData['ally_tag'] = $new_ally_tag;
				}
			}

			if(!empty($new_ally_name) && $this->allianceData['ally_name'] != $new_ally_name)
			{
				$sql = "SELECT COUNT(*) as count FROM %%ALLIANCE%% WHERE ally_universe = :universe AND ally_name = :NewAllianceName;";
				$allianceCount = $db->selectSingle($sql, array(
					':universe'	        => Universe::current(),
					':NewAllianceName'   => $new_ally_name
				), 'count');

				if($allianceCount != 0)
				{
					$this->printMessage(sprintf($LNG['al_already_exists'], $new_ally_name), array(array(
						'label'	=> $LNG['sys_back'],
						'url'	=> 'game.php?page=alliance&mode=admin'
					)));
				}
				else
				{
					$this->allianceData['ally_name'] = $new_ally_name;
				}
			}

			if ($this->allianceData['ally_request_notallow'] != 0 && $this->allianceData['ally_request_notallow'] != 1) {
				$this->allianceData['ally_request_notallow'] = 0;
			}

			$text 		= HTTP::_GP('text', '', true);
			$textMode  	= HTTP::_GP('textMode', 'external');

			$textSQL	= "";

			switch($textMode)
			{
				case 'external':
					$textSQL	= "ally_description = :text, ";
					break;
				case 'internal':
					$textSQL	= "ally_text = :text, ";
					break;
				case 'apply':
					$textSQL	= "ally_request = :text, ";
					break;
			}

			$sql = "UPDATE %%ALLIANCE%% SET
			".$textSQL."
			ally_tag = :AllianceTag,
			ally_name = :AllianceName,
			ally_owner_range = :AllianceOwnerRange,
			ally_image = :AllianceImage,
			ally_web = :AllianceWeb,
			ally_request_notallow = :AllianceRequestNotAllow,
			ally_max_members = :AllianceMaxMember,
			ally_request_min_points = :AllianceRequestMinPoints,
			ally_stats = :AllianceStats,
			ally_diplo = :AllianceDiplo,
			ally_events = :AllianceEvents
			WHERE id = :AllianceID;";

			$db->update($sql, array(
				':AllianceTag'				=> $this->allianceData['ally_tag'],
				':AllianceName'				=> $this->allianceData['ally_name'],
				':AllianceOwnerRange'		=> $this->allianceData['ally_owner_range'],
				':AllianceImage'			=> $this->allianceData['ally_image'],
				':AllianceWeb'				=> $this->allianceData['ally_web'],
				':AllianceRequestNotAllow'	=> $this->allianceData['ally_request_notallow'],
		    	':AllianceMaxMember'        => $this->allianceData['ally_max_members'],
				':AllianceRequestMinPoints'	=> $this->allianceData['ally_request_min_points'],
				':AllianceStats'			=> $this->allianceData['ally_stats'],
				':AllianceDiplo'			=> $this->allianceData['ally_diplo'],
				':AllianceEvents'			=> $this->allianceData['ally_events'],
				':AllianceID'				=> $this->allianceData['id'],
				':text'						=> $text
			));

		} else {
			switch($textMode)
			{
				case 'internal':
					$text	= $this->allianceData['ally_text'];
					break;
				case 'apply':
					$text	= $this->allianceData['ally_request'];
					break;
				default:
					$text	= $this->allianceData['ally_description'];
					break;
			}
		}

        require_once 'includes/classes/class.FlyingFleetHandler.php';

        $available_events = array();

        foreach(array_keys(FlyingFleetHandler::$missionObjPattern) as $missionId) {
            $available_events[$missionId] = $LNG['type_mission_'.$missionId];
        }

		$this->assign(array(
			'RequestSelector'			=> array(0 => $LNG['al_requests_allowed'], 1 => $LNG['al_requests_not_allowed']),
			'YesNoSelector'				=> array(1 => $LNG['al_go_out_yes'], 0 => $LNG['al_go_out_no']),
			'textMode' 					=> $textMode,
			'text' 						=> $text,
			'ally_tag' 					=> $this->allianceData['ally_tag'],
			'ally_name'					=> $this->allianceData['ally_name'],
			'ally_web' 					=> $this->allianceData['ally_web'],
			'ally_image'				=> $this->allianceData['ally_image'],
			'ally_request_notallow' 	=> $this->allianceData['ally_request_notallow'],
			'ally_members' 				=> $this->allianceData['ally_members'],
			'ally_max_members' 			=> $this->allianceData['ally_max_members'],
			'ally_request_min_points'   => $this->allianceData['ally_request_min_points'],
			'ally_owner_range'			=> $this->allianceData['ally_owner_range'],
			'ally_stats_data'			=> $this->allianceData['ally_stats'],
			'ally_diplo_data'			=> $this->allianceData['ally_diplo'],
			'ally_events'				=> explode(',', $this->allianceData['ally_events']),
			'available_events'			=> $available_events,
		));

		$this->display('page.alliance.admin.overview.tpl');
	}

	protected function adminClose()
	{
		global $USER;
		if ($this->allianceData['ally_owner'] == $USER['id']) {
			$db = Database::get();

			//fix by hirako time to change alliance
			$sql = "UPDATE %%USERS%% SET ally_id = '0' ,  ally_date=".time()." WHERE ally_id = :AllianceID;";
			$db->update($sql, array(
				':AllianceID'	=> $this->allianceData['id']
			));

			$sql = "UPDATE %%STATPOINTS%% SET id_ally = '0' WHERE id_ally = :AllianceID;";
			$db->update($sql, array(
				':AllianceID'	=> $this->allianceData['id']
			));

			$sql = "DELETE FROM %%STATPOINTS%% WHERE id_owner = :AllianceID AND stat_type = 2;";
			$db->delete($sql, array(
				':AllianceID'	=> $this->allianceData['id']
			));

			$sql = "DELETE FROM %%ALLIANCE%% WHERE id = :AllianceID;";
			$db->delete($sql, array(
				':AllianceID'	=> $this->allianceData['id']
			));

			$sql = "DELETE FROM %%ALLIANCE_REQUEST%% WHERE allianceId = :AllianceID;";
			$db->delete($sql, array(
				':AllianceID'	=> $this->allianceData['id']
			));

			$sql = "DELETE FROM %%DIPLO%% WHERE owner_1 = :AllianceID OR owner_2 = :AllianceID;";
			$db->delete($sql, array(
				':AllianceID'	=> $this->allianceData['id']
			));
		}

		$this->redirectToHome();
	}

	protected function adminissue_send()
	{
		global $USER, $PLANET, $LNG, $UNI, $CONF;
		if (!$this->rights['BANKISSUE']){
			$this->redirectToHome();
		}

		$planetId	= HTTP::_GP('id_u',0);
		$metal 		= HTTP::_GP('resource901',0);
        $crystal 	= HTTP::_GP('resource902',0);
        $deuterium 	= HTTP::_GP('resource903',0);
		
		$sql = "SELECT isAlliancePlanet FROM %%PLANETS%% WHERE id = :planetId;";
		$targetInfoPlanet = database::get()->selectSingle($sql, array(
			':planetId' => $planetId
		));
		
		 
		if($planetId == 0 || empty($targetInfoPlanet)){
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/jc/game.php?page=alliance&mode=issue');
		}elseif($targetInfoPlanet['isAlliancePlanet'] != $this->allianceData['id']){
			$this->printMessage("This planet does not belong to the alliance planets", true, array('game.php?page=alliance&mode=issue', 2));
			die();
		}elseif($metal == 0|| $crystal == 0  ||$deuterium == 0){
			$this->printMessage("Debes ingresar recursos", true, array('game.php?page=alliance&mode=issue', 2));
			die();
		}elseif($metal < 0|| $crystal < 0  ||$deuterium < 0){
			$this->printMessage($LNG['moon_hack'], true, array('game.php?page=alliance&mode=issue', 2));
			die();
        }elseif($this->allianceData['alliance_storage_metal'] < $metal || $this->allianceData['alliance_storage_crystal'] < $crystal  || $this->allianceData['alliance_storage_deuterium'] < $deuterium){
			$this->printMessage("There is not enough resource in the bank", true, array('game.php?page=alliance&mode=issue', 2));
			die();
        }elseif($this->allianceData['alliance_storage_metal'] < $metal || $this->allianceData['alliance_storage_crystal'] < $crystal  || $this->allianceData['alliance_storage_deuterium'] < $deuterium){
			$this->printMessage("There is not enough resource in the bank", true, array('game.php?page=alliance&mode=issue', 2));
			die();
        }else{
			if($planetId == $PLANET['id']){
				$PLANET['metal'] += $metal;
				$PLANET['crystal'] += $crystal;
				$PLANET['deuterium'] += $deuterium;
			}else{
				$db	= Database::get();
				$sql = "UPDATE %%PLANETS%% SET metal = metal + :metal, crystal = crystal + :crystal, deuterium = deuterium + :deuterium WHERE id = :planetId;";
				$db->update($sql, array(
					':metal'	=> $metal,
					':crystal'	=> $crystal,
					':deuterium'=> $deuterium,
					':planetId' => $planetId
				));
			}
			
			$db	= Database::get();	
			$sql = "UPDATE %%ALLIANCE%% SET alliance_storage_metal = alliance_storage_metal - :alliance_storage_metal, alliance_storage_crystal = alliance_storage_crystal - :alliance_storage_crystal, alliance_storage_deuterium = alliance_storage_deuterium - :alliance_storage_deuterium WHERE id = :allyId;";
			$db->update($sql, array(
				':alliance_storage_metal'	=> $metal,
				':alliance_storage_crystal'	=> $crystal,
				':alliance_storage_deuterium'	=> $deuterium,
				':allyId' => $this->allianceData['id']
			));	
			
			$sql = "INSERT INTO %%STORAGELOGS%% SET allyID = :allyID, userID = :userID, planetid = :planetid, metal = :metal, crystal = :crystal, deuterium = :deuterium, time = :time, type = :type;";

			$db->insert($sql, array(
				':allyID'		=> $this->allianceData['id'],
				':userID'		=> $USER['id'],
				':planetid'		=> $planetId,
				':metal'		=> $metal,
				':crystal'		=> $crystal,
				':deuterium'	=> $deuterium,
				':time'			=> TIMESTAMP,
				':type'			=> 2
			));
			$this->printMessage("Ressource have been added to the selected alliance planet", true, array('game.php?page=alliance&mode=storage', 2));
		}
		
	}

	protected function adminTransfer()
	{
		global $USER;

		if($this->allianceData['ally_owner'] != $USER['id'])
		{
			$this->redirectToHome();
		}

		$db	= Database::get();

		$postleader = HTTP::_GP('newleader', 0);
		if (!empty($postleader))
		{	
			//fix by hirako time to change alliance
			$sql = "UPDATE %%USERS%% SET ally_date=".time()." WHERE ally_id = :AllianceID;";
			$db->update($sql, array(
				':AllianceID'	=> $this->allianceData['id']
			));
			
			$sql = "SELECT ally_rank_id FROM %%USERS%% WHERE id = :LeaderID;";
			$Rank = $db->selectSingle($sql, array(
				':LeaderID'	=> $postleader
			));

			$sql = "UPDATE %%USERS%% SET ally_rank_id = :AllyRank WHERE id = :UserID;";
			$db->update($sql, array(
				':UserID'	=> $USER['id'],
				':AllyRank' => $Rank['ally_rank_id']
			));

			$sql = "UPDATE %%USERS%% SET ally_rank_id = 0 WHERE id = :LeaderID;";
			$db->update($sql, array(
				':LeaderID'	=> $postleader
			));

			$sql = "UPDATE %%ALLIANCE%% SET ally_owner = :LeaderID WHERE id = :AllianceID;";
			$db->update($sql, array(
				':LeaderID'	    => $postleader,
				':AllianceID'   => $this->allianceData['id']
			));

			$this->redirectToHome();
		}
		else
		{
			$sql = "SELECT u.id, r.rankName, u.username FROM %%USERS%% u INNER JOIN %%ALLIANCE_RANK%% r ON r.rankID = u.ally_rank_id AND r.TRANSFER = 1 WHERE u.ally_id = :allianceId AND id != :allianceOwner;";
			$transferUserResult = $db->select($sql, array(
				':allianceOwner'    => $this->allianceData['ally_owner'],
				':allianceId'       => $this->allianceData['id']
			));

			$transferUserList	= array();

			foreach ($transferUserResult as $transferUserRow)
			{
				$transferUserList[$transferUserRow['id']]	= $transferUserRow['username']." [".$transferUserRow['rankName']."]";
			}

			$this->assign(array(
				'transferUserList'	=> $transferUserList,
			));

			$this->display('page.alliance.admin.transfer.tpl');
		}
	}

	protected function adminMangeApply()
	{
		global $LNG, $USER;
		if(!$this->rights['SEEAPPLY'] || !$this->rights['MANAGEAPPLY']) {
			$this->redirectToHome();
		}

		$db = Database::get();

		$sql = "SELECT applyID, u.username, r.time FROM %%ALLIANCE_REQUEST%% r INNER JOIN %%USERS%% u ON r.userId = u.id WHERE r.allianceId = :allianceId;";
		$applyResult = $db->select($sql, array(
			':allianceId'	=> $this->allianceData['id']
		));

		$applyList		= array();

		foreach ($applyResult as $applyRow)
		{
			$applyList[]	= array(
				'username'	=> $applyRow['username'],
				'id'		=> $applyRow['applyID'],
				'time' 		=> _date($LNG['php_tdformat'], $applyRow['time'], $USER['timezone']),
			);
		}

		$this->assign(array(
			'applyList'		=> $applyList,
		));

		$this->display('page.alliance.admin.mangeApply.tpl');
	}

	protected function adminDetailApply()
	{
		global $LNG, $USER;
		if(!$this->rights['SEEAPPLY'] || !$this->rights['MANAGEAPPLY']) {
			$this->redirectToHome();
		}

		$id    = HTTP::_GP('id', 0);

		$db = Database::get();

		$sql = 'SELECT
			r.`applyID`,
			r.`time`,
			r.`text`,
			u.`username`,
			u.`register_time`,
			u.`onlinetime`,
			u.`galaxy`,
			u.`system`,
			u.`planet`,
			CONCAT_WS(\':\', u.`galaxy`, u.`system`, u.`planet`) AS `coordinates`,
			@total_fights := u.`wons` + u.`loos` + u.`draws`,
			@total_fights_percentage := @total_fights / 100,
			@total_fights AS `total_fights`,
			u.`wons`,
			ROUND(u.`wons` / @total_fights_percentage, 2) AS `wons_percentage`,
			u.`loos`,
			ROUND(u.`loos` / @total_fights_percentage, 2) AS `loos_percentage`,
			u.`draws`,
			ROUND(u.`draws` / @total_fights_percentage, 2) AS `draws_percentage`,
			u.`kbmetal`,
			u.`kbcrystal`,
			u.`lostunits`,
			u.`desunits`,
			stat.`tech_rank`,
			stat.`tech_points`,
			stat.`build_rank`,
			stat.`build_points`,
			stat.`defs_rank`,
			stat.`defs_points`,
			stat.`fleet_rank`,
			stat.`fleet_points`,
			stat.`total_rank`,
			stat.`total_points`,
			p.`name`
		FROM
			%%ALLIANCE_REQUEST%% AS r
		LEFT JOIN
			%%USERS%% AS u ON r.userId = u.id
		INNER JOIN
			%%STATPOINTS%% AS stat
		LEFT JOIN
			%%PLANETS%% AS p ON p.id = u.id_planet
		WHERE
			applyID = :applyID;';

		$applyDetail = $db->selectSingle($sql, array(
			':applyID'	=> $id
		));

		if(empty($applyDetail)) {
			$this->printMessage($LNG['al_apply_not_exists'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=alliance&mode=admin&action=mangeApply'
			)));
		}

		require 'includes/classes/BBCode.class.php';

		$applyDetail['text']    	= BBCode::parse($applyDetail['text']);
		$applyDetail['kbmetal']    	= pretty_number($applyDetail['kbmetal']);
		$applyDetail['kbcrystal']   = pretty_number($applyDetail['kbcrystal']);
		$applyDetail['lostunits']   = pretty_number($applyDetail['lostunits']);
		$applyDetail['desunits']    = pretty_number($applyDetail['desunits']);

		$this->assign(array(
			'applyDetail'	=> $applyDetail,
			'apply_time'    => _date($LNG['php_tdformat'], $applyDetail['time'], $USER['timezone']),
			'register_time' => _date($LNG['php_tdformat'], $applyDetail['register_time'], $USER['timezone']),
			'onlinetime'    => _date($LNG['php_tdformat'], $applyDetail['onlinetime'], $USER['timezone']),
		));

		$this->display('page.alliance.admin.detailApply.tpl');
	}

	protected function adminSendAnswerToApply()
	{
		global $LNG, $USER;
		if(!$this->rights['SEEAPPLY'] || !$this->rights['MANAGEAPPLY']) {
			$this->redirectToHome();
		}

		$db = Database::get();

		$text  		= makebr(HTTP::_GP('text', '', true));
		$answer		= HTTP::_GP('answer', '');
		$applyID	= HTTP::_GP('id', 0);

		$sql = "SELECT userId FROM %%ALLIANCE_REQUEST%% WHERE applyID = :applyID;";
		$userId = $db->selectSingle($sql, array(
			':applyID'	=> $applyID
		), 'userId');

		if ($answer == 'yes')
		{
			$sql = "DELETE FROM %%ALLIANCE_REQUEST%% WHERE applyID = :applyID";
			$db->delete($sql, array(
				':applyID'	=> $applyID
			));

			$sql = "UPDATE %%USERS%% SET ally_id = :allianceId, ally_register_time = :time, ally_rank_id = 0 WHERE id = :userId;";
			$db->update($sql, array(
				':allianceId'	=> $this->allianceData['id'],
				':time'         => TIMESTAMP,
				':userId'       => $userId
			));

			$sql = "UPDATE %%STATPOINTS%% SET id_ally = :allianceId WHERE id_owner = :userId AND stat_type = 1;";
			$db->update($sql, array(
				':allianceId'	=> $this->allianceData['id'],
				':userId'       => $userId
			));

			$sql = "UPDATE %%ALLIANCE%% SET ally_members = (SELECT COUNT(*) FROM %%USERS%% WHERE ally_id = :allianceId) WHERE id = :allianceId;";
			$db->update($sql, array(
				':allianceId'	=> $this->allianceData['id'],
			));

			$text		= $LNG['al_hi_the_alliance'] . $this->allianceData['ally_name'] . $LNG['al_has_accepted'] . $text;
			$subject	= $LNG['al_you_was_acceted'] . $this->allianceData['ally_name'];
		}
		else
		{
			$sql = "DELETE FROM %%ALLIANCE_REQUEST%% WHERE applyID = :applyID";
			$db->delete($sql, array(
				':applyID'	=> $applyID
			));

			$text		= $LNG['al_hi_the_alliance'] . $this->allianceData['ally_name'] . $LNG['al_has_declined'] . $text;
			$subject	= $LNG['al_you_was_declined'] . $this->allianceData['ally_name'];
		}

		$senderName	= $LNG['al_the_alliance'] . $this->allianceData['ally_name'] . ' ['.$this->allianceData['ally_tag'].']';
		PlayerUtil::sendMessage($userId, $USER['id'], $senderName, 2, $subject, $text, TIMESTAMP);
		$this->redirectTo('game.php?page=alliance&mode=admin&action=mangeApply');
	}

	protected function adminPermissions()
	{
		if(!$this->rights['RANKS']) {
			$this->redirectToHome();
		}

		$sql = "SELECT * FROM %%ALLIANCE_RANK%% WHERE allianceId = :allianceId;";
		$rankResult = Database::get()->select($sql, array(
			':allianceId'	=> $this->allianceData['id']
		));

		$rankList	= array();
		foreach ($rankResult as $rankRow)
		{
			$rankList[$rankRow['rankID']]	= $rankRow;
		}

		$availableRanks	= array();
		foreach($this->availableRanks as $rankId => $rankName)
		{
			if($this->rights[$rankName])
			{
				$availableRanks[$rankId]	= $rankName;
			}
		}

		$this->assign(array(
			'rankList'			=> $rankList,
			'ownRights'			=> $this->rights,
			'availableRanks'	=> $availableRanks,
		));

		$this->display('page.alliance.admin.permissions.tpl');
	}

	protected function adminPermissionsSend()
	{
		global $LNG;
		if(!$this->rights['RANKS']) {
			$this->redirectToHome();
		}

		$newRank	= HTTP::_GP('newrank', array(), true);
		$delete		= HTTP::_GP('deleteRank', 0);
		$rankData	= HTTP::_GP('rank', array());

		$db = Database::get();

		if(!empty($newRank['rankName']))
		{
			if(!PlayerUtil::isNameValid($newRank['rankName']))
			{
				$this->printMessage($LNG['al_invalid_rank_name'], true, array('game.php?page=alliance&mode=admin&action=permission', 2));
			}elseif(strlen($newRank['rankName']) > 32)
			{
				$this->printMessage("The name is to long. Max 32 chars.", true, array('game.php?page=alliance&mode=admin&action=permission', 2));
			}

			$sql = 'INSERT INTO %%ALLIANCE_RANK%% SET rankName = :rankName, allianceID = :allianceID';
			$params	= array(
				':rankName'		=> $newRank['rankName'],
				':allianceID'	=> $this->allianceData['id'],
			);

			unset($newRank['rankName']);

			foreach($newRank as $key => $value)
			{
				if(isset($this->availableRanks[$key]) && $this->rights[$this->availableRanks[$key]])
				{
					$sql .= ', `'.$this->availableRanks[$key].'` = :'.$this->availableRanks[$key];
					$params[':'.$this->availableRanks[$key]]	= $value == 1 ? 1 : 0;
				}
			}

			$db->insert($sql, $params);
		}
		else
		{
			if(!empty($delete))
			{
				$sql = "DELETE FROM %%ALLIANCE_RANK%% WHERE rankID = :rankID AND allianceId = :allianceId;";
				$db->delete($sql, array(
					':allianceId'	=> $this->allianceData['id'],
					':rankID'       => $delete
				));

				$sql = "UPDATE %%USERS%% SET ally_rank_id = 0 WHERE ally_rank_id = :rankID AND ally_id = :allianceId;";
				$db->update($sql, array(
					':allianceId'	=> $this->allianceData['id'],
					':rankID'       => $delete
				));
			}
			else
			{
				foreach ($rankData as $rankId => $rowData)
				{
					$sql = 'UPDATE %%ALLIANCE_RANK%% SET rankName = :rankName';
					$params	= array(
						':rankName'		=> $rowData['rankName'],
						':allianceID'	=> $this->allianceData['id'],
						':rankId'		=> $rankId
					);

					unset($rowData['rankName']);

					foreach($this->availableRanks as $key => $value)
					{
						
							$sql .= ', `'.$this->availableRanks[$key].'` = :'.$this->availableRanks[$key];
							$params[':'.$this->availableRanks[$key]]	= (isset($rowData[$key])) ? 1 : 0;
						
					}

					$sql .= ' WHERE rankID = :rankId AND allianceID = :allianceID';

					$db->update($sql, $params);
				}
			}
		}

		$this->redirectTo('game.php?page=alliance&mode=admin&action=permissions');
	}

	protected function adminMembers()
	{
		global $USER, $LNG;
		if (!$this->rights['MANAGEUSERS']) {
			$this->redirectToHome();
		}

		$db = Database::get();

		$sql = "SELECT rankID, rankName FROM %%ALLIANCE_RANK%% WHERE allianceId = :allianceId;";
		$rankResult = $db->select($sql, array(
			':allianceId'	=> $this->allianceData['id'],
		));

		$rankList		= array($LNG['al_new_member_rank_text']);
		$rankSelectList	= $rankList;

		foreach($rankResult as $rankRow)
		{
			$hasRankRight	= true;
			foreach($this->availableRanks as $rankName)
			{
				if(!$this->rights[$rankName])
				{
					$hasRankRight = false;
					break;
				}
			}

			if($hasRankRight)
			{
				$rankSelectList[$rankRow['rankID']]	= $rankRow['rankName'];
			}

			$rankList[$rankRow['rankID']]	= $rankRow['rankName'];
		}

		$sql = "SELECT DISTINCT u.id, u.username,u.galaxy, u.system, u.planet, u.ally_register_time, u.onlinetime, u.ally_rank_id, s.total_points
		FROM %%USERS%% u
		LEFT JOIN %%STATPOINTS%% as s ON s.stat_type = '1' AND s.id_owner = u.id
		WHERE ally_id = :allianceId;";

		$memberListResult = $db->select($sql, array(
			':allianceId'	=> $this->allianceData['id'],
		));

		$memberList	= array();

		foreach ($memberListResult as $memberListRow)
		{
			if ($this->allianceData['ally_owner'] == $memberListRow['id'])
				$memberListRow['ally_rank_id'] = -1;

			$memberList[$memberListRow['id']]	= array(
				'username'		=> $memberListRow['username'],
				'galaxy'		=> $memberListRow['galaxy'],
				'system'		=> $memberListRow['system'],
				'planet'		=> $memberListRow['planet'],
				'register_time'	=> _date($LNG['php_tdformat'], $memberListRow['ally_register_time'], $USER['timezone']),
				'points'		=> $memberListRow['total_points'],
				'rankID'		=> $memberListRow['ally_rank_id'],
				'onlinetime'	=> floor((TIMESTAMP - $memberListRow['onlinetime']) / 60),
				'kickQuestion'	=> sprintf($LNG['al_kick_player'], $memberListRow['username'])
			);
		}

		$this->assign(array(
			'memberList'	 => $memberList,
			'rankList'		 => $rankList,
			'rankSelectList' => $rankSelectList,
			'founder'		 => empty($this->allianceData['ally_owner_range']) ? $LNG['al_founder_rank_text'] : $this->allianceData['ally_owner_range'],
			'al_users_list'	 => sprintf($LNG['al_users_list'], count($memberList)),
			'canKick'		 => $this->rights['KICK'],
		));

		$this->display('page.alliance.admin.members.tpl');
	}

    protected function adminRank()
    {
        global $LNG;
        if (!$this->rights['MANAGEUSERS']) {
            $this->sendJSON();
        }

		$userRanks	= HTTP::_GP('rank', array());

		$db = Database::get();

		$sql			= 'SELECT rankID, '.implode(', ', $this->availableRanks).' FROM %%ALLIANCE_RANK%% WHERE allianceID = :allianceId;';
		$rankResult		= $db->select($sql, array(
			':allianceId'	=> $this->allianceData['id']
		));
		$rankList		= array();
		$rankList[0]	= array_combine($this->availableRanks, array_fill(0, count($this->availableRanks), true));

		foreach($rankResult as $rankRow)
		{
			$hasRankRight	= true;
			foreach($this->availableRanks as $rankName)
			{
				if(!$this->rights[$rankName])
				{
					$hasRankRight = false;
					break;
				}
			}

			if($hasRankRight)
			{
				$rankList[$rankRow['rankID']]	= $rankRow;
			}
		}

		foreach($userRanks as $userId => $rankId)
		{
			if($userId == $this->allianceData['ally_owner'] || !isset($rankList[$rankId])) {
				continue;
			}

			$sql = 'UPDATE %%USERS%% SET ally_rank_id = :rankID WHERE id = :userId AND ally_id = :allianceId;';
			$db->update($sql, array(
				':allianceId'	=> $this->allianceData['id'],
				':rankID'       => (int) $rankId,
				':userId'       => (int) $userId
			));
		}

		$this->sendJSON($LNG['fl_shortcut_saved']);
	}

	protected function adminMembersKick()
	{
		if (!$this->rights['KICK']) {
			$this->redirectToHome();
		}

		$db = Database::get();

		$id	= HTTP::_GP('id', 0);

        $sql = "SELECT ally_id FROM %%USERS%% WHERE id = :id;";
        $kickUserAllianceId = $db->selectSingle($sql, array(
            ':id'	=> $id
        ), 'ally_id');

        # Check, if user is in alliance, see #205
        if(empty($kickUserAllianceId) || $kickUserAllianceId != $this->allianceData['id']) {
            $this->redirectToHome();
		}

		//fix by hirako time to change alliance
		$sql = "UPDATE %%USERS%% SET  ally_date=".time()." WHERE ally_id = :AllianceID;";
		$db->update($sql, array(
			':AllianceID'	=> $this->allianceData['id']
		));

		$sql = "UPDATE %%USERS%% SET ally_id = 0, ally_register_time = 0, ally_rank_id = 0 WHERE id = :id;";
		$db->update($sql, array(
			':id'	=> $id	
		));

		$sql = "UPDATE %%STATPOINTS%% SET id_ally = 0 WHERE id_owner = :id AND stat_type = 1;";
		$db->update($sql, array(
			':id'	=> $id
		));

		$sql = "UPDATE %%ALLIANCE%% SET ally_members = (SELECT COUNT(*) FROM %%USERS%% WHERE ally_id = :allianceId) WHERE id = :allianceId;";
		$db->update($sql, array(
			':id'	        => $id,
			':allianceId'   => $this->allianceData['id']
		));

		$this->redirectTo('game.php?page=alliance&mode=admin&action=members');
	}

	protected function adminDiplomacy()
	{
		if (!$this->rights['DIPLOMATIC']) {
			$this->redirectToHome();
		}

		$db = Database::get();

		$diplomaticList	= array(
			0 => array(
				1 => array(),
				2 => array(),
				3 => array(),
				4 => array(),
				5 => array(),
				6 => array()
			),
			1 => array(
				1 => array(),
				2 => array(),
				3 => array(),
				4 => array(),
				5 => array(),
				6 => array()
			),
			2 => array(
				1 => array(),
				2 => array(),
				3 => array(),
				4 => array(),
				5 => array(),
				6 => array()
			)
		);

		$sql = "SELECT d.id, d.level, d.accept, d.owner_1, d.owner_2, a.ally_name FROM %%DIPLO%% d
		INNER JOIN %%ALLIANCE%% a ON IF(:allianceId = d.owner_1, a.id = d.owner_2, a.id = d.owner_1)
		WHERE owner_1 = :allianceId OR owner_2 = :allianceId;";
		$diplomaticResult =  $db->select($sql, array(
			':allianceId'   => $this->allianceData['id']
		));

		foreach($diplomaticResult as $diplomaticRow) {
			$own	= $diplomaticRow['owner_1'] == $this->allianceData['id'];
			if($diplomaticRow['accept'] == 1) {
				$diplomaticList[0][$diplomaticRow['level']][$diplomaticRow['id']] = $diplomaticRow['ally_name'];
			} elseif($own) {
				$diplomaticList[2][$diplomaticRow['level']][$diplomaticRow['id']] = $diplomaticRow['ally_name'];
			} else {
				$diplomaticList[1][$diplomaticRow['level']][$diplomaticRow['id']] = $diplomaticRow['ally_name'];
			}
		}

		$this->assign(array(
			'diploList'	=> $diplomaticList,
		));

		$this->display('page.alliance.admin.diplomacy.default.tpl');
	}

	protected function adminDiplomacyAccept()
	{
		if (!$this->rights['DIPLOMATIC']) {
			$this->redirectToHome();
		}

		$db = Database::get();

		//fix by hirako
		//$sql3 = "Select level, Count(*) as c FROM uni1_diplo GROUP BY level ";
		$sql3 = "Select level, Count(*) as c FROM uni1_diplo Where (owner_1 = :allianceId OR owner_2 = :allianceId) AND id = :id AND accept = 1 GROUP BY level ";
		$pacts = $db->selectSingle($sql3, array(
			':allianceId'   => $this->allianceData['id'],
			':id'           => HTTP::_GP('id', 0),
		));
		
		if(isset($pacts)&&$pacts['c']>0&&$pacts['level']!=5){
			$this->sendJSON(array(
				'error'		=> true,
				'message'	=> "solo se puede tener un pacto de ".$LNG['al_diplo_level'][$level],
			));
		}
		
		//end fix

		$sql = "UPDATE %%DIPLO%% SET accept = 1 WHERE id = :id AND owner_2 = :allianceId;";
		$db->update($sql, array(
			':allianceId'   => $this->allianceData['id'],
			':id'           => HTTP::_GP('id', 0)
		));

		$this->redirectTo('game.php?page=alliance&mode=admin&action=diplomacy');
	}

	protected function adminDiplomacyDelete()
	{
		if (!$this->rights['DIPLOMATIC']) {
			$this->redirectToHome();
		}

		$db = Database::get();

		$sql = "DELETE FROM %%DIPLO%% WHERE id = :id AND (owner_1 = :allianceId OR owner_2 = :allianceId);";
		$db->delete($sql, array(
			':allianceId'   => $this->allianceData['id'],
			':id'           => HTTP::_GP('id', 0)
		));

		$this->redirectTo('game.php?page=alliance&mode=admin&action=diplomacy');
	}

	protected function adminDiplomacyCreate()
	{
		global $USER;
		if (!$this->rights['DIPLOMATIC']) {
			$this->redirectToHome();
		}

		$db = Database::get();

		$this->initTemplate();
		$this->setWindow('popup');

		$diplomaticMode	= HTTP::_GP('diploMode', 0);

		$sql = "SELECT ally_tag,ally_name,id FROM %%ALLIANCE%% WHERE id != :allianceId ORDER BY ally_tag ASC;";
		$diplomaticAlly = $db->select($sql, array(
			':allianceId'   => $USER['ally_id']
		));

		$AllyList = array();
		$IdList = array();
		foreach ($diplomaticAlly as $i)
		{
			$IdList[] = $i['id'];
			$AllyList[] = $i['ally_name'];
		}
		$this->assign(array(
			'diploMode'	=> $diplomaticMode,
			'AllyList'	=> $AllyList,
			'IdList'	=> $IdList,
		));

		$this->display('page.alliance.admin.diplomacy.create.tpl');
	}

	protected function adminDiplomacyCreateProcessor()
	{
		global $LNG, $USER;
		if (!$this->rights['DIPLOMATIC']) {
			$this->redirectToHome();
		}

		$db = Database::get();

		$id	= HTTP::_GP('ally_id', '', UTF8_SUPPORT);

		$sql = "SELECT id, ally_name, ally_owner, ally_tag, (SELECT level FROM %%DIPLO%% WHERE (owner_1 = :id AND owner_2 = :allianceId) OR (owner_2 = :id AND owner_1 = :allianceId)) as diplo FROM %%ALLIANCE%% WHERE ally_universe = :universe AND id = :id;";
		$targetAlliance = $db->selectSingle($sql, array(
			':allianceId'   => $USER['ally_id'],
			':id'           => $id,
			':universe'     => Universe::current()
		));

		if(empty($targetAlliance)) {
			$this->sendJSON(array(
				'error'		=> true,
				'message'	=> sprintf($LNG['al_diplo_no_alliance'], $targetAlliance['id']),
			));
		}

		if(!empty($targetAlliance['diplo'])) {
			$this->sendJSON(array(
				'error'		=> true,
				'message'	=> sprintf($LNG['al_diplo_exists'], $targetAlliance['ally_name']),
			));
		}
		if($targetAlliance['id'] == $this->allianceData['id']) {
			$this->sendJSON(array(
				'error'		=> true,
				'message'	=> $LNG['al_diplo_same_alliance'],
			));
		}

		$this->setWindow('ajax');

		$level	= HTTP::_GP('level', 0);
		$text	= HTTP::_GP('text', '', true);


		//fix by hirako
		//$sql3 = "Select level, Count(*) as c FROM uni1_diplo GROUP BY level ";
		$sql3 = "Select level, Count(*) as c FROM uni1_diplo Where ( (owner_1 = :allianceId OR owner_2 = :allianceId) OR (owner_1 = :taget_ally OR owner_2 = :taget_ally) ) AND level = :level AND accept = 1 GROUP BY level ";
		$pacts = $db->selectSingle($sql3, array(
			':allianceId'   => $USER['ally_id'],
			':level'           => $level,
			':taget_ally' =>	$targetAlliance['id'],
		));
		
		if(isset($pacts)&&$pacts['c']>0&&$level!=5){
			$this->sendJSON(array(
				'error'		=> true,
				'message'	=> "solo se puede tener un pacto de ".$LNG['al_diplo_level'][$level],
			));
		}
		
		//end fix


		if($level == 5)
		{
			PlayerUtil::sendMessage($targetAlliance['ally_owner'], $USER['id'], $LNG['al_circular_alliance'].$this->allianceData['ally_tag'], 1, $LNG['al_diplo_war'], sprintf($LNG['al_diplo_war_mes'], "[".$this->allianceData['ally_tag']."] ".$this->allianceData['ally_name'], "[".$targetAlliance['ally_tag']."] ".$targetAlliance['ally_name'], $LNG['al_diplo_level'][$level], $text), TIMESTAMP);
		}
		else
		{
			PlayerUtil::sendMessage($targetAlliance['ally_owner'], $USER['id'], $LNG['al_circular_alliance'].$this->allianceData['ally_tag'], 1, $LNG['al_diplo_war'], sprintf($LNG['al_diplo_ask_mes'], $LNG['al_diplo_level'][$level], "[".$this->allianceData['ally_tag']."] ".$this->allianceData['ally_name'], "[".$targetAlliance['ally_tag']."] ".$targetAlliance['ally_name'], $text), TIMESTAMP);
		}

		$sql = "INSERT INTO %%DIPLO%% SET owner_1 = :allianceId, owner_2 = :allianceTargetID, level	= :level, accept = 0, accept_text = :text, universe	= :universe";
		$db->insert($sql, array(
			':allianceId'   => $USER['ally_id'],
			':allianceTargetID'  => $targetAlliance['id'],
			':level'             => $level,
			':text'           => $text,
			':universe'     => Universe::current()
		));

		$this->sendJSON(array(
			'error'		=> false,
			'message'	=> $LNG['al_diplo_create_done'],
		));
	}
}
