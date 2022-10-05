{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
	
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['ingame_setting']}</span> - Compras realizadas</h4>
						</div>

						<div class="heading-elements">
							<div class="heading-btn-group">
								<a href="admin.php" class="btn btn-link btn-float has-text"><i class="fa fa-home fa-2x text-primary"></i><span>{$LNG['home']}</span></a>
								<a href="admin.php?page=universe&sid={session_id()}" class="btn btn-link btn-float has-text"><i class="fa fa-stroopwafel fa-2x text-primary"></i><span>{$LNG['mu_universe']}</span></a>
								<a href="admin.php?page=rights&mode=rights&sid={session_id()}" class="btn btn-link btn-float has-text"><i class="fa fa-users fa-2x text-primary"></i><span>{$LNG['mu_moderation_page']}</span></a>>
								<a href="admin.php?page=reset&sid={session_id()}" class="btn btn-link btn-float has-text"><i class="fa fa-undo fa-2x text-primary"></i><span>{$LNG['re_reset_universe'] }</span></a>
							</div>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="admin.php"><i class="icon-home2 position-left"></i> {$LNG['home']}</a></li>
							<li><a href="admin.php?page=shop">{$LNG['ingame_setting']}</a></li>
							<li>Compras realizadas</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li><a href="mailto:rayco.garcia13@nauta.cu"><i class="icon-comment-discussion position-left"></i> {$LNG['ow_support']}</a></li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
							<!-- Advanced legend -->
								<div class="panel panel-flat">
									<div class="panel-body">
										<fieldset>
											<legend class="text-semibold">
												<i class="icon-file-text2 position-left"></i>
												Compras realizadas
												<a class="control-arrow" data-toggle="collapse" data-target="#Frame8">
													<i class="icon-circle-down2"></i>
												</a>
											</legend>
 
											<div class="collapse in" id="Frame8">
												
												<div class="table-responsive">
												<table class="table table-bordered table-hover datatable-highlight">
													<thead>
														<tr>
															<th>#</th>
															<th>Usuario</th>
															<th>Costo</th>
															<th>Moneda</th>
															<th>Bono</th>
															<th>Cantidad</th>
															<th>Fecha</th>
															<th>...</th>
														</tr>
													</thead>
													<tbody>
														{foreach $compras as $key=>$item}
														<tr>
															<td>{$key+1}</td>
															<td>{$item.username}</td>
															<td>{$item.price}</td>
															<td style="text-transform: uppercase;">{$item.coin}</td>
															<td style="text-transform: uppercase;">{$item.title}</td>
															<td>{$item.premium}</td>
															<td>{date('d/m/Y h:m:s',$item.fecha)}</td>
															<td class="text-center">
																{if $item.concluido == 0}
																<button onclick="send({$item.id},'aprove')" title="Realizar pago" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
																<button onclick="send({$item.id},'denied')"  title="Denegar pago" class="btn btn-danger btn-xs"><i class="fa fa-ban"></i></button>
																{else}
																...
																{/if}
															</td>
														</tr>
														{/foreach}
													</tbody>
												</table>
												</div>
											</div>
										</fieldset>
										
									</div>
								</div>
							<!-- /a legend -->
						
<script>
	function send(id,status){
		let res = false;
		if(status == 'aprove')
			res = confirm('Está seguro que desea aceptar dicho pago');
		else
			res = confirm('Está seguro que desea denegar dicho pago');

		if(res)
		{
			// let cantidad = prompt("Inserte la cantidad a regalar por concpeto interno",0);
			do{
			    var cantidad = parseInt(window.prompt("Inserte la cantidad a regalar por concpeto interno", 0), 10);
			}while(isNaN(cantidad));

			// alert(cantidad);
			document.location = 'admin.php?page=shop&action='+status+'&id='+id+'&extra='+cantidad;
		}
	}
</script>
{include file="overall_footer.tpl"}