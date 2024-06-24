@extends('layouts.master')
@section('title','Online Classes')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @include('message') 
        <div class="d-flex align-items-center justify-content-between">
            <div class="btn-group">
               
            </div>
            <div class="button-group">
                <a href="{{url()->previous()}}" onclick="window.history.go(-1); return false;" class="ms-2 btn btn-danger btn-xs"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
            </div>
        </div>
        <div class="card">
            <div class="card-header border-0 flex-wrap d-flex justify-content-between">
                <div>
                    <h4 class=" mb-0 card-title d-flex align-items-center"><i class="mx-2 fs-4 fa-solid fa-arrow-right-long"></i>Online Classes</h4>
                </div>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Add New</button>
                {{-- <div class="ms-auto d-flex align-items-center">
                    <input type="hidden" name="status" id="search_status" value="1">
                    <label class="d-flex align-items-center mb-0"><input type="search" class="ms-2 form-control " placeholder="Search Subject" id="search_subject" name="search_subject" aria-controls="example"></label>
                </div> --}}
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table display dataTablesCard dataTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>Duration</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="subject_table"> 
                           @forelse ($classData as $item)
                               <tr>
                                    <td>{{$item->title}}</td>
                                    <td>{{date("d M Y",strtotime($item->start_date_time))}}</td>
                                    <td>{{date("H:i A",strtotime($item->start_date_time))}}</td>
                                    <td>{{$item->duration.' Minutes'}}</td>
                                    <td>
                                        @php
                                            $link = Crypt::encrypt($item->id);
                                        @endphp
                                        <a href="{{url('online-classes?eq='.$link)}}" class="badge-lg badge badge-rounded badge-success"><i class="me-1 fa-solid fa-plus"></i>Join</a>
                                        <a href="javascript:void(0);" data-id="{{url('online-class-remove?eq='.$link)}}" class="badge-lg badge badge-rounded badge-danger remove_meeting"><i class="me-1 fa-solid fa-plus"></i>Delete</a>
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
            </div>
            <div class="table-pagenation teach justify-content-center mt-5">
                <nav>
                    <ul class="pagination pagination-gutter pagination-primary no-bg">
                        {{$classData->links()}}
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

{{-- Edit Subject --}}
<div class="modal fade" id="exampleModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{url('/store-online-class')}}" id="edit_subject" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Online Class</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body" id="form_details">
                    <div class="form-group">
                        <input type="hidden" name="subject_id" value="{{$subjectId}}">
                        <label for="meeting_title">Title <span class="text-danger">*</span></label>
                        <input type="text" name="meeting_title" id="meeting_title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="start_date">Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" id="start_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="start_time">Start Time <span class="text-danger">*</span></label>
                        <input type="time" name="start_time" id="start_time" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration (In Minutes) <span class="text-danger">*</span></label>
                        <input type="number" min="1" name="duration" id="duration" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary light btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit"  class="btn btn-danger light btn-sm" href="">Add</button>
                </div>
           </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
    $(".remove_meeting").on('click',function(){
        if(confirm('Are you sure? you want to remove this')){
            window.location.href = $(this).data('id');
        }
    })
</script>
@endsection