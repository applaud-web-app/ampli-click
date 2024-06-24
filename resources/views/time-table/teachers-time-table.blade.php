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
                            <select name="course" id="course" class="form-control" required>
                                <option value="">Select Course</option>
                                @foreach ($courses as $item)
                                    <option value="{{$item->id}}" {{$course==$item->id ? 'selected':''}}>{{$item->title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-md-0 mb-3 me-2">
                            <select name="batch" id="batch" class="form-control" required>
                                <option value="">Select Batch</option>
                                @foreach ($batches as $val)
                                    <option value="{{$val->id}}" {{$val->id==$batch ? 'selected':''}}>{{$val->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-md-0 mb-3 me-2">
                            <input type="date" name="date" class="form-control" value="{{$date}}" required>
                        </div>
                        <div class="mb-md-0 mb-3 me-2">
                            <button type="submit" class="btn btn-sm btn-primary">Show Timetable</button>
                        </div>
                    </div>
                </form>
            </div>

            @if($showTable==1)
            <div class="card-body pt-0">
                <form action="{{url('store-teacher-timetable')}}" method="post">
                    <input type="hidden" name="course_id" value="{{$course}}">
                    <input type="hidden" name="batch_id" value="{{$batch}}">
                    <input type="hidden" name="date" value="{{$date}}">
                    @csrf
                    <div class="table-responsive">
                        <table class="table display dataTablesCard dataTable">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Teacher</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                </tr>
                            </thead>
                            
                            <tbody id="subject_table"> 
                            @foreach ($subjects as $item)
                                @php
                                    $tId = 0;
                                    $stDate = '';
                                    $endDate = '';
                                    $pkId = 0;
                                    if(isset($timetableData[$item->id])){
                                        $tId = $timetableData[$item->id]->teacher_id;
                                        $stDate = date("H:i:s",strtotime($timetableData[$item->id]->start_date_time));
                                        $endDate = date("H:i:s",strtotime($timetableData[$item->id]->end_date_time));
                                        $pkId = $timetableData[$item->id]->id;
                                    }
                                @endphp
                                <input type="hidden" name="old_t_d[{{$item->id}}]" value="{{$pkId}}">
                                <tr>
                                    <td>{{$item->sub_name}}</td>
                                    <td>
                                        <div>
                                            <select name="teacher[{{$item->id}}]" class="form-control" >
                                                <option value="">Teacher</option>
                                                @foreach ($teachers as $tval):
                                                    <option value="{{$tval->id}}" {{$tId==$tval->id ? 'selected':''}}>{{$tval->teacher_name}}</option>
                                                @endforeach;
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <input type="time" name="start_time[{{$item->id}}]" class="form-control" value="{!!$stDate!!}">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <input type="time" name="end_time[{{$item->id}}]" class="form-control" value="{!!$endDate!!}">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    
                </form>
            </div>
            @endif

            
        </div>
    </div>
</div>

@push('scripts')
<script>
$("#course").on('change',function(){
    var courseId = $(this).val();
    $("#batch").html(`<option value="">Select Batch</option>`);
    if(courseId > 0){
        $("#batch").html(`<option value="">Loading...</option>`);
        $.get('{{url("get-batch-with-course?id=")}}'+courseId,function(data){
            var str = `<option value="">Select Batch</option>`;
            for(var i in data){
                str+=`<option value="${data[i].id}">${data[i].name}</option>`;
            }
            $("#batch").html(`${str}`);
        });
    }
});
</script>
@endpush


@endsection