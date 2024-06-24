@extends('layouts.master')
@section('title','Upload Folder')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/basic.css"
    integrity="sha512-+Vla3mZvC+lQdBu1SKhXLCbzoNCl0hQ8GtCK8+4gOJS/PN9TTn0AO6SxlpX8p+5Zoumf1vXFyMlhpQtVD5+eSw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="content-body mh-auto">
    <div class="container">
        @include('message')
        <!-- Row -->
        <div class="button-group">
            <a href="{{url()->previous()}}" class="mb-2 btn btn-danger btn-xs"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0 card-title">{{$fileData->node_name}}</h4>
                    </div>
                    <div class="card-body text-center">
                        @if($fileData->type=='Video')
                        <video controls style="width:100%;height:auto;position: relative !important;" controlsList="nodownload" oncontextmenu="return false;">
                            <source src="{{url('course-media/'.$fileData->subjects_id.'/'.$fileData->description)}}" type="video/mp4" />
                        </video>
                        @elseif($fileData->type=='Media')
                            @php
                                $extArr = explode(".",$fileData->description);
                                $ImageFile = array('jpg','jpeg','png','gif','apng','ico','cur','jfif','pjpeg','pjp','svg','webp','flif','tiff');
                            @endphp
                            @if(end($extArr)== "pdf")
                                <iframe style="width:100%;height:768px;"  src="{{url('course-media-file/'.$fileData->subjects_id.'/'.$fileData->description)}}#toolbar=0"></iframe>
                            @elseif(in_array(end($extArr),$ImageFile))
                                <img oncontextmenu="return false;"  class="img-fluid" src="{{url('course-media-file/'.$fileData->subjects_id.'/'.$fileData->description)}}" style="pointer-events: none;">
                            @else
                            <div class="row align-items-center justify-content-center">
                                <div class="col-lg-8">
                                    <img src="/images/download-file.jpg" width="300px" alt="">
                                    <h4>To download your assignment or files, just click the "Download" button below.</h4>
                                    <a href="{{url('course-media-file/'.$fileData->subjects_id.'/'.$fileData->description)}}" class="btn-danger btn" download>Download</a>
                                </div>
                            </div>
                            @endif
                        @else
                        @endif

                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Jquery Cdn -->
@endsection