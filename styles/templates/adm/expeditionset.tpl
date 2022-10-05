{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['server_setting']}</span> - {$LNG['expedition_setting']}</h4>
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
							<li><a href="admin.php?page=expeditionset">{$LNG['server_setting']}</a></li>
							<li class="active">{$LNG['expedition_setting']}</li>
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
												{$LNG['expedition_setting']}	
												<a class="control-arrow" data-toggle="collapse" data-target="#Frame1">
													<i class="icon-circle-down2"></i>
												</a>
											</legend>
 
											<div class="collapse in" id="Frame1">
												<div class="form-group">
													<label class="col-lg-3 control-label">Find resource chance:</label>
													<div class="col-lg-9">
														<input type="text" name="expe_chance_res" value="{$expe_chance_res}" class="form-control" maxlength="60">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">Find darkmatter chance:</label>
													<div class="col-lg-9">
														<input type="text" name="expe_chance_dark" value="{$expe_chance_dark}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">Find fleets chance:</label>
													<div class="col-lg-9">
														<input type="text" name="expe_chance_fleets" value="{$expe_chance_fleets}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">Find aliens/pirates chance:</label>
													<div class="col-lg-9">
														<input type="text" name="expe_chance_hostile" value="{$expe_chance_hostile}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">Find black hole chance:</label>
													<div class="col-lg-9">
														<input type="text" name="expe_chance_hole" value="{$expe_chance_hole}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">Find time change chance:</label>
													<div class="col-lg-9">
														<input type="text" name="expe_chance_change" value="{$expe_chance_change}" class="form-control"> 
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-lg-3 control-label">Find resource converter chance:</label>
													<div class="col-lg-9">
														<input type="text" name="expe_chance_converter" value="{$expe_chance_converter}" class="form-control">
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-lg-3 control-label">Find arsenal item chance:</label>
													<div class="col-lg-9">
														<input type="text" name="expe_chance_arsenal" value="{$expe_chance_arsenal}" class="form-control">
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-lg-3 control-label">Fleet points required to find arsenal items:</label>
													<div class="col-lg-9">
														<input type="text" name="expe_fleet_arsenal" value="{$expe_fleet_arsenal}" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">Fleet points required to find fleets:</label>
													<div class="col-lg-9">
														<input type="text" name="expe_minPoint_fleet" value="{$expe_minPoint_fleet}" class="form-control">
													</div>
												</div>
												
												
												
											</div>
										</fieldset>									

										<div class="text-right">
											<button type="submit" class="btn btn-primary">Submit form <i class="icon-arrow-right14 position-right"></i></button>
										</div>
									</div>
								</div>
							</form>
							<!-- /a legend -->
						
{include file="overall_footer.tpl"}