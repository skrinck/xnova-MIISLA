{include file="overall_header.tpl"}
{include file="overall_menu.tpl"}
	<!-- Theme JS files -->

<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{$LNG['mu_utility']}</span> - {$LNG['mu_news']}</h4>
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
							<li><a href="admin.php?page=news">{$LNG['mu_utility']}</a></li>
							<li class="active">{$LNG['mu_news']}</li>
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
							<form class="form-horizontal" action="admin.php?page=news&action=send&mode=2" method="post">
								<div class="panel panel-flat">


									<div class="panel-body">
										<fieldset>
											<legend class="text-semibold">
												<i class="fa fa-envelope "></i>
												<span id="title">{$LNG['mu_news']}</span>
												<a class="control-arrow" data-toggle="collapse" data-target="#demo1">
													<i class="icon-circle-down2"></i>
												</a>
											</legend>
 
											<div class="collapse in" id="demo1">
												<div class="container">
													<div class="row">
														{nocache}{if isset($mode)}
														<form method="POST" action="?page=news&amp;action=send&amp;mode={$mode}" style="width: 100%">
															{if $news_id}<input class="btn btn-dark btn-xs" name="id" type="hidden" value="{$news_id}">{/if}
															<table class="content_page">
																<tr>
																	<td width="25%">{$nws_title}</td>
																	<td><input type="text" name="title" value="{$news_title}"></td>
																</tr>
																<tr>
																	<td>{$nws_content}</td>
																	<td><textarea cols="70" rows="10" name="text" style="height: 250px;">{$news_text}</textarea></td>
																</tr>
																<tr>
																	<td colspan="2"><button class="btn btn-default btn-xs" type="submit" >{$button_submit}</button></td>
																</tr>
															</table>
														</form>
														{/if}{/nocache}

														{if !isset($mode)}
															<div class="row">
															<div class="col-md-10">
															<table class="table datatable-highlight">
																<thead>
																	<tr>
																		<th>{$nws_id}</th>
																		<th>{$nws_title}</th>
																		<th>{$nws_date}</th>
																		<th>{$nws_from}</th>
																		<th>{$nws_del}</th>
																	</tr>
																</thead>
																<tbody>
																	{foreach name=NewsList item=NewsRow from=$NewsList}
																	<tr>
																		<td><a href="?page=news&amp;action=edit&amp;id={$NewsRow.id}">{$NewsRow.id}</a></td>
																		<td><a href="?page=news&amp;action=edit&amp;id={$NewsRow.id}">{$NewsRow.title}</a></td>
																		<td><a href="?page=news&amp;action=edit&amp;id={$NewsRow.id}">{$NewsRow.date}</a></td>
																		<td><a href="?page=news&amp;action=edit&amp;id={$NewsRow.id}">{$NewsRow.user}</a></td>
																		<td class="text-center"><a href="?page=news&amp;action=delete&amp;id={$NewsRow.id}" onclick="return confirm('{$NewsRow.confirm}');"><i class="fas fa-trash fa-1x text-danger"></i></a></td>
																		<td style="display:none"></td>
																	</tr>
																	{/foreach}
																</tbody>
															</table>
															<a class="btn btn-default btn-xs" href="?page=news&amp;action=create">{$nws_create}</a>
														</div>
														</div>
														{/if}
													</div>
												</div>
												</div>
												</div>
<script>
  $('td').css('padding','10px');
  $('input').addClass('form-control');
  {if isset($mode)}
  	$('#title').html('{$nws_head}');
  {/if}
</script>
{include file="overall_footer.tpl"}