<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="admin.php?page=overview"><i class="fas fa-home"></i></a>
			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle hidden-lg hidden-sm hidden-md"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>
		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown language-switch">
					<a class="dropdown-toggle" data-toggle="dropdown">
						{$LNG->getLanguage()}
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						{foreach $LNG->getAllowedLangs() as $item}
							<li><a href="javascript:setLanguage('{$item}')" class="{$item}">{$item}</a></li>
						{/foreach}
					</ul>
				</li>
				<li class="dropdown dropdown-user" style="margin-top:3px;">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-user-circle fa-2x"></i>
						<i class="caret"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="javascript:top.location.href='admin.php?page=logout';"><i class="icon-switch2"></i> {$LNG['adm_cp_logout']}</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->
	<!-- Page container -->
	<div class="page-container">
		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main">
				<div class="sidebar-content">

					<!-- User menu -->
					<div class="sidebar-user">
						<div class="category-content">
							<div class="media">
								<a href="#" class="media-left"><img src="styles/theme/gow/img/menu-top.png" style="width:190px;height:auto" alt=""></a>
								<div class="media-body">
								</div>
							</div>
						</div>
					</div>
					<!-- /user menu -->
					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">
								<!-- Main -->
								<li class="navigation-header"><span>{$LNG['main']}</span></li>
								<li {if $pageactiveshow == "overview"} class="active"{/if}><a href="admin.php?page=overview"><i class="fas fa-home"></i> <span>{$LNG['dashboard']}</span></a></li>

								<li {if HTTP::_GP('page', "", true) == "infos"} class="active"{/if}><a href="admin.php?page=infos"> <i class="fas fa-info"></i> <span>{$LNG['mu_game_info']}</span></a></li>
								<li>
									<a href="#"><i class="fas fa-server"></i> <span>{$LNG['server_setting'] }</span></a>
									<ul>
										<li {if $pageactiveshow == "generalsett"} class="active"{/if}><a href="admin.php?page=generalsett">{$LNG['mu_general']}</a></li>
										<li {if HTTP::_GP('page', "", true) == "config"} class="active"{/if}><a href="admin.php?page=config">{$LNG['mu_settings']}</a></li>
										<li {if HTTP::_GP('page', "", true) == "proxyset"} class="active"{/if}><a href="admin.php?page=proxyset">{$LNG['mu_proxy']}</a></li>
									</ul>
								</li>

								<li>
									<a href="#"><i class="fas fa-cogs"></i> <span>{$LNG['log_ssettings']}</span></a>
									<ul>
										<li>
											<a href="#">{$LNG['ingame_setting']}</a>
											<ul>
												<li{if HTTP::_GP('page', "", true) == "configuni"} class="active"{/if}><a href="admin.php?page=configuni">{$LNG['universe_config_cmplete']}</a></li>
												<li{if HTTP::_GP('page', "", true) == "universeset"} class="active"{/if}><a href="admin.php?page=universeset">{$LNG['log_usettings']}</a></li>
												<li{if $pageactiveshow == "queuset"} class="active"{/if}><a href="admin.php?page=queuset">{$LNG['se_buildlist']}</a></li>
												<li{if $pageactiveshow == "colonyset"} class="active"{/if}><a href="admin.php?page=colonyset">{$LNG['se_server_colonisation_config']}</a></li>
												<li{if $pageactiveshow == "planetset"} class="active"{/if}><a href="admin.php?page=planetset">{$LNG['mu_planets_options']}</a></li>
												<li{if $pageactiveshow == "debrisset"} class="active"{/if}><a href="admin.php?page=debrisset">{$LNG['se_debris']}</a></li>
												<li{if $pageactiveshow == "galaxyset"} class="active"{/if}><a href="admin.php?page=galaxyset">{$LNG['se_galaxy_settings']}</a></li>
												<li{if $pageactiveshow == "chat"} class="active"{/if}><a href="admin.php?page=chat">{$LNG['mu_chat']}</a></li>
											</ul>
										</li>
								
										<li{if $pageactiveshow == "module"} class="active"{/if}><a href="admin.php?page=module">{$LNG['mu_module_setting']}</a></li>
										<li{if $pageactiveshow == "statsconf"} class="active"{/if}><a href="admin.php?page=statsconf">{$LNG['log_statsettings']}</a></li>
										<li{if $pageactiveshow == "cronjob"} class="active"{/if}><a href="admin.php?page=cronjob">{$LNG['mu_cronjob']}</a></li>
										<!--<li><a href="paiement_settings.php">Paiement Settings</a></li>-->
									</ul>
									<!-- Mods Añadidos -->
									<li>
										<a href="#"><i class="fas fa-server"></i> <span>{$LNG['mu_settings_mod'] }</span></a>
										<ul>
											<li{if HTTP::_GP('page', "", true) == "giveaway"} class="active"{/if}><a href="admin.php?page=giveaway"><i class="fas fa-gift"></i> <span>{$LNG['mu_giveaway']}</span></a></li>

											<li{if HTTP::_GP('page', "", true) == "lottery"} class="active"{/if}><a href="admin.php?page=lottery"><i class="fas fa-money-bill"></i> <span>{$LNG['mu_lottery']}</span></a></li>
											
											<li{if HTTP::_GP('page', "", true) == "configmods"} class="active"{/if}><a href="admin.php?page=configmods">{$LNG['mu_configmods']}</a></li>
											<li{if HTTP::_GP('page', "", true) == "botadd"} class="active"{/if}><a href="admin.php?page=botadd"><i class="fas fa-users"></i> <span>{$LNG['mu_botadd']}</span></a></li>
											<li{if HTTP::_GP('page', "", true) == "obonus"} class="active"{/if}><a href="admin.php?page=obonus"><i class="fas fa-user-clock"></i> <span>{$LNG['mu_obonus']}</span></a></li>
											<li{if HTTP::_GP('page', "", true) == "tournament"} class="active"{/if}><a href="admin.php?page=tournament"><i class="fas fa-trophy"></i> <span>{$LNG['mu_woa']}</span></a></li>
											<li{if HTTP::_GP('page', "", true) == "configasteroid"} class="active"{/if}><a href="admin.php?page=configasteroid"><i class="fas fa-sync"></i> <span>{$LNG['mu_asteroid']}</span></a></li>
										</ul>
									</li>
									<!-- /Mods Añadidos -->
								</li>

								<li {if $pageactiveshow == "disclaimer"} class="active"{/if}><a href="admin.php?page=disclaimer"><i class="fas fa-home"></i> <span>{$LNG['mu_disclaimer']}</span></a></li>
								<!-- /main -->
								<!--Forms -->
								<li class="navigation-header"><span>{$LNG['mu_users_settings']}</span></li>

								<li{if HTTP::_GP('page', "", true) == "usersonline"} class="active"{/if}><a href="admin.php?page=usersonline"><i class="fas fa-users"></i> <span>{$LNG['mu_connected']}</span></a></li>
								
								<li{if HTTP::_GP('page', "", true) == "fleets"} class="active"{/if}><a href="admin.php?page=fleets"><i class="fas fa-fighter-jet"></i> <span>{$LNG['mu_flying_fleets']}</span></a></li>
								<li{if HTTP::_GP('page', "", true) == "active"} class="active"{/if}><a href="?page=active" ><i class="fas fa-user-check"></i><span>{$LNG.mu_vaild_users}</span></a></li>

								<li{if HTTP::_GP('page', "", true) == "create"} class="active"{/if}><a href="admin.php?page=create"><i class="fas fa-user-plus"></i> <span>{$LNG['new_creator_title']}</span></a></li>
								<li{if HTTP::_GP('page', "", true) == "accounteditor"} class="active"{/if}><a href="admin.php?page=accounteditor"><i class="fas fa-user-edit"></i> <span>{$LNG['ad_editor_title']}</span></a></li>
								<li{if HTTP::_GP('page', "", true) == "bans"} class="active"{/if}><a href="admin.php?page=bans"><i class="icon-user-block"></i> <span>{$LNG['mu_ban_options']}</span></a></li>
								
								
								<li class="navigation-header"><span>{$LNG['se_search']}</span> </li>
								<li{if $pageactiveshow == "search"} class="active"{/if}><a href="admin.php?page=search"><i class="fas fa-users"></i> <span>{$LNG['se_search_title']}</span></a></li>

								<li{if $pageactiveshow == "accountdata"} class="active"{/if}><a href="admin.php?page=accountdata"><i class="fas fa-info"></i> <span>{$LNG['mu_info_account_page']}</span></a></li>
								<li>
									<a href="#"><i class="fas fa-list"></i> <span>{$LNG['various_list']}</span></a>
									<ul>
										<li{if $pageactiveshow == "playerlist"} class="active"{/if}><a href="admin.php?page=search&search=users&minimize=on"><span>{$LNG['mu_user_list']}</span></a></li>
										<li{if $pageactiveshow == "planetlist"} class="active"{/if}><a href="admin.php?page=search&search=planet&minimize=on"><span>{$LNG['mu_planet_list'] }</span></a></li>
										<li{if $pageactiveshow == "planetalist"} class="active"{/if}><a href="admin.php?page=search&search=p_connect&minimize=on"><span>{$LNG['mu_active_planets']}</span></a></li>
										<li{if $pageactiveshow == "moonlist"} class="active"{/if}><a href="admin.php?page=search&search=moon&minimize=on"><span>{$LNG['mu_moon_list']}</span></a></li>
										
										<li{if $pageactiveshow == "maillist"} class="active"{/if}><a href="admin.php?page=maillist"><span>{$LNG.mail_list}</span></a></li>

										<li{if HTTP::_GP('page', "", true) == "messagelist"} class="active"{/if}><a href="admin.php?page=messagelist"><span>{$LNG['mu_mess_list']}</span></a></li>
										
										<li{if $pageactiveshow == "commentlist"} class="active"{/if}><a href="admin.php?page=commentlist"><span>{$LNG.mu_hof_comments}</span></a></li>
									</ul>
								</li>								
								
								<li class="navigation-header"><span>{$LNG['mu_utility']}</span></li>

								<li{if HTTP::_GP('page', "", true) == "news"} class="active"{/if}><a href="admin.php?page=news"><i class="fas fa-newspaper"></i> <span>{$LNG['mu_news']}</span></a></li>
								
								<li{if HTTP::_GP('page', "", true) == "globalmessage"} class="active"{/if}><a href="admin.php?page=globalmessage"><i class="fas fa-comments"></i> <span>{$LNG['mu_global_message']}</span></a></li>

								<li{if HTTP::_GP('page', "", true) == "support"} class="active"{/if}><a href="admin.php?page=support"><i class="fas fa-life-ring"></i> <span>{$LNG['ti_header']}</span></a></li>
									
								<li>
									<a href="#"><i class="fas fa-search"></i> <span>{$LNG['mu_logs']}</span></a>
									<ul>
										<li{if $pageactiveshow == "Players_Logs"} class="active"{/if}><a href="admin.php?page=log&type=player"><span>{$LNG['log_player']}</span></a></li>
										<li{if $pageactiveshow == "Planets_Logs"} class="active"{/if}><a href="admin.php?page=log&type=planet"><span>{$LNG['log_planet']}</span></a></li>
										<li{if $pageactiveshow == "Settings_Logs"} class="active"{/if}><a href="admin.php?page=log&type=settings"><span>{$LNG['log_settings']}</span></a></li>
										<li{if $pageactiveshow == "Present_Logs"} class="active"{/if}><a href="admin.php?page=log&type=present"><span>{$LNG['log_present']}</span></a></li>
										<li{if $pageactiveshow == "campaign"} class="active"{/if}><a href="admin.php?page=log&type=campaign"><span>{$LNG['log_campaign']}</span></a></li>
									</ul>
								</li>

							<!-- herramientas navigation -->
							<li class="navigation-header"><span>{$LNG['mu_tools']}</span> </li>

								

								<li{if HTTP::_GP('page', "", true) == "dump"} class="active"{/if}><a href="admin.php?page=dump"><i class="fas fa-database"></i> <span>{$LNG['mu_dump']}</span></a></li>

								<li{if HTTP::_GP('page', "", true) == "statsupdate"} class="active"{/if}><a href="admin.php?page=statsupdate"><i class="fas fa-chart-bar"></i> <span>{$LNG['mu_manual_points_update']}</span></a></li>

								<li{if HTTP::_GP('page', "", true) == "clearcache"} class="active"{/if}><a href="admin.php?page=clearcache"><i class="fas fa-history"></i> <span>{$LNG['mu_clear_cache']}</span></a></li>

								<li>
									<a href="#"><i class="fas fa-list"></i> <span>{$LNG['log_menu']}</span></a>
									<ul>
										<li{if HTTP::_GP('page', "", true) == "shop"} class="active"{/if}><a href="admin.php?page=shop	"> <span>{$LNG['mu_shop']}</span></a></li>

										<li{if $pageactiveshow == "multiips"} class="active"{/if}><a href="admin.php?page=multiips"><span>{$LNG['mu_multiip_page']}</span></a></li>

										<li{if $pageactiveshow == "fleetlog"} class="active"{/if}><a href="admin.php?page=fleetlog"><span>{$LNG['mu_log_fleetlog']}</span></a></li>

										<li{if $pageactiveshow == "multilogin"} class="active"{/if}><a href="admin.php?page=multilogin"><span>{$LNG['mu_multilogin']}</span></a></li>
									</ul>
								</li>
							</ul>
							<!-- /navigation-accordion -->
						</div>
					</div>
					<!-- /main navigation -->
				</div>
			</div>
			<!-- /main sidebar -->
