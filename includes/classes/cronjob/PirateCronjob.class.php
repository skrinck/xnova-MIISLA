<?php

/**
 *  2Moons
 *   by Yamil Readigos Hurtado 2019-2020
 *   by Rayco Garcia Fernandez 2020
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons Moon Dark
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @author Yamil Readigos Hurtado <ireadigos@gmail.com>
 * @author Rayco Garcia Fernandez <rayco.garcia13@nauta.cu>
 * @copyright 2020 YamilRH
 * @copyright 2020 Yamil Readigos Hurtado <ireadigos@gmail.com>
 * @licence MIT
 * @version 2.7
 * @link https://www.miisla.nat.cu
 */

require_once 'includes/classes/cronjob/CronjobTask.interface.php';

class PirateCronjob implements CronjobTask
{
	function run()
	{
        $langObjects    = array();
        $db = Database::get();

        $sql    = "SELECT DISTINCT id, lang FROM %%USERS%%";
        $totalPremiums = $db->select($sql, array(
        ));
        foreach($totalPremiums as $userInfo){
            
            if(!isset($langObjects[$userInfo['lang']]))
            {
                $langObjects[$userInfo['lang']] = new Language($userInfo['lang']);
                $langObjects[$userInfo['lang']]->includeData(array('L18N', 'INGAME', 'TECH', 'CUSTOM', 'MODs'));
            }
            
            $LNG    = $langObjects[$userInfo['lang']];
            $From       = '<span class="admin">System</span>';
            $Subject    = '<span class="admin">Evento Pirata</span>';             
            $message = '<span class="admin">'.sprintf($LNG['custom_pirate']).'
            </span>';
            PlayerUtil::sendMessage($userInfo['id'], 0, $From, 200, $Subject, $message, TIMESTAMP, NULL, 1, Universe::getEmulated());
        }


        // запрос рандомной планеты
        $sql = 'SELECT * FROM %%PLANETS%% WHERE last_update >= :last_update ORDER BY RAND() LIMIT 1;';
        $TargetAttack = $db->selectSingle($sql, array(
            ':last_update'  => TIMESTAMP-(60*60*24*24)
        ));


        // запрос данных игрока которого атакуют
        $sql = 'SELECT * FROM %%USERS%% WHERE id = :id;';
        $USERk = $db->selectSingle($sql, array(
            ':id'   => $TargetAttack['id_owner']
        ));

        //if ($USERk['urlaubs_modus'] == 1){ // если игрок в отпуске то нахуй на него нападать и выход
        //    exit;
        //}

            $planet    = $TargetAttack['planet'];
            $system   = $TargetAttack['system'];
            $galaxy    = $TargetAttack['galaxy'];
            $id        = $TargetAttack['id'];
            $TOwner = $USERk['id'];
            $planettype  = $TargetAttack['planet_type']; // всякая хрень про планету
            $fleetarray  = array();
           // $fleet_array = "";
           // 
           
           /*foreach($reslist['fleet'] as $Element){
                if($TargetAttack[$resource[$Element]] > 0 && $Element != 212){ // запрос кораблей на планке
                if ($Element == 202)
                {
                if(isset($fleetarray[204]))
                $fleetarray[204] += mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.3),ceil($TargetAttack[$resource[$Element]] * 0.5)); // если ид 204 есть на планете, то запрос колличества и выборка из этого колл-ва среднего рандома
                else
                $fleetarray[204] = mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.3),ceil($TargetAttack[$resource[$Element]] * 0.5));
                }
                elseif ($Element == 203){
                if(isset($fleetarray[204]))
                $fleetarray[204] += mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.3),ceil($TargetAttack[$resource[$Element]] * 0.5));
                else
                $fleetarray[204] = mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.3),ceil($TargetAttack[$resource[$Element]] * 0.5));
                }
                elseif ($Element == 208){
                if(isset($fleetarray[204]))
                $fleetarray[204] += mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.3),ceil($TargetAttack[$resource[$Element]] * 0.5));
                else
                $fleetarray[204] = mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.3),ceil($TargetAttack[$resource[$Element]] * 0.5));
                }
                elseif ($Element == 209){
                if(isset($fleetarray[204]))
                $fleetarray[204] += mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.3),ceil($TargetAttack[$resource[$Element]] * 0.5));
                else
                $fleetarray[204] = mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.3),ceil($TargetAttack[$resource[$Element]] * 0.5));
                }
                elseif ($Element == 210){
                if(isset($fleetarray[204]))     
                $fleetarray[204] += mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.3),ceil($TargetAttack[$resource[$Element]] * 0.5));
                else
                $fleetarray[204] = mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.3),ceil($TargetAttack[$resource[$Element]] * 0.5));
                }
                elseif ($Element == 217){
                if(isset($fleetarray[213]))     
                $fleetarray[213] += mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.4),ceil($TargetAttack[$resource[$Element]] * 0.5));
                else
                $fleetarray[213] = mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.4),ceil($TargetAttack[$resource[$Element]] * 0.5));
                }
                elseif ($Element == 219){
                if(isset($fleetarray[213]))
                $fleetarray[213] += mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.4),ceil($TargetAttack[$resource[$Element]] * 0.5));
                else
                $fleetarray[213] = mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.4),ceil($TargetAttack[$resource[$Element]] * 0.5));
                }
                else
                $fleetarray[$Element] = mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.5),ceil($TargetAttack[$resource[$Element]] * 0.6));                 
                }
            }

            //Start Foreach Defense
            foreach($reslist['defense'] as $Element){
                if($TargetAttack[$resource[$Element]] > 0){
                    if($Element == 401){
                        if(isset($fleetarray[204]))
                            $fleetarray[204] += mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.2),ceil($TargetAttack[$resource[$Element]] * 0.4));
                        else
                            $fleetarray[204] = mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.2),ceil($TargetAttack[$resource[$Element]] * 0.4));
                    }
                    elseif ($Element == 402){
                        if(isset($fleetarray[204]))
                            $fleetarray[204] += mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.2),ceil($TargetAttack[$resource[$Element]] * 0.4));
                        else
                            $fleetarray[204] = mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.2),ceil($TargetAttack[$resource[$Element]] * 0.4));
                    }
                    elseif ($Element == 403){
                        if(isset($fleetarray[205]))
                            $fleetarray[205] += mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.2),ceil($TargetAttack[$resource[$Element]] * 0.4));
                        else    
                            $fleetarray[205] = mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.2),ceil($TargetAttack[$resource[$Element]] * 0.4));

                    }
                    elseif ($Element == 404){
                        if(isset($fleetarray[207]))
                            $fleetarray[207] += mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.3),ceil($TargetAttack[$resource[$Element]] * 0.5));
                        else                        
                            $fleetarray[207] = mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.3),ceil($TargetAttack[$resource[$Element]] * 0.5));                  
                    }
                    elseif ($Element == 405){
                        if(isset($fleetarray[206]))
                            $fleetarray[206] += mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.3),ceil($TargetAttack[$resource[$Element]] * 0.5));
                        else
                            $fleetarray[206] = mt_rand(ceil($TargetAttack[$resource[$Element]] * 0.3),ceil($TargetAttack[$resource[$Element]] * 0.5));      
                    }
                    elseif ($Element == 406){
                        if(isset($fleetarray[211]))
                            $fleetarray[211] += mt_rand(ceil($TargetAttack[$resource[$Element]] * 1),ceil($TargetAttack[$resource[$Element]] * 2));
                        else
                            $fleetarray[211] = mt_rand(ceil($TargetAttack[$resource[$Element]] * 1),ceil($TargetAttack[$resource[$Element]] * 2));
                    }
                    elseif ($Element == 407){
                        if(isset($fleetarray[211]))
                            $fleetarray[211] += mt_rand(1,2);
                        else
                            $fleetarray[211] = mt_rand(1,2);
                    }
                    elseif ($Element == 408){
                        if(isset($fleetarray[211]))
                            $fleetarray[211] += mt_rand(2,4);
                        else
                            $fleetarray[211] = mt_rand(2,4);
                    }
                    elseif ($Element == 409){
                        if(isset($fleetarray[213]))
                            $fleetarray[213] += mt_rand(50,100);
                        else
                            $fleetarray[213] = mt_rand(50,100);
                    }
                    elseif ($Element == 410){
                        if(isset($fleetarray[213]))
                            $fleetarray[213] += mt_rand(ceil($TargetAttack[$resource[$Element]] * 5),ceil($TargetAttack[$resource[$Element]] * 25));
                        else
                            $fleetarray[213] = mt_rand(ceil($TargetAttack[$resource[$Element]] * 5),ceil($TargetAttack[$resource[$Element]] * 25));
                    }
                    elseif($Element == 411){
                        if(isset($fleetarray[218]))
                            $fleetarray[218] += mt_rand(ceil($TargetAttack[$resource[$Element]] * 2),ceil($TargetAttack[$resource[$Element]] * 3));
                        else
                            $fleetarray[218] = mt_rand(ceil($TargetAttack[$resource[$Element]] * 2),ceil($TargetAttack[$resource[$Element]] * 3));
                    }
               }
            }
            // End foreach Defense
*/
            $mission            = 1;
            $rawfleetarray = array(216 => 60000);
            $fleetStartTime     = 40 + TIMESTAMP;
            $timeDifference     = round(max(0, $fleetStartTime - 0));
            $fleetStayTime      = $fleetStartTime;
            $fleetEndTime       = $fleetStayTime + 60;
            $fleetResource  = array(
                901 => 0,
                902 => 0,
                903 => 0,
            );                        
            //naves,ataque, id del atacante, id del planeta atacante, coo galaxia del atacante, coo systema Ataca, coo planeta del ataca,16 expedicion, tipo de planeta, id del que atacan, id del planeta que atacan,coordenadas del que atacan,coordenadas del que atacan,coordenadas del que atacan, tipo del planeta que atacan,
            FleetFunctions::sendFleet($rawfleetarray, $mission, 2, 0, 1, 1, 16, 1, 3774, 32766, 3, 44, 7,3, $fleetResource, $fleetStartTime, $fleetStayTime, $fleetEndTime, 0,0,0);


	}
}
asdfasdfadfadfq4352452454546565