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
	<title>Verify Mobile Number : Ampliclicks Academy</title>

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
				<h3 class="mb-0 text-white">Verify Mobile Number!</h3>
				<p class="text-white mb-0">Please verify your mobile number to register.</p>
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
					<div class="row no-gutters position-relative">
						<div class="col-xl-12 tab-content">
                            <div id="page_loader">
                                <div class="lds-dual-ring"></div>
                            </div>
                            
							<div id="sign-up" class="auth-form tab-pane fade show active  form-validation">
								<form action="{{url('register-process')}}" method="POST" id="login_frm" name="login_frm">
									@csrf
									<h1 class="d-flex align-items-center mb-0">Mobile Verification</h1>
									<div class="mb-3">
										<label for="exampleFormControlInput1"
											class="form-label mb-2 fs-13 label-color font-w500">Enter OTP Send To - {{$phoneNumber}} <a href="{{url('register')}}" class="text-primary"> (change mobile number)</a></label>
										<input type="text" class="form-control" name="otp_txt" id="otp_txt"
											placeholder="Enter One Time Password" value=""
											required>
										@error('username') <span class="text-danger">{{$message}}</span> @enderror
									</div>
                                    <div>
                                        <p class="text-danger" id="error_txt"></p>
                                    </div>
                                    <div id="resend_block">
                                        <p id="resend_txt"></p>
                                    </div>
									<button type="button" id="verify_btn" class="btn btn-block btn-primary">Verify</button>
                                </form>
                                    <div id="recaptcha-container" class="mb-3"></div>
								{{-- <div class="new-account mt-3 text-center">
									<p class="font-w500">Don't have any account? <a class="text-primary"
											href="/register" data-toggle="tab">Register</a></p>
								</div> --}}
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
    <script src="{{asset('vendor/global/global.min.js')}}"></script>
	<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
	<script>
      var firebaseConfig = {
    apiKey: "AIzaSyAFEcGmT1yGTsz53SDQMCm47YyzKhOAbcM",
    authDomain: "ampliclicks-otp.firebaseapp.com",
    projectId: "ampliclicks-otp",
    storageBucket: "ampliclicks-otp.appspot.com",
    messagingSenderId: "635387170141",
    appId: "1:635387170141:web:2c334b5662b4ef68beacb4"
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
                    document.getElementById('resend_txt').innerHTML = `<a href="javascript:void(0)" onclick="sendOtpToMobile()" class="text-primary">Resend OTP</a>`;
                }
                seconds--;
            }, 1000);
        }
        function sendOtpToMobile(){
            $('#page_loader').show();
            document.getElementById('error_txt').innerHTML = "";
            var number = "+91{{substr($phoneNumber,-10)}}";
            firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
                window.confirmationResult = confirmationResult;
                coderesult = confirmationResult;
                $('#page_loader').hide();
                startTimeInterval();
            }).catch(function (error) {
                var err_msg = error.message;
                if(error.message=="TOO_SHORT"){
                    err_msg = "OTP not sent..something went wrong. please check your mobile number or contact administrator";
                }
                document.getElementById('error_txt').innerHTML = err_msg;
                $('#page_loader').hide();
                document.getElementById('verify_btn').style.display = 'none';
            });
        }
    </script>
    <script>
        window.onload = function(e){ 
            sendOtpToMobile();
        }
    </script>

    <script>
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
        document.getElementById('verify_btn').addEventListener('click',function(event){
            event.target.setAttribute('disabled','disabled');
            event.target.innerHTML = 'Processing...';
            var code = document.getElementById('otp_txt').value;
            if(code!=""){
                coderesult.confirm(code).then(function (result) {
                    var user = result.user;
                    postData("{{url('set-user-mob')}}", { mob_num: '{{$phoneNumber}}' }).then((data) => {
                        $("#login_frm")[0].submit();
                    });
                }).catch(function (error) {
                    console.log(error);
                    document.getElementById('error_txt').innerHTML = "Invalid or expired OTP..please enter valid one time password sent to your mobile number";
                    event.target.removeAttribute('disabled');
                    event.target.innerHTML = 'Verify';
                });
            }
        });
    </script>
    

</body>
</html>