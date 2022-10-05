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

function ShowSearchPage()
{
	global $LNG, $USER;
	
	if ($_GET['delete'] == 'user') {
        PlayerUtil::deletePlayer((int) $_GET['user']);
        message($LNG['se_delete_succes_p'], '?page=search&search=users&minimize=on', 2);
	} elseif ($_GET['delete'] == 'planet'){
		PlayerUtil::deletePlanet((int) $_GET['planet']);
        message($LNG['se_delete_succes_p'], '?page=search&search=planet&minimize=on', 2);
    }
	
	$SearchFile		= HTTP::_GP('search', '');
	$SearchFor		= HTTP::_GP('search_in', '');
	$SearchMethod	= HTTP::_GP('fuki', '');
	$SearchKey		= HTTP::_GP('key_user', '', UTF8_SUPPORT);
	$Page 			= HTTP::_GP('side', 0);
	$Order			= HTTP::_GP('key_order', '');
	$OrderBY		= HTTP::_GP('key_acc', '');
	$limit			= HTTP::_GP('limit', 25);

	$Selector	= array(
		'list'	=> array(
			'users'		=> $LNG['se_users'],	
			'planet'	=> $LNG['se_planets'],
			'moon'		=> $LNG['se_moons'],
			'alliance'	=> $LNG['se_allys'],
			'vacation'	=> $LNG['se_vacations'],
			'banned'	=> $LNG['se_suspended'],
			'admin'		=> $LNG['se_authlevels'],
			'inactives'	=> $LNG['se_inactives'],
			'online'	=> $LNG['online_users'],
			'p_connect'	=> $LNG['se_planets_act'],
		),
		'search'	=> array(
			'name'	=> $LNG['se_input_name'],
			'id'	=> $LNG['input_id'],
		),
		'filter'	=> array(
			'normal'	=> $LNG['se_type_all'],
			'exacto'	=> $LNG['se_type_exact'],
			'last'		=> $LNG['se_type_last'],
			'first'		=> $LNG['se_type_first'],
		),
		'order'	=> array(
			'ASC'	=> $LNG['se_input_asc'],
			'DESC'	=> $LNG['se_input_desc'],
		),
		'limit'	=> array(
			'1'		=> '1',
			'5'		=> '5',
			'10'	=> '10',
			'15'	=> '15',
			'20'	=> '20',
			'25'	=> '25',
			'50'	=> '50',
			'100'	=> '100',
			'200'	=> '200',
			'500'	=> '500',	
		)
	);
	$template	= new template();
	$template->loadscript('styles/assets/js/plugins/forms/selects/select2.min.js');
	$template->loadscript('styles/assets/js/plugins/forms/styling/uniform.min.js');
	$template->loadscript('styles/assets/js/plugins/forms/styling/switchery.min.js');
	$template->loadscript('styles/assets/js/plugins/forms/styling/switch.min.js');
	$template->loadscript('styles/assets/js/core/app.js');
	$template->loadscript('styles/assets/js/pages/form_layouts.js');
	$template->loadscript('styles/assets/js/pages/form_checkboxes_radios.js');
	
	$pageactiveshow = 'search';
	
	if (HTTP::_GP('minimize', '') == 'on' || HTTP::_GP('minimize', '') == '1')
	{
		$Minimize			= "&amp;minimize=on";
		$template->assign_vars(array(	
			'minimize'	=> 'checked = "checked"',
			'diisplaay'	=> 'style="display:none;"',
		));
	}

    $SpecialSpecify	= "";
	
	switch($SearchMethod)
	{
		case 'exacto':
			$SpecifyWhere	= "= '".$GLOBALS['DATABASE']->sql_escape($SearchKey)."'";
		break;
		case 'last':
			$SpecifyWhere	= "LIKE '".$GLOBALS['DATABASE']->sql_escape($SearchKey, true)."%'";
		break;
		case 'first':
			$SpecifyWhere	= "LIKE '%".$GLOBALS['DATABASE']->sql_escape($SearchKey, true)."'";
		break;
		default:
			$SpecifyWhere	= "LIKE '%".$GLOBALS['DATABASE']->sql_escape($SearchKey, true)."%'";
		break;
	};

	if (!empty($SearchFile))
	{
		$ArrayUsers		= array("users", "vacation", "admin", "inactives", "online");
		$ArrayPlanets	= array("planet", "moon", "p_connect");
		$ArrayBanned	= array("banned");
		$ArrayAlliance	= array("alliance");

		if (in_array($SearchFile, $ArrayUsers))
		{
			$Table			= "users";
			$NameLang		= array(
			    0 => $LNG['se_search_users'][0],
			    1 => $LNG['se_search_users'][1],
			    2 => $LNG['se_search_users'][2],
			    3 => $LNG['se_search_users'][3],
			    4 => $LNG['se_search_users'][4],
			    5 => $LNG['se_search_users'][5],
			    6 => $LNG['se_search_users'][6],
			    7 => $LNG['se_search_users'][7],
			    8 => $LNG['se_search_users'][8]
            );
			$SpecifyItems	= "id,username,email_2,onlinetime,register_time,user_lastip,authlevel,bana,urlaubs_modus";
			$SName			= $LNG['se_input_userss'];
			if ($SearchFile == "vacation"){
				$SpecialSpecify	= "AND urlaubs_modus = '1'";
				$SName			= $LNG['se_input_vacatii'];}
				
			if ($SearchFile == "online"){
				$SpecialSpecify	= "AND onlinetime >= '".(TIMESTAMP - 15 * 60)."'";
				$SName			= $LNG['se_input_connect'];}
				
			if ($SearchFile == "inactives"){
				$SpecialSpecify	= "AND onlinetime < '".(TIMESTAMP - 60 * 60 * 24 * 7)."'";
				$SName			= $LNG['se_input_inact'];}
				
			if ($SearchFile == "admin"){
				$SpecialSpecify	= "AND authlevel <= '".$USER['authlevel']."' AND authlevel > '0'";
				$SName			= $LNG['se_input_admm'];}
				
				
			$SpecialSpecify	.= " AND universe = '".Universe::getEmulated()."'";
			
			(($SearchFor == "name") ? $WhereItem = "WHERE username" : $WhereItem = "WHERE id");
			$ArrayOSec		= array("id", "username", "email_2", "onlinetime", "register_time", "user_lastip", "authlevel", "bana", "urlaubs_modus");
			$Array0SecCount	= count($ArrayOSec);

			for ($OrderNum = 0; $OrderNum < $Array0SecCount; $OrderNum++)
				$OrderBYParse[$ArrayOSec[$OrderNum]]	= $LNG['se_search_users'][$OrderNum];
		}
		
		
		elseif (in_array($SearchFile, $ArrayPlanets))
		{
			$Table			= "planets p";
			$NameLang		= array(
			    0 => $LNG['se_search_planets'][0],
			    1 => $LNG['se_search_planets'][1],
			    2 => $LNG['se_search_planets'][2],
			    3 => $LNG['se_search_planets'][3],
			    4 => $LNG['se_search_planets'][4],
			    5 => $LNG['se_search_planets'][5],
			    6 => $LNG['se_search_planets'][6],
			    7 => $LNG['se_search_planets'][7],
            );
			$SpecifyItems	= "p.id,p.name,CONCAT(u.username, ' (ID:&nbsp;', p.id_owner, ')'),p.last_update,p.galaxy,p.system,p.planet,p.id_luna";
			
			if ($SearchFile == "planet") {
				$SpecialSpecify	= "AND planet_type = '1'";
				$SName			= $LNG['se_input_planett'];
			} elseif ($SearchFile == "moon") {
				$SpecialSpecify	= "AND planet_type = '3'";
				$SName			= $LNG['se_input_moonn'];
			} elseif ($SearchFile == "p_connect") {
				$SpecialSpecify	= "AND last_update >= ".(TIMESTAMP - 60 * 60)."";
				$SName			= $LNG['se_input_act_pla'];
			}
			
			$SpecialSpecify	.= " AND p.universe = ".Universe::getEmulated();
			$WhereItem = "LEFT JOIN ".USERS." u ON u.id = p.id_owner ";
			if($SearchFor == "name") {
				$WhereItem .= "WHERE p.name";
			} else {
				$WhereItem .= "WHERE p.id";
			}
			
			$ArrayOSec		= array("id", "name", "id_owner", "id_luna", "last_update", "galaxy", "system", "planet");
			$Array0SecCount	= count($ArrayOSec);
			
			for ($OrderNum = 0; $OrderNum < $Array0SecCount; $OrderNum++)
				$OrderBYParse[$ArrayOSec[$OrderNum]]	= $LNG['se_search_planets'][$OrderNum];
		}
		
		
		elseif (in_array($SearchFile, $ArrayBanned))
		{
			$Table			= "banned";
			$NameLang		= array(
			    0 => $LNG['se_search_banned'][0],
			    1 => $LNG['se_search_banned'][1],
			    2 => $LNG['se_search_banned'][2],
			    3 => $LNG['se_search_banned'][3],
			    4 => $LNG['se_search_banned'][4],
			    5 => $LNG['se_search_banned'][5],
            );
			$SpecifyItems	= "id,who,time,longer,theme,author";
			$SName			= $LNG['se_input_susss'];
			$SpecialSpecify	= " AND universe = '".Universe::getEmulated()."'";
			
			(($SearchFor == "name") ? $WhereItem = "WHERE who" : $WhereItem = "WHERE id");
			
			
			$ArrayOSec		= array("id", "who", "time", "longer", "theme", "author");
			$Array0SecCount	= count($ArrayOSec);
			
			for ($OrderNum = 0; $OrderNum < $Array0SecCount; $OrderNum++)
				$OrderBYParse[$ArrayOSec[$OrderNum]]	= $LNG['se_search_banned'][$OrderNum];
		}
		
		
		elseif (in_array($SearchFile, $ArrayAlliance))
		{
			$Table			= "alliance";
			$NameLang		= array(
			    0 => $LNG['se_search_alliance'][0],
			    1 => $LNG['se_search_alliance'][1],
			    2 => $LNG['se_search_alliance'][2],
			    3 => $LNG['se_search_alliance'][3],
			    4 => $LNG['se_search_alliance'][4],
			    5 => $LNG['se_search_alliance'][5],
            );
			$SpecifyItems	= "id,ally_name,ally_tag,ally_owner,ally_register_time,ally_members";
			$SName			= $LNG['se_input_allyy'];
			$SpecialSpecify	= " AND ally_universe = '".Universe::getEmulated()."'";
			
			(($SearchFor == "name") ? $WhereItem = "WHERE ally_name" : $WhereItem = "WHERE id");
			
			
			$ArrayOSec		= array("id", "ally_name", "ally_tag", "ally_owner", "ally_register_time", "ally_members");
			$Array0SecCount	= count($ArrayOSec);
			
			for ($OrderNum = 0; $OrderNum < $Array0SecCount; $OrderNum++)
				$OrderBYParse[$ArrayOSec[$OrderNum]]	= $LNG['se_search_alliance'][$OrderNum];
		}
				
		$RESULT	= MyCrazyLittleSearch($SpecifyItems, $WhereItem, $SpecifyWhere, $SpecialSpecify, $Order, $OrderBY, $limit, $Table, $Page, $NameLang, $ArrayOSec, $Minimize, $SName, $SearchFile);
	}
	
	$template->assign_vars(array(	
		'Selector'				=> $Selector,
		'limit'					=> $limit,
		'search'				=> $SearchKey,
		'SearchFile'			=> $SearchFile,
		'SearchFor'				=> $SearchFor,
		'SearchMethod'			=> $SearchMethod,
		'Order'					=> $Order,
		'OrderBY'				=> $OrderBY,
		'OrderBYParse'			=> $OrderBYParse,
		'se_search'				=> $LNG['se_search'],
		'se_limit'				=> $LNG['se_limit'],
		'se_asc_desc'			=> $LNG['se_asc_desc'],
		'se_filter_title'		=> $LNG['se_filter_title'],
		'se_search_in'			=> $LNG['se_search_in'],
		'se_type_typee'			=> $LNG['se_type_typee'],
		'se_intro'				=> $LNG['se_intro'],
		'se_search_title'		=> $LNG['se_search_title'],
		'se_contrac'			=> $LNG['se_contrac'],
		'se_search_order'		=> $LNG['se_search_order'],
		'ac_minimize_maximize'	=> $LNG['ac_minimize_maximize'],
		'LIST'					=> $RESULT['LIST'],
		'PAGES'					=> $RESULT['PAGES'],
	));
	
	$template->show('SearchPage.tpl');
}

function MyCrazyLittleSearch($SpecifyItems, $WhereItem, $SpecifyWhere, $SpecialSpecify, $Order, $OrderBY, $Limit, $Table, $Page, $NameLang, $ArrayOSec, $Minimize, $SName, $SearchFile)
{
	global $USER, $LNG;
	
	$parse	= $LNG;
	
	if (!$Page) 
	{ 
		$INI = 0; 
    	$Page = 1; 
	}
	else
		$INI = ($Page - 1) * $Limit;
		
	$ArrayEx	= explode(",", str_replace("CONCAT(u.username, ' (ID:&nbsp;', p.id_owner, ')')", '', $SpecifyItems));

	if (!$Order || !in_array($Order, $ArrayOSec))
		$Order	= $ArrayEx[0];
		
	$CountArray	= count($ArrayEx);
	
	
	$QuerySearch	 = "SELECT ".$SpecifyItems." FROM ".DB_PREFIX.$Table." ";
	$QuerySearch	.= $WhereItem." ";
	$QuerySearch	.= $SpecifyWhere." ".$SpecialSpecify." ";
	$QuerySearch	.= "ORDER BY ".$Order." ".$OrderBY." ";
	$QuerySearch	.= "LIMIT ".$INI.",".$Limit;
	$FinalQuery		= $GLOBALS['DATABASE']->query($QuerySearch);
	
	$QueryCSearch	 = "SELECT COUNT(".$ArrayEx[0].") AS total FROM ".DB_PREFIX.$Table." ";
	$QueryCSearch	.= $WhereItem." ";
	$QueryCSearch	.= $SpecifyWhere." ".$SpecialSpecify." ";
	$CountQuery		= $GLOBALS['DATABASE']->getFirstRow($QueryCSearch);
	
	if ($CountQuery['total'] > 0)
	{
		$NumberOfPages = ceil($CountQuery['total'] / $Limit);
	
		$UrlForPage	= "?page=search
						&search=".$SearchFile."
						&search_in=".$_GET['search_in']."
						&fuki=".$_GET['fuki']."
						&key_user=".$_GET['key_user']."
						&key_order=".$_GET['key_order']."
						&key_acc=".$_GET['key_acc']."
						&limit=".$Limit;
						 
		if($NumberOfPages > 1)
		{
			$BeforePage	= ($Page - 1);
			$NextPage	= ($Page + 1);

			$PAGEE		= "";

			for ($i = 1; $i <= $NumberOfPages; $i++)
			{ 
				$PAGEE .= $Page == $i ? "&nbsp;".$Page."&nbsp;" : " <a href='".$UrlForPage."&amp;side=".$i.$Minimize."'>".$i."</a> ";
			}

			if(($Page - 1) > 0) 
				$BEFORE	= "<a href='".$UrlForPage."&amp;side=".$BeforePage.$Minimize."'><img src=\"./styles/resource/images/admin/arrowleft.png\" title=".$LNG['se__before']." height=10 width=14></a> ";
			else
				$BEFORE	= "";

			if(($Page + 1) <= $NumberOfPages) 
				$NEXT	= "<a href='".$UrlForPage."&amp;side=".$NextPage.$Minimize."'><img src=\"./styles/resource/images/admin/arrowright.png\" title=".$LNG['se__next']." height=10 width=14></a>";
			else
				$NEXT	= "";
		

			$Search['PAGES']	= '<tr><td colspan="3" style="color:#00CC33;border: 1px lime solid;text-align:center;">'.$BEFORE.'&nbsp;'.$PAGEE.'&nbsp;'.$NEXT.'</td></tr>';
		}
	

		$Search['LIST']	 = "<table class=\"table table-striped table-dark\">";
		$Search['LIST']	.= "<tr>";
	
		for ($i = 0; $i < $CountArray; $i++)
			$Search['LIST']	.= "<th>".$NameLang[$i]."</th>";
	
		if ($Table == "users") 
		{
			if (allowedTo('ShowAccountDataPage'))
				$Search['LIST']	.= "<th>...</th>";
		}
		
		if ($Table == "planets p")
		{				
			if (allowedTo('ShowQuickEditorPage'))
				$Search['LIST']	.= "<th>...</th>";
		}

		
		$Search['LIST']	.= "</tr>";
	
	
		while ($WhileResult	= $GLOBALS['DATABASE']->fetch_num($FinalQuery))
		{
			$Search['LIST']	 .= "<tr>";
			if ($Table == "users"){				
				$WhileResult[3] = $_GET['search'] == "online" ? pretty_time( TIMESTAMP - $WhileResult[3] ) : _date($LNG['php_tdformat'], $WhileResult[3] , $USER['timezone']);
				$WhileResult[4]	= _date($LNG['php_tdformat'], $WhileResult[4], $USER['timezone']);
				
				$WhileResult[6]	= $LNG['rank'][$WhileResult[6]];
				(($WhileResult[7] == '1')	? $WhileResult[7] = "<font color=lime>".$LNG['one_is_no'][1]."</font>" : $WhileResult[7] = $LNG['one_is_no'][0]);
				(($WhileResult[8] == '1')	? $WhileResult[8] = "<font color=lime>".$LNG['one_is_no'][1]."</font>" : $WhileResult[8] = $LNG['one_is_no'][0]);
			}
			
			if ($Table == "banned"){
				$WhileResult[2]	= _date($LNG['php_tdformat'], $WhileResult[2], $USER['timezone']);
				$WhileResult[3]	= _date($LNG['php_tdformat'], $WhileResult[3], $USER['timezone']);
			}
			
			if ($Table == "alliance")
				$WhileResult[4]	= _date($LNG['php_tdformat'], $WhileResult[4], $USER['timezone']);
				
			if ($Table == "planets p") {
				$WhileResult[3]	= pretty_time(TIMESTAMP - $WhileResult[3]);
				$WhileResult[7]	= $WhileResult[7] > 0 ? "<font color=lime>".$LNG['one_is_no'][1]."</font>" : $LNG['one_is_no'][0];
			}
			
			for ($i = 0; $i < $CountArray; $i++)
				$Search['LIST']	.= "<td>".$WhileResult[$i]."</td>";
		
		
			if ($Table == "users")
			{
				$Search['LIST']	.= "<td>";
				$Search['LIST'].='<ul class="icons-list"><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>';
				$Search['LIST'].='<ul class="dropdown-menu dropdown-menu-right">';
				if (allowedTo('ShowQuickEditorPage') && ($WhileResult[0] != ROOT_USER || $USER['id']==ROOT_USER ))
					$Search['LIST']	.= "<li><a href=\"javascript:openEdit('".$WhileResult[0]."', 'player');\"><i class='fas fa-edit'></i> ".$LNG['se_search_edit']."</a></li>";
			
				if ( $USER['authlevel'] == AUTH_ADM || ($USER['authlevel'] == AUTH_ADMINS &&  $WhileResult[6] != $LNG['rank'][3] ))
				{
					$DELETEBUTTON = $WhileResult[0] != $USER['id'] || $WhileResult[0] != ROOT_USER ? '<li><a href="?page=search&amp;delete=user&amp;user='.$WhileResult[0].'" onclick="return confirm(\''.$LNG['ul_sure_you_want_dlte'].' '.$WhileResult[1].'?\');"><i class="fas fa-times"></i>'.$LNG['button_delete'].'</a></li>' : '';
					
					$Search['LIST']	.= $DELETEBUTTON;
				}

				$Search['LIST'].='</ul></li></ul>';
				$Search['LIST']	.= "</td>";
			}
		
			if ($Table == "planets p"){
			
				$Search['LIST']	.= "<td class=\"text-center\">";

				$Search['LIST'].='<ul class="icons-list"><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>';
				$Search['LIST'].='<ul class="dropdown-menu dropdown-menu-right">';
				if (allowedTo('ShowQuickEditorPage'))
					$Search['LIST']	.= "<li><a href=\"javascript:openEdit('".$WhileResult[0]."', 'planet');\"><i class=\"fa fa-edit\"></i>".$LNG['se_search_edit']."</a></li>";
					
				if ($USER['authlevel'] == AUTH_ADM )
					$Search['LIST']	.= '<li><a href="?page=search&amp;delete=planet&amp;planet='.$WhileResult[0].'" onclick="return confirm(\''.$LNG['se_confirm_planet'].' '.$WhileResult[1].'\');"><i class="fas fa-ban"></i> '.$LNG['button_delete'].'</a></li>';
				
				$Search['LIST'].='</ul></li></ul>';
				$Search['LIST']	.= "</td>";
			}
			
			$Search['LIST']	.= "</tr>";
		}
		$Search['LIST']	.= "<tr><td colspan=\"20\" class=\"text-center\">".$LNG['se_input_hay']."<font color=lime>".$CountQuery['total']."</font>".$SName."</td></tr>";
		$Search['LIST']	.= "</table>";
	
	
		$GLOBALS['DATABASE']->free_result($FinalQuery);
		
		return $Search;
	}
	else
	{
		$Result['LIST']	 = "<br><table border='0px' style='background:url(images/Adm/blank.gif);' width='90%'>";
		$Result['LIST']	.= "<tr><td style='color:#00CC33;border: 2px red solid;' height='25px'><font color=red>".$LNG['se_no_data']."</font></td></tr>";
		$Result['LIST']	.= "</table>";
		return $Result;
	}
}
