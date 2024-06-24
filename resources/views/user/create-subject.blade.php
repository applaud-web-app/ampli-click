@extends('layouts.master')
@section('title','Add Subject')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="container-fluid">
            @include('message')
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Add Subject</h5>
                        </div>
                        <div class="card-body">
                            <form action="/create-subject" enctype="multipart/form-data" method="post">
                                @csrf
                                <div class="row">
                                    <div class="row">
                                        <div class="col-xl-4 col-sm-6 mb-3">
                                            <label for="SubjectId" class="form-label">Subject Name<span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control" name="name" id="SubjectId"
                                                placeholder="Subject Name">
                                        </div>
                                        <div class="col-sm-4 col-sm-4 mb-3">
                                            <label class="form-label">Select Category<span
                                                    class="required">*</span></label>
                                            <select class="form-control" name="category" id="category" required>
                                                <option selected disabled>Select a Category</option>
                                                @foreach ($categorys as $category)
                                                <option value="{{ $category->id }}">{{$category->title}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger"> @error('category') <div
                                                    class="alert alert-danger">{{ $message }}</div> @enderror</span>
                                        </div>
                                        <div class="col-sm-4 col-sm-4 mb-3">
                                            <label class="form-label">Select Subcategory<span
                                                    class="required">*</span></label>
                                            <select class="form-control" id="subcategory" name="subcategory" required>
                                                <option selected disabled>Select a Category</option>
                                            </select>
                                            <span class="text-danger"> @error('subcategory') <div
                                                    class="alert alert-danger">{{ $message }}</div> @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-6 mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Subject
                                            Description<span class="required">*</span></label>
                                        <textarea class="form-control" name="description"
                                            id="exampleFormControlTextarea1" rows="9"
                                            placeholder="Subject Description"></textarea>
                                    </div>
                                    <div class="mb-3 col-xl-6 col-sm-6">
                                        <label class="form-label">Banner Image<span
                                                class="required">*</span></label>
                                        <div class="avatar-upload">
                                            <div class="avatar-preview">
                                                <img id="blah" width="200px" height="180px"
                                                    src="/images/no-img-avatar.png">
                                            </div>
                                            <div class="change-btn mt-1">
                                                <input type='file' class="form-control d-none" id="imgInp" name="image"
                                                    accept=".png, .jpg, .jpeg">
                                                <label for="imgInp"
                                                    class="dlab-upload mb-0 btn btn-primary btn-sm">Choose File</label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="batch" value="{{$batch}}">
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
    $(document).ready(function() {
        $("#category").change(function() {
            // console.log("change");
            $id = $(this).val();
            $.ajax({
                url: '{{ url("/fetch-subcategory/")}}/' + $id,
                type: 'post',
                data: {
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(respond) {
                    console.log(respond);
                    $("#subcategory").find('option:not(:first)').remove();
                    if (respond['subcategorys'].length > 0) {
                        $.each(respond['subcategorys'], function(key, value) {
                            $("#subcategory").append("<option value=" + value[
                                    'id'] + ">" + value['title'] +
                                "</option>");
                        });
                    } else {
                        $("#subcategory").append(
                            "<option>Not Have Any Subcategory</option>");
                    }
                }
            });
        });
    });
</script>
@endsection