@extends('layouts.master')
@section('title','Update Course')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @include('message') 
        <!-- row -->
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12">
                <div class="card profile-card card-bx">
                    <div class="card-header">
                        <h6 class="card-title">Update Course</h6>
                    </div>
                    <form action="/update-Category" enctype="multipart/form-data" method="POST" class="profile-form">
                        @csrf
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">Course Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="cat_name" placeholder="Course Title" value="{{$Categorys->title}}" required>
                                    <input type="hidden" name="cat_id" value="{{$Categorys->id}}">
                                    <span class="text-danger"> @error('cat_name')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span> 
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Course Image <span class="text-danger">( File Type Must Be: Png, Jpg, Jpeg, Gif)</span></label><br>
                                    <img src="/upload/course/{{$Categorys->course_img == "" ? "default-banner.png" : $Categorys->course_img}}" id="uploadImage" class="w-100 img-fluid img-thumbnail" alt="">
                                    <input type="file" class="d-none form-control" name="cat_image" id="fileInput" placeholder="Course Title">
                                    <span class="text-danger"> @error('cat_image')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>                                 
                                </div>


                              
                                <div class="col-lg-12 mb-3">  
                                    <label class="form-label">Course Description<span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="cat_description" placeholder="Course Description" cols="30" rows="5" required>{{$Categorys->description}}</textarea>
                                    <span class="text-danger"> @error('cat_description')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>                             
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-end">
                            <button class="btn btn-primary btn-sm">Update Course</button>
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