{block name="title" prepend}{$LNG.lm_messages}{/block}
{block name="content"}
<br>
<span class="ir-arriba fas fa-arrow-up fa-3x"></span>
<div class="contianer">
	<div class="content_page">
		<table style="table-layout:fixed;width: 100%">
			<div class="title text-center">
				<b>{$LNG.mg_overview}</b>
				<span id="loading" style="display:none;"> ({$LNG.loading})</span>
			</div>
			{foreach $CategoryList as $CategoryID => $CategoryRow}
				{if ($CategoryRow@iteration % 6) === 1}<tr>{/if}
				{if $CategoryRow@last && ($CategoryRow@iteration % 6) !== 0}<td>&nbsp;</td>{/if}
				<td style="word-wrap: break-word;color:{$CategoryRow.color};"><a href="#" onclick="Message.getMessages({$CategoryID});return false;" style="color:{$CategoryRow.color};">{$LNG.mg_type.{$CategoryID}}</a>
				<br><span id="unread_{$CategoryID}">{$CategoryRow.unread}</span>/<span id="total_{$CategoryID}">{$CategoryRow.total}</span>
				</td>
				{if $CategoryRow@last || ($CategoryRow@iteration % 6) === 0}</tr>{/if}
			{/foreach}
		</table>
		<br>
		<table style="width:100%;table-layout:fixed;" class="text-center">
				<div class="title">
					{$LNG.mg_game_operators}
				</div>
				{foreach $OperatorList as $OperatorName => $OperatorEmail}
				<div class="text-center">
					{$OperatorName}<a href="mailto:{$OperatorEmail}"  class="tooltip" data-tooltip-content="{$LNG.mg_write_mail_to_ops} {{$OperatorName}}"> <i class="far fa-envelope"></i></a>
				</div>
				{/foreach}
		</table>
	</div>
</div>
{/block}
{block name="script" append}
{if !empty($category)}
<script>$(function() {
	Message.getMessages({$category}, {$side});
})</script>
{/if}
{/block}
