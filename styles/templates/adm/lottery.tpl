{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['mu_users_settings']}</span> - {$LNG['mu_lottery']}</h4>
						</div>

						<div class="heading-elements">
							<div class="heading-btn-group">
								<a href="admin.php" class="btn btn-link btn-float has-text"><i class="fa fa-home fa-2x text-primary"></i><span>{$LNG['home']}</span></a>
								<a href="admin.php?page=universe&sid={session_id()}" class="btn btn-link btn-float has-text"><i class="fa fa-stroopwafel fa-2x text-primary"></i><span>{$LNG['mu_universe']}</span></a>
								<a href="admin.php?page=rights&mode=rights&sid={session_id()}" class="btn btn-link btn-float has-text"><i class="fa fa-users fa-2x text-primary"></i><span>{$LNG['mu_moderation_page']}</span></a>
								<a href="admin.php?page=reset&sid={session_id()}" class="btn btn-link btn-float has-text"><i class="fa fa-undo fa-2x text-primary"></i><span>{$LNG['re_reset_universe'] }</span></a>
							</div>
						</div>
					</div>
					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="admin.php"><i class="icon-home2 position-left"></i> {$LNG['home']}</a></li>
							<li><a href="admin.php?page=accountdata">{$LNG['mu_users_settings']}</a></li>
							<li>{$LNG['mu_lottery']}</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li><a href="mailto:rayco.garcia13@nauta.cu"><i class="icon-comment-discussion position-left"></i> {$LNG['ow_support']}</a></li>
						</ul>
					</div>
				</div>
				<!-- /page header -->
	<div class="content">
	<div class="panel panel-flat">
	<div class="panel-body">
			<fieldset>
				<legend class="text-semibold">
					<i class="icon-file-text2 position-left"></i>
					Descripición de la lotería
					<a class="control-arrow" data-toggle="collapse" data-target="#Frame1">
						<i class="icon-circle-down2"></i>
					</a>
				</legend>
				<div class="collapse in" id="Frame1">
		<table>
			<form method="post" id="formSend">
				<input type="hidden" name="action" value="send">
				<!-- Zielplaneten definieren -->
					<div id="traderContainer" class="centerContainer" style="margin-top:10px;">
							<div class="row" style="margin:auto">
								<div class="col-md-4" style="">
									<div class="title">Costo</div>
									<div class="row">
										<div class="col-md-12">
											<div class="row">
												<div class="">
													<img src="{$dpath}images/{$resources.901}.gif" border="0" height="30" width="30" style="margin: 3px;">
													{$LNG.tech.901}: 
												</div>
												<input type="text" name="precio_metal" value="{$ticket_price_metal}" class="align-middle form-control">
											</div>
											<div class="row">
												<div class="">
													<img clas="col-md-2" src="{$dpath}images/{$resources.902}.gif" border="0" height="30" width="30" style="margin: 3px;">
												{$LNG.tech.902}: 
												</div>
												<input type="text" name="precio_crystal" value="{$ticket_price_crystal}" class="align-middle form-control">
											</div>
											<div class="row">
												<div class="">
													<img src="{$dpath}images/{$resources.903}.gif" border="0" height="30" width="30" style="margin: 3px;">
														{$LNG.tech.903}:
												</div>
												<input type="text" name="precio_deut" value="{$ticket_price_deuterium}" class="align-middle form-control">
											</div>
											<div class="row">
												<div class="">
													<img src="{$dpath}images/{$resources.921}.gif" border="0" height="30" width="30" style="margin: 3px;">
													<span style="font-size:0.9em">{$LNG.tech.921}:</span>
												</div>
												<input type="text" name="precio_mo" value="{$ticket_price_mo}" class="align-middle form-control">
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="title">Premio</div>
									<div class="col-md-12">
											<div class="row">
												<div class="">
													<img src="{$dpath}images/{$resources.901}.gif" border="0" height="30" width="30" style="margin: 3px;">
													{$LNG.tech.901}: 
												</div>
												<input type="text" name="gan_metal" value="{$gan_metal}" class="align-middle form-control">
											</div>
											<div class="row">
												<div class="">
													<img src="{$dpath}images/{$resources.902}.gif" border="0" height="30" width="30" style="margin: 3px;">
												{$LNG.tech.902}: 
												</div>
												<input type="text" name="gan_crystal" value="{$gan_crystal}" class="align-middle form-control">
											</div>
											<div class="row">
												<div class="">
													<img src="{$dpath}images/{$resources.903}.gif" border="0" height="30" width="30" style="margin: 3px;">
														{$LNG.tech.903}:
												</div>
												<input type="text" name="gan_deut" value="{$gan_deu}" class="align-middle form-control">
											</div>
											<div class="row">
												<div class="">
													<img src="{$dpath}images/{$resources.921}.gif" border="0" height="30" width="30" style="margin: 3px;">
													<span style="font-size:0.9em">{$LNG.tech.921}:</span>
												</div>
												<input type="text" name="gan_mo" value="{$gan_mato}" class="align-middle form-control">
											</div>
											<div class="row">
												<div class="" title="inscritos por transferencia">
													<img src="{$dpath}images/{$resources.921}.gif" border="0" height="30" width="30" style="margin: 3px;">
													<span style="font-size:0.9em">Regalo MO:</span>
												</div>
												<input type="text" name="regalo_mo" value="{$regalo}" class="align-middle form-control">
											</div>
										</div>
								</div>
								<div class="col-md-4">
									<div class="title">Configuración</div>
										{if !$terminado}
										<center><span class="countdown2" style="font-size:2em;" secs="{$secs}"></span></center>
										<div class="text-center">
												<input type="hidden" name="loteria" value="finish">
												<button type="submit" href="" style="margin-top:10%" class="btn btn-danger btn-xs"><i class="fas fa-ban"></i> Terminar Lotería</button>
										</div>
										{else}
										<div class="text-center">
											<div class="form-group">
												<label class="col-md-5 pull-left">Cantidad de ganadores</label>
												<input class="form-control col-md-7 text-center" value="{$ganadores}" type="text" name="cant_ganad">
											</div>
											<br/>
											<div class="form-group">
												<label class="col-md-5 pull-left">Porcentaje descuento</label>
												<input class="form-control col-md-7 text-center" value="{$percent}" type="text" name="percent_desc">
											</div>
											<br/>
											<div class="form-group">
												<label class="col-md-5 pull-left">Cantidad de Horas</label>
												<input class="form-control col-md-7 text-center" value="{$horas}" type="text" name="cant_horas">
											</div>
											<br/>
											<div class="form-group">
												<label class="col-md-5 pull-left">Máximo de tickets</label>
												<input class="form-control col-md-7 text-center" value="{$maximo}" type="text" name="max_tickets">
											</div>
											<br/>
											<div class="form-group">
												<label class="col-md-5 pull-left">Descripción</label>
												<textarea class="form-control col-md-7" name="descr" style="font-size:1em;background-color: rgb(33, 36, 40); color: #bcbcbc; height:100px">{$descr}</textarea>
											</div>
											<input type="hidden" name="loteria" value="start">
											<button type="submit" style="margin-top:10%" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Nueva Lotería</button>
										</div>
										{/if}
								</div>
							</div>
							<hr style="line-dashed">
					</div>
			</form>

					<table style="width:100%">
					<div class="title text-center font-weight-bold">Jugadores</div>
						<div class="row" style="margin:auto;margin-top:10px;">
							<div class="col-md-4">
								<div class="title">Usuarios Inscritos</div>
								<div id="listado" style="height:100%;padding:0 10px 0 10px; text-align:justify">
									{foreach $inscritos as $item}
										{$item['user']}({$item['cant']}),
									{/foreach}
								</div>
							</div>
							<div class="col-md-4">
								<div class="title">Inscribir por Transferencia</div>
								<div style="height:100%;padding:0 10px 0 10px; text-align:justify">
									{if !$terminado}
									<form id="registerForm" method="POST" action="admin.php?page=lotteryReg">
										<div class="form-group">
											<select name="user" required id="seluser" size="20" style="width:100%;height:100px;">
												{$UserList}
											</select>
											<script>
												var UserList = new filterlist(document.getElementsByName('user')[0]);
											</script>
										</div>
										<div class="form-group">
											<label class="col-md-3 pull-left" style="font-size:1.3em">Filtrar</label>
											<input type="text" class="form-control col-md-9" name="regexp" onKeyUp="UserList.set(this.value)">
										</div>
										<br>
										<div class="form-group">
											<label class="col-md-3 pull-left" style="font-size:1.3em">Cantidad</label>
											<input type="number" required id="cantidad" class="form-control col-md-9" name="cantidad">
										</div>
										<div class="text-center">
											<button type="submit" class="btn btn-xs btn-info"><i class="fas fa-check"></i> Registrar</button>
										</div>
										</form>
										{/if}
								</div>
							</div>
							<div class="col-md-4">
								<div class="title">Ganador</div>
								<div class="text-center" style="height:100%">
										<div style="margin-top:10%"> {$ganador}</div>
								</div>
							</div>

						</div>
						<div class="clear"></div>
				</table>
		</table>
		</div>
		<fieldset>
	</div>
	</div>
	</div>
	</div>
	</div>
	
{include file="overall_footer.tpl"}