{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['general_setting']}</span> - {$ad_authlevel_title}</h4>
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
							<li><a href="admin.php?page=accountdata">{$LNG['general_setting']}</a></li>
							<li class="active">{$ad_authlevel_title}</li>
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
							<legend class="text-semibold">
								<i class="icon-file-text2 position-left"></i>
								{$ad_authlevel_title}
								<a class="control-arrow" data-toggle="collapse" data-target="#table1">
									<i class="icon-circle-down2"></i>
								</a>
							</legend>
							<div class="collapse in" id="Frame8">
								<form action="" method="post">
									<input name="action" type="hidden" value="send">
									<input name="id_1" type="hidden" value="{$id}">
									<table class="table">
											<th>
												{$User['username']}
											</th>
											<th>
												<a href="javascript:;" onclick="$('.no').removeAttr('checked');$('.yes').prop('checked', 'checked');">{$yesorno.1}</a> 
											</th>
											<th>
												<a href="javascript:;" onclick="$('.yes').removeAttr('checked');$('.no').prop('checked', 'checked');">{$yesorno.0}</a>
											</th>
										</tr>
										{foreach item=File from=$Files}
										<tr>
											<td>
												{$File}
											</td>
											<td>
												{$yesorno.1} <input class="yes" name="rights[{$File}]" type="radio"{if $Rights.$File == 1} checked="checked"{/if} value="1"> 
											</td>
											<td>
												{$yesorno.0} <input class="no" name="rights[{$File}]" type="radio"{if $Rights.$File != 1} checked="checked"{/if} value="0">
											</td>
										</tr>
										{/foreach}
										<tr><td colspan="3">
										<br>
											<button class="btn btn-info" type="submit">{$button_submit} <i class="fa fa-arrow-right"></i></button>
										</td></tr>
									</table>
								</form>
								</div>
							</div>
						</div>
					</div>
<script>
$('td').css('padding','10px')
</script>
{include file="overall_footer.tpl"}