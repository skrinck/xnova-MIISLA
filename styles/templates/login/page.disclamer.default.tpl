{block name="title" prepend}{$LNG.siteTitleDisclamer}{/block}
{block name="content"}
	<div class="container" style="margin-top: 80px;">
		<div class="panel panel-default">
			<div class="panel-heading">{$LNG.siteTitleDisclamer}</div>
			<div class="panel-body">
				<p class="lead">Information</p>
				<p>Aqui encontras los datos de contacto del Ogame.</p>

				<hr>

				<div class="row">
					<address class="col-lg-6">
						<strong>{$LNG.disclamerLabelAddress}</strong><br>
                        {$disclamerAddress}
					</address>
					<address class="col-lg-6">
						<strong>{$LNG.disclamerLabelPhone}</strong><br>
                        {$disclamerPhone}
					</address>
				</div>

				<div class="row">
					<address class="col-lg-6">
						<strong>{$LNG.disclamerLabelMail}</strong><br>
						<a href="{$disclamerMail}">{$disclamerMail}</a>
					</address>
					<address class="col-lg-6">
						<strong>{$LNG.disclamerLabelNotice}</strong><br>
                        {$disclamerNotice}
					</address>
				</div>
			</div>
		</div>
	</div>
{/block}