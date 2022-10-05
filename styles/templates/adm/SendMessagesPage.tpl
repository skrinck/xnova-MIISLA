{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}

	<!-- Theme JS files -->
<script type="text/javascript">

function check(){
	if($('#text').val().length == 0) {
		Dialog.alert('{$LNG.mg_empty_text}');
		return false;
	} else {
		$.post('admin.php?page=globalmessage&action=send&ajax=1', $('#message').serialize(), function(data) {
			Dialog.alert(data, function() {
				location.reload();
			});
		});
		return true;
	}
}
</script>
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['mu_utility']}</span> - {{$LNG['mu_global_message']}}</h4>
						</div>

							<div class="heading-elements">
							<div class="heading-btn-group">
								<a href="admin.php" class="btn btn-link btn-float has-text"><i class="fa fa-home fa-2x text-primary"></i><span>{$LNG['home']}</span></a>
								<a href="admin.php?page=universe&sid={session_id()}" class="btn btn-link btn-float has-text"><i class="fa fa-stroopwafel fa-2x text-primary"></i><span>{$LNG['mu_universe']}</span></a>
								<a href="admin.php?page=rights&mode=rights&sid={session_id()}" class="btn btn-link btn-float has-text"><i class="fa fa-users fa-2x text-primary"></i><span>{$LNG['mu_moderation_page']}</span></a>
								<a href="admin.php?page=reset&sid={session_id()}" class="btn btn-link btn-float has-text"><i class="fa fa-undo fa-2x text-primary"></i><span>{$LNG['re_reset_universe'] }</span></a>
							</div>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="admin.php?page=overview"><i class="icon-home2 position-left"></i> {$LNG['home']}</a></li>
							<li><a href="admin.php?page=globalmessage">{$LNG['mu_utility']}</a></li>
							<li class="active">{$LNG['mu_global_message']}</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li><a href="mailto:rayco.garcia13@nauta.cu"><i class="icon-comment-discussion position-left"></i> {$LNG['ow_support']}</a></li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">



							<!-- Advanced legend -->
							<form class="form-horizontal" action="admin.php?page=globalmessage&action=send" method="post">
								<div class="panel panel-flat">


									<div class="panel-body">
										<fieldset>
											<legend class="text-semibold">
												<i class="fa fa-envelope "></i>
												{$LNG['al_send_circular_message']}
												<a class="control-arrow" data-toggle="collapse" data-target="#demo1">
													<i class="icon-circle-down2"></i>
												</a>
											</legend>
 
											<div class="collapse in" id="demo1">
												
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['se_lang']}:</label>
													<div class="col-lg-9">
														<select name=lang data-placeholder="Select the desired option" class="select">
															{foreach $langSelector as $item}
																<option value="{$item}">{$item}</option>
															{/foreach}
														</select>
													</div>
												</div> 
												
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['ma_mode']}:</label>
													<div class="col-lg-9">
														<select name=typemsg data-placeholder="Select the desired option" class="select">
															<option value="0">Mensaje Interno</option>
															<option value="1">Notificación</option>
															<option value="3">Correo</option>
															<!--<option value="2">Android Push Notifications</option>-->
														</select>
													</div>
												</div> 
												
												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['ma_subject']}:</label>
													<div class="col-lg-9">
														<input name="subject" type="text" class="form-control">
													</div>
												</div>

												<div class="form-group">
													<label class="col-lg-3 control-label">{$LNG['ma_message']}:</label>
													<div class="col-lg-9">
				                                    <textarea rows="5" cols="5" name="text" id="text" class="form-control"></textarea>
			                                    </div>
												</div>

											</div>
										</fieldset>									

										<div class="text-right">
											<button type="submit" class="btn btn-primary">{$LNG['up_submit']} <i class="icon-arrow-right14 position-right"></i></button>
										</div>
									</div>
								</div>
							</form>
							<!-- /a legend -->

{include file="overall_footer.tpl"}
