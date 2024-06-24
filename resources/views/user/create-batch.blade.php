@extends('layouts.master')
@section('title','Create Batch')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @include('message')
        <!-- row -->
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-10">
                <div class="card profile-card card-bx">
                    <div class="card-header">
                        <h6 class="card-title">Create Batch</h6>
                    </div>
                    <form action="create-batch" method="POST" class="profile-form">
                        @csrf
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-sm-6 m-b30">
                                    <label class="form-label">Batch Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" placeholder="Batch Name" value="{{old('name')}}" required>
                                    <span class="text-danger"> @error('name')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>                                 
                                </div>
                                <div class="col-sm-3 m-b30">
                                    <label class="form-label">Staring Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id ="startTime" name="start_date" value="{{old('start_date')}}" required>
                                    <span class="text-danger"> @error('start_date')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>                                 
                                </div>
                                <div class="col-sm-3 m-b30">
                                    <label class="form-label">Ending Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id ="endTime" name="end_date" value="{{old('end_date')}}" required>
                                    <span class="text-danger"> @error('end_date')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>                                 
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button class="btn btn-primary">Add</button>
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