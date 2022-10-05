{block name="title" prepend}{$LNG.lm_trader}{/block}
{block name="content"}
<div class="container container-page table-responsive text-center" style="width:50%">
	{if $requiredDarkMatter}
		<table style="width:100%">
				<div class="title text-center font-weight-bold">{$LNG.fcm_info}</div>
				<div class="alert alert-danger text-center"><i class="fas fa-exclamation-triangle fa-2x align-middle"></i> {$requiredDarkMatter}</div>
		</table>
	{/if}
	<table style="width:100%">
			<div class="title text-center font-weight-bold">{$LNG.tr_call_trader}</div>
				<div>{$LNG.tr_call_trader_who_buys}</div>
				<hr>
				<div id="traderContainer" class="centerContainer">
					<div class="outer">
						<div class="inner">
							{foreach $charge as $resourceID => $chageData}
							<div class="trader_col">
								{if !$requiredDarkMatter}<form action="game.php?page=trader" method="post">
								<input type="hidden" name="mode" value="trade">
								<input type="hidden" name="resource" value="{$resourceID}">
								<input type="image" id="trader_metal" src="{$dpath}images/{$resource.$resourceID}.gif" title="{$LNG.tech.$resourceID}" border="0" height="32" width="52"><br>
								<label for="trader_metal">{$LNG.tech.$resourceID}</label>
								</form>
								{else}<img src="{$dpath}images/{$resource.$resourceID}.gif" border="0" height="32" width="52" style="margin: 3px;"><br>{$LNG.tech.$resourceID}{/if}
							</div>
							{/foreach}
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<br>
				<div>
					<p>{$LNG.tr_exchange_quota}: {$charge.901.903}/{$charge.902.903}/{$charge.903.903}</p>
				</div>
				<hr>
				<div class="alert alert-info text-center"><i class="fas fa-exclamation-circle fa-2x align-middle"></i> {$tr_cost_dm_trader}</div>
	</table>
</div>
{/block}