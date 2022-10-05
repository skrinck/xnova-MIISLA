{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['general_setting']}</span> - {$LNG['config_ref']}</h4>
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
							<li><a href="admin.php?page=referalset">{$LNG['general_setting']}</a></li>
							<li class="active">{$LNG['config_ref']}</li>
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
												{$LNG['se_ref']}
												<a class="control-arrow" data-toggle="collapse" data-target="#Frame3">
													<i class="icon-circle-down2"></i>
												</a>
											</legend>
 
											<div class="collapse in" id="Frame3">
											
												<div class="form-group">
													<label class="col-lg-3 control-label"></label>
													<div class="col-lg-9">
													<div class="checkbox checkbox-switch">
													<label>
													<input type="checkbox" name="ref_active" data-on-color="success" data-off-color="danger" data-on-text="{$LNG['cs_yes']}" data-off-text="{$LNG['cs_no']}" class="switch"{if $ref_active} checked="checked"{/if}>
													</label>
													{$LNG['se_ref_active']} <i class="fa fa-info-circle tooltip text-danger" title="{$LNG['se_ref_active_info']}"></i>
													</div>													
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['se_ref_bonus']} <i class="fa fa-info-circle tooltip text-danger" title="{$LNG['se_ref_bonus_info']}"></i></label>
													<div class="col-lg-9">
														<input type="text" name="ref_bonus" value="{$ref_bonus}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['se_ref_bonus_am']} <i class="fa fa-info-circle tooltip text-danger" title="{$LNG['se_ref_bonus_am_info']}"></i></label>
													<div class="col-lg-9">
														<input type="text" name="ref_bonus1" value="{$ref_bonus1}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['se_ref_minpoints']} <i class="fa fa-info-circle tooltip text-danger" title="{$LNG['se_ref_minpoints_info']}"></i></label>
													<div class="col-lg-9">
														<input type="text" name="ref_minpoints" value="{$ref_minpoints}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['se_ref_max_referals']} <i class="fa fa-info-circle tooltip text-danger" title="{$LNG['se_ref_max_referals_info']}"></i></label>
													<div class="col-lg-9">
														<input type="text" name="ref_max_referals" value="{$ref_max_referals}" class="form-control">
													</div>
												</div>
											</div>
										</fieldset>
										
										<div class="text-right">
											<button type="submit" class="btn btn-primary">{$LNG['up_submit']} <i class="icon-arrow-right14 position-right"></i></button>
										</div>
									</div>
								</div>
							</form>
							<!-- /a legend -->
						
{include file="overall_footer.tpl"}