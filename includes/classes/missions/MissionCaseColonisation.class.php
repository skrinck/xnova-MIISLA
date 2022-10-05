<?php
/*
 *Modificado por Linkin
 *Ahora la flota que va con el colonizador se queda en el planeta que se ha colonizado
 */
class MissionCaseColonisation extends MissionFunctions implements Mission
{
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{
		$db		= Database::get();
		$sql	= 'SELECT * FROM %%USERS%% WHERE `id` = :userId;';
		$senderUser		= $db->selectSingle($sql, array(
			':userId'	=> $this->_fleet['fleet_owner'],
		));
		$senderUser['factor']	= getFactors($senderUser, 'basic', $this->_fleet['fleet_start_time']);
		$LNG	= $this->getLanguage($senderUser['lang']);
		$checkPosition	= PlayerUtil::checkPosition($this->_fleet['fleet_universe'], $this->_fleet['fleet_end_galaxy'],
			$this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet']);
		$isPositionFree	= PlayerUtil::isPositionFree($this->_fleet['fleet_universe'], $this->_fleet['fleet_end_galaxy'],
			$this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet']);
		if (!$isPositionFree || !$checkPosition)
		{
			$message = sprintf($LNG['sys_colo_notfree'], GetTargetAddressLink($this->_fleet, ''));
		}
		else
		{
			$allowPlanetPosition	= PlayerUtil::allowPlanetPosition($this->_fleet['fleet_end_planet'], $senderUser);
			if(!$allowPlanetPosition)
			{
				$message = sprintf($LNG['sys_colo_notech'] , GetTargetAddressLink($this->_fleet, ''));
			}
			else
			{
				$sql	= 'SELECT COUNT(*) as state
				FROM %%PLANETS%%
				WHERE `id_owner`	= :userId
				AND `planet_type`	= :type
				AND `destruyed`		= :destroyed;';
				$currentPlanetCount	= $db->selectSingle($sql, array(
					':userId'		=> $this->_fleet['fleet_owner'],
					':type'			=> 1,
					':destroyed'	=> 0
				), 'state');
				$maxPlanetCount		= PlayerUtil::maxPlanetCount($senderUser);
				if($currentPlanetCount >= $maxPlanetCount)
				{
					$message = sprintf($LNG['sys_colo_maxcolo'], GetTargetAddressLink($this->_fleet, ''), $maxPlanetCount);
					$this->setState(FLEET_RETURN);
					$this->SaveFleet();
				}
				else
				{
					$NewOwnerPlanet = PlayerUtil::createPlanet($this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'],
						$this->_fleet['fleet_end_planet'], $this->_fleet['fleet_universe'], $this->_fleet['fleet_owner'],
						$LNG['fcp_colony'], false, $senderUser['authlevel']);
					if($NewOwnerPlanet === false)
					{
						$message = sprintf($LNG['sys_colo_badpos'], GetTargetAddressLink($this->_fleet, ''));
						
					}
					else
					{
						$this->_fleet['fleet_end_id']	= $NewOwnerPlanet;
						$message = sprintf($LNG['sys_colo_allisok'], GetTargetAddressLink($this->_fleet, ''));
						$this->StoreGoodsToPlanet();
						if ($this->_fleet['fleet_amount'] == 1) {
							$this->KillFleet();
						} else {
							$CurrentFleet = explode(";", $this->_fleet['fleet_array']);
							$NewFleet	 = '';
							foreach ($CurrentFleet as $Group)
							{
								if (empty($Group)) continue;
								$Class = explode (",", $Group);
								if ($Class[0] == 208 && $Class[1] > 1)
									$NewFleet  .= $Class[0].",".($Class[1] - 1).";";
								elseif ($Class[0] != 208 && $Class[1] > 0)
									$NewFleet  .= $Class[0].",".$Class[1].";";
							}
							$this->UpdateFleet('fleet_array', $NewFleet);
							$this->UpdateFleet('fleet_amount', ($this->_fleet['fleet_amount'] - 1));
							/*$this->UpdateFleet('fleet_resource_metal', 0);
							$this->UpdateFleet('fleet_resource_crystal', 0);
							$this->UpdateFleet('fleet_resource_deuterium', 0);*/
							$this->RestoreFleet(false);
						}
					}
				}
			}
		}
		PlayerUtil::sendMessage($this->_fleet['fleet_owner'], 0, $LNG['sys_colo_mess_from'], 4, $LNG['sys_colo_mess_report'],
			$message, $this->_fleet['fleet_start_time'], NULL, 1, $this->_fleet['fleet_universe']);
		$this->setState(FLEET_RETURN);
		$this->SaveFleet();
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{
		$this->RestoreFleet();
	}
}
