@extends('layouts.master')
@if (Auth::user()->u_role == 1)
    @section('title', auth::user()->name.' Profile')
    @section('student', auth::user()->name)
@else 
    @section('title', auth('teacher')->user()->teacher_name.' Profile')
    @section('student', auth('teacher')->user()->teacher_name)
@endif
@section('content')
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('message')
        <div class="row mt-4">
            <div class="col-lg-12 col-xl-12 col-xxl-12">
                <div class="profile card card-body px-3 pt-3 pb-0">
                    <div class="profile-head">
                        <div class="profile-info">
                            <div class="profile-photo">
                                <img width="100px" height="100px" src="/upload/teachers/{{$teacher->image}}" class="rounded-circle" alt="">
                            </div>
                            <div class="edit-profile ms-auto">
                                <a href="/dashboard" class="btn btn-xs btn-primary text-white">Back</a>
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
                                        {{$teacher->teacher_name}}</a>
                                    <a href="javascript:void(0);" class="list-group-item py-2"><i
                                            class="fa-regular fa-star align-middle"></i><b
                                            class="text-primary">Designation:</b> {{$teacher->designation}}</a>
                                    <a href="javascript:void(0);" class="list-group-item py-2"><i
                                            class="fa-regular fa-star align-middle"></i><b
                                            class="text-primary">Email:</b>
                                        {{$teacher->email}} </a>
                                    <a href="javascript:void(0);" class="list-group-item py-2"><i
                                        class="fa-regular fa-star align-middle"></i><b
                                        class="text-primary">Number:</b>
                                    {{$teacher->number}} </a>
                                    <a href="javascript:void(0);" class="list-group-item py-2"><i
                                        class="fa-regular fa-star align-middle"></i><b
                                        class="text-primary">Gender:</b>
                                    {{($teacher->gender == 1 ? "Male" : ($teacher->gender == 2 ? "Female" : "Other"))}} </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 mb-3">
                            <p class="fw-bold">Personal Details</p>
                            <form action="/update-teacher-profile" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="row mb-3">
                                        <div class="col-lg-3 text-center">
                                            <label class="form-label">Photo</label>
                                            <div class="avatar-upload">
                                               <div class="avatar-preview">
                                                   <img id="blah" width="100px" height="100px" src="/upload/teachers/{{$teacher->image}}"> 	
                                               </div>
                                               <div class="change-btn mt-2 mb-lg-0 mb-3">
                                                   <input type='file' class="form-control d-none" name="image"  id="imgInp" accept=".png, .jpg, .jpeg">
                                                   <label for="imgInp" class="dlab-upload mb-0 btn btn-primary btn-sm">Choose File</label>
                                                   <input type="hidden" name="id" value="{{$teacher->id}}">
                                               </div>
                                           </div>	
                                           @error('image') <span class="text-danger">{{$message}}</span>  @enderror
                                        </div>
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Name<span class="text-danger">*</span></label>
                                                    <input type="text" name="name" class="form-control " placeholder="Enter Name" value="{{$teacher->teacher_name}}">
                                                    <input type="hidden" name="uid" value="{{$teacher->id}}">
                                                    @error('name') <span class="text-danger">{{$message}}</span>  @enderror
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Designation<span class="text-danger">*</span></label>
                                                    <input type="text" name="designation" class="form-control " placeholder="Enter Designation" value="{{$teacher->designation}}">
                                                    @error('designation') <span class="text-danger">{{$message}}</span>  @enderror
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Email Address<span class="text-danger">*</span></label>
                                                    <input type="email" name="email" class="form-control " placeholder="Enter Email" value="{{$teacher->email}}">
                                                    @error('email') <span class="text-danger">{{$message}}</span>  @enderror
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Number<span class="text-danger">*</span></label>
                                                    <input type="number" name="number" class="form-control " placeholder="Enter Number" value="{{$teacher->number}}">
                                                    @error('number') <span class="text-danger">{{$message}}</span>  @enderror
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Gender<span class="text-danger">*</span></label>
                                                    <select name="gender" id="" class="form-control">
                                                        <option value="">Select Gender</option>
                                                        <option value="1" {{$teacher->gender == 1 ? "selected":""}}>Male</option>
                                                        <option value="2" {{$teacher->gender == 2 ? "selected":""}}>Female</option>
                                                        <option value="3" {{$teacher->gender == 3 ? "selected":""}}>Others</option>
                                                    </select>
                                                    @error('gender') <span class="text-danger">{{$message}}</span>  @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary btn-xs">Save Changes</button>
                                </div>
                            </form>
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