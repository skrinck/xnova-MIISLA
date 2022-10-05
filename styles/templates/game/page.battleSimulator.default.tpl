{block name="title" prepend}{$LNG.bs_battlesim}{/block}
{block name="content"}

<div class="content_page">
	<div class="title">
		{$LNG.bs_battlesim}
	</div>

	<div>
		<form id="form" name="battlesim">
		<input type="hidden" name="slots" id="slots" value="{$Slots + 1}">
		<input type="hidden" name="Pid" id="Pid" value="{$Pid}">
		<table style="width:100%">
			<tr>
				<td>{$LNG.bs_steal} {$LNG.tech.901}: <input type="text" size="10" value="{if isset($battleinput.0.1.901)}{$battleinput.0.1.901}{else}0{/if}" name="battleinput[0][1][901]"> {$LNG.tech.902}: <input type="text" size="10" value="{if isset($battleinput.0.1.902)}{$battleinput.0.1.902}{else}0{/if}" name="battleinput[0][1][902]"> {$LNG.tech.903}: <input type="text" size="10" value="{if isset($battleinput.0.1.903)}{$battleinput.0.1.903}{else}0{/if}" name="battleinput[0][1][903]"></td>
			</tr>
			<tr>
				<td class="left"><input class="btn btn-xs btn-dark" type="button" onClick="return add();" value="{$LNG.bs_add_acs_slot}"></td>
			</tr>
			<tr>
				<td class="transparent" style="padding:0;">
					<div id="tabs">
						<ul>
							{section name=tab start=0 loop=$Slots}<li><a href="#tabs-{$smarty.section.tab.index}">{$LNG.bs_acs_slot} {$smarty.section.tab.index + 1}</a></li>{/section}
						</ul>
						{section name=content start=0 loop=$Slots}
						<div id="tabs-{$smarty.section.content.index}">
							<table>
								<tr>
									<th></th>
									<th>{$LNG.bs_techno}</th>
									<th>{$LNG.bs_atter}</th>
									<th>{$LNG.bs_deffer}</th>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td><button class="reset btn btn-xs btn-dark">{$LNG.bs_reset}</button></td>
									<td><button class="reset btn btn-xs btn-dark">{$LNG.bs_reset}</button></td>
								</tr>
								<tr>
									<td><img src="{$dpath}gebaeude/109.gif" class="images-yamil" width="45" height="45"></td></td>
									<td>{$LNG.tech.109}:</td>
									<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.0.109)}{$battleinput.{$smarty.section.content.index}.0.109}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][109]"></td>
									<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.1.109)}{$battleinput.{$smarty.section.content.index}.1.109}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][109]"></td>
								</tr>
								<tr>
									<td><img src="{$dpath}gebaeude/110.gif" class="images-yamil" width="45" height="45"></td></td>
									<td>{$LNG.tech.110}:</td>
									<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.0.110)}{$battleinput.{$smarty.section.content.index}.0.110}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][110]"></td>
									<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.1.110)}{$battleinput.{$smarty.section.content.index}.1.110}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][110]"></td>
								</tr>
								<tr>
									<td><img src="{$dpath}gebaeude/111.gif" class="images-yamil" width="45" height="45"></td>
									<td>{$LNG.tech.111}:</td>
									<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.0.111)}{$battleinput.{$smarty.section.content.index}.0.111}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][111]"></td>
									<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.1.111)}{$battleinput.{$smarty.section.content.index}.1.111}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][111]"></td>
								</tr>
								<tr>
									<td><img src="{$dpath}gebaeude/120.gif" class="images-yamil" width="45" height="45"></td>
									<td>{$LNG.tech.120}:</td>
									<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.0.120)}{$battleinput.{$smarty.section.content.index}.0.120}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][120]"></td>
									<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.1.120)}{$battleinput.{$smarty.section.content.index}.1.120}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][120]"></td>
								</tr>
								<tr>
									<td><img src="{$dpath}gebaeude/121.gif" class="images-yamil" width="45" height="45"></td>
									<td>{$LNG.tech.121}:</td>
									<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.0.121)}{$battleinput.{$smarty.section.content.index}.0.121}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][121]"></td>
									<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.1.121)}{$battleinput.{$smarty.section.content.index}.1.121}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][121]"></td>
								</tr>
								<tr>
									<td><img src="{$dpath}gebaeude/122.gif" class="images-yamil" width="45" height="45"></td>
									<td>{$LNG.tech.122}:</td>
									<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.0.122)}{$battleinput.{$smarty.section.content.index}.0.122}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][122]"></td>
									<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.1.122)}{$battleinput.{$smarty.section.content.index}.1.122}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][122]"></td>
								</tr>
								<tr>
									<td><img src="{$dpath}gebaeude/199.gif" class="images-yamil" width="45" height="45"></td>
									<td>{$LNG.tech.199}:</td>
									<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.0.199)}{$battleinput.{$smarty.section.content.index}.0.199}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][199]"></td>
									<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.1.199)}{$battleinput.{$smarty.section.content.index}.1.199}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][199]"></td>
								</tr>
							</table>
							<br>
							<table>
								<tr>
									<td class="transparent">
										<table>
											<tr>
												<th></th>
												<th>{$LNG.bs_ship}</th>
												<th>{$LNG.bs_atter}</th>
												<th>{$LNG.bs_deffer}</th>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td><button class="reset btn btn-xs btn-dark">{$LNG.bs_reset}</button></td>
												<td><button class="reset btn btn-xs btn-dark">{$LNG.bs_reset}</button></td>
											</tr>
											{foreach $fleetList as $id}
											<tr>
												<td><img src="{$dpath}gebaeude/{$id}.{if $id >=600 && $id <= 699}jpg{else}gif{/if}" class="images-yamil" width="45" height="45"></td>
												<td>{$LNG.tech.$id}:</td>
												<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.0.$id)}{$battleinput.{$smarty.section.content.index}.0.$id}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][{$id}]"></td>
												<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.1.$id)}{$battleinput.{$smarty.section.content.index}.1.$id}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][{$id}]"></td>
											</tr>
											{/foreach}
										</table>
									</td>
									{if $smarty.section.content.index == 0}
										<td style="width:50%" class="transparent">
											<table>
												<tr>
													<th></th>
													<th>{$LNG.bs_defense}</td>
													<th>{$LNG.bs_atter}</th>
													<th>{$LNG.bs_deffer}</th>
												</tr>
												<tr>
													<td></td>
													<td></td>
													<td></td>
													<td><button class="reset btn btn-xs btn-dark">{$LNG.bs_reset}</button></td>
												</tr>
												{foreach $defensiveList as $id}
												<tr>
													<td><img src="{$dpath}gebaeude/{$id}.{if $id >=600 && $id <= 699}jpg{else}gif{/if}" class="images-yamil" width="45" height="45"></td></td>
													<td>{$LNG.tech.$id}:</td>
													<td>-</td>
													<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.1.$id)}{$battleinput.{$smarty.section.content.index}.1.$id}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][{$id}]"></td>
												</tr>
											{/foreach}
											</table>
										</td>
									{/if}
								</tr>
							</table>
						</div>
						{/section}
					</div>
				</td>
			</tr>
			<tr id="submit">
				<td><input class="btn btn-xs btn-dark" type="button" onClick="return check();" value="{$LNG.bs_send}">&nbsp;<input class="btn btn-xs btn-dark" type="reset" value="{$LNG.bs_cancel}"></td>
			</tr>
			<tr id="wait" style="display:none;">
				<td style="height:20px">{$LNG.bs_wait}</td>
			</tr>
		</table>
	</form>
	</div>
</div>

{/block}
