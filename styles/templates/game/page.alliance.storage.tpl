{block name="title" prepend}{$LNG.al_storage}{/block}
{block name="content"}
<div id="content">
	<div id="ally_content" class="conteiner">
		<div class="gray_stripe">
	        <div class="left_part">	
	            {$LNG.al_storage} 
	        </div>
	        <a href="?page=alliance&amp;mode=logstorage" class="batn_lincks right_flank over imperia">{$LNG.al_storage_logs}</a>
	    </div>
		    <div class="ally_contents sepor_conten res_901">
	    	<div class="res_ico"></div>
	        <div class="res_text">{$LNG.tech.901}:</div>
	        <div class="res_count">{$alliance_storage_metal|number}</div>
	        <div class="clear"></div>
	    </div>
	    <div class="ally_contents sepor_conten res_902">
	    	<div class="res_ico"></div>
	        <div class="res_text">{$LNG.tech.902}:</div>
	        <div class="res_count">{$alliance_storage_crystal|number}</div>
	        <div class="clear"></div>
	    </div>
	    <div class="ally_contents sepor_conten res_903">
	    	<div class="res_ico"></div>
	        <div class="res_text">{$LNG.tech.903}:</div>
	        <div class="res_count">{$alliance_storage_deuterium|number}</div>
	        <div class="clear"></div>
	    </div>
	    <div class="ally_contents sepor_conten res_stardust">
			{if $stellar_ores > 0}
				<div class="btn_border right_flank"> 
				<a href="?page=alliance&amp;mode=putStardustAll" class="batn_lincks left_flank">
	                <div class="res_ico"></div>&nbsp;&nbsp;{$LNG.tech.923} <b>(All)&nbsp;&nbsp;</b> 
	            </a> </div>
				<div class="btn_border right_flank"> 
				<a href="?page=alliance&amp;mode=putStardust" class="batn_lincks left_flank">
	                <div class="res_ico"></div>&nbsp;&nbsp;{$LNG.tech.923} <b>+ 1&nbsp;&nbsp;</b> 
	            </a> </div>
			{/if}
			{if $alliance_storage_stardust > 0 && $rights.BANK}
				<div class="btn_border right_flank" > 
				<a href="?page=alliance&amp;mode=isStardust" class="batn_lincks right_flank">
	            <div class="res_ico"></div>&nbsp;&nbsp;{$LNG.tech.923}  <b>- 1&nbsp;&nbsp;</b> 
	            </a></div>
            {/if}		
	        <div class="res_ico"></div>
	        <div class="res_text">{$LNG.tech.923}:</div>
	        <div class="res_count" style="width:200px;">{$alliance_storage_stardust|number}</div>
	        <div class="clear"></div>
	    </div>
		<div class="ally_contents" style="padding:10px;">
			{if $rights.BANK}
				<div class="btn_border right_flank"> 
					<a href="?page=alliance&amp;mode=issue" method="post">
						<input value="{$LNG.al_storage_aliado}" type="submit">
					</a>
				</div>
			{/if}
			{if $rights.BANK}
				<div class="btn_border right_flank">
					{if !empty($widraw_active)}
						<button style="padding: 6px 15px;"> {$LNG.al_storage_widraw}: <span style="cursor:default" class="countdown2"  secs="{$widraw_active}"></span></button>
					{else}
						<a href="?page=alliance&amp;mode=vlyat" method="post">
							<input value="{$LNG.al_storage_widraw}" type="submit">
						</a>
					{/if}
				</div>
			{/if}
			<div class="btn_border right_flank">

				{if !empty($deposit_active)}
					<button style="padding: 6px 15px;"> {$LNG.al_storage_deposit}: <span style="cursor:default" class="countdown2"  secs="{$deposit_active}"></span></button>
				{else}
					<a href="?page=alliance&amp;mode=put" method="post">
						<input value="{$LNG.al_storage_deposit}" type="submit">
					</a>
				{/if}
			</div>

		<div class="clear"></div>        
		</div>
		 <div class="gray_stripe">
			<a href="game.php?page=alliance">{$LNG.al_back}</a>
        </div>
	</div>
</div>
{/block}