{block name="title" prepend}{$LNG.lm_officiers}{/block}
{block name="content"}
<span class="ir-arriba fas fa-arrow-up fa-3x"></span>
<div id="build_content" class="conteiner container" style="width: 98%">

	

	<div class="gray_stripe text-center" style="padding-right:0;">
		{$LNG.lm_officiers}{if isModuleAvailable($smarty.const.MODULE_GUBERNATORS)}<a href="game.php?page=gubernators"><input class="right_flank btn btn-dark btn-xs" style="padding:5px" value="{$LNG.lm_gubernators}" type="button"> </a>{/if}
	</div>
	<div id="dmbonus_elements" class="dmbonus_list">
		{foreach $officierList as $ID => $Element}
			<div class="build_box">
	            <div class="head">
	            	{$LNG.tech.$ID} {if $Element.level > 0}[{$Element.level}/{$Element.maxLevel}]{/if} 
	            </div>
	            <div class="content_box">
	            	<div class="image">
						<img src="{$dpath}gebaeude/{$ID}.jpg" alt="{$LNG.tech.$ID}">
					</div>
					<div class="prices">
						{foreach $Element.elementBonus as $BonusName => $Bonus}
							<div class="price">
								 {$LNG.bonus.$BonusName} <sup class="text-success">{if $Bonus@iteration % 3 === 1}{/if}{if $Bonus[0] < 0}-{else}+{/if}{if $Bonus[1] == 0}{abs($Bonus[0] * 100)}%{else}{$Bonus[0]}{/if}{if $Bonus@iteration % 3 === 0 || $Bonus@last}{else}&nbsp;{/if}</sup>
							</div>
						{/foreach}
						{foreach $Element.costResources as $RessID => $RessAmount}
							<div class="price">
								<img src="{$dpath}images/{$RessID}.png" class="tooltip" data-tooltip-content="{$LNG.tech.{$RessID}}" width="20" height="20" alt="{$LNG.tech.{$RessID}}"> <span class="tooltip" data-tooltip-content="{$LNG.tech.{$RessID}}" {if $Element.costOverflow[$RessID] == 0}class="res_{$RessID}_text"{/if} style="color:{if $Element.costOverflow[$RessID] == 0}{else}red{/if}">{$RessAmount|number}</span>						
							</div>					
						{/foreach}	
					</div>
					<div style="margin-top: 22px">
						{if $Element.maxLevel <= $Element.level}
						<button class="construct_button_lost_officer construct_button" style="color:red">
							{$LNG.bd_maxlevel}
						</button>
						{elseif $Element.buyable}
							<form action="game.php?page=officier" method="post" class="build_form">
								<input type="hidden" name="id" value="{$ID}">
								<button type="submit" class="build_submit construct_button_officer">{$LNG.of_recruit}</button>
							</form>
						{else}
						<button type="submit" class="construct_button_officer construct_button_lost_officer" style="color:#FF0000">{$LNG.dmbonus_norecruit}</button>
						{/if}
					</div>
	            </div>
	        </div>
	    {/foreach}
	</div>
</div>
{/block}
{block name="script"}
<script src="scripts/game/officier.js"></script>
{/block}
