<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{$LNG['adm_cp_title']} | xNova</title>

	<!-- Global stylesheets -->
	<link href="styles/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="styles/assets/css/minified/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="styles/assets/css/minified/core.min.css" rel="stylesheet" type="text/css">
	<link href="styles/assets/css/minified/components.min.css" rel="stylesheet" type="text/css">
	<link href="styles/assets/css/minified/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="styles/assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="styles/assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="styles/assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="styles/assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->


	<!-- Theme JS files -->
	<script type="text/javascript" src="styles/assets/js/core/app.js"></script>
	<!-- /theme JS files -->

</head>

<body>

	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.php"><img src="styles/images/rootbanner.png" alt=""></a>

			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			</ul>
		</div>

	</div>
	<!-- /main navbar -->
	<!-- Page container -->
	<div class="page-container login-container">

		<!-- Page content -->
		<div class="page-content">
		<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content">
					<!-- Simple login form -->
					<form method="post">
						<div class="panel panel-body login-form">
						
							<div class="text-center">
								<div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
								<h5 class="content-group">{$LNG['adm_cp_title']} <small class="display-block">{$LNG['adm_password_info']}</small></h5>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="text" class="form-control" readonly value="{$username}">

							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="password" class="form-control" name="admin_pw" placeholder="{$LNG['adm_password']}" required>

							</div>

							<div class="form-group">
								<button type="submit" name="btn-login" class="btn btn-primary btn-block">{$LNG['adm_login']} <i class="icon-circle-right2 position-right"></i></button>
							</div>
						</div>
					</form>
					<!-- /simple login form -->
{include file="overall_footer.tpl"}