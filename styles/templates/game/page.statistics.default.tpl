{block name="title" prepend}{$LNG.lm_statistics}{/block}
{block name="content"}
<span class="ir-arriba fas fa-arrow-up fa-3x"></span>
<!-- <div class="row_alert"><div class="alert alert-warning text-center" style="padding-left: 50px"><i class="fas fa-exclamation-triangle fa-4x pull-left"></i> Esta página se encuentra en mejora por lo que puede sufrir cambios en cualquier momento, en caso de que vea un error no se preocupe intente más tarde. <br>Disculpen las molestias que esto pueda ocasionar</div></div> -->
<div class="content_page" style="width:98%;">
	
	<div class="gray_stripe">
    	{$LNG.st_statistics}  ({$LNG.st_updated}: {$stat_date}) <font style="float:right">{$LNG.stats_next_upd}: <span style="color:#FC0"><b id="brpstats"> <b><font></font></b></b></span></font>
    </div>

	<div>
		<form name="stats" id="stats" method="post" action="">
			<table style="width: 100%; text-align: center;">
				<tr>
					<td style="padding: 10px;">
						<span style="margin-right: 10px;"><label for="who">{$LNG.st_show}</label> <select name="who" id="who" onchange="$('#stats').submit();">{html_options options=$Selectors.who selected=$who}</select></span>
						<span style="margin-right: 10px;"><label for="type">{$LNG.st_per}</label> <select name="type" id="type" onchange="$('#stats').submit();">{html_options options=$Selectors.type selected=$type}</select></span>
						<span><label for="range">{$LNG.st_in_the_positions}</label> <select name="range" id="range" onchange="$('#stats').submit();">{html_options options=$Selectors.range selected=$range}</select></span>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div class="text-center">
		<!-- <div class="title">
			<b>{$LNG.st_leyend}</b>
		</div>
		<p class="pull-left">
			PE: Posición por Estructuras <br>
			PI: Posición por Investigación <br>
			PF: Posición por Flotas <br>
			PD: Posición por Defensa <br>
		</p>
		<p class="pull-right">
			<span style='color:#87CEEB'>*</span> -> Se mantiene en el mismo puesto<br>
			<span style='color:green'>+#</span> -> Cantidad de puesto subidos con su última posición<br>
			<span style='color:red'>-#</span> -> Cantidad de puesto bajados con su última posición<br>
		</p>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<p class="text-center">
			<span style="color: #a0ffa0;">D</span> -> Jugador Débil
			<span style="color: #ffa0a0;">F</span> -> Jugador Fuerte
			<span style="color: #659ec7;">V</span> -> Jugador en Vacaciones
			<span style="color: white;text-decoration: line-through;">B</span> -> Jugador Baneado
			<span style="color: white;">i</span> -> Inactivo 7 días
			<span style="color: white;">I</span> -> Inactivo +7 días
			<span style="color: yellow;"><i class="fas fa-trophy"></i></span> -> Líder de una alianza
		</p> -->
	</div>

	<div>
		<table class="text-center">
			{if $who == 1}
				{include file="shared.statistics.playerTable.tpl"}
			{elseif $who == 2}
				{include file="shared.statistics.allianceTable.tpl"}
			{/if}
		</table>
	</div>
	<script type="text/javascript">
	v = new Date();
	var brpstats = document.getElementById('brpstats');
	function tstats(){
		n  = new Date();
		ss = {$nextStatUpdate};
		s  = ss - Math.floor( (n.getTime() - v.getTime()) / 1000);
		m  = 0;
		h  = 0;
		d  = 0;
		if ( s < 0 ) {
			   var zeit = new Date();
			var ende = zeit.getTime();
			ende = ende + 100;
		
			function countdown() {
		
				var zeit2 = new Date();
				var jetzt = zeit2.getTime();
		
				if(jetzt >= ende) {
				   brpstats.innerHTML = '<blink><b><font color=red>...</font></b></blink>';
				}
		
			}
		
			setInterval(countdown, 1000);
		} else 
		{
			   if ( s > 59 ) { m = Math.floor( s / 60 ); s = s - m * 60; }
			   if ( m > 59 ) { h = Math.floor( m / 60 ); m = m - h * 60; }
			   if ( h > 24 ) { d = Math.floor( h / 24 ); h = h - d * 24; }
			   if ( s < 10 ) { s = '0' + s }
			   if ( m < 10 ) { m = '0' + m }
			   if ( h < 10 ) { h = '' + h }
			   if ( s >= 0 ) { s = s + 's' }
			   if ( m > 0 ) { m = m + 'm' }  else m = '';
			   if ( m == 0 && h > 0 ) { m = '0' + m + 'm'}
			   if ( h > 0 ) { h = h + 'h' }  else h = '';
			   if ( d > 0 ) { d = d + 'd' }  else d = '';
		
			   brpstats.innerHTML = ' <b><font>' + d + ' ' + h + ' ' + m + ' ' + s + '</font></b>';
		}
		window.setTimeout('tstats();',999);
	}
	window.onload=tstats();
</script>
</div>
{/block}


