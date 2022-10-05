{block name="title" prepend}{$LNG.lm_defenses}{/block}
{block name="content"}
<div id="build_content" class="conteiner container" style="width: 98%">
    <div class="gray_stripe text-center">
    	<span>{$LNG.lm_defenses}</span>
	</div>
	{if !$NotBuilding}
<div id="infobox" class="alert alert-danger text-center" style="padding-left: 50px"><i class="fas fa-exclamation-triangle fa-3x align-middle"></i> {$LNG.bd_building_shipyard}</div>
	{/if}
	{if !empty($BuildList)}
		<table style="width: 100%;" class="text-center">
			<tr>
				<td class="transparent">
					<div id="bx" class="z"></div>
					<i class="fas fa-tachometer-alt" style="font-size: 13px;"></i>  {$LNG.bd_destroy_time}: <span id="timeleft"></span>
					<br>
					<form action="game.php?page=defense" method="post">
					<input type="hidden" name="action" value="delete">
					<table style="width: 100%;">
					<tr>
						<td><select style="min-height: 150px;" name="auftr[]" id="auftr" size="10" multiple><option>&nbsp;</option></select></td>
					</tr>
					<tr>
						<th class="text-center"><div class="alert alert-info"><i class="fas fas fa-bullhorn fa-2x align-middle"></i> {$LNG.bd_cancel_warning}</div>
							<input type="submit" class="btn btn-dark btn-sm" value="{$LNG.bd_cancel_send}"></th>
					</tr>
					</table>
					</form>
				</td>
			</tr>
		</table>
		<br>
	{/if}
	<div id="shipyard_elements" class="build_list">
		<form action="game.php?page=defense" method="post">
			{foreach $elementList as $ID => $Element}
				<div class="build_box">
					<div class="head">
						<a href="#" onclick="return Dialog.info({$ID})">{$LNG.tech.{$ID}}</a> [<span class="tooltip" data-tooltip-content="{$LNG.bd_available}">{$Element.available|number}</span>/<span class="tooltip" data-tooltip-content="{$LNG.bd_max_ships_long}">{$Element.maxBuildable|number}]</span>
						<a href="#" onclick="return Dialog.info({$ID})" class="interrogation manual">?</a>
					</div>
					<div class="content_box">
						<div class="image">
							<img src="{$dpath}gebaeude/{$ID}.gif" alt="{$LNG.tech.$ID}">
						</div>
						<div class="prices">
						{foreach $Element.costResources as $RessID => $RessAmount}
							<div class="price">
								<img src="{$dpath}images/{$RessID}.png" class="tooltip" data-tooltip-content="{$LNG.tech.{$RessID}}" width="20" height="20" alt="{$LNG.tech.{$RessID}}"> <span class="tooltip" data-tooltip-content="{$LNG.tech.{$RessID}}" {if $Element.costOverflow[$RessID] == 0}class="res_{$RessID}_text"{/if} style="color:{if $Element.costOverflow[$RessID] == 0}{else}red{/if}">{$RessAmount|number}</span>						
							</div>					
						{/foreach}							
							<div class="price">
								<span style="font-weight: bold;"><i class="fas fa-tachometer-alt" style="font-size: 13px;"></i> {$Element.elementTime|time}</span>
							</div>
						</div>						
					</div>
					<div style="margin-top: 22px">
						{if $Element.AlreadyBuild}
							{elseif $NotBuilding && $Element.buyable}
                            	<input style="width:50%;height:33px;line-height:33px;margin-left:6px;border-color: #005a87; margin-right:1px;-moz-border-radius: 0px 0px 0px 0px;-webkit-border-radius: 0px 0px px 0px;border-radius: 0px 0px 0px;" type="text" name="fmenge[{$ID}]" id="input_{$ID}" value="0" tabindex="{$smarty.foreach.FleetList.iteration}" />
                            	<input style="padding:8px; margin-left: -10px; border-left: none;" type="button" value="{$LNG.bd_max_ships}" onclick="$('#input_{$ID}').val('{$Element.maxBuildable}')">    
								<input style="display:block;float:right;color: #fff;font-weight: bold; font-size: 13px;height:31px;line-height:31px;padding: 0 15px;border: 1px solid green !important;background: #16501cbf !important;-moz-border-radius: 0px 0px 3px;-webkit-border-radius: 0px 0px 3px 0px;border-radius: 0px 0px 3px;" type="submit" value="{$LNG.bd_build_ships}" />
						{/if}
					</div>
					
				</div>
			{/foreach}
		</form>
	</div>
</div>
{/block}
{block name="script" append}
<script type="text/javascript">
data			= {$BuildList|json};
bd_operating	= '{$LNG.bd_operating}';
bd_available	= '{$LNG.bd_available}';
</script>
{if !empty($BuildList)}
<script src="scripts/base/bcmath.js"></script>
<script src="scripts/game/shipyard.js"></script>
<script type="text/javascript">
$(function() {
    ShipyardInit();
});
</script>
{/if}
{/block}
