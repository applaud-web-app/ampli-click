<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
	<!-- All Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="Learning Management System">
	<meta name="robots" content="Learning Management System">
	<meta name="keywords" content="Learning Management System">
	<meta name="description" content="Learning Management System">
	<meta property="og:title" content="Learning Management System">
	<meta property="og:description" content="Learning Management System">
	<meta property="og:image" content="social-image.html">
	<meta name="format-detection" content="telephone=no">

	<!-- Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Page Title Here -->
	<title>Trainer Login : Dhibrahm LMS</title>

	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="{{asset('images/favicon.png')}}">
	<link href="{{asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
	<link href="{{asset('css/style.css')}}" rel="stylesheet">
	<link href="{{asset('css/iziToast.min.css')}}" rel="stylesheet">

</head>

<body class="body  h-100">
	<div class="authincation d-flex flex-column flex-lg-row flex-column-fluid">
		<div class="login-aside text-center  d-flex flex-column flex-row-auto">
			<div class="d-flex flex-column-auto flex-column py-3">

				<img src="{{asset('images/logo.png')}}" alt="" class="bg-white mb-3 mx-auto rounded-1" width="200">
				
				<h3 class="mb-0 text-white">Welcome back!</h3>
				<p class="text-white mb-0">Please enter your email and password to access your account.</p>
			</div>
			<div class="aside-image position-relative" style="background-image:url(images/login2.png);">
				{{-- <img class="img1 move-1" src="{{asset('images/background/pic3.png')}}" alt="">
				<img class="img2 move-2" src="{{asset('images/background/pic4.png')}}" alt="">
				<img class="img3 move-3" src="{{asset('images/background/pic5.png')}}" alt=""> --}}
			</div>
		</div>
		<div
			class="container flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
			<div class="col-md-12">
				@include('message')
			</div>
			<div class="d-flex justify-content-center h-100 align-items-center">
				<div class="authincation-content style-2">
					<div class="row no-gutters">
						<div class="col-xl-12 tab-content">
							<div id="sign-up" class="auth-form tab-pane fade show active  form-validation">
								<form action="{{route('staffLogin')}}" method="POST">
									@csrf
									<h1 class="d-flex align-items-center mb-0 text-uppercase">Trainer Login</h1>
									<div class="mb-3">
										<label for="exampleFormControlInput1"
											class="form-label mb-2 fs-13 label-color font-w500">Email Id <span
												class="text-danger">*</span></label>
										<input type="text" class="form-control" name="email"
											id="exampleFormControlInput1" placeholder="Enter Valid Email" value=""
											required>
										@error('email') <span class="text-danger">{{$message}}</span> @enderror
									</div>
									<div class="mb-3">
										<label for="exampleFormControlInput1"
											class="form-label mb-2 fs-13 label-color font-w500">Password <span
												class="text-danger">*</span></label>
										<input type="password" class="form-control" name="password"
											id="exampleFormControlInput2" placeholder="Enter Valid Password" required>
										@error('password') <span class="text-danger">{{$message}}</span> @enderror
									</div>
									<button type="submit" class="btn btn-block btn-primary">Login</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--**********************************
        Scripts
    ***********************************-->
	<!-- Required vendors -->
	<script src="{{asset('vendor/global/global.min.js')}}"></script>
	<script src="{{asset('js/custom.min.js')}}"></script>
	<script src="{{asset('js/dlabnav-init.js')}}"></script>
	<script src="{{asset('js/iziToast.min.js')}}"></script>
	@if($message = Session::get('success'))
	<script>
		iziToast.success({
			title: 'Success',
			message: '{{$message}}',
			position: 'topRight',
		});
	</script>
	@endif
	@if($message = Session::get('error'))
	<script>
		iziToast.error({
			title: 'Error',
			message: '{{$message}}',
			position: 'topRight',
		});
	</script>
	@endif
</body>


</html>