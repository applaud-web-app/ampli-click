@extends('layouts.master')
@section('title','Update Sub-Category')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @if($message = Session::get('success'))
        <div class="my-3 container">
          <div class="row justify-content-end">
              <div class="col-lg-4">
                <div class="alert alert-info alert-dismissible fade show">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>	
                    <strong>Successfully!!</strong> {{$message}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="fa-solid fa-xmark"></i></span>                    
                    </button>
                </div>
              </div>
          </div>
        </div>
        @endif   
        <!-- row -->
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12">
                <div class="card profile-card card-bx">
                    <div class="card-header">
                        <h6 class="card-title">Update Sub-Category</h6>
                    </div>
                    <form action="/update-category" method="POST" class="profile-form">
                        @csrf
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-sm-4 mb-3">
                                    <label class="form-label">Select Category</label>
                                    <select class="form-control" name="category" required>
                                        <option selected disabled>Select a Category</option>
                                        @foreach ($categorys as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $SubCategorys->categories_id  ? "selected" : "" }}>{{$category->title}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger"> @error('category')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span> 
                                </div>
                                <div class="col-sm-5 m-b30">
                                    <label class="form-label">Sub-Category Title<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="sub_category" placeholder="Category Title" value="{{ $SubCategorys->title }}" required>
                                    <input type="hidden" name="cid"  value="{{ $SubCategorys->id }}" >
                                    <span class="text-danger"> @error('sub_category')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>                                 
                                </div>
                                <div class="col-lg-3">
                                    <div class="align-items-center d-flex">
                                        <div class="input-group">
											<button class="btn btn-primary" type="button">Status</button>
                                            <select class="form-control" name="status">
                                                <option value="1" {{$SubCategorys->status == 1 ? "selected" : ""}}>Active</option>
                                                <option value="0" {{$SubCategorys->status == 0 ? "selected" : ""}}>Pending</option>
                                            </select>
                                            @error('status')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span> 
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-sm-12 m-b30">
                                    <label class="form-label">Sub-Category Description<span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="sub_description" placeholder="Sub-Category Description" cols="30" rows="10" required>{{ $SubCategorys->description }}</textarea>
                                    <span class="text-danger"> @error('sub_description')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>                                 
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary">Update</button>
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
@endsection