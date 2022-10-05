{block name="title" prepend}{$LNG.lm_safe}{/block}
{block name="content"}
<div id="achivment" class="container">
    <div class="ach_main_block">
    
        <div class="ach_head">
            <div class="ach_head_p">{$LNG.lv_coords} {$savedData}/{$maxsaved}</div><!--/ach_head_p-->
            <div class="pull-right">
                <a href="?page=galaxy" class="btn btn-dark btn-xs" style="padding: 5px 6px 5px 6px">{$LNG.lm_galaxy}</a>
            </div><!--/ach_head_right-->
        </div><!--/ach_head-->

        <div id="send_zond">
            <table>
            <tr style="display: none;" id="fleetstatusrow">
            </tr>
            </table>
        </div><!--/send_zond-->

        <div id="galactic_block_1" class="ach_main_content">
            <div id="galactic_status">
                <div class="gal_p5">{$LNG.gl_pos}</div>
                <div class="status_sep"></div>
                <div class="gal_p6">{$LNG.gl_planet}</div>
                <div class="status_sep"></div>
                <div class="gal_p7">{$LNG.gl_moon}</div>
                <div class="status_sep"></div>
                <div class="gal_p8">{$LNG.gl_debris}</div>
                <div class="status_sep"></div>
                <div class="gal_p9">{$LNG.gl_name_activity}</div>
                <div class="status_sep"></div>
                <div class="gal_p10">{$LNG.gl_alliance}</div>
                <div class="status_sep"></div>
                <div class="gal_p11">{$LNG.gl_actions}</div>
            </div><!--/galactic_status-->
            {foreach $savedArray as $ID => $Data}
            <div class="gal_user ">   
                <div class="gal_number">
                    <a href="game.php?page=fleetTable&amp;galaxy={$Data.galaxy}&amp;system={$Data.system}&amp;planet={$Data.planet}&amp;planettype=1">
                    
                    <span class="galactic_number_{$Data.planet}">{$Data@iteration}</span></a>
                </div>
                <span id="p_1" class="gal_img_planet">
                    <img src="{$dpath}planeten/small/s_{$Data.image}.png" alt="">
                </span>
                <div class="gal_planet_name">{$Data.name}</div>
                <div class="gal_ico_moon">
                    {if $Data.hasMoon}
                        <div class="ico_moon"></div>
                    {/if}
                </div>
                <div class="gal_ico_trash">
                    {if $Data.debris}
                        <div class="ico_trash_{if $Data.debris > 225000000000 }big{elseif $Data.debris < 225000000000 && $Data.debris > 7500000000}medium{elseif $Data.debris < 7500000000}small{/if} tooltip_sticky" data-tooltip-content="
                        <table class='tooltip_class_table'>
                            <tr>
                                <th>{$LNG.gl_debris_field} [{$Data.galaxy}:{$Data.system}:{$Data.planet}]</th>
                            </tr>
                            <tr>
                                <td class='tooltip_class_table_text_left'>
                                    <span>{$LNG.tech.901}</span>: <span class='tooltip_class_901'>{$Data.debrisM|number}</span><br />
                                    <span>{$LNG.tech.902}</span>: <span class='tooltip_class_902'>{$Data.debrisC|number}</span>
                                </td>
                            </tr>
                        </table>">
                        </div>
                    {/if}
                </div>
                <div class="gal_player_name">
                    <a style="color:#5ca6aa">
                        <span class=""><span class="honorRank" style="opacity: 0;">&nbsp;</span>{$Data.username}</span>
                    </a>
                </div>
                <div class="gal_ally_name">
                    <a style="color:#5ca6aa">
                        <span class="blue">{$Data.allyname}</span>
                    </a>
                </div>
                <div class="gal_player_cont">
                    <a href="javascript:Spy(6,{$Data.planetId},{$Data.planet},{$Data.system},{$spyShips|json|escape:'html'})" class="tooltip" data-tooltip-content="{$LNG.gl_spy}">
                        <i class="far fa-eye" style="font-size: 15px;"></i>
                    </a>
                    <a href="#" onclick="return Dialog.PM({$Data.userid})" class="tooltip" data-tooltip-content="{$LNG.write_message}">
                        <i class="far fa-envelope" style="font-size: 15px;"></i>
                    </a>  
                    <a href="#" onclick="return Dialog.Buddy({$Data.userid})" class="tooltip" data-tooltip-content="{$LNG.gl_buddy_request}">
                        <i class="far fa-handshake" style="font-size: 15px;"></i>
                    </a>
                    <a href="#" class="ico_del shover tooltip" data-gal="{$Data.galaxy}" data-sys="{$Data.system}" data-pl="{$Data.planet}" data-id="{$ID}" data-tooltip-content="{$LNG.gl_del_coord}">
                        <i class="far fa-save text-danger" style="font-size: 15px;"></i>
                    </a>              
                </div>


            </div>
            {/foreach}

        </div>
    </div>
</div>
<script type="text/javascript">
    status_ok       = 'Done';
    status_fail     = 'Error';
    MaxFleetSetting = 3;
</script>  
	
{/block}
