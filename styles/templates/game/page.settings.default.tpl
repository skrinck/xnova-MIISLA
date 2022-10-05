{block name="title" prepend}{$LNG.lm_options}{/block}
{block name="content"}
<span class="ir-arriba fas fa-arrow-up fa-3x"></span>
<form action="game.php?page=settings" method="post">
<input type="hidden" name="mode" value="send">

<div class="content_page">
	<div class="title">
		{$LNG.lm_options}
	</div>

	<div>
		<table style="width:100%;">
			<tbody>
				{if $userAuthlevel > 0}
				<tr class="title">
					<th colspan="2">{$LNG.op_admin_title_options}</th>
				</tr>
				<tr>
					<td>{$LNG.op_admin_planets_protection}</td>
					<td><input name="adminprotection" type="checkbox" value="1" {if $adminProtection > 0}checked="checked"{/if}></td>
				</tr>
				{/if}
				<tr class="title">
					<th colspan="2">{$LNG.op_user_data}</th>
				</tr>
				<tr>
					<td><img name="foto" title="" src="{$foto}" style="height:85px;width:85px;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;" class="tooltip" data-tooltip-content="{$LNG.hofComment_7}"></td>
					<td>
						<input name="foto" maxlength="255" size="80" value="{$foto}" type="text" class="autocomplete">	
					</td>
				</tr>
				<tr>
					<td width="50%">{$LNG.op_username}</td>
					<td width="50%" style="height:22px;">{if $changeNickTime < 0}<input name="username" size="20" value="{$username}" type="text">{else}{$username}{/if}</td>
				</tr>
				<tr>
					<td>{$LNG.op_old_pass}</td>
					<td><input name="password" size="20" type="password" class="autocomplete"></td>
				</tr>
				<tr>
					<td>{$LNG.op_new_pass}</td>
					<td><input name="newpassword" size="20" maxlength="40" type="password" class="autocomplete"></td>
				</tr>
				<tr>
					<td>{$LNG.op_repeat_new_pass}</td>
					<td><input name="newpassword2" size="20" maxlength="40" type="password" class="autocomplete"></td>
				</tr>
				<tr class="title">
					<th colspan="2">{$LNG.op_general_settings}</th>
				</tr>
				<tr>
					<td>{$LNG.op_timezone}</td>
					<td>{html_options name=timezone options=$Selectors.timezones selected=$timezone}</td>
				</tr>
				{if count($Selectors.lang) > 1}
				<tr>
					<td>{$LNG.op_lang}</td>
					<td>{html_options name=language options=$Selectors.lang selected=$userLang}</td>
				</tr>
				{/if}
				<tr>
					<td>{$LNG.op_sort_planets_by}</td>
					<td>{html_options name=planetSort options=$Selectors.Sort selected=$planetSort}</td>
				</tr>
				<tr>
					<td>{$LNG.op_sort_kind}</td>
					<td>
						{html_options name=planetOrder options=$Selectors.SortUpDown selected=$planetOrder}
					</td>
				</tr>
				{if count($Selectors.Skins) > 1}
				<tr>
					<td>{$LNG.op_skin_example}</td>
					<td>{html_options options=$Selectors.Skins selected=$theme name="theme" id="theme"}</td>
				</tr>
				{/if}
				<tr>
					<td>{$LNG.op_red_resources}</td>
					<td>{html_options name=gatherOptions class="big_seting_text" options=$Selectors.planetOption class="big_seting_text option" selected=$gatheroptions}</td>
				</tr>
				<tr>
					<td>{$LNG.op_active_build_messages}</td>
					<td><input name="queueMessages" type="checkbox" value="1" {if $queueMessages == 1}checked="checked"{/if}></td>
				</tr>
				<tr>
					<td>{$LNG.op_active_spy_messages_mode}</td>
					<td><input name="spyMessagesMode" type="checkbox" value="1" {if $spyMessagesMode == 1}checked="checked"{/if}></td>
				</tr>
				<tr>
					<td>{$LNG.op_block_pm}</td>
					<td><input name="blockPM" type="checkbox" value="1" {if $blockPM == 1}checked="checked"{/if}></td>
				</tr>
				<tr>
				     <td>{$LNG.option_alarm}</td>
				     <td>{html_options name=sirena nChange="SoundTest(this.options[this.selectedIndex].value)"  options=$Selectors.sirena class="big_seting_text option" selected=$sirenas}</td>
				 </tr>
				<tr class="title">
					<th colspan="2">{$LNG.op_galaxy_settings}</th>
				</tr>
				<tr>
					<td><a title="{$LNG.op_spy_probes_number_descrip}">{$LNG.op_spy_probes_number}</a></td>
					<td><input name="spycount" size="{$spycount|count_characters + 3}" value="{$spycount}" type="int"></td>
				</tr>
				<tr>
					<td>{$LNG.op_max_fleets_messages}</td>
					<td><input name="fleetactions" maxlength="2" size="{$fleetActions|count_characters + 2}" value="{$fleetActions}" type="int"></td>
				</tr>
				<tr class="title">
					<th>{$LNG.op_shortcut}</th>
					<th>{$LNG.op_show}</th>
				</tr>
				<tr>
					<td><img src="{$dpath}img/e.gif" alt="">{$LNG.op_spy}</td>
					<td><input name="galaxySpy" type="checkbox" value="1" {if $galaxySpy == 1}checked="checked"{/if}></td>
				</tr>
				<tr>
					<td><img src="{$dpath}img/m.gif" alt="">{$LNG.op_write_message}</td>
					<td><input name="galaxyMessage" type="checkbox" value="1" {if $galaxyMessage == 1}checked="checked"{/if}></td>
				</tr>
				<tr>
					<td><img src="{$dpath}img/b.gif" alt="">{$LNG.op_add_to_buddy_list}</td>
					<td><input name="galaxyBuddyList" type="checkbox" value="1" {if $galaxyBuddyList == 1}checked="checked"{/if}></td>
				</tr>
				<tr>
					<td><img src="{$dpath}img/r.gif" alt="">{$LNG.op_missile_attack}</td>
					<td><input name="galaxyMissle" type="checkbox" value="1" {if $galaxyMissle == 1}checked="checked"{/if}></td>
				</tr>
				<tr class="title">
					<th colspan="2">{$LNG.op_vacation_delete_mode}</th>
				</tr>
				<tr>
					<td><a title="{$LNG.op_activate_vacation_mode_descrip}">{$LNG.op_activate_vacation_mode}</a></td>
					<td><input name="vacation" type="checkbox" value="1"></td>
				</tr>
				<tr>
					<td><a title="{$LNG.op_dlte_account_descrip}">{$LNG.op_dlte_account}</a></td>
					<td><input name="delete" type="checkbox" value="1" {if $db_deaktjava > 0}checked="checked"{/if}></td>
				</tr>
				{if isModuleAvailable($smarty.const.MODULE_BANNER)}
				<tr class="title">
					<th colspan="3">{$LNG.ov_userbanner}</th>
				</tr>
				<tr>
					<td colspan="3"><img src="userpic.php?id={$userid}" alt="" width="590" height="95" id="userpic"><br><br><table><tr><td class="transparent">HTML:</td><td class="transparent"><input type="text" value='<a href="{$SELF_URL}{if $ref_active}index.php?ref={$userid}{/if}"><img src="{$SELF_URL}userpic.php?id={$userid}"></a>' readonly="readonly" style="width:450px;"></td></tr><tr><td class="transparent">BBCode:</td><td class="transparent"><input type="text" value="[url={$SELF_URL}{if $ref_active}index.php?ref={$userid}{/if}][img]{$SELF_URL}userpic.php?id={$userid}[/img][/url]" readonly="readonly" style="width:450px;"></td></tr></table></td>
				</tr>
				{/if}
				<tr>
					<td colspan="2"><input class="btn btn-dark btn-xs" value="{$LNG.op_save_changes}" type="submit"></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</form>
{/block}
