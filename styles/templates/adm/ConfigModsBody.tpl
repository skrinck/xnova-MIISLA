{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<div class="content-wrapper">
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['general_setting']}</span> - {$LNG['mu_configmods']}</h4>
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
            <li><a href="admin.php?page=configmods">{$LNG['general_setting']}</a></li>
            <li class="active">{$LNG['mu_configmods']}</li>
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
                        {$LNG['mu_configmods']}
                        <a class="control-arrow" data-toggle="collapse" data-target="#Frame8">
                            <i class="icon-circle-down2"></i>
                        </a>
                    </legend>
                    <div class="collapse in" id="Frame8">
                        <center>
                            <form action="" method="post">
                                <input type="hidden" name="opt_save" value="1">
                                <table width="70%" cellpadding="2" cellspacing="2">
                                    <tr>
                                        <th colspan="2">{$LNG.msg_expedition}</th><th>&nbsp;</th>
                                    </tr>
                                    <tr>
                                        <td>{$LNG.msg_expedition_active}<br></td>
                                        <td>
                                            <!-- <input name="expedition_limit_res_active"{if $expedition_limit_res_active} checked="checked"{/if} type="checkbox"> -->
                                            <input name="expedition_limit_res_active"{if $expedition_limit_res_active} checked="checked"{/if} type="checkbox"></td>
                                        </td>
                                        <td><img src="./styles/resource/images/admin/i.gif" width="16" height="16" alt="" class="tooltip" data-tooltip-content="{$LNG.msg_expedition_active_desc}"></td>
                                    </tr>
                                    <tr>
                                        <td>{$LNG.msg_expedition_active_price}</td>
                                        <td><input name="expedition_limit_res" class="form-control" maxlength="40" size="60" value="{$expedition_limit_res}" type="text"></td>
                                        <td><img src="./styles/resource/images/admin/i.gif" width="16" height="16" alt="" class="tooltip" data-tooltip-content="{$LNG.msg_expedition_active_price_desc}"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <button type="submit" class="btn btn-primary">{$LNG.se_save_parameters}<i class="icon-arrow-right14 position-right"></i></button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </center>
                    </div></div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
<script>
   $('tr').prop('heigth','2');
    $('select').css('width','40%').select2();
    $('textarea').addClass('form-control').css('width','80%').addClass('pull-left').css('margin-right','10px');
    $('input').addClass('form-control').css('width','40%').addClass('pull-left').css('margin-right','10px');
    $('input[type="checkbox"]').removeClass('form-control').addClass('switch').attr('data-on-color','success')
    .attr('data-off-color','danger')
</script>
</body>
{include file="overall_footer.tpl"}