{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['general_setting']}</span> - {$ad_authlevel_title}</h4>
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
							<li><a href="admin.php?page=accountdata">{$LNG['general_setting']}</a></li>
							<li class="active">{$ad_authlevel_title}</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li><a href="mailto:rayco.garcia13@nauta.cu"><i class="icon-comment-discussion position-left"></i> {$LNG['ow_support']}</a></li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
					<div class="panel panel-flat">
						<div class="panel-body">
							<legend class="text-semibold">
								<i class="icon-file-text2 position-left"></i>
								{$ad_authlevel_title}
								<a class="control-arrow" data-toggle="collapse" data-target="#table1">
									<i class="icon-circle-down2"></i>
								</a>
							</legend>
							<div class="collapse in" id="Frame8">
								<form action="" method="post" name="users">
										<table width="55%">
										<tr>
											<td colspan="2">
											<select name="id_1" size="20" style="width:80%;">
												{$UserList}
											</select>
											
											<script type="text/javascript">
												var UserList = new filterlist(document.getElementsByName('id_1')[0]);
											</script>
											<br>
											<a href="?page=rights&amp;mode=rights&amp;sid={$sid}&amp;get=adm">{$ad_authlevel_aa}</a>&nbsp;
											<a href="?page=rights&amp;mode=rights&amp;sid={$sid}&amp;get=ope">{$ad_authlevel_oo}</a>&nbsp;
											<a href="?page=rights&amp;mode=rights&amp;sid={$sid}&amp;get=mod">{$ad_authlevel_mm}</a>&nbsp;
											<a href="?page=rights&amp;mode=rights&amp;sid={$sid}&amp;get=pla">{$ad_authlevel_jj}</a>&nbsp;
											<a href="?page=rights&amp;mode=rights&amp;sid={$sid}">{$ad_authlevel_tt}</a>&nbsp;
											<br><br>
											<a href="javascript:UserList.set('^A')" title="{$bo_select_title} A">A</a>
											<a href="javascript:UserList.set('^B')" title="{$bo_select_title} B">B</a>
											<a href="javascript:UserList.set('^C')" title="{$bo_select_title} C">C</a>
											<a href="javascript:UserList.set('^D')" title="{$bo_select_title} D">D</a>
											<a href="javascript:UserList.set('^E')" title="{$bo_select_title} E">E</a>
											<a href="javascript:UserList.set('^F')" title="{$bo_select_title} F">F</a>
											<a href="javascript:UserList.set('^G')" title="{$bo_select_title} G">G</a>
											<a href="javascript:UserList.set('^H')" title="{$bo_select_title} H">H</a>
											<a href="javascript:UserList.set('^I')" title="{$bo_select_title} I">I</a>
											<a href="javascript:UserList.set('^J')" title="{$bo_select_title} J">J</a>
											<a href="javascript:UserList.set('^K')" title="{$bo_select_title} K">K</a>
											<a href="javascript:UserList.set('^L')" title="{$bo_select_title} L">L</a>
											<a href="javascript:UserList.set('^M')" title="{$bo_select_title} M">M</a>
											<a href="javascript:UserList.set('^N')" title="{$bo_select_title} N">N</a>
											<a href="javascript:UserList.set('^O')" title="{$bo_select_title} O">O</a>
											<a href="javascript:UserList.set('^P')" title="{$bo_select_title} P">P</a>
											<a href="javascript:UserList.set('^Q')" title="{$bo_select_title} Q">Q</a>
											<a href="javascript:UserList.set('^R')" title="{$bo_select_title} R">R</a>
											<a href="javascript:UserList.set('^S')" title="{$bo_select_title} S">S</a>
											<a href="javascript:UserList.set('^T')" title="{$bo_select_title} T">T</a>
											<a href="javascript:UserList.set('^U')" title="{$bo_select_title} U">U</a>
											<a href="javascript:UserList.set('^V')" title="{$bo_select_title} V">V</a>
											<a href="javascript:UserList.set('^W')" title="{$bo_select_title} W">W</a>
											<a href="javascript:UserList.set('^X')" title="{$bo_select_title} X">X</a>
											<a href="javascript:UserList.set('^Y')" title="{$bo_select_title} Y">Y</a>
											<a href="javascript:UserList.set('^Z')" title="{$bo_select_title} Z">Z</a>

											<BR>
											<INPUT NAME="regexp" onKeyUp="UserList.set(this.value)">
											<INPUT TYPE="button" onClick="UserList.set(this.form.regexp.value)" value="{$button_filter}">
											<INPUT TYPE="button" onClick="UserList.reset();this.form.regexp.value=''" value="{$button_deselect}">
											</td>
										</tr>
										<tr>
											<td colspan="3">
											<br>
											<input type="submit" value="{$button_submit}"></td>
										</tr>
									</table>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
{include file="overall_footer.tpl"}