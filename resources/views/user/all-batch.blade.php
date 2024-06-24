@extends('layouts.master')
@section('title','All Batches')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @include('message')
        <div class="row justify-content-center">
            <div class="col-xl-12 mt-3">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="DefaultTab" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card-body pt-0">
                            <div class="default-tab">
                                @if (Auth::user()->u_role == 1)
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link border-0 active text-dark" data-bs-toggle="tab"
                                            href="#home" aria-selected="true" role="tab">Active</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link border-0 text-dark" data-bs-toggle="tab"
                                            href="#profile" aria-selected="false" role="tab" tabindex="-1">Deactive</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link border-0 text-dark" data-bs-toggle="tab"
                                            href="#contact" aria-selected="false" role="tab" tabindex="-1">Ended</a>
                                    </li>
                                </ul>
                                @endif
                                <div class="card border-0" id="bootstrap-table2">
                                    <!-- Nav tabs -->
                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="home" role="tabpanel">
                                            <div class="card-header flex-wrap d-flex justify-content-between  border-0 px-3">
                                                <div>
                                                    <h4 class="card-title">Active Batches</h4>
                                                </div>
                                                <div class="ms-auto d-flex align-items-center">
                                                    <label class="d-flex align-items-center mb-0"><input type="search"
                                                            class="ms-2 form-control "
                                                            placeholder="Search Active Batch" id="searchActivebatch"
                                                            name="searchActivebatch" aria-controls="example"></label>
                                                            @if (Auth::user()->u_role == 1)
                                                    <a href="/create-batch" type="button"
                                                        class="ms-3 btn btn-outline-primary btn-sm">Create Batch</a>
                                                        @endif
                                                </div>
                                            </div>
                                            <div class="tab-content" id="myTabContent-1">
                                                <div class="tab-pane fade show active" id="bordered" role="tabpanel"
                                                    aria-labelledby="home-tab-1">
                                                    <div class="card-body pt-0">
                                                        <div class="table-responsive full-data">
                                                            <table class="table display datatable dataTablesCard">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S No.</th>
                                                                        <th>Batch Name</th>
                                                                        <th>No. of Learners</th>
                                                                        <th>Start Date</th>
                                                                        <th>End Date</th>
                                                                        <th>Subject</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="batch_table">
                                                                    <?php $i = $batchs->firstItem() ?>
                                                                    @foreach($batchs as $batch)
                                                                        @if ($batch->status == 1)
                                                                        <tr>
                                                                            <td><strong>{{$i++}}</strong></td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <span
                                                                                        class="w-space-no">{{ $batch->name }}</span>
                                                                                        @if (Auth::user()->u_role == 1)
                                                                                    <a href="batch-edit/{{ $batch->id }}"
                                                                                        class="ms-2 btn btn-primary shadow btn-xs sharp me-1"><i
                                                                                            class="fa fa-pencil"></i></a>
                                                                                            @endif
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <span class="w-space-no">
                                                                                      {{$batch->allot_batches_count}}
                                                                                    </span>
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
                                                                                @if (Auth::user()->u_role == 1)
                                                                                <a href="/add/subject/{{$batch->id}}" class="badge-lg badge badge-rounded badge-success"><i class="me-1 fa-solid fa-plus"></i>Add</a>
                                                                                @endif
                                                                                <a href="/view/subject/{{$batch->id}}" class="badge-lg badge badge-rounded badge-dark"><i class="me-1 fa-solid fa-eye"></i>View</a>
                                                                                @if (Auth::user()->u_role == 1)
                                                                                <a href="/allot-batch/{{$batch->id}}" class="badge-lg badge badge-rounded badge-danger"><i class="me-1 fa-solid fa-paperclip"></i>Allot</a>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                        @endif
                                                                        @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="d-flex justify-content-center mt-5">
                                                            {{$batchs->links()}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="profile" role="tabpanel">
                                            <div class="card-header flex-wrap d-flex justify-content-between  border-0 px-3">
                                                <div>
                                                    <h4 class="card-title">Deactive Batches</h4>
                                                </div>
                                                <div class="ms-auto d-flex align-items-center">
                                                    <label class="d-flex align-items-center mb-0"><input type="search"
                                                            class="ms-2 form-control "
                                                            placeholder="Search Deactive Batch" id="searchDeactive"
                                                            name="searchDeactive" aria-controls="example"></label>
                                                    <a href="/create-batch" type="button"
                                                        class="ms-3 btn btn-outline-primary btn-sm">Create Batch</a>
                                                </div>
                                            </div>
                                            <div class="tab-content" id="myTabContent-1">
                                                <div class="tab-pane fade show active" id="bordered" role="tabpanel"
                                                    aria-labelledby="home-tab-1">
                                                    <div class="card-body pt-0">
                                                        <div class="table-responsive full-data">
                                                            <table class="table display datatable dataTablesCard">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S No.</th>
                                                                        <th>Batch Name</th>
                                                                        <th>Start Date</th>
                                                                        <th>End Date</th>
                                                                        <th>Subject</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="deactive_table">
                                                                    <?php $i = $batchs->firstItem() ?>
                                                                    @foreach($batchs as $batch)
                                                                        @if ($batch->status == 0)
                                                                        <tr>
                                                                            <td><strong>{{$i++}}</strong></td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <span
                                                                                        class="w-space-no">{{ $batch->name }}</span>
                                                                                    <a href="batch-edit/{{ $batch->id }}"
                                                                                        class="ms-2 btn btn-primary shadow btn-xs sharp me-1"><i
                                                                                            class="fa fa-pencil"></i></a>
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
                                                                                <a href="/view/subject/{{$batch->id}}" class="badge-lg badge badge-rounded badge-dark"><i class="me-1 fa-solid fa-eye"></i>View</a>
                                                                            </td>
                                                                        </tr>
                                                                        @endif
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="d-flex justify-content-center mt-5">
                                                            {{$batchs->links()}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="contact" role="tabpanel">
                                            <div class="card-header flex-wrap d-flex justify-content-between  border-0 px-3">
                                                <div>
                                                    <h4 class="card-title">Ended Batches</h4>
                                                </div>
                                                <div class="ms-auto d-flex align-items-center">
                                                    <label class="d-flex align-items-center mb-0"><input type="search"
                                                            class="ms-2 form-control "
                                                            placeholder="Search Ended Batch" id="searchEnded"
                                                            name="searchEnded" aria-controls="example"></label>
                                                    <a href="/create-batch" type="button"
                                                        class="ms-3 btn btn-outline-primary btn-sm">Create Batch</a>
                                                </div>
                                            </div>
                                            <div class="tab-content" id="myTabContent-1">
                                                <div class="tab-pane fade show active" id="bordered" role="tabpanel"
                                                    aria-labelledby="home-tab-1">
                                                    <div class="card-body pt-0">
                                                        <div class="table-responsive full-data">
                                                            <table class="table display datatable dataTablesCard">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S No.</th>
                                                                        <th>Batch Name</th>
                                                                        <th>Start Date</th>
                                                                        <th>End Date</th>
                                                                        <th>Subject</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="endbatch_table">
                                                                    <?php $i = $batchs->firstItem() ?>
                                                                    @foreach($batchs as $batch)
                                                                        @if ($batch->status == 2)
                                                                        <tr>
                                                                            <td><strong>{{$i++}}</strong></td>
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
                                                                                <a href="/view/subject/{{$batch->id}}" class="badge-lg badge badge-rounded badge-dark"><i class="me-1 fa-solid fa-eye"></i>View</a>
                                                                            </td>
                                                                        </tr>
                                                                        @endif
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="d-flex justify-content-center mt-5">
                                                            {{$batchs->links()}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Jquery Cdn -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $('#searchActivebatch').on('input', function(e) {
            $value = $(this).val();
            $.ajax({
                url: '{{ url("/search-batch")}}',
                type: 'post',
                data: {
                    _token: '{{csrf_token()}}',
                    search: $value
                },
                dataType: 'json',
                success: function(respond) {
                    $y = 1;
                    $htmlView = "";
                    if (respond['batch'].length > 0) {
                        for (let i = 0; i < respond['batch'].length; i++) {
                            console.log(respond);
                            $htmlView += `<tr>
                                <td><strong>${$y++}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="w-space-no">${respond['batch'][i].name}</span>
                                        @if (Auth::user()->u_role == 1)
                                        <a href="batch-edit/${respond['batch'][i].id}"  class="ms-2 btn btn-primary shadow btn-xs sharp me-1"><i
                                         class="fa fa-pencil"></i></a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center"><span class="w-space-no"> ${respond['batch'][i].allot_batches_count}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center"><span class="w-space-no"> ${moment(respond['batch'][i].start_date).format('DD-MMM-YYYY')}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="w-space-no">${moment(respond['batch'][i].end_date).format('DD-MMM-YYYY')}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        @if (Auth::user()->u_role == 1)
                                        <a href="/add/subject/${respond['batch'][i].id}" class="badge-lg badge badge-rounded badge-success"><i class="me-1 fa-solid fa-plus"></i>Add</a>
                                        @endif
                                        <a href="/view/subject/${respond['batch'][i].id}" class="mx-1 badge-lg badge badge-rounded badge-dark"><i class="me-1 fa-solid fa-eye"></i>View</a>
                                        @if (Auth::user()->u_role == 1)
                                        <a href="/allot-batch/${respond['batch'][i].id}" class="badge-lg badge badge-rounded badge-danger"><i class="me-1 fa-solid fa-paperclip"></i>Allot</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>`;
                        }
                        $("#batch_table").html($htmlView);
                    } else {
                        $("#batch_table").html(
                            "<tr><td colspan='7'><div class='justify-content-center d-flex align-items-center'><span class='w-space-no fs-3 text-primary'>No Record Found</span></div></td></tr><tr></tr>"
                        );
                    }
                }
            });
        });
    });

    $(document).ready(function() {
        $('#searchDeactive').on('input', function(e) {
            $value = $(this).val();
            $.ajax({
                url: '{{ url("/search-deactive-batch")}}',
                type: 'post',
                data: {
                    _token: '{{csrf_token()}}',
                    search: $value
                },
                dataType: 'json',
                success: function(respond) {
                    $y = 1;
                    $htmlView = "";
                    if (respond['batch'].length > 0) {
                        for (let i = 0; i < respond['batch'].length; i++) {
                            $htmlView += `<tr>
                                <td><strong>${$y++}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="w-space-no">${respond['batch'][i].name}</span>
                                        <a href="batch-edit/${respond['batch'][i].id}"  class="ms-2 btn btn-primary shadow btn-xs sharp me-1"><i
                                         class="fa fa-pencil"></i></a>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center"><span class="w-space-no"> ${moment(respond['batch'][i].start_date).format('DD-MMM-YYYY')}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center"><span class="w-space-no"> ${moment(respond['batch'][i].end_date).format('DD-MMM-YYYY')}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="w-space-no">${respond['batch'][i].allot_batches_count}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="/view/subject/${respond['batch'][i].id}" class="ms-1 badge-lg badge badge-rounded badge-dark"><i class="me-1 fa-solid fa-eye"></i>View</a>
                                    </div>
                                </td>
                            </tr>`;
                        }
                        $("#deactive_table").html($htmlView);
                    } else {
                        $("#deactive_table").html(
                            "<tr><td colspan='7'><div class='justify-content-center d-flex align-items-center'><span class='w-space-no fs-3 text-primary'>No Record Found</span></div></td></tr><tr></tr>"
                        );
                    }
                }
            });
        });
    });

    $(document).ready(function() {
        $('#searchEnded').on('input', function(e) {
            $value = $(this).val();
            $.ajax({
                url: '{{ url("/search-ended-batch")}}',
                type: 'post',
                data: {
                    _token: '{{csrf_token()}}',
                    search: $value
                },
                dataType: 'json',
                success: function(respond) {
                    $y = 1;
                    $htmlView = "";
                    if (respond['batch'].length > 0) {
                        for (let i = 0; i < respond['batch'].length; i++) {
                            $htmlView += `<tr>
                                <td><strong>${$y++}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="w-space-no">${respond['batch'][i].name}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center"><span class="w-space-no"> ${moment(respond['batch'][i].start_date).format('DD-MMM-YYYY')}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="w-space-no">${moment(respond['batch'][i].end_date).format('DD-MMM-YYYY')}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="w-space-no">${moment(respond['batch'][i].end_date).format('DD-MMM-YYYY')}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="w-space-no">${respond['batch'][i].allot_batches_count}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="/view/subject/${respond['batch'][i].id}" class="ms-1 badge-lg badge badge-rounded badge-dark"><i class="me-1 fa-solid fa-eye"></i>View</a>
                                    </div>
                                </td>
                            </tr>`;
                        }
                        $("#endbatch_table").html($htmlView);
                    } else {
                        $("#endbatch_table").html(
                            "<tr><td colspan='7'><div class='justify-content-center d-flex align-items-center'><span class='w-space-no fs-3 text-primary'>No Record Found</span></div></td></tr><tr></tr>"
                        );
                    }
                }
            });
        });
    });
</script>
@endsection