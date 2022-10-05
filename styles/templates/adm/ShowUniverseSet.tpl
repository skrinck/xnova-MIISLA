{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['general_setting']}</span> - {$LNG['log_usettings']}</h4>
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
							<li><a href="admin.php?page=universeset">{$LNG['general_setting']}</a></li>
							<li class="active">{$LNG['log_usettings']}</li>
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
												{$LNG['general_setting']}
												<a class="control-arrow" data-toggle="collapse" data-target="#Frame1">
													<i class="icon-circle-down2"></i>
												</a>
											</legend>
 
											<div class="collapse in" id="Frame1">
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['univ_name']}:</label>
													<div class="col-lg-9">
														<input type="text" name="uni_name" value="{$uni_name}" class="form-control" maxlength="60">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['se_general_speed']}:</label>
													<div class="col-lg-9">
														<input type="text" name="game_speed" value="{$game_speed}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['se_fleet_speed']}:</label>
													<div class="col-lg-9">
														<input type="text" name="fleet_speed" value="{$fleet_speed}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['se_resources_producion_speed']}:</label>
													<div class="col-lg-9">
														<input type="text" name="resource_multiplier" value="{$resource_multiplier}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['se_halt_speed']}:</label>
													<div class="col-lg-9">
														<input type="text" name="halt_speed" value="{$halt_speed}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['se_energy_speed']}:</label>
													<div class="col-lg-9">
														<input type="text" name="energySpeed" value="{$energySpeed}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label"></label>
													<div class="col-lg-9">
													<div class="checkbox checkbox-switch">
													<label>
													<input type="checkbox" name="closed" {if $game_disable} checked="checked"{/if} data-on-color="success" data-off-color="danger" data-on-text="{$LNG['cs_yes']}" data-off-text="{$LNG['cs_no']}" class="switch">
													{$LNG['se_server_op_close']}
													</label>
													</div>
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['se_server_status_message']}:</label>
													<div class="col-lg-9">
														<textarea rows="5" cols="5" name="close_reason" class="form-control">{$close_reason}</textarea>
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label"></label>
													<div class="col-lg-9">
													<div class="checkbox checkbox-switch">
													<label>
													<input type="checkbox" name="reg_closed" data-on-color="success" data-off-color="danger" data-on-text="{$LNG['cs_yes']}" data-off-text="{$LNG['cs_no']}" class="switch"{if $reg_closed} checked="checked"{/if}>
														{$LNG['se_reg_closed']}
													</label>
													</div>
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label"></label>
													<div class="col-lg-9">
													<div class="checkbox checkbox-switch">
													<label>
													<input type="checkbox" name="adm_attack" data-on-color="success" data-off-color="danger" data-on-text="{$LNG['cs_yes']}" data-off-text="{$LNG['cs_no']}" class="switch"{if $adm_attack} checked="checked"{/if}>
													{$LNG['qe_authattack']}
													</label>
													</div>
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label"></label>
													<div class="col-lg-9">
													<div class="checkbox checkbox-switch">
													<label>
													<input type="checkbox" name="user_valid" data-on-color="success" data-off-color="danger" data-on-text="{$LNG['cs_yes']}" data-off-text="{$LNG['cs_no']}" class="switch"{if $user_valid} checked="checked"{/if}>
													{$LNG['se_verfiy_mail']	}
													</label>
													</div>
												</div>
												</div>
											</div>
										</fieldset>									

										<div class="text-right">
											<button type="submit" class="btn btn-primary">{$LNG.button_submit}<i class="icon-arrow-right14 position-right"></i></button>
										</div>
									</div>
								</div>
							</form>
							<!-- /a legend -->
						
{include file="overall_footer.tpl"}