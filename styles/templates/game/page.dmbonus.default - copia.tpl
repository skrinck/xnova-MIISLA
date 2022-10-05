{block name="title" prepend}{$LNG.lm_dmbonus}{/block}
{block name="content"}
<div id="ally_content" class="conteiner container" >
    <div class="gray_stripe" style="padding-right:0;">
       {$LNG.lm_dmbonus} 
       <div class="ach_head_right">
            {$LNG.achiev_2}: <span>{$achievement_point_used|number} / {$achievement_points|number}</span>
            <i class="fas fa-star"></i>
       </div><!--/ach_head_right-->              
    </div> 
	<div id="gubernators_elements" class="gob_elements" style="padding-top:10px; padding-bottom:5px;">    	
            {foreach $darkmatterList as $ID => $Element}
                <div id="ofic_{$ID}" class="build_box">
            <div class="head">
                {$LNG.tech.{$ID}} <span>[{$Element.level}/{$Element.maxLevel}] {if $Element.level> 0}<a href="game.php?page=DMBonus&mode=resetgouvernor&id={$ID}" class="tooltip go_reset_tree" data-tooltip-content="{$LNG.go_rpts}">⇓</a>{/if}
				<span class="pull-right">{if $Element.timeLeft > 0}<span class="text-warning" style="font-weight: bold;" id="time_{$ID}">-</span> <a href="game.php?page=DMBonus&mode=resetgouvernortime&id={$ID}" class="tooltip go_reset_tree" data-tooltip-content="{$LNG.go_reset}">⇓</a>{/if}</span>
            </div>
            <div class="content_box">
                <div class="image">
                       <img src="{$dpath}gebaeude/{$ID}.png" alt="{$LNG.tech.{$ID}}">
                    </div>
                    <div class="prices">
                        <br>
						{foreach $Element.elementBonus as $BonusName => $Bonus}
                        <p>
                            <span style="color:#393;">
                                {if $Bonus[0] < 0}-{else}+{/if}<span id="{if $Bonus@iteration === 1}{$Element.gouvernorName}{$ID}{else}{$Element.gouvernorName2}{$ID}{/if}">{if $Bonus[1] == 0}{abs($Bonus[0] * 100)}{else}{$Bonus[0]}{/if}</span>%
                            </span> 
                             {$LNG.bonus.$BonusName}

                        </p>{/foreach}
                    </div>
                    <div class="clear"></div>
                	<div class="left_part">                    
                    <form action="game.php?page=DMBonus" method="post" class="build_form">
	                    <div class="time_build">
	                        {$LNG.tech.921}: 
	                        <b><span id="price{$ID}" style="color:{if {$Element.maxPrice} < $darkmatter}#6C6{else}#F33{/if}">{$Element.maxPrice|number}</span></b>
	                    </div>
                    	<div class="clear"></div>
                                
						{if $Element.maxPrice < $darkmatter}	
	                        <input name="id" value="{$ID}" type="hidden" /> 
                            <input style="padding:8px;" type="button" value="Días:" />    
	                        <input id="days{$ID}" class="gob_btn_build" name="days"  max="365" min="1" value="1" type="number" onchange="GubPrice('{$ID}', {$Element.maxPrice});" />
							<input class="gob_build" type="submit" value="{$LNG.go_build}" />      
                        {else}
							<div class="btn_build_border">
	                        	<span class="btn_build red">{$LNG.go_notbuild}</span>
	                    	</div>							
                      	{/if}         
                    </form>
                    <div class="clear"></div>
                </div>
                <div class="right_part">
                    <form action="game.php?page=DMBonus" method="post" class="build_form">
	                    <div class="time_build">
	                        {$LNG.achiev_2}: 
	                        <b><span id="price_point{$ID}" style="color:#09C">{$Element.maxAP}</span></b>                         
	                    </div>
	                    <div class="clear"></div>
						
						{if $Element.maxLevel <= $Element.level}
							<div class="btn_build_border">
	                	                        <span class="btn_build red">
	                        	{$LNG.bd_maxlevel}
	                        </span>
						                </div>
							{elseif $achievement_points < $Element.maxAP}	
							<div class="btn_build_border">
								<span class="btn_build red">{$LNG.go_pts}</span>
							</div>
						{else}
	                    <div class="btn_build_border">
	                        <input name="lvl_id" value="{$ID}" type="hidden"> 
	                        <input id="uplvl{$ID}" class="gob_btn_up" name="lvl_count" max="{$Element.maxLevel}" min="{$Element.level + 1}" value="{$Element.level + 1}" type="number" onchange="GubPriceAP('{$ID}', {$Element.level}, '{$Element.elementName}' );" />
							<input class="gob_up" type="submit" value="{$LNG.go_up_build}" />                	 	
                        </div>
						{/if}   
                    </form>
                    <div class="clear"></div>
                </div>
                                <div class="clear"></div>
            </div>
			
            <div class="clear"></div>
        </div>
		{/foreach}
            </div>
			
</div>

<script type="text/javascript">
	{literal}
		var GOVERNORS = {"dm_attack":{"MaxLevel":65,"priceAP":[50,1.07],"priceDM":[40000,1.1],"bonus":{"Attack":{"default":0.1,"bonuslevel":0.01,"divider":1,"factor":100}}},"dm_defensive":{"MaxLevel":65,"priceAP":[50,1.075],"priceDM":[40000,1.1],"bonus":{"Defensive":{"default":0.1,"bonuslevel":0.01,"divider":1,"factor":100},"Shield":{"default":0.1,"bonuslevel":0.01,"divider":1,"factor":100}}},"dm_buildtime":{"MaxLevel":50,"priceAP":[20,1.1],"priceDM":[7500,1.08],"bonus":{"BuildTimeFall":{"default":0.1,"bonuslevel":0.01,"divider":1,"factor":100},"GueueBuild":{"default":0,"bonuslevel":1,"divider":25,"factor":1}}},"dm_resource":{"MaxLevel":250,"priceAP":[100,1.01],"priceDM":[30000,1.022],"bonus":{"Resource":{"default":0.1,"bonuslevel":0.01,"divider":1,"factor":100},"ResourceGeneral":{"default":0,"bonuslevel":1,"divider":25,"factor":1}}},"dm_energie":{"MaxLevel":100,"priceAP":[50,1.022],"priceDM":[10000,1.055],"bonus":{"Energy":{"default":0.1,"bonuslevel":0.01,"divider":1,"factor":100},"EnergyGeneral":{"default":0,"bonuslevel":1,"divider":25,"factor":1}}},"dm_researchtime":{"MaxLevel":40,"priceAP":[100,1.12],"priceDM":[25000,1.14],"bonus":{"ResearchTimeFall":{"default":0.1,"bonuslevel":0.01,"divider":1,"factor":100},"GueueTech":{"default":0,"bonuslevel":1,"divider":20,"factor":1}}},"dm_fleettime":{"MaxLevel":40,"priceAP":[100,1.13],"priceDM":[50000,1.15],"bonus":{"FlyTime":{"default":0.1,"bonuslevel":0.01,"divider":1,"factor":100}}}};
	{/literal}
	var AllRep = {$achievement_points};
	var DMS = {$darkmatter};
</script>
            <div class="clear"></div>   
            </div>         
        </div><!--/body-->
{/block}
{block name="script"}
<script src="scripts/game/gubernators.js"></script>
{/block}