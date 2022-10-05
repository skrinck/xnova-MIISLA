{include file="overall_header.tpl"}
<script type="text/javascript">
function check(){
	$.post('?page=qeditor&edit=planet&id={$id}&action=send', $('#userform').serialize(), function(data){
		alert(data)
                
                opener.location.reload();
                window.close();
	});
	return false;
}
</script>
<div class="panel panel-flat" style="color:black">
                        <div class="panel-body">
<form method="post" id="userform" action="" onsubmit="return check();">
<table width="100%"><tr>
        <th colspan="3">{$LNG.qe_info}</th>
</tr>
<tr style="height:26px;"><td width="50%">{$LNG.qe_id}:</td><td width="50%">{$id}</td></tr>
<tr><td width="50%">{$LNG.qe_planetname}:</td><td width="50%"><input name="name" type="text" size="15" value="{$name}"></td></tr>
<tr style="height:26px;"><td width="50%">{$LNG.qe_coords}:</td><td width="50%">[{$galaxy}:{$system}:{$planet}]</td></tr>
<tr style="height:26px;"><td width="50%">{$LNG.qe_owner}:</td><td width="50%">{$ownername} ({$LNG.qe_id}: {$ownerid})</td></tr>
<tr><td width="50%">{$LNG.qe_fields}:</td><td width="50%">{$field_min} / <input name="field_max" type="text" size="3" value="{$field_max}"></td></tr>
<tr style="height:26px;"><td width="50%">{$LNG.qe_temp}:</td><td width="50%">{$temp_min} / {$temp_max}</td></tr>
</table>
<table width="100%">
<tr>
        <th colspan="3">{$LNG.qe_resources}</th>
</tr>
<tr>
        <td></td><td>{$LNG.qe_count}</td><td>{$LNG.qe_input}</td>
</tr>
<tr><td width="30%">{$LNG.tech.901}:</td><td width="30%">{$metal_c}</td><td width="40%"><input name="metal" type="text" value="{$metal}"></td></tr>
<tr><td width="30%">{$LNG.tech.902}:</td><td width="30%">{$crystal_c}</td><td width="40%"><input name="crystal" type="text" value="{$crystal}"></td></tr>
<tr><td width="30%">{$LNG.tech.903}:</td><td width="30%">{$deuterium_c}</td><td width="40%"><input name="deuterium" type="text" value="{$deuterium}"></td></tr>
</table>
<table width="100%">
<tr>
        <th colspan="3">{$LNG.qe_build}</th>
</tr>
<tr>
        <td></td><td>{$LNG.qe_level}</td><td>{$LNG.qe_input}</td>
</tr>
{foreach item=Element from=$build}
<tr><td width="30%">{$Element.name}:</td><td width="30%">{$Element.count}</td><td width="40%"><input name="{$Element.type}" type="text" value="{$Element.input}"></td>
{/foreach}
</table>
<table width="100%">
<tr>
        <th colspan="3">{$LNG.qe_fleet}</th>
</tr>
<tr>
        <td></td><td>{$LNG.qe_count}</td><td>{$LNG.qe_input}</td>
</tr>
{foreach item=Element from=$fleet}
<tr><td width="30%">{$Element.name}:</td><td width="30%">{$Element.count}</td><td width="40%"><input name="{$Element.type}" type="text" value="{$Element.input}"></td>
{/foreach}
</table>
<table width="100%">
<tr>
        <th colspan="3">{$LNG.qe_defensive}</th>
</tr>
<tr>
        <td></td><td>{$LNG.qe_count}</td><td>{$LNG.qe_input}</td>
</tr>
{foreach item=Element from=$defense}
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
