{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['ingame_setting']}</span> - {$LNG['mu_info_account_page']}</h4>
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
							<li><a href="admin.php?page=accountdata">{$LNG['ingame_setting']}</a></li>
							<li>{$LNG['mu_info_account_page']}</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li><a href="mailto:rayco.garcia13@nauta.cu"><i class="icon-comment-discussion position-left"></i> {$LNG['ow_support']}</a></li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">


					<form class="form-horizontal" method="post" name="users">
					<!-- Using API -->
					<div class="panel panel-flat">

						<table class="table" width="100%">
							<thead>
								<tr>
						            <td>
										<select name="id_u" size="20" style="width:100%;">
											{$Userlist}
										</select>
										<SCRIPT type="text/javascript">
											var UserList = new filterlist(document.users.id_u);
										</SCRIPT>
										<br><br>
										<div class="form-group has-feedback has-feedback-left">
											<input type="text" class="form-control input-lg" name="regexp" placeholder="{$LNG.filter_user}" onKeyUp="UserList.set(this.value)">
											<div class="form-control-feedback">
												<i class="icon-search4"></i>
											</div>
										</div>
									</td>
						        </tr>
								
							</thead>
						</table>
						
					</div>
					<!-- /using API -->
					
					<div class="text-right">
							<button type="submit" class="btn btn-primary">{$LNG['qe_submit']} <i class="icon-arrow-right14 position-right"></i></button>
						</div>
					</form>
{include file="overall_footer.tpl"}