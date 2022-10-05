{block name="title" prepend}{$LNG.lm_technology}{/block}
{block name="content"}
<span class="ir-arriba fas fa-arrow-up fa-3x"></span>
<div class="content_page" width="100%">
	<div id="tabse" class="title">
		{foreach $TechTreeList as $elementID => $requireList}
			{if $elementID == 0}
				<div onclick="tabse(this,'tab{$elementID}');" id="but0" class="active">{$LNG.tech.$requireList}</div>
				{else}
			{if !is_array($requireList)}
				<div onclick="tabse(this,'tab{$elementID}');" class="inactive">{$LNG.tech.$requireList}</div>
			{/if}{/if}
		{/foreach}
	</div>
<br><br>
{foreach $TechTreeList as $elementID => $requireList}
	{if $elementID == 0}
		<table id="tab{$elementID}" class="activetab" width="100%">
		{else}
		{if !is_array($requireList)}
			</table>
			<table id="tab{$elementID}" class="inactivetab">
			{else}
			<tr>
				<td><a href="#" onclick="return Dialog.info({$elementID})"><img src="{$dpath}gebaeude/{$elementID}.{if $elementID >=600 && $elementID <= 699}jpg{else}gif{/if}" width="70" height="70"></a></td>
				<td  style="width:60%"><a href="#" onclick="return Dialog.info({$elementID})">{$LNG.tech.$elementID}</a></td>
				<td style="width:40%">
				{if $requireList}
					{foreach $requireList as $requireID => $NeedLevel}
						<a href="#" onclick="return Dialog.info({$elementID})"><span style="color:{if $NeedLevel.own < $NeedLevel.count}red{else}lime{/if};">{$LNG.tech.$requireID} ({$LNG.tt_lvl} {min($NeedLevel.count, $NeedLevel.own)}/{$NeedLevel.count})</span></a>{if !$NeedLevel@last}<br>{/if}
					{/foreach}
				{/if}
				</td>
			</tr>
		{/if}
	{/if}
{/foreach}
</table></div><script>
var aclass = document.getElementById('but0');
var atab = document.getElementById('tab0');
function tabse(geklickt,etab){
	aclass.className ="inactive";
	atab.className = "inactivetab";
	aclass = geklickt;
	atab = document.getElementById(etab);	
	aclass.className = "active";
	atab.className = 'activetab';	
	}</script>
{/block}