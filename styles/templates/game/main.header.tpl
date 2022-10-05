<!DOCTYPE html>

<!--[if lt IE 7 ]> <html lang="{$lang}" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="{$lang}" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="{$lang}" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="{$lang}" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="{$lang}" class="no-js"> <!--<![endif]-->
<head>
	<title>{block name="title"} - {$uni_name} - {$game_name}{/block}</title>
	<meta name="generator" content="2Moons {$VERSION}">
	<!-- 
		This website is powered by 2Moons {$VERSION}
		2Moons is a free Space Browsergame initially created by Jan Kröpke and licensed under GNU/GPL.
		2Moons is copyright 2009-2018 of Jan Kröpke. Extensions are copyright of their respective owners.
		Information and contribution at http://2moons.de/
	-->
	{if !empty($goto)}
	<meta http-equiv="refresh" content="{$gotoinsec};URL={$goto}">
	{/if}
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">

	<link href="styles/resource/izi/css/iziToast.min.css" rel="stylesheet" type="text/css"/>
	<link href="styles/resource/fontawesome/css/all.min.css" rel="stylesheet">
	<link href="styles/resource/css/all.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="styles/resource/css/base/boilerplate.css">
	<link rel="stylesheet" type="text/css" href="styles/resource/css/ingame/main.css">
	<link rel="stylesheet" type="text/css" href="styles/resource/css/base/jquery.css">
	<link rel="stylesheet" type="text/css" href="styles/resource/css/base/jquery.fancybox.css">
	<link rel="stylesheet" type="text/css" href="styles/resource/css/base/validationEngine.jquery.css">
	<link rel="stylesheet" type="text/css" href="{$dpath}ingame.css">
	<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
	<script type="text/javascript">
	var ServerTimezoneOffset = {$Offset};
	var serverTime 	= new Date({$date.0}, {$date.1 - 1}, {$date.2}, {$date.3}, {$date.4}, {$date.5});
	var startTime	= serverTime.getTime();
	var localTime 	= serverTime;
	var localTS 	= startTime;
	var Gamename	= document.title;
	var Ready		= "{$LNG.ready}";
	var Skin		= "{$dpath}";
	var Lang		= "{$lang}";
	var head_info	= "{$LNG.fcm_info}";
	var auth		= {$authlevel|default:'0'};
	var days 		= {$LNG.week_day|json|default:'[]'} 
	var months 		= {$LNG.months|json|default:'[]'} ;
	var tdformat	= "{$LNG.js_tdformat}";
	var queryString	= "{$queryString|escape:'javascript'}";
	var isPlayerCardActive	= "{$isPlayerCardActive|json}";

	setInterval(function() {
		serverTime.setSeconds(serverTime.getSeconds()+1);
	}, 1000);
	</script>
	<!-- 
	<script src="scripts/login/jquery.js"></script>
	<script src="scripts/login/bootstrap.min.js"></script> -->
	<script type="text/javascript" src="scripts/base/jquery.min.js"></script>
	<script type="text/javascript" src="scripts/base/jquery.js"></script>
	<script type="text/javascript" src="scripts/base/jquery.ui.js"></script>
	<script type="text/javascript" src="scripts/base/jquery.cookie.js"></script>
	<script type="text/javascript" src="scripts/base/jquery.fancybox.js?"></script>
	<script type="text/javascript" src="scripts/base/jquery.validationEngine.js"></script>
	<script type="text/javascript" src="scripts/l18n/validationEngine/jquery.validationEngine-{$lang}.js"></script>
	<script type="text/javascript" src="scripts/base/tooltip.js"></script>
	<script type="text/javascript" src="scripts/game/base.js"></script>
	<script type="text/javascript" src="styles/resource/izi/js/iziToast.js"></script>
	<script type="text/javascript" src="scripts/game/json.js?{$REV}"></script>
	<script type="text/javascript" src="scripts/base/alertify.min.js?{$REV}"></script>
	{foreach item=scriptname from=$scripts}
	<script type="text/javascript" src="scripts/game/{$scriptname}.js?v={$REV}"></script>
	{/foreach}
	{block name="script"}{/block}
	<script type="text/javascript">
	$(function() {
		{$execscript}
	});

	$(document).ready(function(){
 
	$('.ir-arriba').click(function(){
		$('body, html').animate({
			scrollTop: '0px'
		}, 300);
	});
 
	$(window).scroll(function(){
		if( $(this).scrollTop() > 0 ){
			$('.ir-arriba').slideDown(300);
		} else {
			$('.ir-arriba').slideUp(300);
		}
	});
 
});
	</script>
</head>
<body id="{$smarty.get.page|htmlspecialchars|default:'overview'}" class="{$bodyclass}">
	<div id="tooltip" class="tip"></div>
