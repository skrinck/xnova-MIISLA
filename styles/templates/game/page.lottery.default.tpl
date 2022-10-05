{block name="title" prepend}{$LNG.lm_lottery}{/block}
{block name="content"}
<div class="content_page" style="width:90%">
		<table style="width:100%">
				<div class="title text-center font-weight-bold">{$LNG.lm_lottery}</div>
				<div class="alert alert-info text-center"><i class="fas fa-exclamation-triangle fa-2x align-middle"></i> 
				{$descripcion}
				</div>
		</table>
		<table style="width:100%; margin-bottom:10px">
			<div class="title font-weight-bold">Descripición de la rifa</div>
				<div id="traderContainer" class="centerContainer" style="margin-top:10px;">
					<div class="row" style="margin:auto">
						<div class="col-md-4" style="">
							<div class="title">Precio por Boleto</div>
							<div class="">
								<img src="{$dpath}images/{$resources.901}.gif" border="0" height="30" width="30" style="margin: 3px;">
								{$LNG.tech.901}: ${$ticket_price_metal|number}
							</div>
							<div class="">
								<img src="{$dpath}images/{$resources.902}.gif" border="0" height="30" width="30" style="margin: 3px;">
								{$LNG.tech.902}: ${$ticket_price_crystal|number}
							</div>
							<div class="">
								<img src="{$dpath}images/{$resources.903}.gif" border="0" height="30" width="30" style="margin: 3px;">
								{$LNG.tech.903}: ${$ticket_price_deuterium|number}
							</div>
							<div class="">
								<img src="{$dpath}images/{$resources.921}.gif" border="0" height="30" width="30" style="margin: 3px;">
								{$LNG.tech.921}: ${$ticket_price_mo|number}
							</div>
						</div>
						<div class="col-md-4">
							<div class="title">Premios</div>
							<div class="">
								<img src="{$dpath}images/{$resources.901}.gif" border="0" height="30" width="30" style="margin: 3px;">
								{$LNG.tech.901}: ${$gan_metal|number}  - <span class="text-danger">({($gan_metal*$mios)|pretty_number})</span>
							</div>
							<div class="">
								<img src="{$dpath}images/{$resources.902}.gif" border="0" height="30" width="30" style="margin: 3px;">
								{$LNG.tech.902}: ${$gan_crystal|number} - <span class="text-danger">({($gan_crystal*$mios)|pretty_number})</span>
							</div>
							<div class="">
								<img src="{$dpath}images/{$resources.903}.gif" border="0" height="30" width="30" style="margin: 3px;">
								{$LNG.tech.903}: ${$gan_deu|number} - <span class="text-danger">({($gan_deu*$mios)|pretty_number})</span>
							</div>
							<div class="">
								<img src="{$dpath}images/{$resources.921}.gif" border="0" height="30" width="30" style="margin: 3px;">
								{$LNG.tech.921}: ${$gan_mato|number} - <span class="text-danger">({($gan_mato*$mios)|pretty_number})</span>
							</div>
						</div>
						<div class="col-md-4" style="margin:auto;margin-top:0px;">
							<div class="title">Inscribirse</div>
							{if !$terminado}
								<center><span class="countdown2" style="font-size:2em;" secs="{$secs}"></span></center><div class="text-center">
									<form action="" method="POST">
										<input type="hidden" name="inscribirse" value="si"><button type="submit" href="" style="margin-top:10%" class="btn btn-dark btn-xs pulse"><i class="fas fa-check"></i> Inscribirse</button>
									</form>
								</div>
							{else}
								<div class="text-center">
									<div style="margin-top:10%"> Evento Terminado</div>
								</div>
							{/if}
							<div class="text-center">
								<div style="margin-top:10%"> BOLETOS COMPRADOS <br> <span class="text-success">{$mios}</span>/<span class="text-danger">{$max}<span></div>
							</div>
						</div>
					</div>
				</div>
			<div>
		</table>
		<table style="width:100%">
			<div class="title text-center font-weight-bold">Jugadores</div>
				<div class="row" style="margin:auto;margin-top:10px;">
					<div class="col-md-8" style="margin:auto;margin-top:0px;">
						<div class="title">{$userinscritos} Usuarios Inscritos</div>
						<div style="height:100%;padding:0 10px 0 10px; text-align:justify">
							{foreach $inscritos as $item}
								{$item['user']}({$item['cant']}),
							{/foreach}
						</div>
					</div>
					<div class="col-md-4">
						<div class="title">Ganador</div>
						{if !is_array($ganador)}
							<div class="{if !is_array($ganador)}text-center{/if} text-center" style="height:100%;margin-bottom:10px;">
								{if is_array($ganador)}
									{foreach $ganador as $key=>$item}
										{if $key == 0}
											<div style="margin-top:10%"> <img src="styles/theme/gow/premios/oro.png" width="50"> {$item[0]} - {$item[1]} </div>
										{else if $key == 1}
											<div style="margin-top:10%"> <img src="styles/theme/gow/premios/plata.png" width="50"> {$item[0]} - {$item[1]} </div>
										{else if $key == 2}
											<div style="margin-top:10%"> <img src="styles/theme/gow/premios/bronce.png" width="50"> {$item[0]} - {$item[1]} </div>
										{else}
											<div style="margin-top:10%"><img src="styles/theme/gow/premios/medalla.png" width="50"> {$item[0]} - {$item[1]} </div>
										{/if}
									{/foreach}
								{else}
									<div style="margin-top:10%">{$ganador}</div>
								{/if}
							</div>
						{/if}
					</div>

				</div>
				<div class="clear"></div>
		</table>
	</div>
{/block}