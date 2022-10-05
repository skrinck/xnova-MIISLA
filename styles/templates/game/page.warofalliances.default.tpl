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
			{if $activo} 
				{if !$inscribed}
					Actualmente se encuentra activa la subscripcion de alianzas al torneo. Cerrara la inscripcion el {date("D d.m.Y H:m:s a", {$time})} y comenzara el torneo inmediatamente
					<form action="?page=warOfAlliances" method="POST">
						<button type="submit" name="inscripcion" class="btn btn-primary">Inscribirme</button>
					</form>
				{else}
					Ya tu alianza se encuentra inscrita en el torneo. Preparate junto a tus aliados hasta que comience el torneo.
					<br>
					{date("D d.m.Y H:m:s a", {$time})}
				{/if}
			{else}
				Actualmente se encuentra inactivo
			{/if}
		</div>
		<div class="rules">
			<div class="rules_header text-center">El torneo War of Alliances conciste en:</div>
			<div class="rules_text">Explicacion y normas</div>
		</div>
	</div>

</div>
{/block}