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
												<table width="100%">
													<tr class="text-center">
														<td><a class="btn btn-default btn-xs" href="?page=create&amp;mode=user"><img src="./styles/resource/images/admin/arrowright.png" width="16" height="10"> {$new_creator_title_u}</a></td>
														<td><a class="btn btn-default btn-xs" href="?page=create&amp;mode=planet"><img src="./styles/resource/images/admin/arrowright.png" width="16" height="10"> {$new_creator_title_p}</a></td>
														<td><a class="btn btn-default btn-xs" href="?page=create&amp;mode=moon"><img src="./styles/resource/images/admin/arrowright.png" width="16" height="10"> {$new_creator_title_l}</a></td>
													</tr>
												</table>
											</div>
										</fieldset>
									</div>
								</div>

<script>
	$('td').css('padding','10px')
</script>
{include file="overall_footer.tpl"}