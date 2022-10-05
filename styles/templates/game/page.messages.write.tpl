{block name="title" prepend}{$LNG.write_message}{/block}
{block name="content"}

<div class="content_page_popup">
    <div class="title_popup">
        {$LNG.mg_send_new}
    </div>

    <div class="content_popup">
        <form name="message" id="message" action="" method="">
        <input type="hidden" name="id" value="{$id}">
            <table style="width:100%;">
                <tr style="height:20px;">
                    <td>{$LNG.mg_send_to}</td>
                    <td><input type="text" name="to" size="40" value="{$OwnerRecord.username} [{$OwnerRecord.galaxy}:{$OwnerRecord.system}:{$OwnerRecord.planet}]"></td>
                </tr>
                <tr>
					<td>{$LNG.mg_subject}</td>
					<td style="width:70%"><input type="text" name="subject" id="subject" size="40" maxlength="40" value="{if !empty($subject)}{$subject}{else}{$LNG.mg_no_subject}{/if}"></td>
				</tr>
                <tr>
                    <td>{$LNG.mg_message}(<span id="cntChars">0</span> / 5000 {$LNG.bu_characters})</td>
                    <td><textarea style="height: 215px;" name="text" id="text" cols="40" rows="10" size="100" onkeyup="$('#cntChars').text($(this).val().length);"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2"><input id="submit" type="button" class="btn btn-dark btn-xs" onClick="check();" name="button" value="{$LNG.mg_send}"></td>
                </tr>
            </table>
        </form>
    </div>
</div>

{/block}
{block name="script" append}
<script type="text/javascript">
function check(){
	if($('#text').val().length == 0) {
		alert('{$LNG.mg_empty_text}');
		return false;
	} else {
		$('submit').attr('disabled','disabled');
		$.post('game.php?page=messages&mode=send&id={$id}&ajax=1', $('#message').serialize(), function(data) {
			alert(data);
			parent.$.fancybox.close();
			return true;
		}, 'json');
	}
}
</script>
{/block}