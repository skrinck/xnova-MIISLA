{block name="title" prepend}{$LNG.siteTitleIndex}{/block}
{block name="content"}
	<div class="jumbotron hidden-xs" style="margin-top:10px;">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-lg-12">
					<h1>{$descHeader}</h1>
					<p>{$descText}</p>
					<p style="text-align: center;"><a class="btn btn-lg btn-success" href="index.php?page=screens">{$LNG.buttonScreenshot}</a></p>
				</div>
			</div>
		</div>
	</div>

	<div class="container mobile">
		<div class="row">
			<div class="col-lg-6">
				<div class="panel panel-default">
					<div class="panel-heading">{$LNG.siteTitleNews}</div>
                    {foreach $newsList as $newsRow}
						<div class="panel-body">
							<h1 class="page-header">{$newsRow.title}</h1>
							<p>{$newsRow.text}</p>
						</div>
                    {foreachelse}
						<div class="panel-body">
							<h3 class="page-header">{$LNG.news_does_not_exist}</h3>
						</div>
                    {/foreach}
					<div style="text-align: right; padding: 10px;">
						<a href="index.php?page=news">
							<button type="button" class="btn btn-success">{$LNG.siteTitleNewsall}</button>
						</a>
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="panel panel-default">
					<div class="panel-heading">{$LNG.loginadmin}</div>
					<div class="panel-body">
						<div class="title">
							<span>{foreach $AdminsOnline as $ID => $Name}{if !$Name@first}&nbsp;&bull;&nbsp;{/if}{$Name}{foreachelse}{$LNG.ov_no_admins_online}{/foreach}</span>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">{$LNG.loginHeader}</div>
					<div class="panel-body">
						<form id="login" name="login" action="index.php?page=login" data-action="index.php?page=login" method="post">
							<input type="hidden" name="secret" value="{$token}">
							<div class="form-group">
								<label for="universe">{$LNG.universe}</label>
								<select name="uni" id="universe" class="form-control changeAction">{html_options options=$universeSelect selected=$UNI}</select>
							</div>
							<div class="form-group">
								<label for="username">{$LNG.loginUsername}</label>
								<input type="text" class="form-control" name="username" id="username" placeholder="{$LNG.loginUsername}">
							</div>
							<div class="form-group">
								<label for="password">{$LNG.loginPassword}</label>
								<input type="password" class="form-control" name="password" id="password" placeholder="{$LNG.loginPassword}">
							</div>
							<div style="text-align: right;">
								<button type="submit" class="btn btn-primary">{$LNG.loginButton}</button>
							</div>
						</form>
						<div style="text-align: center">
							<a href="index.php?page=register">{$LNG.buttonRegister}</a> {if $mailEnable}- <a href="index.php?page=lostPassword">{$LNG.buttonLostPassword}</a>{/if}
							<br>
							<span class="small">{$loginInfo}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
{/block}
{block name="script" append}
<script>{if $code}alert({$code|json});{/if}</script>
{/block}