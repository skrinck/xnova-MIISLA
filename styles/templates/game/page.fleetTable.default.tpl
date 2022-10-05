{block name="title" prepend}{$LNG.lm_fleet}{/block}
{block name="content"}

<div class="content_page">
	<div class="title">
		{$LNG.lm_fleet}
		{if isModuleAvailable($smarty.const.MODULE_RDUCE_RESOURSE)}<a href="game.php?page=reduceresources" class="right_flank btn btn-dark btn-xs">{$LNG.lm_red_resources}</a>{/if}
	</div>
	<div>
		<div class="title" style="text-align: right;">
			<span class="transparent" style="text-align:left; float: left;">{$LNG.fl_fleets} {$activeFleetSlots} / {$maxFleetSlots}</span>
			<span class="transparent">{$activeExpedition} / {$maxExpedition} {$LNG.fl_expeditions}</span>
			<span>|</span> 
			<span class="transparent">{$activeMOFound} / <span class="tooltip" style="color:#6ccdce" data-tooltip-content="<table class='reducefleet_table'>       
                           <tr><td class='reducefleet_name_ship'>Default {$LNG.type_mission_11}:</td><td class='reducefleet_name_ship'>{$MOFound}</span></td></tr>
				           <tr><td class='reducefleet_name_ship'>{$LNG.tech.124}:</td><td class='reducefleet_name_ship'>{$moduleMOFound}</span></td></tr></tr>">{$maxMOFound}</span> {$LNG.fl_mofound}
			<span>|</span>
			{$LNG.type_mission_16} {$activeAsteroids} / <span class="tooltip" style="color:#6ccdce" data-tooltip-content="<table class='reducefleet_table'>       
                           <tr><td class='reducefleet_name_ship'>Default {$LNG.type_mission_16}:</td><td class='reducefleet_name_ship'>{$Asteroid}</span></td></tr>
				           <tr><td class='reducefleet_name_ship'>{$LNG.tech.150}:</td><td class='reducefleet_name_ship'>{$moduleAsteroide}</span></td></tr></tr>">{$maxAsteroids}</span>
				           <span>|</span> 

				           <span style="float:right;color:#6ccdce;"><span class="totalFleetPoints">0</span> {$LNG.fleetta_point_fle}</span>	
		</div>
		<table style="width: 100%;">
			<tr>
				<td>{$LNG.fl_number}</td>
				<td>{$LNG.fl_mission}</td>
				<td>{$LNG.fl_ammount}</td>
				<td>{$LNG.fl_beginning}</td>
				<td>{$LNG.fl_departure}</td>
				<td>{$LNG.fl_destiny}</td>
				<td>{$LNG.fl_arrival}</td>
				<td>{$LNG.fl_objective}</td>
				<td>{$LNG.fl_order}</td>
			</tr>
			{foreach name=FlyingFleets item=FlyingFleetRow from=$FlyingFleetList}
			<tr>
			<td>{$smarty.foreach.FlyingFleets.iteration}</td>
			<td>{$LNG["type_mission_{$FlyingFleetRow.mission}"]}
			{if $FlyingFleetRow.state == 1}
				<br><a title="{$LNG.fl_returning}">{$LNG.fl_r}</a>
			{else}
				<br><a title="{$LNG.fl_onway}">{$LNG.fl_a}</a>
			{/if}
			</td>
			<td><a class="tooltip_sticky" data-tooltip-content="<table width='100%'><tr><th colspan='2' style='text-align:center;'>{$LNG.fl_info_detail}</th></tr>{foreach $FlyingFleetRow.FleetList as $shipID => $shipCount}<tr><td class='transparent'>{$LNG.tech.{$shipID}}:</td><td class='transparent'>{$shipCount}</td></tr>{/foreach}</table>">{$FlyingFleetRow.amount}</a></td>
			<td><a href="game.php?page=galaxy&amp;galaxy={$FlyingFleetRow.startGalaxy}&amp;system={$FlyingFleetRow.startSystem}">[{$FlyingFleetRow.startGalaxy}:{$FlyingFleetRow.startSystem}:{$FlyingFleetRow.startPlanet}]</a></td>
			<td{if $FlyingFleetRow.state == 0} style="color:lime"{/if}>{$FlyingFleetRow.startTime}</td>
			<td><a href="game.php?page=galaxy&amp;galaxy={$FlyingFleetRow.endGalaxy}&amp;system={$FlyingFleetRow.endSystem}">[{$FlyingFleetRow.endGalaxy}:{$FlyingFleetRow.endSystem}:{$FlyingFleetRow.endPlanet}]</a></td>
			{if $FlyingFleetRow.mission == 4 && $FlyingFleetRow.state == 0}
			<td>-</td>
			{else}
			<td{if $FlyingFleetRow.state != 0} style="color:lime"{/if}>{$FlyingFleetRow.endTime}</td>
			{/if}
			<td id="fleettime_{$smarty.foreach.FlyingFleets.iteration}" class="fleets" data-fleet-end-time="{$FlyingFleetRow.returntime}" data-fleet-time="{$FlyingFleetRow.resttime}">{pretty_fly_time({$FlyingFleetRow.resttime})}</td>
			<td>
			{if !$isVacation && $FlyingFleetRow.state != 1}
				<form action="game.php?page=fleetTable&amp;action=sendfleetback" method="post">
				<input name="fleetID" value="{$FlyingFleetRow.id}" type="hidden">
				<input class="btn btn-dark btn-xs" value="{$LNG.fl_send_back}" type="submit">
				</form>
				{if $FlyingFleetRow.mission == 1}
				<form action="game.php?page=fleetTable&amp;action=acs" method="post">
				<input name="fleetID" value="{$FlyingFleetRow.id}" type="hidden">
				<input class="btn btn-dark btn-xs" value="{$LNG.fl_acs}" type="submit">
				</form>
				{/if}
				{if $FlyingFleetRow.lock}
					<form action="game.php?page=fleetTable&amp;action=unlock" method="post">
						<input name="fleetID" value="{$FlyingFleetRow.id}" type="hidden">
						<input value="Desbloquear" type="submit">
					</form>
				{/if}
			{else}
			&nbsp;-&nbsp;
			{/if}
			</td>
			</tr>
			{foreachelse}
			<tr>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
			</tr>
			{/foreach}
			{if $maxFleetSlots == $activeFleetSlots}
			<tr><td colspan="9">{$LNG.fl_no_more_slots}</td></tr>
			{/if}
		</table>

		{if !empty($acsData)}
			{include file="shared.fleetTable.acsTable.tpl"}
		{/if}

		<form action="?page=fleetStep1" method="post">
		<input type="hidden" name="galaxy" value="{$targetGalaxy}">
		<input type="hidden" name="system" value="{$targetSystem}">
		<input type="hidden" name="planet" value="{$targetPlanet}">
		<input type="hidden" name="type" value="{$targetType}">
		<input type="hidden" name="secret" value="{$secret}">
		<input type="hidden" name="target_mission" value="{$targetMission}">
			<table style="width: 100%; max-width: 100%;">
				{if count($FleetsOnPlanetBattle) != 0}
				<tr>
		        	<th colspan="3" class="gray_stripe piccolastriscia">{$LNG.fleetta_typ_1}</th>     
		            <th style="padding:0;" class="gray_stripe piccolastriscia">            	
		             	<a href="javascript:noShipsBatle();" class="fl_min_ships">Min</a>
		                <a href="javascript:maxShipsBatle();" class="fl_max_ships">Max</a>
		           	</th>
		        </tr>{/if}
				{foreach $FleetsOnPlanetBattle as $FleetRow}
				 <tr class="fl_fllets_rows">
		            <td class="fl_fllets_rows_img_td"><a href="#" onclick="return Dialog.info({$FleetRow.id})"><img src="{$dpath}/gebaeude/{$FleetRow.id}.gif" alt="{$LNG.tech.{$FleetRow.id}}"></a></td>
		            <td> {if $FleetRow.speed != 0}<span class="tooltip" data-tooltip-content="{$LNG.fl_speed_title} {$FleetRow.speed}" style="cursor:help;">{$LNG.tech.{$FleetRow.id}}</span>{else}{$LNG.tech.{$FleetRow.id}}{/if}</td>
		            <td id="ship{$FleetRow.id}_value">{$FleetRow.count|number}</td>
		            <td class="fl_fllets_rows_input_td">
		            	<div class="fl_fllets_rows_input_div">
		                	<div onclick="minShip('ship{$FleetRow.id}');" class="fl_fllets_rows_input_min">Min</div>
		                    <div onclick="maxShip('ship{$FleetRow.id}');" class="fl_fllets_rows_input_max">Max</div>
		                	<input class="fl_fllets_rows_input_countdots countdots" name="ship{$FleetRow.id}" id="ship{$FleetRow.id}_input" size="10" value="0" />
		               	</div>
		            </td>
		        </tr>
				{/foreach}

				{if count($FleetsOnPlanetTransport) != 0}
				<tr>
		        	<th colspan="3" class="gray_stripe piccolastriscia">{$LNG.fleetta_typ_2}</th>     
		            <th style="padding:0;" class="gray_stripe piccolastriscia">            	
		             	<a href="javascript:noShipsTransports();" class="fl_min_ships">Min</a>
		                <a href="javascript:maxShipsTransports();" class="fl_max_ships">Max</a>
		           	</th>
		        </tr>{/if}
				{foreach $FleetsOnPlanetTransport as $FleetRow}
				 <tr class="fl_fllets_rows">
		            <td class="fl_fllets_rows_img_td"><a href="#" onclick="return Dialog.info({$FleetRow.id})"><img src="{$dpath}/gebaeude/{$FleetRow.id}.gif" alt="{$LNG.tech.{$FleetRow.id}}"></a></td>
		            <td> {if $FleetRow.speed != 0}<span class="tooltip" data-tooltip-content="{$LNG.fl_speed_title} {$FleetRow.speed}" style="cursor:help;">{$LNG.tech.{$FleetRow.id}}</span>{else}{$LNG.tech.{$FleetRow.id}}{/if}</td>
		            <td id="ship{$FleetRow.id}_value">{$FleetRow.count|number}</td>
		            <td class="fl_fllets_rows_input_td">
		            	<div class="fl_fllets_rows_input_div">
		                	<div onclick="minShip('ship{$FleetRow.id}');" class="fl_fllets_rows_input_min">Min</div>
		                    <div onclick="maxShip('ship{$FleetRow.id}');" class="fl_fllets_rows_input_max">Max</div>
		                	<input class="fl_fllets_rows_input_countdots countdots" name="ship{$FleetRow.id}" id="ship{$FleetRow.id}_input" size="10" value="0" />
		               	</div>
		            </td>
		        </tr>
				{/foreach}

				{if count($FleetsOnPlanetProcessorcs) != 0}
				<tr>
		        	<th colspan="3" class="gray_stripe piccolastriscia">{$LNG.fleetta_typ_4}</th>     
		            <th style="padding:0;" class="gray_stripe piccolastriscia">            	
		             	<a href="javascript:noShipsProcessors();" class="fl_min_ships">Min</a>
		                <a href="javascript:maxShipsProcessors();" class="fl_max_ships">Max</a>
		           	</th>
		        </tr>{/if}
				{foreach $FleetsOnPlanetProcessorcs as $FleetRow}
				 <tr class="fl_fllets_rows">
		            <td class="fl_fllets_rows_img_td"><a href="#" onclick="return Dialog.info({$FleetRow.id})"><img src="{$dpath}/gebaeude/{$FleetRow.id}.gif" alt="{$LNG.tech.{$FleetRow.id}}"></a></td>
		            <td> {if $FleetRow.speed != 0}<span class="tooltip" data-tooltip-content="{$LNG.fl_speed_title} {$FleetRow.speed}" style="cursor:help;">{$LNG.tech.{$FleetRow.id}}</span>{else}{$LNG.tech.{$FleetRow.id}}{/if}</td>
		            <td id="ship{$FleetRow.id}_value">{$FleetRow.count|number}</td>
		            <td class="fl_fllets_rows_input_td">
		            	<div class="fl_fllets_rows_input_div">
		                	<div onclick="minShip('ship{$FleetRow.id}');" class="fl_fllets_rows_input_min">Min</div>
		                    <div onclick="maxShip('ship{$FleetRow.id}');" class="fl_fllets_rows_input_max">Max</div>
		                	<input class="fl_fllets_rows_input_countdots countdots" name="ship{$FleetRow.id}" id="ship{$FleetRow.id}_input" size="10" value="0" />
		               	</div>
		            </td>
		        </tr>
				{/foreach}


				{if count($FleetsOnPlanetSpecial) != 0}
				<tr>
		        	<th colspan="3" class="gray_stripe piccolastriscia">{$LNG.fleetta_typ_3}</th>     
		            <th style="padding:0;" class="gray_stripe piccolastriscia">            	
		             	<a href="javascript:noShipsSpecial();" class="fl_min_ships">Min</a>
		                <a href="javascript:maxShipsSpecial();" class="fl_max_ships">Max</a>
		           	</th>
		        </tr>{/if}
				{foreach $FleetsOnPlanetSpecial as $FleetRow}
				 <tr class="fl_fllets_rows">
		            <td class="fl_fllets_rows_img_td"><a href="#" onclick="return Dialog.info({$FleetRow.id})"><img src="{$dpath}/gebaeude/{$FleetRow.id}.gif" alt="{$LNG.tech.{$FleetRow.id}}"></a></td>
		            <td> {if $FleetRow.speed != 0}<span class="tooltip" data-tooltip-content="{$LNG.fl_speed_title} {$FleetRow.speed}" style="cursor:help;">{$LNG.tech.{$FleetRow.id}}</span>{else}{$LNG.tech.{$FleetRow.id}}{/if}</td>
		            <td id="ship{$FleetRow.id}_value">{$FleetRow.count|number}</td>
		            <td class="fl_fllets_rows_input_td">
		            	<div class="fl_fllets_rows_input_div">
		                	<div onclick="minShip('ship{$FleetRow.id}');" class="fl_fllets_rows_input_min">Min</div>
		                    <div onclick="maxShip('ship{$FleetRow.id}');" class="fl_fllets_rows_input_max">Max</div>
		                	<input class="fl_fllets_rows_input_countdots countdots" name="ship{$FleetRow.id}" id="ship{$FleetRow.id}_input" size="10" value="0" />
		               	</div>
		            </td>
		        </tr>
				{/foreach}


				<tr style="height:20px;">
				{if count($FleetsOnPlanet) == 0}
				<td colspan="4">{$LNG.fl_no_ships}</td>
				{else}
				<tr class="gray_stripe">
					<td colspan="2" align="left"><a href="javascript:noShips();">{$LNG.fl_remove_all_ships}</a></td>
					<td colspan="2" align="right"><a href="javascript:maxShips();">{$LNG.fl_select_all_ships}</a></td>
				</tr>
				{/if}
				</tr>
				<td class="clear"></td>
				{if $maxFleetSlots != $activeFleetSlots}
				<td colspan="4" align="center"><input class="btn btn-dark btn-xs" type="submit" value="{$LNG.fl_continue}"></td>
				{/if}
			</table>	
		</form>
		<br>
		<table style="width: 100%;">
			<tr class="title"><th colspan="3">{$LNG.fl_bonus}</th></tr>
			<tr><th style="width:33%">{$LNG.fl_bonus_attack}</th><th style="width:33%">{$LNG.fl_bonus_defensive}</th><th style="width:33%">{$LNG.fl_bonus_shield}</th></tr>
			<tr><td>+{$bonusAttack} %</td><td>+{$bonusDefensive} %</td><td>+{$bonusShield} %</td></tr>
			<tr><th style="width:33%">{$LNG.tech.115}</th><th style="width:33%">{$LNG.tech.117}</th><th style="width:33%">{$LNG.tech.118}</th></tr>
			<tr><td>+{$bonusCombustion} %</td><td>+{$bonusImpulse} %</td><td>+{$bonusHyperspace} %</td></tr>
		</table>
	</div>
</div>

{/block}
{block name="script" append}<script src="scripts/game/fleetTable.js"></script>
<script type="text/javascript">
	fleetGroopShip	= [{foreach name=groupFleets item=GroupFleetRow from=$userGroupShip}{ {foreach $GroupFleetRow.FleetList as $shipID => $shipCount}"{$shipID}":{$shipCount}{if !$shipCount@last},{/if}{/foreach} },{/foreach}];
	var pointsPrice = { "ship202":0.004,"ship203":0.012,"ship204":0.004,"ship205":0.011,"ship206":0.0265,"ship207":0.058,"ship208":0.04,"ship209":0.018,"ship210":0.001,"ship211":0.12,"ship212":0.0025,"ship213":0.125,"ship214":10.5,"ship215":0.1,"ship216":12.5,"ship217":0.0565,"ship218":500,"ship219":1.8,"ship220":16,"ship221":580,"ship222":360,"ship223":5.625,"ship224":0.15,"ship225":1.8,"ship226":5.2,"ship227":42,"ship228":127,"ship229":0.0105,"ship230":27.75 };
</script>
{/block}
