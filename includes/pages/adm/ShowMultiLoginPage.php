<?php
if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");
function ShowMultiLoginPage()
{
	global $LNG, $USER;
	
	$template	= new template();	
	$template->loadscript('styles/assets/js/plugins/tables/datatables/datatables.min.js');	
	$template->loadscript('styles/assets/js/plugins/forms/selects/select2.min.js');	
	$template->loadscript('styles/assets/js/core/app.js');		
	$template->loadscript('styles/assets/js/pages/datatables_advanced.js');
	$template->assign_vars(array(	
		
	));
	$MultiLoginList	= array();
	/*$QuerySearch	= $GLOBALS['DATABASE']->query("SELECT id,username,email_2,onlinetime,register_time,user_lastip,authlevel,bana,urlaubs_modus FROM ".IPLOG." 
		WHERE onlinetime >= '".(TIMESTAMP - 15 * 60)."' AND universe = ".Universe::getEmulated()." ORDER BY ".$Order." ".$OrderBY.";");*/
	//$QuerySearch	= $GLOBALS['DATABASE']->query("SELECT userId,nickname,ipadress,opsystem,isp,proxies,isValid,timestamp FROM ".IPLOG.";");
	$QuerySearch	= $GLOBALS['DATABASE']->query("SELECT * FROM ".IPLOG.";");
	//while ($WhileResult	= $GLOBALS['DATABASE']->fetch_array($QuerySearch)){
	while($WhileResult = $GLOBALS['DATABASE']->fetch_array($QuerySearch)){
		$MultiLoginList[]	= array(
			'userId'			=> $WhileResult['userId'],
			'nickname'			=> $WhileResult['nickname'],
			'ipadress'			=> $WhileResult['ipadress'],
			'opsystem'			=> $WhileResult['opsystem'],
			'isp'				=> $WhileResult['isp'],
			'proxies'			=> $WhileResult['proxies'],
			'isValid'			=> $WhileResult['isValid'],
			'timestamp'			=> _date($LNG['php_tdformat'], $WhileResult['timestamp'] , $USER['timezone']),
		);	
	}
	$template->assign_vars(array(	
		'MultiLoginList'			=> $MultiLoginList,
		//'pageactiveshow'	=> HTTP::_GP('page', "", true),
	));
	$template->show('MultiLogin.tpl');
}
