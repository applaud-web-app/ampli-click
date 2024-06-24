@extends('layouts.master')
@section('title','Create Sub-Category')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @include('message') 
        <!-- row -->
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12">
                <div class="card profile-card card-bx">
                    <div class="card-header">
                        <h6 class="card-title">Create Sub-Category</h6>
                    </div>
                    <form action="/subcategory" method="POST" class="profile-form">
                        @csrf
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-sm-5 mb-3">
                                    <label class="form-label">Select Category</label>
                                    <select class="form-control" name="category" required>
                                        <option selected disabled>Select a Category</option>
                                        @foreach ($categorys as $category)
                                            <option value="{{ $category->id }}">{{$category->title}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger"> @error('category')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span> 
                                </div>
                                <div class="col-sm-7 m-b30">
                                    <label class="form-label">Sub-Category Title<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="sub_category" placeholder="Category Title" value="{{old('sub_category')}}" required>
                                    <span class="text-danger"> @error('sub_category')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>                                 
                                </div>
                                <div class="col-sm-12 m-b30">
                                    <label class="form-label">Sub-Category Description<span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="sub_description" placeholder="Sub-Category Description" cols="30" rows="10" required>{{old('sub_description')}}</textarea>
                                    <span class="text-danger"> @error('sub_description')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>                                 
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary">Create</button>
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