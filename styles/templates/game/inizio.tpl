{block name="title" prepend}{$LNG.tut_welcome}{/block}
{block name="content"}
<div class="container">
	<div class="container-page">
		<div class="title"><b>{$tut_welcome}</b></div>
		<p class="text-center" style="font-size: 14px">{$LNG.tut_welcom_desc}</p>
		<div class="text-center" style="font-size: 14px">
			<ul id="aufgabe_liste" style="text-align: left;">
				<li class="aufzaehlungszeichen">{$LNG.tut_welcom_desc2}</li>
				<li class="aufzaehlungszeichen">{$LNG.tut_welcom_desc3}</li>
				<li class="aufzaehlungszeichen">{$LNG.tut_welcom_desc4}</li>
			</ul>
			<p>Para mas información puede contactarnos a travez del <a href="https://www.miisla.nat.cu/soporte" style="font-size:12px;color:red;">xForo Soporte</a></p>
		</div>
		<div class="text-center">
			<a href ="?page=tutorial&mode=m1"><input type="submit" style="cursor: pointer; width: 180px; height: 27px;" value="{$LNG.tut_go}" onclick="window.location = '?page=tutorial&mode=m1'"/></a>
		</div>
	</div>
</div>
{/block}