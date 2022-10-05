{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['log_ssettings']}</span> - {$LNG['ingame_setting']} - {$LNG['mu_chat']}</h4>
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
							<li>{$LNG['log_ssettings']}</li>
							<li>{$LNG['ingame_setting']}</li>
							<li class="active">{$LNG['mu_chat']}</li>
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
							<form class="form-horizontal" action="" method="post">
								<div class="panel panel-flat">


									<div class="panel-body">
										
										<fieldset>
											<legend class="text-semibold">
												<i class="icon-file-text2 position-left"></i>
												{$se_server_parameters}
												<a class="control-arrow" data-toggle="collapse" data-target="#Frame3">
													<i class="icon-circle-down2"></i>
												</a>
											</legend>
 
											<div class="collapse in" id="Frame3">
												<center>
						                            <form action="" method="post">
						                                <input type="hidden" name="opt_save" value="1">
						                                <table width="70%" cellpadding="2" cellspacing="2">
						                                	<tr>
						                                        <td>{$ch_closed}<br></td>
						                                        <td>
						                                            <input name="chat_closed"{if $chat_closed == '1'} checked="checked"{/if} type="checkbox"></td>
						                                        </td>
						                                    </tr>
						                                    <tr>
						                                        <td>{$ch_nickchange}<br></td>
						                                        <td>
						                                            <input name="chat_nickchange"{if $chat_nickchange == '1'} checked="checked"{/if} type="checkbox"></td>
						                                        </td>
						                                    </tr>
						                                    <tr>
						                                        <td>{$ch_logmessage}<br></td>
						                                        <td>
						                                            <input name="chat_logmessage"{if $chat_logmessage == '1'} checked="checked"{/if} type="checkbox"></td>
						                                        </td>
						                                    </tr>
						                                    <tr>
						                                        <td>{$ch_allowmes}<br></td>
						                                        <td>
						                                            <input name="chat_allowmes"{if $chat_allowmes == '1'} checked="checked"{/if} type="checkbox"></td>
						                                        </td>
						                                    </tr>
						                                    <tr>
						                                        <td>{$ch_allowchan}<br></td>
						                                        <td>
						                                            <input name="chat_allowchan"{if $chat_allowchan == '1'} checked="checked"{/if} type="checkbox"></td>
						                                        </td>
						                                    </tr>
						                                    <tr>
						                                        <td>{$ch_channelname}</td>
						                                        <td><input name="chat_channelname" class="form-control" value="{$chat_channelname}" type="text"></td>
						                                    </tr>
						                                    <tr>
						                                        <td>{$ch_botname}</td>
						                                        <td><input name="chat_botname" class="form-control" value="{$chat_botname}" type="text"></td>
						                                    </tr>
						                                    <tr>
						                                        <td colspan="3">
						                                            <input value="{$se_save_parameters}" type="submit">
						                                        </td>
						                                    </tr>
						                                </table>
						                            </form>
						                        </center>
												
											</div>
										</fieldset>
									</div>
								</div>
							</form>
							<!-- /a legend -->
{include file="overall_footer.tpl"}
