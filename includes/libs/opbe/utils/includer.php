<?php
/**
 *  OPBE
 *  Copyright (C) 2013  Jstar
 *
 * This file is part of OPBE.
 * 
 * OPBE is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OPBE is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with OPBE.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OPBE
 * @author Jstar <frascafresca@gmail.com>
 * @copyright 2013 Jstar <frascafresca@gmail.com>
 * @license http://www.gnu.org/licenses/ GNU AGPLv3 License
 * @version beta(26-10-2013)
 * @link https://github.com/jstar88/opbe
 */

define('OPBEPATH', 'includes/libs/opbe/');

require ('includes/libs/opbe/utils/GeometricDistribution.php');
require ('includes/libs/opbe/utils/Gauss.php');
require ('includes/libs/opbe/utils/DebugManager.php'); 
require ('includes/libs/opbe/utils/IterableUtil.php');
require ('includes/libs/opbe/utils/Math.php');
require ('includes/libs/opbe/utils/Number.php');
require ('includes/libs/opbe/utils/Events.php');
require ('includes/libs/opbe/utils/Lang.php');
require ('includes/libs/opbe/utils/LangManager.php');
require ('includes/libs/opbe/models/Type.php');
require ('includes/libs/opbe/models/ShipType.php');
require ('includes/libs/opbe/models/Fleet.php');
require ('includes/libs/opbe/models/HomeFleet.php');
require ('includes/libs/opbe/models/Defense.php');
require ('includes/libs/opbe/models/Ship.php');
require ('includes/libs/opbe/models/Player.php');
require ('includes/libs/opbe/models/PlayerGroup.php');
require ('includes/libs/opbe/combatObject/Fire.php');
require ('includes/libs/opbe/combatObject/PhysicShot.php');
require ('includes/libs/opbe/combatObject/ShipsCleaner.php');
require ('includes/libs/opbe/combatObject/FireManager.php');
require ('includes/libs/opbe/core/Battle.php');
require ('includes/libs/opbe/core/BattleReport.php');
require ('includes/libs/opbe/core/Round.php');
require ('includes/libs/opbe/constants/battle_constants.php');
?>
