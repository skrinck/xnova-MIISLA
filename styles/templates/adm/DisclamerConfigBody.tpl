{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['main']}</span> - {$LNG.mu_disclamer}</h4>
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
							<li>{$LNG['main']}</li>
							<li>{$LNG.mu_disclamer}</li>
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
												{$se_server_parameters}
												<a class="control-arrow" data-toggle="collapse" data-target="#disclamer">
													<i class="icon-circle-down2"></i>
												</a>
											</legend>
 
											<div class="collapse in" id="disclamer">
												<form action="" method="post">
													<div class="form-group">
														<label class="col-lg-2 control-label">{$se_disclaimerAddress}</label>
														<div class="col-lg-9">
															<input class="form-control" name="disclaimerAddress" maxlength="255" value="{$disclaimerAddress}" type="text">
														</div>
														<label class="col-lg-1 control-label mt-10">
															  <i class="fa fa-info-circle text-danger tooltip"  title="{$LNG.se_del_user_manually_info}"></i>
														</label>
													</div> &nbsp;
													<div class="form-group mt-10">
														<label class="col-lg-2 control-label">{$se_disclaimerPhone}</label>
														<div class="col-lg-3">
															<input class="form-control" name="disclaimerPhone" value="{$disclaimerPhone}" type="phone">
														</div>
														<div class="col-lg-6"></div>
														<label class="col-lg-1 control-label mt-10">
															  <i class="fa fa-info-circle text-danger tooltip"  title="{$LNG.se_del_user_manually_info}"></i>
														</label>
													</div> &nbsp;
													<div class="form-group mt-10">
														<label class="col-lg-2 control-label">{$se_disclaimerMail}</label>
														<div class="col-lg-3">
															<input class="form-control" name="disclaimerMail" value="{$disclaimerMail}" type="email">
														</div>
														<div class="col-lg-6"></div>
														<label class="col-lg-1 control-label mt-10">
															  <i class="fa fa-info-circle text-danger tooltip"  title="{$LNG.se_del_user_manually_info}"></i>
														</label>
													</div> &nbsp;
													<div class="form-group mt-10">
														<label class="col-lg-2 control-label">{$se_disclaimerNotice}</label>
														<div class="col-lg-8">
															<textarea class="form-control" name="disclaimerNotice" cols="80" rows="5">{$disclaimerNotice}</textarea>
														</div>
														<div class="col-lg-1"></div>
														<label class="col-lg-1 control-label mt-10">
															  <i class="fa fa-info-circle text-danger tooltip"  title="{$LNG.se_del_user_manually_info}"></i>
														</label>
													</div> &nbsp;
												
													
													<div class="mt-10">
														<button type="submit" class="btn btn-primary">{$se_save_parameters} <i class="icon-arrow-right14 position-right"></i></button>
													</div>
												</form>
											</div>
										</fieldset>
										
									</div>
								</div>
							<!-- /a legend -->
						
{include file="overall_footer.tpl"}

