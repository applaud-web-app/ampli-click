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
	<title>Admin Login : Ampliclicks Academy</title>

	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="{{asset('images/favicon.png')}}">
	<link href="{{asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
	<link href="{{asset('css/style.css')}}" rel="stylesheet">

</head>

<body class="body  h-100">

	<div class="authincation h-100" style="background-color:var(--rgba-primary-1)">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
								<div>
									@include('message')
								</div>
                                <div class="auth-form">
									<div class="text-center">
										<a href="/"><img src="{{asset('images/logo.png')}}" alt="" class="img-fluid" width="200"></a>
									</div>
                                    
                                    <form action="{{url('adminLogincheck')}}" method="POST">
										@csrf
										<h2 class="text-center mb-4">Admin Login</h2>
										<div class="mb-3">
											<label for="exampleFormControlInput1"
												class="form-label mb-2">Email Id <span
													class="text-danger">*</span></label>
											<input type="text" class="form-control" name="email"
												id="exampleFormControlInput1" placeholder="Enter Valid Email" value=""
												required>
											@error('email') <span class="text-danger">{{$message}}</span> @enderror
										</div>
										<div class="mb-3">
											<label for="exampleFormControlInput1"
												class="form-label mb-2">Password <span
													class="text-danger">*</span></label>
											<input type="password" class="form-control" name="password"
												id="exampleFormControlInput2" placeholder="Enter Valid Password" required>
											@error('password') <span class="text-danger">{{$message}}</span> @enderror
										</div>
										<button type="submit" class="mt-4 btn btn-block btn-primary">Login</button>
									</form>
                                   
                                </div>
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

</body>


</html>