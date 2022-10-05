<tr class="title">
	<th style="width:60px;" class="text-center">{$LNG.st_position}</th>
	<th class="text-center">{$LNG.st_lvl}</th>
	<th class="text-center">{$LNG.st_rank}</th>
	<th class="text-center">{$LNG.st_alliance}</th>	
	<th class="text-center">{$LNG.st_members}</th>
	<th class="text-center">{$LNG.st_points}</th>
	<th class="text-center">{$LNG.st_per_member}</th>
</tr>
{foreach name=RangeList item=RangeInfo from=$RangeList}
<tr>
	<td>{$RangeInfo.rank}</td>
	<td>{if $RangeInfo.ranking == 0}<span style='color:#87CEEB'>*</span>{elseif $RangeInfo.ranking < 0}<span style='color:red'>{$RangeInfo.ranking}</span>{elseif $RangeInfo.ranking > 0}<span style='color:green'>+{$RangeInfo.ranking}</span>{/if}</td>
	<td class="rango_est">{imageAlianza($RangeInfo.ypoint)}</td>
	<td><a href="game.php?page=alliance&amp;mode=info&amp;id={$RangeInfo.id}" target="ally"{if $RangeInfo.id == $CUser_ally} style="color:lime"{/if}>{$RangeInfo.name}</a></td>
	<td>{$RangeInfo.members}</td>
	<td>{$RangeInfo.points}</td>
	<td>{$RangeInfo.mppoints}</td>
</tr>
{/foreach}