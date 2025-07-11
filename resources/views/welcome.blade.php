<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>PILIH MENU TS</title>
	<link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets') }}/ptagafood/menu/css/styles.css" rel="stylesheet" />
	<style>
		.bg-gradient
		{
			background: #26C784;
			background: -webkit-linear-gradient(to right, #11998e, #26C784);
			background: linear-gradient(to right, #11998e, #26C784);
		}

		.card
		{
			-webkit-box-shadow: 0 8px 6px -6px #CCCCCC;
			-moz-box-shadow: 0 8px 6px -6px #CCCCCC;
			box-shadow: 0 8px 6px -6px #CCCCCC;
		}
		.col-md-4
		{
			margin-bottom: 30px;
		}
	</style>
</head>
<body id="page-top">

	<nav class="navbar navbar-expand-lg  text-uppercase fixed-top" style="background:#00B7B5;" id="mainNav">
		<div class="container">
			<a class="navbar-brand js-scroll-trigger" href="#page-top">RESTAURANT</a>
		</div>
	</nav>

	<header class="text-white text-center" style="margin-top: 150px;"></header>

	<div class="container" style="margin-bottom:50px; ">
		<h5 style="color: #00B7B5;" class="text-center">"WHO LIKES THE SYSTEM WILL MAKE IT EASIER TO WORK"</h5>
		<div class="row justify-content-center" style="margin-top: 50px;">
			
			<div class="col-md-4">
				<a href="{{ route('auth', ['id_lokasi' => 1]) }}">
					<div class="card">
						<div class="card-body">
							<center>
								<img width="100%" height="250px;" src="{{ asset('assets') }}/ptagafood/logo/Takemori_new.jpg" alt="">
							</center>
							<hr>
							<h5 class="text-center" style="color: #00B7B5;">TAKEMORI</h5>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-4">
				<a href="{{ route('auth', ['id_lokasi' => 2]) }}">
					<div class="card">
						<div class="card-body">
							<center>
								<img width="100%" height="250px;" src="{{ asset('assets') }}/ptagafood/logo/soondobu.jpg" alt="">
							</center>
							<hr>
							<h5 class="text-center" style="color: #00B7B5;">SOONDOBU</h5>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-4">
				<a href="https://majoo.putrirembulan.com/AuthAdmin">
					<div class="card">
						<div class="card-body">
							<center>
								<img width="100%" height="250px;" src="{{ asset('assets') }}/ptagafood/logo/boxes.png" alt="">
							</center>
							<hr>
							<h5 class="text-center" style="color: #00B7B5;">Management Bahan</h5>
						</div>
					</div>
				</a>
			</div>

		</div>
	</div>

	<div class="py-4 text-center text-white" style="background:#00B7B5;">
		<div class="container"><small>Copyright ©2021 PT. AGA FOOD </small></div>
	</div>

	<div class="scroll-to-top d-lg-none position-fixed">
		<a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top"><i class="fa fa-chevron-up"></i></a>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

</body>
</html>
