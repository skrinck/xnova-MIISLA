{block name="title" prepend}{$LNG.lm_topkb}{/block}
{block name="content"}
<br>
<span class="ir-arriba fas fa-arrow-up fa-3x"></span>
<table class="content_page">
<tbody>
<tr class="title">
    <th colspan="5" class="text-center">{$LNG.tkb_top}</th>
</tr>
<tr>
    <td colspan="4" class="text-center">{$LNG.tkb_gratz}</td>
</tr>
<tr class="title">
<td colspan="5">{$LNG.tkb_legende}<span style="color:#00FF00">{$LNG.tkb_gewinner}</span><span style="color:#FF0000">{$LNG.tkb_verlierer}</span></td>
</tr>
<tr>
    <td style="padding-right: 50px">{$LNG.tkb_platz}</td>
	<td>{$LNG.tkb_owners}</td>
    <td><a href="game.php?page=battleHall&amp;order=date&amp;sort={if $sort == "ASC"}DESC{else}ASC{/if}"{if $order == "date"} style="font-weight:bold;"{/if}>{$LNG.tkb_datum}</a></td>
	<td><a href="game.php?page=battleHall&amp;order=units&amp;sort={if $sort == "ASC"}DESC{else}ASC{/if}"{if $order == "units"} style="font-weight:bold;"{/if}>{$LNG.tkb_units}</a></td>
    <td>Comentarios</td>
</tr>
{foreach $TopKBList as $row}
    <tr class="day{floor($row.time / 86400)} week{floor($row.time / 604800)}">
        <td>{if $row@iteration == "1"}<img src="styles/theme/gow/batle/1trof.png" style="height: 12px;">{elseif $row@iteration == "2"}<img src="styles/theme/gow/batle/2trof.png" style="height: 12px;">{elseif $row@iteration == "3"}<img src="styles/theme/gow/batle/3trof.png" style="height: 12px;" >{else}{$row@iteration}{/if}</td>
        <td><a href="game.php?page=raport&amp;mode=battlehall&amp;raport={$row.rid}" target="_blank">
        {if $row.result == "a"}
        <span style="color:#00FF00">{$row.attacker}</span> VS <span style="color:#FF0000">{$row.defender}</span>
        {elseif $row.result == "r"}
        <span style="color:#FF0000">{$row.attacker}</span> VS <span style="color:#00FF00">{$row.defender}</span>
        {else}
        {$row.attacker} VS {$row.defender}
        {/if}
        </a></td>
        <td style="padding-right: 50px">{$row.date}</td>
        <td>{$row.units|number}</td>
        <!-- <td>{if empty($row.comments)}Sin comentarios{else}{$row.comments}{/if}</td> -->
        <td class="ticket_row_linck_status" style="color:darkgrey;width:20px;text-align:center;">{$row.AMOUNTCOMMENT}</td>
    </tr>
{/foreach}
</tbody>
</table>
{/block}