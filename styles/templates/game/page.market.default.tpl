{block name="title" prepend}{$LNG.lm_markets}{/block}
{block name="content"}
<div id="build_content" class="conteiner container" style="width: 98%">
	<div class="gray_stripe text-center">
    	<span>{$LNG.lm_markets}</span>
        <a href="#" onclick="return Dialog.manualinfo(10);" class="interrogation manual">?</a>
	</div>
	<div id="market" class="locus" style="margin-top: 10px">
        {if isModuleAvailable($smarty.const.MODULE_FLEET_TRADER)}
        <div class="market_element img_fleettrader" style="margin-top: 10px">
            <a href="game.php?page=fleetDealer">
                <div class="market_title">{$LNG.lm_fleettrader}</div>
            </a>
        </div>
        {/if}
        {if isModuleAvailable($smarty.const.MODULE_TRADER)}
        <div class="market_element img_trader" style="margin-top: 10px">
            <a href="game.php?page=trader">
                <div class="market_title">{$LNG.lm_trader}</div>
            </a>
        </div>
        {/if}
	</div>
</div>
{/block}
