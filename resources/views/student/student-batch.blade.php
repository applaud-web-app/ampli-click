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
                                            <th>S No.</th>
                                            <th>Batch Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Total Subject</th>
                                            <th>Details</th>
                                        </tr>
                                    </thead>
                                    <tbody id="batch_table">
                                        @foreach($show_batches as $batch)
                                            <tr>
                                                <td><strong>{{++$loop->index}}</strong></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span
                                                            class="w-space-no">{{ $batch->name }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="w-space-no">
                                                            {{date('d-M-Y', strtotime($batch->start_date)) }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="w-space-no">
                                                            {{date('d-M-Y', strtotime($batch->end_date)) }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="w-space-no">{{ $batch->total }}</span>
                                                </td>
                                                <td>
                                                    <a href="/student/subject/{{$batch->batches_id}}" class="badge-lg badge badge-rounded badge-dark"><i class="me-1 fa-solid fa-eye"></i>View</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- <div class="d-flex justify-content-center mt-5">
                                {{$batch->links()}}
                            </div> --}}
                        </div>
                    </div>
                    @endif
              
            </div>
        </div>
    </div>
</div>
@endsection