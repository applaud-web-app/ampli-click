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
               
               
                    @if (Auth('student')->user()->status == 1 )
                        <div class="card h-auto ">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table display dataTablesCard  dataTable">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Start Time</th>
                                                <th>Duration</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="batch_table">
                                            @forelse ($classData as $item)
                                                <tr>
                                                    @php
                                                        $link = Crypt::encrypt($item->id);
                                                        $startDate = strtotime($item->start_date_time);
                                                        $endDate = strtotime(date("Y-m-d H:i:s",strtotime($item->start_date_time.' +'.$item->duration.'minutes')));
                                                        $currDate = time();
                                                    @endphp
                                                        <td>{{$item->title}}</td>
                                                        <td>{{date("d M Y",strtotime($item->start_date_time))}}</td>
                                                        <td>{{date("H:i A",strtotime($item->start_date_time))}}</td>
                                                        <td>{{$item->duration.' Minutes'}}</td>
                                                        <td>
                                                            @if($currDate<$endDate && $currDate > $startDate)
                                                                <a href="{{url('online-classes?eq='.$link)}}" class="badge-lg badge badge-rounded badge-success"><i class="me-1 fa-solid fa-plus"></i>Join</a>
                                                            @else
                                                                <a href="javascript:void(0)" class="badge-lg badge badge-rounded badge-light"><i class="me-1 fa-solid fa-plus"></i>Join</a>
                                                            @endif
                                                        </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5"><h4 class="text-center text-danger">NO DATA</h4></td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center mt-5">
                                    {{$classData->links()}}
                                </div>
                            </div>
                        </div>
                    @endif
              
            </div>
        </div>
    </div>
</div>
@endsection