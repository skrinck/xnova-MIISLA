{block name="title" prepend}{$LNG.alert_danger}{/block}
{block name="content"}
<div style="width:90%;margin: 0 auto;">
	<div class="alert alert-danger alert-dismissible text-center" role="alert">
		{if !empty($redirectButtons)}
			{foreach $redirectButtons as $button}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<a href="{$button.url}"><i aria-hidden="true" class="fas fa-times text-danger"></i></a>
				</button>
			{/foreach}
		{/if}
		<h4 class="alert-heading text-center"><i class="fas fa-exclamation-triangle fa-2x align-middle"></i> {$LNG.alert_danger}!</h4>
		<p><strong><u>System!</u></strong> {$message}</p>
		<hr>
		<p class="mb-0">{$LNG.alert_sug}</p>
	</div>
</div>
{/block}