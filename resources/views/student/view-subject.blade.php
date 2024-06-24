@extends('layouts.studentmaster')
@section('title', auth('student')->user()->fname.' '.auth('student')->user()->lname)
@section('student', auth('student')->user()->fname)
@section('content')
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('message')
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card h-auto">
                    <div class="card-header">
                        <h4 class="card-title"> Subjects</h4>
                    </div>
                    
                        @if (Auth('student')->user()->status == 1 )
                        <div class="card-body">
                            <div class="row">
                                @foreach ($subjects as $subject)
                                    <div class="col-lg-3 mb-3">
                                        <div class="border border-primary rounded overflow-hidden ">
                                            <div class="banner-box">
                                                <img class="img-fluid w-100" src="/upload/subject/{{$subject->sub_image}}" alt="">
                                            </div>
                                            <div class="content-box d-block text-center p-3">
                                                <h5 class="mb-1 text-primary">{{$subject->sub_name}}</h5>
                                                <p class="mb-1">{{$subject->sub_description}}</p>
                                                <div class="button-box">
                                                    <a href="/subject-details/{{$subject->id}}" class="btn-xs btn btn-block btn-primary rounded">View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                           {{-- <div class="table-responsive">
                                 <table class="table table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th>S No.</th>
                                            <th>Subject</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="subject_table">
                                        @foreach ($subjects as $subject)
                                        <tr>
                                            <td><strong>{{++$loop->index}}</strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img class="me-3 rounded avatar avatar-sm"
                                                        src="/upload/courses/{{$subject->sub_image}}" alt="DexignZone">
                                                    <span class="w-space-no">{{$subject->sub_name}}</span>
                                                </div>
                                            </td>
                                            <td>{{$subject->sub_description}}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="/subject-details/{{$subject->id}}"
                                                        class="btn btn-success shadow btn-xs sharp me-1"><i
                                                            class="fa-solid fa-copy"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table> 
                            </div>--}}
                        </div>
                        @endif
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection