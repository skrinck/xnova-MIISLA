{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['mu_users_settings']}</span> - {$LNG.mu_connected}</h4>
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
							<li><a href="admin.php?page=usersonline">{$LNG['mu_users_settings']}</a></li>
							<li>{$LNG.mu_connected}</li>
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
												{$LNG.mu_connected}
												<a class="control-arrow" data-toggle="collapse" data-target="#Frame8">
													<i class="icon-circle-down2"></i>
												</a>
											</legend>
 
											<div class="collapse in" id="Frame8">
												<div class="table-responsive">
												<table class="table table-bordered table-hover datatable-highlight">
													<thead>
														<tr>
															<th>{$LNG['se_search_users'][0]}</th>
															<th>{$LNG['se_search_users'][1]}</th>
															<th>{$LNG['se_search_users'][2]}</th>
															<th>{$LNG['se_search_users'][3]}</th>
															<th>{$LNG['se_search_users'][4]}</th>
															<th>{$LNG['se_search_users'][6]}</th>
															<th>{$LNG['visiting']}</th>
															<th>{$LNG['se_search_users'][7]}</th>
															<th>{$LNG['se_search_users'][8]}?</th>
															<th class="text-center">Actions</th>
														</tr>
													</thead>
													<tbody>
															
													{foreach $OnlineList as $userID => $onlineRow} 
														<tr>
															<td>{$userID}</td>
															<td>{$onlineRow.username}</td>
															<td>{$onlineRow.email_2}</td>
															<td>{$onlineRow.onlinetime}</td>
															<td>{$onlineRow.register_time}</td>
															<td>{$onlineRow.authlevel}</td>
															<td>{$onlineRow.lastVisit}</td>
															<td>{if $onlineRow.bana == 0}<span class="label label-success">NO</span>{else}<span class="label label-danger">SI</span>{/if}</td>
															<td>{if $onlineRow.urlaubs_modus == 0}<span class="label label-success">NO</span>{else}<span class="label label-danger">Si</span>{/if}</td>
															<td class="text-center">
																<ul class="icons-list">
																	<li class="dropdown">
																		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
																			<i class="icon-menu9"></i>
																		</a>

																		<ul class="dropdown-menu dropdown-menu-right">
																			<li><a href="javascript:openEdit({$userID},'player')"><i class="fas fa-user-edit"></i> {$LNG['up_edit']}</a></li>
																			<li><a href="?page=usersonline&amp;delete=user&amp;user={$userID}" onclick="return confirm('{$LNG.ul_sure_you_want_dlte} - {$onlineRow.username}');"><i class="fas fa-times"></i> {$LNG['up_del']}</a></li>
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
						
{include file="overall_footer.tpl"}