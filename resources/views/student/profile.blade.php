@extends('layouts.studentmaster')
@section('title', auth('student')->user()->fname.' Profile')
@section('student', auth('student')->user()->fname)
@section('content')
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-lg-12 col-xl-12 col-xxl-12">
                <div class="profile card card-body px-3 pt-3 pb-0">
                    <div class="profile-head">
                        <div class="profile-info">
                            <div class="profile-photo">
                                <img width="100px" height="100px" src="upload/student/{{$studentData->image}}" class="rounded-circle img-thumbnail bg-white" alt="">
                            </div>
                            <div class="edit-profile ms-auto">
                                <a href="/" class="btn btn-xs btn-primary text-white">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="pt-3 pb-0 email-left-box" id="email-left">
                                <div class="mail-list pb-0 mb-0 rounded mt-0">
                                    <p class="text-danger mb-2">Personal Details</p>
                                    <a href="javascript:void(0);" class="list-group-item py-2"><i
                                            class="fa-regular fa-star align-middle"></i><b
                                            class="text-primary">Name:</b>
                                        {{$studentData->fname ." ".$studentData->lname}}</a>
                                    <a href="javascript:void(0);" class="list-group-item py-2"><i
                                            class="fa-regular fa-star align-middle"></i><b
                                            class="text-primary">Username:</b> {{$studentData->username}}</a>
                                    <a href="javascript:void(0);" class="list-group-item py-2"><i
                                            class="fa-regular fa-star align-middle"></i><b
                                            class="text-primary">Email:</b>
                                        {{$studentData->email}} </a>
                                    <a href="javascript:void(0);" class="list-group-item py-2"><i
                                            class="fa-regular fa-star align-middle"></i><b
                                            class="text-primary">Mobile:</b>
                                        {{$studentData->mobile}}</a>
                                    <a href="javascript:void(0);" class="list-group-item py-2"><i
                                            class="fa-regular fa-star align-middle"></i><b class="text-primary">DOB:</b>
                                        {{$studentData->dob}}</a>
                                    <a href="javascript:void(0);" class="list-group-item py-2"><i
                                            class="fa-regular fa-star align-middle"></i><b
                                            class="text-primary">Aadhar:</b>
                                        {{$studentData->aadhar}}</a>
                                    <a href="javascript:void(0);" class="list-group-item py-2"><i
                                            class="fa-regular fa-star align-middle"></i><b
                                            class="text-primary">Gender:</b>
                                        {{$studentData->gender == 1 ? "Male" : ($studentData->gender == 2 ? "Female" : ($studentData->gender == 3 ? "Other" : "")) }}</a>
                                    <a href="javascript:void(0);" class="list-group-item py-2"><i
                                            class="fa-regular fa-star align-middle"></i><b
                                            class="text-primary">State:</b>
                                        {{$studentData->state}}</a>
                                    <a href="javascript:void(0);" class="list-group-item py-2"><i
                                            class="fa-regular fa-star align-middle"></i><b
                                            class="text-primary">City:</b>
                                        {{$studentData->city}}</a>
                                    <a href="javascript:void(0);" class="list-group-item py-2"><i
                                            class="fa-regular fa-star align-middle"></i><b
                                            class="text-primary">Address:</b>
                                        {{$studentData->address}}</a>
                                </div>
                            </div>
                            <div class="mb-0 pt-2 email-left-box" id="email-left">
                                <div class="mail-list pt-0 rounded mt-0">
                                    <p class="text-danger mb-2">Parent Details</p>
                                    <a href="javascript:void(0);" class="list-group-item py-2"><i
                                            class="fa-regular fa-star align-middle"></i><b class="text-primary">Father
                                            Name:</b>
                                        {{$studentData->parent_first ." ".$studentData->parent_last}}</a>
                                    <a href="javascript:void(0);" class="list-group-item py-2"><i
                                            class="fa-regular fa-star align-middle"></i><b class="text-primary">Mobile
                                            Number:</b> {{$studentData->p_number}}</a>
                                    <a href="javascript:void(0);" class="list-group-item py-2"><i
                                            class="fa-regular fa-star align-middle"></i><b
                                            class="text-primary">Email:</b>
                                        {{$studentData->p_email}} </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 mb-3">
                            <p class="fw-bold">Personal Details</p>
                            {{-- <form action="/student-profile" method="POST" enctype="multipart/form-data"> --}}
                                {{-- @csrf --}}
                                <div class="row">
                                    <div class="row mb-3">
                                        <div class="col-lg-3 text-center">
                                            <label class="form-label">Profile Photo</label>
                                            <div class="avatar-upload">
                                               <div class="">
                                                   <img id="blah" class="rounded-circle" width="100px" height="100px" src="upload/student/{{$studentData->image}}"> 	
                                               </div>
                                               {{-- <div class="change-btn mt-2 mb-lg-0 mb-3">
                                                   <input type='file' class="form-control d-none" name="image"  id="imgInp" accept=".png, .jpg, .jpeg">
                                                   <label for="imgInp" class="dlab-upload mb-0 btn btn-primary btn-sm">Choose File</label>
                                               </div> --}}
                                           </div>	
                                        </div>
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">First Name<span class="text-danger">*</span></label>
                                                    <input type="text" name="fname" class="form-control " placeholder="Enter First Name" value="{{$studentData->fname}}" readonly disabled>
                                                    {{-- <input type="hidden" name="sid" value="{{$studentData->id}}"> --}}
                                                    @error('fname') <span class="text-danger">{{$message}}</span>  @enderror
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Last Name</label>
                                                    <input type="text" name="lname" class="form-control " placeholder="Enter Last Name" value="{{$studentData->lname}}" readonly disabled>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Username<span class="text-danger">*</span></label>
                                                    <input type="text" name="username" class="form-control " placeholder="Enter Username" value="{{$studentData->username}}" readonly disabled>
                                                      @error('username') <span class="text-danger">{{$message}}</span>  @enderror
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Email Address</label>
                                                    <input type="email" name="email" class="form-control " placeholder="Enter Email" value="{{$studentData->email}}" readonly disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Mobile No.<span class="text-danger">*</span></label>
                                        <input type="number" name="mobile" class="form-control " placeholder="Enter Mobile No." value="{{$studentData->mobile}}" readonly disabled>
                                          @error('mobile') <span class="text-danger">{{$message}}</span>  @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Aadhar No.<span class="text-danger">*</span></label>
                                        <input type="number" name="aadhar" class="form-control " placeholder="Enter Aadhar No." value="{{$studentData->aadhar}}" readonly disabled>
                                          @error('aadhar') <span class="text-danger">{{$message}}</span>  @enderror
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label class="form-label">Date Of Birth</label>
                                        <input type="date" name="dob" class="form-control " value="{{$studentData->dob}}" readonly disabled>
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label class="form-label">Gender<span class="text-danger">*</span></label>
                                        <select name="gender" id="" class="form-control " readonly disabled>
                                            <option value="1" value="{{$studentData->gender == 1 ? "selected" : ""}}">Male</option>
                                            <option value="2" value="{{$studentData->gender == 2 ? "selected" : ""}}">Female</option>
                                            <option value="3" value="{{$studentData->gender == 3 ? "selected" : ""}}">Other</option>
                                        </select>
                                          @error('gender') <span class="text-danger">{{$message}}</span>  @enderror
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label class="form-label">State</label>
                                        <select name="state" id="" class="form-control " readonly disabled>
                                            <option value="1">Uttrakhand</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label class="form-label">City</label>
                                        <select name="city" id="" class="form-control " readonly disabled>
                                            <option value="1">Dehradun</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Address<span class="text-danger">*</span></label>
                                        <textarea name="address" class="form-control "id="" cols="30" rows="4" placeholder="Enter Address" readonly disabled>{{$studentData->address}}</textarea>
                                    </div>
                                      @error('address') <span class="text-danger">{{$message}}</span>  @enderror
                                </div>
                                <div class="row mt-3">
                                    <p class="fw-bold">Parent Details</p>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">First Name<span class="text-danger">*</span></label>
                                        <input type="text" name="pname" value="{{$studentData->parent_first}}" class="form-control " placeholder="Enter First Name" readonly disabled>
                                          @error('pname') <span class="text-danger">{{$message}}</span>  @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" name="plname" value="{{$studentData->parent_last}}" class="form-control " placeholder="Enter Last Name" readonly disabled>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Email Address<span class="text-danger">*</span></label>
                                        <input type="email" name="pemail" value="{{$studentData->p_email}}" class="form-control " placeholder="Enter Email" readonly disabled>
                                          @error('pemail') <span class="text-danger">{{$message}}</span>  @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Mobile No.<span class="text-danger">*</span></label>
                                        <input type="number" name="pmobile" value="{{$studentData->p_number}}" class="form-control " placeholder="Enter Mobile No." readonly disabled>
                                          @error('pmobile') <span class="text-danger">{{$message}}</span>  @enderror
                                    </div>
                                </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
    }
  </script>
@endsection
