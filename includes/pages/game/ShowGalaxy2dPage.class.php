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

require_once('includes/classes/class.Galaxy2dRows.php');

class ShowGalaxy2dPage extends AbstractGamePage
{
    public static $requireModule = MODULE_GALAXY;

	function __construct() 
	{
		parent::__construct();
	}

function showsavec()
	{

// public static $requireModule = MODULE_SAVECOOR1;

		global $USER, $PLANET, $resource, $LNG, $reslist;
		
		$sql	= 'SELECT * FROM %%SAVEDGAL%% WHERE userId = :userId;';
		$savedData	= database::get()->select($sql, array(
			':userId'	=> $USER['id']
		));
		
		$savedArray = array();
		foreach($savedData as $Data){
			$sql	= 'SELECT * FROM %%PLANETS%% WHERE galaxy = :galaxy AND system = :system AND planet = :planet AND planet_type = 1;';
			$isExistentPlanet	= database::get()->selectSingle($sql, array(
				':galaxy'	=> $Data['galaxy'],
				':system'	=> $Data['system'],
				':planet'	=> $Data['planet'],
			));
			
			$sql	= 'SELECT * FROM %%USERS%% WHERE id = :userId;';
			$isExistentPlayer	= database::get()->selectSingle($sql, array(
				':userId'	=> $isExistentPlanet['id_owner'],
			));
			
			if(empty($isExistentPlanet) || empty($isExistentPlayer)){
				$sql	= 'DELETE FROM %%SAVEDGAL%% WHERE galaxy = :galaxy AND system = :system AND planet = :planet AND userId = :userId;';
				database::get()->delete($sql, array(
					':galaxy'	=> $Data['galaxy'],
					':system'	=> $Data['system'],
					':planet'	=> $Data['planet'],
					':userId'	=> $USER['id'],
				));
				continue;
			}
			
			$savedArray[$Data['savedId']] = array(
				'name'		=> $isExistentPlanet['name'],
				'planetId'	=> $isExistentPlanet['id'],
				'image'		=> $isExistentPlanet['image'],
				'userid'	=> $isExistentPlanet['id_owner'],
				'username'	=> getUsername($isExistentPlanet['id_owner']),
				'allyname'	=> !empty($isExistentPlayer['ally_id']) ? $this->getAllianceTag($isExistentPlayer['ally_id']) : "",
				'galaxy'	=> $Data['galaxy'],
				'system'	=> $Data['system'],
				'planet'	=> $Data['planet'],
				'hasMoon'	=> $isExistentPlanet['id_luna'] != 0 ? 1 : 0,
				'debris'	=> $isExistentPlanet['der_metal'] + $isExistentPlanet['der_crystal'],
				'debrisM'	=> $isExistentPlanet['der_metal'],
				'debrisC'	=> $isExistentPlanet['der_crystal'],
			);
			
		}
		
		$this->tplObj->loadscript('galaxy.js');
        $this->assign(array(
			'savedData'			=> count($savedData),
			'savedArray'		=> $savedArray,
			'spyShips'			=> array(210 => $USER['spio_anz']),
			'maxfleetcount'		=> FleetFunctions::GetCurrentFleets($USER['id']),
			'fleetmax'			=> FleetFunctions::GetMaxFleetSlots($USER),
			'probesAval'		=> $PLANET[$resource[210]],
			'maxsaved'			=> FleetFunctions::getSaveCoordLimit($USER),
		));
		
		$this->display('page.galaxy.showsavec.tpl');
	}
	
	function delcord()
	{
		global $USER, $PLANET, $resource, $LNG, $reslist;
		
		$logId	 		= HTTP::_GP('id', 0);
		
		$sql	= 'SELECT * FROM %%SAVEDGAL%% WHERE savedId = :savedId AND userId = :userId;';
		$savedData	= database::get()->selectSingle($sql, array(
			':savedId'	=> $logId,
			':userId'	=> $USER['id']
		));
		
		if(empty($savedData)){
			echo json_encode(array("message" => "You are not the owner of this shortcut or this shortcut does not exist anymore.", "error" => true));
			die();
		}else{
			$sql	= 'DELETE FROM %%SAVEDGAL%% WHERE savedId = :savedId AND userId = :userId;';
			database::get()->delete($sql, array(
				':savedId'	=> $logId,
				':userId'	=> $USER['id'],
			));
			echo json_encode(array("message" => "The shortcut has been successfully deleted.", "error" => false));
			die();
		}
		
	}
	
	function savecord()
	{
		global $USER, $PLANET, $resource, $LNG, $reslist;

		$maxsaved = FleetFunctions::getSaveCoordLimit($USER);
		
		/* if($USER['id'] != 1){
			echo json_encode(array("message" => "The mod is under development", "error" => true));
			die();
		} */
		$sql	= 'SELECT * FROM %%SAVEDGAL%% WHERE userId = :userId;';
		$savedData	= database::get()->select($sql, array(
			':userId'	=> $USER['id']
		));
		
		$galaxy 		= HTTP::_GP('galaxy', 0);
		$system 		= HTTP::_GP('system', 0);
		$planet 		= HTTP::_GP('planet', 0);
		
		$sql	= 'SELECT * FROM %%SAVEDGAL%% WHERE userId = :userId AND galaxy = :galaxy AND system = :system AND planet = :planet;';
		$isExistent	= database::get()->selectSingle($sql, array(
			':userId'	=> $USER['id'],
			':galaxy'	=> $galaxy,
			':system'	=> $system,
			':planet'	=> $planet,
		));
		
		$sql	= 'SELECT * FROM %%PLANETS%% WHERE galaxy = :galaxy AND system = :system AND planet = :planet AND planet_type = 1;';
		$isExistentPlanet	= database::get()->selectSingle($sql, array(
			':galaxy'	=> $galaxy,
			':system'	=> $system,
			':planet'	=> $planet,
		));
		
		if(empty($isExistentPlanet)){
			echo json_encode(array("message" => "The planet has not been found. It has not been saved in the log book.", "error" => true));
		}elseif(count($savedData) == $maxsaved){
			echo json_encode(array("message" => "You can save at maximum coordinates.", "error" => true));
		}elseif(!empty($isExistent)){
			echo json_encode(array("message" => "This coordinates are already saved in your log book.", "error" => true));
		}else{
			$sql	= 'INSERT INTO %%SAVEDGAL%% SET  userId = :userId, galaxy = :galaxy, system = :system, planet = :planet;';
			database::get()->insert($sql, array(
				':userId'	=> $USER['id'],
				':galaxy'	=> $galaxy,
				':system'	=> $system,
				':planet'	=> $planet,
			));
			echo json_encode(array("message" => "The coordinates have been successfully saved.", "error" => false));
		}
	}



	public function show()
	{
		global $USER, $PLANET, $resource, $LNG, $reslist, $CONF;

		$config			= Config::get();
		$db				= Database::get();

		$action 		= HTTP::_GP('action', '');
		$galaxyLeft		= HTTP::_GP('galaxyLeft', '');
		$galaxyRight	= HTTP::_GP('galaxyRight', '');
		$systemLeft		= HTTP::_GP('systemLeft', '');
		$systemRight	= HTTP::_GP('systemRight', '');
		$galaxy			= min(max(HTTP::_GP('galaxy', (int) $PLANET['galaxy']), 1), $config->max_galaxy);
		$system			= min(max(HTTP::_GP('system', (int) $PLANET['system']), 1), $config->max_system);
		$planet			= min(max(HTTP::_GP('planet', (int) $PLANET['planet']), 1), $config->max_planets);
		$type			= HTTP::_GP('type', 1);
		$current		= HTTP::_GP('current', 0);
		
        if (!empty($galaxyLeft))
            $galaxy	= max($galaxy - 1, 1);
        elseif (!empty($galaxyRight))
            $galaxy	= min($galaxy + 1, $config->max_galaxy);

        if (!empty($systemLeft))
            $system	= max($system - 1, 1);
        elseif (!empty($systemRight))
            $system	= min($system + 1, $config->max_system);

		if ($galaxy != $PLANET['galaxy'] || $system != $PLANET['system'])
		{
			if($PLANET['deuterium'] < $config->deuterium_cost_galaxy)
			{	
				$this->printMessage($LNG['gl_no_deuterium_to_view_galaxy'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=galaxy'
				)));
			} else {
				$PLANET['deuterium']	-= $config->deuterium_cost_galaxy;
            }
		}

        $targetDefensive    = $reslist['defense'];
        $targetDefensive[]	= 502;
		$missileSelector[0]	= $LNG['gl_all_defenses'];
		
		foreach($targetDefensive as $Element)
		{	
			$missileSelector[$Element] = $LNG['tech'][$Element];
		}
		$sql	= 'SELECT total_points
		FROM %%STATPOINTS%%
		WHERE id_owner = :userId';

		$USER	+= Database::get()->selectSingle($sql, array(
			':userId'	=> $USER['id'],
		));

		$galaxyRows	= new Galaxy2dRows;
		$galaxyRows->setGalaxy($galaxy);
		$galaxyRows->setSystem($system);
		$Result	= $galaxyRows->getGalaxyData();
		require('includes/PlanetData.php');	
		/*$colony = false;
		if($PLANET[$resource[208]] > 0)
		{
			$MaxPlanets		= MaxPlanets($USER[$resource[124]], 1) + $USER['skil_max_planet'];		
			$iPlanetCount 	= $GLOBALS['DATABASE']->countquery("SELECT count(*) FROM ".PLANETS." WHERE `id_owner` = '".$USER['id']."' AND `planet_type` = '1' AND `destruyed` = '0';");
			$colony			= $MaxPlanets > $iPlanetCount ? true : false;
		}*/


		/*
		**Asteroids Galaxy and Me Asteroid colectors
		** by YamilRH
		*/

		$sql	= "SELECT * FROM %%PLANETS%% WHERE gal6mod = :gal6mod";
			$capture = $db->select($sql, array(
				':gal6mod'	=> 1
			));
		$asteroids = $db->rowCount($capture);

		

        $this->tplObj->loadscript('galaxy.js');
        $this->assign(array(
			'GalaxyRows'				=> $Result,
			'planetcount'				=> sprintf($LNG['gl_populed_planets'], Database::get()->rowCount($Result)),
			'action'					=> $action,
			'galaxy'					=> $galaxy,
			'system'					=> $system,
			'planet'					=> $planet,
			'type'						=> $type,
			'current'					=> $current,
			'maxfleetcount'				=> FleetFunctions::GetCurrentFleets($USER['id']),
			'fleetmax'					=> FleetFunctions::GetMaxFleetSlots($USER),
			'currentmip'				=> $PLANET[$resource[503]],
			'grecyclers'   				=> $PLANET[$resource[219]],
			'recyclers'   				=> $PLANET[$resource[209]],
			'spyprobes'   				=> $PLANET[$resource[210]],
			'missile_count'				=> sprintf($LNG['gl_missil_to_launch'], $PLANET[$resource[503]]),
			'spyShips'					=> array(210 => $USER['spio_anz']),
			'settings_fleetactions'		=> $USER['settings_fleetactions'],
			'current_galaxy'			=> $PLANET['galaxy'],
			'current_system'			=> $PLANET['system'],
			'current_planet'			=> $PLANET['planet'],
			'planet_type' 				=> $PLANET['planet_type'],
		        'max_planets'               => $config->max_planets,
			'missileSelector'			=> $missileSelector,
			'ShortStatus'				=> array(
				'vacation'					=> $LNG['gl_short_vacation'],
				'banned'					=> $LNG['gl_short_ban'],
				'inactive'					=> $LNG['gl_short_inactive'],
				'longinactive'				=> $LNG['gl_short_long_inactive'],
				'noob'						=> $LNG['gl_short_newbie'],
				'strong'					=> $LNG['gl_short_strong'],
				'enemy'						=> $LNG['gl_short_enemy'],
				'friend'					=> $LNG['gl_short_friend'],
				'member'					=> $LNG['gl_short_member'],
		                'rol1'                    	=> $LNG['gl_short_rol1'],
                		'rol2'                     	=> $LNG['gl_short_rol2'],
		                'rol3'                   	=> $LNG['gl_short_rol3'],
			),
			'asteroid'				=> $asteroids,
			'measteroid'				=> $USER['asteroid'],
			'pdata'                     => $Pdata,
			'Prasp'                     => $Prasp,
			'fieldfactor'               => $CONF['planet_factor'],
		));
		
		$this->display('page.galaxy2d.default.tpl');
	}
}
