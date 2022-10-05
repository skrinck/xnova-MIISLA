{block name="title" prepend}{$LNG.lm_alliance}{/block}
{block name="content"}
<div id="content">
	<div id="ally_content" class="conteiner">
		<div class="gray_stripe">
    	<span style="float:left; display:block; width:140px;">{$LNG.al_find_alliances}</span>
	        <div class="search_aly">
	            <form action="game.php?page=alliance&amp;mode=search" method="post">
	                <input placeholder="{$LNG.al_find_submit}" name="searchtext" value="{$searchText}" type="text"> 
	                <input value="{$LNG.al_alliance_search}" type="submit"> 
	            </form>     
	        </div>
	        <a href="game.php?page=alliance&amp;mode=create" class="batn_lincks right_flank plus">{$LNG.all_create}</a>   
	    </div> 
	    {foreach $searchList as $seachRow}
		    <div class="ally_img">
			
				<div class="fractions_ico_big">
		        	{if $seachRow.ally_fraction_id != 0}<img alt="" title="" class="tooltip fraction_ico_mini_t" data-tooltip-content="{$seachRow.ally_fraction_name} ({$seachRow.ally_fraction_level})" src="{$dpath}img/race/fraction_{$seachRow.ally_fraction_id}.png">{/if}
		        </div>

			<table class="no_visible">
				<tbody>
					<tr>
						<td>
				        	<a href="game.php?page=alliance&amp;mode=apply&amp;id={$seachRow.id}">
								<img src="{$seachRow.ally_image}">
	                            <span class="designation">
	                				<span>{$seachRow.name} [{$seachRow.tag}]</span><br>
					                {$seachRow.members}
					            </span>
	            			</a>
	        			</td>
	        		</tr>
	        	</tbody>
	    	</table>
    	</div>  
		{foreachelse}
		{/foreach} 
	</div>
	 <div class="clear"></div>  
</div>
{/block}