{block name="title" prepend}{$LNG.lm_support}{/block}
{block name="content"}
<div id="ally_content" class="conteiner_ticket container" style="padding-bottom:2px;width: 67%">
	<div class="gray_stripe" style="padding-right:0;">
       {$LNG.ti_header} <a href="game.php?page=ticket&amp;mode=create"><input type="button" class="right_flank input_blue" style="width:200px; font-weight:bold;" onclick="return add();" value="{$LNG.ti_new}"></a>
    </div>

		<table style="width:100%">
		<tr>
			<td>Promedio de respuesta</td> 
			<td>Clasificación</td> 
			<td>Cantidad de tickets</td> 
		</tr>
		<tr>
			<td>{$timeBetween|time}</td> 
			<td><span class="tckRateStars">
            	<span style="background-image: url(&quot;./styles/images/star-{if $sumStarts >=20}gold{else}gray{/if}.png&quot;);"></span>
            	<span style="background-image: url(&quot;./styles/images/star-{if $sumStarts >=40}gold{else}gray{/if}.png&quot;);"></span>
            	<span style="background-image: url(&quot;./styles/images/star-{if $sumStarts >=60}gold{else}gray{/if}.png&quot;);"></span>
            	<span style="background-image: url(&quot;./styles/images/star-{if $sumStarts >=80}gold{else}gray{/if}.png&quot;);"></span>
            	<span style="background-image: url(&quot;./styles/images/star-{if $sumStarts >=100}gold{else}gray{/if}.png&quot;);"></span>
            </span></td> 
			<td>{$answerCount|number}</td> 
		</tr>
		</table>
<span class="clear"></span>
	{foreach $ticketList as $TicketID => $TicketInfo}	
	 <a href="game.php?page=ticket&amp;mode=view&amp;id={$TicketID}" class="ticket_row_linck">
        <span class="ticket_row_linck_id">#{$TicketID}</span>
        <span class="ticket_row_linck_subject">{$TicketInfo.subject}</span>
        <span class="ticket_row_linck_time">{$TicketInfo.time}</span>
                {if $TicketInfo.status == 1}<span class="ticket_row_linck_status" style="color:green">{$LNG.ti_status_open}</span>{elseif $TicketInfo.status == 0}<span class="ticket_row_linck_status" style="color:orange">{$LNG.ti_status_answer}</span>{elseif $TicketInfo.status == 99}<span class="ticket_row_linck_status" style="color:blue">{$LNG.ti_status_answer}</span>{else}<span class="ticket_row_linck_status" style="color:red">{$LNG.ti_status_closed}</span>{/if}
				{if $TicketInfo.status == 2 && $TicketInfo.rated == 0}
				<span id="{$TicketID}" class="ticket_row_linck_status tckRateStars">
            	<span style="background-image: url(&quot./styles/images/star-gray.png&quot;);" star="1" class="tckRateStar"></span>
            	<span style="background-image: url(&quot;./styles/images/star-gray.png&quot;);" star="2" class="tckRateStar"></span>
            	<span style="background-image: url(&quot;./styles/images/star-gray.png&quot;);" star="3" class="tckRateStar"></span>
            	<span style="background-image: url(&quot;./styles/images/star-gray.png&quot;);" star="4" class="tckRateStar"></span>
            	<span star="5" class="tckRateStar"></span>
            </span>{/if}
                        <span class="clear"></span>
    </a>    
	{/foreach}
    </div>
            <div class="clear"></div>   
            </div>         
        </div><!--/body-->

{/block}
