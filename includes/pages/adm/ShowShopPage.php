<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
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
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");
		
function ShowShopPage()
{
		global $USER, $LNG, $resource;

		$action		= HTTP::_GP('action', '');
		$id		= HTTP::_GP('id', '');
		$extra		= HTTP::_GP('extra', 0);

		$db 			= Database::get();

		$message = array();

		if($action && $id)
		{
			$sql = 'SELECT p.*,b.price,b.premium,b.resource,b.coin,u.id as iduser FROM %%PURCHASEB%% p,%%BONUS%% b,%%USERS%% u WHERE p.user_id = u.id AND p.bono_id = b.id  AND p.id = :id';
			$bono = $db->selectSingle($sql,array(
				':id' => $id
			));

			if($action === 'aprove')
			{
				if(!$bono['concluido'])
				{
					$r = $resource[$bono['resource']];
					$sql = "UPDATE %%USERS%% SET ".$r." = ".$r."+:value WHERE id = :id";
					$db->update($sql, array(
							':value'	=>floatval($bono['premium'])+floatval($extra),
							':id'	=> $bono['iduser']					
					));

					$sql = "UPDATE %%PURCHASEB%% SET concluido = :value WHERE id = :id";
					$db->update($sql, array(
							':value' => 1,
							':id'	=> $id					
					));

					/*$Message.=' MO';
					$From    	= '<span style="color:#666600">System</span>';
					$pmSubject 	= '<span style="color:#666600">Rifa</span>';
					$pmMessage 	= '<span style="color:#666600">'.$Message.'</span>';
					//$USERS		= $GLOBALS['DATABASE']->query("SELECT `id`, `username` FROM ".USERS." WHERE `universe` = '".Universe::getEmulated()."';");
					$USERS = 'SELECT p.*,b.price,b.premium,b.resource,b.coin,u.id as iduser FROM %%PURCHASEB%% p,%%BONUS%% b,%%USERS%% u WHERE p.user_id = u.id AND p.bono_id = b.id  AND p.id = :id';
						$ubono = $db->selectSingle($USERS,array(
							':id' => $id
						));
					while($UserData = $GLOBALS['DATABASE']->fetch_array($ubono))
					{
						$sendMessage = str_replace('{USERNAME}', $UserData['username'], $pmMessage);
						PlayerUtil::sendMessage($UserData['iduser'], 0, $From, 200, $pmSubject, $sendMessage, TIMESTAMP, NULL, 1, Universe::getEmulated());
					}*/
				}
				else
				{
					echo 'Lo siento ese pago ya está concluido';
					exit;
				}

			}
			else if($action === 'denied' )
			{
				$sql = "DELETE FROM %%PURCHASEB%% WHERE id = :id";
				$db->delete($sql,array(
					':id'=>$id
				));
			}

			HTTP::redirectTo('admin.php?page=shop');

		}

		$sql = 'SELECT p.*,b.price,b.premium,b.title,b.coin,u.username, u.email_2 FROM %%PURCHASEB%% p,%%BONUS%% b,%%USERS%% u WHERE  p.user_id = u.id AND p.bono_id = b.id  ORDER BY p.concluido ASC, p.fecha ASC';
		$compras = $db->select($sql);
// echo json_encode($compras);exit;
		$tplObj		= new template();
		$tplObj->loadscript('styles/assets/js/core/app.js');	
		$tplObj->loadscript('styles/assets/js/plugins/tables/datatables/datatables.min.js');	
		$tplObj->loadscript('styles/assets/js/plugins/forms/selects/select2.min.js');	
		$tplObj->loadscript('styles/assets/js/pages/datatables_advanced.js');	
		$tplObj->assign_vars(array(
			'compras'		=> $compras,
			'mensaje'		=>$message
		));
		
		$tplObj->show('Shopping.tpl');	
}