{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['mu_users_settings']}</span> - {$LNG['mu_asteroid']}</h4>
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
                <li><a href="admin.php?page=abonus">{$LNG['settings_mods']}</a></li>
                <li>{$LNG['mu_asteroid']}</li>
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
                            {$LNG['mu_asteroid_desc']}
                            <a class="control-arrow" data-toggle="collapse" data-target="#Frame1">
                                <i class="icon-circle-down2"></i>
                            </a>
                        </legend>
                        <div class="collapse in" id="Frame1">
                            <table width="100%" cellpadding="2" cellspacing="2">
                                <form action="" method="post">
                                <input type="hidden" name="opt_save" value="1">
                                    <tr class="title">
                                        <th colspan="3" class="text-center">{$LNG.msg_asteroid}</th>
                                    </tr>
                                    <tr>
                                        <td>{$LNG.msg_asteroid_metal}</td>
                                        <td><input class="align-middle form-control" name="asteroid_metal" maxlength="40" size="60" value="{$asteroid_metal}" type="text"></td>
                                        <td><img src="./styles/resource/images/admin/i.gif" width="16" height="16" alt="" class="tooltip" data-tooltip-content="{$LNG.msg_asteroid_metal_desc}"></td>
                                    </tr>
                                    <tr>
                                        <td>{$LNG.msg_asteroid_crystal}</td>
                                        <td><input class="align-middle form-control" name="asteroid_crystal" maxlength="40" size="60" value="{$asteroid_crystal}" type="text"></td>
                                        <td><img src="./styles/resource/images/admin/i.gif" width="16" height="16" alt="" class="tooltip" data-tooltip-content="{$LNG.msg_asteroid_crystal_desc}"></td>
                                    </tr>
                                    <tr>
                                        <td>{$LNG.msg_asteroid_deuterium}</td>
                                        <td><input class="align-middle form-control" name="asteroid_deuterium" maxlength="40" size="60" value="{$asteroid_deuterium}" type="text"></td>
                                        <td><img src="./styles/resource/images/admin/i.gif" width="16" height="16" alt="" class="tooltip" data-tooltip-content="{$LNG.msg_asteroid_deuterium_desc}"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><input value="{$LNG.se_save_parameters}" type="submit"></td>
                                    </tr>
                                </form>
                            </table>
                        </div>
                    <fieldset>
                </div>
            </div>
        </div>
    </div>
</div>
{include file="overall_footer.tpl"}
