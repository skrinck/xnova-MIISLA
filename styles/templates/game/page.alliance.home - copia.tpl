{block name="title" prepend}{$LNG.lm_alliance}{/block}
{block name="content"}

<div class="content_page container" style="width:75%">
	<div class="title">
		<b>{$LNG.al_your_ally}</b>
	</div>
	<table class="table-responsive">
		<div>
			{if $ally_image}
					<img width="100%" src="{$ally_image}" />
			{/if}
			<br>
			<br>
			<div class="title">-</div>
			<div>
				<span class="pull-left" style="padding-left: 50px;">{$LNG.al_ally_info_tag}</span>
				<span class="pull-right" style="padding-right: 50px;">{$ally_tag}</span><br>
				<span class="pull-left" style="padding-left: 50px;">{$LNG.al_ally_info_name}</span>
				<span class="pull-right" style="padding-right: 50px;">{$ally_name}</span><br>
				<span class="pull-left" style="padding-left: 50px;">{$LNG.al_ally_info_members}</span>
				<span class="pull-right" style="padding-right: 50px;">{$ally_max_members} / {$ally_members}{if $rights.MEMBERLIST} (<a href="?page=alliance&amp;mode=memberList">{$LNG.al_user_list}</a>){/if}</span><br>
				<span class="pull-left" style="padding-left: 50px;">{$LNG.al_rank}</span>
				<span class="pull-right" style="padding-right: 50px;">{$rankName}{if $rights.ADMIN} (<a href="?page=alliance&amp;mode=admin">{$LNG.al_manage_alliance}</a>){/if}</span><br>
				{if $rights.SEEAPPLY && $applyCount > 0}		
				<span class="pull-left" style="padding-left: 50px;">{$LNG.al_requests}</span>
				<span class="pull-right" style="padding-right: 50px;"><a href="?page=alliance&amp;mode=admin&amp;action=mangeApply">{$requests}</a></span><br>
				{/if}
				{if $rights.ROUNDMAIL}
					<span class="pull-left" style="padding-left: 50px;">{$LNG.al_circular_message}</span>
					<span class="pull-right"  style="padding-right: 50px;"><a href="game.php?page=alliance&mode=circular" onclick="return Dialog.open(this.href, 650, 300);">{$LNG.al_send_circular_message}</a></span>
				{/if}<br>
				<div align="center">
				{if isModuleAvailable($smarty.const.MODULE_CHAT)}
					<span class="text-center"><a href="#" onclick="return Dialog.AllianceChat();">{$LNG.al_goto_chat}</a></span>
				{/if}
				</div>
			</div><br><br>
			{if $rights.EVENTS}
				<div class="title">
					<b>{$LNG.al_events}</b>
				</div>
				{if $ally_events}
						{foreach $ally_events as $member => $events}
								<tr>
									<th style="padding-left: 50%">{$member}</th>
								</tr>
							{foreach $events as $index => $fleet}
								<tr>
									<td id="fleettime_{$index}" class="fleets pull-left" style="padding-left: 10px;" data-fleet-end-time="{$fleet.returntime}" data-fleet-time="{$fleet.resttime}">-</td>
									<td class="pull-right" style="padding-left: 55px;">{$fleet.text}</td>
								</tr>
							{/foreach}
						{/foreach}
				{else}
						<div class="alert alert-info text-center" role="alert"><i class="fas fa-bullhorn fa-2x align-middle" style="margin-right: 5px;"></i>{$LNG.al_no_events}</div>
				{/if}
				{if $ally_pact_events}
					{foreach $ally_pact_events as $member => $events}
							<tr>
								<th style="padding-left: 50%"><b>Alianza Aliada</b> - <u>{$member}</u></th>
							</tr>
						{foreach $events as $index => $fleet}
							<tr>
								<td id="fleettime_{$index}" class="fleets pull-left" style="padding-left: 10px;" data-fleet-end-time="{$fleet.returntime}" data-fleet-time="{$fleet.resttime}">-</td>
								<td class="pull-right" style="padding-left: 55px;">{$fleet.text}</td>
							</tr>
						{/foreach}
					{/foreach}
				{/if}
			{/if}
		
			<br><br>
			<table width="100%">
				<tr class="title" colspan="2">
					<th class="text-center">{$LNG.al_outside_text}</th>
				</tr>
				<tr>
					<td class="bbcode text-center">{if $ally_description}{$ally_description}{else}{$LNG.al_description_message}{/if}</td>
				</tr>
				{if $ally_web}
				<tr>
					<td class="pull-left">{$LNG.al_web_text}</td>
					<td class="pull-right"><a href="{$ally_web}">{$ally_web}</a></td>
				</tr>
				{/if}
				<tr class="title" colspan="2">
					<th class="text-center">{$LNG.al_inside_section}</th>
				</tr>
				<tr>
					<td class="bbcode text-center">{$ally_text}</td>
				</tr>
				<tr class="title" colspan="2">
					<th class="text-center">{$LNG.al_diplo}</th>
				</tr>
				<tr>
					<td align="center">
					{if $DiploInfo}
						{if !empty($DiploInfo.0)}<b><u>{$LNG.al_diplo_level.0}</u></b><br><br>{foreach item=PaktInfo from=$DiploInfo.0}<a href="?page=alliance&mode=info&amp;id={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
					{if !empty($DiploInfo.1)}<b><u>{$LNG.al_diplo_level.1}</u></b><br><br>{foreach item=PaktInfo from=$DiploInfo.1}<a href="?page=alliance&mode=info&amp;id={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
					{if !empty($DiploInfo.2)}<b><u>{$LNG.al_diplo_level.2}</u></b><br><br>{foreach item=PaktInfo from=$DiploInfo.2}<a href="?page=alliance&mode=info&amp;id={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
					{if !empty($DiploInfo.3)}<b><u>{$LNG.al_diplo_level.3}</u></b><br><br>{foreach item=PaktInfo from=$DiploInfo.3}<a href="?page=alliance&mode=info&amp;id={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
						{if !empty($DiploInfo.4)}<b><u>{$LNG.al_diplo_level.4}</u></b><br><br>{foreach item=PaktInfo from=$DiploInfo.4}<a href="?page=alliance&mode=info&amp;id={$PaktInfo.1}">{$PaktInfo.0}</a><br>{/foreach}<br>{/if}
					{else}
						{$LNG.al_no_diplo}
					{/if}
					</td>
				</tr>
				<tr class="title" colspan="2">
					<th class="text-center">{$LNG.pl_fightstats}</th>
				</tr>
				<tr>
					<td class="pull-left">{$LNG.pl_totalfight}</td>
					<td class="pull-right">{$totalfight|number}</td>
				</tr>
				<tr>
					<td class="pull-left">{$LNG.pl_fightwon}</td>
					<td class="pull-right">{$fightwon|number} {if $totalfight}({round($fightwon / $totalfight * 100, 2)}%){/if}</td>
				</tr>
				<tr>	
					<td class="pull-left">{$LNG.pl_fightlose}</td>
					<td class="pull-right">{$fightlose|number} {if $totalfight}({round($fightlose / $totalfight * 100, 2)}%){/if}</td>
				</tr>
				<tr>	
					<td class="pull-left">{$LNG.pl_fightdraw}</td>
					<td class="pull-right">{$fightdraw|number} {if $totalfight}({round($fightdraw / $totalfight * 100, 2)}%){/if}</td>
				</tr>
				<tr>
					<td class="pull-left">{$LNG.pl_unitsshot}</td>
					<td class="pull-right">{$unitsshot}</td>
				</tr>
				<tr>
					<td class="pull-left">{$LNG.pl_unitslose}</td>
					<td class="pull-right">{$unitslose}</td>
				</tr>
				<tr>
					<td class="pull-left">{$LNG.pl_dermetal}</td>
					<td class="pull-right">{$dermetal}</td>
				</tr>
				<tr>
					<td class="pull-left">{$LNG.pl_dercrystal}</td>
					<td class="pull-right">{$dercrystal}</td>
				</tr>
				<!-- Abandonar alliance -->
				{if !$isOwner}
				<tr class="title">
					<th class="text-center">{$LNG.al_leave_alliance}</th>
				</tr>
				<br>
					<tr align="center">
						<td>
							<a href="game.php?page=alliance&amp;mode=close" onclick="return confirm('{$LNG.al_leave_ally}');">
								<button class="btn btn-dark btn-xs" >{$LNG.al_continue}</button>
							</a>
						</td>
					</tr>
				{/if}
			</table>
		</div>
	</table>
</div>
{/block}
