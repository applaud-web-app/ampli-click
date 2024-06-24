@extends('layouts.master')
@section('title','Update Trainer')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @include('message')
        <!-- row -->
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-10">
                <div class="card profile-card card-bx">
                    <div class="card-header">
                        <h6 class="card-title">Update Trainer</h6>
                    </div>
                    <form action="/update-teacher" method="POST" class="profile-form" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-xl-2 col-lg-4 text-center">
                                    <label class="form-label">Profile Image</label>
                                     <div class="avatar-upload">
                                        <div class="avatar-preview">
                                            <img id="blah"  class="img-fluid img-thumbnail" src="/upload/teachers/{{$teachers->image}}"> 			
                                        </div>
                                        <div class="change-btn mt-2">
                                            <input type='file' class="form-control d-none" id="imgInp" name="image" accept=".png, .jpg, .jpeg">
                                            <label for="imgInp" class="dlab-upload mb-0 btn btn-primary btn-sm">Choose File</label>
                                        </div>
                                    </div>	
                                </div>
                                <div class="col-xl-10 col-lg-8">
                                    <div class="row align-items-center">
                                    <div class="col-lg-6 col-md-6 col-12 mb-3">
                                        <label class="form-label">Trainer Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" placeholder="Trainer Name" value="{{$teachers->teacher_name}}" required>
                                        <input type="hidden" name="tid" value="{{$teachers->id}}">
                                        <span class="text-danger"> @error('name')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>                                 
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12 mb-3">
                                        <label class="form-label">Trainer Designation<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="designation" placeholder="Trainer Designation" value="{{$teachers->designation}}" required>
                                        <span class="text-danger"> @error('designation')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>                                 
                                    </div>
                                   
                                    <div class="col-sm-6 m-b30">
                                        <label class="form-label">Email ID<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" placeholder="Email ID" value="{{$teachers->email}}" required>
                                        <span class="text-danger"> @error('email')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>                                 
                                    </div>
                                    <div class="col-sm-6 m-b30">
                                        <label class="form-label">Mobile Number</label>
                                        <input type="number" value="{{$teachers->number}}" class="form-control" name="mobile" placeholder="Mobile Number">
                                        <span class="text-danger"> @error('mobile')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>                                 
                                    </div>
                                   
                                    <div class="col-sm-6 m-b30">
                                        <label class="form-label">Gender</label>
                                        <div class="mb-3 mb-0">
                                            <div class="form-check custom-checkbox d-inline-block mb-2 checkbox-primary">
                                                <input type="radio" class="form-check-input" id="customRadioBox7" value="1" name="gender" {{$teachers->gender == 1 ? "checked":""}}>
                                                <label class="form-check-label" for="customRadioBox7">Male</label>
                                            </div>
                                            <div class="form-check custom-checkbox d-inline-block mb-2 mx-2 checkbox-primary">
                                                <input type="radio" class="form-check-input" id="customRadioBox8" value="2" name="gender" {{$teachers->gender == 2 ? "checked":""}}>
                                                <label class="form-check-label" for="customRadioBox8">Female</label>
                                            </div>
                                            <div class="form-check custom-checkbox d-inline-block mb-2 checkbox-primary">
                                                <input type="radio" class="form-check-input" id="customRadioBox9" value="3" name="gender" {{$teachers->gender == 3 ? "checked":""}}>
                                                <label class="form-check-label" for="customRadioBox9">other</label>
                                            </div>
                                        </div>
                                        <span class="text-danger"> @error('gender')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12 mb-3">
                                      
                                        <div class="input-group">
                                            <button class="btn btn-primary" type="button">Status</button>
                                            <select class="form-control wide" name="status" tabindex="null">
                                                <option value="1" {{$teachers->status == 1 ? "selected" : ""}}>Active</option>
                                                <option value="0" {{$teachers->status == 0 ? "selected" : ""}}>Disabled</option>
                                            </select>
                                        </div>
                                    </div>                             
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end"><button type="submit" class="btn btn-primary">Update Profile</button></div>                            
                        </div>
                    </form>
                </div>
            </div>
        </div>	
        
        <!--**********************************
            Footer start
        ***********************************-->
        
        <!--**********************************
            Footer end
        ***********************************-->
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