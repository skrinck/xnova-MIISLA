{block name="title" prepend}{$LNG.lm_buildings}{/block}
{block name="content"}
<div id="build_content" class="conteiner container" style="width: 98%">
	<div class="gray_stripe text-center">
		<span>{$LNG.lm_buildings}</span>
		{if isModuleAvailable($smarty.const.MODULE_BUILDING_BUY)}
			<a href="game.php?page=buyBuild" class="right_flank btn btn-dark btn-xs" style="padding:6px">{$LNG.lm_buybuild}</a>
	        {/if}
	</div>
	{if !empty($Queue)}
	<div id="buildlist" class="buildlist">
		<table style="width:100%;">
			{foreach $Queue as $List}
			{$ID = $List.element}
			<tr>
				<td style="width:70%;vertical-align:top;" class="left">
					{$List@iteration}.: 
					{if !($isBusy.research && ($ID == 6 || $ID == 31 || $ID == 45)) && !($isBusy.shipyard && ($ID == 15 || $ID == 21)) && !($isBusy.defense && ($ID == 15 || $ID == 21)) && $RoomIsOk && $CanBuildElement && $BuildInfoList[$ID].buyable}
					<form class="build_form" action="game.php?page=buildings" method="post">
						<input type="hidden" name="cmd" value="insert">
						<input type="hidden" name="building" value="{$ID}">
						<button type="submit" class="build_submit onlist">{$LNG.tech.{$ID}} {$List.level}{if $List.destroy} {$LNG.bd_dismantle}{/if}</button>
					</form>
					{else}{$LNG.tech.{$ID}} {$List.level} {if $List.destroy}{$LNG.bd_dismantle}{/if}{/if}
					{if $List@first}
					<br><br><div id="progressbar" data-time="{$List.resttime}"></div>
				</td>
				<td>
					<div id="time" data-time="{$List.time}"><br></div>
					<form action="game.php?page=buildings" method="post" class="build_form">
						<input type="hidden" name="cmd" value="fast">
						<button type="submit" class="build_submit onlist tooltip btn btn-dark btn-sm" data-tooltip-content="{$LNG.cost} : {if $need_dm<10}{10}{else}{($need_dm)}{/if} {$LNG.dm}" style="color: red"><i class="fa fa-fast-forward" aria-hidden="true"></i> {$LNG.acceleration}</button>
					</form>
					<form action="game.php?page=buildings" method="post" class="build_form">
						<input type="hidden" name="cmd" value="cancel">
						<button type="submit" class="build_submit onlist btn btn-dark btn-sm">{$LNG.bd_cancel}</button>
					</form>
					{else}
				</td>
				<td>
					<form action="game.php?page=buildings" method="post" class="build_form">
						<input type="hidden" name="cmd" value="remove">
						<input type="hidden" name="listid" value="{$List@iteration}">
						<button type="submit" class="build_submit onlist">{$LNG.bd_cancel}</button>
					</form>
					{/if}
					<br><span style="color:lime" data-time="{$List.endtime}" class="timer">{$List.display}</span><br>
				</td>
			</tr>
		{/foreach}
		</table>
	</div>
	{/if}
	<div id="building_elements" class="build_list">
		 {foreach $BuildInfoList as $ID => $Element}
			<div class="build_box">
				<div class="head">
					<a href="#" onclick="return Dialog.info({$ID})">{$LNG.tech.{$ID}}</a> {if $Element.level > 0}[{$Element.level}/{$Element.maxLevel}]{/if}
						{if $Element.level > 0}
							{if $ID == 43}<a href="#" onclick="return Dialog.info({$ID})">{$LNG.bd_jump_gate_action}</a>{/if}
							{if ($ID == 44 && !$HaveMissiles) ||  $ID != 44}{* Start Destruction Popup *}<a class="tooltip" data-tooltip-content="<table style='width:300px'>
								<tr class='title text-center'>{$LNG.bd_dismantle}</tr>
									<tr>
										<th colspan='2'>{$LNG.bd_price_for_destroy} {$LNG.tech.{$ID}} {$Element.level}</th>
									</tr>
									{foreach $Element.destroyResources as $ResType => $ResCount}
									<tr>
										<td>{$LNG.tech.{$ResType}}</td>
										<td><span style='color:lime'>{$ResCount|number}</span></td>
									</tr>
									{/foreach}
									<tr>
										<td>{$LNG.bd_destroy_time}</td>
										<td>{$Element.destroyTime|time}</td>
									</tr>
								</table>">
								<form action='game.php?page=buildings' method='post' class='build_form'>
												<input type='hidden' name='cmd' value='destroy'>
												<input type='hidden' name='building' value='{$ID}'>
												<button type='submit' class='build_submit onlist'><i class="fas fa-trash-alt" style="color: red; font-size: 11px;"></i></button>
											</form></a>
							{* End Destruction Popup *}
							{/if}
								{else}
							&nbsp;
						{/if}<a class="tooltip interrogation res" data-tooltip-content="<table style='width:300px'>
								<tr class='title text-center'><b>{$LNG.bd_remaining}:</b></tr>
									{foreach $Element.costOverflow as $ResType => $ResCount}
									<tr>
										<td>{$LNG.tech.{$ResType}}: <span style='font-weight:700'>{$ResCount|number}</span><br></td>
									</tr>
									{/foreach}
								</table>">i</a>
					<a href="#" onclick="return Dialog.info({$ID})" class="interrogation manual">?</a>
				</div>
				<div class="content_box">
					<div class="image">
						<img src="{$dpath}gebaeude/{$ID}.gif" alt="{$LNG.tech.$ID}">
					</div>
					<div class="prices">
					{foreach $Element.costResources as $RessID => $RessAmount}
						<div class="price">
							<img src="{$dpath}images/{$RessID}.png" class="tooltip" data-tooltip-content="{$LNG.tech.{$RessID}}" width="20" height="20" alt="{$LNG.tech.{$RessID}}"> <span class="tooltip" data-tooltip-content="{$LNG.tech.{$RessID}}" {if $Element.costOverflow[$RessID] == 0}class="res_{$RessID}_text"{/if} style="color:{if $Element.costOverflow[$RessID] == 0}{else}red{/if}">{$RessAmount|number}</span>						
						</div>					
					{/foreach}
					{if $ID == 12}
						<div class="price">
							<span style="font-weight: bold; float: right !important; padding-right: 5px !important"><i class="fas fa-tachometer-alt" style="font-size: 13px;"></i> {$Element.elementTime|time}</span>
						</div>
						{else}
						<div class="price">
							<span style="font-weight: bold;"><i class="fas fa-tachometer-alt" style="font-size: 13px;"></i> {$Element.elementTime|time}</span>
						</div>
					{/if}						
					</div>
					<div class="res_global_info">
                                {foreach $Element.ressources as $res}
                                    {if !empty($Element.{$res + $Element.class_production})}
                                    <div class="res_info info_res_{$res}"><a class="tooltip" data-tooltip-content="
                                        <table class='reducefleet_table'>
                                            <tr>
                                                <td class='reducefleet_img_ship'><img src='{$dpath}img/resources/{$res}f.png'></td>
                                                <td class='reducefleet_name_ship'>{$LNG.tech.{$res}} <span class='reducefleet_count_ship'>{$Element.{$res + $Element.class_production}|number}</span></td>
                                            </tr>
                                        </table>"><img height="15" width="15" src="{$dpath}img/resources/{$res}f.png"></a>
                                    </div>   
                                    {/if}
                                {/foreach}
                                {foreach $Element.storage as $res}
                                    {if !empty($Element.{$res + $Element.class_storage})}
                                    <div class="res_info info_res_{$res}"><a class="tooltip" data-tooltip-content="
                                        <table class='reducefleet_table'>
                                            <tr>
                                                <td class='reducefleet_img_ship'><img height='15' width='15' src='{$dpath}img/resources/{$res}f.png'></td>
                                                <td class='reducefleet_name_ship'>{$LNG.tech.{$res}} <span class='reducefleet_count_ship'>{$Element.{$res + $Element.class_storage}|number}</span></td>
                                            </tr>
                                        </table>"><img height="15" width="15" src="{$dpath}img/resources/{$res}f.png"></a>
                                    </div>   
                                    {/if}
                                {/foreach}
                                </div>  
					<div style="margin-top: 22px">
						{if $Element.maxLevel == $Element.levelToBuild}
							<div class="construct_button_lost">
								<span style="color:red">{$LNG.bd_maxlevel}</span>
							</div>
							{elseif ($isBusy.research && ($ID == 6 || $ID == 31 || $ID == 45)) || ($isBusy.shipyard && ($ID == 15 || $ID == 21)) || ($isBusy.defense && ($ID == 15 || $ID == 21))}
							<div class="construct_button_lost">
								<span style="color:red">{$LNG.bd_working}</span>
							</div>
						{else}
							{if $RoomIsOk}
								{if $CanBuildElement && $Element.buyable}
								<form action="game.php?page=buildings" method="post" class="build_form">
									<input type="hidden" name="cmd" value="insert">
									<input type="hidden" name="building" value="{$ID}">
									<button type="submit" class="build_submit construct_button">{if $Element.level == 0}{$LNG.bd_build}{else}{$LNG.bd_build_next_level}{$Element.levelToBuild + 1}{/if}</button>
								</form>
								{else}
								<button class="construct_button_lost">
									<span style="color:red">{if $Element.level == 0}{$LNG.bd_build}{else}{$LNG.bd_build_next_level}{$Element.levelToBuild + 1}{/if}</span>
								</button>
								{/if}
							{else}
							<button class="construct_button_lost">
								<span style="color:red">{$LNG.bd_no_more_fields}</span>
							</button>
							{/if}
						{/if}
					</div>
				</div>
			</div>
		 {/foreach}
	</div>
</div>
{/block}
