{block name="title" prepend}{$LNG.lm_overview}{/block}
{block name="script" append}{/block}
{block name="content"}
<div style="margin: 1%">
	{if $closed}
		<div class="alert alert-danger text-center"><i class="fas fa-exclamation-triangle fa-2x"></i> {$LNG.ov_closed}</div>
		{elseif $delete}
		<div class="alert alert-danger text-center"><i class="fas fa-exclamation-triangle fa-2x"></i> {$delete}</div>
		{elseif $vacation}
		<div class="alert alert-info text-center"><i class="fas fa-exclamation-triangle fa-2x"></i> {$LNG.tn_vacation_mode} {$vacation}</div>
	{/if}
</div>
<div class="content_page" style="width: 98%;">
	<div class="title">
		<span><i class="fas fa-user-shield"></i> {$LNG.ov_admins_online}:  {foreach $AdminsOnline as $ID => $Name}{if !$Name@first}&nbsp;&bull;&nbsp;{/if}<a href="#" onclick="return Dialog.PM({$ID})">{$Name}</a> {foreachelse}{$LNG.ov_no_admins_online}{/foreach}</span>
	</div>
	<div class="title text-info"><i class="fas fa-users"></i> {$LNG.lm_online} / {$Users} de {$Usersmax}</div>
	<div class="alert alert-info text-center"><i class="fas fa-bullhorn fa-2x align-middle"></i> Bienvenidos al Moon Dark, es importante que revisen periódicamente la página del <a href="http://tinored.jovenclub.cu/index.php?/forum/31-xnova/" style="color: red;"><b>Foro Soporte</b></a></div>

	<div>
		<table style="width: 100%;">
			{foreach $fleets as $index => $fleet}
			<tr>
				<td id="fleettime_{$index}" class="fleets" data-fleet-end-time="{$fleet.returntime}" data-fleet-time="{$fleet.resttime}">{pretty_fly_time({$fleet.resttime})}</td>
				<td colspan="2">{$fleet.text}</td>
			</tr>
			{/foreach}
		</table>
	</div>

	<div>
		<div id="contentPlanet" style="background: url({$dpath}planeten/{$planetimage}.jpg) no-repeat; background-size: cover; margin-top: 10px;">

			<div id="namePlanet">
				<a href="#" onclick="return Dialog.PlanetAction();" class="tooltip" data-tooltip-content="{$LNG.ov_planetmenu}" >{$LNG["type_planet_{$planet_type}"]} "<span class="planetname">{$planetname}</span>"</a>
			</div>

			{if $planet_type == 1}
			<div id="lunePlanet">
				{if $Moon}<a href="game.php?page=overview&amp;cp={$Moon.id}&amp;re=0" class="tooltip" data-tooltip-content="{$Moon.name}"><i class="fas fa-moon"></i> {$Moon.name} ({$LNG.fcm_moon})</a>{else}<i class="far fa-moon"></i> <a href="#!">{$LNG.ov_create_moon}</a>{/if}
			</div>
			{/if}

			<div id="listDetailPlanet">
				<table>
					<tbody>
						<tr>
							<td class="desc">{$LNG.ov_diameter}</td>
							<td class="data">{$planet_diameter} {$LNG.ov_distance_unit} (<a title="{$LNG.ov_developed_fields}">{$planet_field_current}</a> / <a title="{$LNG.ov_max_developed_fields}">{$planet_field_max}</a> {$LNG.ov_fields})</td>
						</tr>
						<tr>
							<td class="desc">{$LNG.ov_temperature}</td>
							<td class="data">{$LNG.ov_aprox} {$planet_temp_min}{$LNG.ov_temp_unit} {$LNG.ov_to} {$planet_temp_max}{$LNG.ov_temp_unit}</td>
						</tr>
						<tr>
							<td class="desc">{$LNG.ov_position}</td>
							<td class="data"><a href="game.php?page=galaxy&amp;galaxy={$galaxy}&amp;system={$system}">[{$galaxy}:{$system}:{$planet}]</a></td>
						</tr>
						<tr>
							<td class="desc">{$LNG.ov_points}</td>
							<td class="data">{$rankInfo}</td>
						</tr>
					</tbody>
				</table>
			</div>
			{foreach $fleet as $index => $flota}
			<div id="listship">
				<table>
					<tbody>
						<tr>
							<td class="desc">{$LNG.ls_tship}</td>
							
							<td class="data"><a data-tooltip-content="{if $total_ship==0 } {$LNG.fl_no_ships} {/if}{if $total_ship!=0 }<table style='width:200px'>
								<tr><span>{$LNG.ls_tship}</span></tr>
										<hr>
								{foreach $ships as $ids=>$sh}
									{if $sh['amount']!=0}
										<tr>
											<td style='width:50%'>{$LNG.tech.$ids}</td>
											<td style='width:50%'>{$sh['amount']|number}</td>
										</tr>
									{/if}
								{/foreach}</table>{/if}" class="tooltip">{$total_ship}</a></td>
						</tr>
						<tr>
							<td class="desc">{$LNG.ls_ship_civ}</td>
							<td class="data"><a data-tooltip-content="{if $ship_civ['amount']==0 } {$LNG.fl_no_ships} {/if}{if $ship_civ['amount']!=0 }<table style='width:200px'>
								<tr><span>{$LNG.ls_ship_civ}</span></tr>
										<hr>
								{foreach $ship_civ['ids'] as $id}
									{if $ships[$id]['amount']!=0}
										<tr>
											<td style='width:50%'>{$LNG.tech.$id}</td>
											<td style='width:50%'>{$ships[$id]['amount']|number}</td>
										</tr>
									{/if}
								{/foreach}</table>{/if}" class="tooltip">{$ship_civ['amount']}</a>
							</td>
						</tr>
						<tr>
							<td class="desc">{$LNG.ls_ship_comb}</td>
							<td class="data"><a data-tooltip-content="{if $ship_comb['amount']==0 } {$LNG.fl_no_ships} {/if}{if $ship_comb['amount']!=0 }<table style='width:200px'>
								<tr><span>{$LNG.ls_ship_comb}</span></tr>
										<hr>
								{foreach $ship_comb['ids'] as $id}
									{if $ships[$id]['amount']!=0}
										<tr>
											<td style='width:50%'>{$LNG.tech.$id}</td>
											<td style='width:50%'>{$ships[$id]['amount']|number}</td>
										</tr>
									{/if}
								{/foreach}</table>{/if}" class="tooltip">{$ship_comb['amount']}</a></td>
						</tr>
						<tr>
							<td class="desc">{$LNG.ls_ship_ins}</td>
							<td class="data"><a data-tooltip-content="{if $ship_ins['amount']==0 } {$LNG.fl_no_ships} {/if}{if $ship_ins['amount']!=0 }<table style='width:200px'>
								<tr><span>{$LNG.ls_ship_ins}</span></tr>
										<hr>
								{foreach $ship_ins['ids'] as $id}
									{if $ships[$id]['amount']!=0}
										<tr>
											<td style='width:50%'>{$LNG.tech.$id}</td>
											<td style='width:50%'>{$ships[$id]['amount']|number}</td>
										</tr>
									{/if}
								{/foreach}</table>{/if}" class="tooltip">{$ship_ins['amount']}</a></td>
						</tr>
						<tr>
							<td class="desc">{$LNG.ls_ship_cap}</td>
							<td class="data"><a data-tooltip-content="{if $ship_cap['amount']==0 } {$LNG.fl_no_ships} {/if}{if $ship_cap['amount']!=0 }<table style='width:200px'>
								<tr><span>{$LNG.ls_ship_cap}</span></tr>
										<hr>
								{foreach $ship_cap['ids'] as $id}
									{if $ships[$id]['amount']!=0}
										<tr>
											<td style='width:50%'>{$LNG.tech.$id}</td>
											<td style='width:50%'>{$ships[$id]['amount']|number}</td>
										</tr>
									{/if}
								{/foreach}</table>{/if}" class="tooltip">{$ship_cap['amount']}</a></td>
						</tr>
					</tbody>
				</table>
			</div>
			{/foreach}

		</div>
		
		<div>
			<div class="listBat">
				<div class="title">{$LNG.ov_list_title_build}</div>
				{foreach $allConstr as $item }
				    {$item['planet']['name']}({$item['planet']['galaxy']}:{$item['planet']['system']}:{$item['planet']['planet']}) - {$LNG.tech[$item['id']]} <span class="level">({$item['level']})</span><br><div class="timer" data-time="{$item['timeleft']}">{$item['starttime']}</div><hr>
				   {foreachelse} <i class="fas fa-hashtag"></i> {$LNG.ov_free}
				    {/foreach}
			</div>
			<div class="listRech">
				<div class="title">{$LNG.ov_list_title_tech}</div>
				{if $buildInfo.tech}
				<a href="game.php?page=galaxy&amp;galaxy={$galaxy}&amp;system={$system}">[{$galaxy}:{$system}:{$planet}]</a> - {$LNG.tech[$buildInfo.tech['id']]} <span class="level">({$buildInfo.tech['level']})</span><br><div class="timer" data-time="{$buildInfo.tech['timeleft']}">{$buildInfo.tech['starttime']}</div>{else}<i class="fas fa-hashtag"></i> {$LNG.ov_free}{/if}
			</div>
			<div class="listFleet">
				<div class="title">{$LNG.ov_list_title_fleet}</div>
				 {if $buildInfo.fleet}
				 <a href="game.php?page=galaxy&amp;galaxy={$galaxy}&amp;system={$system}">[{$galaxy}:{$system}:{$planet}]</a> - {$LNG.tech[$buildInfo.fleet['id']]} <span class="level">({$buildInfo.fleet['level']})</span><br><div class="timer" data-time="{$buildInfo.fleet['timeleft']}">{$buildInfo.fleet['starttime']}</div>{else}<i class="fas fa-hashtag"></i> {$LNG.ov_free}{/if}
			</div>
<div class="listFleet">
	<div class="title">
		{$LNG.ov_list_title_defense}
	</div>
	<i class="fas fa-hashtag"></i> 
	{if $buildInfo.defense}
		{$LNG.tech[$buildInfo.defense['id']]} 
		<span class="level">
			({$buildInfo.defense['level']})
		</span><br>
		<div class="timer" data-time="{$buildInfo.defense['timeleft']}">
			{$buildInfo.defense['starttime']}
		</div>
	{else}
		{$LNG.ov_free}
	{/if}
</div>
			<div class="clear"></div>
		</div>
		<br><br>
		{if $is_news}
		<div>
			<div class="title">{$LNG.ov_news}</div>
			<div>{$news}</div>
			<!--<div class="alert alert-info"><i class="fas fa-bullhorn fa-2x align-middle"></i> Si desea Descativar el código de 2do factor visita el siguiente <b><a href="https://www.miisla.nat.cu/soporte/index.php?threads/segundo-factor-de-autenticaci%C3%B3n-en-moon-dark.46/post-420" style="color: red;">ENLACE</a></b><br>
			</div>-->
		</div>
		{/if}

		{if $ref_active}
		<div style="margin-top: 10px; text-align: center;">
			<div class="title">{$LNG.ov_reflink}</div>
			<div><input id="referral" type="text" value="{$path}index.php?ref={$userid}" readonly="readonly" style="width:450px;" /></div>

			<table style="width: 100%;">
				{foreach $RefLinks as $RefID => $RefLink}
				<tr>
					<td colspan="2"><a href="#" onclick="return Dialog.Playercard({$RefID}, '{$RefLink.username}');">{$RefLink.username}</a></td>
					<td>{{$RefLink.points|number}} / {$ref_minpoints|number}</td>
				</tr>
				{foreachelse}
				<tr>
					<td colspan="3">{$LNG.ov_noreflink}</td>
				</tr>
				{/foreach}
			</table>
		</div>
		{/if}
	</div>
</div>

{/block}
{block name="script" append}
    <script src="scripts/game/overview.js"></script>
{/block}
