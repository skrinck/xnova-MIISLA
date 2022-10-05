{block name="title" prepend}{$LNG.lm_records}{/block}
{block name="content"}
<span class="ir-arriba fas fa-arrow-up fa-3x"></span>
<div class="content_page">
	<div class="title">
		{$LNG.rec_last_update_on}: {$update}
	</div>

	<div>
		<table>
			<tbody>
				<tr class="title">
					<th></th>
					<th>{$LNG.tech.0}</th>
					<th>{$LNG.rec_players}</th>
					<th>{$LNG.rec_level}</th>
				</tr>
				{foreach $buildList as $elementID => $elementRow}
				<tr>
					<td><img src="{$dpath}gebaeude/{$elementID}.{if $elementID >=600 && $elementID <= 699}jpg{else}gif{/if}" class="images-yamil" width="45" height="45"></td>
					<td>{$LNG.tech.{$elementID}}</td>
					{if !empty($elementRow)}
					<td>{foreach $elementRow as $user}<a href='#' onclick='return Dialog.Playercard({$user.userID});'>{$user.username}</a>{if !$user@last}<br>{/if}{/foreach}</td>
					<td>{$elementRow[0].level|number}</td>
					{else}
					<td>-</td>
					<td>-</td>
					{/if}
				</tr>
				{/foreach}
				<tr class="title">
					<th></th>
					<th>{$LNG.tech.100}</th>
					<th>{$LNG.rec_players}</th>
					<th>{$LNG.rec_level}</th>
				</tr>
				{foreach $researchList as $elementID => $elementRow}
				<tr>
					<td><img src="{$dpath}gebaeude/{$elementID}.{if $elementID >=600 && $elementID <= 699}jpg{else}gif{/if}" class="images-yamil" width="45" height="45"></td>
					<td>{$LNG.tech.{$elementID}}</td>
					{if !empty($elementRow)}
					<td>{foreach $elementRow as $user}<a href='#' onclick='return Dialog.Playercard({$user.userID});'>{$user.username}</a>{if !$user@last}<br>{/if}{/foreach}</td>
					<td>{$elementRow[0].level|number}</td>
					{else}
					<td>-</td>
					<td>-</td>
					{/if}
				</tr>
				{/foreach}
				<tr class="title">
					<th></th>
					<th>{$LNG.tech.200}</th>
					<th>{$LNG.rec_players}</th>
					<th>{$LNG.rec_count}</th>
				</tr>
				{foreach $fleetList as $elementID => $elementRow}
				<tr>
					<td><img src="{$dpath}gebaeude/{$elementID}.{if $elementID >=600 && $elementID <= 699}jpg{else}gif{/if}" class="images-yamil" width="45" height="45"></td>
					<td>{$LNG.tech.{$elementID}}</td>
					{if !empty($elementRow)}
					<td>{foreach $elementRow as $user}<a href='#' onclick='return Dialog.Playercard({$user.userID});'>{$user.username}</a>{if !$user@last}<br>{/if}{/foreach}</td>
					<td>{$elementRow[0].level|number}</td>
					{else}
					<td>-</td>
					<td>-</td>
					{/if}
				</tr>
				{/foreach}
				<tr class="title">
					<th></th>
					<th>{$LNG.tech.400}</th>
					<th>{$LNG.rec_players}</th>
					<th>{$LNG.rec_count}</th>
				</tr>
				{foreach $defenseList as $elementID => $elementRow}
				<tr>
					<td><img src="{$dpath}gebaeude/{$elementID}.{if $elementID >=600 && $elementID <= 699}jpg{else}gif{/if}" class="images-yamil" width="45" height="45"></td>
					<td>{$LNG.tech.{$elementID}}</td>
					{if !empty($elementRow)}
					<td>{foreach $elementRow as $user}<a href='#' onclick='return Dialog.Playercard({$user.userID});'>{$user.username}</a>{if !$user@last}<br>{/if}{/foreach}</td>
					<td>{$elementRow[0].level|number}</td>
					{else}
					<td>-</td>
					<td>-</td>
					{/if}
				</tr>
				{/foreach}
				<tr class="title">
					<th></th>
					<th>{$LNG.tech.500}</th>
					<th>{$LNG.rec_players}</th>
					<th>{$LNG.rec_count}</th>
				</tr>

				{foreach $missileList as $elementID => $elementRow}
				<tr>
					<td><img src="{$dpath}gebaeude/{$elementID}.{if $elementID >=600 && $elementID <= 699}jpg{else}gif{/if}" class="images-yamil" width="45" height="45"></td>
					<td>{$LNG.tech.{$elementID}}</td>
					{if !empty($elementRow)}
					<td>{foreach $elementRow as $user}<a href='#' onclick='return Dialog.Playercard({$user.userID});'>{$user.username}</a>{if !$user@last}<br>{/if}{/foreach}</td>
					<td>{$elementRow[0].level|number}</td>
					{else}
					<td>-</td>
					<td>-</td>
					{/if}
				</tr>
				{/foreach}
				<tr class="title">
					<th></th>
					<th>{$LNG.tech.600}</th>
					<th>{$LNG.rec_players}</th>
					<th>{$LNG.rec_count}</th>
				</tr>

				{foreach $officierList as $elementID => $elementRow}
				<tr>
					<td><img src="{$dpath}gebaeude/{$elementID}.{if $elementID >=600 && $elementID <= 699}jpg{else}gif{/if}" width="45" height="45"></td>
					<td>{$LNG.tech.{$elementID}}</td>
					{if !empty($elementRow)}
					<td>{foreach $elementRow as $user}<a href='#' onclick='return Dialog.Playercard({$user.userID});'>{$user.username}</a>{if !$user@last}<br>{/if}{/foreach}</td>
					<td>{$elementRow[0].level|number}</td>
					{else}
					<td>-</td>
					<td>-</td>
					{/if}
				</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
</div>

{/block}
