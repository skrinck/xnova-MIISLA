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

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");

function ShowDisclaimerPage(){
	global $LNG, $USER;

	if($_GET['action'] == 'send') {
		$edit_id 	= HTTP::_GP('id', 0);
		//$title 		= $GLOBALS['DATABASE']->sql_escape(HTTP::_GP('title', '', true));
		$user 		= $GLOBALS['DATABASE']->sql_escape(HTTP::_GP('user', '', true));
		$rank 		= $GLOBALS['DATABASE']->sql_escape(HTTP::_GP('rank', '', true));
		$address 		= $GLOBALS['DATABASE']->sql_escape(HTTP::_GP('address', '', true));
		$email 		= $GLOBALS['DATABASE']->sql_escape(HTTP::_GP('email', '', true));
		$phone 		= $GLOBALS['DATABASE']->sql_escape(HTTP::_GP('phone', '', true));
		$text 		= $GLOBALS['DATABASE']->sql_escape(HTTP::_GP('text', '', true));
		$query		= ($_GET['mode'] == 2) ? "INSERT INTO ".DISCLAIMER." (`id` ,`user` ,`rank` ,`address` ,`email` ,`phone` ,`text`) VALUES ( NULL , '".$user."', '".$rank."', '".$address."', '".$email."', '".$phone."', '".$text."');" : "UPDATE ".DISCLAIMER."  `user` = '".$user."', `rank` = '".$rank."', `address` = '".$address."', `email` = '".$email."', `phone` = '".$phone."',`text` = '".$text."'  WHERE `id` = '".$edit_id."' LIMIT 1;";
		
		$GLOBALS['DATABASE']->query($query);
	} elseif($_GET['action'] == 'delete' && isset($_GET['id'])) {
		$GLOBALS['DATABASE']->query("DELETE FROM ".DISCLAIMER." WHERE `id` = '".HTTP::_GP('id', 0)."';");
	}

	$query = $GLOBALS['DATABASE']->query("SELECT * FROM ".DISCLAIMER." ORDER BY id ASC");

	while ($u = $GLOBALS['DATABASE']->fetch_array($query)) {
		$DisclaimerList[]	= array(
			'id'		=> $u['id'],
			'user'		=> $u['user'],
			'rank'		=> $u['rank'],
			'address'	=> $u['address'],
			'email'		=> $u['email'],
			'phone'		=> $u['phone'],
			'text'		=> $u['text'],
			'confirm'	=> sprintf($LNG['ds_confirm'], $u['user']),
		);
	}
	
	$template	= new template();


	if($_GET['action'] == 'edit' && isset($_GET['id'])) {
		$disclaimer = $GLOBALS['DATABASE']->getFirstRow("SELECT id, user, rank, address, email, phone, text FROM ".DISCLAIMER." WHERE id = '".$GLOBALS['DATABASE']->sql_escape($_GET['id'])."';");
		$template->assign_vars(array(	
			'mode'					=> 1,
			'disclaimer_id'			=> $disclaimer['id'],
			'disclaimer_user'		=> $disclaimer['user'],
			'disclaimer_rank'		=> $disclaimer['rank'],
			'disclaimer_address'	=> $disclaimer['address'],
			'disclaimer_email'		=> $disclaimer['email'],
			'disclaimer_phone'		=> $disclaimer['phone'],
			'disclaimer_text'		=> $disclaimer['text'],
		));
	} elseif($_GET['action'] == 'create') {
		$template->assign_vars(array(	
			'mode'			=> 2,
			'ds_head'		=> $LNG['ds_head_create'],
		));
	}
	$template->loadscript('styles/assets/js/plugins/tables/datatables/datatables.min.js');	
	$template->loadscript('styles/assets/js/plugins/forms/selects/select2.min.js');	
	$template->loadscript('styles/assets/js/core/app.js');		
	$template->loadscript('styles/assets/js/pages/datatables_advanced.js');
	
	$template->assign_vars(array(	
		'DisclaimerList'		=> $DisclaimerList,
		'button_submit'			=> $LNG['button_submit'],
		'ds_total' 				=> sprintf($LNG['ds_total'], is_array($DisclaimerList) ? count($DisclaimerList) : 0),
		'ds_id'					=> $LNG['ds_id'],
		'ds_user'				=> $LNG['ds_user'],
		'ds_rank'				=> $LNG['ds_rank'],
		'ds_address'			=> $LNG['ds_address'],
		'ds_email'				=> $LNG['ds_email'],
		'ds_phone'				=> $LNG['ds_phone'],
		'ds_text'				=> $LNG['ds_text'],
		'ds_create'				=> $LNG['ds_create'],
	));
	
	$template->show('DisclaimerPage.tpl');
}