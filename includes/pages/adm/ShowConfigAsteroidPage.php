<?php
/**
 * 2moons-2.6
 * The project is reserved for its owner for any bug or question you can contact him
 * Created by Moon Dark v2.6.
 * User: YamilRH (ireadigos@gmail.com)
 * Copyright: 2020 - YamilRH
 * Date: 2/08/2020
 * File: ShowConfigAsteroidPage.php
 * Version: 1.0.0
 */
if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");

function ShowConfigAsteroidPage()
{
    global $LNG;
    $config = Config::get(Universe::getEmulated());

    if (!empty($_POST))
    {
        $config_before = array(
            'asteroid_metal'				=> $config->asteroid_metal,
            'asteroid_crystal'              => $config->asteroid_crystal,
            'asteroid_deuterium'            => $config->asteroid_deuterium,
        );

        //$expedition_limit_res_active 				= isset($_POST['expedition_limit_res_active']) && $_POST['expedition_limit_res_active'] == 'on' ? 1 : 0;

        $asteroid_metal				= HTTP::_GP('asteroid_metal', 0);
        $asteroid_crystal               = HTTP::_GP('asteroid_crystal', 0);
        $asteroid_deuterium               = HTTP::_GP('asteroid_deuterium', 0);

        $config_after = array(
            'asteroid_metal'                => $asteroid_metal,
            'asteroid_crystal'              => $asteroid_crystal,
            'asteroid_deuterium'            => $asteroid_deuterium,
        );

        foreach($config_after as $key => $value)
        {
            $config->$key	= $value;
        }
        $config->save();

        $LOG = new Log(3);
        $LOG->target = 0;
        $LOG->old = $config_before;
        $LOG->new = $config_after;
        $LOG->save();
    }

        $template       = new template();
        $template->loadscript('filterlist.js');
        $template->loadscript('styles/assets/js/core/app.js');  
        $template->loadscript('styles/assets/js/plugins/tables/datatables/datatables.min.js');  
        $template->loadscript('styles/assets/js/plugins/forms/selects/select2.min.js'); 
        $template->loadscript('styles/assets/js/pages/datatables_advanced.js');

    $template->assign_vars(array(
        'asteroid_metal'                => $config->asteroid_metal,
        'asteroid_crystal'              => $config->asteroid_crystal,
        'asteroid_deuterium'            => $config->asteroid_deuterium,
    ));

    $template->show('ConfigAsteroidBody.tpl');
}
