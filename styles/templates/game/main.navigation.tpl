<div id="leftmenu">

	<div class="text-center">
	<div class="title"><i class="fas fa-user"></i> {$LNG.ov_user_online}: <span style="font-weight: bold; color: lime;">{$onlineUser|number}</span>/<span style="font-weight: bold;">{$Usersmax}</span></div>
	<div id="indicators"><div id="attack" class="indicator {$attackActive} tooltip" data-tooltip-content="{if $totalAttacks > 0}{$LNG.customm_1_1}{else}{$LNG.customm_1}{/if}"><div class="icoi"></div></div><div id="destruction" class="indicator {if $unicAttacks > 0}active_indicator{/if} tooltip" data-tooltip-content="{if $unicAttacks > 0}{$LNG.customm_3_1}{else}{$LNG.customm_3}{/if}"><div class="icoi"></div></div><div id="espionage" class="indicator {if $totalSpio > 0}{$LNG.customm_4_1}{else}{$LNG.customm_4}{/if} tooltip" data-tooltip-content="{if $totalSpio > 0}active_indicator{/if}" href="game.php?page=overview"><div class="icoi"></div></div><div id="rocket" class="indicator {if $totalRockets > 0}active_indicator{/if} tooltip" data-tooltip-content="{if $totalRockets > 0}{$LNG.customm_5_1}{else}{$LNG.customm_5}{/if}"><div class="icoi"></div></div></div></div> 
	<br>
	<div>
		<div class="title">{$LNG.ov_obonus}</div>
		<div >
			{if $b_active}
				{if $BMine}
					{foreach item=bonus from=$all_bonus}
						{if $bonus.procent == 10}
							<a class="tooltip activo" data-tooltip-content="Producción de Minas aumentada al 10%">
								<img src="{$dpath}bonus/m1.gif" />
							</a>
						{elseif $bonus.procent == 30}
							<a class="tooltip" data-tooltip-content="Producción de Minas aumentada al 30%">
								<img src="{$dpath}bonus/m2.gif" />
							</a>
						{elseif $bonus.procent == 50}
							<a class="tooltip" data-tooltip-content="Producción de Minas aumentada al 50%">
								<img src="{$dpath}bonus/m3.gif" />
							</a>
						{/if}
					{/foreach}
				{/if}
				{if $BMO}
					{foreach item=bonus from=$all_bonus}
						{if $bonus.procent == 10}
							<a class="tooltip activo" data-tooltip-content="Probabilidad de encontrar Materia Oscura aumentada al 10% en expediciones">
								<img src="{$dpath}bonus/mo1.gif" />
							</a>
						{elseif $bonus.procent == 30}
							<a class="tooltip" data-tooltip-content="Probabilidad de encontrar Materia Oscura aumentada al 30% en expediciones">
								<img src="{$dpath}bonus/mo2.gif" />
							</a>
						{elseif $bonus.procent == 50}
							<a class="tooltip" data-tooltip-content="Probabilidad de encontrar Materia Oscura aumentada al 50% en expediciones">
								<img src="{$dpath}bonus/mo3.gif" />
							</a>
						{/if}
					{/foreach}
				{/if}
			{else}
				<div class="text-center">NO HAY BONO ACTIVO</div>
			{/if}
		</div>
	</div><br>
	<!--BEGIN navs by YamilRH -->
	<div class="tabse title">
		<a href="#tab2" class="btn btn-xs"><span class="fas fa-chart-bar"></span> {$LNG.lm_resources}</a>
		<a href="#tab1" class="btn btn-xs"><span class="fas fa-user"></span> {$LNG.mn_profile}</a>
		<a href="#tab3" class="btn btn-xs"><span class="fas fa-cogs"></span> {$LNG.lm_MOD}</a>
	</div>

	<div class="secciones">
		<article id="tab2">
				{if $bonus_time > TIMESTAMP}
					<div class="menu_content_full">
						Bono Siguiente {$bonus_time_rest}
					</div>
				{/if}
				<div class="menu_content_full">
					{if isModuleAvailable($smarty.const.MODULE_CHAT)}<a href="game.php?page=chat"><font color="sardeblack">{$LNG.lm_chat}</font></a>{/if}
				</div>
			<div class="row">
				{if isModuleAvailable($smarty.const.MODULE_BUILDING)}<div class="menu_content"><a href="game.php?page=buildings"><font color="sardeblack">{$LNG.lm_buildings}</font></a></div>{/if}
				{if isModuleAvailable($smarty.const.MODULE_RESEARCH)}<div class="menu_content"><a href="game.php?page=research"><font color="sardeblack">{$LNG.lm_research}</font></a></div>{/if}
				{if isModuleAvailable($smarty.const.MODULE_SHIPYARD_FLEET)}<div class="menu_content"><a href="game.php?page=shipyard&amp;mode=fleet"><font color="sardeblack">{$LNG.lm_shipshard}</font></a></div>{/if}
				{if isModuleAvailable($smarty.const.MODULE_SHIPYARD_DEFENSIVE)}<div class="menu_content"><a href="game.php?page=defense"><font color="sardeblack">{$LNG.lm_defenses}</font></a></div>{/if}
				{if isModuleAvailable($smarty.const.MODULE_OFFICIER) || isModuleAvailable($smarty.const.MODULE_DMEXTRAS)}<div class="menu_content"><a href="game.php?page=officier"><font color="sardeblack">{$LNG.lm_officiers}</font></a></div>{/if}
				<!--{if isModuleAvailable($smarty.const.MODULE_FLEET_TRADER)}<div class="menu_content"><a href="game.php?page=fleetDealer"><font color="sardeblack">{$LNG.lm_fleettrader}</font></a></div>{/if}
				{if isModuleAvailable($smarty.const.MODULE_TRADER)}<div class="menu_content"><a href="game.php?page=trader"><font color="sardeblack">{$LNG.lm_trader}</font></a></div>{/if}-->
				<div class="menu_content"><a href="game.php?page=fleetTable"><font color="sardeblack">{$LNG.lm_fleet}</font></a></div>
				{if isModuleAvailable($smarty.const.MODULE_RESSOURCE_LIST)}<div class="menu_content"><a href="game.php?page=resources"><font color="sardeblack">{$LNG.lm_prodution}</font></a></div>{/if}
				{if isModuleAvailable($smarty.const.MODULE_GALAXY)}<div class="menu_content"><a href="game.php?page=galaxy"><font color="00AAAA">{$LNG.lm_galaxy}</font></a></div>{/if}
				{if isModuleAvailable($smarty.const.MODULE_ALLIANCE)}<div class="menu_content"><a href="game.php?page=alliance"><font color="00AAAA">{$LNG.lm_alliance}</font></a></div>{/if}
<!--				<div class="menu_content"><a href="index.php?page=rules" target="rules"><font color="00AAAA">{$LNG.lm_rules}</font></a></div>-->
				{if isModuleAvailable($smarty.const.MODULE_SIMULATOR)}<div class="menu_content"><a href="game.php?page=battleSimulator"><font color="00AAAA">{$LNG.lm_battlesim}</font></a></div>{/if}
<!--				{if isModuleAvailable($smarty.const.MODULE_NOTICE)}<div class="menu_content"><a href="javascript:OpenPopup('?page=notes', 'notes', 720, 300);"><font color="00AAAA">{$LNG.lm_notes}</font></a></div>{/if}-->
				<div class="clear"></div>	
			</div>
			<!-- <div class="menu_content_full pulse">
				<a href="game.php?page=shop"><font color="00AAAA">{$LNG.lm_shop}(Donaciones)</font></a>
			</div> -->
		</article>
		<article id="tab1">
			<div class="menu_header">
				{imageApodo($ranking)}<br>
				{$LNG.mn_username}: <span style="color: cyan; font-weight: bold;">{$username}</span><br>
				<div class="onligne">
					{$LNG.mn_ranking}: <a href="game.php?page=statistics&range={$rankGlobal}">{$rankGlobal}</a><br>
					<span>{$LNG.mn_battle}: {$totalGlobal}</span><br>
					<span>{$LNG.mn_points}: {$pointsGlobal}</span><br>
					<span>{$LNG.mn_wins}: {$yfightwon} {$LNG.mn_that} {$winsGlobal}%</span><br>
					<span>{$LNG.mn_draws}: {$yfightdraw} {$LNG.mn_that} {$ypdraws}%</span><br>
					<span>{$LNG.mn_loos}: {$yfightlose} {$LNG.mn_that} {$yploos}%</span><br>
					<span>{$LNG.mn_unitsshot}: {$yunitsshot}</span><br>
					<span>{$LNG.mn_unitslose}: {$yunitslose}</span><br>
					<span>{$LNG.mn_dermetal}: {$ydermetal}</span><br>
					<span>{$LNG.mn_dercrystal}: {$ydercrystal}</span><br>
					{$LNG.mn_fleet}: <span style="color:{($maxfleetcount/$fleetmax*100 >70)?"red":"lime"}"><b class="tooltip" data-tooltip-content="{$LNG.max_fleetcount}">{$maxfleetcount}</b></span>/<b class="tooltip" data-tooltip-content="{$LNG.fleet_max}" style="color: red;">{$fleetmax}</b><br>
				</div>
			</div>
		</article>
		<article id="tab3">
			<div class="row">
<!--				<div class="menu_content"><a href="game.php?page=relocate"><font color="orange celestial">{$LNG.rm_relocate}</font></a></div>	-->
				<div class="menu_content"><a href="game.php?page=race"><font color="orange celestial">{$LNG.fraction_fraction}</font></a></div>	
				<div class="menu_content"><a href="game.php?page=tutorial"><font color="orange celestial">{$LNG.tut_tut}</font></a></div>
				<div class="menu_content"><a href="game.php?page=PlanetRadar"><font color="orange celestial">{$LNG.Radar}</font></a></div>
			</div>
		</article>
	</div>

	<!-- END navs by YamilRH -->

	<div class="menu_content_full">
		{if $authlevel > 0}<a target="_blank" href="./admin.php" style="color:lime">{$LNG.lm_administration}</a>{/if}
	</div><div class="menu_content_full">
                {if $authlevel > 0}<a href="game.php?page=ticketadmin" style="color:lime">Administrar Tickets</a>{/if}
        </div>

	{if $alliance !=0}
	<table id="memberList" style="width:100%;" class="tablesorter">
		<thead>
			<th colspan="8" class="title">Alianza <a class="tooltip" data-tooltip-content="Enviar Mensaje global"  href="game.php?page=alliance&mode=circular" onclick="return Dialog.open(this.href, 650, 300);"><i class="fas fa-share-square"></i></a></th>
		</thead>
		<tbody>
			{foreach $memberList as $userID => $memberListRow}
			<tr class="">
				<td><a href="#" onclick="return Dialog.Playercard({$userID}, '{$memberListRow.username}');" class="tooltip" data-tooltip-content="<table class='tablesorter'><thead><th class='text-center'>{$LNG.al_position}</th><th class='text-center'>{$LNG.al_points}</th></thead><tbody><td>{$memberListRow.rankName}</td>
				<td data-points='{$memberListRow.points}'>{$memberListRow.points|number}</td></tbody></table>">{$memberListRow.username}</a></td>				<td>
					<a href="#" onclick="return Dialog.PM({$userID});">
						<i class="far fa-envelope tooltip" data-tooltip-content="{$LNG.write_message}" style="font-size: 15px;"></i>
					</a>
				</td>
				<td>{if $memberListRow.onlinetime < 4}<span style="color:lime">{$LNG.al_memberlist_on}</span>{elseif $memberListRow.onlinetime <= 15}<span style="color:yellow">{$memberListRow.onlinetime} {$LNG.al_memberlist_min}</span>{else}<span style="color:red">{$LNG.al_memberlist_off}</span>{/if}</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
	{/if}
	<div class="menu_footer">
		<div><i class="fas fa-clock"></i> <span class="servertime">{$servertime}</span></div>
		<div><i class="far fa-copyright"></i> Copyright {$game_name} 2020</div>
	</div>
</div>
<div style="height:0; overflow:hidden;" loop="false;" id="music">
		<audio id="beepataks" preload="auto">
        <source src="{$dpath}/sound/sirena.mp3">
        <source src="{$dpath}/sound/sirena.ogg"> 
    </audio>
    <script type="text/javascript">
        var ataks = "{$totalAttacks}";
        var spio = "{$totalSpio}";
        var unic = "{$unicAttacks}";
        var rakets = "{$totalRockets}";
		
		document.getElementById('beepataks').volume={$sirena};
		setInterval(function() { AJAX() }, 5000);
    </script>
</div>
