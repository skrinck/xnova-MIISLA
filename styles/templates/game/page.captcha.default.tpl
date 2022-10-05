{block name="title" prepend}{$LNG.lm_captcha}{/block}
{block name="content"}
<div id="achivment" class="container">
    <div class="ach_main_block">
        <div class="ach_head">
                <div class="ach_head_p">{$LNG.lm_captcha}</div><!--/ach_head_p-->
                <div class="pull-right">
                    <a href="game.php?page=captcha" class="batn_lincks" style="padding-right: 10px">{$LNG.fl_captcha_2}</a>
                </div><!--/ach_head_right-->
        </div><!--/ach_head-->
        <div class="ach_main_content">
            <div class="ally_contents" style="padding-bottom:10px; font-size:11px; text-align:center">
                <span style="color:white">
                    Selecione la respuesta correcta
                </span>
            </div>
            <table id="captcha" class="ally_ranks ach_content">
                <tbody>
                    <tr>
                        <td><a href="game.php?page=captcha"><img style="max-height:none !important;" src="styles/images/captcha/resolve{$isCaptchaCode}_{$showImage}.gif" /></a></td>
                        <td><a href="game.php?page=captcha&amp;mode=send&amp;number=1"><img style="max-height:none !important;" src="styles/images/captcha/captcha{$isNumberOne}.gif" /></a></td>
                        <td><a href="game.php?page=captcha&amp;mode=send&amp;number=2"><img style="max-height:none !important;" src="styles/images/captcha/captcha{$isNumberTwo}.gif" /></a></td>
                        <td><a href="game.php?page=captcha&amp;mode=send&amp;number=3"><img style="max-height:none !important;" src="styles/images/captcha/captcha{$isNumberThree}.gif" /></a></td>
                    </tr>
                </tbody>
            </table>
            <div class="ally_contents" style="padding-bottom:10px; font-size:11px; text-align:center">
                <span style="color:#D1393C">
                    {$LNG.fl_captcha_1}
                </span>
            </div>
        </div><!--/ach_main_content-->
    </div><!--/ach_main_block-->
</div>
{/block}
