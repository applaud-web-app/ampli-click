@extends('layouts.master')
@section('content')
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('message')
        <!-- Row -->
      
        <div class="row justify-content-center">
            <div class="col-xl-3  col-lg-6 col-sm-6">
                <a href="/students" class="widget-stat card bg-info">
                    <div class="card-body  p-4">
                        <div class="media">
                            <span class="me-3">
                                <i class="la la-users"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1 text-white">Learners</p>
                                <h3 class="text-white">  {{($totalStudent < 10) ? '0' .$totalStudent : $totalStudent}}</h3>
                               
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3  col-lg-6 col-sm-6">
                <a href="/teachers" class="widget-stat card bg-warning">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="me-3">
                                <i class="las la-chalkboard-teacher"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1 text-white">Trainers</p>
                                <h3 class="text-white">{{($totalTeacher < 10) ? '0' .$totalTeacher : $totalTeacher}}</h3>
                               
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3  col-lg-6 col-sm-6">
                <a href="" class="widget-stat card bg-success overflow-hidden">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="me-3">
                                <i class="las la-school"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1 text-white">Courses</p>
                                <h3 class="text-white">{{($totalCourses < 10) ? '0' .$totalCourses : $totalCourses}}</h3>
                               
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3  col-lg-6 col-sm-6">
                <a href="" class="widget-stat card bg-danger ">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="me-3">
                                <i class="las la-calendar"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1 text-white">Admins</p>
                                <h3 class="text-white">{{($totalAdmins < 10) ? '0' .$totalAdmins : $totalAdmins}}</h3>
                              
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-lg-6 col-sm-6">
                <a href="/students" class="widget-stat card bg-dark ">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="me-3">
                                <i class="las la-calendar"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1 text-white">Approved Learners</p>
                                <h3 class="text-white">{{($approvedStudent < 10) ? '0' .$approvedStudent : $approvedStudent}}</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4  col-lg-6 col-sm-6">
                <a href="/students?unapproved=1" id="unapproved" class="widget-stat card bg-secondary ">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="me-3">
                                <i class="las la-calendar"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1 text-white">Unapproved Learners</p>
                                <h3 class="text-white">{{($unapprovedStudent < 10) ? '0' .$unapprovedStudent : $unapprovedStudent}}</h3>
                              
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 wow fadeInUp" data-wow-delay="1.5s">
                <div class="card">
                    <div class="card-header pb-0 border-0 flex-wrap">
                        <div class="d-flex align-items-center justify-content-between mb-3 w-100">
                            <div>
                                <h2 class="heading mb-0">Recently Added Courses</h2>
                            </div>
                            <div>
                                @if (Auth::user()->u_role == 1)
                                <a href="/category" class="icon-box icon-box-sm bg-primary border-0">
                                    <svg width="14" height="14" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5.87826 10.0611H0V5.869H5.87826V0H10.0522V5.869H16V10.0611H10.0522V16H5.87826V10.0611Z"
                                            fill="white" />
                                    </svg>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body    pt-0">
                        <div class="table-responsive full-data">
                            <table
                                class="table-responsive-lg table display dataTablesCard student-tab dataTable ">
                                <thead>
                                    <tr>
                                        <th>SNo.</th>
                                        <th>Course Name</th>
                                        <th>Course Description</th>
                                        <th class="text-center">Subject</th>
                                        <th class="text-center">Batch</th>
                                        @if (Auth::user()->u_role == 1)
                                        <th >Status</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody id="student_table">
                                    @foreach ($Categorys as $Category)
                                    <tr>
                                        <td>{{++$loop->index}}</td>
                                        <td>{{$Category->title}}</td>
                                        <td title="{{$Category->description}}">{{substr($Category->description,0,40)}}
                                            </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <a href="/course-subject/{{$Category->id}}"
                                                    class="btn btn-success btn-sm ms-2 p-1 px-2 text-white rounded-pill"
                                                    style="font-size:13px;"><span
                                                        class="p-1 text-white">{{$Category->total_subject_count}}</span>
                                                    | <span class="text-white"
                                                        href="/course-subject/{{$Category->id}}"><i
                                                            class="fa-regular fa-eye"></i></span></a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <a href="/course/batch/{{$Category->id}}"
                                                    class="btn btn-danger btn-sm ms-2 p-1 px-2 text-white rounded-pill"
                                                    style="font-size:13px;"><span
                                                        class="p-1 text-white">{{$Category->total_batch_count}}</span> |
                                                    <span class="text-white" href=""><i
                                                            class="fa-regular fa-eye"></i></span></a>
                                            </div>
                                        </td>
                                        @if (Auth::user()->u_role == 1)
                                        <td>
                                            <div class="form-check form-switch">
                                                <span class="badge badge-success">Active</span>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 wow fadeInUp" data-wow-delay="1.5s">
                <div class="card">
                    <div class="card-header  border-0 flex-wrap">
                        <div>
                            <h2 class="heading mb-0">Recently Added Learners</h2>
                        </div>
                        @if (Auth::user()->u_role == 1)
                        <a href="/add-student" class="icon-box icon-box-sm bg-primary border-0">
                            <svg width="14" height="14" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.87826 10.0611H0V5.869H5.87826V0H10.0522V5.869H16V10.0611H10.0522V16H5.87826V10.0611Z"
                                    fill="white" />
                            </svg>
                        </a>
                        @endif
                    </div>
                        <div class="card-body pt-0">
                           
                            <div class="table-responsive full-data">
                                <table class="table display dataTablesCard student-tab dataTable ">
                                    <thead>
                                        <tr>
                                            <th>SNo.</th>
                                            <th class="text-start">Name</th>
                                            <th>Username</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="student_table">
                                        @foreach ($recentStudent as $student)
                                        <tr>
                                            <td>
                                                <h6 class="mb-0">{{++$loop->index}}</h6>
                                            </td>
                                            <td>
                                                <div class="trans-list">
                                                    <img src="/upload/student/{{$student->image}}" alt=""
                                                        class="avatar me-3">
                                                    <h4>{{$student->fname}} {{$student->lname}}</h4>
                                                </div>
                                            </td>
                                            <td><span class="text-primary font-w600">{{$student->username}}</span></td>
                                            <td>
                                                <span class="badge badge-success">Active</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                       
                    </div>
                </div>
             
            </div>
            <div class="col-xl-6 wow fadeInUp" data-wow-delay="1.5s">
                <div class="card">
                    <div class="card-header  border-0 flex-wrap">

                        <div>
                            <h2 class="heading mb-0">Recently Added Trainer</h2>
                        </div>
                        @if (Auth::user()->u_role == 1)
                        <a href="/add-teacher" class="icon-box icon-box-sm bg-primary border-0">
                            <svg width="14" height="14" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.87826 10.0611H0V5.869H5.87826V0H10.0522V5.869H16V10.0611H10.0522V16H5.87826V10.0611Z"
                                    fill="white" />
                            </svg>
                        </a>
                        @endif
                    </div>
                        <div class="card-body pt-0">
                           
                              
                                <div class="table-responsive full-data">
                                    <table class="table display dataTablesCard student-tab dataTable ">
                                        <thead>
                                            <tr>
                                                <th>SNo.</th>
                                                <th class="text-start">Name</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="student_table">
                                            @foreach ($recentTeachers as $teachers)
                                            <tr>
                                                <td>
                                                    <h6 class="mb-0">{{++$loop->index}}</h6>
                                                </td>
                                                <td>
                                                    <div class="trans-list">
                                                        <img src="/upload/teachers/{{$teachers->image}}" alt=""
                                                            class="avatar me-3">
                                                        <h4>{{$teachers->teacher_name}}</h4>
                                                    </div>
                                                </td>
                                                <td><span class="text-primary font-w600">{{$teachers->email}}</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-success">Active</span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                          
                      
                    </div>
                   
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 wow fadeInUp" data-wow-delay="1.5s">
                <div class="card">
                    <div class="card-header pb-0 border-0 flex-wrap">
                        
                            <div class="mb-3">
                                <h2 class="heading mb-0">Unapproved Learners</h2>
                            </div>
                        
                    </div>
                    <div class="card-body    pt-0">
                        <div class="table-responsive full-data">
                            <table
                                class="table-responsive-lg table display dataTablesCard student-tab dataTable ">
                                <thead>
                                    <tr>
                                        <th>SNo.</th>
                                        <th class="text-start">Name</th>
                                        <th>Username</th>
                                        <th>Aadhar</th>
                                        <th>Email</th>
                                        <th>Number</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="student_table">
                                    @foreach ($recentUnapprovedStudent as $unapprovedStudent)
                                    <tr>
                                        <td>
                                            <h6 class="mb-0">{{++$loop->index}}</h6>
                                        </td>
                                        <td>
                                            <div class="trans-list">
                                                <img src="/upload/student/{{$unapprovedStudent->image}}" alt=""
                                                    class="avatar me-3">
                                                <h4>{{$unapprovedStudent->fname}} {{$unapprovedStudent->lname}}</h4>
                                            </div>
                                        </td>
                                        <td><span class="text-primary font-w600">{{$unapprovedStudent->username}}</span>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{$unapprovedStudent->aadhar}}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{$unapprovedStudent->email == null ? "----------" :
                                                $unapprovedStudent->email}}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{$unapprovedStudent->mobile}}</h6>
                                        </td>
                                        <td>
                                            <span class="badge badge-danger">Unapproved</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- column-->
    </div>
</div>
@endsection