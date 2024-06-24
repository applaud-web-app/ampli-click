@extends('layouts.master')
@section('title','All Trainer')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @include('message')
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card h-auto">
                  <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                      <div class="input-group search-area mb-md-0 mb-3">
                        <input type="text" class="form-control" placeholder="Search" id="search_teacher" name="search_teacher">
                      </div>
                      <div>
                        <a href="/add-teacher" class="btn btn-primary">+ New Trainer</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            <div class="col-xl-12">


                <div class="row" id="teacher_table">
                    <!--column-->
                    @foreach ($teachers as $teacher)
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="card contact_list text-center">
                            <div class="card-body">
                                <div class="user-content">
                                    <div class="user-info">
                                        <div class="user-img">
                                            <img src="upload/teachers/{{$teacher->image}}" alt="" class="avatar avatar-xl">
                                        </div>
                                        <div class="user-details">
                                            <h4 class="user-name mb-0">{{$teacher->teacher_name}}</h4>
                                            <p>{{$teacher->designation}}</p>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a href="javascript:void(0);" class="btn sharp2 rounded-circle {{$teacher->gender == 1 ? "btn-primary" : (($teacher->gender == 2 ) ? 'btn-danger' : 'btn-warning') }}" data-bs-toggle="dropdown" title="{{$teacher->gender == 1 ? "Male" : (($teacher->gender == 2 ) ? 'Female' : 'Other') }}" aria-expanded="false">
                                        </a>
                                    </div>
                                </div>
                                <div class="contact-icon">
                                    <span class="badge light  {{$teacher->status == 1 ? "badge-primary" : "badge-danger"}}">Status : {{$teacher->status == 1 ? "Active" : "Disable"}}</span>
                                </div>
                                <div class="">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('edit.teacher', ['id' => $teacher->id]) }}" class="btn  btn-primary btn-sm w-50 me-2"><i class="fa-solid fa-user me-2"></i>Edit</a>
                                        <a href="{{ route('delete.teacher', ['id' => $teacher->id]) }}" onclick="return confirm('Are you sure want to delete this?');" class="btn  btn-light btn-sm w-50 "><i class="me-2 fa-sharp fa-regular fa-trash-can"></i>Delete</a>
                                    </div>
                                    <div class="mt-2">                                                
                                        {{-- <a href="{{ route('passUpdate.teacher', ['id' => $teacher->id]) }}" class="btn  btn-success btn-sm w-100 ">Update Password</a> --}}
                                        <!-- Small modal -->
                                        <button type="button" id="" class="modalpass btn btn-success btn-sm w-100" data-bs-toggle="modal" data-bs-target=".bd-example-modal-sm" data-id="{{$teacher->id}}">Update Password</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                                
                    @endforeach
                    <!--/column-->

                </div>	



                <div class="table-pagenation teach justify-content-center">
                    <nav>
                        <ul class="pagination pagination-gutter pagination-primary no-bg">
                            {{$teachers->links()}}
                        </ul>
                    </nav>
                </div>



                {{-- Modal Box --}}
                <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content" id="modalbody">
                        </div>
                    </div>
                </div>
            
              
            </div>
        </div>
    </div>
</div>    
<!-- Jquery Cdn -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //  Update Password
    $(document).ready(function(){
        $(document).on('click','.modalpass', function(){
            $id = $(this).data('id');
            console.log($id);
            $.ajax({
                url:'{{ url("/fetch-teacher/")}}/'+$id,
                type:'post',
                data: { _token: '{{csrf_token()}}' },
                dataType:'json',
                success:function(respond){
                    console.log(respond);
                    if(respond['teachers'].length > 0){
                        $("#modalbody").html(
                            `<form action="/teacher/passUpdate" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">${respond['teachers'][0].teacher_name}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col-sm-12 m-b30">
                                        <label class="form-label">Update Password<span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="updatepassword" placeholder="Update Password" required="">
                                        <input type="hidden"  name="tid" value="${respond['teachers'][0].id}">
                                        <span class="text-danger"> @error('updatepassword')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>  
                                                                 
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                            </div>
                           </form>`);
                    }else{
                        $("#modalbody").append("<span class='text-danger'>Error!! Please Try Again Later</span>");
                    }
                }
            });
        });
    });

    // Searching
    $(document).ready(function(){
        
        $('#search_teacher').on('input',function(e){ 
            $value = $(this).val();

            $.ajax({
                url:'{{ url("/search-teacher")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}', search: $value },
                dataType:'json',
                success:function(respond){
                    console.log(respond);
                    $y =1;
                    $htmlView = "";
                    if(respond['teachers'].length > 0){
                            for(let i = 0; i < respond['teachers'].length; i++){
                                $htmlView += `<div class="col-xl-3 col-lg-4 col-sm-6">
                                <div class="card contact_list text-center">
                                    <div class="card-body">
                                        <div class="user-content">
                                            <div class="user-info">
                                                <div class="user-img">
                                                    <img src="upload/teachers/${respond['teachers'][i].image}" alt="" class="avatar avatar-xl">
                                                </div>
                                                <div class="user-details">
                                                    <h4 class="user-name mb-0">${respond['teachers'][i].teacher_name}</h4>
                                                    <p>${respond['teachers'][i].designation}</p>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <a href="javascript:void(0);" class="btn sharp2 rounded-circle  ${respond['teachers'][i].gender == 1 ? "btn-primary" : respond['teachers'][i].gender == 2 ? 'btn-danger' : 'btn-warning' }" data-bs-toggle="dropdown" title="${respond['teachers'][i].gender == 1 ? "Male" : respond['teachers'][i].gender == 2 ? 'Female' : 'Other' }" aria-expanded="false">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="contact-icon">
                                            <span class="badge light  ${respond['teachers'][i].status == 1 ?  "badge-primary" : "badge-danger" }">Status : ${respond['teachers'][i].status == 1 ?   "Active" : "Disable" }</span>
                                        </div>
                                        <div class="">
                                            <div class="d-flex align-items-center">
                                                <a href="/teacher/edit/${respond['teachers'][i].id}" class="btn  btn-primary btn-sm w-50 me-2"><i class="fa-solid fa-user me-2"></i>Edit</a>
                                                <a href="/teacher/delete/${respond['teachers'][i].id}" onclick="return confirm('Are you sure want to delete this?');" class="btn  btn-light btn-sm w-50 "><i class="me-2 fa-sharp fa-regular fa-trash-can"></i>Delete</a>
                                            </div>
                                            <div class="mt-2">
                                                <button type="button" id="" class="modalpass btn btn-success btn-sm w-100" data-bs-toggle="modal" data-bs-target=".bd-example-modal-sm" data-id="${respond['teachers'][i].id}">Update Password</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  `;
                            }
                            $("#teacher_table").html($htmlView);
                    }else{
                        $("#teacher_table").html("<tr><td colspan='7'><div class='justify-content-center d-flex align-items-center'><span class='w-space-no fs-3 text-primary'>No Record Found</span></div></td></tr><tr></tr>");
                    }
                }
            });
        });
    });
</script>
@endsection