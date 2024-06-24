@extends('layouts.master')
@section('title','Update Subject')
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
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Update Subject</h5>
                    </div>
                    <div class="card-body">
                      
                        <form action="/update-subject" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="row align-items-center">
                                <div class="col-xl-9 col-sm-9 mb-3">
                                    <label for="SubjectId" class="form-label">Subject Name<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="name" id="SubjectId" value="{{$subjects->sub_name}}" placeholder="Subject Name">
                                    <input type="hidden" name="sid" value="{{$subjects->id}}">
                                </div> 
                                <div class="col-sm-3 m-0">
                                    <div class="align-items-center d-flex">
                                        <div class="input-group">
											<button class="btn btn-primary" type="button">Status</button>
                                            <select class="form-control wide" name="status" tabindex="null">
                                                <option value="1" {{$subjects->status == 1 ? "selected" : ""}}>Active</option>
                                                <option value="0" {{$subjects->status == 0 ? "selected" : ""}}>Pending</option>
                                                <option value="3" {{$subjects->status == 3 ? "selected" : ""}}>Remove</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 col-sm-4 mb-3">
                                        <label class="form-label">Select Category<span class="required">*</span></label>
                                            <select class="form-control" name="category" id="category" required>
                                                <option >Select a Category</option>
                                                @foreach ($categorys as $category)
                                                    <option value="{{ $category->id }}" {{$subjects->categories_id == $category->id ? "selected" : ""}}>{{$category->title}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger"> @error('category')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span> 
                                    </div>
                                    <div class="col-sm-4 col-sm-4 mb-3">
                                        <label class="form-label">Select Subcategory<span class="required">*</span></label>
                                        <select class="form-control" id="subcategory" data-id="{{$subjects->sub_categories_id}}" name="subcategory" required>
                                            <option selected disabled>Select a Subcategory</option>
                                        </select>
                                            <span class="text-danger"> @error('subcategory')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span> 
                                    </div>  
                                    <div class="mb-3 col-xl-4 col-sm-4">
                                        <label class="form-label">Select Batch<span class="required">*</span></label>
                                        <select class="form-control wide" name="batch" required>
                                            <option selected disabled>Select a Batch</option>
                                            @foreach ($batchs as $batch)
                                                <option value="{{ $batch->id }}" {{$subjects->batches_id == $batch->id ? "selected" : ""}}>{{$batch->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger"> @error('batch')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span> 
                                    </div> 
                                </div>
                                <div class="col-xl-6 col-sm-6 mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">Subject Description<span class="required" >*</span></label>
                                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="9" placeholder="Subject Description">{{$subjects->sub_description}}</textarea>
                                </div>
                                <div class="mb-3 col-xl-6 col-sm-6">
                                    <label  class="form-label">Banner Image<span class="required">*</span></label>
                                    <div class="avatar-upload">
                                        <div class="avatar-preview">
                                            <img id="blah" width="200px" height="180px" src="/upload/courses/{{$subjects->sub_image}}"> 			
                                        </div>
                                        <div class="change-btn mt-1">
                                            <input type='file' class="form-control d-none" id="imgInp" name="image" accept=".png, .jpg, .jpeg">
                                            <label for="imgInp" class="dlab-upload mb-0 btn btn-primary btn-sm">Choose File</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-end mt-3">
                                    <button class="btn btn-primary" type="submit">Add Subject</button>
                                </div>
                            </div>                        
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Jquery Cdn -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<script>
    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
    }
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
            $("#category").change(function(){
                // console.log();
                $id = $(this).val();
                $.ajax({
                    url:'{{ url("/fetch-subcategory/")}}/'+$id,
                    type:'post',
                    data: { _token: '{{csrf_token()}}' },
                    dataType:'json',
                    success:function(respond){
                        // console.log(respond);
                        $("#subcategory").find('option:not(:first)').remove();
                        if(respond['subcategorys'].length > 0){
                            $.each(respond['subcategorys'],function(key,value){
                                $("#subcategory").append("<option value="+value['id']+">"+value['title']+"</option>");
                            });
                        }else{
                            $("#subcategory").append("<option>Not Have Any Subcategory</option>");
                        }
                    }
                });
                
                

            })
    })

    $(document).ready(function(){
            // $("#category").change(function(){
                // console.log();
                $id = $("#category").val();
                $sub_id = $("#subcategory").data('id');
                $.ajax({
                    url:'{{ url("/fetch-subcategory/")}}/'+$id,
                    type:'post',
                    data: { _token: '{{csrf_token()}}' },
                    dataType:'json',
                    success:function(respond){
                        // console.log(respond);
                        $("#subcategory").find('option:not(:first)').remove();
                        if(respond['subcategorys'].length > 0){                            
                            $.each(respond['subcategorys'],function(key,value){
                                $ss ="";
                              if($sub_id == value['id']){
                                $ss = "selected";
                              }
                                $("#subcategory").append("<option "+$ss+" value="+value['id']+">"+value['title']+"</option>");
                            });
                        }else{
                            $("#subcategory").append("<option>Not Have Any Subcategory</option>");
                        }
                    }
                });
                
                

            // })
    })

    
</script>
@endsection
