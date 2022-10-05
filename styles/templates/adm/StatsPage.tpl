{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['general_setting']}</span> - {$LNG['log_statsettings']}</h4>
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
							<li><a href="index.php"><i class="icon-home2 position-left"></i> {$LNG['home']}</a></li>
							<li><a href="statistics_settings.php">{$LNG['general_setting']}</a></li>
							<li class="active">{$LNG['log_statsettings']}</li>
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
												{$LNG['cs_title']}
												<a class="control-arrow" data-toggle="collapse" data-target="#demo2">
													<i class="icon-circle-down2"></i>
												</a>
											</legend>
											<div class="collapse in" id="demo2">

											<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['cs_point_per_resources_used']}</label>
													<div class="col-lg-9">
														<input type="text" class="form-control" name="stat_settings" value="{$stat_settings}">
													</div>
												</div>
											<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['cs_points_to_zero']}</label>
													<div class="col-lg-9">
													{html_options data-placeholder="Select the desired option" class="select" name=stat options=$Selector selected=$stat}
													
												</div>
												</div>	
											<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['cs_access_lvl']}</label>
													<div class="col-lg-9">
														<input type="text" class="form-control" name="stat_level" value="{$stat_level}">
													</div>
												</div>	
				                			</div>
										</fieldset>

										<div class="text-right">
											<button type="submit" class="btn btn-primary">{$LNG['up_submit']}<i class="icon-arrow-right14 position-right"></i></button>
										</div>
									</div>
								</div>
							</form>
							<!-- /a legend -->
						
{include file="overall_footer.tpl"}