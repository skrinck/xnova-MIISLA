{block name="title" prepend}{$LNG.siteTitleDisclamer}{/block}
{block name="content"}
	<div class="container" style="margin-top: 80px;">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center"><h3>{$LNG.disclamerLabel}</h3></div>
                    {foreach $disclaimerList as $disclaimerRow}
                        <div class="panel-body">
                        	<div class="row text-center">
                        		<address class="col-lg-6">
									<strong>{$LNG.disclamerLabelUser}</strong>
			                        {$disclaimerRow.user}<br>
			                        <strong>{$LNG.disclamerLabelRank}</strong>
			                        {$disclaimerRow.rank}<br>
			                        <strong>{$LNG.disclamerLabelMail}</strong>
			                        {$disclaimerRow.email}
								</address>
								<address class="col-lg-6">
									<strong>{$LNG.disclamerLabelAddress}</strong>
			                        {$disclaimerRow.address}<br>
			                        <strong>{$LNG.disclamerLabelPhone}</strong>
			                        {$disclaimerRow.phone}<br>
			                        <strong>{$LNG.disclamerLabelNotice}</strong>
			                        {$disclaimerRow.text}
								</address>
                        	</div>
                            
                        </div>
                        {foreachelse}
                        <div class="panel-body">
                            <h3 class="page-header">{$LNG.news_does_not_exist}</h3>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
{/block}