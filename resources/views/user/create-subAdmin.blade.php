@extends('layouts.master')
@section('title','Sub Admins')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @include('message')
        <div class="row justify-content-center">
            <div class="col-xl-12 mt-3">
                <div class="d-flex align-items-center">
                    @if (Auth::user()->u_role == 1)
                    <button type="button" class="filterSubAdmins border-0 rounded-top btn shadow-none btn-outline-primary btn-sm rounded-0 btn-primary" data-id="1">Active Members</button>
                    <button type="button" class="filterSubAdmins border-0 rounded-top btn shadow-none btn-outline-primary btn-sm rounded-0" data-id="0">Deactive Members</button>
                    @endif
                </div>
              
                    <div class="card h-auto" id="bootstrap-table2">
                        <div class="card-header flex-wrap d-flex justify-content-between border-0  ">
                            <div>
                                <h4 class=" mb-0 card-title d-flex align-items-center">Sub Admins</h4>
                            </div>
                            <div class="ms-auto d-flex align-items-center">
                                <input type="hidden" name="status" id="search_status" value="1">
                                <label class="d-flex align-items-center mb-0"><input type="search"
                                        class="ms-2 form-control " placeholder="Search Active Batch"
                                        id="searchsubadmin" name="searchsubadmin" aria-controls="example"></label>
                                @if (Auth::user()->u_role == 1)
                                <button class="shadow-none btn btn-outline-primary btn-sm ms-2" type="button" data-id="" class="delete_btn mb-2" data-bs-toggle="modal" data-bs-target="#createBatch"  data-bs-toggle="tooltip" data-placement="top" title="Create Batch">Create Sub Admin</button>
                                @endif
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table display dataTable">
                                    <thead>
                                        <tr>
                                            <th>SNo.</th>
                                            <th>User Name</th>
                                            <th>Designation</th>
                                            <th>Email Id</th>
                                            @if (Auth::user()->u_role == 1)
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody id="batch_table">
                                        @foreach($subadmins as $batch)
                                        @if ($batch->status == 1)
                                        <tr>
                                            <td><strong>{{++$loop->index}}</strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">{{ $batch->name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">
                                                        {{$batch->designation}}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">
                                                        {{$batch->email }}
                                                    </span>
                                                </div>
                                            </td>
                                            @if (Auth::user()->u_role == 1)
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input statusChecked" type="checkbox" role="switch" id="checkBox" data-id="{{$batch->id}}" {{$batch->status == 1 ? "checked": ""}}>
                                                </div>
                                            </td>
                                            <td class="text-center">
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
                                {{-- {{$subadmins->links()}} --}}
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
                <form action="/delete-subadmin" method="POST">
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
            <form action="{{url('/dashboard')}}" id="edit_subAdmin">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Edit Sub-Admin</h5>
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
                    <button type="submit" id="updateSubadmin" class="btn btn-danger light btn-sm" href="">Update</button>
                </div>
           </form>
        </div>
    </div>
</div>


{{-- Create New Batch --}}
<div class="modal fade" id="createBatch">
    <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="/create-subAdmin" method="post" enctype="multipart/form-data" id="create_batch">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create New Sub-Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body" id="form_details">
                    <span class="text-danger mb-2 text-center" id="error"></span>
                    <div class="row form-group-sm">
                        <div class="col-lg-12 mb-3">
                            <label for="batchName" class="text-dark">Upload Image</label>
                            <input type="file" class="form-control" value="" id="batchName" placeholder="Enter Name" name="uploadImage">
                            @error('uploadImage') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="batchName" class="text-dark">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="" id="batchName" placeholder="Enter Name" name="name">
                            @error('name') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="startDate" class="text-dark">Designation <span class="text-danger">*</span></label>
                            <input type="text" id="startDate" class="form-control" value="" placeholder="Enter Designation" name="designation">
                            @error('designation') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="endDate" class="text-dark">Email Id <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="endDate" value="" placeholder="Enter Email" name="email">
                            @error('email') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="endDate" class="text-dark">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="endDate" value="" placeholder="Enter Password" name="password">
                            @error('password') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary light btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="batchCreate" class="btn btn-danger light btn-sm">Create</button>
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
            $id = $(this).data('id');
            $.ajax({
                url: '{{ url("/update-subadmin-details")}}',
                type: 'post',
                data: {
                    _token: '{{csrf_token()}}',
                    id: $id,
                },
                dataType: 'json',
                success: function(respond) {
                    $y = 1;
                    if (respond['user']) {
                        $htmlView = `<span class="text-danger mb-2 text-center" id="error2"></span>
                    <div class="row form-group-sm">
                        <div class="col-lg-12 mb-3">
                            <label for="batchName" class="text-dark">Upload Image</label><br>
                            <img width="100px" src="/upload/teachers/${respond['user'].image}" class="img-fluid mb-2">
                            <input type="file" class="form-control" value="" id="subimage" placeholder="Enter Name" name="uploadImage">
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="batchName" class="text-dark">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="${respond['user'].name}" id="subname" placeholder="Enter Name" name="name">
                            <input type="hidden" value="${respond['user'].id}" name="id">
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="startDate" class="text-dark">Designation <span class="text-danger">*</span></label>
                            <input type="text" id="designation" class="form-control" value="${respond['user'].designation}" placeholder="Enter Designation" name="designation">
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="endDate" class="text-dark">Email Id <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="subemail" value="${respond['user'].email}" placeholder="Enter Email" name="email">
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="endDate" class="text-dark">Password <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" value="" placeholder="Enter Password" id="Password" name="password">
                        </div>
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

     // Edit Subject By Ajax
     $(document).ready(function(){
        $(document).on('click','#updateSubadmin', function(e){
            e.preventDefault();
            var FormDataD = new FormData(document.getElementById('edit_subAdmin'));
            $subimage = $('#subimage').val();
            $subname = $('#subname').val();
            $designation = $('#designation').val();
            $subemail = $('#subemail').val();
            $password = $('#Password').val();
            if ($subname=="" || $designation =="" || $subemail == "" || $password == "" ){
                $('#error2').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h1 class="text-danger mb-0"><i class="fa-solid fa-triangle-exclamation"></i></h1>
                    <strong>Error!!</strong> Please Fill All Required Field</div>`);
                setTimeout(function(){
                    $('#error2').html("").fadeIn("slow");
                }, 2000);
            }else{
                $.ajax({
                    url:'{{ url("/update-subadmin")}}',
                    type:'post',
                    data: FormDataD,
                    dataType:'json',
                    contentType: false,
                    processData: false,
                    success:function(respond){
                        $('#subimage').val('');
                        $('#subname').val('');
                        $('#designation').val('');
                        $('#subemail').val('');
                        $('#Password').val('');
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

    $(document).ready(function(){
        $('.filterSubAdmins').on('click',function Activebatch(e){ 
            $('.filterSubAdmins').removeClass("btn-primary");
            $(this).addClass("btn-primary");
            $status = $(this).data('id');

            $('#search_status').val($status);
            $.ajax({
                url:'{{ url("/fetch-subadmin")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}' , status: $status },
                dataType:'json',
                success:function(respond){
                    $y =1;
                    $htmlView = "";
                    if(respond['users'].length > 0){
                            for(let i = 0; i < respond['users'].length; i++){
                                $htmlView += `<tr>
                                            <td><strong>${$y++}</strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">${respond['users'][i].name}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">
                                                        ${respond['users'][i].designation}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">
                                                        ${respond['users'][i].email}
                                                    </span>
                                                </div>
                                            </td>
                                            @if (Auth::user()->u_role == 1)
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input statusChecked" type="checkbox" role="switch" id="checkBox" data-id=" ${respond['users'][i].id}" ${respond['users'][i].status == 1 ? "checked" : ""}>
                                                </div>
                                            </td> 
                                            <td class="text-center">
                                                <span>
                                                    <a type="button" data-id="${respond['users'][i].id}" class="mx-2 edit_btn mb-2" data-bs-toggle="modal" data-bs-target="#editBatch"  data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a>
                                                    <a type="button" data-id="${respond['users'][i].id}" class="delete_btn mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2"  data-bs-toggle="tooltip" data-placement="top" title="Delete"><i class="fa-solid fa-xmark text-danger"></i></a>
                                                </span>
                                            </td>
                                            @endif
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

    
    // Status 
    $(document).ready(function(){
        $(document).on('change','.statusChecked', function(){
            $id = $(this).data('id');
            if($(this).prop('checked') == true){
                $status = 1;
            }else{
                $status = 0;
            }
            console.log($status);
            $.ajax({
                url:'{{ url("/update-subadmin-status")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}', status: $status, id: $id},
                dataType:'json',
                success:function(respond){
                    if($status == 1){
                        $('.filterSubAdmins')[1].click();
                    }else{
                        $('.filterSubAdmins')[0].click();
                    }
                }
            });
        });
    });

    // Search 
    $(document).ready(function(){
        $('#searchsubadmin').on('input',function(e){ 
            $value = $(this).val();
            $status = $("#search_status").val()
            $.ajax({
                url:'{{ url("/search-subadmin")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}', search: $value ,status: $status},
                dataType:'json',
                success:function(respond){
                    $y =1;
                    $htmlView = "";
                    if(respond['users'].length > 0){
                            for(let i = 0; i < respond['users'].length; i++){
                                $htmlView += `<tr>
                                            <td><strong>${$y++}</strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">${respond['users'][i].name}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">
                                                        ${respond['users'][i].designation}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="w-space-no">
                                                        ${respond['users'][i].email}
                                                    </span>
                                                </div>
                                            </td>
                                            @if (Auth::user()->u_role == 1)
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input statusChecked" type="checkbox" role="switch" id="checkBox" data-id=" ${respond['users'][i].id}" ${respond['users'][i].status == 1 ? "checked" : ""}>
                                                </div>
                                            </td> 
                                            <td class="text-center">
                                                <span>
                                                    <a type="button" data-id="${respond['users'][i].id}" class="mx-2 edit_btn mb-2" data-bs-toggle="modal" data-bs-target="#editBatch"  data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a>
                                                    <a type="button" data-id="${respond['users'][i].id}" class="delete_btn mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2"  data-bs-toggle="tooltip" data-placement="top" title="Delete"><i class="fa-solid fa-xmark text-danger"></i></a>
                                                </span>
                                            </td>
                                            @endif
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