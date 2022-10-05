<?php

/**
 *  2Moons
 *  Copyright (C) 2011 Jan Kröpke
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2009 Lucky
 * @copyright 2011 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2011-12-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

require_once 'includes/classes/cronjob/CronjobTask.interface.php';

class TournamentCronJob implements CronjobTask
{
	function run()
	{		
		if(config::get()->tourneyEnd < TIMESTAMP){
			$tourneyIds = array(1,2,3,4,5);
			foreach($tourneyIds as $Ids){
				$sql 	= "SELECT * FROM %%TOURNEYPARTICI%% WHERE tourneyJoin = :tourneyJoin AND tourneyUnits > 0 ORDER BY tourneyUnits DESC LIMIT 3;";
				$totalPlayers = database::get()->select($sql, array(
					':tourneyJoin'    => $Ids
				));
				$sql = "SELECT * FROM %%TOURNEY%% WHERE tourneyId = :tourneyId;";
				$tourneyDetail = database::get()->selectSingle($sql, array(
					':tourneyId'	=> $Ids
				));
				$sql	= 'DELETE FROM %%TOURNEYLOGS%%;';
				Database::get()->delete($sql, array());
				
				$countPrice = 0;
				$priceArray = array("0" => $tourneyDetail['priceOne'], "1" => $tourneyDetail['priceTwo'], "2" => $tourneyDetail['priceThree']);
				foreach($totalPlayers as $Winner){
					$sql 	= "UPDATE %%USERS%% SET darkmatter = darkmatter + :darkmatter WHERE id = :userId;";
					database::get()->update($sql, array(
						':darkmatter'   => $priceArray[$countPrice],
						':userId'    	=> $Winner['playerId']
					));
					$sql 	= "INSERT INTO %%TOURNEYLOGS%% SET tourneyUnits = :tourneyUnits, playerId = :playerId, joinTime = :joinTime, tourneyJoin = :tourneyJoin;";
					database::get()->insert($sql, array(
						':tourneyUnits' => $Winner['tourneyUnits'],
						':playerId'   	=> $Winner['playerId'],
						':joinTime'   	=> $Winner['joinTime'],
						':tourneyJoin'  => $Winner['tourneyJoin'],
					));
					PlayerUtil::sendMessage($Winner['playerId'], $Winner['playerId'], getUsername($Winner['playerId']), 200, "Mini Torneos", "Tu hs ganado un Mini Torneo y has recivido. ".pretty_number($priceArray[$countPrice])." darkmatter.", TIMESTAMP);
					$countPrice++;
				}
			}
			$sql	= 'DELETE FROM %%TOURNEYPARTICI%%;';
			database::get()->delete($sql, array());
			$sql	= 'DELETE FROM %%TOURNEY%%;';
			database::get()->delete($sql, array());
			//START NEW COMPETITIONS HERE
			$AlowedEvents = array(1,2,3,4,5,6,7,8,9,10);
			$totalTourney = array(1,2,3,4,5);
			$tourneyNames =	array("Alpha", "Beta", "Gamma", "Delta", "Epsilon");
			$countArray   = 0;
			$priceArray	  = array("0" => array(5000,3000,2000), "1" => array(4500,2700,1800), "2" => array(4000,2400,1600), "3" => array(3500,2100,1400), "4" => array(3000,1800,1200), "5" => array(0,0,0), "6" => array(0,0,0), "7" => array(0,0,0));
			$CountIdTour  = 0;
			foreach($totalTourney as $Tourney){
				$randTourney  = array_rand($AlowedEvents, 1) + 1;
				$RealCat	  = $randTourney - 1;
				unset($AlowedEvents[$RealCat]);
				$CountIdTour++;
				$sql 	= "INSERT INTO %%TOURNEY%% SET tourneyId = :tourneyId, tourneyName = :tourneyName, priceOne = :priceOne, priceTwo = :priceTwo, priceThree = :priceThree, tourneyEvent = :tourneyEvent;";
				database::get()->insert($sql, array(
					':tourneyId' 	=> $CountIdTour,
					':tourneyName' 	=> $tourneyNames[$countArray],
					//':priceOne'   	=> $priceArray[$randTourney][0],
					//':priceTwo'   	=> $priceArray[$randTourney][1],
					//':priceThree'  	=> $priceArray[$randTourney][2],
					':priceOne'   	=> 3000,
					':priceTwo'   	=> 2000,
					':priceThree'  	=> 1000,
					':tourneyEvent' => $randTourney,
				));
				$countArray++;
			}

			$sql	= "SELECT DISTINCT id, lang FROM %%USERS%% WHERE onlinetime > :onlinetime;";
			$activeUsers = database::get()->select($sql, array(
				':onlinetime'	=> TIMESTAMP - (20*60),
			));
			
			$langObjects	= array();
			foreach($activeUsers as $userInfo){
				
				if(!isset($langObjects[$userInfo['lang']]))
				{
					$langObjects[$userInfo['lang']]	= new Language($userInfo['lang']);
					$langObjects[$userInfo['lang']]->includeData(array('L18N', 'INGAME', 'TECH', 'CUSTOM', 'MODs'));
				}
				
				$LNG	= $langObjects[$userInfo['lang']];
				
				$sql = "INSERT INTO %%NOTIF%% SET userId = :userId, timestamp = :timestamp, noText = :noText, noImage = :noImage, isType = :isType;";
				database::get()->insert($sql, array(
					':userId'		=> $userInfo['id'],
					':timestamp'	=> TIMESTAMP,
					':noText'		=> 'Han comenzado los Mini-Torneo. ¿Qué esperas? Participa Ya!!',
					':noImage'		=> "/media/avatars/default.jpg",
					':isType'		=> 1
				));
			}

			//SET A NEW TIMER
			config::get(ROOT_UNI)->tourneyEnd	= TIMESTAMP + 56 * 3600;
			$sql	= 'UPDATE %%CONFIG%% SET `tourneyEnd` = :tourneyEnd WHERE `uni` = 1;';
			database::get()->update($sql, array(
				':tourneyEnd'	=> TIMESTAMP + 56 * 3600, 
			));	
		}
	}
}
