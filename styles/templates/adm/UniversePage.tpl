{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['general_setting']}</span> - {$LNG['mu_universe']}</h4>
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
							<li><a href="admin.php?page=accountdata">{$LNG['general_setting']}</a></li>
							<li>{$LNG['mu_universe']}</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li><a href="mailto:rayco.garcia13@nauta.cu"><i class="icon-comment-discussion position-left"></i> {$LNG['ow_support']}</a></li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
					<div class="panel panel-flat">
						<div class="panel-body">
							<legend class="text-semibold">
								<i class="icon-file-text2 position-left"></i>
								{$LNG['mu_universe']}
								<a class="control-arrow" data-toggle="collapse" data-target="#Frame8">
									<i class="icon-circle-down2"></i>
								</a>
							</legend>
							<div class="collapse in" id="Frame8">
								<div class="table-responsive">
									<table class="table">
										<tr>
											<th>{$LNG.uvs_id}</th>
											<th>{$LNG.uvs_name}</th>
											<th colspan="5" title="{$LNG.uvs_speeds_full}">{$LNG.uvs_speeds}</th>
											<th>{$LNG.uvs_players}</th>
											<th>{$LNG.uvs_planets}</th>
											<th>{$LNG.uvs_inactive}</th>
											<th>{$LNG.uvs_open}</th>
											<th>{$LNG.uvs_actions}</th>
										</tr>
										{foreach $uniList as $uniID => $uniRow}
										<tr style="height:23px;">
											<td>{$uniID}</td>
											<td>{$uniRow.uni_name|number}</td>
											<td>{($uniRow.game_speed / 2500)|number}</td>
											<td>{($uniRow.fleet_speed / 2500)|number}</td>
											<td>{$uniRow.resource_multiplier|number}</td>
											<td>{$uniRow.halt_speed|number}</td>
											<td>{$uniRow.energySpeed|number}</td>
											<td>{$uniRow.users_amount|number}</td>
											<td>{$uniRow.planet|number}</td>
											<td>{$uniRow.inactive|number}</td>
											<td>{if $uniRow.game_disable == 1}<span style="color:lime;">{$LNG.uvs_on}</span>{else}<span style="color:red;">{$LNG.uvs_off}</span>{/if}</td>
											<td>{if $uniRow.game_disable == 1}<a href="?page=universe&amp;action=closed&amp;uniID={$uniID}&amp;sid={$SID}&amp;reload=t"><img src="styles/resource/images/icons/closed.png" alt=""></a>{else}<a href="?page=universe&amp;action=open&amp;uniID={$uniID}&amp;sid={$SID}&amp;reload=t"><img src="styles/resource/images/icons/open.png" alt=""></a>{/if}{if $uniID != $smarty.const.ROOT_UNI}<a href="?page=universe&amp;action=delete&amp;uniID={$uniID}&amp;sid={$SID}&amp;reload=t" onclick="return confirm('{$LNG.uvs_delete}');" title="{$LNG.uvs_delete}"><img src="styles/resource/images/false.png" alt=""></a>{/if}</td>
										</tr>
										{/foreach}
										<tr><td colspan="12"><a class="btn btn-info" href="?page=universe&action=create&amp;sid={$SID}&amp;reload=t"><i class="fa fa-plus"></i> {$LNG.uvs_new}</a></td></tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
{include file="overall_footer.tpl"}