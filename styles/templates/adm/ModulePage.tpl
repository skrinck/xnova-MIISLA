{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['general_setting']}</span> - {$LNG['mu_module']}</h4>
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
							<li class="active">{$LNG['mu_module']}</li>
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
									{$mod_module}
									<a class="control-arrow" data-toggle="collapse" data-target="#Frame1">
										<i class="icon-circle-down2"></i>
									</a>
								</legend>

								<div class="collapse in" id="Frame1">
									<table class="table table-hover">
									<tr>
										<td colspan="3" class="text-center alert alert-info">
											<span class=""><strong>{$mod_info}</strong><span>
										</td>
									</tr>
									{foreach key=ID item=Info from=$Modules}
									<tr>
										<td>{$Info.name}</td>
										{if $Info.state == 1}
											<td style="color:green"><b>{$mod_active}</b></td>
											<td style="padding:10px"><a class="btn btn-success btn-xs" href="?page=module&amp;mode=deaktiv&amp;id={$ID}">{$mod_change_deactive}</a></td>
										{else}
											<td style="color:red"><b>{$mod_deactive}</b></td>
											<td style="padding:10px"><a class="btn btn-danger btn-xs" href="?page=module&amp;mode=aktiv&amp;id={$ID}">{$mod_change_active}</a></td>
										{/if}
										</tr>
									{/foreach}
									</table>
								</div>
							</fieldset>
						</div>
					</div>
				</div>

{include file="overall_footer.tpl"}