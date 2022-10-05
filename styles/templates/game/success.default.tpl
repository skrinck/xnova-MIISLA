{block name="title" prepend}{$LNG.alert_success}{/block}
{block name="content"}
<div style="width:90%;margin: 0 auto;">
	<div class="alert alert-success alert-dismissible text-center" role="alert">
		{if !empty($redirectButtons)}
			{foreach $redirectButtons as $button}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<a href="{$button.url}"><i aria-hidden="true" class="fas fa-times text-success"></i></a>
				</button>
			{/foreach}
		{/if}
		<h4 class="alert-heading text-center"><i class="fas fa-check fa-2x align-middle"></i> {$LNG.alert_success}!</h4>
		<p><strong><u>System!</u></strong> {$message}</p>
	</div>
</div>
{/block}