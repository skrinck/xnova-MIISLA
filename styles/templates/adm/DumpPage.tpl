{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['general_setting']}</span> - {$LNG['mu_universe']}</h4>
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
							<li>{$LNG['mu_universe']}</li>
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
								{$LNG['mu_universe']}
								<a class="control-arrow" data-toggle="collapse" data-target="#Frame8">
									<i class="icon-circle-down2"></i>
								</a>
							</legend>
							<div class="collapse in" id="Frame8">
								<form action="admin.php?page=dump" method="post">
									<input type="hidden" name="action" value="dump">
									<table class="table569">
										<tr>
											<th colspan="2">{$LNG.du_header}</th>
										</tr>
										<tr>
											<td>{$LNG.du_choose_tables}</td>
											<td>
												<div><input type="checkbox" id="selectAll"><label for="selectAll">{$LNG.du_select_all_tables}</label></div>
												<div>{html_options multiple="multiple" style="width:250px" size="10" name="dbtables[]" id="dbtables" values=$dumpData.sqlTables output=$dumpData.sqlTables}</div>
											</td>
										</tr>
										<tr>
											<td colspan="2"><button class="btn btn-info" type="submit">{$LNG.du_submit} <i class="fa fa-arrow-right"></i></button></td>
										</tr>
									</table>
								</form>
							</div>
						</div>
					</div>
<script>
$(function() {
	$('#selectAll').on('click', function() {
		if($('#selectAll').prop('checked') === true)
		{
			$('#dbtables').val(function() {
				return $(this).children().map(function() { 
					return $(this).attr('value');
				}).toArray();
			});
		}
		else
		{
			$('#dbtables').val(null);
		}
	});
});

	$('textarea').addClass('form-control').css('width','100%').addClass('pull-left').css('margin-right','10px');
	$('input').addClass('form-control').css('width','40%').addClass('pull-left').css('margin-right','10px');
	$('input[type="checkbox"]').removeClass('form-control').addClass('switch').attr('data-on-color','success')
	.attr('data-off-color','danger')

	$(document).ready(function(){
	$('.bootstrap-switch').css('margin-top','5px');
	$('.bootstrap-switch').css('margin-bottom','5px');
	$('td').css('padding','5px');
})	
</script>
{include file="overall_footer.tpl"}