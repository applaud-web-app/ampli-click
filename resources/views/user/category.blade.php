@extends('layouts.master')
@section('title','Create Course')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @include('message')
        <!-- row -->
        <div class="d-flex justify-content-between align-items-center mb-1">
            <a href="{{url()->previous()}}" onclick="window.history.go(-1); return false;" class="btn btn-danger btn-xs"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
            <a href="/view-category" class="btn btn-primary btn-xs">View Courses <i class="fa-solid fa-arrow-right-long"></i></a>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card profile-card card-bx">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">Create Course</h6>
                    </div>
                    <form action="/category" method="POST" enctype="multipart/form-data" class="profile-form">
                        @csrf
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">Course Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="cat_name" placeholder="Course Title" value="{{old('cat_name')}}" required>
                                    <span class="text-danger"> @error('cat_name')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span> 
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Course Image <span class="text-danger">( File Type Must Be: Png, Jpg, Jpeg, Gif)</span></label><br>
                                    <img src="/images/upload-default2.png" id="uploadImage" class="img-fluid img-thumbnail" alt="">
                                    <input type="file" class="d-none form-control" name="cat_image" id="fileInput" placeholder="Course Title">
                                    <span class="text-danger"> @error('cat_image')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>     
                                </div>

                               
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">Course Description<span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="cat_description" placeholder="Course Description"  rows="5" required>{{old('cat_description')}}</textarea>
                                    <span class="text-danger"> @error('cat_description')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>                             
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button class="btn btn-primary btn-sm">Create Course</button>
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
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
    $('#uploadImage').click(function(){
        $('#fileInput').click();
    });
</script>
<script>
    fileInput.onchange = evt => {
      const [file] = fileInput.files
      if (file) {
        uploadImage.src = URL.createObjectURL(file)
      }
    }
</script>
@endsection