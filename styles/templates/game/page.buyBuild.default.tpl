{block name="title" prepend}{$LNG.lm_buybuild}{/block}
{block name="content"}
<div id="ally_content" class="conteiner">
    <div class="gray_stripe text-center">
        {$LNG.lm_buybuild}  
    </div>
    <form action="game.php?page=buyBuild" method="post">
        <input type="hidden" name="mode" value="send">
        <input type="hidden" id="Element" name="Element" value="">
        <div class="tablesorter ally_ranks">
            <div class="pull-left">
                <img class="buyres" style="width:150px; height:150px" id="img" alt="" data-src="{$dpath}gebaeude/" src="{$dpath}gebaeude/undefined.gif"/>
                <span class="designation_buy">
                    <span id="traderHead">Sin Especificar</span><br/>
                </span>
            </div>
            <div class="text-center gray_stripe_th" style="padding-top: 20px">
                <table>
                    <tr>
                        <td>
                            {$LNG.bd_lvl_up}: <input min="0" type="number" onchange="Total();" type="text" id="count" name="count" onkeyup="Total();">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {$LNG.bd_the_initial_cost} {$LNG.tech.921}: <span id="price" class="text-warning" style="font-weight:bold;"></span>          
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {$LNG.bd_total} {$LNG.tech.921}: <span id="total_price_factor" class="text-danger" style="font-weight:bold;"></span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="clear"></div>
        <div class="gray_stripe text-center">
            <input style="display:none;" id="batn" type="submit" value="{$LNG.bd_buy}" class="btn btn-dark btn-xs"> 
        </div>
        <div >
            {foreach $Elements as $Element}
                <img class="buyres element tooltip" onclick="updateVars({$Element})" src="{$dpath}gebaeude/{$Element}.gif" alt="{$LNG.tech.$Element}" data-tooltip-content="{$LNG.tech.{$Element}}" />
                {/foreach}
        </div>
    </form>
</div>
{/block}
{block name="script" append}
<script type="text/javascript">
   var CostInfo = {$CostInfos|json};
</script>
{/block}
