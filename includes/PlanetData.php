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

$planetData	= array(
	1	=> array('temp' => mt_rand(220, 260),	'fields' => mt_rand(95, 108),	'image' => array('trocken' => mt_rand(1, 10), 'wuesten' => mt_rand(1, 4))),
	2	=> array('temp' => mt_rand(170, 210),	'fields' => mt_rand(97, 110),	'image' => array('trocken' => mt_rand(1, 10), 'wuesten' => mt_rand(1, 4))),
	3	=> array('temp' => mt_rand(120, 160),	'fields' => mt_rand(98, 137),	'image' => array('trocken' => mt_rand(1, 10), 'wuesten' => mt_rand(1, 4))),
	4	=> array('temp' => mt_rand(70, 110),	'fields' => mt_rand(123, 203),	'image' => array('dschjungel' => mt_rand(1, 10))),
	5	=> array('temp' => mt_rand(60, 100),	'fields' => mt_rand(148, 210),	'image' => array('dschjungel' => mt_rand(1, 10))),
	6	=> array('temp' => mt_rand(50, 90),		'fields' => mt_rand(148, 226),	'image' => array('dschjungel' => mt_rand(1, 10))),
	7	=> array('temp' => mt_rand(40, 80),		'fields' => mt_rand(141, 273),	'image' => array('normaltemp' => mt_rand(1, 7))),
	8	=> array('temp' => mt_rand(30, 70),		'fields' => mt_rand(169, 246),	'image' => array('normaltemp' => mt_rand(1, 7))),
	9	=> array('temp' => mt_rand(20, 60),		'fields' => mt_rand(161, 238),	'image' => array('normaltemp' => mt_rand(1, 7), 'wasser' => mt_rand(1, 9))),
	10	=> array('temp' => mt_rand(10, 50),		'fields' => mt_rand(154, 224),	'image' => array('normaltemp' => mt_rand(1, 7), 'wasser' => mt_rand(1, 9))),
	11	=> array('temp' => mt_rand(0, 40),		'fields' => mt_rand(148, 204),	'image' => array('normaltemp' => mt_rand(1, 7), 'wasser' => mt_rand(1, 9))),
	12	=> array('temp' => mt_rand(-10, 30),	'fields' => mt_rand(136, 171),	'image' => array('normaltemp' => mt_rand(1, 7), 'wasser' => mt_rand(1, 9))),
	13	=> array('temp' => mt_rand(-50, -10),	'fields' => mt_rand(109, 121),	'image' => array('eis' => mt_rand(1, 10))),
	14	=> array('temp' => mt_rand(-90, -50),	'fields' => mt_rand(81, 93),	'image' => array('eis' => mt_rand(1, 10))),
	15	=> array('temp' => mt_rand(-130, -90),	'fields' => mt_rand(65, 74),	'image' => array('eis' => mt_rand(1, 10)))
);

$Pdata		= array(
	1	=> array('tempmin' => (220),  'tempmax' => (260),	'fieldsmin' => (95),	'fieldsmax' => (108),	'color' => '#FF0000'),
	2	=> array('tempmin' => (170),  'tempmax' => (210),	'fieldsmin' => (97),	'fieldsmax' => (110),	'color' => '#FF1010'),
	3	=> array('tempmin' => (120),  'tempmax' => (160),	'fieldsmin' => (98),	'fieldsmax' => (137),	'color' => '#FF2222'),
	4	=> array('tempmin' => (70),  'tempmax' => (110),	'fieldsmin' => (123),	'fieldsmax' => (203),	'color' => '#FE3333'),
	5	=> array('tempmin' => (60),   'tempmax' => (100),	'fieldsmin' => (148),	'fieldsmax' => (210),	'color' => '#FC4242'),
	6	=> array('tempmin' => (50),   'tempmax' => (90),	'fieldsmin' => (148),	'fieldsmax' => (226),	'color' => '#FC5353'),
	7	=> array('tempmin' => (40),   'tempmax' => (80),	'fieldsmin' => (141),	'fieldsmax' => (273),	'color' => '#FF6B6B'),
	8	=> array('tempmin' => (30),   'tempmax' => (70),	'fieldsmin' => (169),	'fieldsmax' => (246),	'color' => '#FF8383'),
	9	=> array('tempmin' => (20),   'tempmax' => (60),	'fieldsmin' => (161),	'fieldsmax' => (238),	'color' => '#FD9898'),
	10	=> array('tempmin' => (10),   'tempmax' => (50),	'fieldsmin' => (154),	'fieldsmax' => (224),	'color' => '#D0E5FF'),
	11	=> array('tempmin' => (0),   'tempmax' => (40),	'fieldsmin' => (148),	'fieldsmax' => (204),	'color' => '#B0D2FC'),
	12	=> array('tempmin' => (-10),   'tempmax' => (30),	'fieldsmin' => (136),	'fieldsmax' => (171),	'color' => '#98C6FE'),
	13	=> array('tempmin' => (-50),   'tempmax' => (-10),	'fieldsmin' => (109),	'fieldsmax' => (121),	'color' => '#88BDFF'),
	14	=> array('tempmin' => (-90),    'tempmax' => (-50),	'fieldsmin' => (81),	'fieldsmax' => (93),	'color' => '#6DAEFE'),
	15	=> array('tempmin' => (-130),  'tempmax' => (-90),	'fieldsmin' => (65),	'fieldsmax' => (74),	'color' => '#57A3FF')
	
);
?>