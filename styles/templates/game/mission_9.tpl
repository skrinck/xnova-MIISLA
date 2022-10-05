{block name="title" prepend}{$LNG.tut_welcome}{/block}
{block name="content"}
<div class="container container-page" style="width: 95%;">
	<div class="title">
		{$LNG.tut_tut}
	</div>
	<table class="table">
		<thead>
			<tr class="text-center">
				<th scope="col"><a href="game.php?page=tutorial&mode=m1">{$LNG.tut_m1} {$Si1}{$No1}</a></th>
				<th scope="col"><a href="game.php?page=tutorial&mode=m2">{$LNG.tut_m2} {$Si2}{$No2}</a></th>
				<th scope="col"><a href="game.php?page=tutorial&mode=m3">{$LNG.tut_m3} {$Si3}{$No3}</a></th>
				<th scope="col"><a href="game.php?page=tutorial&mode=m4">{$LNG.tut_m4} {$Si4}{$No4}</a></th>
				<th scope="col"><a href="game.php?page=tutorial&mode=m5">{$LNG.tut_m5} {$Si5}{$No5}</a></th>
				<th scope="col"><a href="game.php?page=tutorial&mode=m6">{$LNG.tut_m6} {$Si6}{$No6}</a></th>
				<th scope="col"><a href="game.php?page=tutorial&mode=m7">{$LNG.tut_m7} {$Si7}{$No7}</a></th>
				<th scope="col"><a href="game.php?page=tutorial&mode=m8">{$LNG.tut_m8} {$Si8}{$No8}</a></th>
				<th scope="col"><a href="game.php?page=tutorial&mode=m9">{$LNG.tut_m9} {$Si9}{$No9}</a></th>
			</tr>
			<tr>
				<td colspan="9">
					<h5 class="textBeefy text-center">{$LNG.tut_m9_name} - {$livello9} {$Si9}{$No9}</h5>
				</td>
			</tr>
			<tr>
				<td class="k">
					<p id="aufgabentext"><img src="{$dpath}gebaeude/209.gif" class="pic"></p>
					<td class="k" colspan="9">
						<p>{$LNG.tut_m9_desc}</p>
					</td>
				</td>
			</tr>
			<tr>
				<td class="k text-center" colspan="9">
					<h3>{$LNG.tut_objects}:</h3>

						<ul id="aufgabe_liste">
							<li class="aufzaehlungszeichen"> {$LNG.tut_m9_quest} {$Si_m9_1}{$No_m9_1}{$Si9}</li>
							<li class="aufzaehlungszeichen"> {$LNG.tut_m9_quest3} {$Si_m9_3}{$No_m9_3}{$Si9}</li>
							<li class="aufzaehlungszeichen"> {$LNG.tut_m9_quest4} {$Si_m9_4}{$No_m9_4}{$Si9}</li>
						</ul>

					<div style="color:orange;">{$LNG.tut_m9_gain}</div>
				</td>
			</tr>
			{if $Si9}
			<tr>
				<td colspan="9" class="text-center">
					<div class="alert alert-success text-center" style="font-size:15px"><i class="fas fa-check"></i> {$LNG.tut_compleat}</div>
				</td>
			</tr>
			{/if}
		</thead>
	</table>
</div>
{/block}