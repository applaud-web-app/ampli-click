@extends('layouts.master')
@section('title','Update Batch')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @include('message')
        <!-- row -->
        <div class="row justify-content-center">
            <div class="col-xl-11 col-lg-10">
                <div class="card profile-card card-bx">
                    <div class="card-header">
                        <h6 class="card-title">Update Batch</h6>
                    </div>
                    <form action="/update-batch" method="POST" class="profile-form">
                        @csrf
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-sm-5 m-b30">
                                    <label class="form-label">Batch Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" placeholder="Batch Name" value="{{$batch->name}}" required>
                                    <input type="hidden" name="id" value="{{$batch->id}}" required>
                                    <span class="text-danger"> @error('name')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>                                 
                                </div>
                                <div class="col-sm-2 m-b30">
                                    <label class="form-label">Staring Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="start_date" value="{{$batch->start_date}}" required>
                                    <span class="text-danger"> @error('start_date')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>                                 
                                </div>
                                <div class="col-sm-2 m-b30">
                                    <label class="form-label">Ending Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="end_date" value="{{$batch->end_date}}" required>
                                    <span class="text-danger"> @error('end_date')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>                                 
                                </div>
                                <div class="col-sm-3 m-0">
                                    <div class="align-items-center d-flex">
                                        <div class="input-group">
											<button class="btn btn-primary" type="button">Status</button>
                                            <select class="form-control" name="status">
                                                <option value="1" {{$batch->status == 1 ? "selected" : ""}}>Active</option>
                                                <option value="0" {{$batch->status == 0 ? "selected" : ""}}>Deactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
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