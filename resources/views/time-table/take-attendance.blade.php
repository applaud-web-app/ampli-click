@extends('layouts.master')
@section('title','TimeTable')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @include('message') 
        <div class="card">
            <div class="card-header border-0">
                <h4>Learners Attendance </h4>
                <div>
                    <h5>Date - {{date("d M Y",strtotime($timetableData->t_date))}}</h5>
                    <h5>Course - {{$timetableData->course->title}}</h5>
                    <h5>Batch - {{$timetableData->batch->name}}</h5>
                    <h5>Subject - {{$timetableData->subject->sub_name}}</h5>
                </div>
                
            </div>

            <div class="card-body pt-0">
                <form action="{{url('store-student-attendance')}}" method="post" id="att_frm">
                    @csrf
                    <div class="table-responsive">
                        <table class="table display dataTablesCard dataTable">
                            <thead>
                                <tr>
                                    <th>Learner</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            
                            <tbody id="subject_table"> 
                                <input type="hidden" name="batch_id" value="{{$timetableData->batch_id}}">
                                <input type="hidden" name="subject_id" value="{{$timetableData->subject_id}}">
                                <input type="hidden" name="date" value="{{$timetableData->t_date}}">
                            @forelse ($studentData as $item)
                               
                                @php
                                    $sts = 0;
                                    $colrCode = '#ffffff';
                                    if(isset($attData[$item->id])){
                                        $sts = $attData[$item->id];
                                        if($sts==1){
                                            $colrCode = 'rgb(201 252 223) !important';
                                        }elseif($sts==2){
                                            $colrCode = 'rgb(205 137 137) !important';
                                        }else{
                                            $colrCode = 'rgb(229 196 117) !important';
                                        }
                                    }
                                @endphp
                                <tr style="background:{!!$colrCode!!};">
                                    <td>
                                        <div>
                                            <img src="{{asset('upload/student/'.$item->image)}}" class="img-thumbnail" width="65" height="65">
                                            {{$item->fname.' '.$item->lname}}
                                        </div>
                                       
                                    </td>
                                    <td>
                                        <div>
                                            <select name="attendace[{{$item->id}}]" class="form-control">
                                                <option value="1" {{$sts==1 ? 'selected':''}}>Present</option>
                                                <option value="2" {{$sts==2 ? 'selected':''}}>Absent</option>
                                                <option value="3" {{$sts==3 ? 'selected':''}}>Leave</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2"><h4 class="text-center text-danger">NO DATA</h4></td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Mark Attendace</button>
                        </div>
                        
                    </div>
                </form>

            </div>
           

            
        </div>
    </div>
</div>

@push('scripts')

@endpush


@endsection