{block name="title" prepend}{$LNG.lm_trader}{/block}
{block name="content"}
<div class="content_page text-center">
	<form id="trader" action="" method="post">
				<input type="hidden" name="mode" value="send">
				<input type="hidden" name="resource" value="{$tradeResourceID}">
					<table style="width:100%">
						<div class="title text-center">
							{$LNG.tr_sell} {$LNG.tech.$tradeResourceID}
						</div>
						<div class="text-center">
							<span>{$LNG.tr_resource}</span>
							<span class="pull-right">{$LNG.tr_quota_exchange}</span>
							<span class="pull-right" style="padding-right:90px;">{$LNG.tr_amount}</span>
						</div>
						<hr>
						<div class="text-center">
							<span>{$LNG.tech.$tradeResourceID}</span>
							<span class="pull-right">1</span>
							<span id="ress" class="pull-right"  style="padding-right:200px;">0</span>
						</div>
						{foreach $tradeResources as $tradeResource}
						<div class="text-center">
							<span><label for="resource{$tradeResource}">{$LNG.tech[$tradeResource]}</label></span>
							<span><input name="trade[{$tradeResource}]" id="resource{$tradeResource}" class="trade_input" type="text" value="0" size="30" data-resource="{$tradeResource}"></span>
							<span class="pull-right">{$charge[$tradeResource]}</span>
							<span id="resource{$tradeResource}Shortly" class="pull-right" style="padding-right:200px;"></span>
						</div>
						{/foreach}
						<div><input class="btn btn-dark btn-xs" type="submit" value="{$LNG.tr_exchange}"></div>
					</table>
	</form>
</div>
{/block}
{block name="script" append}
<script type="text/javascript">
var charge = {$charge|json};
</script>
{/block}