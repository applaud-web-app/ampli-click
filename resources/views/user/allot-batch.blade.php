@extends('layouts.master')
@section('title','Allot Batch')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @include('message')
        <!-- row -->
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-10">
                {{-- <div class="card profile-card card-bx"> --}}
                <div class="default-tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link  border-0 active text-dark" data-bs-toggle="tab" href="#home"
                                aria-selected="true" role="tab">Batch Learner</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link  border-0 text-dark" data-bs-toggle="tab" href="#profile"
                                aria-selected="false" role="tab" tabindex="-1">Inactive Batch Learner</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link  border-0 text-dark" data-bs-toggle="tab"
                                href="#contact" aria-selected="false" role="tab" tabindex="-1">Add Learners</a>
                        </li>
                    </ul>
                    <div class="card border-0" id="bootstrap-table2">
                        <!-- Nav tabs -->
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="home" role="tabpanel">
                                <form action="/unalloted-student" method="POST">
                                    @csrf
                                    <input type="hidden" name="bId" value="{{$batch_id}}">
                                    <div class="card-header">
                                        <h6 class="card-title">All Batch Learner</h6>
                                        <div>
                                            <button type="submit" class="btn btn-success btn-xs">Unallot Batch</button>
                                            {{-- <a href="/alloted-batch-student/{{$batch_id}}" class="btn btn-success btn-xs ms-2">View Alloted Student</a> --}}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-xl-12 wow fadeInUp" data-wow-delay="1.5s">
                                            @error('unallotedCourse')
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong> {{$message}}</strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close">X</button>
                                            </div>
                                            @enderror
                                            <div class="table-responsive full-data">
                                                <table
                                                    class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <div
                                                                    class="form-check custom-checkbox checkbox-success check-lg me-3">
                                                                    <input type="checkbox" name="unallotedCourse"
                                                                        class="form-check-input" id="checkAll">
                                                                    <label class="form-check-label"
                                                                        for="checkAll"></label>
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
                                                        <?php $j=1; ?>
                                                        @foreach ($Activestudents as $Activestudent)
                                                        <tr>
                                                            <td>
                                                                <div
                                                                    class="form-check custom-checkbox checkbox-success check-lg me-3">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="unallotedCourse[]" value="{{$Activestudent->id}}"
                                                                        id="checkAll">
                                                                    <label class="form-check-label"
                                                                        for="checkAll"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <h6 class="mb-0">{{$j++}}</h6>
                                                            </td>
                                                            <td>
                                                                <div class="trans-list">
                                                                    <img src="/upload/student/{{$Activestudent->image}}"
                                                                        alt="" class="avatar me-3">
                                                                    <h4>{{$Activestudent->fname}} {{$Activestudent->lname}}</h4>
                                                                </div>
                                                            </td>
                                                            <td><span
                                                                    class="text-primary font-w600">{{$Activestudent->username}}</span>
                                                            </td>
                                                            <td>
                                                                <h6 class="mb-0">{{$Activestudent->parent_first}}
                                                                    {{$Activestudent->parent_last}}</h6>
                                                            </td>
                                                            <td>
                                                                <h6 class="mb-0">{{$Activestudent->mobile}}</h6>
                                                            </td>
                                                            <td>
                                                                <h6 class="mb-0">{{$Activestudent->city}}</h6>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel">
                                <form action="/active-Student-batch" method="POST">
                                    @csrf
                                    <input type="hidden" name="bId" value="{{$batch_id}}">
                                    <div class="card-header">
                                        <h6 class="card-title">Inactive Batch Learner</h6>
                                        <div>
                                            <button type="submit" class="btn btn-danger btn-xs">Make Active Member</button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-xl-12 wow fadeInUp" data-wow-delay="1.5s">
                                            @error('unactiveCourse')
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong> {{$message}}</strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close">X</button>
                                            </div>
                                            @enderror
                                            <div class="table-responsive full-data">
                                                <table
                                                    class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <div
                                                                    class="form-check custom-checkbox checkbox-success check-lg me-3">
                                                                    <input type="checkbox" name="unactiveCourse"
                                                                        class="form-check-input" id="checkAll2">
                                                                    <label class="form-check-label"
                                                                        for="checkAll2"></label>
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
                                                        <?php $j=1; ?>
                                                        @foreach ($Inactivestudents as $Inactivestudent)
                                                        <tr>
                                                            <td>
                                                                <div
                                                                    class="form-check custom-checkbox checkbox-success check-lg me-3">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="unactiveCourse[]" value="{{$Inactivestudent->id}}"
                                                                        id="checkAll2">
                                                                    <label class="form-check-label"
                                                                        for="checkAll2"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <h6 class="mb-0">{{$j++}}</h6>
                                                            </td>
                                                            <td>
                                                                <div class="trans-list">
                                                                    <img src="/upload/student/{{$Inactivestudent->image}}"
                                                                        alt="" class="avatar me-3">
                                                                    <h4>{{$Inactivestudent->fname}} {{$Inactivestudent->lname}}</h4>
                                                                </div>
                                                            </td>
                                                            <td><span
                                                                    class="text-primary font-w600">{{$Inactivestudent->username}}</span>
                                                            </td>
                                                            <td>
                                                                <h6 class="mb-0">{{$Inactivestudent->parent_first}}
                                                                    {{$Inactivestudent->parent_last}}</h6>
                                                            </td>
                                                            <td>
                                                                <h6 class="mb-0">{{$Inactivestudent->mobile}}</h6>
                                                            </td>
                                                            <td>
                                                                <h6 class="mb-0">{{$Inactivestudent->city}}</h6>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel">
                                <form action="/allot-batch" method="POST">
                                    @csrf
                                    <input type="hidden" name="bId" value="{{$batch_id}}">
                                    <div class="card-header">
                                        <h6 class="card-title">Add Learner</h6>
                                        <div>
                                            <button type="submit" class="btn btn-primary btn-xs">Allot Batch</button>
                                            {{-- <a href="/alloted-batch-student/{{$batch_id}}" class="btn btn-success btn-xs ms-2">View Alloted Student</a> --}}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-xl-12 wow fadeInUp" data-wow-delay="1.5s">
                                            @error('allotCourse')
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong> {{$message}}</strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close">X</button>
                                            </div>
                                            @enderror
                                            <div class="table-responsive full-data">
                                                <table
                                                    class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <div
                                                                    class="form-check custom-checkbox checkbox-success check-lg me-3">
                                                                    <input type="checkbox" name="allotCourse"
                                                                        class="form-check-input" id="checkAll">
                                                                    <label class="form-check-label"
                                                                        for="checkAll"></label>
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
                                                        <?php $j=1; ?>
                                                        @foreach ($students as $student)
                                                        <tr>
                                                            <td>
                                                                <div
                                                                    class="form-check custom-checkbox checkbox-success check-lg me-3">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="allotCourse[]" value="{{$student->id}}"
                                                                        id="checkAll">
                                                                    <label class="form-check-label"
                                                                        for="checkAll"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <h6 class="mb-0">{{$j++}}</h6>
                                                            </td>
                                                            <td>
                                                                <div class="trans-list">
                                                                    <img src="/upload/student/{{$student->image}}"
                                                                        alt="" class="avatar me-3">
                                                                    <h4>{{$student->fname}} {{$student->lname}}</h4>
                                                                </div>
                                                            </td>
                                                            <td><span
                                                                    class="text-primary font-w600">{{$student->username}}</span>
                                                            </td>
                                                            <td>
                                                                <h6 class="mb-0">{{$student->parent_first}}
                                                                    {{$student->parent_last}}</h6>
                                                            </td>
                                                            <td>
                                                                <h6 class="mb-0">{{$student->mobile}}</h6>
                                                            </td>
                                                            <td>
                                                                <h6 class="mb-0">{{$student->city}}</h6>
                                                            </td>
                                                        </tr>
                                                        @endforeach
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
    </div>
</div>
@endsection