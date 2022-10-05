{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['mu_users_settings']}</span> - {$LNG['new_creator_title']}</h4>
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
							<li><a href="admin.php?page=create">{$LNG['mu_users_settings']}</a></li>
							<li class="active">{$LNG['new_creator_title']}</li>
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
												{$LNG['new_creator_title']}
												<a class="control-arrow" data-toggle="collapse" data-target="#demo2">
													<i class="icon-circle-down2"></i>
												</a>
											</legend>
											<div class="collapse in" id="demo2">
												<form action="" method="post">
													<input type="hidden" name="mode" value="agregar">
													<table width="100%">
														<tr>
															<th colspan="3">{$po_add_planet}</th>
														</tr>
														<tr>
															<td>{$input_id_user}</td>
															<td><input name="id" type="text" size="4"></td>
														</tr>
														<tr>
															<td>{$new_creator_coor}</td>
															<td>
																<input name="galaxy" type="text" size="3" maxlength="1" class="" title="{$po_galaxy}">&nbsp; :
																<input name="system" type="text" size="3" maxlength="3" class="" title="{$po_system}">&nbsp; :
																<input name="planet" type="text" size="3" maxlength="2" class="" title="{$po_planet}">
															</td>
														</tr>
														<tr>
															<td>{$po_name_planet}</td>
															<td><input name="name" type="text" size="15" maxlength="25" value="{$po_colony}"></td>
														</tr>
														<tr>
															<td>{$po_fields_max}</td>
															<td><input name="field_max" type="text" size="6" maxlength="10"></td>
														</tr>
														<tr>
															<td colspan="2"><button class="btn btn-success btn-xs" type="submit">{$button_add}</button></td>
														</tr>
														<tr>
															<td colspan="2" style="text-align:left;">
																<a class="btn btn-info btn-xs" href="?page=create"><i class="fa fa-arrow-left"></i> {$new_creator_go_back}</a>&nbsp;
																<a class="btn btn-danger btn-xs" href="?page=create&amp;mode=user"><i class="fa fa-fa-sync"></i> {$new_creator_refresh}</a>
															</td>
														</tr>
													</table>
												</form>
												 </div>
                              </fieldset>
                           </div>
                        </div>

<script>
	// $('input').css('width','50%')
	$('select').css('width','50%')
	$('select').select2()
	$('input').addClass('form-control');
	$('input[name="galaxy"],input[name="system"],input[name="planet"]').removeClass('form-control')
      .css('padding','5px').css('border','1px solid #ddd').css('border-radius','3px');
	$('td').css('padding','10px');
</script>
{include file="overall_footer.tpl"}