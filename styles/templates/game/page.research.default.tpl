{block name="title" prepend}{$LNG.lm_research}{/block}
{block name="content"}
<div id="build_content" class="conteiner container" style="width: 98%">
    <div class="gray_stripe text-center">
    	<span>{$LNG.lm_research}</span>
	</div>
<br>
	{if $IsLabinBuild}
		<div class="alert alert-danger text-center" style="padding-left: 50px"><i class="fas fa-exclamation-triangle fa-3x align-middle"></i> {$LNG.bd_building_lab}</div>	
	{/if}

	{if !empty($Queue)}
	<div id="buildlist" class="buildlist">
		<table style="width: 100%;">
					<div class="alert alert-info text-center"><i class="fas fas fa-bullhorn fa-2x align-middle"></i> {$LNG.bd_cancel_research}</div>
			{foreach $Queue as $List}
			{$ID = $List.element}
			<tr>
				<td style="width:70%;vertical-align:top;" class="left">
					{if isset($ResearchList[$List.element])}
					{$CQueue = $ResearchList[$List.element]}
					{/if}
					{$List@iteration}.: 
					{if isset($CQueue) && $CQueue.maxLevel != $CQueue.level && !$IsFullQueue && $CQueue.buyable}
					<form action="game.php?page=research" method="post" class="build_form">
						<input type="hidden" name="cmd" value="insert">
						<input type="hidden" name="tech" value="{$ID}">
						<button type="submit" class="build_submit onlist">{$LNG.tech.{$ID}} {$List.level}{if !empty($List.planet)} @ {$List.planet}{/if}</button>
					</form>
					{else}
					{$LNG.tech.{$ID}} {$List.level}{if !empty($List.planet)} @ {$List.planet}{/if}
					{/if}
					{if $List@first}
					<br><br><div id="progressbar" data-time="{$List.resttime}"></div>
				</td>
				<td>
					<div id="time" data-time="{$List.time}"><br></div>
					<form action="game.php?page=research" method="post" class="build_form">
						<input type="hidden" name="cmd" value="cancel">
						<button type="submit" class="build_submit onlist">{$LNG.bd_cancel}</button>
					</form>
					{else}
				</td>
				<td>
					<form action="game.php?page=research" method="post" class="build_form">
						<input type="hidden" name="cmd" value="remove">
						<input type="hidden" name="listid" value="{$List@iteration}">
						<button type="submit" class="build_submit onlist">{$LNG.bd_cancel}</button>
					</form>
					{/if}
					<br><span style="color:lime" data-time="{$List.endtime}" class="timer">{$List.display}</span>
				</td>
			</tr>
		{/foreach}
		</table>
	</div>
	{/if}
	<div id="building_elements" class="build_list">
		{foreach $ResearchList as $ID => $Element}
			<div class="build_box">
				<div class="head">
					<a href="#" onclick="return Dialog.info({$ID})">{$LNG.tech.{$ID}}</a> {if $Element.level > 0}[{$Element.level}/{$Element.maxLevel}]{/if}
					<a class="tooltip interrogation res" data-tooltip-content="<table style='width:300px'>
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
					<div class="price">
						<span style="font-weight: bold;"><i class="fas fa-tachometer-alt" style="font-size: 13px;"></i> {$Element.elementTime|time}</span>
					</div>
					</div>
					<div style="margin-top: 22px">
						{if $Element.maxLevel == $Element.levelToBuild}
							<button type="submit" class="construct_button_lost">
								<span style="color:red">{$LNG.bd_maxlevel}</span>
							</button>
						{elseif $IsLabinBuild || $IsFullQueue || !$Element.buyable}
							<button type="submit" class="construct_button_lost">
								<span style="color:red">{if $Element.level == 0 && $Element.levelToBuild == 0}{$LNG.bd_tech}{else}{$LNG.bd_tech_next_level}{$Element.levelToBuild + 1}{/if}</span>
							</button>
						{else}
							<form action="game.php?page=research" method="post" class="build_form">
								<input type="hidden" name="cmd" value="insert">
								<input type="hidden" name="tech" value="{$ID}">
								<button type="submit" class="build_submit construct_button">{if $Element.level == 0 && $Element.levelToBuild == 0}{$LNG.bd_tech}{else}{$LNG.bd_tech_next_level}{$Element.levelToBuild + 1}{/if}</button>
							</form>
						{/if}
					</div>
				</div>
			</div>
		{/foreach}
	</div>
</div>
{/block}
{block name="script" append}
    {if !empty($Queue)}
        <script src="scripts/game/research.js"></script>
    {/if}
{/block}
