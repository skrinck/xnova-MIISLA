{block name="title" prepend}{$LNG.lm_shop}{/block}
{block name="content"}
<span class="ir-arriba fas fa-arrow-up fa-3x"></span>
<div class="container content_page">
	<div class="title"><b>{$LNG.lm_shop}</b></div>
		<div>
			<div class="alert alert-info text-center"><h4>Bonos:<br>1- Móvil+1000MO<br>2-Nauta+1000MO<br> 3-Tarjeta+2000MO</h4></div>
		</div>
		<hr>

		{if $msg != ''}
		<div class="alert alert-danger text-uppercase text-center" role="alert">
		  {$msg}
		</div>
		{/if}
		<div class="container">
			<div class="row">
				<div class="col-lg-4 offset-lg-4 text-center">
					<h2>Paquetes</h2>
					<hr>
				</div>
			</div>
			<section class="pricing">
				<div class="row">
					{foreach $bonus as $item}
					<div class="col">
	                    <div class="card1 mb-5">
						    <div class="card-body">
						        <h5 class="card-title text-uppercase text-center">{$item['title']}</h5>
						        <hr class="bg-white mt-1">
						        <h6 class="card-price text-center mt-4">{number_format((float)$item['price'],2,'.','')}</h6>
						        <p class="text-center period mb-0">{$item['coin']}</p>
						        <ul class="ul text-center list-unstyled">
						            <li>{pretty_number($item['premium'])} de {$LNG['tech'][$item['resource']]}</li>
						            <li>{$item['min_time']} días</li>			            
						        </ul>
						        <button onclick="send({$item.id})" {if !$aviable}disabled{/if} class="btn btn-block btn-outline-light text-uppercase">Solicitar</button>
						    </div>
						</div>
					</div>
					{/foreach}
				</div>
				{if !$aviable}
					<br>
					<div class="alert alert-info text-center">
						<i class="fas fa-bullhorn fa-2x align-middle"></i> Para solicitar próximo paquete es el <a style="color: red"><b>{$tiempo}</a> Horas del Servidor</b>
					</div>
				{/if}
			</section>
		</div>
	</div>
</div>

<script>
	function send(id){
		let	res = confirm('Está seguro que desea solicitar este bono?');
		if(res)
		{
			document.location = 'game.php?page=shop&bono='+id;
		}
	}
</script>
{/block}