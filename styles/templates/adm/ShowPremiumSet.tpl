{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['general_setting']}</span> - {$LNG['premium_0']}</h4>
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
							<li><a href="admin.php?page=premium">{$LNG['general_setting']}</a></li>
							<li class="active">{$LNG['premium_0']}</li>
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
												{$LNG['premium_1']}	
												<a class="control-arrow" data-toggle="collapse" data-target="#Frame1">
													<i class="icon-circle-down2"></i>
												</a>
											</legend>
 
											<div class="collapse in" id="Frame1">
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['premium_18']}</label>
													<div class="col-lg-9">
														<input type="text" name="prem_res" value="{$prem_res.promotion}" class="form-control" maxlength="60">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['premium_21']}</label>
													<div class="col-lg-9">
														<input type="text" name="prem_storage" value="{$prem_storage.promotion}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['premium_23']}</label>
													<div class="col-lg-9">
														<input type="text" name="prem_s_build" value="{$prem_s_build.promotion}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['premium_25']}</label>
													<div class="col-lg-9">
														<input type="text" name="prem_o_build" value="{$prem_o_build.promotion}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['premium_27']}</label>
													<div class="col-lg-9">
														<input type="text" name="prem_button" value="{$prem_button.promotion}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['premium_29']}</label>
													<div class="col-lg-9">
														<input type="text" name="prem_speed_button" value="{$prem_speed_button.promotion}" class="form-control"> 
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['premium_31']}</label>
													<div class="col-lg-9">
														<input type="text" name="prem_expedition" value="{$prem_expedition.promotion}" class="form-control">
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['premium_33']}</label>
													<div class="col-lg-9">
														<input type="text" name="prem_count_expiditeon" value="{$prem_count_expiditeon.promotion}" class="form-control">
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['premium_35']}</label>
													<div class="col-lg-9">
														<input type="text" name="prem_speed_expiditeon" value="{$prem_speed_expiditeon.promotion}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['premium_37']	}</label>
													<div class="col-lg-9">
														<input type="text" name="prem_moon_dextruct" value="{$prem_moon_dextruct.promotion}" class="form-control">
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['premium_39']}</label>
													<div class="col-lg-9">
														<input type="text" name="prem_leveling" value="{$prem_leveling.promotion}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['premium_41']}</label>
													<div class="col-lg-9">
														<input type="text" name="prem_batle_leveling" value="{$prem_batle_leveling.promotion}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['premium_43']}</label>
													<div class="col-lg-9">
														<input type="text" name="prem_bank_ally" value="{$prem_bank_ally.promotion}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['premium_45']}</label>
													<div class="col-lg-9">
														<input type="text" name="prem_conveyors_l" value="{$prem_conveyors_l.promotion}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['premium_47']}</label>
													<div class="col-lg-9">
														<input type="text" name="prem_conveyors_s" value="{$prem_conveyors_s.promotion}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['premium_49']}</label>
													<div class="col-lg-9">
														<input type="text" name="prem_conveyors_t" value="{$prem_conveyors_t.promotion}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['premium_51']}</label>
													<div class="col-lg-9">
														<input type="text" name="prem_prod_from_colly" value="{$prem_prod_from_colly.promotion}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['premium_53']}</label>
													<div class="col-lg-9">
														<input type="text" name="prem_moon_creat" value="{$prem_moon_creat.promotion}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['premium_55']}</label>
													<div class="col-lg-9">
														<input type="text" name="prem_fuel_consumption" value="{$prem_fuel_consumption.promotion}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['premium_57']}</label>
													<div class="col-lg-9">
														<input type="text" name="prem_prime_units" value="{$prem_prime_units.promotion}" class="form-control">
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