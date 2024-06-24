@extends('layouts.master')
@section('title','All Subcategory')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @include('message') 
        <div class="row justify-content-center">
            <div class="col-xl-12 mt-4">
                <div class="card" id="bootstrap-table9">
                    <div class="card-header flex-wrap d-flex justify-content-between px-3">
                        <div>
                            <h4 class="card-title">All Subcategory</h4>
                        </div>
                        <div class="ms-auto d-flex align-items-center">
                            <label class="d-flex align-items-center mb-0"><input type="search" class="ms-2 form-control " placeholder="Search" id="search_subcat" name="search_subcat" aria-controls="example"></label>
                            <a href="/subcategory" type="button" class="ms-3 btn btn-outline-primary btn-sm">Create Subcategory</a>
                        </div>
                    </div>
                    <div class="tab-content" id="myTabContent-7">
                        <div class="tab-pane fade show active" id="solidbackground" role="tabpanel" aria-labelledby="home-tab-7">	
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th scope="col">SNo.</th>
                                                <th scope="col">Parent Category</th>
                                                <th scope="col">Sub-Category</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sub_table">
                                            <?php $i = $categorys->firstItem() ?>
                                            @foreach ($categorys as $Category)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$Category->parentCat}}</td>
                                                <td>{{$Category->title}}</td>
                                                
                                                <td title="{{$Category->description}}">{{substr($Category->description,0,77)}} [....]</td>
                                                <td><span class="badge {{$Category->status != 0 ? "badge-success":"badge-warning"}}">{{$Category->status != 0 ? "Active":"Pending"}}</span></td>
                                                <td>
                                                    <span>
                                                        <a href="{{ route('edit.subcategory', ['id' => $Category->id]) }}" class="me-4" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a>
                                                        <a href="{{ route('delete.subcategory', ['id' => $Category->id]) }}" onclick="return confirm('Are you sure want to delete this?');"  data-bs-toggle="tooltip" data-placement="top" title="btn-close"><i class="fa-solid fa-xmark text-danger"></i></a>
                                                    </span>
                                                </td>
                                            </tr>                                                
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        {{$categorys->links()}}
                    </div>
                </div>
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
        $('#search_subcat').on('input',function(e){ 
            $value = $(this).val();

            $.ajax({
                url:'{{ url("/search-subcategory")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}', search: $value },
                dataType:'json',
                success:function(respond){
                    console.log(respond);
                    $y =1;
                    $htmlView = "";
                    if(respond['category'].length > 0){
                            for(let i = 0; i < respond['category'].length; i++){
                                $htmlView += `<tr>
                                                <td>${$y++}</td>
                                                <td>${respond['category'][i].parentCat}</td>
                                                <td>${respond['category'][i].title}</td>
                                                
                                                <td title="${respond['category'][i].description}">${respond['category'][i].description.slice(0, 70)} [....]</td>
                                                <td><span class="badge ${respond['category'][i].status != 0 ? "badge-success":"badge-warning" }">${respond['category'][i].status != 0 ? "Active":"Pending" }</span></td>
                                                <td>
                                                    <span>
                                                        <a href="/subcategory/edit/${respond['category'][i].id}" class="me-4" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a>
                                                        <a href="/subcategory/delete/${respond['category'][i].id}" onclick="return confirm('Are you sure want to delete this?');"  data-bs-toggle="tooltip" data-placement="top" title="btn-close"><i class="fa-solid fa-xmark text-danger"></i></a>
                                                    </span>
                                                </td>
                                            </tr>`;
                            }
                            $("#sub_table").html($htmlView);
                    }else{
                        $("#sub_table").html("<tr><td colspan='7'><div class='justify-content-center d-flex align-items-center'><span class='w-space-no fs-3 text-primary'>No Record Found</span></div></td></tr><tr></tr>");
                    }
                }
            });
        });
    });
</script>
@endsection