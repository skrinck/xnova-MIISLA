{block name="title" prepend}{$LNG.lm_tourney}{/block}
{block name="content"}
    <div id="achivment" class="container">
    <div class="ach_main_block">
    
        <div class="ach_head">
            <div class="ach_head_p">{$LNG.lm_tourney}</div><!--/ach_head_p-->
            <div class="pull-right">
                {if $tourneyEnd > 0}{$LNG.tourney_time}: <span>{$tourneyEnd|time}</span>{else}<span style="color:red;">{$LNG.tourney_end}.</span>{/if}
            </div><!--/ach_head_right-->
        </div><!--/ach_head-->

        <div class="ach_main_content">
                            
            <div class="ach_menu">
                <ul>
                                        <li{if $touneyGroup == 1} class="enable"{/if}>
                        <a href="game.php?page=tourney&amp;group=1">Alpha</a>
                    </li>
                                        <li{if $touneyGroup == 2} class="enable"{/if}>
                        <a href="game.php?page=tourney&amp;group=2">Beta</a>
                    </li>
                                        <li{if $touneyGroup == 3} class="enable"{/if}>
                        <a href="game.php?page=tourney&amp;group=3">Gamma</a>
                    </li>
                                        <li{if $touneyGroup == 4} class="enable"{/if}>
                        <a href="game.php?page=tourney&amp;group=4">Delta</a>
                    </li>
                                        <li{if $touneyGroup == 5} class="enable"{/if}>
                        <a href="game.php?page=tourney&amp;group=5">Epsilon</a>
                    </li>
                    <li >
                        <a >Arsenal Event <span class="text-danger">Desactivado</span></a>
                    </li>
                    
                                    </ul>  
            </div> 
            <div class="ach_content_box">
                <div style="float:left; width:100%;">
                               
              
                               
                <div id="ach_level" class="ach_content">
                    
                                       
                                        
                    <div class="ach_img" style="
    width: 100%;
    margin: auto;
    float: none;
">
                        <img alt="Peaceful" src="{$dpath}tourney/divisions/{$touneyGroup}.png">
                    </div>
                    <div class="ach_content_text" style="
    margin-left: 10px;
    margin-top: 20px;
">
                    
                        <div class="left_part" style="width: 33.3%;float: left;">
                 <div class="record_rows" style="padding: 0px">
                 
               <div class="record_img_utits" style="padding: 5px;">        
                    <img alt="" src="styles/theme/gow/premios/oro.png">
            </div>
           
                       <div class="record_name_utits" style="line-height: 40px;color: #a52d29;float: none;width: 135px;">{$tourneyDetail.priceOne|number} units<img src="{$dpath}img/resources/921f.png" style="
    height: 20px;
    width: 25px;
    border-radius: 5px;
    margin-left: 4px;
">

            </div>
                    
                     
                     
                        <div class="required_blocks">
                        
                                                        
                            </div>
                    </div>    </div>
<div class="left_part" style="width: 33.3%;float: left;">
                 <div class="record_rows" style="padding: 0px">
                 
               <div class="record_img_utits" style="padding: 5px;">        
                    <img alt="" src="styles/theme/gow/premios/plata.png">
            </div>
            <div class="record_name_utits" style="line-height: 40px;color: #a52d29;float: none;width: 135px;">{$tourneyDetail.priceTwo|number} units<img src="{$dpath}img/resources/921f.png" style="
    height: 20px;
    width: 25px;
    border-radius: 5px;
    margin-left: 4px;
">

            </div>
                        <div class="required_blocks">
                        
                                                        
                            </div>
                    </div>    </div>
<div class="left_part" style="width: 33.3%;float: left;">
                 <div class="record_rows" style="padding: 0px">
                 
               <div class="record_img_utits" style="padding: 5px;">        
                    <img alt="" src="styles/theme/gow/premios/bronce.png">
            </div>
            <div class="record_name_utits" style="line-height: 40px;color: #a52d29;float: none;width: 135px;">{$tourneyDetail.priceThree|number} units<img src="{$dpath}img/resources/921f.png" style="
    height: 20px;
    width: 25px;
    border-radius: 5px;
    margin-left: 4px;
">

            </div>
                        <div class="required_blocks">
                        
                                                        
                            </div>
                    </div>    </div>

                        
                        <div id="submit" style="width: 100%;float: left;margin-left: -10px;margin-bottom: -10px;margin-top:20px;">
            {if $tourneyCheck == 0}<form method="post">
            <input type="hidden" name="group" value="{$touneyGroup}">  
            <input value="{$LNG.tourney_btn}" class="btn btn-primary btn-xs" type="submit" style="width: 104%;">  
            </form>{/if}
    </div>
                                            </div> <!--/ach_content_text-->     
                    <div class="clear"></div>               
                </div> <!--/ach_content-->
                  <div id="ach_batle_level" class="ach_content" style="
    padding: 8px;
">{$tourneyDescrip}

   </div>           
                <div id="ach_batle_level" class="ach_content" style="
    padding-bottom: 4px;
">
                    
                    
                                        
        <div id="ally_content" class="conteiner" style="width: 100%;background: none;border: none;">
            <table class="tablesorter ally_ranks" style="margin-bottom: 3px;margin-top: 2px;width: 500px;">
                <tbody>
                    <tr>
                        <td style="width: 15%;text-align: center;color: #5ca6aa;background: #091d2e;border-color: #091d2e;">{$LNG.tourney_pos}</td>
                        <td style="width: 35%;text-align: center;color: #5ca6aa;background: #091d2e;border-color: #091d2e;">{$LNG.tourney_name}</td>
                        <td style="width: 50%;text-align: center;color: #5ca6aa;background: #091d2e;border-color: #091d2e;">{$LNG.tourney_pts}</td>                        
                    </tr>
                </tbody>
            </table>
            {foreach $playerList as $ID => $Player}
                <a target="#" class="ticket_row_linck text-center">
                    <span class="ticket_row_linck_id" style="width:10%;text-align: center;border-right:none">#{$Player@iteration}</span>
                    <span class="ticket_row_linck_subject" style="width:39%; text-align: center;color:#a9a9a9;">{$Player.playerName}</span>
                    <span class="ticket_row_linck_status" style="width:45%; text-align: center;color:#a9a9a9;">{$Player.tourneyUnits|number}</span>
                    <span class="clear"></span>
                </a>
            {foreachelse}
                <a target="#" class="ticket_row_linck text-center">{$LNG.tourney_noplayers}</a>
            {/foreach}       
        </div>
            </div> <!--/ach_content_text-->     
                    <div class="clear"></div>               
                </div>
                                            </div> <!--/ach_content_text-->     
                    <div class="clear"></div>               
                </div> <!--/ach_content-->
                                </div>   
                <div style="padding-top:7px;"></div>
                <div class="clear"></div>   
                            
            </div>
                       
             <!--/ach_content_box-->
            
        </div><!--/ach_main_content-->
        
    </div><!--/ach_main_block-->
</div><!--/achivment-->    
</div>
</div>
            <div class="clear"></div>   
            </div>         
        </div><!--/body-->
{/block}
