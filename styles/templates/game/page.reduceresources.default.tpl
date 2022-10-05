{block name="title" prepend}{$LNG.lm_red_resources}{/block}
{block name="content"}
<div id="achivment" class="container">
    <div class="ach_main_block">
    
        <div style="overflow:hidden; position:absolute; width:0; height:0;">
            <form action="game.php?page=reduceresources&amp;mode=reduce" method="post" id="form">
                <input name="tokens" value="tokens" type="hidden">
                <table class="tablesorter ally_ranks">
                    <tbody>
                        <tr style="height:20px;">
                            <td colspan="5">
                                <input value="{$LNG.reduce_res_1}" type="submit">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <form action="game.php?page=reduceresources&amp;mode=reduce" method="post" id="form">
        <div class="ach_head">
            <div class="ach_head_p">{$LNG.reduce_res_2}</div><!--/ach_head_p-->
            <div class="pull-right">
                <span class="all_true" style="color:#6C9; cursor:pointer;" onclick="planet_select_all();">{$LNG.reduce_res_3}</span> |
                <span class="all_false" style="color:#F96; cursor:pointer;" onclick="planet_reset_all();">{$LNG.reduce_res_4}</span>
            </div><!--/ach_head_right-->
        </div><!--/ach_head-->

        {if $planetsResult == 0}
            <div class="ally_contents">{$LNG.reduce_res_6}</div>
            {else}
            
                {foreach $PlanetListin as $ID => $Element}  
                    <div id="prow_{$ID}" class="rd_planet_row {if $Element.ev_transporter > 0}rd_planet_row_select{/if}" {if $Element.ev_transporter > 0}onclick="planet_select({$ID});"{/if}>
                    {if $Element.ev_transporter > 0}<input class="rd_checkbox" id="p{$ID}" name="palanets[]" value="{$ID}" type="checkbox">{/if}
                        <div class="rd_planet_img">
                            <img title="{$Element.name} [{$Element.galaxy}:{$Element.system}:{$Element.planet}]" src="{$dpath}planeten/small/s_{$Element.image}.png" alt="" width="48" height="48">
                        </div>
                    <div class="rd_planet_data_name">
                        <span style="color:#CC6;">{$Element.name}</span><br>            
                        <span style="color:#CCC;">[{$Element.galaxy}:{$Element.system}:{$Element.planet}]</span><br>
                        {if $Element.ev_transporter > 0}<span style="color:#09F;">{$LNG.reduce_res_8}: {$Element.duration} </span>{/if}
                    </div>
                    <div class="rd_planet_resours">        
                        <div class="imper_block_td">
                            <div class="occupancy occupancy_901" style="width:{min(100,$Element.metal*100/$Element.metal_max)}%"></div>
                            <div class="text_res tooltip" data-tooltip-content="<span class='p_res'>{$LNG.tech.901}</span> <span style='color:#999'>({$Element.name} [{$Element.galaxy}:{$Element.system}:{$Element.planet}])</span> <div style='border-bottom:1px dashed #666; margin:7px 0 4px 0;'></div> <span style='color:#999'>{$Element.metal|number} / {$Element.metal_max|number}</span>"><span>{$LNG.tech.901}:</span> {$Element.metal|number}</div>
                        </div>            
                        <div class="imper_block_td">
                            <div class="occupancy occupancy_902" style="width:{min(100,$Element.crystal*100/$Element.crystal_max)}%"></div>
                            <div class="text_res tooltip" data-tooltip-content="<span class='p_res'>{$LNG.tech.902}</span> <span style='color:#999'>({$Element.name} [{$Element.galaxy}:{$Element.system}:{$Element.planet}])</span> <div style='border-bottom:1px dashed #666; margin:7px 0 4px 0;'></div> <span style='color:#999'>{$Element.crystal|number} / {$Element.crystal_max|number}</span>"> <span>{$LNG.tech.902}:</span> {$Element.crystal|number}</div>
                        </div>         
                        <div class="imper_block_td">
                            <div class="occupancy occupancy_903" style="width:{min(100,$Element.deuterium*100/$Element.deuterium_max)}%"></div>
                            <div class="text_res tooltip" data-tooltip-content="<span class='p_res'>{$LNG.tech.903}</span> <span style='color:#999'>({$Element.name} [{$Element.galaxy}:{$Element.system}:{$Element.planet}])</span> <div style='border-bottom:1px dashed #666; margin:7px 0 4px 0;'></div> <span style='color:#999'>{$Element.deuterium|number} / {$Element.deuterium_max|number}</span>"><span>{$LNG.tech.903}:</span> {$Element.deuterium|number}</div>
                        </div>
                    </div>
                    <div class="rd_planet_status">
                         {if $Element.ev_transporter > 0}
                         {$LNG.tech.203}: {$Element.ev_transporter|number}<br>
                         Necessary: {$Element.ev_necesary|number}
                         {else}
                            <span style="color:#F30;">{$LNG.reduce_res_5}</span>{/if}<br>
                    </div>
                    <div class="clear"></div>
                </div>
            {/foreach}
                
                
            <div class="build_band ticket_bottom_band" style="padding-left:20px;">      
                <input class="bottom_band_submit" value="{$LNG.reduce_res_1}" type="submit">
            </div>
        {/if}

        </form>
    </div><!--/ach_main_block-->
</div><!--/container-->
{/block}
