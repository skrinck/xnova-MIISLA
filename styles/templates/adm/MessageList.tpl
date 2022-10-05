{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['ingame_setting']}</span> - {$LNG['mu_mess_list']}</h4>
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
							<li><a href="admin.php?page=messagelist">{$LNG['ingame_setting']}</a></li>
							<li class="active">{$LNG['mu_mess_list']}</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li><a href="mailto:rayco.garcia13@nauta.cu"><i class="icon-comment-discussion position-left"></i> {$LNG['ow_support']}</a></li>
							
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-envelope position-left"></i>
									{$LNG['mg_type'][$type]}
									<span class="caret"></span>
								</a>

								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="admin.php?page=messagelist&type=0"> {$LNG['mg_type'][0]}</a></li>
									<li><a href="admin.php?page=messagelist&type=1"> {$LNG['mg_type'][1]}</a></li>
									<li><a href="admin.php?page=messagelist&type=2"> {$LNG['mg_type'][2]}</a></li>
									<li><a href="admin.php?page=messagelist&type=3"> {$LNG['mg_type'][3]}</a></li>
									<li><a href="admin.php?page=messagelist&type=4"> {$LNG['mg_type'][4]}</a></li>
									<li><a href="admin.php?page=messagelist&type=5"> {$LNG['mg_type'][5]}</a></li>
									<li><a href="admin.php?page=messagelist&type=15"> {$LNG['mg_type'][15]}</a></li>
									<li><a href="admin.php?page=messagelist&type=50"> {$LNG['mg_type'][50]}</a></li>
									<li><a href="admin.php?page=messagelist&type=99"> {$LNG['mg_type'][99]}</a></li>
									<li><a href="admin.php?page=messagelist&type=100"> {$LNG['mg_type'][100]}</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">


					<!-- Individual column searching (text inputs) -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">{$LNG['mg_type'][$type]}</h5>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                	</ul>
		                	</div>
						</div>


						<table class="table datatable-column-search-inputs">
							<thead>
								<tr>
					                <th>{$LNG.ml_type}</th>
									<th>{$LNG.ml_subject}</th>
					                <th>{$LNG.ml_date}</th>
					                <th>{$LNG.ml_sender}</th>
					                <th>{$LNG.ml_receiver}</th>
					                <th>{$LNG.ml_id}</th>
					            </tr>
							</thead>
							<tbody>
							
							{foreach $messageList as $messageID => $messageRow}
								<tr data-messageID="{$messageID}">
					                <td>{$LNG.mg_type[$messageRow.type]}</td>
					                <td>{$messageRow.subject}</td>
					                <td>{$messageRow.time}</td>
					                <td>{$messageRow.sender}</td>
					                <td>{$messageRow.receiver}</td>
									<td><a href="#" data-toggle="modal" data-target="#modal_theme_success{$messageID}">{$messageID}</a></td>
					            </tr>
					        {/foreach} 
							</tbody>
							<tfoot>
								<tr>
					                <td>Type</td>
					                <td>Subject</td>
					                <td>Start Date</td>
					                <td>Sender</td>
					                <td>Receiver</td>
					                <td></td>
					            </tr>
							</tfoot>
						</table>
					</div>
					<!-- /individual column searching (text inputs) -->

{foreach $messageList as $messageID => $messageRow}
		<!-- Success modal -->
	<div id="modal_theme_success{$messageID}" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-success">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h6 class="modal-title">{$messageRow.subject}</h6>
				</div>

				<div class="modal-body">
					<p>
						{$messageRow.text} 
					</p>
					<hr>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">{$LNG['tutorial_close_info']}</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /success modal -->
{/foreach}
					
{include file="overall_footer.tpl"}