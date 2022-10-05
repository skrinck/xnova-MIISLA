{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['home']}</span> - {$LNG['dashboard']}</h4>
						</div>

						<div class="heading-elements">
							<div class="heading-btn-group">
								<a href="admin.php" class="btn btn-link btn-float has-text"><i class="fa fa-home fa-2x text-primary"></i><span>{$LNG['home']}</span></a>
								<a href="admin.php?page=universe&sid={session_id()}" class="btn btn-link btn-float has-text"><i class="fa fa-stroopwafel fa-2x text-primary"></i><span>{$LNG['mu_universe']}</span></a>
								<a href="admin.php?page=rights&mode=rights&sid={session_id()}" class="btn btn-link btn-float has-text"><i class="fa fa-users fa-2x text-primary"></i><span>{$LNG['mu_moderation_page']}</span></a>
								<a href="admin.php?page=reset&sid={session_id()}" class="btn btn-link btn-float has-text"><i class="fa fa-undo fa-2x text-primary"></i><span>{$LNG['re_reset_universe'] }</span></a>
							</div>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="admin.php"><i class="icon-home2 position-left"></i> {$LNG['home']}</a></li>
							<li class="active">{$LNG['mu_game_info']}</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li><a href="mailto:rayco.garcia13@nauta.cu"><i class="icon-comment-discussion position-left"></i> {$LNG['ow_support']}</a></li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
<table width="60%">
    <tr>
		<td>
<pre class="left">-- Server Info --
Server Infos: {$info}
PHP-Version: {$vPHP} ({$vAPI})
JSON Verfügbar: {$json}
BCMath Verfügbar: {$bcmath}
cURL Verfügbar: {$curl}
SafeMode: {$safemode}
MemoryLimit: {$memory}
MySQL-Client-Version: {$vMySQLc}
MySQL-Server-Version: {$vMySQLs}
ErrorLog: {$errorlog} ({$errorloglines}, {$log_errors})
Timezone(PHP/CONF/USER): {$php_tz} / {$conf_tz} / {$user_tz}
Suhosin: {$suhosin}

-- Game --
Game Version: 2Moons {$vGame}
Game Addresse: http://{$root}/
Game Pfad: http://{$gameroot}/index.php

Browser: {$browser}</pre>
		</td>
    </tr>
</table>
{include file="overall_footer.tpl"}

					</div>
					<!-- /dashboard content -->

{include file="overall_footer.tpl"}