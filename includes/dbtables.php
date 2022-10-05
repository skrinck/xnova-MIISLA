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

define('DB_VERSION_REQUIRED', 4);
define('DB_NAME'			, $database['databasename']);
define('DB_PREFIX'			, $database['tableprefix']);

// Data Tabells
$dbTableNames	= array(
	'AKS'				=> DB_PREFIX.'aks',
	'ALLIANCE'			=> DB_PREFIX.'alliance',
	'ALLIANCEFRACTIONS'	=> DB_PREFIX.'alliance_fractions',
	'ALLIANCE_RANK'		=> DB_PREFIX.'alliance_ranks',
	'ALLIANCE_REQUEST'	=> DB_PREFIX.'alliance_request',
	'BANNED'			=> DB_PREFIX.'banned',
	'BUDDY'				=> DB_PREFIX.'buddy',
	'BUDDY_REQUEST'		=> DB_PREFIX.'buddy_request',
	'CHAT_BAN'			=> DB_PREFIX.'chat_bans',
	'CHAT_INV'			=> DB_PREFIX.'chat_invitations',
	'CHAT_MES'			=> DB_PREFIX.'chat_messages',
	'CHAT_ON'			=> DB_PREFIX.'chat_online',
	'CONFIG'			=> DB_PREFIX.'config',
	'CRONJOBS'			=> DB_PREFIX.'cronjobs',
	'CRONJOBS_LOG'		=> DB_PREFIX.'cronjobs_log',
	'DIPLO'				=> DB_PREFIX.'diplo',
	'FLEETS'			=> DB_PREFIX.'fleets',
	'FLEETS_EVENT'		=> DB_PREFIX.'fleet_event',
	'LOG'				=> DB_PREFIX.'log',
	'LOG_FLEETS'		=> DB_PREFIX.'log_fleets',
	'LOSTPASSWORD'		=> DB_PREFIX.'lostpassword',
	'NEWS'				=> DB_PREFIX.'news',
	'NOTES'				=> DB_PREFIX.'notes',
	'MESSAGES'			=> DB_PREFIX.'messages',
	'MULTI'				=> DB_PREFIX.'multi',
	'PLANETS'			=> DB_PREFIX.'planets',
	'RW'				=> DB_PREFIX.'raports',
	'RECORDS'			=> DB_PREFIX.'records',
	'SESSION'			=> DB_PREFIX.'session',
	'SHORTCUTS'			=> DB_PREFIX.'shortcuts',
	'STATPOINTS'		=> DB_PREFIX.'statpoints',
	'SYSTEM'		    => DB_PREFIX.'system',
	'TICKETS'			=> DB_PREFIX.'ticket',
	'TICKETS_ANSWER'	=> DB_PREFIX.'ticket_answer',
	'TICKETS_CATEGORY'	=> DB_PREFIX.'ticket_category',
	'TOPKB'				=> DB_PREFIX.'topkb',
	'TOPKB_USERS'		=> DB_PREFIX.'users_to_topkb',
	'USERS'				=> DB_PREFIX.'users',
	'USERS_ACS'			=> DB_PREFIX.'users_to_acs',
	'USERS_AUTH'		=> DB_PREFIX.'users_to_extauth',
	'USERS_VALID'	 	=> DB_PREFIX.'users_valid',
	'VARS'	 			=> DB_PREFIX.'vars',
	'VARS_RAPIDFIRE'	=> DB_PREFIX.'vars_rapidfire',
	'VARS_REQUIRE'	 	=> DB_PREFIX.'vars_requriements',
	'MARKET'			=> DB_PREFIX.'market',
	'LOTTERY'			=> DB_PREFIX.'lottery',
	'CONFLOTTERY'		=> DB_PREFIX.'lottery_config',
	'COMMENTSHOF'		=> DB_PREFIX.'comments',
	'PURCHASE'			=> DB_PREFIX.'purchase_logs',
	'EMAILS'			=> DB_PREFIX.'emails',
	'TRACKING'			=> DB_PREFIX.'tracking_mod',
	'NOTIF'				=> DB_PREFIX.'notifications',
	'STATHISTORY'		=> DB_PREFIX.'stathistory',
	'IPLOG'				=> DB_PREFIX.'ip_multimod',
	'AMTRACKER'			=> DB_PREFIX.'amtracker',
	'BONUS'				=> DB_PREFIX.'bonus',
	'PURCHASEB'			=> DB_PREFIX.'purchasebonus',
	'BOTS'				=> DB_PREFIX.'bots',
	'OBONUS'			=> DB_PREFIX.'ocational_bonus',
	'TOURNEY'			=> DB_PREFIX.'tourney',
	'TOURNEYLOGS'		=> DB_PREFIX.'tourney_logs',
	'TOURNEYPARTICI'	=> DB_PREFIX.'tourney_participante',
	'FLEETS_GROUP'		=> DB_PREFIX.'fleet_groups',
	'DMREFUND'			=> DB_PREFIX.'darkmatter_logs',
	'TWOA'				=> DB_PREFIX.'tournament',
	'TWOAU'				=> DB_PREFIX.'tournament_users',
	'SAVEDGAL'			=> DB_PREFIX.'saved_galaxy',
	'BLACKLIST'			=> DB_PREFIX.'blacklist',
	'TRANSSTAT'       	=> DB_PREFIX.'trans_stat',
	'ADMINLOGINS'       => DB_PREFIX.'admin_logins',
	'DISCLAIMER'       	=> DB_PREFIX.'disclaimer',
	'STORAGELOGS'		=> DB_PREFIX.'storages_logs',
	'STORAGEPERS'		=> DB_PREFIX.'storage_personal',
	'GOUVERNORS'		=> DB_PREFIX.'gouvernors',
);
// MOD-TABLES
?>
