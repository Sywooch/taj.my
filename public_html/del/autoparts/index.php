<?php 
session_start();
if(isset($_POST['name'])&&isset($_POST['password'])&&$_POST['name']=='administrator'&&$_POST['password']=='lvivservice2018Ua') {
	$_SESSION['key']='216f6cfbc78a3cbcad52301ffa8dea81edf1b3ad3a5f3d2fe0147d2837461043';
}
	
if(isset($_SESSION['key'])&&$_SESSION['key']=='216f6cfbc78a3cbcad52301ffa8dea81edf1b3ad3a5f3d2fe0147d2837461043') {
	if(isset($_GET['back'])) {
		header('Location: '.urldecode($_GET['back']));
	} else {
		header('Location: /admin/');
	}
}
?>
	<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">
		<title>Admin - Головна - A4Studio </title>
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="JSOFT Admin - Responsive HTML5 Template">
		<meta name="author" content="

	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Admin - A4Studio </title>
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="">
		<meta name="author" content="Vadym Bohdanovych">


		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="../assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="../assets/vendor/modernizr/modernizr.js"></script>

	</head>
	<body>
		<section class="body">
		
		
		<!doctype html>
<html class="fixed">
		<!-- start: page -->
		<section class="body-sign body-locked">
			<div class="center-sign">
				<div class="panel panel-sign">
					<div class="panel-body">
						<form action="/admin/login/<?php if(isset($_GET['back'])) echo '?back='.urlencode($_GET['back']);?>" method="POST">
							<div class="current-user text-center">
								<img src="http://gadjet-service.com/images/logo-3.png" style="height: auto; background: #FFF; top: -80px; padding: 45px 5px;" alt="Gadjet Service" class="img-circle user-image" />
								<h2 class="user-name text-dark m-none">Вхід до адміністративної панелі</h2>
								<p class="user-email m-none">Будь ласка, авторизуйтесь</p>
							</div>
							<div class="form-group mb-lg">
								<div class="input-group input-group-icon">
									<input id="pwd" name="name" type="name" class="form-control input-lg" placeholder="Логін" />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-user"></i>
										</span>
									</span>
								</div>
							</div>
							<div class="form-group mb-lg">
								<div class="input-group input-group-icon">
									<input id="pwd" name="password" type="password" class="form-control input-lg" placeholder="Пароль" />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-lock"></i>
										</span>
									</span>
								</div>
							</div>

							<div class="row">
								<div class="col-xs-6">
								</div>
								<div class="col-xs-6 text-right">
									<button type="submit" class="btn btn-primary">Авторизація</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
		<!-- end: page -->

		<!-- Vendor -->
		<script src="../assets/vendor/jquery/jquery.js"></script>
		<script src="../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="../assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="../assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="../assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>

	</body>
</html>