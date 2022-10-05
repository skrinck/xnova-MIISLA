{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['ingame_setting']}</span> - {$LNG.mu_multiip_page}</h4>
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
							<li><a href="admin.php?page=commentlist">{$LNG['ingame_setting']}</a></li>
							<li class="active">{$LNG.mu_multiip_page}</li>
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
							<legend class="text-semibold">
								<i class="icon-file-text2 position-left"></i>
								{$LNG.mu_multiip_page}
								<a class="control-arrow" data-toggle="collapse" data-target="#table1">
									<i class="icon-circle-down2"></i>
								</a>
							</legend>
							<div class="collapse in" id="table1">
							<table id="dtable" style="width:100%">
								<thead>
									<tr>
										<th>{$LNG['se_input_ip']}</th>
										<th>{$LNG.se_id_owner}</th>
										<th>{$LNG.se_name}</th>
										<th>{$LNG.se_email}</th>
										<th>{$LNG.ac_register_time}</th>
										<th>{$LNG.ac_act_time}</th>
										<th>{$LNG.mip_known}</th>
									</tr>
								</thead>
								<tbody>
									{foreach $multiGroups as $IP => $Users}
									<tr>
										<td rowspan="{count($Users)}">{$IP} <br>Cuentas {count($Users)}</td>
										{foreach $Users as $ID => $User}
										<td class="left" style="padding:3px;">{$ID}</td>
										<td class="left" style="padding:3px;"><a href="admin.php?page=accountdata&id_u={$ID}">{$User.username} (?)</a></td>
										<td class="left" style="padding:3px;">{$User.email}</td>
										<td class="left" style="padding:3px;">{$User.register_time}</td>
										<td class="left" style="padding:3px;">{$User.onlinetime}</td>
										<td class="center" style="padding:3px;">{if ($User.isKnown != 0)}<a href="admin.php?page=multiips&amp;action=unknown&amp;id={$ID}"><img src="styles/resource/images/true.png"></a>{else}<a href="admin.php?page=multiips&amp;action=known&amp;id={$ID}"><img src="styles/resource/images/false.png"></a>{/if}</td>
										</tr>{if !$User@last}<tr>{/if}
										{/foreach}
									{/foreach}
								</tbody>	
							</table>
						</div>
					</div>

<script>
// $('#dtable').dataTable();
$('td').css('padding','10px');
$('select').select2();
</script>
{include file="overall_footer.tpl"}