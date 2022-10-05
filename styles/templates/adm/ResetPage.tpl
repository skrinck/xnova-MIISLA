{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['adm_cp_title']}</span> - {$LNG['re_reset_universe']}</h4>
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
				<li>{$LNG['adm_cp_title']}</li>
				<li class="active">{$LNG['re_reset_universe']}</li>
			</ul>

			<ul class="breadcrumb-elements">
				<li><a href="mailto:rayco.garcia13@nauta.cu"><i class="icon-comment-discussion position-left"></i> {$LNG['ow_support']}</a></li>
			</ul>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">
		<!-- Dashboard content -->
		<div class="row">
			<div class="panel panel-flat">
				<div class="panel-body">
					<legend class="text-semibold">
						<i class="icon-file-text position-left"></i>
						{$LNG['re_reset_universe']}
						<a class="control-arrow" data-toggle="collapse" data-target="#table1">
							<i class="icon-circle-down2"></i>
						</a>
					</legend>
					<div class="collapse in" id="table1">
                        <form action="" method="post" onsubmit="return confirm('{$re_reset_universe_confirmation}');">
							<fieldset>
								<legend class="text-semibold">
									<i class="icon-file-text2 position-left"></i>
									{$re_player_and_planets}
								</legend>

								<div class="collapse in" id="demo1">
									<table width="40%">
                                        <tr><td style="text-align:left">{$re_reset_player}</td><td style="text-align:right"><input type="checkbox" name="players"></td></tr>
                                        <tr><td style="text-align:left">{$re_reset_planets}</td><td style="text-align:right"><input type="checkbox" name="planets"></td></tr>
                                        <tr><td style="text-align:left">{$re_reset_moons}</td><td style="text-align:right"><input type="checkbox" name="moons"></td></tr>
                                    </table>
									
								</div><!-- /demo1 end -->
							</fieldset>
							<fieldset>
								<legend class="text-semibold">
									<i class="icon-file-text2 position-left"></i>
									{$re_defenses_and_ships}
								</legend>

								<div class="collapse in" id="demo2">
									<table width="40%">
                                        <tr><td style="text-align:left">{$re_defenses}</td><td style="text-align:right"><input type="checkbox" name="defenses"></td></tr>
                                            <tr><td style="text-align:left">{$re_ships}</td><td style="text-align:right"><input type="checkbox" name="ships"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_hangar}</td><td style="text-align:right"><input type="checkbox" name="h_d"></td></tr>
                                    </table>
									
								</div><!-- /demo2 end -->
							</fieldset>
							<fieldset>
								<legend class="text-semibold">
									<i class="icon-file-text2 position-left"></i>
									{$re_buldings}
								</legend>

								<div class="collapse in" id="demo3">
									<table width="40%">
                                        <tr><td style="text-align:left">{$re_buildings_pl}</td><td style="text-align:right"><input type="checkbox" name="edif_p"></td></tr>
                                            <tr><td style="text-align:left">{$re_buildings_lu}</td><td style="text-align:right"><input type="checkbox" name="edif_l"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_buldings}</td><td style="text-align:right"><input type="checkbox" name="edif"></td></tr>
                                    </table>
									
								</div><!-- /demo2 end -->
							</fieldset>
							<fieldset>
								<legend class="text-semibold">
									<i class="icon-file-text2 position-left"></i>
									{$re_inve_ofis}
								</legend>

								<div class="collapse in" id="demo4">
									<table width="40%">
                                       <tr><td style="text-align:left">{$re_ofici}</td><td style="text-align:right"><input type="checkbox" name="ofis"></td></tr>
                                            <tr><td style="text-align:left">{$re_investigations}</td><td style="text-align:right"><input type="checkbox" name="inves"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_invest}</td><td style="text-align:right"><input type="checkbox" name="inves_c"></td></tr>
                                    </table>
									
								</div><!-- /demo4 end -->
							</fieldset>
							<fieldset>
								<legend class="text-semibold">
									<i class="icon-file-text2 position-left"></i>
									{$re_resources}
								</legend>

								<div class="collapse in" id="demo5">
									<table width="40%">
                                        <tr><td style="text-align:left">{$re_resources_met_cry}</td><td style="text-align:right"><input type="checkbox" name="resources"></td></tr>
                                       	<tr><td style="text-align:left">{$re_resources_dark}</td><td style="text-align:right"><input type="checkbox" name="dark"></td></tr>
                                       	<tr><td style="text-align:left">{$re_resources_antimatter}</td><td style="text-align:right"><input type="checkbox" name="antimatter"></td></tr>
                                    </table>
									
								</div><!-- /demo5 end -->
							</fieldset>
							<fieldset>
								<legend class="text-semibold">
									<i class="icon-file-text2 position-left"></i>
									{$re_general}
								</legend>

								<div class="collapse in" id="demo6">
									<table width="40%">
                                       <tr><td style="text-align:left">{$re_reset_notes}</td><td style="text-align:right"><input type="checkbox" name="notes"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_rw}</td><td style="text-align:right"><input type="checkbox" name="rw"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_buddies}</td><td style="text-align:right"><input type="checkbox" name="friends"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_allys}</td><td style="text-align:right"><input type="checkbox" name="alliances"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_fleets}</td><td style="text-align:right"><input type="checkbox" name="fleets"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_errors}</td><td style="text-align:right"><input type="checkbox" name="errors"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_banned}</td><td style="text-align:right"><input type="checkbox" name="banneds"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_messages}</td><td style="text-align:right"><input type="checkbox" name="messages"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_statpoints}</td><td style="text-align:right"><input type="checkbox" name="statpoints"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_comments}</td><td style="text-align:right"><input type="checkbox" name="comments"></td></tr>
                                             <tr><td style="text-align:left">{$re_reset_adm_logins}</td><td style="text-align:right"><input type="checkbox" name="admlogins"></td></tr>
                                             <tr><td style="text-align:left">{$re_reset_bots}</td><td style="text-align:right"><input type="checkbox" name="bots"></td></tr>
                                             <tr><td style="text-align:left">{$re_reset_notifications}</td><td style="text-align:right"><input type="checkbox" name="notifications"></td></tr>
                                             <tr><td style="text-align:left">{$re_reset_messages_chat}</td><td style="text-align:right"><input type="checkbox" name="mchat"></td></tr>
                                             <tr><td style="text-align:left">{$re_reset_cronjob}</td><td style="text-align:right"><input type="checkbox" name="cronjoblogs"></td></tr>
                                             <tr><td style="text-align:left">{$re_reset_acs}</td><td style="text-align:right"><input type="checkbox" name="acs"></td></tr>
                                             <tr><td style="text-align:left">{$re_reset_tickets}</td><td style="text-align:right"><input type="checkbox" name="tickets"></td></tr>
                                             <tr><td style="text-align:left">{$re_reset_tracking}</td><td style="text-align:right"><input type="checkbox" name="tracking"></td></tr>
                                             <tr><td style="text-align:left">{$re_reset_fleet_logs}</td><td style="text-align:right"><input type="checkbox" name="fleetlogs"></td></tr>
                                             <tr><td style="text-align:left">{$re_reset_savedcoord}</td><td style="text-align:right"><input type="checkbox" name="savedcoord"></td></tr>
                                    </table>
									
								</div><!-- /demo6 end -->
							</fieldset>

							<table width="40%"><hr>
								<tr><th style="text-align:left;">{$re_reset_all}</th><th style="text-align:right;margin-right:2px;"><input type="checkbox" name="resetall" onclick="$('input').attr('checked', this.checked ? 'checked' : false)"></th>
								</tr>


								<tr><td colspan="2" height="60">
									<button class="btn btn-info" type="submit">{$button_submit} <i class="fa fa-arrow-right"></i></button>
								</td></tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- /dashboard content -->

{include file="overall_footer.tpl"}