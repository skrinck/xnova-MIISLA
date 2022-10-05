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

class ConsejoCronjob implements CronjobTask
{
	
	function run()
	{		
		//$consejos = array("".$LNG['adsense_cron']."","".$LNG['adsense_cron']."","".$LNG['adsense_cron']."", 
		);
		

		$langObjects	= array();
		
		$sql	= "SELECT DISTINCT id, lang FROM %%USERS%%";
		$consejo = database::get()->select($sql, array());

		
		foreach($consejo as $userInfo){
			if(!isset($langObjects[$userInfo['lang']]))
			{
				$langObjects[$userInfo['lang']]	= new Language($userInfo['lang']);
				$langObjects[$userInfo['lang']]->includeData(array('L18N', 'INGAME', 'TECH', 'CUSTOM', 'MODs'));
			}
			$LNG	= $langObjects[$userInfo['lang']];

			$Message1 = sprintf($LNG['consejo_'.mt_rand(1,4)]);
			$From    	= '<span style="color:#773399">System</span>';
			$Subject 	= '<span style="color:#773399">Consejos</span>';
			$message = '<span style="color:#773399">'.$Message1.'</span>';
			PlayerUtil::sendMessage($userInfo['id'], 0, $From, 4, $Subject, $message, TIMESTAMP, NULL, 1, Universe::getEmulated());
		}		
	}
}