                                    
{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['general_setting']}</span> - {$LNG['re_reset_universe']}</h4>
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
					<div class="panel panel-flat">
						<div class="panel-body">
							<legend class="text-semibold">
								<i class="icon-file-text2 position-left"></i>
								{$LNG['re_reset_universe']}
								<a class="control-arrow" data-toggle="collapse" data-target="#table1">
									<i class="icon-circle-down2"></i>
								</a>
							</legend>
							<div class="collapse in" id="Frame8">
                                    <form action="" method="post" onsubmit="return confirm('{$re_reset_universe_confirmation}');">
                                        <table width="40%">
                                            <tr><th colspan="2">{$re_player_and_planets}</th></tr>
                                            <tr><td style="text-align:left">{$re_reset_player}</td><td style="text-align:right"><input type="checkbox" name="players"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_planets}</td><td style="text-align:right"><input type="checkbox" name="planets"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_moons}</td><td style="text-align:right"><input type="checkbox" name="moons"></td></tr>

                                            <tr><th colspan="2">{$re_defenses_and_ships}</th></tr>
                                            <tr><td style="text-align:left">{$re_defenses}</td><td style="text-align:right"><input type="checkbox" name="defenses"></td></tr>
                                            <tr><td style="text-align:left">{$re_ships}</td><td style="text-align:right"><input type="checkbox" name="ships"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_hangar}</td><td style="text-align:right"><input type="checkbox" name="h_d"></td></tr>

                                            <tr><th colspan="2">{$re_buldings}</th></tr>
                                            <tr><td style="text-align:left">{$re_buildings_pl}</td><td style="text-align:right"><input type="checkbox" name="edif_p"></td></tr>
                                            <tr><td style="text-align:left">{$re_buildings_lu}</td><td style="text-align:right"><input type="checkbox" name="edif_l"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_buldings}</td><td style="text-align:right"><input type="checkbox" name="edif"></td></tr>

                                            <tr><th colspan="2">{$re_inve_ofis}</th></tr>
                                            <tr><td style="text-align:left">{$re_ofici}</td><td style="text-align:right"><input type="checkbox" name="ofis"></td></tr>
                                            <tr><td style="text-align:left">{$re_investigations}</td><td style="text-align:right"><input type="checkbox" name="inves"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_invest}</td><td style="text-align:right"><input type="checkbox" name="inves_c"></td></tr>

                                            <tr><th colspan="2">{$re_resources}</th></tr>
                                            <tr><td style="text-align:left">{$re_resources_dark}</td><td style="text-align:right"><input type="checkbox" name="dark"></td></tr>
                                            <tr><td style="text-align:left">{$re_resources_met_cry}</td><td style="text-align:right"><input type="checkbox" name="resources"></td></tr>

                                            <tr><th colspan="2">{$re_general}</th></tr>
                                            <tr><td style="text-align:left">{$re_reset_notes}</td><td style="text-align:right"><input type="checkbox" name="notes"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_rw}</td><td style="text-align:right"><input type="checkbox" name="rw"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_buddies}</td><td style="text-align:right"><input type="checkbox" name="friends"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_allys}</td><td style="text-align:right"><input type="checkbox" name="alliances"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_fleets}</td><td style="text-align:right"><input type="checkbox" name="fleets"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_errors}</td><td style="text-align:right"><input type="checkbox" name="errors"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_banned}</td><td style="text-align:right"><input type="checkbox" name="banneds"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_messages}</td><td style="text-align:right"><input type="checkbox" name="messages"></td></tr>
                                            <tr><td style="text-align:left">{$re_reset_statpoints}</td><td style="text-align:right"><input type="checkbox" name="statpoints"></td></tr>
                                            <tr><td style="text-align:left">{$re_comments}</td><td style="text-align:right"><input type="checkbox" name="comments"></td></tr>
                                             <tr><td style="text-align:left">{$re_adm_logins}</td><td style="text-align:right"><input type="checkbox" name="admlogins"></td></tr>

                                            <tr><th style="text-align:left;">{$re_reset_all}</th><th style="text-align:right;margin-right:2px;"><input type="checkbox" name="resetall" onclick="$('input').attr('checked', this.checked ? 'checked' : false)"></th></tr>


                                            <tr><td colspan="2" height="60">
												<button class="btn btn-info" type="submit">{$button_submit} <i class="fa fa-arrow-right"></i></button>
											</td></tr>
                                        </table>
                                    </form>
                                </div>
							</div>
						</div>
					</div>
				</div>
{include file="overall_footer.tpl"}
