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
	<title>Learner Register : Ampliclicks Academy</title>

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
				
				<h3 class="mb-0 text-white">Join us today!</h3>
				<p class="text-white mb-0">Create your account to unlock exclusive features and enjoy a personalized experience. Fill in the required fields below to get started.</p>
			</div>
			<div class="aside-image position-relative" style="background-image:url(images/login1.png);">
				{{-- <img class="img1 move-1" src="{{asset('images/background/pic3.png')}}" alt="">
				<img class="img2 move-2" src="{{asset('images/background/pic4.png')}}" alt="">
				<img class="img3 move-3" src="{{asset('images/background/pic5.png')}}" alt=""> --}}
			</div>
		</div>
		<div
			class="container flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
			@include('message')
			<div class="d-flex justify-content-center h-100 align-items-center">
				<div class="authincation-content style-2">
					<div class="row no-gutters">
						<div class="col-xl-12 tab-content">
							<div id="sign-up" class="auth-form tab-pane fade show active  form-validation">
								<form action="{{route('register')}}" method="POST" name="register_frm" id="register_frm">
									@csrf
									<div class="text-center mb-4">
										<h3 class="text-center mb-2 text-black">Learner Registration</h3>
									</div>
									<div class="row">
										<div class="mb-3 col-6">
											<label for="exampleFormControlInput2"
												class="form-label mb-2 fs-13 label-color font-w500">First Name<span class="text-danger">*</span></label>
											<input type="text" class="form-control" name="fname" id="exampleFormControlInput2"
												placeholder="Enter First Name" value="{{$regData->fname}}" required>
											@error('fname') <span class="text-danger">{{$message}}</span> @enderror
										</div>
										<div class="mb-3 col-6">
											<label for="exampleFormControlInput2"
												class="form-label mb-2 fs-13 label-color font-w500">Last Name</label>
											<input type="text" class="form-control" name="lname" id="exampleFormControlInput2"
												placeholder="Enter Last Name" value="{{$regData->lname}}">
										</div>
										<div class="mb-3">
											<label for="exampleFormControlInput1"
												class="form-label mb-2 fs-13 label-color font-w500">Username<span class="text-danger">*</span></label>
											<input type="text" class="form-control" name="username" id="exampleFormControlInput1"
												placeholder="Enter Username" value="{{$regData->username}}" required>
											@error('username') <span class="text-danger">{{$message}}</span> @enderror
										</div>
										<div class="mb-3">
											<label for="exampleFormControlInput1"
												class="form-label mb-2 fs-13 label-color font-w500">Email<span class="text-danger">*</span></label>
											<input type="text" class="form-control" name="email" id="email"
												placeholder="Enter Username" value="{{$regData->email}}">
											@error('email') <span class="text-danger">{{$message}}</span> @enderror
										</div>
										<div class="mb-3">
											<label for="exampleFormControlInput3"
												class="form-label mb-2 fs-13 label-color font-w500">Password<span class="text-danger">*</span></label>
											<input type="password" class="form-control" name="password" id="exampleFormControlInput3"
												placeholder="Password" value="{{$regData->password}}" required>
											@error('password') <span class="text-danger">{{$message}}</span> @enderror
										</div>
										<div class="mb-3">
											<label for="exampleFormControlInput1"
												class="form-label mb-2 fs-13 label-color font-w500">Phone Number (OTP will be send to this number)<span class="text-danger">*</span></label>
											<input type="number" name="mobile" class="form-control" id="exampleFormControlInput1"
												placeholder="Enter Phone Number" value="{{$regData->mobile}}" required>
											@error('mobile') <span class="text-danger">{{$message}}</span> @enderror
										</div>
										{{-- <div class="mb-3">
											<label for="exampleFormControlInput1"
												class="form-label mb-2 fs-13 label-color font-w500">Aadhar Number<span class="text-danger">*</span></label>
											<input type="number" name="aadhar" class="form-control" id="exampleFormControlInput1"
												placeholder="Enter Aadher Number">
										</div> --}}
										<div class="mb-3 d-flex">
											<input type="checkbox" required>
											<label  class="form-label fs-13 label-color font-w500 ms-1 mb-0"> By continuing, you agree to our <a href="{{route('termAndcondition')}}">terms and conditions.</a> </label>
										</div>
									</div>
									<button type="submit" class="btn btn-block btn-primary">Register Now</button>
								</form>
								<div class="new-account mt-3 text-center">
									<p class="font-w500">Already have an account? <a class="text-primary" href="{{route('login')}}">Login</a></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Terms</h5>
				
			</div>
			<div class="modal-body">
			<p>
				Ampliclicks Academy would like to congratulate you for taking the first step towards the amazing world of Data Science and Analytics. On behalf of the entire faculty and staff, it is my pleasure to welcome you to the Data Analytics Master Program at Ampliclicks Academy. We are thrilled to have you as a vibrant part of the Data Scientists community.</p>
				
			<p>The Data Analytics Master Program (which includes online/offline training and mentorship) is designed to equip you with the necessary skills, required knowledge, and hands-on practical experience to thrive in the rapidly evolving field of data science. Throughout your journey at Ampliclicks Academy, you will be challenged to think critically and innovate to explore the frontiers of Data Science.</p>

 

		<p>As a Data Science professional, you will play a vital role in shaping the future of modern businesses and society at large. You will find yourself at the forefront of discovering new insights, creating models, and developing solutions to a complex and pressing set of problems of our time. We are confident that the knowledge and skills you acquire in this program will enable you to make a significant impact in the business world.</p>

 

	<p>Our faculty members and mentors are experts in their fields and are committed to providing a world-class training experience. They will challenge you, inspire you, and provide guidance throughout your journey at Ampliclicks Academy. Our extended staff members are here to support you on every step of the journey, from navigating administrative processes, to providing career advice, desired counseling services, and finally walk you through all the baby steps required to get placed.</p>

 

<p>As a student in the Data Analytics Master Program, you will have access to state-of-the-art facilities, cutting-edge technologies, rich array of resources that includes library facilities to study and practice between 09:30 am to 08:00 pm. You will also collaborate with other students, faculty members, mentors, and industry leaders through various extracurricular activities, such as hackathons, project workshops, seminars, personality development classes, and mock interviews.</p>

 

<p>We encourage you to take advantage of all the opportunities available here and make the most use of your time at Ampliclicks Academy. We are confident that you will find the journey both challenging and rewarding. We intend to support you in every way that fulfills the academic and professional pursuits of your dreams.</p>

 

<p>Soon after the enrollment process, you will have to follow the below-desired steps:</p>

 

<p>i)Join the WhatsApp group of the batch</p>

<p>ii)Fill the google sheet with KYC documents to create your profile,</p>

<p>iii)For classes, you will be sent the zoom link in the batch group in advance,</p>

<p>iv)For accessing the recordings of the classes and assignments you need to login to our LMS platform, https://app.ampliclicksacademy.in/register . Upon joining our course and registration on our LMS portal to access class materials, you therby accept and agree to be abide by the terms and conditions mentioned in our website www.ampliclicksacademy.in.</p>

 

<p>v)Apart from classroom/live training on technical skills, we have the best in industry mentorship program. Our team of experienced mentors is dedicated to helping you uncover the data scientist within you and discover your true potential. We believe that with the right guidance, introspection, and resourceful practice, you can achieve great success in the world of data science.</p>

 

<p>vi)You need to have a laptop or desktop with widows 10 or above OS, Intel i5 or above processor, 8 GB RAM and 512 GB SSD/HDD.</p>

  

<p>We would like to inform you that you have chosen the Data Analytics Master Program for 6 Months and the course fees is Rs. 1,80,000/-. You will get a separate email confirming your payment structure within a week.</p>

 

<p>The terms and conditions of your payment and services are as follows.</p>

 

<p>Acceptance of Refund Policy, Terms, and Conditions:</p>

 

<p>By enrolling for any single or combination of Ampliclicks Academy’ courses, whether purchased by you or a third party on your behalf, at full price or on a special offer, you agree that.</p>

 

<p>In case Ampliclicks Academy cancels the whole program (rescheduling of certain classes does not tantamount to cancellation of the program), 100% refund will be paid to you within 30 days of such cancellation.</p>

 

<p>If the student wishes to discontinue the course, he/she must intimate in writing to info@ampliclicksacademy.inwithin 15 days of course start date or attend 4 classes, whichever is earlier. In such case 100% of total paid amount will be refunded except registration charges of Rs. 2,500/-</p>

 

<p>Once the student continues to attend 5thclass, its considered that, he is continuing with the class and cannot discontinue or no refund will be made.</p>

 

<p>After which, Ampliclicks Academy is not obliged or bound legally to refund any portion of the course fees. Exclusions apply, see below.</p>

 

<p>A student is considered enrolled when they have received a payment confirmation email from Ampliclicks Academy. A request for refund will only be considered valid if emailed to us at info@ampliclicksacademy.in. Any request sent after the expiration of the refund period will not be considered.</p>

 

<p>It is the student’s responsibility to evaluate the courses they have purchased and seek a refund if they so decide before the expiration of the 7th day or 4th class, no questions will be asked during refund period as per refund policy.</p>

 

<p>If the payment is not made as per the agreed timeline mentioned in the payment structure Email, then your LMS access may be revoked.</p>

 

 <p>Please note: By joining our course, you agree that you will use the class materials for your learning purpose and will not share our materials or videos with anyone else for any personal gains or commercial purpose.</p>

 

<p>The class schedule will be announced every week in advance. However, the same may undergo changes depending on the availability of the faculties or any other reason beyond the control of the Institute.</p>

 

<p>Your Student Mentorship program and mentor details will be shared separately through email.</p>

 

<p>For any issues, please reach out to</p>

 

<p>Level I: Mrs. Pratibha Singh on 90089-55077</p>

<p>Level II: Mr. Dhirendra Dhal on 99643-55777</p>

 

<p>We thank you for believing in team Ampliclicks Academy and once again, welcome to Ampliclicks Academy’ Data Science Master Program! We are thrilled to have you as a part of our community, and we wish you all the best for a stupendous career in the field of Data Science.</p>


			</div>
			<div class="modal-footer">
				<button type="button" id="submit_register" class="btn btn-primary">Accept & Register</button>
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
	<script>
		$("#register_frm").on('submit',function(e){
			e.preventDefault();
			$("#exampleModal").modal('show');
		});
	</script>
	<script>
		$("#submit_register").on('click',function(){
			$("#register_frm")[0].submit();
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