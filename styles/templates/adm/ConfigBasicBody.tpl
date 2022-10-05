{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['server_setting']}</span> - {$LNG['mu_general']}</h4>
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
							<li><a href="admin.php?page=generalsett">{$LNG['server_setting']}</a></li>
							<li class="active">{$LNG['mu_general']}</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li><a href="mailto:rayco.garcia13@nauta.cu"><i class="icon-comment-discussion position-left"></i> {$LNG['ow_support']}</a></li>
						</ul>
					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">
						<form action="" method="post">
							<input type="hidden" name="opt_save" value="1">
							<div class="panel panel-flat">
								<div class="panel-body">
									<fieldset>
										<legend class="text-semibold">
											<i class="icon-file-text2 position-left"></i>
											{$LNG.se_server_parameters}
											<a class="control-arrow" data-toggle="collapse" data-target="#demo1">
												<i class="icon-circle-down2"></i>
											</a>
										</legend>
										<div class="collapse in" id="demo1">
											<div class="form-group">
												<label class="col-lg-3 control-label">{$LNG.se_game_name}:</label>
												<div class="col-lg-9">
													<input class="form-control" name="game_name" value="{$game_name}" type="text" maxlength="60">
												</div>
											</div> &nbsp;
											<div class="form-group">
												<label class="col-lg-3 control-label">{$LNG.se_ttf_file}:</label>
												<div class="col-lg-8">
													<input class="form-control" name="ttf_file" value="{$ttf_file}" type="text">
												</div>
												<label class="col-lg-1 control-label">
													<i class="fa fa-info-circle text-danger tooltip" style="margin-top:10px;margin-left:30%	" title="{$LNG.se_ttf_file_info}"></i>
												</label>
											</div> &nbsp;
											<div class="form-group" style="margin-top:5px">
												<label class="col-lg-3 control-label">{$LNG.se_timzone}:</label>
												<div class="col-lg-9">
													{html_options name=timezone options=$Selector.timezone selected=$timezone}
												</div>
											</div> 
										</div>
									</fieldset>
									<fieldset>
										<legend class="text-semibold">
											<i class="icon-file-text2 position-left"></i>
											{$LNG.se_player_settings}
											<a class="control-arrow" data-toggle="collapse" data-target="#demo2">
												<i class="icon-circle-down2"></i>
											</a>
										</legend>
										<div class="collapse in" id="demo2">
											<div class="form-group">
												<label class="col-lg-3 control-label">{$LNG.se_del_oldstuff}:</label>
												<div class="col-lg-1">
													<input class="form-control" name="del_oldstuff" maxlength="3" size="2" value="{$del_oldstuff}" type="text">
												</div>
												<div class="col-lg-1 mt-10">
													{$LNG.se_days}
												</div>
												<label class="col-lg-7 control-label mt-10">
													  <i class="fa fa-info-circle text-danger tooltip"  title="{$LNG.se_del_oldstuff_info}"></i>
												</label>
											</div> &nbsp;
											<div class="form-group mt-10">
												<label class="col-lg-3 control-label">{$LNG.se_del_user_manually}:</label>
												<div class="col-lg-1">
													<input class="form-control" name="del_user_manually" maxlength="3" size="2" value="{$del_user_manually}" type="text">
												</div><div class="col-lg-1 mt-10">{$LNG.se_days}</div>
												<label class="col-lg-7 control-label mt-10">
													  <i class="fa fa-info-circle text-danger tooltip"  title="{$LNG.se_del_user_manually_info}"></i>
												</label>
											</div> &nbsp;
											<div class="form-group mt-10">
												<label class="col-lg-3 control-label">{$LNG.se_del_user_automatic}:</label>
												<div class="col-lg-1">
													<input class="form-control" name="del_user_automatic" maxlength="3" size="2" value="{$del_user_automatic}" type="text">
												</div><div class="col-lg-1 mt-10">{$LNG.se_days}</div>
												<label class="col-lg-7 control-label mt-10">
													  <i class="fa fa-info-circle text-danger tooltip"  title="{$LNG.se_del_user_automatic_info}"></i>
												</label>
											</div> &nbsp;
											<div class="form-group mt-10">
												<label class="col-lg-3 control-label">{$LNG.se_sendmail_inactive}:</label>
												<div class="col-lg-1">
													<input class="form-control" style="width:15px;margin-left:10px" name="sendmail_inactive"{if $sendmail_inactive} checked="checked"{/if}  type="checkbox">
												</div>
											</div>&nbsp;
											<div class="clearfix"></div>
											<div class="form-group mt-10">
												<label class="col-lg-3 control-label">{$LNG.se_del_user_sendmail}:</label>
												<div class="col-lg-1">
													<input class="form-control" name="del_user_sendmail" maxlength="3" size="2" value="{$del_user_sendmail}" type="text">
												</div><div class="col-lg-1 mt-10">{$LNG.se_days}</div>
												<label class="col-lg-7 control-label mt-10">
													  <i class="fa fa-info-circle text-danger tooltip"  title="{$LNG.se_del_user_sendmail_info}"></i>
												</label>
											</div> &nbsp; 
										</div>
									</fieldset>
									<fieldset>
										<legend class="text-semibold">
											<i class="icon-file-text2 position-left"></i>
											{$LNG.se_recaptcha_head}
											<a class="control-arrow" data-toggle="collapse" data-target="#demo3">
												<i class="icon-circle-down2"></i>
											</a>
										</legend>
										<div class="collapse in" id="demo3">
											<div class="form-group mt-10">
												<label class="col-lg-3 control-label">{$LNG.se_recaptcha_active}:</label>
												<div class="col-lg-1">
													<input class="form-control" style="width:15px;margin-left:10px" name="capaktiv"{if $capaktiv} checked="checked"{/if}  type="checkbox">
												</div>
												<label class="col-lg-8 control-label mt-10">
													  <i class="fa fa-info-circle text-danger tooltip"  title="{$LNG.se_recaptcha_desc}"></i>
												</label>
											</div>&nbsp;
											<div class="clearfix"></div>
											<div class="form-group">
												<label class="col-lg-3 control-label">{$LNG.se_recaptcha_public}:</label>
												<div class="col-lg-9">
													<input class="form-control" name="cappublic" value="{$cappublic}" type="text" maxlength="60">
												</div>
											</div> &nbsp;
											<div class="form-group">
												<label class="col-lg-3 control-label">{$LNG.se_recaptcha_private}:</label>
												<div class="col-lg-9">
													<input class="form-control" name="capprivate" value="{$capprivate}" type="text" maxlength="60">
												</div>
											</div> &nbsp;
									</fieldset>
									<fieldset>
										<legend class="text-semibold">
											<i class="icon-file-text2 position-left"></i>
											{$LNG.se_smtp}
											<a class="control-arrow" data-toggle="collapse" data-target="#demo4">
												<i class="icon-circle-down2"></i>
											</a>
										</legend>
										<div class="collapse in" id="demo4">
											<div class="form-group mt-10">
												<label class="col-lg-3 control-label">{$LNG.se_mail_active}:</label>
												<div class="col-lg-1">
													<input class="form-control" style="width:15px;margin-left:10px" name="mail_active"{if $mail_active} checked="checked"{/if}  type="checkbox">
												</div>
											</div>&nbsp;
											<div class="clearfix"></div>
											<div class="form-group mt-10">
												<label class="col-lg-3 control-label">{$LNG.se_mail_use}:</label>
												<div class="col-lg-9">
													{html_options name=mail_use options=$Selector.mail selected=$mail_use}
												</div>
											</div>&nbsp;
											<div class="form-group">
												<label class="col-lg-3 control-label">{$LNG.se_smtp_sendmail}:</label>
												<div class="col-lg-8">
													<input class="form-control" name="smtp_sendmail" value="{$smtp_sendmail}" type="text" autocomplete="off">
												</div>
												<label class="col-lg-1 control-label">
													<i class="fa fa-info-circle text-danger tooltip" style="margin-top:10px;margin-left:30%	" title="{$LNG.se_smtp_sendmail_info}"></i>
												</label>
											</div> &nbsp;
											<div class="form-group mt-10">
												<label class="col-lg-3 control-label">{$LNG.se_smail_path}:</label>
												<div class="col-lg-9">
													<input class="form-control" name="smail_path" value="{$smail_path}" type="text">
												</div>
											</div> &nbsp;
											<div class="form-group">
												<label class="col-lg-3 control-label">{$LNG.se_smtp_host}:</label>
												<div class="col-lg-8">
													<input class="form-control" name="smtp_host" value="{$smtp_host}" type="text" autocomplete="off">
												</div>
												<label class="col-lg-1 control-label">
													<i class="fa fa-info-circle text-danger tooltip" style="margin-top:10px;margin-left:30%	" title="{$LNG.se_smtp_host_info}"></i>
												</label>
											</div> &nbsp;
											<div class="form-group mt-10">
												<label class="col-lg-3 control-label">{$LNG.se_smtp_ssl}:</label>
												<div class="col-lg-8">
													{html_options name=smtp_ssl options=$Selector.encry selected=$smtp_ssl}
												</div>
												<label class="col-lg-1 control-label">
													<i class="fa fa-info-circle text-danger tooltip" style="margin-top:10px;margin-left:30%	" title="{$LNG.se_smtp_ssl_info}"></i>
												</label>
											</div> &nbsp;
											<div class="clearfix"></div>
											<div class="form-group mt-10">
												<label class="col-lg-3 control-label">{$LNG.se_smtp_port}:</label>
												<div class="col-lg-8">
													<input class="form-control" name="smtp_port" value="{$smtp_port}" type="text" autocomplete="off">
												</div>
												<label class="col-lg-1 control-label">
													<i class="fa fa-info-circle text-danger tooltip" style="margin-top:10px;margin-left:30%	" title="{$LNG.se_smtp_port_info}"></i>
												</label>
											</div> &nbsp;
											<div class="clearfix"></div>
											<div class="form-group mt-10">
												<label class="col-lg-3 control-label">{$LNG.se_smtp_user}:</label>
												<div class="col-lg-9">
													<input class="form-control" name="smtp_user" value="{$smtp_user}" type="text" autocomplete="off">
												</div>
											</div> &nbsp;
											<div class="form-group">
												<label class="col-lg-3 control-label">{$LNG.se_smtp_pass}:</label>
												<div class="col-lg-9">
													<input class="form-control" name="smtp_pass" value="{$smtp_pass}" type="password" autocomplete="off">
												</div>
											</div> &nbsp;
									</fieldset>
									<fieldset>
										<legend class="text-semibold">
											<i class="icon-file-text2 position-left"></i>
											{$LNG.se_google}
											<a class="control-arrow" data-toggle="collapse" data-target="#demo5">
												<i class="icon-circle-down2"></i>
											</a>
										</legend>
										<div class="collapse in" id="demo5">
											<div class="form-group">
												<label class="col-lg-3 control-label">{$LNG.se_google_active}:</label>
												<div class="col-lg-8">
													<input class="form-control" style="width:15px;margin-left:10px" name="ga_active"{if $ga_active} checked="checked"{/if}  type="checkbox">
												</div>
												<label class="col-lg-1 control-label">
													<i class="fa fa-info-circle text-danger tooltip" style="margin-top:10px;margin-left:30%	" title="{$LNG.se_google_info}"></i>
												</label>
											</div> &nbsp;
											<div class="form-group mt-10">
												<label class="col-lg-3 control-label">{$LNG.se_google_key}:</label>
												<div class="col-lg-8">
													<input class="form-control" name="ga_key" value="{$ga_key}" type="text" autocomplete="off">
												</div>
												<label class="col-lg-1 control-label">
													<i class="fa fa-info-circle text-danger tooltip" style="margin-top:10px;margin-left:30%	" title="{$LNG.ga_key}"></i>
												</label>
											</div> &nbsp;
										</div>
									</fieldset>
									</div>
									<div class="panel-footer p-10">
									<div class="text-right">
										<button type="submit" class="btn btn-primary">{$LNG.se_save_parameters} <i class="icon-arrow-right14 position-right"></i></button>
									</div>
								</div>
							</div>
						</form>
					</center>

<script>
	$('select').select2()
</script>
{include file="overall_footer.tpl"}