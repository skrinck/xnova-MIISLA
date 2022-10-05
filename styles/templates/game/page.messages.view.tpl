{block name="content"}
<form action="game.php?page=messages" method="post">
<input type="hidden" name="mode" value="action">
<input type="hidden" name="ajax" value="1">
<input type="hidden" name="messcat" value="{$MessID}">
<input type="hidden" name="side" value="{$page}">

	<div id="messagestable">
		<div class="title" style="margin: 0 -5px 0 -5px;">
			{$LNG.mg_message_title}
		</div>
			<table style="width:100%;">
				<hr>
				{if $MessID != 999}
				<tr align="center">
					<select class="custom-select" name="actionTop">
						<option value="readmarked">{$LNG.mg_read_marked}</option>
						<option value="readtypeall">{$LNG.mg_read_type_all}</option>
						<option value="readall">{$LNG.mg_read_all}</option>
						<option value="deletemarked">{$LNG.mg_delete_marked}</option>
						<option value="deleteunmarked">{$LNG.mg_delete_unmarked}</option>
						<option value="deletetypeall">{$LNG.mg_delete_type_all}</option>
						<option value="deleteunmarkedtype">{$LNG.mg_delete_unmarked_type}</option>
						<option value="deleteall">{$LNG.mg_delete_all}</option>
					</select>
					<input class="btn btn-dark btn-xs" value="{$LNG.mg_confirm}" type="submit" name="submitTop">
				</tr>
				{/if}
				<br>
				<tr class="container">
					{$LNG.mg_page}: {if $page != 1}
						<a href="#" class="tooltip" data-tooltip-content="{$LNG.m_back}" onclick="Message.getMessages({$MessID}, {$page - 1});return false;">&laquo;</a>&nbsp;{/if}{for $site=1 to $maxPage}
						<a href="#" onclick="Message.getMessages({$MessID}, {$site});return false;">{if $site == $page}<b class="text-success tooltip" data-tooltip-content="{$LNG.m_now}">[{$site}]</b>{else}[{$site}]{/if}
						</a>
						{if $site != $maxPage}&nbsp;{/if}{/for}{if $page != $maxPage}&nbsp;<a href="#" class="tooltip" data-tooltip-content="{$LNG.m_next}" onclick="Message.getMessages({$MessID}, {$page + 1});return false;">&raquo;</a>{/if}
				</tr>
				<hr>
				<tr style="height: 20px;">
					<td class="text-center">{$LNG.mg_action}</td>
					<td class="text-center">{$LNG.mg_date}</td>
					<td class="text-center">{if $MessID != 999}{$LNG.mg_from}{else}{$LNG.mg_to}{/if}</td>
					<td class="text-center">{$LNG.mg_subject}</td>
				</tr>
				{foreach $MessageList as $Message}
				<tr id="message_{$Message.id}" class="title message_head{if $MessID != 999 && $Message.unread == 1} mes_unread{/if}">
					<td style="width:40px;" rowspan="2">
					{if $MessID != 999}<input name="messageID[{$Message.id}]" value="1" type="checkbox">{/if}
					{if $MessID == 0 || $MessID == 3 || $MessID == 199 && $Message.oldType == 0 || $MessID == 199 && $Message.oldType == 3}
					<br>
					<a class="tooltip" data-tooltip-content="{$LNG.mg_re}" onclick="return Dialog.SRTF({$Message.id})"><i class="fas fa-share-square"></i></a>
					{/if}
					</td>
					<td>{$Message.time}</td>
					<td>{$Message.from}</td>
					<td>{$Message.subject}
					{if $Message.type == 1 && $MessID != 999}
					<a href="#" onclick="return Dialog.PM({$Message.sender}, Message.CreateAnswer('{$Message.subject}'));" class="tooltip" data-tooltip-content="{$LNG.mg_answer_to} {strip_tags($Message.from)}"><i class="far fa-envelope" style="font-size: 15px;"></i></a>
					{/if}
					</td>
				</tr>
				<tr class="messages_body">
					<td colspan="3" class="left" style="padding: 10px; background: rgba(0,0,0,0.3);">
					{$Message.text}
					</td>
				</tr>
				{/foreach}
			</table>
	</div>
</form>
<!-- <br><br>
<form action="game.php?page=messages" method="post" style="width: 100%">
	<input type="hidden" name="mode" value="action">
	<input type="hidden" name="ajax" value="1">
	<input type="hidden" name="messcat" value="{$MessID}">
	<input type="hidden" name="side" value="{$page}">

	<div id="messagestable">
		<div class="title text-center" >
			{$LNG.mg_message_title}
		</div>
	<table>
		<hr>
			{if $MessID != 999}
			<div align="center">
				<select class="custom-select" name="actionTop">
					<option value="readmarked">{$LNG.mg_read_marked}</option>
					<option value="readtypeall">{$LNG.mg_read_type_all}</option>
					<option value="readall">{$LNG.mg_read_all}</option>
					<option value="deletemarked">{$LNG.mg_delete_marked}</option>
					<option value="deleteunmarked">{$LNG.mg_delete_unmarked}</option>
					<option value="deletetypeall">{$LNG.mg_delete_type_all}</option>
					<option value="deleteall">{$LNG.mg_delete_all}</option>
				</select>
				<input class="btn btn-dark btn-xs" value="{$LNG.mg_confirm}" type="submit" name="submitTop">
			</div>
			{/if}
			<br>
			<div class="container">
				{$LNG.mg_page}: {if $page != 1}
					<a href="#" class="tooltip" data-tooltip-content="{$LNG.m_back}" onclick="Message.getMessages({$MessID}, {$page - 1});return false;">&laquo;</a>&nbsp;{/if}{for $site=1 to $maxPage}
					<a href="#" onclick="Message.getMessages({$MessID}, {$site});return false;">{if $site == $page}<b class="text-success tooltip" data-tooltip-content="{$LNG.m_now}">[{$site}]</b>{else}[{$site}]{/if}
					</a>
					{if $site != $maxPage}&nbsp;{/if}{/for}{if $page != $maxPage}&nbsp;<a href="#" class="tooltip" data-tooltip-content="{$LNG.m_next}" onclick="Message.getMessages({$MessID}, {$page + 1});return false;">&raquo;</a>{/if}
			</div>
			<hr>
			<table style="width: 100%">
				<head>
					<tr>
						<th scope="col" class="text-center">{$LNG.mg_action}</th>
						<th scope="col" class="text-center">{$LNG.mg_date}</th>
						<th scope="col" class="text-center">{if $MessID != 999}{$LNG.mg_from}{else}{$LNG.mg_to}{/if}</th>
						<th scope="col" class="text-center">{$LNG.mg_subject}</th>
					</tr>
				</head>
				<tbody>
					{foreach $MessageList as $Message}
					<tr id="message_{$Message.id}" class="title text-center message_head{if $MessID != 999 && $Message.unread == 1} mes_unread{/if}">
						<td>{if $MessID != 999}<input name="messageID[{$Message.id}]" value="1" type="checkbox">{/if}</td>
						<td>{$Message.time}</td>
						<td>{$Message.from}</td>
						<td>{$Message.subject}
							{if $Message.type == 1 && $MessID != 999}
								<a href="#" onclick="return Dialog.PM({$Message.sender}, Message.CreateAnswer('{$Message.subject}'));" class="tooltip" data-tooltip-content="{$LNG.mg_answer_to} {strip_tags($Message.from)}"><i class="far fa-envelope" style="font-size: 15px;"></i>
								</a>
							{/if}
						</td>
					</tr>
				</tbody>
					<tr class="messages_body">
						<td colspan="6" style="padding: 10px; background: rgba(0,0,0,0.3);">
						{$Message.text}
						</td>
					</tr>
					{/foreach}
			</table>
			<hr>
			{if $MessID != 999}
			<div align="center">
				<select class="custom-select" name="actionTop">
					<option value="readmarked">{$LNG.mg_read_marked}</option>
					<option value="readtypeall">{$LNG.mg_read_type_all}</option>
					<option value="readall">{$LNG.mg_read_all}</option>
					<option value="deletemarked">{$LNG.mg_delete_marked}</option>
					<option value="deleteunmarked">{$LNG.mg_delete_unmarked}</option>
					<option value="deletetypeall">{$LNG.mg_delete_type_all}</option>
					<option value="deleteall">{$LNG.mg_delete_all}</option>
				</select>
				<input class="btn btn-dark btn-xs" value="{$LNG.mg_confirm}" type="submit" name="submitTop">
			</div>
			{/if}
			<br>
			<div class="container">
				{$LNG.mg_page}: {if $page != 1}
					<a href="#" class="tooltip" data-tooltip-content="{$LNG.m_back}" onclick="Message.getMessages({$MessID}, {$page - 1});return false;">&laquo;</a>&nbsp;{/if}{for $site=1 to $maxPage}
					<a href="#" onclick="Message.getMessages({$MessID}, {$site});return false;">{if $site == $page}<b class="text-success tooltip" data-tooltip-content="{$LNG.m_now}">[{$site}]</b>{else}[{$site}]{/if}
					</a>
					{if $site != $maxPage}&nbsp;{/if}{/for}{if $page != $maxPage}&nbsp;<a href="#" class="tooltip" data-tooltip-content="{$LNG.m_next}" onclick="Message.getMessages({$MessID}, {$page + 1});return false;">&raquo;</a>{/if}
			</div>
			<hr>
		</table>
	</div>
</form> -->
{/block}
