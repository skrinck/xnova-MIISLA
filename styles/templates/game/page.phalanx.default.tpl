{block name="title" prepend}{$LNG.gl_phalanx}{/block}
{block name="content"}
<div class="content_page content_responsive" style="width: 98%">
	<table>
	<tr>
    	<th colspan="10" class="title">{$LNG.px_scan_position} [{$galaxy}:{$system}:{$planet}] ({$name})</th>
	</tr>
	<tr>
		<th colspan="10" class="text-center">{$LNG.px_fleet_movement}</th>
	</tr>
	{foreach $fleetTable as $index => $fleet}
		<tr>
			<td id="fleettime_{$index}" class="fleets" data-fleet-end-time="{$fleet.returntime}" data-fleet-time="{$fleet.resttime}">00:00:00</td>
			<td>{$fleet.text}</td>
		</tr>
	{foreachelse}
		<div class="alert alert-info text-center"><i class="fas fa-exclamation-triangle fa-2x align-middle"></i> {$LNG.px_no_fleet}</div>
	{/foreach}
	</table>
</div>
{/block}