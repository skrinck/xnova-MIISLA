{block name="title" prepend}Bonus{/block}
{block name="content"}
<style type="text/css">
.para_imagen {
    height: 190px;
    background: rgba(255,255,255,.05);
    overflow: hidden;
}
.anouncement, .rules {
    padding: 10px 5px;
}
.rules_text {
    margin-top: 5px;
}
.content_page{
	background: #0000009e;
}
.anouncement table {
    width: 82%;
    border: 1px solid #000;
}

.anouncement td {
    padding: 7px;
}

.para_imagen img {
    width: 100%;
}
</style>
<div class="content_page">
	<div class="title">
			Torneo War Of Alliances
	</div>
	<div class="torunament_content">
		<div class="para_imagen">
			<img src="./styles/theme/gow/WarOfAlliance/battles.jpg">
		</div>
		<div class="anouncement">
				<div class="tabse title">
					<span data-rel="#ttab01" class="btn btn-xs">Alianzas</span>
					<span data-rel="#ttab02" class="btn btn-xs">Usuarios de Alianza</span>
				</div>
				<div class="tournament_section">
					<article id="ttab01" style="display: block;">
						<table>
							<tr style="background: #070707a6; border-bottom: 1px solid #000;box-shadow: 0px 4px 4px -2px #000;">
								<td>Ranking</td>
								<td>Alianza</td>
								<td>Etiqueta</td>
								<td>Miembros</td>
								<td>Unidades perdidas</td>
							</tr>
							{foreach item=alliance key=rank from=$alliances}
							<tr>
								<td>{$rank+1}</td>
								<td>{$alliance.name}</td>
								<td>{$alliance.tag}</td>
								<td>{$alliance.members}</td>
								<td>{$alliance.total_destroy}</td>
							</tr>
							{/foreach}
						</table>
					</article>
					<article id="ttab02" style="display: none;">
						<table>
							<tr style="background: #070707a6; border-bottom: 1px solid #000;box-shadow: 0px 4px 4px -2px #000;">
								<td>Ranking</td>
								<td>Jugador</td>
								<td>Alianza</td>
								<td>Unidades perdidas</td>
							</tr>
							{foreach item=user key=rank from=$users}
							<tr>
								<td>{$rank+1}</td>
								<td>{$user.name}</td>
								<td>{$user.ally_name}</td>
								<td>{$user.total_lost}</td>
							</tr>
							{/foreach}
						</table>
					</article>
				</div>
						
		</div>
		<div class="rules">
			<div class="rules_header text-center">El torneo War of Alliances conciste en:</div>
			<div class="rules_text">Explicacion y normas</div>
		</div>
	</div>

</div>
<script type="text/javascript">
	$('[data-rel*="#ttab"]').click(function(){
		$('[data-rel*="#ttab"]').removeClass('active')
		$(this).addClass('active')

		console.log($(this))

		$('[id*="ttab"]').hide();
		$($(this).data('rel')).show();
	});
</script>
{/block}