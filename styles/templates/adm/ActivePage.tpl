{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
<div class="content-wrapper">
	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['ingame_setting']}</span> - {$LNG['mu_vaild_users']}</h4>
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
				<li><a href="admin.php?page=playerlist">{$LNG['ingame_setting']}</a></li>
				<li>{$LNG['mu_vaild_users']}</li>
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
						{$LNG.ap_nicht_aktivierte_user}
						<a class="control-arrow" data-toggle="collapse" data-target="#Frame8">
							<i class="icon-circle-down2"></i>
						</a>
					</legend>

					<div class="collapse in table-responsive" id="Frame8">
						<table class="table table-bordered table-hover datatable-highlight">
							<thead>
								<tr>
									<th>{$LNG.ap_id}</th>
									<th>{$LNG.ap_username}</th>
									<th>{$LNG.ap_datum}</th>
									<th>{$LNG.ap_email}</th>
									<th>{$LNG.ap_ip}</th>
									<th>{$LNG.ap_status}</th>
									<th>{$LNG.ap_del}</th>
								</tr>
							</thead>
							<tbody>
							{foreach name=User item=User from=$Users}
							<tr>
								<td>{$User.id}</td>
								<td>{$User.name}</td>
								<td><nobr>{$User.date}</nobr></td>
								<td>{$User.email}</td>
								<td>{$User.ip}</td>
								<td><a href="#" onclick="return activeUser({$User.id},'{$User.validationKey}');">{$LNG.ap_aktivieren}</a></td>
								<td><a href="?page=active&amp;action=delete&id={$User.id}" onclick="return confirm('{$LNG.ap_sicher}{$User.username} {$LNG.ap_entfernen}');"><i class="fas fa-times text-danger fa-2x"></i></a></td>
							</tr>
							{/foreach}
							</tbody>	
							<tr>
								<td colspan="8">{$LNG.ap_insgesamt} {count($Users)} {$LNG.ap_nicht_aktivierte}</td>
							</tr>
						</table>
					</div>
				</fieldset>
			</div>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
	function activeUser(validationID, validationKey) {
		$.getJSON('index.php?page=vertify&mode=json&i='+validationID+'&k='+validationKey, function(data){
			alert(data);
			parent.frames['Hauptframe'].location.reload();
		});
		return false;
	}
</script>
{include file="overall_footer.tpl"}