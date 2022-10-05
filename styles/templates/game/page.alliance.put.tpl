{block name="title" prepend}{$LNG.al_storage}{/block}
{block name="content"}
<div id="content">
	<div id="ally_content" class="conteiner">
		<div class="gray_stripe">
	    	<a href="game.php?page=alliance&amp;mode=storage" style="color:#8e9394;">{$LNG.al_storage}</a>
	        <i class="fas fa-arrow-right"></i>
	    	{$LNG.al_storage_deposit} 
			
			<span style="float:right"><a href="game.php?page=alliance&amp;mode=storage">{$LNG.al_back}</a></span>
		</div>
		<form id="trader" action="game.php?page=alliance" method="post">
	        <input name="mode" value="putsend" type="hidden">     
	        <div class="ally_contents sepor_conten res_901">
	            <div class="res_ico"></div>
	            <div class="res_text">{$LNG.tech.901}:</div>
	            <div class="res_count"><input name="resource901" id="resource901" class="trade_input" value="0" size="30" type="text"></div>
	            <div class="clear"></div>
	        </div>
	        <div class="ally_contents sepor_conten res_902">
	            <div class="res_ico"></div>
	            <div class="res_text">{$LNG.tech.902}:</div>
	            <div class="res_count"><input name="resource902" id="resource902" class="trade_input" value="0" size="30" type="text"></div>
	            <div class="clear"></div>
	        </div>
	        <div class="ally_contents sepor_conten res_903">
	            <div class="res_ico"></div>
	            <div class="res_text">{$LNG.tech.903}:</div>
	            <div class="res_count"><input name="resource903" id="resource903" class="trade_input" value="0" size="30" type="text"></div>
	            <div class="clear"></div>
	        </div>
	        <div class="ally_contents" style="padding:10px;">
	        	<div style="float:left; margin-left:22px; line-height:18px;">
	        		<div class="res_text">{$LNG.al_storage_max}:</div>
	        		<div class="res_count" style="width:auto;">{if $cost|number == 0}{$LNG.al_storage_inv}: <a href="#" onclick="return Dialog.info(125)">{$LNG.tech.125}</a>{else} {$cost|number}{/if}</div>
	                <div class="clear"></div>
	                <div class="res_text">{$LNG.allian_6}:</div>
	        		<div class="res_count" style="width:auto;"><span id="ress">0</span></div>
	            </div>         
	            <div class="btn_border right_flank">
	                <input value="ОК" type="submit">
	            </div>
	            <div class="clear"></div>
	        </div>
	    </form>



    </div>
</div>

{/block}
{block name="script" append}
<script type="text/javascript">
var ress1charge = 1;
var ress2charge = 1;
var ress3charge = 1;
</script>
{/block}