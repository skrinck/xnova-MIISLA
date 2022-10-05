{block name="title" prepend}{$LNG.lm_topkb}{/block}
{block name="content"}
<script charset="UTF-8" type="text/javascript" src="scripts/game/comments.js"></script>
<script type="text/javascript">
    var hofComment_5    = "{$LNG.hofComment_5}";
    var hofComment_6    = "{$LNG.hofComment_6}";
	$(document).ready(function(){
		$('.batle_scan').click(function(){ 
			$(this).toggleClass('batle_scan_active');
			$(this).parent().parent().find(".batle_mem_content").stop(true, false).slideToggle(300);
		});		
	});
	function RoundScan(idSelect)
	{
		$(String(idSelect)).find(".batle_scan").stop(true, false).toggleClass('batle_scan_active');
		$(String(idSelect)).find(".batle_mem_content").stop(true, false).slideToggle(300);
	};
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
</script>
<div id="content_battle">
    {if isset($Info)}	
	<div id="batle_top_nav">
        <div style="float:left; width:378px;" class="batle_party">
            <table>
                <tbody>
                    <tr>
                    <td style="text-align: right;font-size: 20px;font-weight: bold;padding:0px 0 25px;color:{if $Raport.result == 'a'}lime{elseif $Raport.result == 'r'}red{else}white{/if}"><img alt="attacker" title="attacker" src="{$dpath}img/battle/att.png"> {$Info.0}</td>
                    </tr>
                </tr>
                </tbody>
            </table>
        </div>
        <div style="float:right" class="batle_party">
            <table>
                <tbody>
                    <tr>
                    <td style="text-align: left;font-size: 20px;font-weight: bold;padding:0px 0 25px;color:{if $Raport.result == 'r'}lime{elseif $Raport.result == 'a'}red{else}white{/if}"><img alt="defender" title="defender" src="{$dpath}img/battle/def.png"> {$Info.1}</td>
                    </tr>
                </tbody>
            </table>
        </div>                    
        <div id="batle_vs">
            {$Raport.time}
        </div>
    </div>
    {/if}
    <div id="raports">
        {foreach $Raport.rounds as $Round => $RoundInfo}
        <div class="batle_round" id="round_{$Round}">
            <div class="batle_part_att">
                {foreach $RoundInfo.attacker as $Player}
                {$PlayerInfo = $Raport.players[$Player.userID]}   		        
                <div class="batle_mem {if $RoundInfo@last}{if $Raport.result == 'r'}batle_mem batle_mem_die{else}batle_mem{/if}{/if}">
                    <div class="batle_mem_header">
			<span style="float: left;padding-right: 10px"> <div class="images-yamil"><img src="media/avatars/default.jpg" alt="" width="60px" height="60px" class="tooltip" data-tooltip-content="{$PlayerInfo.name}"></div></span>
                        <span>{$PlayerInfo.name}</span> 
                        {if isset($Info)}([XX:XX:XX]){else}([{$PlayerInfo.koords[0]}:{$PlayerInfo.koords[1]}:{$PlayerInfo.koords[2]}]{if isset($PlayerInfo.koords[3])}{/if}){/if}<br>
				        {$LNG.sys_ship_weapon} <span>+{$PlayerInfo.tech[0]}%</span> •
                        {$LNG.sys_ship_shield} <span>+{$PlayerInfo.tech[1]}%</span> • 
                        {$LNG.sys_ship_armour} <span>+{$PlayerInfo.tech[2]}%</span> </b>
                        <div class="batle_scan {if $RoundInfo@last}batle_scan_active{/if}"></div>
                    </div>
                    <div class="batle_mem_content" {if $RoundInfo@last}style="display:block;"{/if}>
						{foreach $Player.ships as $ShipID => $ShipData}	
   		    	        <div class="batle_unit">
                            <div class="img_unit tooltip" style="cursor:help !important" data-tooltip-content="
                                <table>
                                    <tr>
                                        <td style='color:#FC0; text-align:right !important;'>{$LNG.sys_ship_weapon}:</td>
                                        <td style='text-align:right !important;'><span >{$ShipData[1]|number}</span></td>
                                    </tr>
                                    <tr>
                                        <td style='color:#FC0; text-align:right !important;'>{$LNG.sys_ship_shield}:</td>
                                        <td style='text-align:right !important;'><span >{$ShipData[3]|number}</span></td>
                                    </tr>
                                    <tr>
                                        <td style='color:#FC0; text-align:right !important;'>{$LNG.sys_ship_armour}:</td>
                                        <td style='text-align:right !important;'>{$ShipData[2]|number}</td>
                                    </tr>
                                </table>
                            ">
                                <img alt="" title="" src="{$dpath}gebaeude/{$ShipID}.gif" width="60px" height="60px" />
                                
                            </div>
                            <span class="name_unit"><span {if $ShipID == 224 || $ShipID == 229 || $ShipID == 230}style="color:#32CD32"{/if}>{$LNG.shortNames.{$ShipID}}</span></span><br>
                    {if $RoundInfo@last && $ShipID > 400}<span style="color:#7ad96a;">{$ShipData[0]|number}</span>{else}{$ShipData[0]|number}{/if}<br>
                    <span class="destruct_unit">
                                                    {if !$RoundInfo@last} {if $ShipData[4] != 0}-{/if}{($ShipData[4])|number} {/if}                                         </span>
                </div>
                        {/foreach}
               	        <div class="clear"></div>
                    </div>  
                </div>
                {/foreach}      		        
            </div>
            <div class="batle_part_def">
                {foreach $RoundInfo.defender as $Player}
                {$PlayerInfo = $Raport.players[$Player.userID]}  		      
                <div class="batle_mem {if $RoundInfo@last}{if $Raport.result == 'a'}batle_mem batle_mem_die{else}batle_mem{/if}{/if}">
                    <div class="batle_mem_header">
			<span style="float: left;padding-right: 10px"> <div class="images-yamil"><img src="media/avatars/default.jpg" alt="" width="60px" height="60px" class="tooltip" data-tooltip-content="{$PlayerInfo.name}"></div></span>
                        <span>{$PlayerInfo.name}</span> 
                        {if isset($Info)}([XX:XX:XX]){else}([{$PlayerInfo.koords[0]}:{$PlayerInfo.koords[1]}:{$PlayerInfo.koords[2]}]{if isset($PlayerInfo.koords[3])}{/if}){/if}<br>
				        {$LNG.sys_ship_weapon} <span>+{$PlayerInfo.tech[0]}%</span> •
                        {$LNG.sys_ship_shield} <span>+{$PlayerInfo.tech[1]}%</span> • 
                        {$LNG.sys_ship_armour} <span>+{$PlayerInfo.tech[2]}%</span> 
                        <div class="batle_scan {if $RoundInfo@last}batle_scan_active{/if}"></div>          
                    </div>
                    <div class="batle_mem_content" {if $RoundInfo@last}style="display:block;"{/if}>
						{foreach $Player.ships as $ShipID => $ShipData}	
   		    	        <div class="batle_unit">
                            <div class="img_unit tooltip" style="cursor:help !important" data-tooltip-content="
                                <table>
                                    <tr>
                                        <td style='color:#FC0; text-align:right !important;'>{$LNG.sys_ship_weapon}:</td>
                                        <td style='text-align:right !important;'><span >{$ShipData[1]|number}</span></td>
                                    </tr>
                                    <tr>
                                        <td style='color:#FC0; text-align:right !important;'>{$LNG.sys_ship_shield}:</td>
                                        <td style='text-align:right !important;'><span >{$ShipData[3]|number}</span></td>
                                    </tr>
                                    <tr>
                                        <td style='color:#FC0; text-align:right !important;'>{$LNG.sys_ship_armour}:</td>
                                        <td style='text-align:right !important;'>{$ShipData[2]|number}</td>
                                    </tr>
                                </table>
                            ">
                                <img alt="" title="" src="{$dpath}gebaeude/{$ShipID}.gif" width="60px" height="60px" />
                                
                            </div>
                            <span class="name_unit"><span {if $ShipID == 224 || $ShipID == 229 || $ShipID == 230}style="color:#32CD32"{/if}>{$LNG.shortNames.{$ShipID}}</span></span><br>
                    {if $RoundInfo@last && $ShipID > 400}<img title="" class="tooltip" data-tooltip-content="Después de la Reparación" src="{$dpath}img/battle/report_tool.png" style="height: 11px;vertical-align: middle;margin-right: 3px;"/><span style="color:#7ad96a;" class="tooltip" data-tooltip-content="Después de la Reparación">{$ShipData[0]|number}</span>{else}{$ShipData[0]|number}{/if}<br>
                    <span class="destruct_unit">
                                                    {if !$RoundInfo@last} {if $ShipData[4] != 0}-{/if}{($ShipData[4])|number}     {/if}                                     </span>
                </div>
                        {/foreach}
                        <div class="clear"></div>
                    </div>
                </div>
                {/foreach}		
            </div>
            <div class="batle_part_sep">
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div><!--/round-->
        <div class="batle_round_info" onclick="RoundScan('#round_{$Round}');">
            <h2>{$Round}</h2>
            <h3>Round</h3>
        </div>
        {if !$RoundInfo@last}
        <div class="band_att tooltip" style="cursor:help !important" data-tooltip-content="{$LNG.fleet_attack_1} {$RoundInfo.info[0]|number} {$LNG.fleet_attack_2} {$RoundInfo.info[3]|number} {$LNG.damage}<br> {$LNG.fleet_defs_1} {$RoundInfo.info[2]|number} {$LNG.fleet_defs_2} {$RoundInfo.info[1]|number} {$LNG.damage}">
            <div class="ico_part">
                <img alt="" title="" src="{$dpath}img/battle/att.png" />
            </div>
            <div class="ico_part" style="left:auto; right:5px;">
                <img alt="" title="" src="{$dpath}img/battle/def.png" />
            </div>
            <div class="left_part_att" style="width:{if {({$RoundInfo.info[0]} +{$RoundInfo.info[2]})}>0}{(100*({$RoundInfo.info[0]}))/{({$RoundInfo.info[0]} +{$RoundInfo.info[2]})}}{else}nan{/if}%">
                <div class="bsorb" style="width:{if {({$RoundInfo.info[3]} +{$RoundInfo.info[1]})}>0}{(50*({$RoundInfo.info[3]}))/{({$RoundInfo.info[3]} +{$RoundInfo.info[1]})}}{else}nan{/if}%">
                    <div class="bsorb_end"></div>
                    <div class="bsorb_mid"></div>
                </div>    
            </div>
            <div class="left_part_def" style="width:{if {({$RoundInfo.info[0]} +{$RoundInfo.info[2]})}>0}{(100*({$RoundInfo.info[2]}))/{({$RoundInfo.info[0]} +{$RoundInfo.info[2]})}}{else}nan{/if}%">
                <div class="bsorb" style="width:{if {({$RoundInfo.info[3]} +{$RoundInfo.info[1]})}>0}{(50*({$RoundInfo.info[1]}))/{({$RoundInfo.info[3]} +{$RoundInfo.info[1]})}}{else}nan{/if}%">
                    <div class="bsorb_end"></div>
                    <div class="bsorb_mid"></div>
                </div> 
            </div>
        </div>
        {/if}
        {/foreach}
        <div class="batle_part_sep">
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div><!--/round-->
<!--ITOG-->
	<div class="batle_round_info" onclick="RoundScan('#round_2');">
        {if $Raport.result == "a"}
        <h2 style="color:#45a000">{$LNG.sys_attacker_won}</h2>
        {elseif $Raport.result == "r"}
        <h2>{$LNG.sys_defender_won}</h2>
        {else}
        <h2 style="color:#c77602">{$LNG.sys_both_won}</h2>
        {/if}
    </div>    
    <div class="band_itog tooltip" style="cursor:help !important" data-tooltip-content="
    	{$LNG.sys_attacker_lostunits} {$Raport['units'][0]|number} {$LNG.sys_units}<br>
        {$LNG.sys_defender_lostunits} {$Raport['units'][1]|number} {$LNG.sys_units}
    ">
        <div class="ico_part">
            <img alt="" title="" src="{$dpath}img/battle/att.png" />
        </div>
        <div class="ico_part" style="left:auto; right:5px;">
            <img alt="" title="" src="{$dpath}img/battle/def.png" />
        </div>
        <div class="left_part_att" style="width:{if {({$Raport['units'][0]} +{$Raport['units'][1]})}>0}{100/($Raport['units'][0]+$Raport['units'][1])*$Raport['units'][0]}{else}50{/if}%"></div>
        <div class="left_part_def" style="width:{if {({$Raport['units'][0]} +{$Raport['units'][1]})}>0}{100/($Raport['units'][0]+$Raport['units'][1])*$Raport['units'][1]}{else}50{/if}%"></div>
    </div>
    <div class="batle_text">    
        {if $Raport.result == "a"}
        {$LNG.sys_stealed_ressources} {foreach $Raport.steal as $elementID => $amount}{$amount|number} {$LNG.tech.$elementID}{if ($amount@index + 2) == count($Raport.steal)} {$LNG.sys_and} {elseif !$amount@last}, {/if}{/foreach}
        {elseif $Raport.result == "r"}
        {else}
        {/if}
        <br>
        {$LNG.debree_field_1} {foreach $Raport.debris as $elementID => $amount}{$amount|number} {$LNG.tech.$elementID}{if ($amount@index + 2) == count($Raport.debris)} {$LNG.sys_and} {elseif !$amount@last}, {/if}{/foreach} {$LNG.debree_field_2}<br>  
        {if $Raport.mode == 1}
        {* Destruction *}
        {if $Raport.moon.moonDestroySuccess == -1}
        {* Attack not win *}
        {$LNG.sys_destruc_stop}
        <br>
        {else}
        {* Attack win *}
        {sprintf($LNG.sys_destruc_lune, "{$Raport.moon.moonDestroyChance}")}<br>{$LNG.sys_destruc_mess1}
        {if $Raport.moon.moonDestroySuccess == 1}
        {* Destroy success *}
        {$LNG.sys_destruc_reussi}
        {elseif $Raport.moon.moonDestroySuccess == 0}
        {* Destroy failed *}
        {$LNG.sys_destruc_null}			
        {/if}
        <br>
        {sprintf($LNG.sys_destruc_rip, "{$Raport.moon.fleetDestroyChance}")}
        {if $Raport.moon.fleetDestroySuccess == 1}
        {* Fleet destroyed *}
        <br>
        {$LNG.sys_destruc_echec}
        {/if}			
        {/if}
        {else}
        {* Normal Attack *}
        {$LNG.sys_moonproba} {$Raport.moon.moonChance} %
        <br>
        {if !empty($Raport.moon.moonName)}
        {if isset($Info)}
        {* Moon created (HoF Mode) *}
        {sprintf($LNG.sys_moonbuilt, "{$Raport.moon.moonName}", "XX", "XX", "XX")}
        {else}
        {* Moon created *}
        {sprintf($LNG.sys_moonbuilt, "{$Raport.moon.moonName}", "{$Raport.koords[0]}", "{$Raport.koords[1]}", "{$Raport.koords[2]}")}
        {/if}
        {/if}
        {/if}
        {$Raport.additionalInfo}
        <br>
    </div>
</div>
</div>
</div>
<div class="clear"></div>            
</div>
{if $Raport.simulate == 0}
{if $Activo==0 && $comments ==0}
    <div class="comments-container">
        <ul id="comments-list" class="comments-list">
            <li>
                <div class="comment-main-level">
                    <!-- Avatar -->
                    <div class="comment-avatar"><img src="{$foto}" alt=""></div>
                    <!-- Contenedor del Comentario -->
                        <div class="comment-box">
                            <div class="comment-content">
                                <form id="form" method="post">
                                <!-- need to supply post id with hidden fild -->
                                    <input type="hidden" name="encoded_secret" value="{$encrypted_txt}">
                                    <label>
                                        <textarea name="comment" id="comment" cols="30" rows="5" placeholder="{$LNG.mg_empty_text}..." required style="background-color: #000111;"></textarea>
                                    </label>
                            </div>
                            <div class="comment-head barracorta">
                                <input type="submit" id="submit" value="{$LNG.mg_send}" class="pulsante">
                            </div>
                            </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    {else}
    <div class="alert alert-info text-center"><h2>Usted no tiene permitido comentar en las batallas</h2></div>{/if}
<div class="post">
</div>


<div class="comment-block">
</div>

<div class="comments-container">
    <ul id="comments-list" class="comments-list">
        {foreach $COMMENTDATA as $COMMENT}
        <li id="comm_{$COMMENT.commendId}">
            <div class="comment-main-level">
            <!-- Avatar -->
                <div class="comment-avatar"><img name="foto" title="" src="{$COMMENT.avatar}"  class="tooltip" data-tooltip-content="{$COMMENT.name}"></div>
                <!-- Contenedor del Comentario -->
                <div class="comment-box">
                    <div class="comment-head">
                        <h6 class="comment-name"><a href="#">{$COMMENT.name}</a> {if !empty($COMMENT.alliance)}<span class="alleanza">{$COMMENT.alliance}</span>{/if} {if $COMMENT.replyToComment != 0}replied to Odiabile{/if}</h6> 
                        <span >{$COMMENT.commentDate}</span> <span id="youFlagged_{$COMMENT.commendId}">{if !empty($COMMENT.alreadyFlagged)}  {$LNG.hofComment_6}{/if}</span>
                        {*<span class="immagine"><img src="{$dpath}img/iconav/report-reply.png" onclick="toggle_visibility('quick_reply');"></span>*}
                        {if $authlevel > 1}<span class="immagine"><img src="{$dpath}img/iconav/delmsg.png" class="tooltip delete" data-id="{$COMMENT.commendId}" data-tooltip-content="{$LNG.hofComment_3}"></span>{/if}
                    </div>
                    <div class="comment-content" id="content_{$COMMENT.commendId}">
                        {$COMMENT.comment} 
                    </div>

                    {*<div id="quick_reply_{$COMMENT.commendId}" style="display: none;">
                        <div class="comment-box">
                            <div class="comment-content">
                                <form id="form" method="post">
                                <!-- need to supply post id with hidden fild -->
                                <input type="hidden" name="encoded_secret" value="{$encrypted_txt}">
                                <label>
                                  <textarea name="comment" id="comment" cols="30" rows="5" placeholder="{$LNG.hofComment_1}..." required style="background-color: #000111;"></textarea>
                                </label>
                            </div>
                            <div class="comment-head barracorta">
                                <input type="submit" id="submit" value="{$LNG.hofComment_1}" class="pulsante">
                            </div>
                          </form>
                        </div>
                    </div>*}
                </div>
            </div>
        </li>
        {/foreach}
    </ul>

    {if $MessageCount > 0}
        <div class="message_page_navigation">
            {$LNG.mg_page}:
            {if $page != 1}
            <a href="?page=raport&mode=battleHall&raport={$RID}&site={$page - 1}">«</a>&nbsp;{/if}
            {for $site=1 to $maxPage}
                <a href="?page=raport&mode=battleHall&raport={$RID}&site={$site}" >
                        {if $site == $page}
                            <span class="active_page">[{$site}]</span>
                            {else}
                                [{$site}]
                        {/if}
                </a>
                {if $site != $maxPage}&nbsp;{/if}
            {/for}
            &nbsp;<a href="?page=raport&mode=battleHall&raport={$RID}&site={$page + 1}">»</a>
        </div>
    {/if}
{/if}





{/block}

