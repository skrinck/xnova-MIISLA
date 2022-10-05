			</div>
		</fieldset>
	</div>
</div>
<script>
	$('select').css('width','50%')
	$('select').select2()
	$('input').addClass('form-control');
	$('input[type="submit"],input[type="reset"]').removeClass('form-control').css('border-radius','2px')
	.css('padding','5px 10px').css('background-color','#fcfcfc').css('border','1px solid transparent').css('border-color','#ddd').css('color','#000');
	$('td').css('padding','10px');
	$('input[type="checkbox"]').removeClass('form-control').addClass('switch').attr('data-on-color','success')
	.attr('data-off-color','danger');
	$('input[name="galaxy"],input[name="system"],input[name="planet"]').removeClass('form-control')
      .css('padding','5px').css('border','1px solid #ddd').css('border-radius','3px');
	$('td').css('padding','10px');
	$('input[name="g"],input[name="s"],input[name="p"]').removeClass('form-control')
      .css('padding','5px').css('border','1px solid #ddd').css('border-radius','3px');
	$('td').css('padding','10px');

	$(document).ready(function(){
		$('.bootstrap-switch').css('margin-top','5px');
		$('.bootstrap-switch').css('margin-bottom','5px');
		$('td').css('padding-top','5px');
		$('td').css('padding-bottom','5px');
	})
</script>
{include file="overall_footer.tpl"}