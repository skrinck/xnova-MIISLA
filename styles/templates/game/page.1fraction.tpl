{block name="title" prepend}{$LNG.fraction_fraction}{/block}
{block name="content"}
<div class="content_page" style="width: 50%">
	<div class="title">
		{$LNG.fraction_fraction}
	</div>
	<div class="alert alert-danger text-center"><i class="fas fa-exclamation-triangle fa-5x pull-left"></i>Las Facciones se encuentran es fase de desarrollo, por lo que se le aconseja de no cambiar de facción porque le descontará 10.000 de MO, por cada cambio y no asumirá ninguna función <br>Disculpen las molestias que esto pueda ocasionar</div>
	{foreach $colectionSelect as $id => $fractionRow}
		<div class="main_construct_fac" style="height: 250px;">
			<div class="block_construct_fac">
				<div class="title" style="margin: 5px 0 0 -5px; text-align: left;">
					<img src="{$dpath}fraction/{$id}.gif" alt="{$LNG.fraction_name.$id}" width="30" height="30">
					{$LNG.fraction_name.$id}
				</div>

				<div class="block_construct_desc_fac">
					<div class="block_construct_desc_list_fac">
						<div class="pull-left">
							{foreach $fractionRow.bonus as $key => $bonusRow}
								<div style="margin-bottom: 10px;">
									{$LNG['fraction_bonus'][$bonusRow.0][0]}
									{if $bonusRow.1 >0}{$LNG['fraction_bonus'][$bonusRow.0][1]}{/if}{$LNG['fraction_bonus'][$bonusRow.0][3]*$bonusRow.1}{$LNG['fraction_bonus'][$bonusRow.0][2]}
								</div>
							{/foreach}
						</div>
						<div class="pull-rigth">
							<div style="padding-left: 200px;">
								<img src="{$dpath}fraction/{$id}.gif" alt="{$LNG.fraction_name.$id}" class="tooltip_sticky" data-tooltip-content="{$LNG.fraction_name.$id}" width="130" height="130" />
							</div>
						</div>
					</div>

					<div>
						{if $fraction == 0}
							<form action="game.php?page=fraction&mode=vibrat&id={$id}" method="post" class="build_form">
								<input type="hidden" name="id" value="{$id}">
								<button type="submit" class="build_submit construct_button">Seleccione</button>
							</form>
						{elseif $fraction == $id}
							<!-- <img src="{$dpath}fraction/factiv.png" style="width: 7vw;height: 7vw;left: 2.5vw;bottom: 2vw;position: absolute;"> -->
						{elseif $fraction != 0}
							<form action="game.php?page=fraction&mode=smena&id={$id}" method="post" class="build_form">
								<input type="hidden" name="id" value="{$id}">
								<button type="submit" class="build_submit construct_button_lost_fac">Cambio de facción</button>
							</form>
						{/if}
					</div>
				</div>
			</div>
		</div>
	{/foreach}
</div>
{/block}