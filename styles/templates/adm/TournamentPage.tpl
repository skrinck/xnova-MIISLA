{include file="overall_header.tpl"}
<style type="text/css">
.ship_content {
    float: left;
    width: 80px;
    height: 80px;
    overflow: hidden;
    margin: 9px;
    cursor: pointer;
    border: 1px solid transparent;
}

.ship_item. {
    width: 100%;
    height: 100%;
}

.ship_item img {
    width: 100%;
    height: 100%;
}
.ship_content.active {
    border: 1px solid darkred;
    box-shadow: 0px 0px 6px 0px darkred;
}
.ship_content:hover {
    border: 1px solid darkred;
    box-shadow: 0px 0px 6px 0px darkred;
}
.ship_content.active .ship_item:before {
    content: "";
    position: absolute;
    background: linear-gradient(to top, #800303bd 30%, transparent);
    width: 80px;
    height: 80px;
}
</style>
{include file="overall_menu.tpl"}
<div class="content-wrapper">
	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['mu_users_settings']}</span> - {$LNG['mu_woa']}</h4>
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
				<li><a href="admin.php?page=tournament">{$LNG['mu_settings_mod']}</a></li>
				<li>{$LNG['mu_woa']}</li>
			</ul>

			<ul class="breadcrumb-elements">
				<li><a href="mailto:rayco.garcia13@nauta.cu"><i class="icon-comment-discussion position-left"></i> {$LNG['ow_support']}</a></li>
			</ul>
		</div>
	</div>
	<!-- /page header -->
<div class="content">
<div class="panel panel-flat">
<div class="panel-body">
<fieldset>
	<legend class="text-semibold">
		<i class="icon-file-text2 position-left"></i>
		{$LNG['mu_woa_desc']}
		<a class="control-arrow" data-toggle="collapse" data-target="#Frame12">
			<i class="icon-circle-down2"></i>
		</a>
	</legend>
	<div class="collapse in" id="Frame12">
<table>
	<div class="row">
<div class="alert alert-warning">Testo de prueba</div>
		<div class="card-deck">
			<form method="POST">
				<div>
					<div style="padding-left: 50px">
						<label>
							Activo
							<input type="checkbox" name="status" {if $tournament.status=='1'}checked{/if}>
						</label>
					</div>
					<legend class="text-semibold">
					Naves no permitidas					
					</legend>
					<div>
						{foreach item=ship key=ship_id from=$tournament.ships}
							<div class="ship_content{if $ship==1} active{/if}" id="ship_{$ship_id}" data-ship="{$ship_id}">
								<div class="ship_item">
									<img src="styles/theme/mdy/gebaeude/{$ship_id}.gif" title="{$LNG.tech.{$ship_id}}">
								</div>
							</div>
						{/foreach}
							<input type="hidden" name="ships" id="ships" value="{foreach item=ship key=ship_id from=$tournament.ships}{$ship_id},{$ship};{/foreach}">
					</div>
					<div style="padding-top: 200px"><input type="submit" name="Actualizar" class="btn btn-success btn-xs"></div>
				</div>
			</form>
		</div>
	</div>
</table>
</div>
<fieldset>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
	$('[id*="ship_"]').click(function(){
		$class = $(this).attr('class');
		$ships = $('#ships').val();
		ship = $(this).data('ship');

		if($class == 'ship_content active'){
			$(this).removeClass('active');
			$ships = $ships.replace(ship+',1;', ship+',0;');
		}else{
			$(this).addClass('active');
		    $ships = $ships.replace(ship+',0;', ship+',1;');
		}

		$('#ships').val($ships);
	});
</script>
{include file="overall_footer.tpl"}