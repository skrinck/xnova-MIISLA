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

class ShowTechtreePage extends AbstractGamePage
{
    public static $requireModule = MODULE_TECHTREE;

    function __construct()
    {
        parent::__construct();
    }

    function show()
    {
        global $resource, $requeriments, $reslist, $USER, $PLANET;

        $elementIDs		= array_merge(
            array(0),
            $reslist['build'],
            array(100),
            $reslist['tech'],
            array(200),
            $reslist['fleet'],
            array(400),
            $reslist['defense'],
            array(500),
            $reslist['missile'],
            array(600),
            $reslist['officier']
        );

        $techTreeList = array();

        foreach($elementIDs as $elementId)
        {
            if(!isset($resource[$elementId]))
            {
                $techTreeList[$elementId]	= $elementId;
            }
            else
            {
                $requirementsList	= array();
                if(isset($requeriments[$elementId]))
                {
                    foreach($requeriments[$elementId] as $requireID => $RedCount)
                    {
                        $requirementsList[$requireID]	= array(
                            'count' => $RedCount,
                            'own'   => isset($PLANET[$resource[$requireID]]) ? $PLANET[$resource[$requireID]] : $USER[$resource[$requireID]]
                        );
                    }
                }

                $techTreeList[$elementId]	= $requirementsList;
            }
        }

        $this->assign(array(
            'TechTreeList'		=> $techTreeList,
        ));

        $this->display('page.techTree.default.tpl');
    }
}
