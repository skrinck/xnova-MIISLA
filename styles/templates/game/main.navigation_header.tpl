<div class="fixed-top" align="center">
	<div id="main_header">
		<div class="main_list_left">
			<ul>
				<li><a href="game.php?page=changelog" style="color: lime; font-weight: bold;">V{$VERSION|replace:'.git':''}</a></li>
				<li><a href="game.php?page=overview"><i class="fas fa-home tooltip padding_navigation" data-tooltip-content="{$LNG.lm_overview}"></i></a></li>
				{if isModuleAvailable($smarty.const.MODULE_IMPERIUM)}<li><a href="game.php?page=imperium"><i class="fas fa-globe tooltip padding_navigation" data-tooltip-content="{$LNG.lm_empire}"></i></a></li>{/if}
				
				{if isModuleAvailable($smarty.const.MODULE_STATISTICS)}<li><a href="game.php?page=statistics"><i class="fas fa-chart-pie tooltip padding_navigation" data-tooltip-content="{$LNG.lm_statistics}"></i></a></li>{/if}
				
				{if isModuleAvailable($smarty.const.MODULE_BATTLEHALL)}<li><a href="game.php?page=battleHall"><i class="fas fa-crosshairs tooltip padding_navigation" data-tooltip-content="{$LNG.lm_topkb}"></i></a></li>{/if}
				
				{if isModuleAvailable($smarty.const.MODULE_RECORDS)}<li><a href="game.php?page=records"><i class="fas fa-chess-queen tooltip padding_navigation" data-tooltip-content="{$LNG.lm_records}"></i></a></li>{/if}
				
				{if isModuleAvailable($smarty.const.MODULE_SEARCH)}<li><a href="game.php?page=search"><i class="fas fa-search tooltip padding_navigation" data-tooltip-content="{$LNG.lm_search}"></i></a></li>{/if}
				
				 {if isModuleAvailable($smarty.const.MODULE_LOTTERY)}<li><a href="game.php?page=lottery"><i class="fas fa-money-bill-alt tooltip padding_navigation" data-tooltip-content="{$LNG.lm_lottery}"></i></a></li>{/if}
				
				<!--{if isModuleAvailable($smarty.const.MODULE_FLEET)}<li><a href="game.php?page=fleet"><i class="fas fa-search tooltip padding_navigation" data-tooltip-content="{$LNG.lm_fleet}"></i></a></li>{/if}-->

				<!--{if $bonus_time < TIMESTAMP}
					{if isModuleAvailable($smarty.const.MODULE_BONUS)}<li><a href="game.php?page=bonus"><i class="fas fa-gifts blinker tooltip padding_navigation" style="color:orange" data-tooltip-content="{$LNG.lm_bonus}"></i></a></li>{/if}
				{/if}-->
				
				<!--<li><a href="game.php?page=trophy"><i class="fas fa-trophy tooltip padding_navigation" data-tooltip-content="{$LNG.lm_trophy}"></i></a></li>-->

				<li><a href="game.php?page=top"><i class="fas fa-chart-bar tooltip padding_navigation" data-tooltip-content="{$LNG.lm_top}"></i></a></li>

				<!-- <li><a href="game.php?page=conteiner"><i class="fas fa-database tooltip padding_navigation" data-tooltip-content="{$LNG.lm_container}"></i></a></li> -->

				<li><a href="game.php?page=tourney"><i class="fas fa-dice tooltip padding_navigation" data-tooltip-content="{$LNG.lm_tourney}"></i></a></li>
				<li><a href="game.php?page=warOfAlliances"><i class="fas fa-trophy tooltip padding_navigation" data-tooltip-content="{$LNG.lm_warOfAlliances}"></i></a></li>
				<li><a href="game.php?page=achievement"><i class="fas fa-award tooltip padding_navigation" data-tooltip-content="{$LNG.lm_achievement}"></i></a></li>
				{if isModuleAvailable($smarty.const.MODULE_MESSAGES)}<li><a href="game.php?page=messages"><i class="fas fa-envelope tooltip padding_navigation" data-tooltip-content="{$LNG.lm_messages}"></i>{nocache}{if $new_message > 0}<span id="newmes"> <span id="newmesnum">{if $new_message > 99}99+{else}{$new_message}{/if}</span></span>{/if}{/nocache}</a></li>{/if}
				<li><a href="game.php?page=market"><i class="fas fa-shopping-cart tooltip padding_navigation" data-tooltip-content="{$LNG.lm_markets}"></i></a></li>
			</ul>
		</div>

		<a href="?cp={$previousPlanet}"><i class="fas fa-caret-left" style="font-size: 20px; margin: 5px; vertical-align: sub;"></i></a>
		<span id="planetSelectorWrapper">
	        <label for="planetSelector"></label>
			<select id="planetSelector">
				{html_options options=$PlanetSelect selected=$current_pid}
			</select>
		</span>
		<a href="?cp={$nextPlanet}" class="hidden-xs"><i class="fas fa-caret-right" style="font-size: 20px; margin: 5px; vertical-align: sub;"></i></a>

		<div class="main_list_right">
			<ul>
			<li><a href="?{$queryString}&chpb=1"><i class="fas {if $barplan }fa-eye-slash{else}fa-eye{/if} tooltip padding_navigation" data-tooltip-content="{if $barplan} {$LNG.lm_barPlanet_hide}{else}{$LNG.lm_barPlanet_show}{/if}"></i></a></li>
				{if isModuleAvailable($smarty.const.MODULE_TECHTREE)}<li><a href="game.php?page=techtree"><i class="fas fa-flask tooltip padding_navigation" data-tooltip-content="{$LNG.lm_technology}"></i></a></li>{/if}
				{if isModuleAvailable($smarty.const.MODULE_BUDDYLIST)}<li><a href="game.php?page=buddyList"><i class="fas fa-user-circle tooltip padding_navigation" data-tooltip-content="{$LNG.lm_buddylist}"></i></a></li>{/if}
				{if isModuleAvailable($smarty.const.MODULE_BANLIST)}<li><a href="game.php?page=banList"><i class="fas fa-user-times tooltip padding_navigation" data-tooltip-content="{$LNG.lm_banned}"></i></a></li>{/if}
				{if !empty($hasBoard)}<li><a href="game.php?page=board" target="forum"><i class="fas fa-comment-alt tooltip padding_navigation" data-tooltip-content="{$LNG.lm_forums}"></i></a></li>{/if}
				{if isModuleAvailable($smarty.const.MODULE_NOTICE)}<li><a href="javascript:OpenPopup('?page=notes', 'notes', 720, 300);"><i class="fas fa-edit tooltip padding_navigation" data-tooltip-content="{$LNG.lm_notes}"></i></a></li>{/if}
				<li><a href="game.php?page=rules"><i class="fas fa-book tooltip padding_navigation" data-tooltip-content="{$LNG.lm_rules}"></i></a></li>
				<li><a href="game.php?page=questions"><i class="fas fa-question-circle tooltip padding_navigation" data-tooltip-content="{$LNG.lm_faq}"></i></a></li>
				<li><a href="game.php?page=settings"><i class="fas fa-wrench tooltip padding_navigation" data-tooltip-content="{$LNG.lm_options}"></i></a></li>
				<li><a href="https://www.facebook.com/XnoVa_Desconocido-100559094821819/" target="_blank"><i class="fab fa-facebook-f tooltip padding_navigation" data-tooltip-content="Página en Facebook"></i></a></li>
				<li><a href="https://t.me/Moon_Darkv2_6" target="_blank"><i class="fab fa-telegram-plane tooltip padding_navigation" data-tooltip-content="Grupo en Telegram"></i></a></li>
				<li><a href="https://www.youtube.com/channel/UCuZTslT-CBFF6XtD2wDha9w" target="_blank"><i class="fab fa-youtube tooltip padding_navigation" data-tooltip-content="Youtube"></i></a></li>
				<li><a href="game.php?page=logout" style="color: red;"><i class="fas fa-power-off tooltip padding_navigation" data-tooltip-content="{$LNG.lm_logout}"></i></a></li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
	<div id="header" {if $barplan ==0 }style="height: 40px;{/if}">

		<div id="res_nav">
            {foreach $resourceTable as $resourceID => $resouceData} 
                {if !isset($resouceData.current)}
                    {$resouceData.current = $resouceData.max + $resouceData.used}
                    <div id="res_block_{$resouceData.name}" class="bloc_res tooltip" data-tooltip-content="<span class='colore{$resourceID}'>{$LNG.tech.$resourceID}</span><div style='border-bottom:1px dashed #666; margin:7px 0 4px 0;'></div>{$LNG.RE} {$resouceData.percent|number}%">
                        <div class="ico_res"></div>
                        <div class="stock_res">
                            <div class="stock_percentage stock_percentage_left" style="width:{abs($resouceData.percent/2)}%;{if $resouceData.percent > -0.1}display:none;{/if}"></div>
                            <div class="stock_percentage stock_percentage_right" style="width:{$resouceData.percent/2}%;{if $resouceData.percent < 0.1}display:none;{/if}"></div>
                            <div class="separator_{$resouceData.name}"></div>
                            <div class="stock_text"><span id="current_{$resouceData.name}" name="{$resouceData.current|number}" data-real="{$resouceData.current}">{$resouceData.used|shortly_number}</span>/{$resouceData.max|shortly_number}</div>
                        </div>
                    </div>
                {else}
                    {if !isset($resouceData.current) || !isset($resouceData.max)}
                        <div id="res_block_{$resouceData.name}" class="bloc_res tooltip" data-tooltip-content="<span class='colore{$resourceID}'>{$LNG.tech.$resourceID}</span><div style='border-bottom:1px dashed #666; margin:7px 0 4px 0;'></div>{$LNG.RE} {pretty_number($resouceData.current)}">
                            {if isModuleAvailable($smarty.const.MODULE_FAIR)}
                            <a href="game.php?page=fair"><div class="ico_res"></div></a>
                            {else}
                            <div class="ico_res"></div>
                            {/if}
                            <div class="stock_res2">
                                <div class="stock_percentage" style="width:100%;"></div>
                                <div class="separator_{$resouceData.name}"></div>
                                <div class="stock_text"><span class='colore{$resourceID}' id="current_{$resouceData.name}" name="{$resouceData.current|number}" data-real="{$resouceData.current}">{shortly_number($resouceData.current)}</span></div>
                            </div>
                        </div>
                    {else}
                        <div id="res_block_{$resouceData.name}" class="bloc_res tooltip" 
                            data-tooltip-content="
                            <span class='colore{$resourceID}'>{$LNG.tech.$resourceID}</span>
                            <div style='border-bottom:1px dashed #666; margin:7px 0 4px 0;'></div>
                            {$LNG.PPS}: {$resouceData.information}
                            <br/>{$LNG.PPD}: {$resouceData.informationd}
                            <br/>{$LNG.PPW}: {$resouceData.informationz} 
                            <div style='border-bottom:1px dashed #666; margin:7px 0 4px 0;'>
                            </div> <span style='color:#999'>{$resouceData.current|number}/{$resouceData.max|number}</span>">
                            {if isModuleAvailable($smarty.const.MODULE_TRADER)}
                            <a href="game.php?page=trader"><div class="ico_res"></div></a>
                            {else}
                            <div class="ico_res"></div>
                            {/if}
                            {*<a href="game.php?page=trader&amp;mode=trade&amp;resource=901" class="exchange_res tooltip" data-tooltip-content="Обменять <span class='colore{$resourceID}'>{$LNG.tech.$resourceID}</span>"></a>*}
							<div class="stock_res">
                                <div class="stock_percentage" style="width:{$resouceData.percent}%;"></div>
                                <div class="stock_text">
                                    <span id="current_{$resouceData.name}" name="{$resouceData.current|number}" data-real="{$resouceData.current}">{shortly_number($resouceData.current)}</span>
                                </div>
                            </div>
                        </div>
                    {/if}
                {/if}
            {/foreach}       
        </div>
		<div class="clearfix"></div>
		{if $barplan }
			<div class="list-planets" style="overflow: auto;">
			<div>Planetas <span>{$currentPlanetCountTable} /{$maxPlanetCount}</span><br><br></div>
				{foreach $sider as $currentPlanet}
					<div class="planeta {if $current_pid==$currentPlanet.id} actual {/if}">
						<a href="?{$queryString}&cp={$currentPlanet.id}" title="{$currentPlanet.name}-{$currentPlanet.coord}">
						<img src="{$dpath}planeten/small/s_{$currentPlanet.image}.png">
						<p>
							<span style="white-space:nowrap;">{$currentPlanet.name}</span><br>
							{$currentPlanet.coord}
						</p>
						</a>
					</div>
				{/foreach}
			</div>
		{/if}
</div>
		<div class="clear"></div>

			{if !$vmode}
			<script type="text/javascript">
			var viewShortlyNumber	= {$shortlyNumber|json};
			var vacation			= {$vmode};
	        $(function() {
			{foreach $resourceTable as $resourceID => $resourceData}
			{if isset($resourceData.production)}
	            resourceTicker({
	                available: {$resourceData.current|json},
	                limit: [0, {$resourceData.max|json}],
	                production: {$resourceData.production|json},
	                valueElem: "current_{$resourceData.name}",
	                valuePoursent: "bar_{$resourceID}"
	            }, true);
			{/if}
			{/foreach}
	        });
			</script>
	        <script src="scripts/game/topnav.js"></script>
	        {if $hasGate}<script src="scripts/game/gate.js"></script>{/if}
			{/if}
	</div>

