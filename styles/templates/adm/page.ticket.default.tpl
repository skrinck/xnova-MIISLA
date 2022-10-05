{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
	
<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['ingame_setting']}</span> - {$LNG['ti_header']}</h4>
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
							<li><a href="admin.php?page=support">{$LNG['ingame_setting']}</a></li>
							<li class="active">{$LNG['ti_header']}</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li><a href="mailto:rayco.garcia13@nauta.cu"><i class="icon-comment-discussion position-left"></i> {$LNG['ow_support']}</a></li>
						</ul>
					</div>
				</div>
				<!-- /page header -->
				

				<!-- Content area -->
				<div class="content">
					
					<!-- Task manager table -->
					<div class="panel panel-white">
						<div class="panel-heading">
							<h6 class="panel-title">{$LNG['ti_header']}</h6>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                		<li><a data-action="close"></a></li>
			                	</ul>
		                	</div>
						</div>

						<table class="table tasks-list table-lg">
							<thead>
								<tr>
									<th>#</th>
									<th>Period</th>
					                <th>{$LNG['input_text']}</th>
					                <th>{$LNG['nt_priority']}</th>
					                <th>{$LNG['se_search_users'][3]}</th>
					                <th>{$LNG['status']}</th>
					                <th>{$LNG['ti_username']}</th>
									<th class="text-center text-muted" style="width: 30px;"><i class="icon-checkmark3"></i></th>
					            </tr>
							</thead>
							<tbody>
								{foreach $ticketList as $TicketID => $TicketInfo}	
								{if ($type == "" || $TicketInfo.status == $type || ($type==1 && $TicketInfo.status==0) || ($type==2 && $TicketInfo.status>=$type ) ) }
								<tr>
									<td>#{$TicketID}</td>
									<td>{$TicketInfo.time}</td>
					                <td>
					                	<div class="text-semibold"><a href="admin.php?page=support&amp;mode=view&amp;id={$TicketID}">{$TicketInfo.subject}</a></div>
					                	<div class="text-muted">{$TicketInfo.LastMessage}</div>
					                </td>
					                <td>
					                	<div class="btn-group">
											<span class="label label-{$categoriaT[$TicketInfo.categoryID]} dropdown-toggle" data-toggle="dropdown">{$LNG['ti_type'][$TicketInfo.categoryID]}</span>
										</div>
				                	</td>
					                <td>
					                	<div class="input-group input-group-transparent">
					                		<div class="input-group-addon"><i class="icon-calendar2 position-left"></i></div>
					                		{$TicketInfo.time}
					                	</div>
				                	</td>
					                <td>
										{if $TicketInfo.status == 1}<span class="ticket_row_linck_status" style="color:green">{$LNG.ti_status_open}</span>{elseif $TicketInfo.status == 0}<span class="ticket_row_linck_status" style="color:orange">{$LNG.ti_status_answer}</span>{elseif $TicketInfo.status == 99}<span class="ticket_row_linck_status" style="color:blue">{$LNG.ti_status_resolve}</span>{else}<span class="ticket_row_linck_status" style="color:red">{$LNG.ti_status_closed}</span>{/if}
					                </td>
					                <td>
					                	{$TicketInfo.username}
					                </td>
									<td class="text-center">
										<ul class="icons-list">
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
															<ul class="dropdown-menu dropdown-menu-right">
																<li><a href="admin.php?page=support&amp;mode=view&amp;id={$TicketID}"><i class="icon-history"></i> {$LNG['text']}</a></li>
																<li class="divider"></li>
																<li><a href="admin.php?page=support&mode=changestatus&ticketid={$TicketID}&action=resolve"><i class="icon-checkmark3 text-success"></i> {$LNG['resolve_ticket']}</a></li>
																<li><a href="admin.php?page=support&mode=changestatus&ticketid={$TicketID}&action=close"><i class="icon-cross2 text-danger"></i> {$LNG['close_ticket']}</a></li>
															</ul>
														</li>
													</ul>
									</td>
					            </tr>
								{/if}
								{/foreach}
							</tbody>
						</table>
					</div>
					<!-- /task manager table -->
						
{include file="overall_footer.tpl"}