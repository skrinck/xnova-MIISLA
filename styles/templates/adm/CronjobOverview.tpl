{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['general_setting']}</span> - {$LNG['mu_cronjob']}</h4>
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
							<li><a href="admin.php?page=cronjob">{$LNG['general_setting']}</a></li>
							<li class="active">{$LNG['mu_cronjob']}</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li><a href="mailto:rayco.garcia13@nauta.cu"><i class="icon-comment-discussion position-left"></i> {$LNG['ow_support']}</a></li>
						</ul>
					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">
							<!-- Advanced legend -->
								<div class="panel panel-flat">
									<div class="panel-body">
										<fieldset>
											<legend class="text-semibold">
												<i class="icon-file-text2 position-left"></i>
												{$LNG['mu_cronjob']}
												<a class="control-arrow" data-toggle="collapse" data-target="#Frame8">
													<i class="icon-circle-down2"></i>
												</a>
											</legend>
											<div class="collapse in" id="Frame8">
											<div class="table-responsive">
												<table style="table-layout:fixed;width:100%;border-collapse:collapse" class="table table-bordered table-hover datatable-highlight">
													<thead>
														<tr>
															<th>{$LNG.cronjob_id}</th>
															<th>{$LNG.cronjob_name}</th>
															<th>{$LNG.cronjob_min}</th>
															<th>{$LNG.cronjob_hours}</th>
															<th>{$LNG.cronjob_dom}</th>
															<th>{$LNG.cronjob_month}</th>
															<th>{$LNG.cronjob_dow}</th>
															<th>{$LNG.cronjob_class}</th>
															<th>{$LNG.cronjob_nextTime}</th>
															<th>{$LNG.cronjob_inActive}</th>
															<th>{$LNG.cronjob_lock}</th>															<th class="text-center">Actions</th>
														</tr>
													</thead>
													<tbody>
														{foreach item=CronjobInfo from=$CronjobArray}
														<tr>
															<td class="td">{$CronjobInfo.id}</td>
															<td class="td">{if isset($LNG.cronName[$CronjobInfo.name])}{$LNG.cronName[$CronjobInfo.name]}{else}{$CronjobInfo.name}{/if}</td>
															<td>{$CronjobInfo.min}</td>
															<td>{$CronjobInfo.hours}</td>
															<td>{$CronjobInfo.dom}</td>
															<td>{if $CronjobInfo.month == '*'}{$CronjobInfo.month}{else}{foreach item=month from=$CronjobInfo.month}{$LNG.months.{$month-1}}{/foreach}{/if}</td>
															<td>{if $CronjobInfo.dow == '*'}{$CronjobInfo.dow}{else}{foreach item=d from=$CronjobInfo.dow}{$LNG.week_day.{$d}} {/foreach}{/if}</td>
															<td class="td">{$CronjobInfo.class}</td>
															<td class="td">{if $CronjobInfo.isActive}{date($LNG.php_tdformat, $CronjobInfo.nextTime)}{else}-{/if}</td>
															<td class="td">{if $CronjobInfo.isActive}<a href="admin.php?page=cronjob&amp;id={$CronjobInfo.id}&amp;active=0"><span class="label label-success">Active</span></a>{else}<a href="admin.php?page=cronjob&amp;id={$CronjobInfo.id}&amp;active=1"><span class="label label-danger">Not active</span></a>{/if}</td>
															<td class="td">{if $CronjobInfo.lock}<a href="admin.php?page=cronjob&amp;id={$CronjobInfo.id}&amp;lock=0"><span class="label label-danger">Locked</span></a>{else}<a href="admin.php?page=cronjob&amp;id={$CronjobInfo.id}&amp;lock=1"><span class="label label-success">Active</span></a>{/if}</td>
															<td class="text-center">
																<ul class="icons-list">
																	<li class="dropdown">
																		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
																			<i class="icon-menu9"></i>
																		</a>

																		<ul class="dropdown-menu dropdown-menu-right">
																			<li><a href="admin.php?page=cronjob&detail={$CronjobInfo.id}"><i class="icon-pencil5"></i> Edit Cron</a></li>
																			<li><a href="admin.php?page=cronjob&delete={$CronjobInfo.id}"><i class="glyphicon glyphicon-remove"></i> Delete Cron</a></li>
																		</ul>
																	</li>
																</ul>
															</td>
														</tr>
														{/foreach}
													
													</tbody>
												</table>
											</div>
											</div>
										</fieldset>
										
									</div>
								</div>
							<!-- /a legend -->
						<script>
							$('td.td').css('overflow','auto')
						</script>
{include file="overall_footer.tpl"}
