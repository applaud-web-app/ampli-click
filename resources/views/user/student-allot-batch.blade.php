@extends('layouts.master')
@section('title','Batch Allot')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @include('message')
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card profile-card card-bx">
                    <div class="card-header">
                        <h6 class="card-title">Allot Batch to Learner</h6>
                    </div>
                    <form action="/alloted-batch-student" method="POST" class="profile-form">
                        @csrf
                        <div class="card-body">
                            @error('subjectId') <span class="text-danger">{{$message}}</span>  @enderror
                            <div class="row align-items-center">
                                <div class="col-sm-6 m-b30">
                                    <label class="form-label">Select Course<span class="text-danger">*</span></label>
                                    <select name="course" id="course" class="form-control">
                                        <option value="" selected disabled>Choose a Course</option>
                                        @foreach ($courses as $course)
                                            <option value="{{$course->id}}">{{$course->title}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="sid" value="{{$studentID}}">
                                    <span class="text-danger"> @error('batch')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>                                 
                                </div>
                                <div class="col-sm-6 m-b30" >
                                    <label class="form-label">Select Batch<span class="text-danger">*</span></label>
                                    <select name="batch" id="courseBatch" class="form-control">
                                        <option value="" selected>Please Select A Course First</option>
                                    </select>
                                </div>
                                <div id="subjectBox">
                                </div>
                                <div class="col-sm-12 mt-2 d-flex justify-content-end" id="allot_btn">
                                </div>
                            </div>
                        </div>
                    </form>
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

    $(document).ready(function(){
        $('#course').on('change',function(e){ 
            $value = $(this).val();
            console.log($value);
            $.ajax({
                url:'{{ url("/fetch-batch-course")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}', course: $value,studentId:{{$studentID}}},
                dataType:'json',
                success:function(respond){
                    $y =1;
                    $htmlView = "";
                    if(respond['batch'].length > 0){
                    $htmlView += '<option value="">Select A Batch</option>';
                            for(let i = 0; i < respond['batch'].length; i++){
                                $htmlView += `<option value="${respond['batch'][i].id}">${respond['batch'][i].name}</option>`;
                            }
                            $("#courseBatch").html($htmlView);
                    }else{
                        $("#courseBatch").html(`<label class="form-label">Select Course<span class="text-danger">*</span></label>
                                    <select name="course" id="course" class="form-control">
                                        <option value="" selected >This Course Doesn't Have Any Batch Yet</option>
                                    </select>`);
                    }
                    $("#subjectBox").html("");
                }
            });
        });
    });

    $(document).ready(function(){
        $('#courseBatch').on('change',function(e){ 
            $value = $('#course').val();
            $batch = $(this).val();
            $.ajax({
                url:'{{ url("/fetch-batch-subject")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}',batch:$batch, course: $value,studentId:{{$studentID}}},
                dataType:'json',
                success:function(respond){
                    $y =1;
                    $html = "";
                    if(respond['subject'].length > 0){
                        $html = "<h4 class='mt-3 mb-2'>Select Course</h3>";
                        for(let i = 0; i < respond['subject'].length; i++){
                            $html += `<div class="col-2 text-center p-2 rounded-pill badge badge-outline-primary m-1">
                                                    <input type="checkbox" class="checkSubject" id="allBatch" name="subjectId[]" value="${respond['subject'][i].id}" checked="">
                                                    <label for="allBatch" class="mb-0" id="${respond['subject'][i].id}">${respond['subject'][i].sub_name}</label>
                                                </div>`;
                        }
                        $("#subjectBox").html($html);
                        $("#allot_btn").html(`<button class="btn btn-primary">Allot</button>`);
                    }else{
                        $('#subjectBox').html('<span class="text-center text-danger">This Course Does Not Have Any Subject To Allot!!</span>');
                    }
                }
            });
        });
    });
</script>
@endsection