{block name="title" prepend}{$LNG.lm_empire}{/block}
{block name="content"}
<br>
<span class="ir-arriba fas fa-arrow-up fa-3x"></span>
<div class="container">
	<div class="content_page" style="width:100%">
		<div class="title text-center">
			{$LNG.lv_imperium_title}
		</div>
		<div style="width:100%">
			<table class="table-responsive" >
				<head>
					<tr>
						<td style="font-size: 35px;">{$LNG.lv_planet}</td>
						<td style="font-size: 50px;">&Sigma;</td>
						{foreach $planetList.image as $planetID => $image}
							<td style=""><a href="game.php?page=overview&amp;cp={$planetID}"><img width="50" height="50" class="images-yamil" border="0" src="{$dpath}planeten/small/s_{$image}.png"></a></td>
						{/foreach}
					</tr>
					<tr>
						<td>{$LNG.lv_name}</td>
						<td>{$LNG.lv_total}</td>
						{foreach $planetList.name as $name}
							<td>{$name}</td>
						{/foreach}
					</tr>
					<tr>
						<td>{$LNG.lv_coords}</td>
						<td>-</td>
						{foreach $planetList.coords as $coords}
							<td><a href="game.php?page=galaxy&amp;galaxy={$coords.galaxy}&amp;system={$coords.system}">[{$coords.galaxy}:{$coords.system}:{$coords.planet}]</a></td>
						{/foreach}
					</tr>
					<tr>
						<td>{$LNG.lv_fields}</td>
						<td>-</td>
						{foreach $planetList.field as $field}
							<td>{$field.current} / {$field.max}</td>
						{/foreach}
					</tr>
				</head>
				<tbody>

					<tr>
						<th class="title" colspan="{$colspan}" style="text-align:left">{$LNG.lv_resources}</th>
					</tr>
					{foreach $planetList.resource as $elementID => $resourceArray}
					<tr>
						<td>{$LNG.tech.$elementID}</td>
						<td class="res_{$elementID}_text">{array_sum($resourceArray)|number}</td>
						{foreach $resourceArray as $planetID => $resource}
							<td class="res_{$elementID}_text">{$resource|number}</td>
						{/foreach}
					</tr>
					{/foreach}
					<tr>
						<th class="title" colspan="{$colspan}" style="text-align:left">Proudcción {$LNG.rs_daily}</th>
					</tr>
					{foreach $planetList1.resource as $elementID => $resourceArray}
						<tr>
							<td>{$LNG.tech.$elementID}</td>
							<td class="res_{$elementID}_text">{array_sum($resourceArray)|number}</td>
							{foreach $resourceArray as $planetID => $resource}
							<td class="res_{$elementID}_text">{$resource|number}</td>
						{/foreach}
						</tr>
					{/foreach}
					<tr>
						<th class="title" colspan="{$colspan}">{$LNG.lv_buildings}</th>
					</tr>
					{foreach $planetList.build as $elementID => $buildArray}
					<tr>
						<td><a href='#' onclick='return Dialog.info({$elementID})' class='tooltip' data-tooltip-content="<table><tr class=title'><th>{$LNG.tech.{$elementID}}</th></tr><tr><table class='hoverinfo'><tr><td><img width='70' height='70' class='images-yamil' src='{$dpath}gebaeude/{$elementID}.{if $elementID >=600 && $elementID <= 699}jpg{else}gif{/if}'></td><td>{$LNG.shortDescription.$elementID}</td></tr></table></tr></table>">{$LNG.tech.$elementID}</a></td>
						<td>{array_sum($buildArray)|number}</td>
						{foreach $buildArray as $planetID => $build}
							<td>{$build|number}</td>
						{/foreach}
					</tr>
					{/foreach}
					<tr>
						<th class="title" colspan="{$colspan}">{$LNG.lv_technology}</th>
					</tr>
					{foreach $planetList.tech as $elementID => $tech}
					<tr>
						<td><a href='#' onclick='return Dialog.info({$elementID})' class='tooltip' data-tooltip-content="<table><tr class=title'><th>{$LNG.tech.{$elementID}}</th></tr><tr><table class='hoverinfo'><tr><td><img width='70' height='70' class='images-yamil' src='{$dpath}gebaeude/{$elementID}.{if $elementID >=600 && $elementID <= 699}jpg{else}gif{/if}'></td><td>{$LNG.shortDescription.$elementID}</td></tr></table></tr></table>">{$LNG.tech.$elementID}</a></td>
						<td>{$tech|number}</td>
						{foreach $planetList.name as $name}
							<td>{$tech|number}</td>
						{/foreach}
					</tr>
					{/foreach}
					<tr>
						<th class="title" colspan="{$colspan}">{$LNG.lv_ships}</th>
					</tr>
					{foreach $planetList.fleet as $elementID => $fleetArray}
					<tr>
						<td><a href='#' onclick='return Dialog.info({$elementID})' class='tooltip' data-tooltip-content="<table><tr class=title'><th>{$LNG.tech.{$elementID}}</th></tr><tr><table class='hoverinfo'><tr><td><img width='70' height='70' class='images-yamil' src='{$dpath}gebaeude/{$elementID}.{if $elementID >=600 && $elementID <= 699}jpg{else}gif{/if}'></td><td>{$LNG.shortDescription.$elementID}</td></tr></table></tr></table>">{$LNG.tech.$elementID}</a></td>
						<td>{array_sum($fleetArray)|number}</td>
						{foreach $fleetArray as $planetID => $fleet}
							<td>{$fleet|number}</td>
						{/foreach}
					</tr>
					{/foreach}
					<tr>
						<th class="title" colspan="{$colspan}">{$LNG.lv_defenses}</th>
					</tr>
					{foreach $planetList.defense as $elementID => $fleetArray}
					<tr>
						<td><a href='#' onclick='return Dialog.info({$elementID})' class='tooltip' data-tooltip-content="<table><tr class=title'><th>{$LNG.tech.{$elementID}}</th></tr><tr><table class='hoverinfo'><tr><td><img width='70' height='70' class='images-yamil' src='{$dpath}gebaeude/{$elementID}.{if $elementID >=600 && $elementID <= 699}jpg{else}gif{/if}'></td><td>{$LNG.shortDescription.$elementID}</td></tr></table></tr></table>">{$LNG.tech.$elementID}</a></td>
						<td>{array_sum($fleetArray)|number}</td>
						{foreach $fleetArray as $planetID => $fleet}
							<td>{$fleet|number}</td>
						{/foreach}
					</tr>
					{/foreach}
					<tr>
					 	<th class="title" colspan="{$colspan}">{$LNG.tech.500}</th>
				 	</tr>
					{foreach $planetList.missiles as $elementID => $fleetArray}
					<tr>
						<td><a href='#' onclick='return Dialog.info({$elementID})' class='tooltip' data-tooltip-content="<table><tr class=title'><th>{$LNG.tech.{$elementID}}</th></tr><tr><table class='hoverinfo'><tr><td><img width='70' height='70' class='images-yamil' src='{$dpath}gebaeude/{$elementID}.{if $elementID >=600 && $elementID <= 699}jpg{else}gif{/if}'></td><td>{$LNG.shortDescription.$elementID}</td></tr></table></tr></table>">{$LNG.tech.$elementID}</a></td>
						<td>{array_sum($fleetArray)|number}</td>
						{foreach $fleetArray as $planetID => $fleet}
							<td>{$fleet|number}</td>
						{/foreach}
					</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>
</div>
{/block}
