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

define('MODE', 'ADMIN');
define('DATABASE_VERSION', 'OLD');

define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');

require_once 'includes/common.php';
require_once 'includes/classes/class.Log.php';

if ($USER['authlevel'] == AUTH_USR)
{
	HTTP::redirectTo('game.php');
}

$session	= Session::create();
if($session->adminAccess != 1)
{
	include_once('includes/pages/adm/ShowLoginPage.php');
	ShowLoginPage();
	exit;
}

$uni	= HTTP::_GP('uni', 0);

if($USER['authlevel'] == AUTH_ADM && !empty($uni))
{
	Universe::setEmulated($uni);
}

$page	= HTTP::_GP('page', '');
switch($page)
{
	//------------------------------------------------------------------------------------//
	case 'usersonline':
		include_once('includes/pages/adm/ShowOnlinePage.php');
		ShowOnlinePage();
	break;
	case 'addam':
		include_once('includes/pages/adm/ShowAddamPage.php');
		ShowAddamPage();
	break;
	case 'maillist':
		include_once('includes/pages/adm/ShowMailPage.php');
		ShowMailPage();
	break;
	case 'commentlist':
		include_once('includes/pages/adm/ShowCommentsPage.php');
		ShowCommentsPage();
	break;
	case 'generalsett':
		include_once('includes/pages/adm/ShowGeneralsetPage.php');
		ShowGeneralsetPage();
	break;
	case 'premium':
		include_once('includes/pages/adm/ShowGeneralsetPage.php');
		ShowPremiumsetPage();
	break;
	case 'adsense':
		include_once('includes/pages/adm/ShowGeneralsetPage.php');
		ShowAdsensePage();
	break;
	case 'metaoption':
		include_once('includes/pages/adm/ShowGeneralsetPage.php');
		ShowMetaPage();
	break;
	case 'proxyset':
		include_once('includes/pages/adm/ShowIngamesetPage.php');
		ShowProxysetPage();
	break;
	case 'universeset':
		include_once('includes/pages/adm/ShowIngamesetPage.php');
		ShowIngamesetPage();
	break;
	case 'expeditionset':
		include_once('includes/pages/adm/ShowIngamesetPage.php');
		ShowExpeditionsetPage();
	break;
	case 'queuset':
		include_once('includes/pages/adm/ShowIngamesetPage.php');
		ShowQueusetPage();
	break;
	case 'referalset':
		include_once('includes/pages/adm/ShowIngamesetPage.php');
		ShowRefsetPage();
	break;
	case 'colonyset':
		include_once('includes/pages/adm/ShowIngamesetPage.php');
		ShowColonysetPage();
	break;
	case 'planetset':
		include_once('includes/pages/adm/ShowIngamesetPage.php');
		ShowPlanetsetPage();
	break;
	case 'debrisset':
		include_once('includes/pages/adm/ShowIngamesetPage.php');
		ShowDebrissetPage();
	break;
	case 'galaxyset':
		include_once('includes/pages/adm/ShowIngamesetPage.php');
		ShowGalaxysetPage();
	break;
	case 'noobset':
		include_once('includes/pages/adm/ShowIngamesetPage.php');
		ShowNoobsetPage();
	break;
	case 'variousset':
		include_once('includes/pages/adm/ShowIngamesetPage.php');
		ShowVarioussetPage();
	break;
	case 'playerlist':
		include_once('includes/pages/adm/ShowVariousoptPage.php');
		ShowPlayerlistPage();
	break;
	case 'planetlist':
		include_once('includes/pages/adm/ShowVariousoptPage.php');
		ShowPlanetlistPage();
	break;
	case 'planetalist':
		include_once('includes/pages/adm/ShowVariousoptPage.php');
		ShowPlanetalistPage();
	break;
	case 'moonlist':
		include_once('includes/pages/adm/ShowVariousoptPage.php');
		ShowMoonlistPage();
	break;
	case 'moonalist':
		include_once('includes/pages/adm/ShowVariousoptPage.php');
		ShowMoonalistPage();
	break;
	case 'livechecker':
		include_once('includes/pages/adm/ShowLivecheckerPage.php');
		ShowLivecheckerPage();
	break;
	case 'payarchive':
		include_once('includes/pages/adm/ShowPayinfoPage.php');
		ShowPayarchivePage();
	break;
	case 'paystatistic':
		include_once('includes/pages/adm/ShowPayinfoPage.php');
		ShowPayarchivePage();
	break;
	case 'createcampaign':
		include_once('includes/pages/adm/ShowCreatecampaignPage.php');
		ShowCreatecampaignPage();
	break;
	case 'campaignlog':
		include_once('includes/pages/adm/ShowCreatecampaignPage.php');
		ShowCreatecampaignPage();
	break;
	case 'bans':
		include_once('includes/pages/adm/ShowBanPage.php');
		ShowBanPage();
	break;
	case 'messagelist':
		include_once('includes/pages/adm/ShowMessageListPage.php');
		ShowMessageListPage();
	break;
	case 'globalmessage':
		include_once('includes/pages/adm/ShowSendMessagesPage.php');
		ShowSendMessagesPage();
	break;
	case 'fleets':
		include_once('includes/pages/adm/ShowFlyingFleetPage.php');
		ShowFlyingFleetPage();
	break;
	case 'accountdata':
		include_once('includes/pages/adm/ShowAccountDataPage.php');
		ShowAccountDataPage();
	break;
	case 'support':
		include_once('includes/pages/adm/ShowSupportPage.php');
		new ShowSupportPage();
	break;
	//------------------------------------------------------------------------------------//
	case 'logout':
		include_once('includes/pages/adm/ShowLogoutPage.php');
		ShowLogoutPage();
	break;
	case 'infos':
		include_once('includes/pages/adm/ShowInformationPage.php');
		ShowInformationPage();
	break;
	case 'rights':
		include_once('includes/pages/adm/ShowRightsPage.php');
		ShowRightsPage();
	break;
	case 'config':
		include_once('includes/pages/adm/ShowConfigBasicPage.php');
		ShowConfigBasicPage();
	break;
	case 'configuni':
		include_once('includes/pages/adm/ShowConfigUniPage.php');
		ShowConfigUniPage();
	break;
	case 'chat':
		include_once('includes/pages/adm/ShowChatConfigPage.php');
		ShowChatConfigPage();
	break;
	case 'teamspeak':
		include_once('includes/pages/adm/ShowTeamspeakPage.php');
		ShowTeamspeakPage();
	break;
	case 'facebook':
		include_once('includes/pages/adm/ShowFacebookPage.php');
		ShowFacebookPage();
	break;
	case 'module':
		include_once('includes/pages/adm/ShowModulePage.php');
		ShowModulePage();
	break;
	case 'statsconf':
		include_once('includes/pages/adm/ShowStatsPage.php');
		ShowStatsPage();
	break;
	case 'disclamer':
		include_once('includes/pages/adm/ShowDisclamerPage.php');
		ShowDisclamerPage();
	break;
	case 'create':
		include_once('includes/pages/adm/ShowCreatorPage.php');
		ShowCreatorPage();
	break;
	case 'accounteditor':
		include_once('includes/pages/adm/ShowAccountEditorPage.php');
		ShowAccountEditorPage();
	break;
	case 'active':
		include_once('includes/pages/adm/ShowActivePage.php');
		ShowActivePage();
	break;
	case 'password':
		include_once('includes/pages/adm/ShowPassEncripterPage.php');
		ShowPassEncripterPage();
	break;
	case 'search':
		include_once('includes/pages/adm/ShowSearchPage.php');
		ShowSearchPage();
	break;
	case 'qeditor':
		include_once('includes/pages/adm/ShowQuickEditorPage.php');
		ShowQuickEditorPage();
	break;
	case 'statsupdate':
		include_once('includes/pages/adm/ShowStatUpdatePage.php');
		ShowStatUpdatePage();
	break;
	case 'reset':
		include_once('includes/pages/adm/ShowResetPage.php');
		ShowResetPage();
	break;
	case 'news':
		include_once('includes/pages/adm/ShowNewsPage.php');
		ShowNewsPage();
	break;
	case 'topnav':
		include_once('includes/pages/adm/ShowTopnavPage.php');
		ShowTopnavPage();
	break;
	case 'overview':
		include_once('includes/pages/adm/ShowOverviewPage.php');
		ShowOverviewPage();
	break;
	case 'menu':
		include_once('includes/pages/adm/ShowMenuPage.php');
		ShowMenuPage();
	break;
	case 'clearcache':
		include_once('includes/pages/adm/ShowClearCachePage.php');
		ShowClearCachePage();
	break;
	case 'universe':
		include_once('includes/pages/adm/ShowUniversePage.php');
		ShowUniversePage();
	break;
	case 'multiips':
		include_once('includes/pages/adm/ShowMultiIPPage.php');
		ShowMultiIPPage();
	break;
	case 'log':
		include_once('includes/pages/adm/ShowLogPage.php');
		ShowLog();
	break;
	case 'vertify':
		include_once('includes/pages/adm/ShowVertify.php');
		ShowVertify();
	break;
	case 'cronjob':
		include_once('includes/pages/adm/ShowCronjobPage.php');
		ShowCronjob();
	break;
	case 'giveaway':
		include_once('includes/pages/adm/ShowGiveawayPage.php');
		ShowGiveaway();
	break;
	case 'voucher':
		include_once('includes/pages/adm/ShowVoucherPage.php');
		ShowVoucher();
	break;
	case 'autocomplete':
		include_once('includes/pages/adm/ShowAutoCompletePage.php');
		ShowAutoCompletePage();
	break;
	case 'dump':
		include_once('includes/pages/adm/ShowDumpPage.php');
		ShowDumpPage();
	break;
	default:
		include_once('includes/pages/adm/ShowIndexPage.php');
		ShowIndexPage();
	break;
	case 'lottery':
		include_once('includes/pages/adm/ShowLotteryPage.php');
		ShowLottery();
	break;
	case 'lotteryReg':
		include_once('includes/pages/adm/ShowLotteryPage.php');
		RegisterLottery();
	break;
	case 'configmods':
        include_once('includes/pages/adm/ShowConfigModsPage.php');
        ShowConfigModsPage();
    case 'shop':
        include_once('includes/pages/adm/ShowShopPage.php');
        ShowShopPage();
    break;
    case 'fleetlog':
		include_once('includes/pages/adm/ShowFleetLogPage.php');
		ShowFleetLogPage();
	break;
	case 'botadd':
		include_once('includes/pages/adm/ShowBotaddPage.php');
		ShowBotaddPage();
	break;
	 case 'obonus':
		include_once('includes/pages/adm/ShowOcationalBonusPage.php');
		ShowOcationalBonusPage();
	break;
	case 'tournament':
		include_once('includes/pages/adm/ShowTournamentPage.php');
		ShowTournamentPage();
	break;
	case 'configasteroid':
    	include_once('includes/pages/adm/ShowConfigAsteroidPage.php');
    	ShowConfigAsteroidPage();
	break;
	case 'multilogin':
		include_once('includes/pages/adm/ShowMultiLoginPage.php');
		ShowMultiLoginPage();
	break;
	case 'disclaimer':
		include_once('includes/pages/adm/ShowDisclaimerPage.php');
		ShowDisclaimerPage();
	break;
}
