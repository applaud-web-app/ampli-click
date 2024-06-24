@extends('layouts.master')
@section('title','TimeTable')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @include('message') 
        <div class="card">
            <div class="card-header border-0">
                <form action="" method="get" action="" id="timetable_frm" name="timetable_frm">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                       
                        <div class="mb-md-0 mb-3 me-2">
                            <input type="date" name="date" class="form-control" value="{{$date}}" required>
                        </div>
                        <div class="mb-md-0 mb-3 me-2">
                            <button type="submit" class="btn btn-sm btn-primary">Show</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table display dataTablesCard dataTable">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Batch</th>
                                <th>Subject</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody id="subject_table"> 
                            @forelse ($attendaceData as $item)
                                <tr>
                                    <td>{{$item->course->title}}</td>
                                    <td>{{$item->batch->name}}</td>
                                    <td>{{$item->subject->sub_name}}</td>
                                    <td>{{date("H:i:s",strtotime($item->start_date_time))}}</td>
                                    <td>{{date("H:i:s",strtotime($item->end_date_time))}}</td>
                                    <td>
                                        <div>
                                            <a href="{{url('take-attendance/'.$item->id)}}" class="btn btn-sm btn-primary">Attendance</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"><h4 class="text-center text-danger">NO DATA</h4></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="table-pagenation teach justify-content-center mt-5">
                    <nav>
                        <ul class="pagination pagination-gutter pagination-primary no-bg">
                            {{$attendaceData->links()}}
                        </ul>
                    </nav>
                </div>
            </div>
           

            
        </div>
    </div>
</div>

@push('scripts')

@endpush


@endsection