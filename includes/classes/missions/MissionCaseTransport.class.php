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
class MissionCaseTransport extends MissionFunctions implements Mission
{		
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{
		$sql			= "SELECT * FROM %%PLANETS%% WHERE id = :planetId;";
		$targetPlanet 	= Database::get()->selectSingle($sql, array(
			':planetId'	=> $this->_fleet['fleet_end_id']
		));

		// return fleet if target planet deleted
		if($targetPlanet == false)
		{
			$sql = "SELECT * FROM %%USERS%% WHERE id = :id;";

			$Player	= Database::get()->selectSingle($sql, array(
				':id'	=> $this->_fleet['fleet_owner']
			));
			FleetFunctions::SendFleetBack($Player, $this->_fleet['fleet_id']);
			return;
		}
		
		$sql = 'SELECT name FROM %%PLANETS%% WHERE `id` = :planetId;';

		$startPlanetName	= Database::get()->selectSingle($sql, array(
			':planetId'	=> $this->_fleet['fleet_start_id']
		), 'name');

		$targetPlanetName	= Database::get()->selectSingle($sql, array(
			':planetId'	=> $this->_fleet['fleet_end_id']
		), 'name');
		
		$LNG			= $this->getLanguage(NULL, $this->_fleet['fleet_owner']);

		//MOD Cuidar el server de los transportes entre cuentas vacas
		$db = Database::get();
		if (isModuleAvailable(MODULE_ALLY_TRANSPORT)) {
			
			if ($this->_fleet['fleet_owner'] != $this->_fleet['fleet_target_owner']) {
				//chequea si el que recive no tiene deudas con el que envia
				$sql = "SELECT * FROM %%TRANSSTAT%% WHERE sender = :sender AND recipient = :recipient;";
				$CheckDeuda = $db->selectSingle($sql, array(
					':sender' 		=> $this->_fleet['fleet_owner'],
					':recipient' 	=> $this->_fleet['fleet_target_owner'],
				));

				if (!empty($CheckDeuda)) {
					
					if ($CheckDeuda['send_metal'] > $CheckDeuda['devo_metal'] 
						|| $CheckDeuda['send_crystal'] > $CheckDeuda['devo_crystal'] 
						|| $CheckDeuda['send_deuterium'] > $CheckDeuda['devo_deuterium']) {
						//saca lo que le falta por pagar
						$DeudaM = max(0, $CheckDeuda['send_metal'] - $CheckDeuda['devo_metal']);
						$DeudaC = max(0, $CheckDeuda['send_crystal'] - $CheckDeuda['devo_crystal']);
						$DeudaD = max(0, $CheckDeuda['send_deuterium'] - $CheckDeuda['devo_deuterium']);
						
						$Message = sprintf($LNG['tr_no_empty'], $DeudaM, $DeudaC, $DeudaD);
						//se envia la alerta y media vuelta
						PlayerUtil::sendMessage(
							$this->_fleet['fleet_owner'],
							0,
							$LNG['sys_mess_tower'],
							5,
							$LNG['sys_mess_transport'],
							$Message,
							$this->_fleet['fleet_start_time'],
							NULL,
							1,
							$this->_fleet['fleet_universe']
						);

						$this->setState(FLEET_RETURN);
						$this->SaveFleet();
						return;

					}

				}
				//buscar si el que envia no tiene deudas con el que recive
				$sql = "SELECT * FROM %%TRANSSTAT%% WHERE sender = :sender AND recipient = :recipient;";
				$PagarDeuda = $db->selectSingle($sql, array(
					':sender' 		=> $this->_fleet['fleet_target_owner'],
					':recipient' 	=> $this->_fleet['fleet_owner'],
				));

				if (!empty($PagarDeuda)) {
					//descontar de la deuda
					
					$SacarM = max(0, ($this->_fleet['fleet_resource_metal'] + $PagarDeuda['devo_metal'])) / 4;
					$SacarC = max(0, ($this->_fleet['fleet_resource_crystal'] + $PagarDeuda['devo_crystal'])) / 2;
					

					$ConvertM = 0;
					$ConvertC = 0;
					$ConvertD = $PagarDeuda['devo_deuterium'] + $this->_fleet['fleet_resource_deuterium'] + $SacarM + $SacarC;
					
					if ($ConvertD >= $PagarDeuda['send_deuterium']) {

						$ConvertC += ($ConvertD - $PagarDeuda['send_deuterium']) / 0.5;
						$ConvertD = $PagarDeuda['send_deuterium'];

					}

					if ($ConvertC >= $PagarDeuda['send_crystal']) {

						$ConvertM += ($ConvertC - $PagarDeuda['send_crystal']) / 0.5;
						$ConvertC = $PagarDeuda['send_crystal'];

					}

					/*$this->_fleet['fleet_resource_metal']		= $ConvertM;
					$this->_fleet['fleet_resource_crystal']		= $ConvertC;
					$this->_fleet['fleet_resource_deuterium']	= $ConvertD;*/

					if ($ConvertM < $PagarDeuda['send_metal'] 
						|| $ConvertC < $PagarDeuda['send_crystal'] 
						|| $ConvertD < $PagarDeuda['send_deuterium']) {
						
						$sql = "UPDATE %%TRANSSTAT%% SET 
							devo_metal = :devo_metal, 
							devo_crystal = :devo_crystal, 
							devo_deuterium = :devo_deuterium 
						WHERE sender = :sender AND recipient = :recipient";

						$db->update($sql, array(
							':devo_metal' 		=> $ConvertM,
							':devo_crystal' 	=> $ConvertC,
							':devo_deuterium' 	=> $ConvertD,
							':sender' 			=> $this->_fleet['fleet_target_owner'],
							':recipient' 		=> $this->_fleet['fleet_owner']
						));
					//si con lo que transporta se paga la deuda entonces se elimina
					} else {
						// si sobran recursos al pagar entonces se crea otra deuda
						if ($ConvertM > $PagarDeuda['send_metal'] 
							|| $ConvertC > $PagarDeuda['send_crystal'] 
							|| $ConvertD > $PagarDeuda['send_deuterium']) {
							
							$sql = "INSERT INTO %%TRANSSTAT%% (sender, recipient, send_metal, send_crystal, send_deuterium) VALUES (:sender, :recipient, :send_metal, :send_crystal, :send_deuterium);";

							$db->insert($sql, array(
								':sender' 			=> $this->_fleet['fleet_owner'],
								':recipient' 		=> $this->_fleet['fleet_target_owner'],
								':send_metal' 		=> $ConvertM - $PagarDeuda['send_metal'],
								':send_crystal' 	=> $ConvertC - $PagarDeuda['send_crystal'],
								':send_deuterium' 	=> $ConvertD - $PagarDeuda['send_deuterium'],
							));
						}

						$sql = "DELETE FROM %%TRANSSTAT%% WHERE id = :id;";
						$db->delete($sql, array(
							':id' => $PagarDeuda['id'],
						));

					}
				// si no existe una deuda entonces la crea
				} else {

					$sql = "INSERT INTO %%TRANSSTAT%% (sender, recipient, send_metal, send_crystal, send_deuterium) VALUES (:sender, :recipient, :send_metal, :send_crystal, :send_deuterium);";

					$db->insert($sql, array(
						':sender' 			=> $this->_fleet['fleet_owner'],
						':recipient' 		=> $this->_fleet['fleet_target_owner'],
						':send_metal' 		=> $this->_fleet['fleet_resource_metal'],
						':send_crystal' 	=> $this->_fleet['fleet_resource_crystal'],
						':send_deuterium' 	=> $this->_fleet['fleet_resource_deuterium'],
					));

				}

			}

		}

		$Message		= sprintf($LNG['sys_tran_mess_owner'],
			$targetPlanetName, GetTargetAddressLink($this->_fleet, ''),
			pretty_number($this->_fleet['fleet_resource_metal']), $LNG['tech'][901],
			pretty_number($this->_fleet['fleet_resource_crystal']), $LNG['tech'][902],
			pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['tech'][903]
		);

		PlayerUtil::sendMessage($this->_fleet['fleet_owner'], 0, $LNG['sys_mess_tower'], 5,
			$LNG['sys_mess_transport'], $Message, $this->_fleet['fleet_start_time'], NULL, 1, $this->_fleet['fleet_universe']);

		if ($this->_fleet['fleet_target_owner'] != $this->_fleet['fleet_owner']) 
		{
			$LNG			= $this->getLanguage(NULL, $this->_fleet['fleet_target_owner']);
			$Message        = sprintf($LNG['sys_tran_mess_user'],
				$startPlanetName, GetStartAddressLink($this->_fleet, ''),
				$targetPlanetName, GetTargetAddressLink($this->_fleet, ''),
				pretty_number($this->_fleet['fleet_resource_metal']), $LNG['tech'][901],
				pretty_number($this->_fleet['fleet_resource_crystal']), $LNG['tech'][902],
				pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['tech'][903]
			);

			PlayerUtil::sendMessage($this->_fleet['fleet_target_owner'], 0, $LNG['sys_mess_tower'], 5,
				$LNG['sys_mess_transport'], $Message, $this->_fleet['fleet_start_time'], NULL, 1, $this->_fleet['fleet_universe']);
		}
	
		$this->StoreGoodsToPlanet();
		$this->setState(FLEET_RETURN);
		$this->SaveFleet();
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{
		$LNG		= $this->getLanguage(NULL, $this->_fleet['fleet_owner']);
		$sql		= 'SELECT name FROM %%PLANETS%% WHERE id = :planetId;';
		$planetName	= Database::get()->selectSingle($sql, array(
			':planetId'	=> $this->_fleet['fleet_start_id'],
		), 'name');

		$Message	= sprintf($LNG['sys_tran_mess_back'], $planetName, GetStartAddressLink($this->_fleet, ''));

		PlayerUtil::sendMessage($this->_fleet['fleet_owner'], 0, $LNG['sys_mess_tower'], 4, $LNG['sys_mess_fleetback'],
			$Message, $this->_fleet['fleet_end_time'], NULL, 1, $this->_fleet['fleet_universe']);

		$this->RestoreFleet();
	}
}
