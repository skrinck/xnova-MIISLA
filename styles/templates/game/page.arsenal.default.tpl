{block name="title" prepend}{$LNG.lm_arsenal}{/block}
{block name="content"}
<div id="build_content" class="conteiner container" style="width: 98%">
    <div class="gray_stripe">
	<span>{$LNG.tech.1000} </span>
       <a href="#" onclick="return Dialog.manualinfo(10);" class="interrogation manual">?</a>
	</div>
    <div id="dmbonus_elements" class="dmbonus_list">
        {foreach $arsList as $ID => $Element}
            <div class="build_box">
                <div class="head">
                    {$LNG.tech.$ID} {if $Element.level > 0}[{$Element.level}/{$Element.maxLevel}]{/if} 
                </div>
                <div class="content_box">
                    <div class="image">
                        <img src="{$dpath}gebaeude/{$ID}.gif" alt="{$LNG.tech.$ID}">
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
                            <form action="game.php?page=arsenal" method="post" class="build_form">
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
        <div class="clear"></div>
    </div>
</div>
</div>
            <div class="clear"></div>           
        </div><!--/body-->
<script type="text/javascript">

var ctrlKeyDown = false;

$(document).ready(function(){    
    $(document).on("keydown", keydown);
    $(document).on("keyup", keyup);
});

function keydown(e) { 

    if ((e.which || e.keyCode) == 116 || ((e.which || e.keyCode) == 82 && ctrlKeyDown)) {
        // Pressing F5 or Ctrl+R
        e.preventDefault();
    } else if ((e.which || e.keyCode) == 17) {
        // Pressing  only Ctrl
        ctrlKeyDown = true;
    }
};

function keyup(e){
    // Key up Ctrl
    if ((e.which || e.keyCode) == 17) 
        ctrlKeyDown = false;
};

</script>
{/block}
