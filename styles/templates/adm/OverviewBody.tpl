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
								<a href="admin.php?page=rights&mode=users&sid={session_id()}" class="btn btn-link btn-float has-text"><i class="fas fa-user-cog fa-2x text-primary"></i><span>{$LNG['ad_authlevel_title']}</span></a>
								<a href="admin.php?page=reset&sid={session_id()}" class="btn btn-link btn-float has-text"><i class="fa fa-undo fa-2x text-primary"></i><span>{$LNG['re_reset_universe'] }</span></a>
							</div>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="admin.php"><i class="icon-home2 position-left"></i> {$LNG['home']}</a></li>
							<li class="active">{$LNG['adm_cp_title']}</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li><a href="mailto:rayco.garcia13@nauta.cu"><i class="icon-comment-discussion position-left"></i> {$LNG['ow_support']}</a></li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">

					<!-- Dashboard content -->
					<div class="row">
						<div class="col-lg-8">

							<div class="panel panel-flat" style="padding:10px">
								<div class="margin:10px">
									<div class="pull-left">{$LNG['campaign']}</div>
									<div class="pull-right">
										<ul class="icons-list">
											<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-plus-circle2"></i></a>
												<ul class="dropdown-menu dropdown-menu-right">
													<li><a href="admin.php?page=createcampaign"><i class="icon-file-stats"></i> {$LNG['create_campaign']}</a></li>
													<li><a href="admin.php?page=log&type=campaign"><i class="icon-file-text2"></i> {$LNG['log_campaign']}</a></li>
												</ul>
											</li>
										</ul>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4">

									<!-- Members online -->
									<div class="panel bg-teal-400">
										<div class="panel-body">
											<div class="heading-elements">
												<span class="heading-text badge bg-teal-800">{round($amountonline/$totalUsers*100)}%</span>
											</div>

											<h3 class="no-margin">{$amountonline}</h3>
											{$LNG['se_input_members2']} {$LNG['online_users']}
										</div>

										<div class="container-fluid">
											<div id="members-online"></div>
										</div>
									</div>
									<!-- /members online -->

								</div>

							</div>				
							<!-- Marketing campaigns -->
							<!-- /marketing campaigns -->

							

							<!-- /quick stats boxes -->
									{if $showCommentAlert == 1}<div class="alert alert-danger alert-styled-left alert-bordered">
										<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
										<span class="text-semibold">Attention!</span> There are new hof comments to moderate. <a href="admin.php?page=commentlist" class="alert-link">Click here to access the moderation page</a>.
								    </div>{/if}
									
									<div class="alert alert-danger alert-styled-left alert-bordered">
										<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
										<span class="text-semibold">Attention!</span> Two non-authorized players tried to reach the administration page ! <a href="admin.php?page=commentlist" class="alert-link">Click here to access the moderation page</a>.
								    </div>
									{if $TotalPaysafe >= 1}
									<div class="alert alert-danger alert-styled-left alert-bordered">
										<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
										<span class="text-semibold">Validation!</span> There are {$TotalPaysafe} paysafe cards to approuve be an admin ! <a href="admin.php?page=addam" class="alert-link">Click here to access the moderation page</a>.
								    </div>
									{/if}
									{if $totalBlockedCron != 0}
									<div class="alert alert-danger alert-styled-left alert-bordered">
										<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
										<span class="text-semibold">Attention!</span> There is atleast one cronjob locked that shouldn't be locked for a correct game play ! <a href="admin.php?page=cronjob" class="alert-link">Click here to access the moderation page</a>.
								    </div>
									{/if}
									{if $totalEmailsProc != 0}
									<div class="alert alert-danger alert-styled-left alert-bordered">
										<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
										<span class="text-semibold">Attention!</span> There are currently {$totalEmailsProc} emails being send to players, this can affect a little bit the server performance !
								    </div>
									{/if}
									{if $totalBlocked != 0}
									<div class="alert alert-danger alert-styled-left alert-bordered">
										<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
										<span class="text-semibold">Attention!</span> There are {$totalBlocked} blocked fleets that need to be unlocked to unbug the game ! <a href="admin.php?page=fleets" class="alert-link">Click here to access the moderation page</a>.
								    </div>
									{/if}
						</div>

						<div class="col-lg-4">
							<div class="panel panel-flat">

								<div class="table-responsive">
									<table class="table text-nowrap">
										<thead>
											<tr>
												<th>{$LNG['latest_login']}</th>
												<th>{$LNG['time']}</th>
												<th>{$LNG['state']}</th>
											</tr>
										</thead>
										<tbody>
										{foreach $loggedList as $adminLog => $loggedInfo}
											<tr>
												<td>
													<div class="media-left media-middle">
														<span class="btn bg-{if $loggedInfo.status == 0}success{elseif $loggedInfo.status == 1}danger{/if}-400 btn-rounded btn-icon btn-xs">
															<span class="icon-{if $loggedInfo.status == 0}checkmark3{elseif $loggedInfo.status == 1}cross2{/if}"></span>
														</span>
													</div>

													<div class="media-body">
														<div class="text-muted text-size-small"><i class="text-size-mini position-left"></i> {$loggedInfo.username}</div>
													</div>
												</td>
												<td>
													<span class="text-muted text-size-small">{$loggedInfo.time}</span>
												</td>
												<td>
													<h6 class="text-semibold no-margin">{if $loggedInfo.state == 0}{$LNG['valid']}{else}{$LNG['failed']}{/if}</h6>
												</td>
											</tr>
										{/foreach}
										
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- /dashboard content -->

{include file="overall_footer.tpl"}
