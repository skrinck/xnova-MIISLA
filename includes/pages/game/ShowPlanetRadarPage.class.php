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
 * @version 2.6
 * @link https://www.miisla.nat.cu
 */
class ShowPlanetRadarPage extends AbstractGamePage 
{
//  public static $requireModule = 0;
     public static $requireModule = MODULE_PLANETRADAR;


     function __construct() 
    {
        parent::__construct();
    }


        function show()
        {
            global $USER, $PLANET, $LNG, $resource, $pricelist;

            if ($USER[$resource[124]] == 0)
            {
                $this->printMessage($LNG['no_PlanetR_required']);
            }

            $db = Database::get();

            $Search = HTTP::_GP('search', '');
            $Style = "";
            //$RangeLimit = $PLANET['hangar'] * 2;
            $RangeLimit = Limit::getPlanetRadar($USER);

            ############# BONUS NAME #####################
            if($Search == 'players'){
                $PlanetResult = $db->select("SELECT * FROM %%PLANETS%% WHERE id_owner != :userID AND system > :system AND system < :system1 AND galaxy = :galaxy ORDER BY `system` ASC, `planet` ASC LIMIT :limit ;", array(
                    ':userID' => $USER['id'],
                    ':system' => $PLANET['system'] - $RangeLimit,
                    ':system1' => $PLANET['system'] + $RangeLimit,
                    ':galaxy' => $PLANET['galaxy'],
                    ':limit' => $RangeLimit
                ));

                $PlanetSearch = $db->rowCount($PlanetResult);

                //echo json_encode($PlanetResult);exit;

                /* INNER JOIN ".USERS." ON username = id_owner 
                $Style = '<table class="redesign"><tr><td>Galaxy</td><td>System</td><td>Planet</td><td>
                Current Mines (MM/CM/DS)
                </td><td>
                Debris in Orbit
                </td><td>&nbsp</td></tr>';*/
                
                ############# BONUS EDIT #####################
                $NoBonus = "NoBonus";
                /* Add the wished bonus. No Hangar levels required*/
                $PlanetList      = array();
                if($PlanetSearch > 0 ){

                    $PlanetList      = array();
        
                    foreach($PlanetResult as $planetRow)
                    {
                        $PlanetList[$planetRow['id_owner']] = array(
                            'name'       => $planetRow['name'],
                            'image'      => $planetRow['image'],
                            'system'     => $planetRow['system'],
                            'galaxy'     => $planetRow['galaxy'],
                            'planet'     => $planetRow['planet'],
                        );
                    }
                }   
            }

            $this->assign(array(
                'PlanetList' => $PlanetList,
                'MaxAllowed' => $RangeLimit,
                'Radar' => $Style,
            ));
            $this->display('page.planetradar.default.tpl');
        }

}

?>