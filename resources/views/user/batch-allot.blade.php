@extends('layouts.master')
@section('title','Allot Batch')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @include('message')
        <!-- row -->
        <div class="button-group mb-1 d-flex justify-content-between">
            <a href="{{url()->previous()}}" onclick="window.history.go(-1); return false;" class="ms-2 btn btn-danger btn-xs"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
            <a href="/add-student" type="submit" class="btn btn-primary btn-xs"><i class="fa-regular fa-user ms-1"></i> Add Learner</a>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-10">
                <div class="card profile-card card-bx">
                    <div  id="bootstrap-table2">
                        <form action="/allot-subject-student" method="POST">
                            @csrf
                            <input type="hidden" name="bid" value="{{$BatchId}}">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">{{ucfirst($courseId->name)}} <i class="fa-solid fa-arrow-right-long"></i> Learners</h5>
                                <div>
                                    <button type="submit" class="btn btn-success btn-sm">Allot Batch To Learner</button>
                                </div>
                            </div>
                            <div class="card-body">
                               
                                    <div>
                                        @error('allotCourse')
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Error!!</strong> {{$message}}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
                                        </div>
                                        @enderror
                                        @error('subjectId')
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Error!!</strong> {{$message}}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
                                        </div>
                                        @enderror
                                    </div>
                                    <div  >
                                        <span id="error"></span>
                                        <div class="subjects mb-2">
                                            <div class="row px-3">
                                                @foreach ($subjects as $subject)
                                                    <div class="col-xl-2 col-lg-2 col-md-3 col-6 mb-2 me-2 bg-light py-2 ">
                                                        <div class="d-flex align-items-center form-check custom-checkbox   ">
                                                            <input type="checkbox" class="form-check-input checkSubject" value="{{$subject->id}}" id="allBatch" name="subjectId[]" id="customCheckBox1" checked>
                                                            <label class="form-check-label mb-0 text-primary" for="customCheckBox1" style="margin-top:7px;">{{$subject->sub_name}}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                                                                    
                           
                                <div class="col-xl-12 " >
                                    <div class="table-responsive full-data">
                                        <table class=" table display dataTablesCard student-tab dataTable no-footer">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <div
                                                            class="form-check custom-checkbox me-3">
                                                            <input type="checkbox" name="allotCourse"
                                                                class="form-check-input" id="checkAll">
                                                            <label class="form-check-label" for="checkAll"></label>
                                                        </div>
                                                    </th>
                                                    <th>SNo.</th>
                                                    <th>Name</th>
                                                    <th>Username</th>
                                                    <th>Parent Name</th>
                                                    <th>Mobile</th>
                                                    <th>City</th>
                                                </tr>
                                            </thead>
                                            <tbody id="student_table">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
     $(document).ready(function(){
        $(document).on('change','.checkSubject', function allotBatch(){
            $SubjectId = [];
            $('.checkSubject').each(function( index ) {
                if(this.checked === true){
                    $SubjectId.push($(this).val());
                }
            });

           if($SubjectId.length > 0){
                $.ajax({
                    url:'{{ url("/fetch-student-details")}}',
                    type:'post',
                    data: { _token: '{{csrf_token()}}', sids: $SubjectId},
                    dataType:'json',
                    success:function(respond){
                        console.log(respond);
                        $y = 1;
                        $htmlView = "";
                        if (respond['students'].length > 0) {
                            for (let i = 0; i < respond['students'].length; i++) {
                                $htmlView += `<tr>
                                                <td>
                                                    <div
                                                        class="form-check custom-checkbox checkbox-success check-lg me-3">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="allotCourse[]" value="${respond['students'][i].id}"
                                                            id="checkAll">
                                                        <label class="form-check-label" for="checkAll"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0">${$y++}</h6>
                                                </td>
                                                <td>
                                                    <div class="trans-list">
                                                        <img src="/upload/student/${respond['students'][i].image}" alt=""
                                                            class="avatar me-3">
                                                        <h4>${respond['students'][i].fname} ${respond['students'][i].lname}</h4>
                                                    </div>
                                                </td>
                                                <td><span
                                                        class="text-primary font-w600">${respond['students'][i].username}</span>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0">${respond['students'][i].parent_first}
                                                        ${respond['students'][i].parent_last}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0">${respond['students'][i].mobile}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0">${respond['students'][i].city}</h6>
                                                </td>
                                            </tr>`;
                            }
                            $("#student_table").html($htmlView);
                        } else {
                            $("#student_table").html(
                                "<tr><td colspan='7'><div class='justify-content-center d-flex align-items-center'><span class='w-space-no fs-3 text-primary'>No Record Found</span></div></td></tr><tr></tr>"
                            );
                        }
                    }
                });

           }else{
               $('#error').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h1 class="text-danger mb-0"><i class="fa-solid fa-triangle-exclamation"></i></h1>
                    <strong>Error!!</strong> Please Select a Subject</div>`);
                // setTimeout(function(){
                    $('#error').html("").fadeIn("slow");
                // }, 2000);
           }

        });
    });

    $(document).ready(function(){
        // $(document).on('change','.checkSubject', function allotBatch(){
            $SubjectId = [];
            $('.checkSubject').each(function( index ) {
                if(this.checked === true){
                    $SubjectId.push($(this).val());
                }
            });

           if($SubjectId.length > 0){
                $.ajax({
                    url:'{{ url("/fetch-student-details")}}',
                    type:'post',
                    data: { _token: '{{csrf_token()}}', sids: $SubjectId},
                    dataType:'json',
                    success:function(respond){
                        console.log(respond);
                        $y = 1;
                        $htmlView = "";
                        if (respond['students'].length > 0) {
                            for (let i = 0; i < respond['students'].length; i++) {
                                $htmlView += `<tr>
                                                <td>
                                                    <div
                                                        class="form-check custom-checkbox  me-3">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="allotCourse[]" value="${respond['students'][i].id}"
                                                            id="checkAll">
                                                        <label class="form-check-label" for="checkAll"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0">${$y++}</h6>
                                                </td>
                                                <td>
                                                    <div class="trans-list">
                                                        <img src="/upload/student/${respond['students'][i].image}" alt=""
                                                            class="avatar me-3">
                                                        <h4>${respond['students'][i].fname} ${respond['students'][i].lname}</h4>
                                                    </div>
                                                </td>
                                                <td><span
                                                        class="text-primary font-w600">${respond['students'][i].username}</span>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0">${respond['students'][i].parent_first}
                                                        ${respond['students'][i].parent_last}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0">${respond['students'][i].mobile}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0">${respond['students'][i].city}</h6>
                                                </td>
                                            </tr>`;
                            }
                            $("#student_table").html($htmlView);
                        } else {
                            $("#student_table").html(
                                "<tr><td colspan='7'><div class='justify-content-center d-flex align-items-center'><span class='w-space-no fs-3 text-primary'>No Record Found</span></div></td></tr><tr></tr>"
                            );
                        }
                    }
                });

           }else{
               $('#error').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h1 class="text-danger mb-0"><i class="fa-solid fa-triangle-exclamation"></i></h1>
                    <strong>Error!!</strong> Please Select a Subject</div>`);
                // setTimeout(function(){
                    $('#error').html("").fadeIn("slow");
                // }, 2000);
           }

        // });
    });
</script>

@endsection