<?php
///ally_id
function SetAliados(&$attackers, &$defenders)
{
    $db = Database::get();

    $allyAttack = array();
    $allyDeff   = array();
    $LNG = array();

    foreach ($attackers as $fleetID => $attacker)
    {
        $Player = $attacker['player'];

        if ($Player['ally_id'] == 0) continue;

        $allyAttack[$Player['id']] = getUserAlly($Player['ally_id']);

        $LNG[$Player['id']]    = new Language($Player['lang']);
        $LNG[$Player['id']]->includeData(array('L18N', 'INGAME', 'TECH', 'CUSTOM','MODs'));

    }

    foreach ($defenders as $fleetID => $defender)
    {
        $Player = $defender['player'];

        if ($Player['ally_id'] == 0) continue;

        $allyDeff[$Player['id']] = getUserAlly($Player['ally_id']);

    }

    $sql = "UPDATE %%USERS%% SET ally_id = 0, ally_register_time = 0, ally_rank_id = 0, ally_date = :ally_date WHERE id = :id;";

    foreach ($allyAttack as $Attack => $AllyAttData) {

        foreach ($allyDeff as $Deff => $AllyDeffData) {

            if ($Attack == $Deff) continue;

            if ($AllyAttData['id'] == $AllyDeffData['id']) {

                if (array_key_exists($AllyAttData['ally_owner'], $allyAttack)) {

                    $config = Config::get($AllyDeffData['ally_universe']);

                    $db->update($sql, array(
                        ':id'           => $Deff,
                        ':ally_date'    => $config->ally_date + TIMESTAMP,
                    ));

                    $message = sprintf($LNG[$Attack]['ally_msg_destierro'], getUserName($Deff));

                    PlayerUtil::sendMessage($Attack, 0, $LNG[$Attack]['ally_destierro'], 2, $LNG[$Attack]['ally_destierro'],
                    $message, TIMESTAMP, NULL, 1, $AllyAttData['ally_universe']);

                } else {

                    $config = Config::get($AllyAttData['ally_universe']);

                    $db->update($sql, array(
                        ':id'           => $Attack,
                        ':ally_date'    => $config->ally_date + TIMESTAMP,
                    ));

                    $message = sprintf($LNG[$Attack]['ally_msg_expulcion'], $AllyAttData['ally_name']);

                    PlayerUtil::sendMessage($Attack, 0, $LNG[$Attack]['ally_expulcion'], 2, $LNG[$Attack]['ally_expulcion'],
                    $message, TIMESTAMP, NULL, 1, $AllyAttData['ally_universe']);
                }
            }
        }
    }
}


