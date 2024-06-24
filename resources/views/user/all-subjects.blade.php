@extends('layouts.master')
@section('title','All Subject')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @include('message') 
        <div class="d-flex align-items-center justify-content-between">
            <div class="btn-group">
                @if (Auth::user()->u_role == 1)
                <button type="button" class="filterSubject border-0 rounded-top btn shadow-none btn-outline-primary btn-sm rounded-0 btn-primary" data-id="1">Active Subject</button>
                <button type="button" class="filterSubject border-0 rounded-top btn shadow-none btn-outline-primary btn-sm rounded-0" data-id="0">Deactive Subject</button>
                @endif
            </div>
            <div class="button-group">
                <a href="{{url()->previous()}}" onclick="window.history.go(-1); return false;" class="ms-2 btn btn-danger btn-xs"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
                <a href="/course/batch/{{$categoryName->id}}" class="btn btn-success btn-xs">Next <i class="fa-solid fa-arrow-right-long"></i></a>
            </div>
        </div>
        <div class="card">
            <div class="card-header border-0 flex-wrap d-flex justify-content-between">
                <div>
                    <h4 class=" mb-0 card-title d-flex align-items-center">{{$categoryName->title}}<i class="mx-2 fs-4 fa-solid fa-arrow-right-long"></i>Subjects</h4>
                </div>
                <div class="ms-auto d-flex align-items-center">
                    <input type="hidden" name="status" id="search_status" value="1">
                    <label class="d-flex align-items-center mb-0"><input type="search" class="ms-2 form-control " placeholder="Search Subject" id="search_subject" name="search_subject" aria-controls="example"></label>
                    @if (Auth::user()->u_role == 1)
                    <button class="shadow-none btn btn-primary btn-sm ms-2" type="button" data-id="{{$categoryName->id}}" class="delete_btn mb-2" data-bs-toggle="modal" data-bs-target="#createSubject" data-bs-toggle="tooltip" data-placement="top" title="Add Subject">Add Subject</button>
                    @endif
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table display dataTablesCard dataTable">
                        <thead>
                            <tr>
                                <th>S No.</th>
                                <th>Subject</th>
                                <th>Learner</th>
                                @if (Auth::user()->u_role == 1)
                                <th>Status</th>
                                @endif
                                <th class="text-center">Upload Media</th>
                                <th class="text-center">Online Class</th>
                                @if (Auth::user()->u_role == 1)
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody id="subject_table"> 
                            @foreach ($subjects as $subject)
                            <tr>
                                <td><strong>{{++$loop->index}}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img class="me-3 rounded avatar avatar-sm" src="/upload/subject/{{$subject->sub_image}}" alt="DexignZone">
                                        <span class="w-space-no">{{$subject->sub_name}}</span>
                                    </div>
                                </td>
                                <td><span>{{$subject->allot_subjects_count}}</span></td>
                                @if (Auth::user()->u_role == 1)
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input statusChecked" data-id="{{$subject->id}}" type="checkbox" role="switch" id="checkBox" data-id="40" {{($subject->status == 1 ? "checked" : "")}}>
                                    </div>
                                </td>
                                @endif
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('upload.subject', ['id' => $subject->id]) }}" class="btn btn-primary cstm_btn shadow btn-xs sharp me-1"><i class="fa-solid fa-upload me-2"></i> Upload</a>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{url('all-online-classes/'.$subject->id) }}" class="btn btn-primary cstm_btn shadow btn-xs sharp me-1"><i class="fa-solid fa-plus me-2"></i> Add Class</a>
                                    </div>
                                </td>
                                @if (Auth::user()->u_role == 1)
                                <td>
                                    <div class="d-flex">
                                        <span>
                                            <a type="button" data-id="{{$subject->id}}" class="mx-2 edit_btn mb-2" data-bs-toggle="modal" data-bs-target="#editSubject" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a>
                                            <a type="button" data-id="{{$subject->id}}" class="delete_btn mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2"  data-bs-toggle="tooltip" data-placement="top" title="btn-close"><i class="fa-solid fa-xmark text-danger"></i></a>
                                        </span>
                                    </div>
                                </td>
                                @endif
                            </tr>                                                          
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="table-pagenation teach justify-content-center mt-5">
                <nav>
                    <ul class="pagination pagination-gutter pagination-primary no-bg">
                        {{$subjects->links()}}
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="exampleModalCenter2">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                <form action="/delete-course-subject" method="POST">
                    @csrf
                    <input type="hidden" id="courseId" name="id">
                    <button type="button" class="btn btn-primary light btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger light btn-sm" href="">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Create New Subject --}}
<div class="modal fade" id="createSubject">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{url('/dashboard')}}" id="create_subject">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <span class="text-danger mb-2 text-center" id="error"></span>
                    <div class="row form-group-sm">
                        <div class="col-lg-12 mb-3">
                            <label for="banner_image" class="form-label">Banner Image <code>( File Type Must Be: Png, Jpg, Jpeg, Gif)</code></label>
                            <img src="/images/upload-default2.png" id="uploadImage" class="w-100 img-fluid img-thumbnail" alt="">
                            <input type="file" class="d-none form-control" name="banner_image" id="banner_image" placeholder="Course Title"> 
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="sub_name" class="form-label">Subject Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="" id="sub_name" placeholder="Enter Subject Name" name="sub_name">
                            <input type="hidden" name="cid" value="{{$categoryName->id}}">
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="sub_descp" class="form-label">Subject Description<span class="text-danger">*</span></label>
                            <textarea  width="100%" rows="5" id="sub_descp" class="form-control" name="sub_descp"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary light btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="addSubject" class="btn btn-danger light btn-sm">Add</button>
                </div>
           </form>
        </div>
    </div>
</div>


{{-- Edit Subject --}}
<div class="modal fade" id="editSubject">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{url('/dashboard')}}" id="edit_subject">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Edit Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body" id="form_details">
                    <input type="file" class="d-none form-control" name="banner_image" id="banner_image2" placeholder="Course Title"> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary light btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="updateSubject" class="btn btn-danger light btn-sm" href="">Update</button>
                </div>
           </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js" ></script>

<script>
    $('#uploadImage').click(function(){
        $('#banner_image').click();
    });
</script>
<script>
    banner_image.onchange = evt => {
      const [file] = banner_image.files
      if (file) {
        uploadImage.src = URL.createObjectURL(file)
      }
    }
</script>

<script>
    $(document).on('click','#uploadImage2', function(){
        $('#banner_image2').click();
    });
</script>
<script>
      $(document).on('change','#banner_image2', function(){
        const [file] = banner_image2.files
        if (file) {
            uploadImage2.src = URL.createObjectURL(file)
        }
      });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
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
                url:'{{ url("/update-subject-status")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}', status: $status, id: $id},
                dataType:'json',
                success:function(respond){
                    if($status == 1){
                        $('.filterSubject')[1].click();
                    }else{
                        $('.filterSubject')[0].click();
                    }
                }
            });
        });
    });

    // Delete
    $(document).ready(function(){
        $(document).on('click','.delete_btn', function(){
            $id = $(this).data('id');
            $('#courseId').val($id);
        });
    });

    // Search 
    $(document).ready(function(){
        $('#search_subject').on('input',function(e){ 
            $value = $(this).val();
            $status = $("#search_status").val()
            $.ajax({
                url:'{{ url("/search-course-subject")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}', search: $value ,status: $status, cId: {{$categoryName->id}} },
                dataType:'json',
                success:function(respond){
                    console.log(respond);
                    $y =1;
                    $htmlView = "";
                    if(respond['subjects'].length > 0){
                            for(let i = 0; i < respond['subjects'].length; i++){
                                $htmlView += `<tr>
                                <td><strong>${$y++}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img class="me-3 rounded avatar avatar-sm" src="/upload/subject/${respond['subjects'][i].sub_image}">
                                        <span class="w-space-no">${respond['subjects'][i].sub_name}</span>
                                    </div>
                                </td>
                                <td><span>${respond['subjects'][i].allot_subjects_count}</span></td>
                                @if (Auth::user()->u_role == 1)
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input statusChecked" data-id="${respond['subjects'][i].id}"  type="checkbox" role="switch" id="checkBox" data-id="40" ${(respond['subjects'][i].status == 1 ? "checked" : "")}>
                                    </div>
                                </td>
                                @endif
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="/subject/upload/${respond['subjects'][i].id}" class="btn btn-danger shadow btn-xs sharp me-1 cstm_btn"><i class="fa-solid fa-upload me-2"></i> Upload</a>
                                    </div>
                                </td>
                                @if (Auth::user()->u_role == 1)
                                <td>
                                    <div class="d-flex">
                                        <span>
                                            <a type="button" data-id="${respond['subjects'][i].id}"  class="mx-2 edit_btn mb-2" data-bs-toggle="modal" data-bs-target="#editSubject" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a>
                                            <a type="button" data-id="${respond['subjects'][i].id}" class="delete_btn mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2" data-placement="top" title="Delete"><i class="fa-solid fa-xmark text-danger"></i></a>
                                        </span>
                                    </div>
                                </td>
                                @endif
                            </tr>`;
                            }
                            $("#subject_table").html($htmlView);
                    }else{
                        $("#subject_table").html("<tr><td colspan='7'><div class='justify-content-center d-flex align-items-center'><span class='w-space-no fs-3 text-primary'>No Record Found</span></div></td></tr><tr></tr>");
                    }
                }
            });
        });
    });

    $(document).ready(function(){
        $('.filterSubject').on('click',function Activebatch(e){ 
            $('.filterSubject').removeClass("btn-primary");
            $(this).addClass("btn-primary");
            $status = $(this).data('id');

            $('#search_status').val($status);
            $.ajax({
                url:'{{ url("/filter-course-subject")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}' , status: $status , cId: {{$categoryName->id}} },
                dataType:'json',
                success:function(respond){
                    $y =1;
                    $htmlView = "";
                    console.log(respond);
                    if(respond['subjects'].length > 0){
                            for(let i = 0; i < respond['subjects'].length; i++){
                                $htmlView += `<tr>
                                <td><strong>${$y++}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img class="me-3 rounded avatar avatar-sm" src="/upload/subject/${respond['subjects'][i].sub_image}">
                                        <span class="w-space-no">${respond['subjects'][i].sub_name}</span>
                                    </div>
                                </td>
                                <td><span>${respond['subjects'][i].allot_subjects_count}</span></td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input statusChecked" type="checkbox" data-id="${respond['subjects'][i].id}" role="switch" id="checkBox" data-id="40" ${(respond['subjects'][i].status == 1 ? "checked" : "")}>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="/subject/upload/${respond['subjects'][i].id}" class="btn btn-danger shadow btn-xs sharp me-1 cstm_btn"><i class="fa-solid fa-upload me-2"></i> Upload</a>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <span>
                                            <a type="button" data-id="${respond['subjects'][i].id}" class="mx-2 edit_btn mb-2" data-bs-toggle="modal" data-bs-target="#editSubject" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a>
                                            <a type="button" data-id="${respond['subjects'][i].id}" class="delete_btn mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2" data-placement="top" title="Delete"><i class="fa-solid fa-xmark text-danger"></i></a>
                                        </span>
                                    </div>
                                </td>
                            </tr>`;
                            }
                            $("#subject_table").html($htmlView);
                    }else{
                        $("#subject_table").html("<tr><td colspan='7'><div class='justify-content-center d-flex align-items-center'><span class='w-space-no fs-3 text-primary'>No Record Found</span></div></td></tr><tr></tr>");
                    }
                }
            });
        });
    });

    // Add Subject
    $(document).ready(function(){
        $(document).on('click','#addSubject', function(e){
            e.preventDefault();
            var FormDataD = new FormData(document.getElementById('create_subject'));
            $subDescp = $('#sub_descp').val();
            $subName = $('#sub_name').val();
            $banner_image = $('#banner_image').val();
            if ($subName=="" || $subDescp ==""){
                $('#error').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h1 class="text-danger mb-0"><i class="fa-solid fa-triangle-exclamation"></i></h1>
                    <strong>Error!!</strong> Please Fill All Required Field</div>`);
                setTimeout(function(){
                    $('#error').html("").fadeIn("slow");
                }, 2000);
            }else{
                $.ajax({
                    url:'{{ url("/add-new-subject")}}',
                    type:'post',
                    data: FormDataD,
                    dataType:'json',
                    contentType: false,
                    processData: false,
                    success:function(respond){
                        $('.filterSubject')[0].click();
                        $('#sub_descp').val('');
                        $('#sub_name').val('');
                        $('#banner_image').val('');
                        $('#uploadImage').attr("src","/upload/course/default-banner.png");
                        $(function () {
                            $('#createSubject').modal('toggle');
                        });
                        setTimeout(() => {
                            if(respond.status == 1){
                                toastr.info(respond.message);
                                    $id = respond.redirect;
                                    $url = '/subject/upload/'+$id;
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

    // Fetch Edit Item Record
     $(document).ready(function(){
        $(document).on('click','.edit_btn', function(){
            $Cid = $(this).data('id');
            console.log($Cid);
            $.ajax({
                url: '{{ url("/fetch-subject-record")}}',
                type: 'post',
                data: {
                    _token: '{{csrf_token()}}',
                    subject: $Cid,
                },
                dataType: 'json',
                success: function(respond) {
                    $y = 1;
                    console.log(respond);
                    if (respond['subject']) {
                        $htmlView = `<span class="text-danger mb-2 text-center" id="error2"></span>
                        <div class="row form-group-sm">
                        <div class="col-lg-12 mb-3">
                            <label for="banner_image" class="form-label">Banner Image <code>( File Type Must Be: Png, Jpg, Jpeg, Gif)</code></label>
                            <img src="/upload/subject/${respond['subject'].sub_image}" id="uploadImage2" class="w-100 img-fluid img-thumbnail" alt="">
                            <input type="file" class="d-none form-control" name="banner_image" id="banner_image2" placeholder="Course Title"> 
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="sub_name" class="form-label">Subject Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="${respond['subject'].sub_name}" id="sub_name2" placeholder="Enter Batch Name" name="sub_name">
                            <input type="hidden" name="id" value="${respond['subject'].id}">
                            <input type="hidden" name="cid" value="${respond['subject'].categories_id }">
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="sub_descp" class="form-label">Subject Description<span class="text-danger">*</span></label>
                            <textarea  width="100%" rows="5" id="sub_descp2" class="form-control" name="sub_descp">${respond['subject'].sub_description}</textarea>
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
        $(document).on('click','#updateSubject', function(e){
            e.preventDefault();
            var FormDataD = new FormData(document.getElementById('edit_subject'));
            $subDescp = $('#sub_descp2').val();
            $subName = $('#sub_name2').val();
            $banner_image = $('#banner_image2').val();
            if ($subName=="" || $subDescp ==""){
                $('#error2').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h1 class="text-danger mb-0"><i class="fa-solid fa-triangle-exclamation"></i></h1>
                    <strong>Error!!</strong> Please Fill All Required Field</div>`);
                setTimeout(function(){
                    $('#error2').html("").fadeIn("slow");
                }, 2000);
            }else{
                $.ajax({
                    url:'{{ url("/update-course-subject")}}',
                    type:'post',
                    data: FormDataD,
                    dataType:'json',
                    contentType: false,
                    processData: false,
                    success:function(respond){
                        $('.filterSubject')[0].click();
                        $('#sub_descp2').val('');
                        $('#sub_name2').val('');
                        $('#banner_image2').val('');
                        $(function () {
                            $('#editSubject').modal('toggle');
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
</script>
@if(Session::has('model'))
<script>
    $(window).on('load', function() {
        setTimeout(function() {
            $('#createSubject').modal('show');
        }, 1000);
    });
</script>
@endif
@endsection