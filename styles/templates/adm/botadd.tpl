{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['mu_utility']}</span> - {$LNG['mu_clear_cache']}</h4>
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
							<li><a href="admin.php?page=clearcache">{$LNG['mu_utility']}</a></li>
							<li>{$LNG['mu_clear_cache']}</li>
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
								<div class="panel panel-flat">


									<div class="panel-body">
										
										<fieldset>
											<legend class="text-semibold">
												<i class="icon-file-text2 position-left"></i>
												Cantidad de Bot a agregar
												<a class="control-arrow" data-toggle="collapse" data-target="#Frame8">
													<i class="icon-circle-down2"></i>
												</a>
											</legend>
 
											<div class="collapse in" id="Frame8">
												<input type="number" name="cant_bot" id="bots">
												<button onclick="return bot_add();">agregar</button>
											</div>
										</fieldset>

										

									</div>
									
								</div>

								<div class="panel panel-flat">
											<table class="table">
											  <thead class="thead-dark">
											    <tr>
											      <th scope="col">id</th>
											      <th scope="col">user</th>
											      <th scope="col">MainPlanet</th>
											      <th scope="col">LastConect</th>
											    </tr>
											  </thead>
											  <tbody id="tb">
											    
											</tbody>
										</table>
										</div>
							<!-- /a legend -->
								<script type="text/javascript">

									function bot_update(){
												 $.ajax({
										            url: './list_bot.php',
										            type: "POST",
										            data: {
										            },
										            success: function (data) {
										            	$('#tb').html(data);
										            },
										          
										        })
											}
											function getBaseUrl() {
											    var re = new RegExp(/^.*\//);
											    return re.exec(window.location.href);
											}

											function bot_add(){
        										var cant = document.getElementById("bots").value;
        										if (cant==0) {
        											alert("la cantidad es 0");
        										}else{
        											 var http = new XMLHttpRequest(); 
        											 http.open('HEAD', getBaseUrl()+'admin.php', false); 
              										  http.send(); 
              										  console.log(http);
												 $.ajax({
										            url: './botadd.php',
										            type: "POST",
										            data: {
										            	"cant": cant
										            },
										            success: function (data) {
										            	alert("bots agregados \n"+data);
										            },
										          
										        })
												 bot_update();
												}
											}

											    $(document).ready(function () {
											        bot_update();
											        });

										</script>

{include file="overall_footer.tpl"}	