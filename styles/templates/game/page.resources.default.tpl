{block name="title" prepend}{$LNG.lm_resources}{/block}
{block name="content"}
<div class="content_page">
	<div class="gray_stripe" style="border-bottom:0;">
    	 {$header}
    </div>
    <form action="?page=resources" method="post">
		<input name="mode" value="send" type="hidden">
		<table class="tablesorter ally_ranks text-center">
			<tbody>
				<tr style="height:22px" class="fl_fllets_rows">
					<td style="width:40%">&nbsp;</td>
					<td style="width:10%"><font style="color:#a47d7a;">{$LNG.tech.901}</font></td>
					<td style="width:10%"><font style="color:#5ca6aa;">{$LNG.tech.902}</font></td>
					<td style="width:10%"><font style="color:#339966">{$LNG.tech.903}</font></td>
					<td style="width:10%"><font style="color:#f0bb62">{$LNG.tech.911}</font></td>
				</tr>
				<tr style="height:22px" class="fl_fllets_rows">
					<td  style="text-align: left;">{$LNG.rs_basic_income}</td>
					<td><font style="color:#a47d7a;">{$basicProduction.901|number}</font></td>
					<td><font style="color:#5ca6aa;">{$basicProduction.902|number}</font></td>
					<td><font style="color:#339966">{$basicProduction.903|number}</font></td>
					<td><font style="color:#f0bb62">{$basicProduction.911|number}</font></td>
				</tr>
				{foreach $productionList as $productionID => $productionRow}
					<tr style="height:22px" class="fl_fllets_rows"{if $productionID == 212} id="solarsatsTemp"{/if}>
						<td style="text-align: left;line-height: 20px;"><img src="{$dpath}gebaeude/{$productionID}.gif" alt="" style="height: 20px;width: 20px;float: left;margin-right: 4px;">{$LNG.tech.$productionID } ({if $productionID  > 200}{$LNG.rs_amount}{else}{$LNG.rs_lvl}{/if} {$productionRow.elementLevel})</td>
						<td><span class="tooltip_sticky" data-tooltip-content="<table class='tooltip_class_table'> <tbody><tr><th colspan='2'><font style='color:#a47d7a;'>{$LNG.tech.901}</font></th></tr> <tr> <td style='color: darkgray;'>Default</td><td >{$METALDEFAULT|number}</td> </tr><tr> <td style='color: darkgray;'>{$LNG.offi_1}</td><td >{$METALGOUVERN|number}</td> </tr><tr> <td style='color: darkgray;'>{$LNG.offi_2}</td><td >{$METALOFFICER|number}</td> </tr></tbody></table>" style="color:{if $productionRow.production.901 > 0}#a47d7a{elseif $productionRow.production.901 < 0}brown{else}#a47d7a{/if}">{$productionRow.production.901|number}{if $productionRow.production.901|number >0}<img src="styles/images/mark.png" style="margin-left: 2px;width: 12px;height: 12px; margin-bottom:3px" value="{$productionRow.production.901|number}">{/if}</span></td>
						
						
						
						<td><span class="tooltip_sticky" data-tooltip-content="<table class='tooltip_class_table'> <tbody><tr><th colspan='2'><font style='color:#5ca6aa;'>{$LNG.tech.902}</font></th></tr> <tr> <td style='color: darkgray;'>Default</td><td >{$CRYSADEFAULT|number}</td> </tr><tr> <td style='color: darkgray;'>{$LNG.offi_1}</td><td>{$CRYSAGOUVERN|number}</td> </tr><tr> <td style='color: darkgray;'>{$LNG.offi_2}</td><td>{$CRYSAOFFICER|number}</td> </tr></tbody></table>" style="color:{if $productionRow.production.902 > 0}#5ca6aa{elseif $productionRow.production.902 < 0}brown{else}#5ca6aa{/if}">{$productionRow.production.902|number}{if $productionRow.production.902|number >0}<img src="styles/images/mark.png" style="margin-left: 2px;width: 12px;height: 12px; margin-bottom:3px" value="{$productionRow.production.902|number}">{/if}</span></td>
						
						
						
						<td><span class="tooltip_sticky" data-tooltip-content="<table class='tooltip_class_table'> <tbody><tr><th colspan='2'><font style='color:#339966;'>{$LNG.tech.903}</font></th></tr> <tr> <td style='color: darkgray;'>Default</td><td >{$DEUTDDEFAULT|number}</td> </tr><tr> <td style='color: darkgray;'>{$LNG.offi_1}</td><td>{$DEUTDGOUVERN|number}</td> </tr><tr> <td style='color: darkgray;'>{$LNG.offi_2}</td><td>{$DEUTDOFFICER|number}</td> </tr></tbody></table>" style="color:{if $productionRow.production.903 > 0}#339966{elseif $productionRow.production.903 < 0}brown{else}#339966{/if}">{$productionRow.production.903|number}{if $productionRow.production.903|number >0}<img src="styles/images/mark.png" style="margin-left: 2px;width: 12px;height: 12px; margin-bottom:3px" value="{$productionRow.production.903|number}">{/if}</span></td>
						
						
						
						<td{if $productionID == 212} id="solarsatsTemp2"{/if}><span class="tooltip_sticky" data-tooltip-content="<table class='tooltip_class_table'> <tbody><tr><th colspan='2'><font style='color:#339966;'>{$LNG.tech.911}</font></th></tr> <tr> <td style='color: darkgray;'>Default</td><td >{$ENERDDEFAULT|number}</td> </tr><tr> <td style='color: darkgray;'>{$LNG.offi_1}</td><td>{$ENERDGOUVERN|number}</td> </tr><tr> <td style='color: darkgray;'>{$LNG.offi_2}</td><td>{$ENERDOFFICER|number}</td> </tr></tbody></table>" style="color:{if $productionRow.production.911 > 0}#f0bb62{elseif $productionRow.production.911 < 0}brown{else}#f0bb62{/if}">{$productionRow.production.911|number}{if $productionRow.production.911|number >0}<img src="styles/images/mark.png" style="margin-left: 2px;width: 12px;height: 12px; margin-bottom:3px" value="{$productionRow.production.911|number}">{/if}</span></td>
						
						
						
						<td style="width:10%">
							{html_options name="prod[{$productionID}]" options=$prodSelector selected=$productionRow.prodLevel}
						</td>
					</tr>
				{/foreach}
				<tr style="height:22px " class="fl_fllets_rows">
					<td style="text-align: left;text-align: left;line-height: 20px;"><img src="{$dpath}gebaeude/131.gif" style="height: 20px;width: 20px;float: left;margin-right: 4px;"><a href="#" onclick="return Dialog.info(131)" class="tooltip_sticky" data-tooltip-content="({$LNG.tech.131},{$LNG.tech.132},{$LNG.tech.133})">{$LNG.lv_technology} {$LNG.peace_2}</a></td>
					<td><span style="color:{if $bonusProduction.901 > 0}#a47d7a;{elseif $bonusProduction.901 < 0}brown{else}#a47d7a;{/if}">{$bonusProduction.901|number}</span></td>
					<td><span style="color:{if $bonusProduction.902 > 0}#5ca6aa{elseif $bonusProduction.902 < 0}brown{else}#5ca6aa{/if}">{$bonusProduction.902|number}</span></td>
					<td><span style="color:{if $bonusProduction.903 > 0}#339966{elseif $bonusProduction.903 < 0}brown{else}#339966{/if}">{$bonusProduction.903|number}</span></td>
					<td><span style="color:{if $bonusProduction.911 > 0}#f0bb62{elseif $bonusProduction.911 < 0}brown{else}#f0bb62{/if}">{$bonusProduction.911|number}</span></td>
					<td><input class="btn btn-xs btn-dark" value="{$LNG.rs_calculate}" type="submit" style="width:62px"></td>
				</tr>

				<tr style="height:22px" class="fl_fllets_rows">
					<td style="text-align: left;text-align: left;line-height: 20px;"><img src="styles/theme/gow/gebaeude/22.gif" style="height: 20px;width: 20px;float: left;margin-right: 4px;">{$LNG.rs_storage_capacity}</td>
					<td><span style="color:#a47d7a;">{$storage.901}</span></td>
					<td><span style="color:#5ca6aa;">{$storage.902}</span></td>
					<td><span style="color:#339966">{$storage.903}</span></td>
					<td><span style="color:#f0bb62">-</span></td>
				</tr>
				<tr style="height:22px"  class="fl_fllets_rows">
					<td style="text-align: left;text-align: left;line-height: 20px;">{$LNG.rs_sum}</td>
					<td><span style="color:{if $totalProduction.901 > 0}#a47d7a;{elseif $totalProduction.901 < 0}brown{else}#a47d7a;{/if}">{$totalProduction.901|number}</span></td>
					<td><span style="color:{if $totalProduction.902 > 0}#5ca6aa{elseif $totalProduction.902 < 0}brown{else}#5ca6aa{/if}">{$totalProduction.902|number}</span></td>
					<td><span style="color:{if $totalProduction.903 > 0}#339966{elseif $totalProduction.903 < 0}brown{else}#339966{/if}">{$totalProduction.903|number}</span></td>
					<td><span style="color:{if $totalProduction.911 > 0}#f0bb62{elseif $totalProduction.911 < 0}brown{else}#f0bb62{/if}">{$totalProduction.911|number}</span></td>
				</tr>
				<tr style="height:22pxtext-align: left;line-height: 20px;" class="fl_fllets_rows">
					<td style="text-align: left;">{$LNG.rs_daily}</td>
					<td><span style="color:{if $dailyProduction.901 > 0}#a47d7a{elseif $dailyProduction.901 < 0}brown{else}#a47d7a;{/if}">{$dailyProduction.901|number}</span></td>
					<td><span style="color:{if $dailyProduction.902 > 0}#5ca6aa{elseif $dailyProduction.902 < 0}brown{else}#5ca6aa{/if}">{$dailyProduction.902|number}</span></td>
					<td><span style="color:{if $dailyProduction.903 > 0}#339966{elseif $dailyProduction.903 < 0}brown{else}#339966{/if}">{$dailyProduction.903|number}</span></td>
					<td><span style="color:{if $dailyProduction.911 > 0}#f0bb62{elseif $dailyProduction.911 < 0}brown{else}#f0bb62{/if}">{$dailyProduction.911|number}</span></td>
				</tr>
				<tr style="height:22px" class="fl_fllets_rows">
					<td style="text-align: left;">{$LNG.rs_weekly}</td>
					<td><span style="color:{if $weeklyProduction.901 > 0}#a47d7a{elseif $weeklyProduction.901 < 0}brown{else}#a47d7a;{/if}">{$weeklyProduction.901|number}</span></td>
					<td><span style="color:{if $weeklyProduction.902 > 0}#5ca6aa{elseif $weeklyProduction.902 < 0}brown{else}#5ca6aa{/if}">{$weeklyProduction.902|number}</span></td>
					<td><span style="color:{if $weeklyProduction.903 > 0}#339966{elseif $weeklyProduction.903 < 0}brown{else}#339966{/if}">{$weeklyProduction.903|number}</span></td>
					<td><span style="color:{if $weeklyProduction.911 > 0}#f0bb62{elseif $weeklyProduction.911 < 0}brown{else}#f0bb62{/if}">{$weeklyProduction.911|number}</span></td>
				</tr>
			</tbody>
		</table>
	</form>
		<table class="tablesorter ally_ranks" style="margin-top: 5px;">
			<tbody>
				<tr>
			    	<td>
			        	<form action="?page=resources" method="post">
			            	<input name="mode" value="AllPlanets" type="hidden">
			                <input name="action" value="off" type="hidden">
			            	<button type="submit" style="height:100%;width:100%; background: rgba(255, 19, 0, 0.28); border: 1px rgb(251, 19, 0);">{$LNG.res_disable}</button>
			            </form>
			        </td>
			        <td>
			        	<form action="?page=resources" method="post">
			            	<input name="mode" value="AllPlanets" type="hidden">
			                <input name="action" value="on" type="hidden">
			            	<button type="submit" style="height:100%;width:100%;background: rgba(0,149,21,0.28);border: 1px rgba(0, 255, 0, 1);">{$LNG.res_activate}</button>
			            </form>
			        </td>
			    </tr>
			</tbody>
		</table>
</div>
{/block}
{block name="script" append}
{if $produceEnergy == 0}
<script type="text/javascript">
	$(function() {
	qtips_info('#solarsatsTemp2', '<a href="#" onclick="return Dialog.info(212)">{$LNG.over_referal_more}</a>', 'bottomMiddle', 'topMiddle', 975);
	});
</script>{/if}
{/block}
