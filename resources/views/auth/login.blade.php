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
	<title>Learner Login : Ampliclicks Academy</title>

	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="{{asset('images/favicon.png')}}">
	<link href="{{asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
	<link href="{{asset('css/style.css')}}" rel="stylesheet">
	<link href="{{asset('css/iziToast.min.css')}}" rel="stylesheet">
	<style>
        #page_loader{
            display: flex;
			position: absolute;
			width: 100%;
			height: 100%;
			top: 0px;
			left: 0px;
			justify-content: center;
			align-items: center;
			background: #ffffff52;
			z-index: 1;
        }
        .lds-dual-ring,
        .lds-dual-ring:after {
            box-sizing: border-box;
        }
        .lds-dual-ring {
            display: inline-block;
            width: 80px;
            height: 80px;
        }
        .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 64px;
        height: 64px;
        margin: 8px;
        border-radius: 50%;
        border: 6.4px solid currentColor;
        border-color: currentColor transparent currentColor transparent;
        animation: lds-dual-ring 1.2s linear infinite;
        }
        @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
        }
    </style>
</head>

<body class="body  h-100">
	<div class="authincation d-flex flex-column flex-lg-row flex-column-fluid">
		<div class="login-aside text-center  d-flex flex-column flex-row-auto">
			<div class="d-flex flex-column-auto flex-column py-3">
				<img src="{{asset('images/logo.png')}}" alt="" class="bg-white mb-3 mx-auto rounded-1" width="200">
				<h3 class="mb-0 text-white">Welcome back!</h3>
				<p class="text-white mb-0">Please enter your email and password to access your account.</p>
			</div>
			<div class="aside-image position-relative" style="background-image:url(images/login1.png);">
				{{-- <img class="img1 move-1" src="{{asset('images/background/pic3.png')}}" alt="">
				<img class="img2 move-2" src="{{asset('images/background/pic4.png')}}" alt="">
				<img class="img3 move-3" src="{{asset('images/background/pic5.png')}}" alt=""> --}}
			</div>
		</div>
		<div
			class="container flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
			<div class="d-flex justify-content-center h-100 align-items-center">
				<div class="authincation-content style-2">
					<div class="row no-gutters">
						<div class="col-xl-12 tab-content">
							<div id="page_loader" style="display:none;">
                                <div class="lds-dual-ring"></div>
                            </div>
							<div id="sign-up" class="auth-form tab-pane fade show active  form-validation">
								<form action="{{route('login')}}" method="POST" id="login_frm" name="login_frm">
									@csrf
									<h1 class="d-flex align-items-center mb-0">Learner Login</h1>
									<p class="text-danger" id="error_msg"></p>
									<div class="mb-3 lg_frm">
										<label for="exampleFormControlInput1"
											class="form-label mb-2 fs-13 label-color font-w500">Username <span
												class="text-danger">*</span></label>
										<input type="text" class="form-control" name="username"
											id="username" placeholder="Enter Valid Username" value=""
											required>
										@error('username') <span class="text-danger">{{$message}}</span> @enderror
									</div>
									<div class="mb-3 lg_frm">
										<label for="exampleFormControlInput1"
											class="form-label mb-2 fs-13 label-color font-w500">Password <span
												class="text-danger">*</span></label>
										<input type="password" class="form-control" name="password"
											id="password" placeholder="Enter Valid Password" required>
										@error('password') <span class="text-danger">{{$message}}</span> @enderror
									</div>

									<div class="mb-3 otp_frm" style="display: none;">
										<label for="exampleFormControlInput1"
											class="form-label mb-2 fs-13 label-color font-w500">Enter OTP Send to your mobile number <span id="numbersend" class="ms-1"></span></label>
										<input type="text" class="form-control" name="otp_txt"
											id="otp_txt" placeholder="Enter OTP" required>
									</div>
									<div id="resend_block">
                                        <p id="resend_txt"></p>
                                    </div>
									<button type="button" class="btn btn-block btn-primary" id="login_btn">Login</button>
									<button type="button" class="btn btn-block btn-primary" id="verify_btn" style="display: none;">Verify</button>
								</form>
								<div id="recaptcha-container" class="mb-3"></div>
								<div class="new-account mt-3 text-center lg_frm">
									<p class="font-w500">Don't have any account? <a class="text-primary"
											href="/register" data-toggle="tab">Register</a></p>
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
	<script src="{{asset('js/iziToast.min.js')}}"></script>
	<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
	<script>
		var mobileNumberG = '0';
        var firebaseConfig = {
            apiKey: "AIzaSyCo8KaHu8XZ6jm3ewJXqs0Kma8ZfiSoby4",
			authDomain: "otplogin-5f6f9.firebaseapp.com",
			projectId: "otplogin-5f6f9",
			storageBucket: "otplogin-5f6f9.appspot.com",
			messagingSenderId: "493284471501",
			appId: "1:493284471501:web:55ca067ed947569b2eef84",
			measurementId: "G-0ZJLWFMJMH"
        };
        firebase.initializeApp(firebaseConfig);
    </script>
	 <script>
        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
            'size': 'invisible',
        });
    </script>
	<script>
		function startTimeInterval(){
            seconds = 60;
            var timeinter = setInterval(() => {
                document.getElementById('resend_txt').innerHTML = `Resend OTP in ${seconds} sec`;
                if(seconds < 1){
                    clearInterval(timeinter);
                    document.getElementById('resend_txt').innerHTML = `<a href="javascript:void(0)" onclick="sendOtpToMobile(mobileNumberG)" class="text-primary">Resend OTP</a>`;
                }
                seconds--;
            }, 1000);
        }

		async function postData(url = "", data = {}) {
			// Default options are marked with *
			const response = await fetch(url, {
				method: "POST", // *GET, POST, PUT, DELETE, etc.
				mode: "cors", // no-cors, *cors, same-origin
				cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
				credentials: "same-origin", // include, *same-origin, omit
				headers: {
					"Content-Type": "application/json",
					'X-CSRF-TOKEN': "{{csrf_token()}}"
				},
				redirect: "follow", // manual, *follow, error
				referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
				body: JSON.stringify(data), // body data type must match "Content-Type" header
			});
			return response.json(); // parses JSON response into native JavaScript objects
		}
	</script>

	<script>
		function sendOtpToMobile(number){
			$('#page_loader').css({'display':'flex'});
            document.getElementById('error_msg').innerHTML = "";
			firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
				window.confirmationResult = confirmationResult;
				coderesult = confirmationResult;
				$('#page_loader').hide();
				$(".otp_frm").show();
				$(".lg_frm").hide();
				document.getElementById('verify_btn').style.display = 'block';
				document.getElementById('login_btn').style.display = 'none';
				startTimeInterval();
			}).catch(function (error) {
				var err_msg = error.message;
				if(error.message=="TOO_SHORT"){
					err_msg = "OTP not sent..something went wrong";
				}
				document.getElementById('error_msg').innerHTML = err_msg;
				$('#page_loader').hide();
				$(".otp_frm").hide();
				$(".lg_frm").show();
				document.getElementById('verify_btn').style.display = 'none';
				document.getElementById('login_btn').style.display = 'block';
			});
		}
	</script>

	<script>
		document.getElementById('login_btn').addEventListener('click',function(event){
			var username = document.getElementById('username').value;
			var password = document.getElementById('password').value;
			var err = document.getElementById("error_msg");
			err.innerText = '';
			if(username=='' || password==''){
				err.innerText = 'Enter username and password to login';
			}else{
				event.target.setAttribute('disabled','disabled');
				event.target.innerHTML = 'Processing...';
				postData("{{url('get-stu-mobile')}}", { username: username,password:password }).then((data) => {
					if(data.s==1){
						sendOtpToMobile("+91"+data.mobile);
						mobileNumberG = "+91"+data.mobile;
						$('#numbersend').html("+91"+data.mobile);
					}else{
						err.innerText = 'Invalid username or password';
						event.target.removeAttribute('disabled');
						event.target.innerHTML = 'Login';
					}
				}).catch((error)=>{
					$('#page_loader').hide();
					console.log(error);
					err.innerText = 'Invalid username or password';
					event.target.removeAttribute('disabled');
					event.target.innerHTML = 'Login';
				});
			}
		});	
	</script>	

	<script>
		document.getElementById('verify_btn').addEventListener('click',function(event){
			event.target.setAttribute('disabled','disabled');
			event.target.innerHTML = 'Processing...';
			var code = document.getElementById('otp_txt').value;
			if(code!=""){
				coderesult.confirm(code).then(function (result) {
					var user = result.user;
					postData("{{url('set-user-mob-sess')}}", { mob_num: user.phoneNumber }).then((data) => {
						$("#login_frm")[0].submit();
					});
				}).catch(function (error) {
					console.log(error);
					document.getElementById('error_msg').innerHTML = "Invalid or expired OTP..please enter valid one time password sent to your mobile number";
					event.target.removeAttribute('disabled');
					event.target.innerHTML = 'Verify';
				});
			}
		});
	</script>


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