@extends('layouts.master')
@section('title','Batches')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @include('message')
        <div class="row justify-content-center">
            <div class="col-xl-12 mt-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="btn-group">
                    @if (Auth::user()->u_role == 1)
                    <button type="button" id="activeRecord"
                        class="border-0 rounded-top btn shadow-none btn-outline-primary btn-primary btn-sm rounded-0">Active
                        Batches</button>
                    <button type="button" id="deactiveRecord"
                        class="border-0 rounded-top btn shadow-none btn-outline-primary btn-sm rounded-0">Deactive
                        Batches</button>
                    <button type="button" id="endedRecord"
                        class="border-0 rounded-top btn shadow-none btn-outline-primary btn-sm rounded-0">Ended
                        Batches</button>
                        @endif
                    </div>
                    <div class="button-group">
                        <a href="{{url()->previous()}}" onclick="window.history.go(-1); return false;" class="ms-2 btn btn-danger btn-xs"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
                        <a href="/view-category" class="btn btn-dark btn-xs">View Course</a>
                        <a href="/course-subject/{{$courseName->id}}" class="btn btn-info btn-xs">View Course Subject</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="card border-0" id="bootstrap-table2">
                        <div class="card-header flex-wrap d-flex justify-content-between  border-0 ">
                            <div>
                                <h4 class=" mb-0 card-title d-flex align-items-center">{{$courseName->title}}<i
                                        class="mx-2 fs-4 fa-solid fa-arrow-right-long"></i> Batches</h4>
                            </div>
                            <div class="ms-auto d-flex align-items-center">
                                <input type="hidden" name="status" id="search_status" value="1">
                                <label class="d-flex align-items-center mb-0"><input type="search"
                                        class="ms-2 form-control " placeholder="Search Active Batch"
                                        id="searchBatch" name="searchBatch" aria-controls="example"></label>
                                @if (Auth::user()->u_role == 1)
                                <button class="shadow-none btn btn-primary btn-sm ms-2" type="button" data-id="{{$courseName->id}}" class="delete_btn mb-2" data-bs-toggle="modal" data-bs-target="#createBatch"  data-bs-toggle="tooltip" data-placement="top" title="Create Batch">Create Batch</button>
                                @endif
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table display dataTablesCard dataTable">
                                    <thead>
                                        <tr>
                                            <th>S No.</th>
                                            <th>Batch Name</th>
                                            <th>Total Learners</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            @if (Auth::user()->u_role == 1)
                                            <th>Status</th>
                                            <th>Allot Learner</th>
                                            <th class="text-center">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody id="batch_table">
                                        <?php $i = $courseBatchs->firstItem() ?>
                                        @foreach($courseBatchs as $batch)
                                        @if ($batch->status == 1)
                                        <tr>
                                            <td><strong>{{$i++}}</strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">{{ $batch->name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">
                                                        {{$batch->allot_batches_count}}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">
                                                        {{date('d-M-Y', strtotime($batch->start_date)) }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">
                                                        {{date('d-M-Y', strtotime($batch->end_date)) }}</span>
                                                </div>
                                            </td>
                                            @if (Auth::user()->u_role == 1)
                                            <td>
                                                <select data-id="{{$batch->id}}" class="statusChecked2 badge badge-xs {{$batch->status == 1 ? "bg-success" : ($batch->status == 0 ? "bg-danger" : "bg-light text-dark")}} py-2">
                                                    <option class="bg-light text-dark" value="1" {{$batch->status == 1 ? "selected" : ""}}>Active</option>
                                                    @if (Auth::user()->u_role == 1)
                                                    <option class="bg-light text-dark" value="0" {{$batch->status == 0 ? "selected" : ""}}>Deactive</option>
                                                    <option class="bg-light text-dark" value="3" {{$batch->status == 3 ? "selected" : ""}}>Ended</option>
                                                    @endif
                                                </select>
                                            </td>
                                            <td>
                                                <a href="/batch/allot/{{$batch->id}}" class="badge-lg badge badge-rounded badge-danger"><i class="me-1 fa-solid fa-paperclip"></i>Add Learner</a>
                                                <a href="/batch/unallot/{{$batch->id}}" class="badge-lg badge badge-rounded badge-primary"><i class="me-1 fa-solid fa-paperclip"></i>Remove Learner</a>
                                            </td>
                                            <td>
                                                <span>
                                                    <a type="button" data-id="{{$batch->id}}" class="mx-2 edit_btn mb-2" data-bs-toggle="modal" data-bs-target="#editBatch"  data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a>
                                                    <a type="button" data-id="{{$batch->id}}" class="delete_btn mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2"  data-bs-toggle="tooltip" data-placement="top" title="Delete"><i class="fa-solid fa-xmark text-danger"></i></a>
                                                </span>
                                            </td>
                                            @endif
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                {{$courseBatchs->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="exampleModalCenter2">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body text-center">
                <h4 class="mb-0">Are you sure you want to delete this item?</h4>
                <p class="mb-0">This item will be deleted immediately. You can't undo this action.</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('delete.batch')}}" method="POST">
                    @csrf
                    <input type="hidden" id="courseId" name="id">
                    <button type="button" class="btn btn-primary light btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger light btn-sm" href="">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Edit Batch --}}
<div class="modal fade" id="editBatch">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{url('/dashboard')}}" id="edit_batch">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Edit Batch</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <span class="text-danger mb-2 text-center" id="error2"></span>
                    <div class="row form-group-sm" id="form_details">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary light btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="updateBatch" class="btn btn-danger light btn-sm" href="">Update</button>
                </div>
           </form>
        </div>
    </div>
</div>


{{-- Create New Batch --}}
<div class="modal fade" id="createBatch">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{url('/dashboard')}}" id="create_batch">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create New Batch</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <span class="text-danger mb-2 text-center" id="error"></span>
                    <div class="row form-group-sm">
                        <div class="col-lg-12 mb-3">
                            <label for="batchName" class="text-dark">Batch Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="" id="batchName" placeholder="Enter Batch Name" name="batch_name">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="startDate" class="text-dark">Start Date <span class="text-danger">*</span></label>
                            <input type="date" id="startDate" class="form-control" value="" name="start">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="endDate" class="text-dark">End Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="endDate" value="" name="end">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary light btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="batchCreate" class="btn btn-danger light btn-sm" href="">Create</button>
                </div>
           </form>
        </div>
    </div>
</div>


<!-- Jquery Cdn -->
<link rel="stylesheet" href="{{asset('vendor/toastr/css/toastr.min.css')}}">
<script src="{{asset('vendor/toastr/js/toastr.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Delete btn
    $(document).ready(function(){
        $(document).on('click','.delete_btn', function(){
            $id = $(this).data('id');
            $('#courseId').val($id);
        });
    });

    // Edit btn
    $(document).ready(function(){
        $(document).on('click','.edit_btn', function(){
            $Bid = $(this).data('id');
            $.ajax({
                url: '{{ url("/update-course-batch")}}',
                type: 'post',
                data: {
                    _token: '{{csrf_token()}}',
                    batch: $Bid,
                },
                dataType: 'json',
                success: function(respond) {
                    $y = 1;
                    // $htmlView = "";
                    console.log();
                    if (respond['Batchs']) {
                        $htmlView = `<div class="col-lg-12 mb-3">
                            <label for="batchName" class="text-dark">Batch Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="${respond['Batchs'].name}" id="nameBatch" placeholder="Enter Batch Name" name="nameBatch">
                            <input type="hidden" value="${respond['Batchs'].id}" id="batchId">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="startDate" class="text-dark">Start Date <span class="text-danger">*</span></label>
                            <input type="date" id="startingDate" class="form-control" value="${respond['Batchs'].start_date}" name="startingDate">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="endDate" class="text-dark">End Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="endingDate" value="${respond['Batchs'].end_date}" name="endingDate">
                        </div>`;
                        $("#form_details").html($htmlView);
                    } else {
                        $("#form_details").html(
                            "<div class='alert alert-danger alert-dismissible fade show text-center' role='alert'><h1 class='text-danger mb-0'><i class='fa-solid fa-triangle-exclamation'></i></h1><strong>Oops </strong> Something Went Wrong!!</div>"
                        );
                    }
                }
            });
        });
    });

    // Edit Batch By Ajax
    $(document).ready(function(){
        $(document).on('click','#updateBatch', function(e){
            e.preventDefault();
            $batchName = $('#nameBatch').val();
            $startDate = $('#startingDate').val();
            $endDate = $('#endingDate').val();
            $batchId = $('#batchId').val();

            if ($batchName=="" || $startDate =="" || $endDate==""){
                $('#error2').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h1 class="text-danger mb-0"><i class="fa-solid fa-triangle-exclamation"></i></h1>
                    <strong>Error!!</strong> Please Fill All Required Field</div>`);
                setTimeout(function(){
                    $('#error2').html("").fadeIn("slow");
                }, 2000);
            }else{
                $.ajax({
                    url:'{{ url("/update-batch-Data")}}',
                    type:'post',
                    data: { _token: '{{csrf_token()}}', batchName:$batchName , startDate:$startDate , endDate:$endDate , batchId: $batchId},
                    dataType:'json',
                    success:function(respond){
                        $('#activeRecord').click();
                        $(function () {
                            $('#editBatch').modal('toggle');
                        });
                        setTimeout(() => {
                            if(respond.status == 1){
                                toastr.info(respond.message);
                            }else{
                                toastr.error(respond.message);
                            }
                        },500)
                    }
               });
            }
        });
    });

    // Create Batch By Ajax
    $(document).ready(function(){
        $(document).on('click','#batchCreate', function(e){
            e.preventDefault();
            $batchName = $('#batchName').val();
            $startDate = $('#startDate').val();
            $endDate = $('#endDate').val();

            if ($batchName=="" || $startDate =="" || $endDate==""){
                $('#error').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h1 class="text-danger mb-0"><i class="fa-solid fa-triangle-exclamation"></i></h1>
                    <strong>Error!!</strong> Please Fill All Required Field</div>`);
                setTimeout(function(){
                    $('#error').html("").fadeIn("slow");
                }, 2000);
            }else{
                $.ajax({
                    url:'{{ url("/create-new-batch")}}',
                    type:'post',
                    data: { _token: '{{csrf_token()}}', batchName:$batchName , startDate:$startDate , endDate:$endDate , courseId: {{$courseName->id}}},
                    dataType:'json',
                    success:function(respond){
                        $('#activeRecord').click();
                        $('#batchName').val('');
                        $('#startDate').val('');
                        $('#endDate').val('');
                        $(function () {
                            $('#createBatch').modal('toggle');
                        });
                        setTimeout(() => {
                            if(respond.status == 1){
                                toastr.info(respond.message);
                                $id = respond.redirect;
                                $url = '/batch/allot/'+$id;
                                window.location.replace($url);
                            }else{
                                toastr.error(respond.message);
                            }
                        },500)
                    }
               });
            }
        });
    });

     // Change Status by dropDown
     $(document).ready(function(){
        $(document).on('change','.statusChecked2', function(){
            $id = $(this).data('id');
            $status = $(this).val();
            $.ajax({
                url:'{{ url("/update-batch-status")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}', status: $status, id: $id},
                dataType:'json',
                success:function(respond){
                    if($status == 1){
                        $('#deactiveRecord').click();
                    }else{
                        $('#activeRecord').click();
                    }
                    toastr.success("Batch Status Updated");
                }
            });
        });
    });

    // Change Status by Switch Button
    $(document).ready(function(){
        $(document).on('change','.statusChecked', function(){
            $id = $(this).data('id');
            if($(this).prop('checked') == true){
                $status = 1;
            }else{
                $status = 0;
            }
            $.ajax({
                url:'{{ url("/update-batch-status")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}', status: $status, id: $id},
                dataType:'json',
                success:function(respond){
                    if($status == 1){
                        $('#deactiveRecord').click();
                    }else{
                        $('#activeRecord').click();
                    }
                    toastr.success("Batch Status Updated");
                }
            });
        });
    });

    $(document).ready(function() {
        $('#searchBatch').on('input', function(e) {
            $value = $(this).val();
            $status = $('#search_status').val();
            console.log($status);
            $.ajax({
                url: '{{ url("/search-batch")}}',
                type: 'post',
                data: {
                    _token: '{{csrf_token()}}',
                    search: $value,
                    status: $status,
                    cid: {{$courseName->id}}
                },
                dataType: 'json',
                success: function(respond) {
                    $y = 1;
                    $htmlView = "";
                    if (respond['batch'].length > 0) {
                        for (let i = 0; i < respond['batch'].length; i++) {
                            $htmlView += `<tr>
                                            <td><strong>${$y++}</strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">${respond['batch'][i].name}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">
                                                        ${respond['batch'][i].allot_batches_count}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">
                                                        ${moment(respond['batch'][i].start_date).format('DD-MMM-YYYY')}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">
                                                        ${moment(respond['batch'][i].end_date).format('DD-MMM-YYYY')}</span>
                                                </div>
                                            </td>
                                            @if (Auth::user()->u_role == 1)
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input statusChecked" type="checkbox" role="switch" id="checkBox" data-id="${respond['batch'][i].id}" ${respond['batch'][i].status == 1 ? "checked":""}>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="/batch/allot/${respond['batch'][i].id}" class="badge-lg badge badge-rounded badge-danger"><i class="me-1 fa-solid fa-paperclip"></i>Add Learner</a>
                                                <a href="/batch/unallot/${respond['batch'][i].id}" class="badge-lg badge badge-rounded badge-primary"><i class="me-1 fa-solid fa-paperclip"></i>Remove Learner</a>
                                            </td>
                                            <td>
                                                <span>
                                                    <a type="button" data-id="${respond['batch'][i].id}" class="mx-2 edit_btn mb-2" data-bs-toggle="modal" data-bs-target="#editBatch"  data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a>
                                                    <a type="button" data-id="${respond['batch'][i].id}" class="delete_btn mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2"  data-bs-toggle="tooltip" data-placement="top" title="btn-close"><i class="fa-solid fa-xmark text-danger"></i></a>
                                                </span>
                                            </td>
                                            @endif
                                        </tr>`;
                        }
                        $("#batch_table").html($htmlView);
                    } else {
                        $("#batch_table").html(
                            "<tr><td colspan='7'><div class='justify-content-center d-flex align-items-center'><span class='w-space-no fs-3 text-primary'>No Record Found</span></div></td></tr><tr></tr>"
                        );
                    }
                }
            });
        });
    });

    $(document).ready(function(){
        $('#activeRecord').on('click',function Activebatch(e){ 
            $(this).addClass("btn-primary");
            $('#endedRecord').removeClass("btn-primary");
            $('#deactiveRecord').removeClass("btn-primary");
            $('#search_status').val(1);
            $.ajax({
                url:'{{ url("/view-active-batch")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}' , cid: {{$courseName->id}}},
                dataType:'json',
                success:function(respond){
                    $y =1;
                    $htmlView = "";
                    if(respond['Batchs'].length > 0){
                            for(let i = 0; i < respond['Batchs'].length; i++){
                                $htmlView += `<tr>
                                            <td><strong>${$y++}</strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">${respond['Batchs'][i].name}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">
                                                        ${respond['Batchs'][i].allot_batches_count}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">
                                                        ${moment(respond['Batchs'][i].start_date).format('DD-MMM-YYYY')}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">
                                                        ${moment(respond['Batchs'][i].end_date).format('DD-MMM-YYYY')}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <select data-id="${respond['Batchs'][i].id}" class="statusChecked2 badge badge-xs ${respond['Batchs'][i].status == 1 ? "bg-success" : respond['Batchs'][i].status == 0 ? "bg-danger" : "bg-light text-dark"} py-2">
                                                    <option class="bg-light text-dark" value="1" ${respond['Batchs'][i].status == 1 ? "selected" : ""}>Active</option>
                                                    @if (Auth::user()->u_role == 1)
                                                    <option class="bg-light text-dark" value="0" ${respond['Batchs'][i].status == 0 ? "selected" : ""}>Deactive</option>
                                                    <option class="bg-light text-dark" value="3" ${respond['Batchs'][i].status == 3 ? "selected" : ""}>Ended</option>
                                                    @endif
                                                </select>
                                            </td>
                                            <td>
                                                <a href="/batch/allot/${respond['Batchs'][i].id}" class="badge-lg badge badge-rounded badge-danger"><i class="me-1 fa-solid fa-paperclip"></i>Add Learner</a>
                                                <a href="/batch/unallot/${respond['Batchs'][i].id}" class="badge-lg badge badge-rounded badge-primary"><i class="me-1 fa-solid fa-paperclip"></i>Remove Learner</a>
                                            </td>
                                            <td>
                                                <span>
                                                    <a type="button" data-id="${respond['Batchs'][i].id}" class="mx-2 edit_btn mb-2" data-bs-toggle="modal" data-bs-target="#editBatch"  data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a>
                                                    <a type="button" data-id="${respond['Batchs'][i].id}" class="delete_btn mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2"  data-bs-toggle="tooltip" data-placement="top" title="btn-close"><i class="fa-solid fa-xmark text-danger"></i></a>
                                                </span>
                                            </td>
                                        </tr>`;
                            }
                            $("#batch_table").html($htmlView);
                    }else{
                        $("#batch_table").html("<tr><td colspan='7'><div class='justify-content-center d-flex align-items-center'><span class='w-space-no fs-3 text-primary'>No Record Found</span></div></td></tr><tr></tr>");
                    }
                }
            });
        });
    });

    $(document).ready(function(){
        $('#deactiveRecord').on('click',function Deactivebatch(e){ 
            $(this).addClass("btn-primary");
            $('#activeRecord').removeClass("btn-primary");
            $('#endedRecord').removeClass("btn-primary");
            $('#search_status').val(0);
            $.ajax({
                url:'{{ url("/view-deactive-batch")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}' , cid: {{$courseName->id}} },
                dataType:'json',
                success:function(respond){
                    $y =1;
                    $htmlView = "";
                    if(respond['Batchs'].length > 0){
                            for(let i = 0; i < respond['Batchs'].length; i++){
                                $htmlView += `<tr>
                                            <td><strong>${$y++}</strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">${respond['Batchs'][i].name}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">
                                                        ${respond['Batchs'][i].allot_batches_count}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">${moment(respond['Batchs'][i].start_date).format('DD-MMM-YYYY')}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">${moment(respond['Batchs'][i].end_date).format('DD-MMM-YYYY')}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input statusChecked" type="checkbox" role="switch" id="checkBox" data-id="${respond['Batchs'][i].id}" ${respond['Batchs'][i].status == 1 ? "checked":""}>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="badge-lg badge badge-rounded badge-outline-danger text-danger">Activate to Allot</button>
                                            </td>
                                            <td>
                                                <span>
                                                    <a type="button" data-id="${respond['Batchs'][i].id}" class="mx-2 edit_btn mb-2" data-bs-toggle="modal" data-bs-target="#editBatch"  data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a>
                                                    <a type="button" data-id="${respond['Batchs'][i].id}" class="delete_btn mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2"  data-bs-toggle="tooltip" data-placement="top" title="btn-close"><i class="fa-solid fa-xmark text-danger"></i></a>
                                                </span>
                                            </td>
                                        </tr>`;
                            }
                            $("#batch_table").html($htmlView);
                    }else{
                        $("#batch_table").html("<tr><td colspan='7'><div class='justify-content-center d-flex align-items-center'><span class='w-space-no fs-3 text-primary'>No Record Found</span></div></td></tr><tr></tr>");
                    }
                }
            });
        });
    });

    $(document).ready(function(){
        $('#endedRecord').on('click',function EndedRecord(e){ 
            $(this).addClass("btn-primary");
            $('#deactiveRecord').removeClass("btn-primary");
            $('#activeRecord').removeClass("btn-primary");
            $('#search_status').val(3);
            $.ajax({
                url:'{{ url("/view-ended-batch")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}', cid: {{$courseName->id}}},
                dataType:'json',
                success:function(respond){
                    $y =1;
                    $htmlView = "";
                    if(respond['Batchs'].length > 0){
                            for(let i = 0; i < respond['Batchs'].length; i++){
                                $htmlView += `<tr>
                                            <td><strong>${$y++}</strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">${respond['Batchs'][i].name}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">
                                                        ${respond['Batchs'][i].allot_batches_count}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">
                                                        ${moment(respond['Batchs'][i].start_date).format('DD-MMM-YYYY')}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">
                                                        ${moment(respond['Batchs'][i].end_date).format('DD-MMM-YYYY')}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-xs badge-danger">Ended</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-xs light badge-primary">Batch Ended</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-xs light badge-primary">Batch Ended</span>
                                            </td>
                                        </tr>`;
                            }
                            $("#batch_table").html($htmlView);
                    }else{
                        $("#batch_table").html("<tr><td colspan='7'><div class='justify-content-center d-flex align-items-center'><span class='w-space-no fs-3 text-primary'>No Record Found</span></div></td></tr><tr></tr>");
                    }
                }
            });
        });
    });
</script>
@endsection