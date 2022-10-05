{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
<!-- Secondary sidebar -->
			<div class="sidebar sidebar-secondary sidebar-default">
				<div class="sidebar-content">

					<!-- Actions -->
					<div class="sidebar-category">
						<div class="category-title">
							<span>{$LNG['al_actions']}</span>
							<ul class="icons-list">
								<li><a href="#" data-action="collapse"></a></li>
							</ul>
						</div>

						<div class="category-content">
							{if $ticket_status == 2 || $ticket_status == 99}<a href="admin.php?page=support&mode=changestatus&ticketid={$ticketID}&action=open" class="btn bg-success-400 btn-rounded btn-block btn-xs">{$LNG['reopen_ticket']}</a>{else}<a href="admin.php?page=support&mode=changestatus&ticketid={$ticketID}&action=close" class="btn bg-pink-400 btn-rounded btn-block btn-xs">{$LNG['close_ticket']}</a>{/if}
						</div>
					</div>
					<!-- /actions -->


					<!-- Sub navigation -->
					<div class="sidebar-category">
						<div class="category-title">
							<span>{$LNG['ti_id']}</span>
							<ul class="icons-list">
								<li><a href="#" data-action="collapse"></a></li>
							</ul>
						</div>

						<div class="category-content no-padding">
							<ul class="navigation navigation-alt navigation-accordion">
								
								<li><a href="admin.php?page=support"><i class="icon-files-empty"></i> {$LNG['ti_all']} <span class="badge badge-danger">{$TotalCounts}</span></a></li>
								<li><a href="admin.php?page=support&type=active"><i class="icon-file-plus"></i> {$LNG['ti_active']} <span class="badge badge-default">{$activeCounts}</span></a></li>
								<li><a href="admin.php?page=support&type=closed"><i class="icon-file-locked"></i> {$LNG['ti_closed']}  <span class="badge badge-success">{$ClosedCounts+$ResolvedCounts}</span></a></li>
								
							</ul>
						</div>
					</div>
					<!-- /sub navigation -->

					<!-- Latest updates -->
					<div class="sidebar-category">
						<div class="category-title">
							<span>{$LNG['se_search_users'][3]}</span>
							<ul class="icons-list">
								<li><a href="#" data-action="collapse"></a></li>
							</ul>
						</div>

						<div class="category-content">
							<ul class="media-list">
								{foreach $latest as $key =>$value}
								<li class="media">
									<div class="media-left"><a href="#" class="btn border-success text-success btn-flat btn-icon btn-sm btn-rounded"><i class="icon-checkmark3"></i></a></div>
									<div class="media-body">
										<a href="admin.php?page=support&mode=view&id={$value['ticketID']}">{$value['ownerName']} - {$value['subject']}</a>
										<p class="media-annotation">{substr($value['message'],0,50)}...</p>
										<div class="media-annotation"> {$LNG.ago}: {$value['timem']}</div>
									</div>
								</li>
								{/foreach}
							</ul>
						</div>
					</div>
					<!-- /latest updates -->
				</div>
			</div>
			<!-- /secondary sidebar -->
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
								<a href="admin.php?page=rights&mode=users&sid={session_id()}" class="btn btn-link btn-float has-text"><i class="fa fa-angle-double-up fa-2x text-primary"></i><span>{$LNG['rank']['rank']}</span></a>
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

					<!-- Basic layout -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h6 class="panel-title">[#{$ticketID}] {$ticket_subject}</h6>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                	</ul>
		                	</div>
						</div>

						<div class="panel-body">
							<ul class="media-list chat-list content-group">
								
								{foreach $answerList as $answerID => $answerRow}
								<li class="media{if $answerRow.isAdmin > 0} reversed{/if}">
								{if $answerRow.isAdmin > 0}
									<div class="media-body">
										<div class="media-content">{$answerRow.message}</div>
										<span class="media-annotation display-block mt-10">{$answerRow.time} ago <a href="#"><i class="icon-pin-alt position-right text-muted"></i> {$answerRow.ownerName}</a></span>
									</div>

									<div class="media-right">
										<a href="assets/images/admin_ava.jpg">
											<img src="assets/images/admin_ava.jpg" class="img-circle" alt="">
										</a>
									</div>

								{else}
									<div class="media-left">
										<a href="assets/images/Xterium.jpg">
											<img src="assets/images/Xterium.jpg" class="img-circle" alt="">
										</a>
									</div>

									<div class="media-body">
										<div class="media-content">{$answerRow.message}</div>
										<span class="media-annotation display-block mt-10">{$answerRow.time} ago <a href="#"><i class="icon-pin-alt position-right text-muted"></i> {$answerRow.ownerName}</a></span>
									</div>
								{/if}
								</li>
								{/foreach}
								
					
								
							</ul>
							{if $ticket_status != 2 && $ticket_status != 99}<form action="admin.php?page=support&mode=send" method="post" id="form">
							<input type="hidden" name="id" value="{$ticketID}">
	                    	<textarea name="enter-message" class="form-control content-group" name="message" rows="3" cols="1" placeholder="Enter your message..."></textarea>{/if}

	                    	<div class="row">
	                    		<div class="col-xs-12 text-right">
		                            {if ($ticket_status != 2 && $ticket_status != 99)}<button type="button" onclick="location.href='admin.php?page=support&mode=changestatus&ticketid={$ticketID}&action=close';" class="btn bg-danger-400 btn-labeled btn-labeled-right"><b><i class="icon-cross2"></i></b> Close</button>
									{else}
									<button type="button" onclick="location.href='admin.php?page=support&mode=changestatus&ticketid={$ticketID}&action=open';" class="btn bg-success-400 btn-labeled btn-labeled-right"><b><i class="icon-checkmark3"></i></b> {$LNG['reopen_ticket']}</button>
									{/if}
		                            {if $ticket_status != 2 && $ticket_status != 99}<button type="submit" class="btn bg-teal-400 btn-labeled btn-labeled-right"><b><i class="icon-circle-right2"></i></b> Send</button>{/if}
	                    		</div>
	                    	</div>
							{if $ticket_status != 2 && $ticket_status != 99}</form>{/if}
						</div>
					</div>
					<!-- /basic layout -->
{include file="overall_footer.tpl"}