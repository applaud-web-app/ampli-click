@extends('layouts.master')
@section('title','All Learners')
@section('content')
<div class="content-body">
  <!-- row -->
  <div class="container-fluid">
    @include('message')
    <div class="button-group mb-1 d-flex justify-content-between">
      <a href="{{url()->previous()}}" onclick="window.history.go(-1); return false;"
        class="ms-2 btn btn-danger btn-xs"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
      <a href="/view-category" type="submit" class="btn btn-dark btn-xs"> View Courses</a>
    </div>
    <!-- Row -->
    <div class="row">
      <div class="col-xl-12">
        <div class="card h-auto">
          <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap">
              <div class="input-group search-area mb-md-0 mb-3">
                <input type="text" class="form-control" placeholder="Search" id="search_student" name="search_student">
              </div>
              <div class="d-flex align-items-center col-lg-4">
                <select class="me-sm-2 form-control " name="filter_status" id="filter_status"
                  tabindex="null">
                  <option value="1" selected="">Approved</option>
                  @if (Auth::user()->u_role == 1)
                  <option value="0" @if(\Request::get('unapproved')) {{"selected"}} @endif>Unapproved</option>
                  <option value="2">Disable</option>
                  @endif
                </select>
                @if (Auth::user()->u_role == 1)
                <a href="/add-student" class="btn btn-primary w-100">+ New Learner</a>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

        <!--column-->
        <div class="col-xl-12 " >
          <div class="card h-auto">
              <div class="card-body p-3">
                <div class="table-responsive full-data">
                  <table class=" table display dataTablesCard student-tab dataTable ">
                    <thead>
                      <tr>
                        <th>SNo.</th>
                        <th>Name</th>
                        <th>Username</th>
                        {{-- <th>Parent Name</th>
                        <th>Mobile</th> --}}
                        {{-- <th>City</th> --}}
                        <th>Status</th>
                        @if (Auth::user()->u_role == 1)
                        <th>Allot Course</th>
                        <th >Action</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody id="student_table">
                      <?php $j = $students->firstItem() ?>
                      @foreach ($students as $student)
                      <tr>
                        <td>
                          <h6 class="mb-0">{{$j++}}</h6>
                        </td>
                        <td>
                          <div class="trans-list">
                            <img src="upload/student/{{$student->image}}" alt="" class="avatar me-3">
                            <h4 class="d-flex">{{$student->fname}} {{$student->lname}} <a
                                href="{{ route('edit.student', ['id' => $student->id]) }}" class="ms-1 text-primary"><i
                                  class="fa fa-pencil"></i></a></h4>
                          </div>
                        </td>
                        <td><span class="text-primary font-w600">{{$student->username}}</span></td>
                        {{-- <td>
                          <h6 class="mb-0">{{$student->parent_first}} {{$student->parent_last}}</h6>
                        </td>
                        <td>
                          <h6 class="mb-0">{{$student->mobile}}</h6>
                        </td>
                        <td>
                          <h6 class="mb-0">{{$student->city}}</h6>
                        </td> --}}
      
                        <td>
                          <select data-id="{{$student->id}}" class="change_status badge badge-xs {{$student->status == 1 ? "
                            bg-success" : ($student->status == 0 ? "bg-danger" : "bg-light text-dark")}} py-2">
                            <option class="bg-light text-dark" value="1" {{$student->status == 1 ? "selected" : ""}}>Approved
                            </option>
                            
                            @if (Auth::user()->u_role == 1)
                            <option class="bg-light text-dark" value="0" {{$student->status == 0 ? "selected" :
                              ""}}>Unapproved</option>
                            <option class="bg-light text-dark" value="2" {{$student->status == 2 ? "selected" : ""}}>Disable
                            </option>
                            @endif
                          </select>
                        </td>
                        @if (Auth::user()->u_role == 1)
                        <td>
                          <div class="d-flex ">
                            <a href="/alloted-batch-student/{{$student->id}}" class="btn btn-danger shadow btn-xs me-1"><i
                                class="fa-solid fa-link"></i> Allot</a>
                          </div>
                        </td>
                        <td>
                          <div class="d-flex ">
                            <button type="button" class="modalDevice btn btn-dark shadow btn-xs me-1" data-bs-toggle="modal"
                            data-bs-target="#loginDevice" title="Login Device" data-id="{{$student->id}}"> Login Device</button>

                            <button type="button" class="modalpass btn btn-info shadow btn-xs me-1" data-bs-toggle="modal"
                              data-bs-target="#exampleModalCenter2" title="Update Pass" data-id="{{$student->id}}"><i
                                class="fa-solid fa-lock"></i> Update Password</button>
                          </div>
                        </td>
                        @endif
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="table-pagenation teach justify-content-center ">
                  <nav>
                    <ul class="pagination pagination-gutter pagination-primary no-bg">
                      {{$students->links()}}
                    </ul>
                  </nav>
                </div>
              </div>
          </div>
         
        </div>
       
       
    
    </div>

    {{-- Model Start --}}
    <div class="modal fade" id="exampleModalCenter2">
      <div class="modal-dialog modal-sm">
        <div class="modal-content" id="modalbody">
        </div>
      </div>
    </div>
    {{-- Model End --}}


     {{-- Device Model Start --}}
     <div class="modal fade" id="loginDevice">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Device Info</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0"  id="deviceDetails">
              <div class="d-flex justify-content-center align-items-center p-3">
                <div class="spinner-border text-danger" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
    {{-- Model End --}}

    <!--**********************************
Footer start
***********************************-->
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(document).ready(function () {
    $('#search_student').on('input', function (e) {
      $value = $(this).val();
      $status = $("#filter_status option:selected").val()
      $.ajax({
        url: '{{ url("/search-student")}}',
        type: 'post',
        data: { _token: '{{csrf_token()}}', search: $value, status: $status },
        dataType: 'json',
        success: function (respond) {
          console.log(respond);
          $y = 1;
          // $("#batch_table").remove();
          $htmlView = "";
          if (respond['students'].length > 0) {
            for (let i = 0; i < respond['students'].length; i++) {
              $htmlView += `<tr>
                                  <td><h6 class="mb-0">${$y++}</h6></td>
                                  <td>
                                    <div class="trans-list">
                                      <img src="upload/student/${respond['students'][i].image}" alt="" class="avatar me-3">
                                      <h4 class="d-flex">${respond['students'][i].fname} ${respond['students'][i].lname} <a href="/student/edit/${respond['students'][i].id}" class="ms-1 text-primary"><i class="fa fa-pencil"></i></a></h4>
                                    </div>
                                  </td>
                                  <td><span class="text-primary font-w600">${respond['students'][i].username}</span></td>
                                  <td>
                                    <select data-id="${respond['students'][i].id}"  class="py-2 change_status badge badge-xs ${respond['students'][i].status == 1 ? "bg-success" : (respond['students'][i].status == 0 ? "bg-danger" : "bg-light text-dark")}"">
                                      <option class="bg-light text-dark" value="1" ${respond['students'][i].status == 1 ? "selected" : ""}>Approved</option>
                                      @if (Auth::user()->u_role == 1)
                                      <option class="bg-light text-dark" value="0" ${respond['students'][i].status == 0 ? "selected" : ""}>Unapproved</option>
                                      <option class="bg-light text-dark" value="2" ${respond['students'][i].status == 2 ? "selected" : ""}>Disable</option>
                                      @endif
                                    </select>
                                  </td>
                                  @if (Auth::user()->u_role == 1)
                                  <td>
                                    <div class="">
                                      <a href="/alloted-batch-student/${respond['students'][i].id}" class="btn btn-danger shadow btn-xs me-1"><i class="fa-solid fa-link"></i> Allot</a>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="">
                                       <button type="button" class="modalDevice btn btn-dark shadow btn-xs me-1" data-bs-toggle="modal"
                                      data-bs-target="#loginDevice" title="Login Device" data-id="${respond['students'][i].id}"> Login Device</button>

                                      <button type="button" class="modalpass btn btn-info shadow btn-xs me-1" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2" title="Update Pass" data-id="${respond['students'][i].id}"><i class="fa-solid fa-lock"></i> Update Password</button>
                                    </div>
                                  </td>
                                  @endif
                                </tr>`;
            }
            $("#student_table").html($htmlView);
          } else {
            $("#student_table").html("<tr><td colspan='7'><div class='justify-content-center d-flex align-items-center'><span class='w-space-no fs-3 text-primary'>No Record Found</span></div></td></tr><tr></tr>");
          }
        }
      });
    });
  });

  // Filter Student by status
  $(document).ready(function () {
    $('#filter_status').on('change', function (e) {
      $value = $(this).val();

      $.ajax({
        url: '{{ url("/filter-student")}}',
        type: 'post',
        data: { _token: '{{csrf_token()}}', filter_status: $value },
        dataType: 'json',
        success: function (respond) {
          $y = 1;
          $htmlView = "";
          if (respond['students'].length > 0) {
            for (let i = 0; i < respond['students'].length; i++) {
              $htmlView += `<tr>
                                  <td><h6 class="mb-0">${$y++}</h6></td>
                                  <td>
                                    <div class="trans-list">
                                      <img src="upload/student/${respond['students'][i].image}" alt="" class="avatar me-3">
                                      <h4>${respond['students'][i].fname} ${respond['students'][i].lname} <a href="/student/edit/${respond['students'][i].id}" class="ms-1 text-primary"><i class="fa fa-pencil"></i></a></h4>
                                    </div>
                                  </td>
                                  <td><span class="text-primary font-w600">${respond['students'][i].username}</span></td>
                                  <td>
                                    <select data-id="${respond['students'][i].id}" class="py-2 change_status badge badge-xs ${respond['students'][i].status == 1 ? "bg-success" : (respond['students'][i].status == 0 ? "bg-danger" : "bg-light text-dark")}"">
                                      <option class="bg-light text-dark" value="1" ${respond['students'][i].status == 1 ? "selected" : ""}>Approved</option>
                                      <option class="bg-light text-dark" value="0" ${respond['students'][i].status == 0 ? "selected" : ""}>Unapproved</option>
                                      <option class="bg-light text-dark" value="2" ${respond['students'][i].status == 2 ? "selected" : ""}>Disable</option>
                                    </select>
                                    @if (Auth::user()->u_role == 1)
                                  <td>
                                    <div class="">
                                      <a href="/alloted-batch-student/${respond['students'][i].id}" class="btn btn-danger shadow btn-xs me-1"><i class="fa-solid fa-link"></i> Allot</a>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="">
                                      <button type="button" class="modalDevice btn btn-dark shadow btn-xs me-1" data-bs-toggle="modal"
                                      data-bs-target="#loginDevice" title="Login Device" data-id="${respond['students'][i].id}"> Login Device</button>

                                      <button type="button" class="modalpass btn btn-info shadow btn-xs me-1" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2" title="Update Pass" data-id="${respond['students'][i].id}"><i class="fa-solid fa-lock"></i> Update Password</button>
                                    </div>
                                  </td>
                                  @endif
                                </tr>`;
            }
            $("#student_table").html($htmlView);
          } else {
            $("#student_table").html("<tr><td colspan='7'><div class='justify-content-center d-flex align-items-center'><span class='w-space-no fs-3 text-primary'>No Record Found</span></div></td></tr><tr></tr>");
          }
        }
      });
    });
  });

  $(document).ready(function () {
    // $('.change_status').on('change',function(e){
    $(document).on('change', '.change_status', function () {
      $status = $(this).val();
      $std_id = $(this).data('id');

      $.ajax({
        url: '{{ url("/update-student-status")}}',
        type: 'post',
        data: { _token: '{{csrf_token()}}', status: $status, student_id: $std_id },
        dataType: 'json',
        success: function (respond) {
          $y = 1;
          $htmlView = "";
          if (respond['students'].length > 0) {
            for (let i = 0; i < respond['students'].length; i++) {
              $htmlView += `<tr>
                                  <td><h6 class="mb-0">${$y++}</h6></td>
                                  <td>
                                    <div class="trans-list">
                                      <img src="upload/student/${respond['students'][i].image}" alt="" class="avatar me-3">
                                      <h4>${respond['students'][i].fname} ${respond['students'][i].lname} <a href="/student/edit/${respond['students'][i].id}" class="ms-1 text-primary"><i class="fa fa-pencil"></i></a></h4>
                                    </div>
                                  </td>
                                  <td><span class="text-primary font-w600">${respond['students'][i].username}</span></td>
                                  <td>
                                    <select data-id="${respond['students'][i].id}" class="py-2 change_status badge badge-xs ${respond['students'][i].status == 1 ? "bg-success" : (respond['students'][i].status == 0 ? "bg-danger" : "bg-light text-dark")}" ">
                                      <option class="bg-light text-dark" value="1" ${respond['students'][i].status == 1 ? "selected" : ""}>Approved</option>
                                      <option class="bg-light text-dark" value="0" ${respond['students'][i].status == 0 ? "selected" : ""}>Unapproved</option>
                                      <option class="bg-light text-dark" value="2" ${respond['students'][i].status == 2 ? "selected" : ""}>Disable</option>
                                    </select>
                                    @if (Auth::user()->u_role == 1)
                                    <td>
                                      <div class="">
                                        <a href="/alloted-batch-student/${respond['students'][i].id}" class="btn btn-danger shadow btn-xs me-1"><i class="fa-solid fa-link"></i> Allot</a>
                                      </div>
                                    </td>
                                    <td>
                                      <div class="">
                                        <button type="button" class="modalDevice btn btn-dark shadow btn-xs me-1" data-bs-toggle="modal"
                                      data-bs-target="#loginDevice" title="Login Device" data-id="${respond['students'][i].id}"> Login Device</button>

                                        <button type="button" class="modalpass btn btn-info shadow btn-xs me-1" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2" title="Update Pass" data-id="${respond['students'][i].id}"><i class="fa-solid fa-lock"></i> Update Password</button>
                                      </div>
                                    </td>
                                    @endif
                                </tr>`;
            }
            $("#student_table").html($htmlView);
            $("#filter_status").val($status == 1 ? 0 : 1).attr('selected', 'selected');
            $('#filter_status').change();
          } else {
            $("#student_table").html("<tr><td colspan='7'><div class='justify-content-center d-flex align-items-center'><span class='w-space-no fs-3 text-primary'>No Record Found</span></div></td></tr><tr></tr>");
          }
        }
      });
    })
  })
</script>

<script>
  // Update student Password
  $(document).ready(function () {
    $(document).on('click', '.modalpass', function () {
      $id = $(this).data('id');
      console.log($id);

      $.ajax({
        url: '{{ url("/fetch-student-data/")}}/' + $id,
        type: 'post',
        data: { _token: '{{csrf_token()}}' },
        dataType: 'json',
        success: function (respond) {
          console.log(respond);
          if (respond['students'].length > 0) {
            $("#modalbody").html(
              `<form action="/update-student-pass" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">${respond['students'][0].fname} ${respond['students'][0].lname}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col-sm-12 m-b30">
                                        <label class="form-label">Update Password<span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="updatepassword" placeholder="Update Password" required="">
                                        <input type="hidden"  name="sid" value="${respond['students'][0].id}">
                                        <span class="text-danger"> @error('updatepassword')  <div class="alert alert-danger">{{ $message }}</div> @enderror</span>  
                                                                 
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                            </div>
                           </form>`);
          } else {
            $("#modalbody").append("<span class='text-danger'>Error!! Please Try Again Later</span>");
          }
        }
      });
    });
  });
</script>
<script>
  // User login Device
  $(document).ready(function () {
    $(document).on('click', '.modalDevice', function () {
      $id = $(this).data('id');
      $("#deviceDetails").html(`<div class="d-flex justify-content-center align-items-center p-3">
                <div class="spinner-border text-danger" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>`);
      $.ajax({
        url: '{{ url("/fetch-user-login-details/")}}/' + $id,
        type: 'post',
        data: { _token: '{{csrf_token()}}' },
        dataType: 'json',
        success: function (respond) {
          console.log(respond);
          let data = `<div class="table-responsive">
                      <table class=" table dataTable display verticle-middle ">
                        <thead>
                            <tr>
                                <th>S No.</th>
                                <th>IP Address</th>
                                <th>Device</th>
                                <th>Browser</th>
                                <th>Last Activity</th>
                                <th>Action</th>
                            </tr>
                        </thead>`;
          if(respond['status']){
            for (let index = 0; index < respond['deviceData'].length; index++) {
              data += `<tbody>
                        <tr>
                            <td>${index+1}</td>
                            <td>${respond['deviceData'][index]['ip_address']}</td>
                            <td>${respond['deviceData'][index]['device']}</td>
                            <td>${respond['deviceData'][index]['browser']}, ${respond['deviceData'][index]['os']}</td>
                            <td>${respond['deviceData'][index]['last_activity']}</td>
                            <td><a href="{{url('/')}}/logout-device/${respond['deviceData'][index]['id']}" class="btn btn-sm btn-danger">Logout</a></td>
                        </tr>
                      </tbody>`;           
              }
            data += `</table></div>`;
            $("#deviceDetails").html(data);
          }else{
            $("#deviceDetails").html(`<div class='d-flex justify-content-center align-items-center py-3'>
              <h5>No Active Device Found</h5></div>`);
          }
        }
      });
    });
  });
</script>
<?php
if(\Request::get('unapproved') == 1){
?>
  <script>
  $(document).ready(function(){
    $('#filter_status').change();
  })
</script>
<?php } ?>
@endsection