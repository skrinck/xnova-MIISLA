<?php

/**
 *  2Moons 
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
 */


$fractionList = array(); // declaró un elemento de matriz

// artefacto 1 su nombre

$fractionList[1] = array ( // creó una matriz de arte

'class' => 1, // clase de arte 1 para el usuario

'bonus' => array (array('Attack',0.02),array('BuildTime',0.01),array('consumption1',-0.03),array('bonusExpeditionUnit',0.03), array('Resource',-0.03),),// creó un bono e indicó su indicador

'cost' => 10000, // costo del artefacto en tm

);

$fractionList[2] = array ( // creó una matriz de arte

'class' => 1, // clase de arte 1 para el usuario

'bonus' => array (array('Attack',-0.02),array('BuildTime',-0.01),array('Resource',0.05),array('Defensive',0.05),array('bonusEnergy',0.03)),

'cost' => 10000, // costo del artefacto en tm

);

$fractionList[3] = array ( // creó una matriz de arte

'class' => 1, // clase de arte 1 para el usuario

'bonus' => array (array('Attack',0.01),array('BuildTime',0.02),array('bonusResearchTime',0.01),array('bonusExpeditionUnit',-0.01),array('Resource',0.01),),

'cost' => 10000, // costo del artefacto en tm

);

$fractionList[4] = array ( // creó una matriz de arte

'class' => 1, // clase de arte 1 para el usuario

'bonus' => array (array('Attack',0.01),array('BuildTime',-0.01),array('bonusExpeditionUnit',0.01),array('consumption1',-0.03),array('Expedition',0.03)),

'cost' => 10000, // costo del artefacto en tm

);

$fractionList[5] = array ( // creó una matriz de arte

'class' => 1, // clase de arte 1 para el usuario

'bonus' => array (array('Attack',0.01),array('BuildTime',0.01),array('Shield',0.03),array('bonusResearchTime',-0.05),array('Expedition',0.03)),

'cost' => 10000, // costo del artefacto en tm

);