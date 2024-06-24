@extends('layouts.master')
@section('title','Upload Folder')
@section('content')
<link type="text/css" rel="stylesheet"
    href="{{asset('/js/quee/js/jquery.plupload.queue/css/jquery.plupload.queue.css')}}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/basic.css"
    integrity="sha512-+Vla3mZvC+lQdBu1SKhXLCbzoNCl0hQ8GtCK8+4gOJS/PN9TTn0AO6SxlpX8p+5Zoumf1vXFyMlhpQtVD5+eSw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .plupload_button.plupload_start{
        display: none;
    }
</style>
<div class="content-body">
    @include('message')
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="button-group">
                <a href="{{url()->previous()}}" onclick="window.history.go(-1); return false;" class="mb-2 btn btn-danger btn-xs"><i
                        class="fa-solid fa-arrow-left-long"></i> Back</a>
            </div>
            <div class="button-group">
                <a href="/add-subject/{{$subject->categories_id }}/" class="mb-2 btn btn-primary btn-xs"> Add Subject</a>
                <a href="/course/batch/{{$subject->categories_id }}/" class="mb-2 btn btn-success btn-xs">Next <i class="fa-solid fa-arrow-right-long"></i></a>
            </div>
        </div>
        <div class="card  rounded-0 file_area mb-0">
            <div class="card-header flex-wrap d-flex justify-content-between">
                <h2 class="heading">{{strtoupper($subject->sub_name)}}</h2>
                <div class="ms-2">
                    <button class="btn btn-xs btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModalCenter">Upload Subject Material</button>
                </div>
            </div>
            <div class="card-body">
                <!--row-->
                <div class="row g-1">
                  
                    <!--/column-->
                    <?php $i = 0; ?>
                    @foreach ($uploadData as $upload)
                    @if ($upload->type == "Media")
                    <div class="col-xl-12 border">
                        <div class="file-list p-3">
                            <div class="dz-media me-1 d-flex align-items-center justify-content-center">
                                @php
                                    $extArr = explode(".",$upload->description);
                                @endphp
                                <?php if(end($extArr)== "pdf"){ ?>
                                <img width="30px" height="30px" class="your_image_class" src="/images/pdf.png"
                                alt="">
                                <?php }else { ?>
                                <img width="30px" height="30px" class="your_image_class" src="/images/default-image.png"
                                alt="">
                                <?php } ?>
                            </div>
                            <div class="dz-info">
                                <a href="/access-course-media/{{$subject->id}}/{{$upload->id}}">
                                    <h4 class="title">{{$upload->node_name}}</h4>
                                    <span>{{$upload->created_at}}</span>
                                </a>
                            </div>
                            <div class="ms-auto">
                                <a href="{{url('/delete-data/'.$upload->id.'')}}" onclick="return confirm('Are you sure?');" type="button" class="delete_btn mb-2"><i class="fa-solid fa-xmark text-danger"></i></a>
                            </div>
                        </div>
                    </div>
                    @elseif ($upload->type == "Video")
                    <div class="col-xl-12 border">
                        <div class="file-list p-3 ">
                            <div class="dz-media me-1 d-flex align-items-center justify-content-center">
                                <svg width="30" height="30" viewBox="0 0 40 40" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M39.984 19.984C39.984 30.832 31.36 39.664 20.592 39.968H19.472C8.672 39.68 0 30.848 0 19.968C0 9.088 8.656 0.272 19.456 0H20.576C31.36 0.32 39.984 9.136 39.984 19.984Z"
                                        fill="var(--primary)"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M40.064 19.984C40.064 30.832 31.44 39.664 20.672 39.968H20.064V0H20.64C31.44 0.32 40.064 9.136 40.064 19.984Z"
                                        fill="var(--primary)"></path>
                                    <path
                                        d="M27.763 18.3285L17.7647 11.4837C17.303 11.1674 16.8378 11 16.451 11C15.7034 11 15.241 11.6 15.241 12.6044V27.398C15.241 28.4011 15.7029 29 16.4487 29C16.836 29 17.2938 28.8324 17.7566 28.5152L27.7595 21.6706C28.4028 21.2297 28.7591 20.6364 28.7591 19.9992C28.7592 19.3625 28.407 18.7693 27.763 18.3285Z"
                                        fill="white"></path>
                                </svg>
                            </div>
                            <div class="dz-info">
                                <a href="/access-course-media/{{$subject->id}}/{{$upload->id}}">
                                    <h4 class="title">{{$upload->node_name}}</h4>
                                    <span>{{$upload->created_at}}</span>
                                </a>
                            </div>
                            <div class="ms-auto">
                                <a href="{{url('/delete-data/'.$upload->id.'')}}" onclick="return confirm('Are you sure?');" type="button" class="delete_btn mb-2"><i class="fa-solid fa-xmark text-danger"></i></a>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-xl-12 border">
                        <div class="file-list align-items-start p-3">
                            <div class="mt-2 dz-media d-flex justify-content-center align-items-center me-1">
                                <svg width="30" height="30" viewBox="0 0 79 62" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.7"
                                        d="M75.1668 20.5H68.3334V13.6667C68.3343 12.9934 68.2024 12.3266 67.9451 11.7044C67.6879 11.0822 67.3104 10.5168 66.8343 10.0407C66.3583 9.56467 65.7929 9.1872 65.1707 8.92996C64.5485 8.67272 63.8817 8.54078 63.2084 8.54168H37.1563C36.3935 8.54184 35.6403 8.37168 34.9517 8.04362C34.2631 7.71556 33.6564 7.23787 33.1759 6.64543L29.8276 2.52834C29.1893 1.73859 28.3825 1.10165 27.4661 0.664169C26.5498 0.226689 25.5472 -0.000241404 24.5317 4.56815e-06H5.12506C4.45179 -0.000894936 3.78495 0.131054 3.16275 0.38829C2.54055 0.645527 1.97521 1.023 1.49913 1.49908C1.02305 1.97516 0.645583 2.54049 0.388346 3.16269C0.131109 3.78489 -0.000838865 4.45173 6.06388e-05 5.12501V55.6404C-0.00347238 56.4099 0.147413 57.1723 0.443784 57.8824C0.740155 58.5925 1.17599 59.236 1.72548 59.7746C2.26414 60.3241 2.90758 60.7599 3.6177 61.0563C4.32781 61.3527 5.09017 61.5036 5.85965 61.5H63.3622C64.6314 61.4996 65.8665 61.0884 66.8827 60.3278C67.8988 59.5672 68.6415 58.4981 68.9997 57.2804L78.4468 24.8734C78.5942 24.3642 78.6213 23.8278 78.5259 23.3063C78.4306 22.7849 78.2154 22.2928 77.8974 21.8687C77.5793 21.4447 77.1671 21.1003 76.6933 20.8628C76.2194 20.6253 75.6968 20.5011 75.1668 20.5Z"
                                        fill="var(--primary)"></path>
                                    <path
                                        d="M75.1645 20.5H26.6031C25.3352 20.5002 24.1016 20.9115 23.0875 21.6723C22.0733 22.4332 21.3332 23.5024 20.9784 24.7196L11.48 57.2828C11.1252 58.4994 10.3853 59.5681 9.3715 60.3285C8.35766 61.0889 7.12455 61.5 5.85724 61.5H63.3662C64.6343 61.5001 65.8682 61.0889 66.8826 60.3281C67.8971 59.5672 68.6374 58.4978 68.9923 57.2804L78.4446 24.8733C78.5932 24.3641 78.6211 23.8273 78.5262 23.3054C78.4313 22.7836 78.2162 22.2909 77.8979 21.8666C77.5797 21.4423 77.167 21.0979 76.6925 20.8607C76.2181 20.6235 75.6949 20.5 75.1645 20.5Z"
                                        fill="var(--primary)"></path>
                                </svg>
                            </div>
                            <div class="dz-info w-100 mt-2">
                                <div class="d-flex justify-content-between w-100">
                                    <div class="">
                                        <h5 class="mb-0 me-2">{{$upload->node_name}}</h5>
                                        <span class="text-muted">{{$upload->description}}</span>
                                    </div>
                                    <div class="btn-groups ">
                                        <a href="{{url('/delete-data/'.$upload->id.'')}}" class=" badge badge-rounded badge-danger show-btn" onclick="return confirm('Are you sure?');"><i class="fa-solid fa-xmark "></i></a>
                                        <button class="badge badge-rounded badge-success childs show-btn"
                                            data-id="{{$upload->id}}" data-bs-toggle="collapse"
                                            data-bs-target="#collapseExample{{$i}}" aria-expanded="false"
                                            aria-controls="collapseExample{{$i}}">+</button>
                                        <button class="child_folder badge badge-rounded badge-primary ms-1"
                                            data-bs-toggle="modal" data-bs-target="#exampleModalCenter2"
                                            data-id="{{$upload->id}}">Add</button>
                                    </div>
                                </div>
                                <div class="collapse" id="collapseExample{{$i}}">
                                    <div class="p-0 mt-2 card  d-flex justify-content-between card-body mb-0">
                                        <div id="childData" class="w-100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endif
                    <?php $i++ ?>
                    @endforeach

                </div>

             
            </div>
        </div>
           <!-- Parent Modal -->
           <div class="modal fade" id="exampleModalCenter">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="card-title mb-0">Upload</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body ">

                        <div class="alert alert-light  fade show">
                           
                            <div class="media">
                                <div class="media-body">
                                    <h5 class="mt-1 mb-1">Instruction</h5>
                                    <p class="mb-0">The maximum upload size allowed upto 2GB for Image, PDF & Video Upto 2GB</p>
                                </div>
                            </div>
                        </div>
                        <!-- Column  -->
                        <div class="col-xl-12">
                            <div class=" mb-0 pt-2">
                                <div class="card-header flex-wrap border-0 py-2 px-0 d-flex "
                                    id="default-tab">
                                    <ul class="nav nav-tabs dzm-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active btn-sm" id="home-tab" data-bs-toggle="tab"
                                                data-bs-target="#DefaultTab" type="button" role="tab"
                                                aria-selected="true">Upload Image/PDF</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link btn-sm" id="profile-tab" data-bs-toggle="tab"
                                                data-bs-target="#DefaultTab-html" type="button" role="tab"
                                                aria-selected="false">Upload Folder</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link btn-sm" id="video-tab" data-bs-toggle="tab"
                                                data-bs-target="#video" type="button" role="tab"
                                                aria-selected="false">Upload Video</button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="DefaultTab" role="tabpanel"
                                        aria-labelledby="home-tab">
                                        <form action="/upload-data" class="mb-0" enctype="multipart/form-data"
                                            method="post">
                                            <div class="d-flex justify-content-center">
                                            </div>
                                            @csrf
                                            <div class="">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-12 mb-3">
                                                        <label class="form-label">File Name<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="f_name"
                                                            placeholder="File Name" value="" required="">
                                                        <input type="hidden" name="sid"
                                                            value="{{$subject->id}}">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                    <div class="col-sm-12 ">
                                                        <input type="hidden" class="form-control" name="f_type"
                                                            value="Media" required="">
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 ">
                                                        <label class="form-label">Upload
                                                            File<span
                                                            class="text-danger">*</span></label>
                                                        <div class="avatar-upload text-center">
                                                            <div class="avatar-preview">
                                                                <img id="blah" class="img-fluid w-100 img-thumbnail" height="200px"
                                                                    src="{{asset('images/upload-default2.png')}}">
                                                                    <img src="" class="img-fluid w-100 img-thumbnail" height="200px" id="default-img" alt="">
                                                            </div>
                                                            <div class="change-btn mt-1">
                                                                <input type='file' class="form-control d-none"
                                                                    id="imgInp" name="image">
                                                                <label for="imgInp"
                                                                    class="dlab-upload mb-0 btn btn-primary btn-sm">Choose
                                                                    File</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <button class="btn btn-primary mt-1 btn-sm">Upload</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="DefaultTab-html" role="tabpanel"
                                        aria-labelledby="home-tab">
                                        <form class="mb-0" action="/upload-data" method="post">
                                            @csrf
                                            <div class="d-flex justify-content-center">
                                            </div>
                                            @csrf
                                            <div class="">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-12 mb-3">
                                                        <label class="form-label">Folder Name<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            name="folder_name" placeholder="Folder Name"
                                                            value="" required="">
                                                        <input type="hidden" name="sid"
                                                            value="{{$subject->id}}">
                                                    </div>
                                                    <div class="col-sm-12 mb-3">
                                                        <label class="form-label">Folder Description<span
                                                                class="text-danger">*</span></label>
                                                        <textarea class="form-control" name="f_description"
                                                            placeholder="Folder Description" id="" cols="30"
                                                            rows="6" required=""></textarea>
                                                    </div>
                                                    <div class="col-sm-12 mb-3">
                                                        <input type="hidden" class="form-control" name="f_type"
                                                            value="Folder" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <button class="btn btn-primary mt-1 btn-sm">Upload</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="video" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    <form action="/upload-data" method="POST" id="parentForm">
                                        @csrf
                                        <div class="col-sm-12 mb-3">
                                            <label class="form-label">Video Title<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                name="video_title" placeholder="Enter Video Title"
                                                value="" required="">
                                            <label class="form-label mt-3">Upload Video File<span
                                                class="text-danger">*</span></label>
                                            <div id="uploader">
                                                <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
                                            </div>
                                            <input type="hidden" name="sid"
                                                value="{{$subject->id}}">
                                            <input type="hidden" class="form-control"
                                                name="file_name" id="parentFile"  value="" class="">
                                            <input type="hidden" class="form-control" name="f_type"
                                                value="Video" required="">
                                        </div>
                                        <div class="text-end">
                                            <button type="submit"
                                                class="btn btn-primary btn-sm" id="video_upload">Upload</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Column  -->
                </div>
            </div>
        </div>
        {{-- End Model --}}
        <!-- Child Modal -->
        <div class="modal fade" id="exampleModalCenter2">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Sub-Folder</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                    
                        
                        <div class="alert alert-light  fade show">
                           
                            <div class="media">
                                <div class="media-body">
                                    <h5 class="mt-1 mb-1">Instruction</h5>
                                    <p class="mb-0">The maximum upload size allowed upto 2GB for Image, PDF & Video Upto 2GB</p>
                                </div>
                            </div>
                        </div>
                        

                        <div class="col-xl-12">
                            <div class="flex-wrap border-0 py-2 px-0 d-flex " id="default-tab">
                                <ul class="nav nav-tabs dzm-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active btn-sm" id="home-tab" data-bs-toggle="tab"
                                            data-bs-target="#file1" type="button" role="tab"
                                            aria-selected="true">Upload Image/PDF</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link btn-sm" id="profile-tab" data-bs-toggle="tab"
                                            data-bs-target="#folder1" type="button" role="tab"
                                            aria-selected="false">Upload Folder</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link btn-sm" id="v-tab" data-bs-toggle="tab" data-bs-target="#vdo"
                                            type="button" role="tab" aria-selected="false">Upload Video</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="file1" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    <form action="/upload-subdata" class="mb-0" enctype="multipart/form-data"
                                        method="post">
                                        @csrf
                                        <div class="card-body p-1">
                                            <div class="row align-items-center">
                                                <div class="col-sm-12 mb-3">
                                                    <label class="form-label">File Name<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="f_name"
                                                        placeholder="File Name" value="" required="">
                                                    <input type="hidden" name="sid" value="{{$subject->id}}">
                                                    <input type="hidden" name="parentFolder" class="parentFolder"
                                                        value="">
                                                    <span class="text-danger"></span>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <input type="hidden" class="form-control" name="f_type"
                                                        value="Media" required="">
                                                </div>
                                                <div class="col-xl-12 col-lg-12 ">
                                                    <label class="form-label">Upload File <span class="text-danger">*</span></label>
                                                    <div class="avatar-upload text-center">
                                                        <div class="avatar-preview">
                                                            <img id="blah2"  class="img-fluid img-thumbnail w-auto" height="200px" 
                                                                src="/images/upload-default2.png">
                                                                <img src="" class="img-fluid img-thumbnail w-auto" height="200px" id="default-img1" alt="">
                                                        </div>
                                                        <div class="change-btn mt-1">
                                                            <input type='file' class="form-control d-none" id="imgInp2"
                                                                name="image">
                                                            <label for="imgInp2"
                                                                class="dlab-upload mb-0 btn btn-primary btn-sm">Choose
                                                                File</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer p-0 d-flex justify-content-end">
                                            <button class="btn btn-primary mt-1">Upload</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="folder1" role="tabpanel" aria-labelledby="home-tab">
                                    <form class="mb-0" action="/upload-subdata" method="post">
                                        @csrf
                                        <div class="card-body p-1">
                                            <div class="row align-items-center">
                                                <div class="col-sm-12 mb-3">
                                                    <label class="form-label">Folder Name<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="folder_name"
                                                        placeholder="Folder Name" value="" required="">
                                                    <input type="hidden" name="sid" value="{{$subject->id}}">
                                                    <input type="hidden" name="parentFolder" class="parentFolder"
                                                        value="">
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <label class="form-label">Folder Description<span
                                                            class="text-danger">*</span></label>
                                                    <textarea class="form-control" name="f_description"
                                                        placeholder="Folder Description" id="" cols="30" rows="6"
                                                        required=""></textarea>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <input type="hidden" class="form-control" name="f_type"
                                                        value="Folder" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer p-0 d-flex justify-content-end">
                                            <button class="btn btn-primary mt-1">Upload</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="vdo" role="tabpanel" aria-labelledby="home-tab">
                                    <form action="/upload-subdata" method="POST" id="childForm">
                                        @csrf
                                        <div class="col-sm-12 mb-3">
                                            <label class="form-label">Video Title<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="video_title"
                                                placeholder="Enter Video Title" value="" required="">
                                            <label class="form-label mt-3">Upload Video File<span
                                                class="text-danger">*</span></label>
                                            <div id="uploader2">
                                                <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
                                            </div>
                                            <input type="hidden" name="sid" value="{{$subject->id}}">
                                            <input type="hidden" class="form-control" id="childFile" name="file_name" value=""
                                                class="">
                                                <input type="hidden" name="parentFolder" class="parentFolder"
                                                value="">
                                            <input type="hidden" class="form-control" name="f_type"
                                                value="Video" required="">
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary btn-sm" id="video_upload2">Upload</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/column-->
    </div>
</div>  
<!-- Jquery Cdn -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script type="text/javascript" src="{{asset('/js/quee/js/plupload.full.min.js')}}" charset="UTF-8"></script>
<script type="text/javascript" src="{{asset('/js/quee/js/jquery.plupload.queue/jquery.plupload.queue.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<script>
    $("#parentForm").validate({
        submitHandler: function(form,event) {
            event.preventDefault();
            var fileLength = $("#uploader .plupload_file_name").length;
            console.log(fileLength);
            if (fileLength > 0) {
                // Disable submit button and start upload
                $('#video_upload').attr('disabled', 'disabled').text('Processing...');
                uploader.bind('UploadComplete', function() {
                    $('#video_upload').text('File uploaded successfully');
                    form.submit();
                });
                uploader.start();
            } else {
                iziToast.error({
                    title: 'Error',
                    message: 'Please Upload a Video File',
                    position: 'topRight',
                });
            }
        }
    });
</script>
<script>
    $("#childForm").validate({
        submitHandler: function(form,event) {
            event.preventDefault();
            var fileLength = $("#uploader2 .plupload_file_name").length;
            console.log(fileLength);
            if (fileLength > 0) {
                // Disable submit button and start upload
                $('#video_upload2').attr('disabled', 'disabled').text('Processing...');
                uploader2.bind('UploadComplete', function() {
                    $('#video_upload2').text('File uploaded successfully');
                    form.submit();
                });
                uploader2.start();
            } else {
                iziToast.error({
                    title: 'Error',
                    message: 'Please Upload a Video File',
                    position: 'topRight',
                });
            }
        }
    });
</script>
<script>
    var docsArr_sample = '';
    $('#uploader').pluploadQueue({
        runtimes: 'html5,flash,silverlight,html4',
        url: '{{route("file-upload")}}',
        chunk_size: '10mb',
        multi_selection: true,
        filters: [{
            title: "Audio/Video files",
            extensions: "mp3,mp4"
        }],
        rename: true,
        max_files:  1, // Change this value if you want to allow more than one file
        sortable: true,
        dragdrop: true,
        views: {
            list: true,
            thumbs: true, // Show thumbs
            active: 'thumbs',
        },
        headers: {
            "x-csrf-token": "{{csrf_token()}}"
        },
        flash_swf_url: '{{asset("//js/quee/js/Moxie.swf")}}',
        silverlight_xap_url: '{{asset("//js/quee/js/Moxie.xap")}}',
    });

    var uploader = $("#uploader").pluploadQueue();

    uploader.bind('FileUploaded', function(up, file, info) {
        var response;
        response = jQuery.parseJSON(info.response);
        if (response.error.code == '200') {
            if (docsArr_sample == '') {
                docsArr_sample = ''+response.error.id+'';
            } else {
                docsArr_sample = docsArr_sample + ','+response.error.id+'';
            }
        }
        $('#parentFile').val(docsArr_sample);
        $("#video_upload").text('File uploaded successfully');
    });

    uploader.bind('FilesAdded', function(up, files) {
        if (up.files.length >= up.settings.max_files) {
            up.splice(up.settings.max_files);
            $(up.settings.browse_button).hide();
        }
    });

    uploader.bind('FilesRemoved', function(up, files) {
        if (up.files.length < up.settings.max_files) {
            $(up.settings.browse_button).show();
        }
    });

    uploader.bind('UploadProgress', function(up, file) {
        $(".site-loader").css('display','flex');
        $("button[type='submit']").attr('disabled', 'disabled').text('Processing...');
    });
</script>
<script>
    var docsArr_sample = '';
    $('#uploader2').pluploadQueue({
        runtimes: 'html5,flash,silverlight,html4',
        url: '{{route("file-upload")}}',
        chunk_size: '10mb',
        multi_selection: true,
        filters: [{
            title: "Audio/Video files",
            extensions: "mp3,mp4"
        }],
        rename: true,
        max_files:  1, // Change this value if you want to allow more than one file
        sortable: true,
        dragdrop: true,
        views: {
            list: true,
            thumbs: true, // Show thumbs
            active: 'thumbs',
        },
        headers: {
            "x-csrf-token": "{{csrf_token()}}"
        },
        flash_swf_url: '{{asset("//js/quee/js/Moxie.swf")}}',
        silverlight_xap_url: '{{asset("//js/quee/js/Moxie.xap")}}',
    });

    var uploader2 = $("#uploader2").pluploadQueue();

    uploader2.bind('FileUploaded', function(up, file, info) {
        var response;
        response = jQuery.parseJSON(info.response);
        if (response.error.code == '200') {
            if (docsArr_sample == '') {
                docsArr_sample = ''+response.error.id+'';
            } else {
                docsArr_sample = docsArr_sample + ','+response.error.id+'';
            }
        }
        $('#childFile').val(docsArr_sample);
        $("#video_upload2").text('File uploaded successfully');
    });

    uploader2.bind('FilesAdded', function(up, files) {
        if (up.files.length >= up.settings.max_files) {
            up.splice(up.settings.max_files);
            $(up.settings.browse_button).hide();
        }
    });

    uploader2.bind('FilesRemoved', function(up, files) {
        if (up.files.length < up.settings.max_files) {
            $(up.settings.browse_button).show();
        }
    });

    uploader2.bind('UploadProgress', function(up, file) {
        $(".site-loader").css('display','flex');
        $("button[type='submit']").attr('disabled', 'disabled').text('Processing...');
    });
</script>
<script>
    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
            blah.src = URL.createObjectURL(file)
            $("#blah")
            .on('load', function() { })
            .on('error', function() { 
                blah.style.display = 'none';
                $('#default-img').attr('src','/images/pdf.png');
             })
        }
    }
    imgInp2.onchange = evt => {
        const [file] = imgInp2.files
        if (file) {
            blah2.src = URL.createObjectURL(file);
            $("#blah2")
            .on('load', function() { })
            .on('error', function() { 
                blah2.style.display = 'none';
                $('#default-img1').attr('src','/images/pdf.png');
             })
        }
    }
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $(document).on('click', '.child_folder', function() {
            $id = $(this).data('id');
            console.log($id);
            $('.parentFolder').val($id);
        });
    });
    $(document).on('click', '.show-btn', function(e) {
        $(this).text($(this).text() == "+" ? "-" : "+");
    })
    $(document).ready(function() {
        $(document).on('click', '.childs', function(e) {
            $(this).toggleClass("childs");
            $value = $(this).data('id');
            $var = $(this).parent().parent().next().children().children();
            $.ajax({
                url: '{{ url("/child-folder")}}',
                type: 'post',
                data: {
                    _token: '{{csrf_token()}}',
                    child_folder: $value
                },
                dataType: 'json',
                success: function(respond) {
                    console.log(respond);
                    $y = 1;
                    $html = ``;
                    $htmImg = ``;
                    if (respond['childs'].length > 0) {
                        for (let i = 0; i < respond['childs'].length; i++) {
                            if (respond['childs'][i].type == "Media") {

                                $image = respond['childs'][i].description;

                                if ($image.split('.').pop().toLowerCase() == "pdf") {
                                    $htmImg = `<img width="30px" height="30px" src="/images/pdf.png" alt="">`;
                                }else{
                                    $htmImg = `<img width="30px" height="30px" src="/images/default-image.png" alt="">`;
                                }


                                $html += ` <div class="col-xl-12 border mt-2"><div class="file-list p-3">
                                            <div class="dz-media me-1 d-flex align-items-center justify-content-center">
                                                ${$htmImg}
                                            </div>
                                            <div class="dz-info">
                                                <a href="/access-course-media/{{$subject->id}}/${respond['childs'][i].id}">
                                                    <h4 class="title">${respond['childs'][i].node_name}</h4>
                                                    <span>${respond['childs'][i].created_at}</span>
                                                </a>
                                            </div>
                                            <div class="ms-auto">
                                                <a href="/delete-data/${respond['childs'][i].id}" onclick="return confirm('Are you sure?');" type="button" class="delete_btn mb-2"><i class="fa-solid fa-xmark text-danger"></i></a>
                                            </div>
                                        </div></div>`;
                            }else if(respond['childs'][i].type == "Video"){

                                $html += `<div class="col-xl-12 border mt-2">
                                    <div class="file-list p-3">
                                        <div class="dz-media me-1 d-flex align-items-center justify-content-center">
                                            <svg width="30" height="30" viewBox="0 0 40 40" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M39.984 19.984C39.984 30.832 31.36 39.664 20.592 39.968H19.472C8.672 39.68 0 30.848 0 19.968C0 9.088 8.656 0.272 19.456 0H20.576C31.36 0.32 39.984 9.136 39.984 19.984Z"
                                                    fill="var(--primary)"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M40.064 19.984C40.064 30.832 31.44 39.664 20.672 39.968H20.064V0H20.64C31.44 0.32 40.064 9.136 40.064 19.984Z"
                                                    fill="var(--primary)"></path>
                                                <path
                                                    d="M27.763 18.3285L17.7647 11.4837C17.303 11.1674 16.8378 11 16.451 11C15.7034 11 15.241 11.6 15.241 12.6044V27.398C15.241 28.4011 15.7029 29 16.4487 29C16.836 29 17.2938 28.8324 17.7566 28.5152L27.7595 21.6706C28.4028 21.2297 28.7591 20.6364 28.7591 19.9992C28.7592 19.3625 28.407 18.7693 27.763 18.3285Z"
                                                    fill="white"></path>
                                            </svg>
                                        </div>
                                        <div class="dz-info">
                                            <a href="/access-course-media/{{$subject->id}}/${respond['childs'][i].id}">
                                                <h4 class="title">${respond['childs'][i].node_name}</h4>
                                                <span>${respond['childs'][i].created_at}</span>
                                            </a>
                                        </div>
                                        <div class="ms-auto">
                                            <a href="/delete-data/${respond['childs'][i].id}" onclick="return confirm('Are you sure?');" type="button" class="delete_btn mb-2"><i class="fa-solid fa-xmark text-danger"></i></a>
                                        </div>
                                    </div>
                                </div>`;

                            }else {
                                $html += ` <div class="col-xl-12 border mt-2">
                                <div class=" file-list align-items-start p-3">
                            <div class="mt-2 dz-media d-flex justify-content-center align-items-center me-1">
                                <svg width="30" height="30" viewBox="0 0 79 62" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.7"
                                        d="M75.1668 20.5H68.3334V13.6667C68.3343 12.9934 68.2024 12.3266 67.9451 11.7044C67.6879 11.0822 67.3104 10.5168 66.8343 10.0407C66.3583 9.56467 65.7929 9.1872 65.1707 8.92996C64.5485 8.67272 63.8817 8.54078 63.2084 8.54168H37.1563C36.3935 8.54184 35.6403 8.37168 34.9517 8.04362C34.2631 7.71556 33.6564 7.23787 33.1759 6.64543L29.8276 2.52834C29.1893 1.73859 28.3825 1.10165 27.4661 0.664169C26.5498 0.226689 25.5472 -0.000241404 24.5317 4.56815e-06H5.12506C4.45179 -0.000894936 3.78495 0.131054 3.16275 0.38829C2.54055 0.645527 1.97521 1.023 1.49913 1.49908C1.02305 1.97516 0.645583 2.54049 0.388346 3.16269C0.131109 3.78489 -0.000838865 4.45173 6.06388e-05 5.12501V55.6404C-0.00347238 56.4099 0.147413 57.1723 0.443784 57.8824C0.740155 58.5925 1.17599 59.236 1.72548 59.7746C2.26414 60.3241 2.90758 60.7599 3.6177 61.0563C4.32781 61.3527 5.09017 61.5036 5.85965 61.5H63.3622C64.6314 61.4996 65.8665 61.0884 66.8827 60.3278C67.8988 59.5672 68.6415 58.4981 68.9997 57.2804L78.4468 24.8734C78.5942 24.3642 78.6213 23.8278 78.5259 23.3063C78.4306 22.7849 78.2154 22.2928 77.8974 21.8687C77.5793 21.4447 77.1671 21.1003 76.6933 20.8628C76.2194 20.6253 75.6968 20.5011 75.1668 20.5Z"
                                        fill="var(--primary)"></path>
                                    <path
                                        d="M75.1645 20.5H26.6031C25.3352 20.5002 24.1016 20.9115 23.0875 21.6723C22.0733 22.4332 21.3332 23.5024 20.9784 24.7196L11.48 57.2828C11.1252 58.4994 10.3853 59.5681 9.3715 60.3285C8.35766 61.0889 7.12455 61.5 5.85724 61.5H63.3662C64.6343 61.5001 65.8682 61.0889 66.8826 60.3281C67.8971 59.5672 68.6374 58.4978 68.9923 57.2804L78.4446 24.8733C78.5932 24.3641 78.6211 23.8273 78.5262 23.3054C78.4313 22.7836 78.2162 22.2909 77.8979 21.8666C77.5797 21.4423 77.167 21.0979 76.6925 20.8607C76.2181 20.6235 75.6949 20.5 75.1645 20.5Z"
                                        fill="var(--primary)"></path>
                                </svg>
                            </div>
                            <div class="dz-info w-100 mt-2">
                                <div class="d-flex justify-content-between w-100" id="details_folder">
                                    <div class="">
                                        <h5 class="mb-0 me-2">${respond['childs'][i].node_name}</h5>
                                        <span class="text-muted">${respond['childs'][i].description}</span>
                                    </div>
                                    <div class="btn-groups ">
                                        <a href="/delete-data/${respond['childs'][i].id}" class=" badge badge-rounded badge-danger show-btn" onclick="return confirm('Are you sure?');"><i class="fa-solid fa-xmark "></i></a>
                                        <button class="badge badge-rounded badge-success childs show-btn" data-id="${respond['childs'][i].id}"
                                            data-bs-toggle="collapse" data-bs-target="#collapseExample${respond['childs'][i].id}"
                                            aria-expanded="false" aria-controls="collapseExample${respond['childs'][i].id}">+</button>
                                        <button class="child_folder badge badge-rounded badge-primary ms-1" data-bs-toggle="modal"
                                            data-bs-target="#exampleModalCenter2" data-id="${respond['childs'][i].id}">Add</button>
                                    </div>
                                </div>
                                <div class="collapse" id="collapseExample${respond['childs'][i].id}">
                                    <div class="p-0 d-flex mt-2  justify-content-between  mb-0 w-100">
                                        <div id="childData" class="w-100"></div>
                                    </div>
                                </div>
                            </div>
                        </div></div>`;
                            };
                            $y++;
                        }
                    }
                    $default = `<div class="mt-2 alert alert-danger alert-dismissible fade show mb-0">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        <strong>Empty!!</strong> No Document Found!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </button>
                    </div>`;
                    $var.html(($html == "") ? $default : $html);
                }
            });
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
<script src="{{ asset('js/file_upload.js') }}" defer></script>

{{-- <script>
    var home_url = "{{env('APP_URL') }}";
    var deleteAction = '{{ route("file-delete") }}';
    var generalTS = document.getElementById('dataTS').value;
    var generalDATE = document.getElementById('dataDATE').value;
    var token = '{!! csrf_token() !!}';
</script> --}}
@endsection