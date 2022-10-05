{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['server_setting']}</span> - {$LNG['mu_general']}</h4>
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
							<li><a href="admin.php"><i class="icon-home2 position-left"></i> {$LNG['home']}</a></li>
							<li><a href="admin.php?page=createcampaign">{$LNG['config_campaign']}</a></li>
							<li class="active">{$LNG['create_campaign']}</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li><a href="mailto:rayco.garcia13@nauta.cu"><i class="icon-comment-discussion position-left"></i> {$LNG['ow_support']}</a></li>
						</ul>
					</div>
				</div>
				<!-- /page header -->



				<!-- Content area -->
				<div class="content">

					<!-- Basic setup -->
		            <div class="panel panel-white">
						<div class="panel-heading">
							<h6 class="panel-title">{$LNG['create_campaign']}</h6>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                	</ul>
		                	</div>
						</div>
						{if !empty($showMsg)}
						<div class="alert alert-danger alert-styled-left alert-bordered">
							{$showMsg}
						</div>
						{/if}
	                	<form class="form-basic" method="post">
							<fieldset class="step" id="step1">
								<h6 class="form-wizard-title text-semibold">
									<span class="form-wizard-count">1</span>
									Configuración de compras
									<small class="display-block">Rellene en las ventas lo que desea para iniciar cada una de las compras</small>
								</h6>

								

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Bono de antimateria extra:</label>
											<input type="text" name="donation_bonus" class="form-control" placeholder="valor en % por cada compra de antimateria. Ejemplo 30 para 30%">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Estados de compra extra:</label>
											<select name="special_donation_status" data-placeholder="Desea activar la opción de segundo bono ?" class="select">
														<option></option>
														<option value="1">{$LNG['actived']}</option>
														<option value="0">{$LNG['disabled']}</option>
													</select>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Premio de tiempo extra:</label>
											<input type="text" name="special_donation_premium" class="form-control" placeholder="Valor en % para la oferta de premio de tiempo extra en cada activación. Ejemplo 30 para 30%">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Extra purchase amount:</label>
											<input type="text" name="special_donation_amount" class="form-control" placeholder="Minimum value of antimatter purchase to activate the secod bonus. Example 200000">
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Red bonus button:</label>
											<input type="text" name="red_button" class="form-control" placeholder="Factor for the red bonus button: Example 5 for x5">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Extra purchase percent:</label>
											<input type="text" name="special_donation_percent" class="form-control" placeholder="Value in % to offer as second bonus if min. purchase is met. Example 30 for 30%">
										</div>
									</div>
								</div>
								
							</fieldset>

							<fieldset class="step" id="step2">
								<h6 class="form-wizard-title text-semibold">
									<span class="form-wizard-count">2</span>
									Optional Settings
									<small class="display-block">You can activate optional settings that will run in this event.</small>
								</h6>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Acadedmy points reduction:</label>
			                                <input type="text" name="special_donation_academy" placeholder="Value in % to decrease the cost of 1 academy points. Example 30 for 30%" class="form-control">
		                                </div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Stellar ore reduction:</label>
			                                <input type="text" name="special_donation_stardust" placeholder="Value in % to decrease the cost of 1 stellar ore. Example 30 for 30%" class="form-control">
		                                </div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Darkmatter cost reduction:</label>
			                                <input type="text" name="darkmatter_reduc" placeholder="Value in % to decrease the cost of 1 darkmatter construction [fleet, defense, build, research]. Example 30 for 30%" class="form-control">
		                                </div>

										<div class="form-group">
											<label>Collider promotion reduction:</label>
			                                <input type="text" name="collider_promo" placeholder="Value in % to decrease the cost of the collider price. Example 30 for 30%" class="form-control">
		                                </div>
									</div>

									<div class="col-md-6">

										<div class="form-group">
											<label>Prime buildings:</label>
			                                <select name="primebuild" data-placeholder="Do you want to activate the prime ships and defense [M7,M19, M32, SLIM, IRON, HEAVY MEGADOR] ?" class="select">
												<option></option>
												<option value="1">Activated</option>
												<option value="0">Disabled</option>
											</select>
		                                </div>
										
										<div class="form-group">
											<label>Acitave the suprema event:</label>
			                                <select name="auctionExpe" data-placeholder="Do you want to activate the suprema event to find auction items in the galaxy ?" class="select">
												<option></option>
												<option value="1">Yes</option>
												<option value="0">No</option>
											</select>
		                                </div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Peacefull experience:</label>
											<input type="text" name="peacefullExp" class="form-control" placeholder="Factor for the peacefull experience bar: Example 5 for x5">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Combat experience:</label>
											<input type="text" name="combatExp" class="form-control" placeholder="Factor for the combat experience bar: Example 5 for x5">
										</div>
									</div>
								</div>
							</fieldset>


							<fieldset class="step" id="step3">
								<h6 class="form-wizard-title text-semibold">
									<span class="form-wizard-count">3</span>
									Additional info
									<small class="display-block">Fill in the data. all inputs are required.</small>
								</h6>
								
								<div class="row">
									<div class="col-md-6">
										<label>Start Date: <span class="text-danger">*</span></label>
										<div class="row">
											
											<div class="col-md-4">
												<div class="form-group">
													<select name="start-day" data-placeholder="Start Day" class="select">
														<option></option>
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
														<option value="5">5</option>
														<option value="6">6</option>
														<option value="7">7</option>
														<option value="8">8</option>
														<option value="9">9</option>
														<option value="10">10</option>
														<option value="11">11</option>
														<option value="12">12</option>
														<option value="13">13</option>
														<option value="14">14</option>
														<option value="15">15</option>
														<option value="16">16</option>
														<option value="17">17</option>
														<option value="18">18</option>
														<option value="19">19</option>
														<option value="20">20</option>
														<option value="21">21</option>
														<option value="22">22</option>
														<option value="23">23</option>
														<option value="24">24</option>
														<option value="25">25</option>
														<option value="26">26</option>
														<option value="27">27</option>
														<option value="28">28</option>
														<option value="29">29</option>
														<option value="30">30</option>
														<option value="31">31</option>
													</select>
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="form-group">
													<select name="start-month" data-placeholder="Start Month" class="select">
														<option></option>
														<option value="1">Enero</option>
														<option value="2">Febrero</option>
														<option value="3">Marzo</option>
														<option value="4">Abril</option>
														<option value="5">Mayo</option>
														<option value="6">Junio</option>
														<option value="7">Julio</option>
														<option value="8">Agosto</option>
														<option value="9">Septiembre</option>
														<option value="10">Octubre</option>
														<option value="11">Noviembre</option>
														<option value="12">Diciembre</option>
													</select>
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="form-group">
													<select name="start-year" data-placeholder="Start Year" class="select">
														<option></option>
														<option>{date('Y')}</option>
														<option>{date('Y')+1}</option>
														<option>{date('Y')+2}</option>
														<option>{date('Y')+3}</option>
													</select>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
									<div class="col-md-6">
										<label>End Date: <span class="text-danger">*</span></label>
										<div class="row">
											
											<div class="col-md-4">
												<div class="form-group">
													<select name="end-day" data-placeholder="End Day" class="select">
														<option></option>
														<option></option>
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
														<option value="5">5</option>
														<option value="6">6</option>
														<option value="7">7</option>
														<option value="8">8</option>
														<option value="9">9</option>
														<option value="10">10</option>
														<option value="11">11</option>
														<option value="12">12</option>
														<option value="13">13</option>
														<option value="14">14</option>
														<option value="15">15</option>
														<option value="16">16</option>
														<option value="17">17</option>
														<option value="18">18</option>
														<option value="19">19</option>
														<option value="20">20</option>
														<option value="21">21</option>
														<option value="22">22</option>
														<option value="23">23</option>
														<option value="24">24</option>
														<option value="25">25</option>
														<option value="26">26</option>
														<option value="27">27</option>
														<option value="28">28</option>
														<option value="29">29</option>
														<option value="30">30</option>
														<option value="31">31</option>
													</select>
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="form-group">
													<select name="end-month" data-placeholder="End Month" class="select">
														<option></option>
														<option value="1">Enero</option>
														<option value="2">Febrero</option>
														<option value="3">Marzo</option>
														<option value="4">Abril</option>
														<option value="5">Mayo</option>
														<option value="6">Junio</option>
														<option value="7">Julio</option>
														<option value="8">Agosto</option>
														<option value="9">Septiembre</option>
														<option value="10">Octubre</option>
														<option value="11">Noviembre</option>
														<option value="12">Diciembre</option>
													</select>
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
													<select name="end-year" data-placeholder="End Year" class="select">
														<option></option>
														<option>{date('Y')}</option>
														<option>{date('Y')+1}</option>
														<option>{date('Y')+2}</option>
														<option>{date('Y')+3}</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="row">
									

									<div class="col-md-12">
										<div class="form-group">
											<label>Overview news:</label>
		                                    <textarea name="NewsText" rows="5" cols="5" placeholder="If you want to add any info, do it here." class="form-control"></textarea>
	                                    </div>
									</div>
								</div>
							</fieldset>

							<div class="form-wizard-actions">
								<input class="btn btn-default" id="basic-back" value="Back" type="reset">
								<input class="btn btn-info" id="basic-next" value="Next" type="submit">
							</div>
						</form>
		            </div>
		            <!-- /basic setup -->
						
{include file="overall_footer.tpl"}