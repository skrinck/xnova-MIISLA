{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['ma_message']}</h4>
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
                                                    {$LNG['ad_editor_title']}
                                                    <a class="control-arrow" data-toggle="collapse" data-target="#demo2">
                                                        <i class="icon-circle-down2"></i>
                                                    </a>
                                                </legend>
                                                <div class="collapse in" id="demo2">
                                        <table style="width:519px;">
                                            <tr>
                                                <th>{$fcm_info}</th>
                                            </tr>
                                            <tr>
                                                <td>{$mes}</td>
                                            </tr>
                                        </table>
                                  </div>
                                </div>
                        </fieldset>
                    </div>
                </div>
{include file="overall_footer.tpl"}