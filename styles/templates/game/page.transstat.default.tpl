{block name="title" prepend}{$LNG.com_title}{/block}
{block name="content"}
<style>
table.table tbody tr:nth-child(odd) {
  background-color: rgba(138, 43, 226, 0.6);
}

table.table tbody tr:nth-child(even) {
  background-color: rgba(138, 43, 226, 0.3);
}
table.table tbody tr td {
	border: 1px solid black;
}
</style>
<div class="content_page">
<div class="alert alert-info text-center">
	<span style="font-size: 20px;">
        <i class="fas fa-map-signs"></i> {$LNG.com_alert}
    </span>
</div>
	<div class="title">
		{$LNG.com_title_2}
	</div>
	<table style="width:100%;">
		<tbody>
			<tr>
				<td class="transparent" colspan="3" style="text-align:center;">
				<div onclick="tabse(this,'tab0');" id="but0" class="btn btn-success">{$LNG.com_btn_deud}</div>
				<div onclick="tabse(this,'tab1');"  class="btn btn-info">{$LNG.com_btn_pres}</div><br><br></td>
			</tr>
			<tr id="tab0" class="activetab">
				<td colspan="3">
					<table style="width:100%;" class="table">
						<thead>
							<tr class="title">
								<td>
									{$LNG.com_deud_env}
								</td>
								<td>
									{$LNG.com_deud_env_m}
								</td>
								<td>
									{$LNG.com_deud_env_c}
								</td>
								<td>
									{$LNG.com_deud_env_d}
								</td>
								<td>
									{$LNG.com_deud_pag_m}
								</td>
								<td>
									{$LNG.com_deud_pag_c}
								</td>
								<td>
									{$LNG.com_deud_pag_d}
								</td>
								<td>
									{$LNG.com_deud_rest_m}
								</td>
								<td>
									{$LNG.com_deud_rest_c}
								</td>
								<td>
									{$LNG.com_deud_rest_d}
								</td>
							</tr>
						</thead>
						<tbody>
							{foreach $ComercioRecipient as $Reci}
							<tr>
								<td>
									{getUserName($Reci.send)}
								</td>
								<td>
									{if $Reci.sendM == $Reci.devoM}<i class="fas fa-check" style="color: lime;"></i>{else}{$Reci.sendM}{/if}
								</td>
								<td>
									{if $Reci.sendC == $Reci.devoC}<i class="fas fa-check" style="color: lime;"></i>{else}{$Reci.sendC}{/if}
								</td>
								<td>
									{if $Reci.sendD == $Reci.devoD}<i class="fas fa-check" style="color: lime;"></i>{else}{$Reci.sendD}{/if}
								</td>
								<td>
									{if $Reci.sendM == $Reci.devoM}<i class="fas fa-check" style="color: lime;"></i>{else}{$Reci.devoM}{/if}
								</td>
								<td>
									{if $Reci.sendC == $Reci.devoC}<i class="fas fa-check" style="color: lime;"></i>{else}{$Reci.devoC}{/if}
								</td>
								<td>
									{if $Reci.sendD == $Reci.devoD}<i class="fas fa-check" style="color: lime;"></i>{else}{$Reci.devoD}{/if}
								</td>
								<td>
									{if $Reci.difM > 0}{$Reci.difM}{else}<i class="fas fa-check" style="color: lime;"></i>{/if}
									
								</td>
								<td>
									{if $Reci.difC > 0}{$Reci.difC}{else}<i class="fas fa-check" style="color: lime;"></i>{/if}
								</td>
								<td>
									{if $Reci.difD > 0}{$Reci.difD}{else}<i class="fas fa-check" style="color: lime;"></i>{/if}
								</td>
							</tr>
							{foreachelse}
							<tr style="background: none;">
								<td colspan="10">
									<div class="alert alert-info text-center">
										<span style="font-size: 20px;">
									        <i class="fas fa-check"></i> No existen deudas por pagar!!
									    </span>
									</div>
								</td>
							</tr>
							{/foreach}
						</tbody>
					</table>
				</td>
			</tr>
			<tr id="tab1" class="inactivetab">
				<td colspan="3">
					<table style="width:100%;">
						<tr class="title">
							<td>
								{$LNG.com_pres_rec}
							</td>
							<td>
								{$LNG.com_deud_env_m}
							</td>
							<td>
								{$LNG.com_deud_env_c}
							</td>
							<td>
								{$LNG.com_deud_env_d}
							</td>
							<td>
								{$LNG.com_deud_pag_m}
							</td>
							<td>
								{$LNG.com_deud_pag_c}
							</td>
							<td>
								{$LNG.com_deud_pag_d}
							</td>
							<td>
								{$LNG.com_deud_rest_m}
							</td>
							<td>
								{$LNG.com_deud_rest_c}
							</td>
							<td>
								{$LNG.com_deud_rest_d}
							</td>
						</tr>
						{foreach $ComercioSend as $Send}
						<tr>
							<td>
								{getUserName($Send.recipient)}
							</td>
							<td>
									{if $Send.sendM == $Send.devoM}<i class="fas fa-check" style="color: lime;"></i>{else}{$Send.sendM}{/if}
								</td>
								<td>
									{if $Send.sendC == $Send.devoC}<i class="fas fa-check" style="color: lime;"></i>{else}{$Send.sendC}{/if}
								</td>
								<td>
									{if $Send.sendD == $Send.devoD}<i class="fas fa-check" style="color: lime;"></i>{else}{$Send.sendD}{/if}
								</td>
								<td>
									{if $Send.sendM == $Send.devoM}<i class="fas fa-check" style="color: lime;"></i>{else}{$Send.devoM}{/if}
								</td>
								<td>
									{if $Send.sendC == $Send.devoC}<i class="fas fa-check" style="color: lime;"></i>{else}{$Send.devoC}{/if}
								</td>
								<td>
									{if $Send.sendD == $Send.devoD}<i class="fas fa-check" style="color: lime;"></i>{else}{$Send.devoD}{/if}
								</td>
								<td>
									{if $Send.difM > 0}{$Send.difM}{else}<i class="fas fa-check" style="color: lime;"></i>{/if}
									
								</td>
								<td>
									{if $Send.difC > 0}{$Send.difC}{else}<i class="fas fa-check" style="color: lime;"></i>{/if}
								</td>
								<td>
									{if $Send.difD > 0}{$Send.difD}{else}<i class="fas fa-check" style="color: lime;"></i>{/if}
								</td>
						</tr>
						{foreachelse}
							<tr style="background: none;">
								<td colspan="10">
									<div class="alert alert-info text-center">
										<span style="font-size: 20px;">
									        <i class="fas fa-check"></i> No has realizado ningun Prestamo aun!!
									    </span>
									</div>
								</td>
							</tr>
						{/foreach}
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<script>
var aclass = document.getElementById('but0');
var atab = document.getElementById('tab0');
function tabse(geklickt,etab){
	aclass.className ="btn btn-info";
	atab.className = "inactivetab";
	aclass = geklickt;
	atab = document.getElementById(etab);	
	aclass.className = "btn btn-success";
	atab.className = 'activetab';	
	}</script>
{/block}
