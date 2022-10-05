<tr class="title">
	<th style="width:60px;" class="text-center">{$LNG.st_position}</th>
	<th class="text-center">{$LNG.st_rankbuild}</th>
	<th class="text-center">{$LNG.st_ranktech}</th>
	<th class="text-center">{$LNG.st_rankfleet}</th>
	<th class="text-center">{$LNG.st_rankdefens}</th>
	<th class="text-center">{$LNG.st_rank}</th>
	<th class="text-center">Facciones</th>
	<th class="text-center">Trofeos</th>
	<th class="text-center" colspan="2">{$LNG.st_player}</th>
	<th class="text-center">{$LNG.st_points}</th>
</tr>
{foreach name=RangeList item=RangeInfo from=$RangeList}
<tr>
	<td class=""><a class="tooltip" data-tooltip-content="{if $RangeInfo.ranking == 0}<span style='color:#87CEEB'>*</span>{elseif $RangeInfo.ranking < 0}<span style='color:red'>-{$RangeInfo.ranking}</span>{elseif $RangeInfo.ranking > 0}<span style='color:green'>+{$RangeInfo.ranking}</span>{/if}">{$RangeInfo.rank}</a> {if $RangeInfo.ranking == 0}<span style='color:#87CEEB'>*</span>{elseif $RangeInfo.ranking < 0}<span style='color:red'>-{$RangeInfo.ranking}</span>{elseif $RangeInfo.ranking > 0}<span style='color:green'>+{$RangeInfo.ranking}</span>{/if}</td>
	<td class="">{$RangeInfo.rankbuild}</td>
	<td class="">{$RangeInfo.ranktech}</td>
	<td class="">{$RangeInfo.rankfleet}</td>
	<td class="">{$RangeInfo.rankdefs}</td>
	<td class="rango_est">{imageRango($RangeInfo.point)}</td>
	<td class="rango_est">{imageRace($RangeInfo.race)}</td>
	<td class="rango_est">
		{foreach name=ydesunitsList item=List from=$ydesunitsList}
			{if {$RangeInfo.id} == {$List.id}}<img src="{$dpath}trofeos/yunidades.png" class="tooltip" data-tooltip-content="Mas Unidades Destruidas" style="height: 12px;">{else}{/if}
		{/foreach}
	</td>

	<td class=" text-right" style="padding-right:20px" colspan="2">{if $RangeInfo.allyid != 0}<a href="game.php?page=alliance&amp;mode=info&amp;id={$RangeInfo.allyid}"><span {if $RangeInfo.allyid == $CUser_ally}style="color:#33CCFF"{else}style="color:#4899de"{/if} class="tooltip" data-tooltip-content="{$RangeInfo.allyname} {if $RangeInfo.ally_fraction_id != 0}<img alt='' class='fraction_ico_mini_t' src='{$dpath}img/race/fraction_{$RangeInfo.ally_fraction_id}.png'><div style='border-bottom:1px dashed #666; margin:0px 0 4px 0;'></div>{$RangeInfo.ally_fraction_name} ({$RangeInfo.ally_fraction_level}){else}{/if}">[{$RangeInfo.allytag}]&nbsp;</span></a>{else}{/if}<a href="#" onclick="return Dialog.Playercard({$RangeInfo.id}, '{$RangeInfo.name}');"><span class="{foreach $RangeInfo.class as $class}{if !$class@first} {/if}galaxy-username-{$class}{/foreach} galaxy-username">{$RangeInfo.name}&nbsp;</span></a>{if $RangeInfo.is_leader}<a style="color:yellow" class="tooltip" data-tooltip-content="<table width='100%'><tr><th colspan='2' style='text-align:center;'>{$RangeInfo.ally_owner_range}</th></tr><tr><td class='transparent'>{$RangeInfo.allyname}</td></tr><tr><th colspan='2' style='text-align:center;'>{$LNG.al_ally_info_members}</th></tr><tr><td class='transparent'>{$RangeInfo.members}</td></tr></table>"><i class="fas fa-trophy"></i></a> {/if}{if !empty($RangeInfo.class)}({foreach $RangeInfo.class as $class}{if !$class@first}&nbsp;{/if}<span class="galaxy-short-{$class} galaxy-short"><a class="tooltip" data-tooltip-content="{$LNG.$class}">{$ShortStatus.$class}</a></span>{/foreach}){/if} {if $RangeInfo.id != $CUser_id}<a href="#" onclick="return Dialog.PM({$RangeInfo.id});"><i class="far fa-envelope" title="{$LNG.st_write_message}" style="font-size: 15px;"></i></a>{/if}</td>
	<td class="">{$RangeInfo.points}</td>
</tr>
{/foreach}
