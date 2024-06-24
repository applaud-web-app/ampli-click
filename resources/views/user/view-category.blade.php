@extends('layouts.master')
@section('title','All Courses')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @include('message') 
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="btn-group">
                        @if (Auth::user()->u_role == 1)
                        <button type="button" id="activeRecord" class="border-0 rounded-top btn shadow-none btn-outline-primary btn-primary btn-sm rounded-0">Active Course</button>
                        <button type="button" id="deactiveRecord" class="border-0 rounded-top btn shadow-none btn-outline-primary btn-sm rounded-0">Deactive Course</button>
                        @endif
                    </div>
                    <div class="btn-group">
                        <a href="{{url()->previous()}}" onclick="window.history.go(-1); return false;" class="ms-2 btn btn-danger btn-xs"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
                    </div>
                </div>
                <div class="card" id="">
                    <div class="card-header flex-wrap d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">All Courses</h4>
                        </div>
                        <div class="ms-auto d-flex align-items-center">
                            <label class="d-flex align-items-center mb-0">
                            <input type="hidden" name="status" id="search_status" value="1">
                            <input type="search" class="ms-2 form-control " placeholder="Search" id="search_category" name="search_category" aria-controls="example"></label>
                            @if (Auth::user()->u_role == 1)
                            <a href="/category" type="button" class="ms-2 btn btn-outline-primary btn-sm">Create Courses</a>
                            @endif
                        </div>
                    </div>
                    <div class="tab-content" id="myTabContent-7">
                        <div class="tab-pane fade show active" id="solidbackground" role="tabpanel" aria-labelledby="home-tab-7">	
                            <div class="card-body ">
                                <div class="table-responsive">
                                    <table class="table dataTable display verticle-middle ">
                                        <thead>
                                            <tr>
                                                <th scope="col">SNo.</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Description</th>
                                                <th scope="col" >Subject</th>
                                                <th scope="col" >Batches</th>
                                                @if (Auth::user()->u_role == 1)
                                                <th scope="col" >status</th>
                                                <th scope="col" >Action</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody id="cat_table">
                                            <?php $i = $Categorys->firstItem() ?>
                                            @foreach ($Categorys as $Category)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$Category->title}}</td>
                                                <td title="{{$Category->description}}">{{substr($Category->description,0,40)}} [....]</td>
                                                <td>
                                                    <div class="">
                                                        <a href="/course-subject/{{$Category->id}}" class="btn btn-success btn-sm  p-1 px-2 text-white rounded-pill" style="font-size:13px;"><span  class="p-1 text-white">{{$Category->total_subject_count}}</span>
                                                        | <span class="text-white" href="/course-subject/{{$Category->id}}"><i  class="fa-regular fa-eye"></i></span></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="">
                                                        <a href="/course/batch/{{$Category->id}}" class="btn btn-danger btn-sm p-1 px-2 text-white rounded-pill" style="font-size:13px;"><span class="p-1 text-white">{{$Category->total_batch_count}}</span> | <span class="text-white" href=""><i  class="fa-regular fa-eye"></i></span></a>
                                                    </div>
                                                </td>
                                                @if (Auth::user()->u_role == 1)
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input statusChecked" type="checkbox" role="switch" id="checkBox" data-id="{{$Category->id}}" {{$Category->status == 1 ? "checked": ""}}>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span>
                                                        <a href="{{ route('edit.category', ['id' => $Category->id]) }}" class="me-4" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a>
                                                        <a type="button" data-id="{{$Category->id}}" class="delete_btn mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2"  data-bs-toggle="tooltip" data-placement="top" title="btn-close"><i class="fa-solid fa-xmark text-danger"></i></a>
                                                    </span>
                                                </td>
                                                @endif
                                            </tr>                                                
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center ">
                                {{$Categorys->links()}}
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
                <form action="{{ route('delete.category')}}" method="POST">
                    @csrf
                    <input type="hidden" id="courseId" name="id">
                    <button type="button" class="btn btn-primary light btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger light btn-sm" href="">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Jquery Cdn -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js" ></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function(){
        $(document).on('change','.statusChecked', function(){
            $id = $(this).data('id');
            if($(this).prop('checked') == true){
                $status = 1;
            }else{
                $status = 0;
            }
            $.ajax({
                url:'{{ url("/update-course-status")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}', status: $status, id: $id},
                dataType:'json',
                success:function(respond){
                    if($status == 1){
                        $('#deactiveRecord').click();
                    }else{
                        $('#activeRecord').click();
                    }
                }
            });
        });
    });

    $(document).ready(function(){
        $(document).on('click','.delete_btn', function(){
            $id = $(this).data('id');
            $('#courseId').val($id);
        });
    });

    $(document).ready(function(){
        $('#search_category').on('input',function(e){ 
            $value = $(this).val();
            $status = $('#search_status').val();
            $.ajax({
                url:'{{ url("/search-category")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}', search: $value , status: $status },
                dataType:'json',
                success:function(respond){
                    $y =1;
                    $htmlView = "";
                    if(respond['categorys'].length > 0){
                            for(let i = 0; i < respond['categorys'].length; i++){
                                $htmlView += `<tr>
                                                <td>${$y++}</td>
                                                <td>${respond['categorys'][i].title}</td>
                                                <td title="${respond['categorys'][i].description}">${respond['categorys'][i].description.slice(0, 40)} [....]</td>
                                                <td>
                                                    <div class="">
                                                        <a href="/course-subject/${respond['categorys'][i].id}" class="btn btn-success btn-sm  p-1 px-2 text-white rounded-pill" style="font-size:13px;"><span  class="p-1 text-white">${respond['categorys'][i].total_subject_count}</span>
                                                        | <span class="text-white"><i  class="fa-regular fa-eye"></i></span></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="">
                                                        <a href="/course/batch/${respond['categorys'][i].id}" class="btn btn-danger btn-sm p-1 px-2 text-white rounded-pill" style="font-size:13px;"><span class="p-1 text-white">${respond['categorys'][i].total_batch_count}</span> | <span class="text-white" ><i  class="fa-regular fa-eye"></i></span></a>
                                                    </div>
                                                </td>
                                                @if (Auth::user()->u_role == 1)
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input statusChecked" type="checkbox" role="switch" id="checkBox" data-id="${respond['categorys'][i].id}" ${respond['categorys'][i].status == 1 ? "checked": ""}>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span>
                                                        <a href="/category/edit/${respond['categorys'][i].id}" class="me-4" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a>
                                                        <a type="button" data-id="${respond['categorys'][i].id}" class="delete_btn mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2"  data-bs-toggle="tooltip" data-placement="top" title="btn-close"><i class="fa-solid fa-xmark text-danger"></i></a>
                                                    </span>
                                                </td>
                                                @endif
                                            </tr> `;
                            }
                            $("#cat_table").html($htmlView);
                    }else{
                        $("#cat_table").html("<tr><td colspan='7'><div class='justify-content-center d-flex align-items-center'><span class='w-space-no fs-3 text-primary'>No Record Found</span></div></td></tr><tr></tr>");
                    }
                }
            });
        });
    });

    $(document).ready(function(){
        $('#activeRecord').on('click',function Activebatch(e){ 
            $(this).addClass("btn-primary");
            $('#deactiveRecord').removeClass("btn-primary");
            $('#search_status').val(1);
            $.ajax({
                url:'{{ url("/view-active-category")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}'},
                dataType:'json',
                success:function(respond){
                    $y =1;
                    $htmlView = "";
                    if(respond['categorys'].length > 0){
                            for(let i = 0; i < respond['categorys'].length; i++){
                                $htmlView += `<tr>
                                                <td>${$y++}</td>
                                                <td>${respond['categorys'][i].title}</td>
                                                <td title="${respond['categorys'][i].description}">${respond['categorys'][i].description.slice(0, 40)} [....]</td>
                                                <td>
                                                    <div class="">
                                                        <a href="/course-subject/${respond['categorys'][i].id}" class="btn btn-success btn-sm  p-1 px-2 text-white rounded-pill" style="font-size:13px;"><span href="#" class="p-1 text-white">${respond['categorys'][i].total_subject_count}</span>
                                                        | <span class="text-white" href=""><i  class="fa-regular fa-eye"></i></span></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="">
                                                        <a href="/course/batch/${respond['categorys'][i].id}" class="btn btn-danger btn-sm p-1 px-2 text-white rounded-pill" style="font-size:13px;"><span  class="p-1 text-white">${respond['categorys'][i].total_batch_count}</span> | <span class="text-white" href=""><i  class="fa-regular fa-eye"></i></span></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input statusChecked" type="checkbox" role="switch" id="checkBox" data-id="${respond['categorys'][i].id}" ${respond['categorys'][i].status == 1 ? "checked": ""}>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span>
                                                        <a href="/category/edit/${respond['categorys'][i].id}" class="me-4" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a>
                                                        <a type="button" data-id="${respond['categorys'][i].id}" class="delete_btn mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2"  data-bs-toggle="tooltip" data-placement="top" title="btn-close"><i class="fa-solid fa-xmark text-danger"></i></a>
                                                    </span>
                                                </td>
                                            </tr> `;
                            }
                            $("#cat_table").html($htmlView);
                    }else{
                        $("#cat_table").html("<tr><td colspan='7'><div class='justify-content-center d-flex align-items-center'><span class='w-space-no fs-3 text-primary'>No Record Found</span></div></td></tr><tr></tr>");
                    }
                }
            });
        });
    });

    $(document).ready(function(){
        $('#deactiveRecord').on('click',function Deactivebatch(e){ 
            $(this).addClass("btn-primary");
            $('#activeRecord').removeClass("btn-primary");
            $('#search_status').val(0);
            $.ajax({
                url:'{{ url("/view-deactive-category")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}'},
                dataType:'json',
                success:function(respond){
                    $y =1;
                    $htmlView = "";
                    if(respond['categorys'].length > 0){
                            for(let i = 0; i < respond['categorys'].length; i++){
                                $htmlView += `<tr>
                                                <td>${$y++}</td>
                                                <td>${respond['categorys'][i].title}</td>
                                                <td title="${respond['categorys'][i].description}">${respond['categorys'][i].description.slice(0, 40)} [....]</td>
                                                <td>
                                                    <div class="">
                                                        <a href="/course-subject/${respond['categorys'][i].id}" class="btn btn-success btn-sm  p-1 px-2 text-white rounded-pill" style="font-size:13px;"><span class="p-1 text-white">${respond['categorys'][i].total_subject_count}</span>
                                                        | <span class="text-white"><i  class="fa-regular fa-eye"></i></span></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="">
                                                        <a href="/course/batch/${respond['categorys'][i].id}" class="btn btn-danger btn-sm p-1 px-2 text-white rounded-pill" style="font-size:13px;"><span class="p-1 text-white">${respond['categorys'][i].total_batch_count}</span> | <span class="text-white" ><i  class="fa-regular fa-eye"></i></span></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input statusChecked" type="checkbox" role="switch" id="checkBox" data-id="${respond['categorys'][i].id}" ${respond['categorys'][i].status == 1 ? "checked": ""}>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span>
                                                        <a href="/category/edit/${respond['categorys'][i].id}" class="me-4" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a>
                                                        <a type="button" data-id="${respond['categorys'][i].id}" class="delete_btn mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2"  data-bs-toggle="tooltip" data-placement="top" title="btn-close"><i class="fa-solid fa-xmark text-danger"></i></a>
                                                    </span>
                                                </td>
                                            </tr> `;
                            }
                            $("#cat_table").html($htmlView);
                    }else{
                        $("#cat_table").html("<tr><td colspan='7'><div class='justify-content-center d-flex align-items-center'><span class='w-space-no fs-3 text-primary'>No Record Found</span></div></td></tr><tr></tr>");
                    }
                }
            });
        });
    });

</script>
@endsection