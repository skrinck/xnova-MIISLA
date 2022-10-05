{block name="title" prepend}{$LNG.lm_top}{/block}
{block name="content"}
<span class="ir-arriba fas fa-arrow-up fa-3x"></span>
<div class="container content_page" style="width: 98%">
	<div class="title"><b>{$LNG.lm_top}</b></div>
		<div>
			<div class="alert alert-info text-center">Los Ranking de <b>Mas Perdidas</b>, <b>Mas Empatadas</b> y <b>Mas Unidades Perdidas</b> no serán <b>PREMIADOS</b>!!!</div>
		</div>
		<hr>
		<div class="container">
				<div class="row">
					<div class="col-lg-4 offset-lg-4 text-center">
						<h2>Batallas</h2>
						<hr>
					</div>
				</div>
			<div class="row">
				<div class="col-lg-4 text-center" style="margin-top: 30px">
					<div class="title">Mas Ganadas</div>
					{foreach $ganadores as $key => $value}
						{if $key == 0}
							<div style="margin-top:1%;text-align:left;margin-left:50px" > <img src="styles/theme/gow/premios/oro.png" width="45"> {$ganadores[$key]['username']} - {$ganadores[$key]['wons']}</div>
						{else if $key == 1}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/plata.png" width="45"> {$ganadores[$key]['username']} - {$ganadores[$key]['wons']}</div>
						{else if $key == 2}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/bronce.png" width="45"> {$ganadores[$key]['username']} - {$ganadores[$key]['wons']}</div>
						{/if}
					{/foreach}
				</div>
				<div class="col-lg-4 text-center" style="margin-top: 30px">
					<div class="title">Mas Perdidas</div>
					{foreach $perdedores as $key => $value}
						{if $key == 0}
							<div style="margin-top:1%;text-align:left;margin-left:50px" > <img src="styles/theme/gow/premios/oro.png" width="45"> {$perdedores[$key]['username']} - {$perdedores[$key]['loos']}</div>
						{else if $key == 1}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/plata.png" width="45"> {$perdedores[$key]['username']} - {$perdedores[$key]['loos']}</div>
						{else if $key == 2}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/bronce.png" width="45"> {$perdedores[$key]['username']} - {$perdedores[$key]['loos']}</div>
						{/if}
					{/foreach}
				</div>
				<div class="col-lg-4 text-center" style="margin-top: 30px">
					<div class="title">Mas Empatadas</div>
					{foreach $empatadores as $key => $value}
						{if $key == 0}
							<div style="margin-top:1%;text-align:left;margin-left:50px" > <img src="styles/theme/gow/premios/oro.png" width="45"> {$empatadores[$key]['username']} - {$empatadores[$key]['draws']}</div>
						{else if $key == 1}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/plata.png" width="45"> {$empatadores[$key]['username']} - {$empatadores[$key]['draws']}</div>
						{else if $key == 2}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/bronce.png" width="45"> {$empatadores[$key]['username']} - {$empatadores[$key]['draws']}</div>
						{/if}
					{/foreach}
				</div>

				<div class="col-lg-4 text-center" style="margin-top: 30px">
					<div class="title">Mas Escombros Metal</div>
					{foreach $metal as $key => $value}
						{if $key == 0}
							<div style="margin-top:1%;text-align:left;margin-left:50px" > <img src="styles/theme/gow/premios/oro.png" width="45"> {$metal[$key]['username']} - {pretty_number($metal[$key]['kbmetal'])}</div>
						{else if $key == 1}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/plata.png" width="45"> {$metal[$key]['username']} - {pretty_number($metal[$key]['kbmetal'])}</div>
						{else if $key == 2}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/bronce.png" width="45"> {$metal[$key]['username']} - {pretty_number($metal[$key]['kbmetal'])}</div>
						{/if}
					{/foreach}
				</div>
				<div class="col-lg-4 text-center" style="margin-top: 30px">
					<div class="title">Mas Escombros Cristal</div>
					{foreach $cristal as $key => $value}
						{if $key == 0}
							<div style="margin-top:1%;text-align:left;margin-left:50px" > <img src="styles/theme/gow/premios/oro.png" width="45"> {$cristal[$key]['username']} - {pretty_number($cristal[$key]['kbcrystal'])}</div>
						{else if $key == 1}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/plata.png" width="45"> {$cristal[$key]['username']} - {pretty_number($cristal[$key]['kbcrystal'])}</div>
						{else if $key == 2}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/bronce.png" width="45"> {$cristal[$key]['username']} - {pretty_number($cristal[$key]['kbcrystal'])}</div>
						{/if}
					{/foreach}
				</div>
				<div class="col-lg-4 text-center" style="margin-top: 30px">
					<div class="title">Mas Unidades Destruidas</div>
					{foreach $udestruidas as $key => $value}
						{if $key == 0}
							<div style="margin-top:1%;text-align:left;margin-left:50px" > <img src="styles/theme/gow/premios/oro.png" width="45"> {$udestruidas[$key]['username']} - {pretty_number($udestruidas[$key]['desunits'])}</div>
						{else if $key == 1}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/plata.png" width="45"> {$udestruidas[$key]['username']} - {pretty_number($udestruidas[$key]['desunits'])}</div>
						{else if $key == 2}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/bronce.png" width="45"> {$udestruidas[$key]['username']} - {pretty_number($udestruidas[$key]['desunits'])}</div>
						{/if}
					{/foreach}
				</div>
				<div class="col-lg-4 offset-lg-12 text-center" style="margin-top: 30px">
					<div class="title">Mas Unidades Perdidas</div>
					{foreach $uperdidas as $key => $value}
						{if $key == 0}
							<div style="margin-top:1%;text-align:left;margin-left:50px" > <img src="styles/theme/gow/premios/oro.png" width="45"> {$uperdidas[$key]['username']} - {pretty_number($uperdidas[$key]['lostunits'])}</div>
						{else if $key == 1}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/plata.png" width="45"> {$uperdidas[$key]['username']} - {pretty_number($uperdidas[$key]['lostunits'])}</div>
						{else if $key == 2}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/bronce.png" width="45"> {$uperdidas[$key]['username']} - {pretty_number($uperdidas[$key]['lostunits'])}</div>
						{/if}
					{/foreach}
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-lg-4 offset-lg-4 text-center">
					<h2>Otras</h2>
					<hr>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4 text-center" style="margin-top: 30px">
					<div class="title">Estructuras</div>
					{foreach $ubuild as $key => $value}
						{if $key == 0}
							<div style="margin-top:1%;text-align:left;margin-left:50px" > <img src="styles/theme/gow/premios/oro.png" width="45"> {$ubuild[$key]['username']} - 
							{pretty_number($ubuild[$key]['build_points'])} Pts.</div>
						{else if $key == 1}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/plata.png" width="45"> {$ubuild[$key]['username']} - {pretty_number($ubuild[$key]['build_points'])} Pts.</div>
						{else if $key == 2}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/bronce.png" width="45"> {$ubuild[$key]['username']} - {pretty_number($ubuild[$key]['build_points'])} Pts.</div>
						{/if}
					{/foreach}
				</div>
				<div class="col-lg-4 text-center" style="margin-top: 30px">
					<div class="title">Investigaciones</div>
					{foreach $utech as $key => $value}
						{if $key == 0}
							<div style="margin-top:1%;text-align:left;margin-left:50px" > <img src="styles/theme/gow/premios/oro.png" width="45"> {$utech[$key]['username']} - 
							{pretty_number($utech[$key]['tech_points'])} Pts.</div>
						{else if $key == 1}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/plata.png" width="45"> {$utech[$key]['username']} - 
							{pretty_number($utech[$key]['tech_points'])} Pts.</div>
						{else if $key == 2}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/bronce.png" width="45"> {$utech[$key]['username']} - 
							{pretty_number($utech[$key]['tech_points'])} Pts.</div>
						{/if}
					{/foreach}
				</div>
				<div class="col-lg-4 text-center" style="margin-top: 30px">
					<div class="title">Naves</div>
					{foreach $ufleet as $key => $value}
						{if $key == 0}
							<div style="margin-top:1%;text-align:left;margin-left:50px" > <img src="styles/theme/gow/premios/oro.png" width="45"> {$ufleet[$key]['username']} - 
							{pretty_number($ufleet[$key]['fleet_points'])} Pts.</div>
						{else if $key == 1}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/plata.png" width="45"> {$ufleet[$key]['username']} - 
							{pretty_number($ufleet[$key]['fleet_points'])} Pts.</div>
						{else if $key == 2}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/bronce.png" width="45"> {$ufleet[$key]['username']} - 
							{pretty_number($ufleet[$key]['fleet_points'])} Pts.</div>
						{/if}
					{/foreach}
				</div>
				<div class="col-lg-4 text-center" style="margin-top: 30px">
					<div class="title">Defensa</div>
					{foreach $udefs as $key => $value}
						{if $key == 0}
							<div style="margin-top:1%;text-align:left;margin-left:50px" > <img src="styles/theme/gow/premios/oro.png" width="45"> {$udefs[$key]['username']} - 
							{pretty_number($udefs[$key]['defs_points'])} Pts.</div>
						{else if $key == 1}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/plata.png" width="45"> {$udefs[$key]['username']} - 
							{pretty_number($udefs[$key]['defs_points'])} Pts.</div>
						{else if $key == 2}
							<div style="margin-top:1%;text-align:left;margin-left:50px"> <img src="styles/theme/gow/premios/bronce.png" width="45"> {$udefs[$key]['username']} - 
							{pretty_number($udefs[$key]['defs_points'])} Pts.</div>
						{/if}
					{/foreach}
				</div>
			</div>
		</div>
		
</div>

{/block}