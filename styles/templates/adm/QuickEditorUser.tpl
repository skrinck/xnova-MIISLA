{include file="overall_header.tpl"}
<script type="text/javascript">
function check(){
	$.post('?page=qeditor&edit=player&id={$id}&action=send', $('#userform').serialize(), function(data){
		alert(data, function() {
		});
                opener.location.reload();
                window.close();
	});
	return false;
}
</script>
                <div class="panel panel-flat">
                        <div class="panel-body">
                                <form method="post" id="userform" action="" onsubmit="return check();">
<table width="100%" style="color:#FFFFFF"><tr>
        <th colspan="3">{$LNG.qe_info}</th>
</tr>
<tr style="height:26px;"><td width="50%">{$LNG.qe_id}:</td><td width="50%">{$id}</td></tr>
<tr><td width="50%">{$LNG.qe_username}:</td><td width="50%"><input name="name" type="text" size="15" value="{$name}" autocomplete="off"></td></tr>
<tr style="height:26px;"><td width="50%">{$LNG.qe_hpcoords}:</td><td width="50%">{$planetname} [{$galaxy}:{$system}:{$planet}] ({$LNG.qe_id}: {$planetid})</td></tr>
{if $authlevl != $smarty.const.AUTH_USER}
<tr style="height:26px;"><td width="50%">{$LNG.qe_authattack}:</td><td width="50%"><input type="checkbox" name="authattack"{if $authattack != 0} checked{/if}></td></tr>
{/if}
{if $ChangePW}
<tr style="height:26px;"><td width="50%">{$LNG.qe_password}:</td><td width="50%"><a href="#" onclick="$('#password').css('display', '');$(this).css('display', 'none');return false">{$LNG.qe_change}</a><input style="display:none;" id="password" name="password" type="password" size="15" value="" autocomplete="off"></td></tr>
{/if}
{if $ChangePW}
<tr style="height:26px;"><td width="50%">{$LNG.qe_allowmulti}:</td><td width="50%">{html_options name="multi" options=$LNG.one_is_no selected=$multi}</td></tr>
{/if}
{if $ChangePW}
<tr><td width="30%">{$LNG.qe_comment}:</td><td width="10%"><input name="isChat" type="text" value="{$isChat}"> 1= Desactivar / 0= Activar</td> </tr>
{/if}
{if $ChangePW}
<tr><td width="30%">{$LNG.qe_mp}:</td><td width="10%"><input name="isMP" type="text" value="{$isMP}"> 1= Desactivar / 0= Activar</td> </tr>
{/if}

</table>
<table width="100%" style="color:#FFFFFF">
<tr>
        <th colspan="3">{$LNG.qe_resources}</th>
</tr>
<tr>
        <td>{$LNG['qe_name']}</td><td>{$LNG.qe_count}</td><td>{$LNG.qe_input}</td>
</tr>
<tr><td width="30%">{$LNG.tech.921}:</td><td width="30%">{$darkmatter_c}</td><td width="40%"><input name="darkmatter" type="text" value="{$darkmatter}"></td></tr>
</table>
<table width="100%" style="color:#FFFFFF">
<tr>
        <th colspan="3">{$LNG.qe_tech}</th>
</tr>
<tr>
        <td>{$LNG.qe_name}</td><td>{$LNG.qe_level}</td><td>{$LNG.qe_input}</td>
</tr>
{foreach item=Element from=$tech}
<tr><td width="30%">{$Element.name}:</td><td width="30%">{$Element.count}</td><td width="40%"><input name="{$Element.type}" type="text" value="{$Element.input}"></td>
{/foreach}
<tr>
        <th colspan="3">{$LNG.qe_officier}</th>
</tr>
<tr>
        <td>{$LNG.qe_name}</td><td>{$LNG.qe_level}</td><td>{$LNG.qe_input}</td>
</tr>
{foreach item=Element from=$officier}
<tr><td width="30%">{$Element.name}:</td><td width="30%">{$Element.count}</td><td width="40%"><input name="{$Element.type}" type="text" value="{$Element.input}"></td>
{/foreach}
<tr>
        <td colspan="3">
        <button type="submit" class="btn btn-primary">{$LNG.qe_submit} <i class="icon-arrow-right14 position-right"></i></button>
        <button type="reset" class="btn btn-danger">{$LNG.qe_reset} <i class="fa fa-ban"></i></button>
        </td>
</tr>
</table>
</form>
        </div>
</div>
<script>
        $('input,select').css('background-color','rgb(33, 36, 40)');
        $('input,select').css('color','#bcbcbc')
        $('input,select').css('border','0 none')
        $('input,select').css('border-radius','3px'),
        $('input,select').css('height','30px')
        $('input,select').css('padding-left','5px')
        $('input,select').css('margin-bottom','5px')
        $('input,select').css('font-family','"Open Sans", sans-serif');
                  
        $('#userform').parent().css("background-image","url(styles/theme/gow/img/sfondonuovo.jpg)");
        $('body').css('padding','20px')
        $('form').css('border','1px solid #ccc');
        $('form').css('padding','10px 50px 10px 50px');
        $('th').css('text-align','center');
        $('th').css('background-color','#28292a');
        $('th').css('padding','3px');
        $('th').css('margin','10px');
        $('th').css('border','1.5px solid #000');

        $('body').css('color','#DDD')
        $('body').css('font-size','1.1em')
</script>
