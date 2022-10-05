{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['mu_users_settings']}</span> - {$LNG['mu_giveaway']}</h4>
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
							<li><a href="admin.php?page=giveaway">{$LNG['mu_users_settings']}</a></li>
							<li class="active">{$LNG['mu_giveaway']}</li>
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
												<form method="post">
												<input type="hidden" name="action" value="send">
												<!-- Zielplaneten definieren -->
												<table width="100%" style="color:#000"><tr>
														<th colspan="3">{$LNG.ga_definetarget}</th>
												</tr>
												<tr style="height:26px;">
													<td width="50%">{$LNG.ga_planettypes}:</td>
													<td width="50%">
														<table style="color:#000">
															<tr>
																<td class="transparent"><input type="checkbox" name="planet" value="1" checked></td>
																<td class="transparent left">{$LNG.fcm_planet}</td>
															</tr>
															<tr>
																<td class="transparent"><input type="checkbox" name="moon" value="1"></td>
																<td class="transparent left">{$LNG.fcm_moon}</td>
															</tr>
														</table>
													</td>
												</tr>
												<tr style="height:26px;"><td width="50%">{$LNG.ga_homecoordinates}:</td><td width="50%"><input type="checkbox" name="mainplanet" value="1"></td></tr>
												<tr style="height:26px;"><td width="50%">{$LNG.ga_no_inactives}:</td><td width="50%"><input type="checkbox" name="no_inactive" value="1"></td></tr>
												</table>


												<!-- Rohstoffe -->
												<table width="760px" style="color:#000">
												<tr>
														<th colspan="2">{$LNG.tech.900}</th>
												</tr>
												{foreach item=Element from=$reslist.resstype.1}
												<tr><td width="50%">{$LNG.tech.{$Element}}:</td><td width="50%"><input type="text" name="element_{$Element}" value="0" pattern="[0-9]*"></td></tr>
												{/foreach}
												{foreach item=Element from=$reslist.resstype.3}
												<tr><td width="50%">{$LNG.tech.{$Element}}:</td><td width="50%"><input type="text" name="element_{$Element}" value="0" pattern="[0-9]*"></td></tr>
												{/foreach}
												</table>

												<!-- Geb�ude -->
												<table width="760px" style="color:#000">
												<tr>
														<th colspan="2">{$LNG.tech.0}</th>
												</tr>
												{foreach item=Element from=$reslist.build}
												<tr><td width="50%">{$LNG.tech.{$Element}}:</td><td width="50%"><input type="text" name="element_{$Element}" value="0" pattern="[0-9]*"></td></tr>
												{/foreach}
												</table>

												<!-- Technologie -->
												<table width="760px" style="color:#000">
												<tr>
														<th colspan="2">{$LNG.tech.100}</th>
												</tr>
												{foreach item=Element from=$reslist.tech}
												<tr><td width="50%">{$LNG.tech.{$Element}}:</td><td width="50%"><input type="text" name="element_{$Element}" value="0" pattern="[0-9]*"></td></tr>
												{/foreach}
												</table>

												<!-- Schiffe -->
												<table width="760px" style="color:#000">
												<tr>
														<th colspan="2">{$LNG.tech.200}</th>
												</tr>
												{foreach item=Element from=$reslist.fleet}
												<tr><td width="50%">{$LNG.tech.{$Element}}:</td><td width="50%"><input type="text" name="element_{$Element}" value="0" pattern="[0-9]*"></td></tr>
												{/foreach}
												</table>

												<!-- Verteidigung -->
												<table width="760px" style="color:#000">
												<tr>
														<th colspan="2">{$LNG.tech.400}</th>
												</tr>
												{foreach item=Element from=$reslist.defense}
												<tr><td width="50%">{$LNG.tech.{$Element}}:</td><td width="50%"><input type="text" name="element_{$Element}" value="0" pattern="[0-9]*"></td></tr>
												{/foreach}
												</table>

												<!-- Offiziere -->
												<table width="760px" style="color:#000">
												<tr>
														<th colspan="2">{$LNG.tech.600}</th>
												</tr>
												{foreach item=Element from=$reslist.officier}
												<tr><td width="50%">{$LNG.tech.{$Element}}:</td><td width="50%"><input type="text" name="element_{$Element}" value="0" pattern="[0-9]*"></td></tr>
												{/foreach}
												</table>


												<table width="760px" style="color:#000">
												<tr>
														<td>
														 	<button class="btn btn-success btn-xs" type="submit">{$LNG.up_submit} <i class="fa fa-arrow-right"></i></button>
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
	$('input[type="checkbox"]').removeClass('form-control').addClass('switch').attr('data-on-color','success')
	.attr('data-off-color','danger');
	$('td').css('padding','10px')
</script>
{include file="overall_footer.tpl"}