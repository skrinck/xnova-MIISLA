{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['general_setting']}</span> - {$LNG['mu_cronjob']}</h4>
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
							<li><a href="admin.php?page=cronjob">{$LNG['general_setting']}</a></li>
							<li class="active">{$LNG['mu_cronjob']}</li>
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
												{$LNG['mu_cronjob']}
												<a class="control-arrow" data-toggle="collapse" data-target="#Frame8">
													<i class="icon-circle-down2"></i>
												</a>
											</legend>
											<div class="collapse in" id="Frame8">
												<table class="table">
													{if !empty($error_msg)}
													{foreach from=$error_msg item=error}<tr><td colspan=2>{$error}</td></tr>{/foreach}
													{/if}
													<tr>
														<th colspan=3>{if $id == 0}{$LNG.cronjob_new}{else}{$LNG.cronjob_headline}{$id}{/if}</th>
													</tr>
													<form method="POST" action="">
													<input type="hidden" name="id" value="{$id}">
													<tr>
														<td>{$LNG.cronjob_name}</td>
														<td><input type="text" name="name" value="{$name}"></td>
														<td><img src="./styles/resource/images/admin/i.gif" width="16" height="16" alt="" class="tooltip" title="{$LNG.cronjob_desc_name}"></td>
													</tr>
													<tr>
													<td colspan=3>{$LNG.cronjob_desc}</td>
													</tr>
													<tr>
														<td>{$LNG.cronjob_min}</td>
														<td colspan=2><select style="height:100px;width:80px;" name="min[]" multiple="multiple">{html_options values=range(0, 59) output=range(0, 59) selected=$min}</select><br>
														<input name="min_all" id="min_all" type="checkbox" value="1" {if $min.0==="*"}checked{/if}><label for="min_all">{$LNG.cronjob_selectall}</label></td>
													</tr>
													<tr>
														<td>{$LNG.cronjob_hours}</td>
														<td colspan=2><select style="height:100px;width:80px;" name="hours[]" multiple="multiple">{html_options values=range(0, 23) output=range(0, 23) selected=$hours}</select><br>
														<input name="hours_all" id="hours_all" type="checkbox" value="1" {if $hours.0==="*"}checked{/if}><label for="hours_all">{$LNG.cronjob_selectall}</label></td>
													</tr>
													<tr>
														<td>{$LNG.cronjob_dom}</td>
														<td colspan=2><select style="height:100px;width:80px;" name="dom[]" multiple="multiple">{html_options values=range(1, 31) output=range(1, 31) selected=$dom}</select><br>
														<input name="dom_all" id="dom_all" type="checkbox" value="1" {if $dom.0==="*"}checked{/if}><label for="dom_all">{$LNG.cronjob_selectall}</label></td>
													</tr>
													<tr>
														<td>{$LNG.cronjob_month}</td>
														<td colspan=2><select style="height:100px;width:80px;" name="month[]" multiple="multiple">{html_options values=range(1, 12) output=$LNG.months selected=$month}</select><br>
														<input name="month_all" id="month_all" type="checkbox" value="1" {if $month.0==="*"}checked{/if}><label for="month_all">{$LNG.cronjob_selectall}</label></td>
													</tr>
													<tr>
														<td>{$LNG.cronjob_dow}</td>
														<td colspan=2><select style="height:100px;width:80px;" name="dow[]" multiple="multiple">{html_options values=range(0, 6) output=$LNG.week_day selected=$dow}</select><br>
														<input name="dow_all" id="dow_all" type="checkbox" value="1" {if $dow.0==="*"}checked{/if}><label for="dow_all">{$LNG.cronjob_selectall}</label></td>
													</tr>
													<tr>
														<td>{$LNG.cronjob_class}</td>
														<td>{html_options name="class" output=$avalibleCrons values=$avalibleCrons selected=$class}</td>
														<td><img src="./styles/resource/images/admin/i.gif" width="16" height="16" alt="" class="tooltip" title="{$LNG.cronjob_desc_class}"></td>
													</tr>
													<tr>
													<td colspan=3>
														<button type="submit" class="btn btn-primary">{$LNG['up_submit']}<i class="icon-arrow-right14 position-right"></i></button>
													</td>
													</form>
													</tr>
												</table>
											</div>
										</fieldset>
									</div>
									</div> 	
<script>
	$('select').css('width','50%')
	$('select[name="class"]').select2()
	$('input').addClass('form-control');
	$('input[type="checkbox"]').removeClass('form-control').addClass('switch').attr('data-on-color','success')
	.attr('data-off-color','danger');
	$('td').css('padding','10px')
</script>
</body>
{include file="overall_footer.tpl"}