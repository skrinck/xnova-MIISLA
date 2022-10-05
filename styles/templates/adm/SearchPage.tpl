{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['se_search']}</span> - {$LNG['se_search_title']}</h4>
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
							<li><a href="admin.php?page=search">{$LNG['se_search']}</a></li>
							<li class="active">{$LNG['se_search_title']}</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li><a href="mailto:rayco.garcia13@nauta.cu"><i class="icon-comment-discussion position-left"></i> {$LNG['ow_support']}</a></li>
						</ul>
					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">
				<div class="panel panel-flat">
									<div class="panel-body">
										<fieldset>
											<legend class="text-semibold">
												<i class="icon-file-text2 position-left"></i>
												{$LNG['se_search_title']}
												<a class="control-arrow" data-toggle="collapse" data-target="#demo2">
													<i class="icon-circle-down2"></i>
												</a>
											</legend>
											<div class="collapse in" id="demo2">
												<form action="" method="POST">
													<table class="botones" style="with:100%">
														<tr>
															<td class="transparent left">
																<input type="checkbox" class="switch" data-on-color="success" data-off-color="danger" {$minimize} name="minimize">
																<input class="btn btn-info btn-xs ml-5" type="submit" value="{$se_contrac}" class="button">
																<img src="styles/resource/images/admin/GO.png" onClick="javascript:$('#seeker').slideToggle();" class="tooltip mt-10 ml-10" style="float: right;position: initial" title="{$ac_minimize_maximize}">
															</td>
														</tr>
													</table>
												</form>
												<form action="" method="POST">
														<div id="seeker" {$diisplaay} class="table-responsive">
															<table class="table col-md-12">
																<tr class="title">
																	<th colspan="8" class="text-center">
																		{$se_search_title}
																	</th>
																</tr>
																<tr>
																	<td colspan="6">
																		<input type="text" class="form-control" name="key_user" placeholder="{$se_intro}" value="{$search}">
																	</td>
																</tr>
																<tr class="text-center">
																	<td>
																		{$se_type_typee}
																	</td>
																	<td>
																		{$se_search_in}
																	</td>
																	<td>
																		{$se_filter_title}
																	</td>
																	<td>
																		{$se_limit}
																	</td>
																	<td>
																		{$se_asc_desc}
																	</td>
																	{if $OrderBYParse}
																	<td>
																		{$se_search_order}
																	</td>
																	{/if}
																	<td>
																		&nbsp;
																	</td>
																</tr>
																<tr>
																<td>
																	{html_options name=search options=$Selector.list selected=$SearchFile}
																</td>
																<td>
																	{html_options name=search_in options=$Selector.search selected=$SearchFor}
																</td>
																<td>
																	{html_options name=fucki options=$Selector.filter selected=$Searchmethod}
																</td>
																<td>
																	{html_options name=limit options=$Selector.limit selected=$limit}
																</td>
																<td>
																	{html_options name=key_acc options=$Selector.order selected=$OrderBY}
																</td>
																{if $OrderBYParse}
																<td>
																	{html_options name=key_order options=$OrderBYParse selected=$Order}
																</td>
																{/if}
																<td>
																	<input class="btn btn-dark btn-xs" type="submit" value="{$se_search}">
																</td>
															</tr>
															{if !empty($error)}
															<tr>
																<td colspan="8">
																	<span style="color:red">{$error}</span>
																</td>
															</tr>
															{/if}
															</table>
														</div>
														<br>
														<table class="table">
															{$PAGES}
														</table>
														<br>
														<div class="table table-responsive">
															{$LIST}
														</div>
														<br>
														<table class="table">
															{$PAGES}
														</table>
													</div>
												</form>
										</fieldset>
									</div>
<script>
$('td').css('padding','10px');
$('select').select2();
</script>
{include file="overall_footer.tpl"}