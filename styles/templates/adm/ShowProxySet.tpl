{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['server_setting']}</span> - {$LNG['mu_proxy']}	</h4>
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
							<li><a href="admin.php?page=proxyset">{$LNG['server_setting']}</a></li>
							<li class="active">{$LNG['mu_proxy']}	</li>
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
							<form class="form-horizontal" action="" method="post">
								<div class="panel panel-flat">


									<div class="panel-body">
										<fieldset>
											<legend class="text-semibold">
												<i class="icon-file-text2 position-left"></i>
												{$LNG['mu_proxy']}	
												<a class="control-arrow" data-toggle="collapse" data-target="#Frame1">
													<i class="icon-circle-down2"></i>
												</a>
											</legend>
 
											<div class="collapse in" id="Frame1">
												<div class="form-group">
													<label class="col-lg-3 control-label"></label>
													<div class="col-lg-9">
													<div class="checkbox checkbox-switch">
													<label>
													<input type="checkbox" name="proxyConfig" {if $proxyConfig}checked="checked"{/if} data-on-color="success" data-off-color="danger" data-on-text="{$LNG['one_is_yes'][1]}" data-off-text="{$LNG['one_is_yes'][0]}" class="switch">
														{$LNG['proxy_enab']}
													</label>
													</div>
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label"></label>
													<div class="col-lg-9">
													<div class="checkbox checkbox-switch">
													<label>
													<input type="checkbox" name="proxyAlert" data-on-color="success" data-off-color="danger" data-on-text="{$LNG['one_is_yes'][1]}" data-off-text="{$LNG['one_is_yes'][0]}" class="switch"{if $proxyAlert} checked="checked"{/if}>
														{$LNG['proxy_alert']}
													</label>
													</div>
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label"></label>
													<div class="col-lg-9">
													<div class="checkbox checkbox-switch">
													<label>
													<input type="checkbox" name="proxyBlock" data-on-color="success" data-off-color="danger" data-on-text="{$LNG['one_is_yes'][1]}" data-off-text="{$LNG['one_is_yes'][0]}" class="switch"{if $proxyBlock} checked="checked"{/if}>
														{$LNG['proxy_block']}
													</label>
													</div>
												</div>
												</div>
											</div>
										</fieldset>									

										<div class="text-right">
											<button type="submit" class="btn btn-primary">{$LNG.up_submit} <i class="icon-arrow-right14 position-right"></i></button>
										</div>
									</div>
								</div>
							</form>
							<!-- /a legend -->
							
							<!-- Basic responsive configuration -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">{$LNG['proxy_list']}</h5>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                	</ul>
		                	</div>
						</div>

						<div class="panel-body">
							<table class="table datatable-responsive">
								<thead>
									<tr>
										<th>{$LNG['input_id_user']}</th>
										<th>{$LNG['qe_username']}</th>
										<th>{$LNG['proxy_ip']}</th>
										<th>{$LNG['proxy_provider']}</th>
										<th>{$LNG['proxy_date']}</th>
										<th class="text-center">{$LNG['proxy_acts']}</th>
									</tr>
								</thead>
								<tbody>
									{foreach $ProxyList as $suspectId => $proxyRow}
									<tr>
										<td>{$proxyRow.userId}</td>
										<td>{$proxyRow.nickname}</td>
										<td>{$proxyRow.ipadress}</td>
										<td>{$proxyRow.opsystem}</td>
										<td><span class="label label-default">{$proxyRow.timestamp}</span></td>
										<td class="text-center">
											<ul class="icons-list">
												<li class="dropdown">
													<a href="#" class="dropdown-toggle" data-toggle="dropdown">
														<i class="icon-menu9"></i>
													</a>

													<ul class="dropdown-menu dropdown-menu-right">
														<li><a href="#"><i class="icon-file-pdf"></i> Block Player Action</a></li>
														<li><a href="#"><i class="icon-file-excel"></i> Ban Player</a></li>
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
					<!-- /basic responsive configuration -->
						
{include file="overall_footer.tpl"}