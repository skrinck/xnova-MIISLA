{include file="main.header.tpl" bodyclass="full"}
{include file="main.navigation_header.tpl"}
{include file="main.topnav.tpl"}
{if $hasAdminAccess}
<div class="globalWarning" {if $barplan ==1 }style="margin-top:165px"{/if}>
	{$LNG.admin_access_1} <a id="drop-admin">{$LNG.admin_access_link}</a>{$LNG.admin_access_2}
</div>
{/if}
<div {if $hasAdminAccess} style="margin-top:0px"{elseif $barplan == 1} style="margin-top:165px" {/if}></div>
{include file="main.navigation.tpl"}
<div id="page" {if $hasAdminAccess} style="margin-top:0px" {elseif $barplan == 0} style="margin-top:0px" {/if}>
	<div id="content">
		{block name="content"}{/block}
	</div>
</div>
{foreach $cronjobs as $cronjob}<img src="cronjob.php?cronjobID={$cronjob}" alt="">{/foreach}
{include file="main.footer.tpl" nocache}