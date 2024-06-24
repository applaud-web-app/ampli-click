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
            <div class="col-xl-12 ">
                
                {{-- <div class="card h-auto">
                    <div class="card-body pb-xl-4 pb-sm-3 pb-0"> --}}
                <div class="row justify-content-center">
                    @if (Auth('student')->user()->status == 3 )
                    <div class="card h-auto text-center">
                        <div class="card-body">
                            <h2 class="text-primary  ">Complete Your Registration Process</h2>
                       
                            <h5 class="mb-0">Fill this form to complete your
                                regestration
                                process</h5>
                        </div>
                       
                    </div>
                    <form action="/complete-regestration" class="p-0" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card h-auto">
                            <div class="card-header">
                                <h4 class="card-title">Personal Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                  
                                    <div class="col-lg-4 text-center">
                                        <label class=" form-label">Profile Photo</label>
                                        <div class="profile avatar-upload px-3">
                                            <div class="result_image0 d-flex flex-column align-items-center justify-content-center">
                                                <img src="{{asset('images/no-img-avatar.png')}}" class="img-thumbnail" width="auto" style="height: 150px" alt="">
                                                <button type="button" class="model_open mt-3 mb-0 btn btn-primary btn-sm" data-width="192"
                                                data-height="192" data-index="0" data-bs-toggle="modal"
                                                data-bs-target="#exampleModalCenter2">Choose File</button>
                                            </div>
                                            <input type="hidden" class="base64-image0" name="image" value="{{old('image')}}">
                                            <input type="hidden" name="sid" value="{{Auth('student')->user()->id}}">
                                            @error('image') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-8 mt-4">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Date Of Birth</label>
                                                <input type="date" name="dob" class="form-control" value="">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Gender<span
                                                        class="text-danger">*</span></label>
                                                <select name="gender" id="" class="form-control">
                                                    <option value="1">Male</option>
                                                    <option value="2">Female</option>
                                                    <option value="3">Other</option>
                                                </select>
                                                <span class="text-danger">@error('gender') {{$message}}
                                                    @enderror</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card h-auto">
                            <div class="card-header">
                                <h4 class="card-title">KYC Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4">
                                        <label class="form-label">Aadhar Number <span class="text-danger">*</span></label>
                                        <input type="number" name="aadhar" class="form-control" value="" placeholder="Addhar Number">
                                    </div>
                                    <div class="col-lg-4 text-center">
                                        <label class="form-label">Aadhar Front-Side Image <span class="text-danger">*</span></label>
                                        <div class="result_image1">
                                            <img src="{{asset('images/upload-default.png')}}" class="img-fluid" width="auto" height="200px" alt=""><br>
                                            <button type="button" class="model_open mt-3 mb-0 btn btn-primary btn-sm" data-width="325" data-height="204"
                                                data-index="1" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2">Choose
                                                File</button>
                                        </div>
                                        <input type="hidden" class="base64-image1" name="front_aadhar" value="{{old('front_aadhar')}}">
                                        @error('front_aadhar') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="col-lg-4 text-center">
                                        <label class="form-label">Aadhar Back-Side Image <span class="text-danger">*</span></label>
                                        <div class="result_image2">
                                            <img src="{{asset('images/upload-default.png')}}" class="img-fluid" width="auto" height="200px" alt=""><br>
                                            <button type="button" class="model_open mt-3 mb-0 btn btn-primary btn-sm" data-width="325" data-height="204"
                                                data-index="2" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2">Choose
                                                File</button>
                                        </div>
                                        <input type="hidden" class="base64-image2" name="back_aadhar" value="{{old('back_aadhar')}}">
                                        @error('back_aadhar') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card h-auto">
                            <div class="card-header">
                                <h4 class="card-title">Permanent Address</h4>
                            </div>
                            <div class="card-body">
                               
                                  
                                        <div class="row mb-3">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label">State <span class="text-danger">*</span></label>
                                                        <select name="state" class="default-select form-control wide states_choose" data-id="1"
                                                            value="" tabindex="null">
                                                            <option value="" selected>Select State</option>
                                                            @foreach ($states as $state)
                                                            <option value="{{$state->id}}">{{$state->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label">City <span class="text-danger">*</span></label>
                                                        <select name="city" class="courseBatch1 default-select form-control wide"
                                                            value="" tabindex="null">
                                                            <option value="" selected>Select City</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label class="form-label">Permanent
                                                            Address<span class="text-danger">*</span></label>
                                                        <textarea name="permanent_address" class="form-control" id=""
                                                            cols="30" rows="4" placeholder="Enter Permanent Address"></textarea>
                                                        <span class="text-danger"> @error('permanent_address')
                                                            {{$message}} @enderror</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                   
                                
                            </div>
                        </div>
                        <div class="card h-auto">
                            <div class="card-header">
                                <h4 class="card-title">Local Address (Optional)</h4>
                            </div>
                            <div class="card-body">
                              
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">State</label>
                                        <select name="local_state" class="default-select form-control wide states_choose" data-id="2"
                                            value="" tabindex="null">
                                            <option value="" selected>Select State</option>
                                            @foreach ($states as $state)
                                            <option value="{{$state->id}}">{{$state->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">City</label>
                                        <select name="local_city" class="courseBatch2 default-select form-control wide"
                                            value="" tabindex="null">
                                            <option value="" selected>Select City</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Local Address</label>
                                        <textarea name="local_address" class="form-control" id=""
                                            cols="30" rows="4" placeholder="Enter Local Address"></textarea>
                                        <span class="text-danger"> @error('local_address') {{$message}}
                                            @enderror</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card h-auto">
                            <div class="card-header">
                                <h4 class="card-title">Guardian Details (Optional)</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                   
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">First Name</label>
                                        <input type="text" name="pname" value="" class="form-control"
                                            placeholder="Enter First Name">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" name="plname" value="" class="form-control"
                                            placeholder="Enter Last Name">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" name="pemail" value="" class="form-control"
                                            placeholder="Enter Email">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Mobile No.</label>
                                        <input type="number" name="pmobile" value="" class="form-control"
                                            placeholder="Enter Mobile No.">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-primary ">Submit</button>
                        </div>
                    </form>
                    @endif
                    @if (Auth('student')->user()->status == 0 )
                    <div class="col-lg-12 mb-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <img src="{{asset('images/waiting.png')}}" alt="" class="img-fluid" style="height: auto;width: 230px;">
                                <h3 class="">Hello, <b
                                        class="text-success">{{auth('student')->user()->fname}}</b></h3>
                                    <h4 class="">Application Successfully Submitted & Awaiting Approval. Thank you for your consideration.</h4>
                            </div>
                        </div>
                      
                    </div>
                    @endif
                    @if (Auth('student')->user()->status == 1 )
                    <div class="row ">
                        <div class="col-xl-4 col-sm-6">
                            <div class="widget-stat card">
                                <div class="card-body p-4">
                                    <div class="media ai-icon">
                                        <span class="me-3 bgl-success text-success border border-success">
                                            <svg id="icon-database-widget" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database">
                                                <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                                                <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                                                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                                            </svg>
                                        </span>
                                        <div class="media-body">
                                            <p class="mb-1">Batches</p>
                                            <h4 class="mb-0">  <?php $sum = 0; ?>
                                                @foreach ($TotalSubject as $item)
                                                    <?php $sum += 1 ?>
                                                @endforeach 
                                                {{ $sum < 10 ? "0".$sum : $sum }}
                                            </h4>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                          
                        </div>
                        <div class="col-xl-4 col-sm-6">
                            <div class="widget-stat card">
                                <div class="card-body p-4">
                                    <div class="media ai-icon">
                                        <span class="me-3 bgl-warning text-warning border border-warning">
                                            <svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                                <polyline points="10 9 9 9 8 9"></polyline>
                                            </svg>
                                        </span>
                                        <div class="media-body">
                                            <p class="mb-1">Total Subject</p>
                                            <h4 class="mb-0"> <?php $sum = 0; ?>
                                                @foreach ($TotalBatches as $item)
                                                    <?php $sum += $item->show_batches_count ?>
                                                @endforeach
                                                {{ $sum < 10 ? "0".$sum : $sum }}
                                            </h4>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                        </div>
                        <div class="col-xl-4 col-sm-6">
                            <div class="widget-stat card">
                                <div class="card-body p-4">
                                    <div class="media ai-icon">
                                        <span class="me-3 bgl-primary text-primary border border-primary">
                                            <!-- <i class="ti-user"></i> -->
                                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M22.8333 6.66667V7.16667H23.3333H28.3333C28.6428 7.16667 28.9395 7.28958 29.1583 7.50838C29.3771 7.72717 29.5 8.02391 29.5 8.33333V28.3333C29.5 28.6428 29.3771 28.9395 29.1583 29.1583C28.9395 29.3771 28.6428 29.5 28.3333 29.5H13.3333C13.0239 29.5 12.7272 29.3771 12.5084 29.1583C12.2896 28.9395 12.1667 28.6428 12.1667 28.3333C12.1667 28.0239 12.2896 27.7272 12.5084 27.5084C12.7272 27.2896 13.0239 27.1667 13.3333 27.1667H26.6667H27.1667V26.6667V18.3333V17.8333H26.6667H20H19.5V18.3333V20C19.5 20.3094 19.3771 20.6062 19.1583 20.825C18.9395 21.0438 18.6428 21.1667 18.3333 21.1667H11.6667C11.3572 21.1667 11.0605 21.0438 10.8417 20.825C10.6229 20.6062 10.5 20.3094 10.5 20V18.3333V17.8333H10H3.33333H2.83333V18.3333V26.6667V27.1667H3.33333H6.66667C6.97609 27.1667 7.27283 27.2896 7.49162 27.5084C7.71042 27.7272 7.83333 28.0239 7.83333 28.3333C7.83333 28.6428 7.71042 28.9395 7.49162 29.1583C7.27283 29.3771 6.97609 29.5 6.66667 29.5H1.66667C1.35725 29.5 1.0605 29.3771 0.841709 29.1583C0.622917 28.9395 0.5 28.6428 0.5 28.3333V8.33333C0.5 8.02391 0.622916 7.72717 0.841709 7.50838C1.0605 7.28958 1.35725 7.16667 1.66667 7.16667H6.66667H7.16667V6.66667V1.66667C7.16667 1.35725 7.28958 1.0605 7.50838 0.841709C7.72717 0.622916 8.02391 0.5 8.33333 0.5H21.6667C21.9761 0.5 22.2728 0.622916 22.4916 0.841709C22.7104 1.0605 22.8333 1.35725 22.8333 1.66667V6.66667ZM10 2.83333H9.5V3.33333V6.66667V7.16667H10H20H20.5V6.66667V3.33333V2.83333H20H10ZM16.6667 18.8333H17.1667V18.3333V15V14.5H16.6667H13.3333H12.8333V15V18.3333V18.8333H13.3333H16.6667ZM19.5 15V15.5H20H26.6667H27.1667V15V10V9.5H26.6667H3.33333H2.83333V10V15V15.5H3.33333H10H10.5V15V13.3333C10.5 13.0239 10.6229 12.7272 10.8417 12.5084C11.0605 12.2896 11.3572 12.1667 11.6667 12.1667H18.3333C18.6428 12.1667 18.9395 12.2896 19.1583 12.5084C19.3771 12.7272 19.5 13.0239 19.5 13.3333V15Z" fill="var(--primary)" stroke=""></path>
                                            </svg>
                                        </span>
                                        <div class="media-body">
                                            <p class="mb-1">Completed Subject</p>
                                            <h4 class="mb-0">  <?php $sum = 0; ?>
                                                @foreach ($CompletedBatches as $item)
                                                    <?php $sum += $item->show_batches_count ?>
                                                @endforeach 
                                                {{ $sum < 10 ? "0".$sum : $sum }}
                                            </h4>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                          
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter2">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Size Image</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal">
          </button>
        </div>
        <form id="form">
          <div class="modal-body pb-2">
            @csrf
            <img src="/images/resize-img.jpg" id="image-preview" class="img-fluid w-100">
            <input type="file" name="image" id="image-input" class="form-control mb-3" accept="image/*">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success btn-sm" id="uploadIMg"><i class="fa-solid fa-crop-simple"></i>
              Crop Image</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(document).ready(function() {
    $('.states_choose').on('change', function(e) {
      var id = $(this).data('id');
      $value = $(this).val();
      console.log($value);
      $.ajax({
        url: '{{ url("/fetch-city-student")}}',
        type: 'post',
        data: {
          _token: '{{csrf_token()}}',
          state: $value
        },
        dataType: 'json',
        success: function(respond) {
          $y = 1;
          $htmlView = "";
          if (respond['city'].length > 0) {
            $htmlView += '<option value="">Select A City</option>';
            for (let i = 0; i < respond['city'].length; i++) {
              $htmlView += `<option value="${respond['city'][i].id}">${respond['city'][i].name}</option>`;
            }
            $(".courseBatch" + id).html($htmlView);
          } else {
            $(".courseBatch" + id).html(`<label class="form-label">Select Course<span class="text-danger">*</span></label>
                        <select name="course" id="course" class="form-control">
                            <option value="" selected >Not Found</option>
                        </select>`);
          }
        }
      });
    });
  });
</script>
<script>
    $(document).ready(function() {
      var preview;
      var index = 0;
      $('.model_open').on('click', function() {
        $width = $(this).data("width");
        $height = $(this).data("height");
        index = $(this).data("index");
        $outerWidth = $width + 20;
        $outerHeight = $height + 20;
        $('.cr-boundary').hide('');
        $('.cr-slider-wrap').hide('');
        preview = new Croppie($('#image-preview')['0'], {
          boundary: {
            width: $outerWidth,
            height: $outerHeight
          },
          viewport: {
            width: $width,
            height: $height,
            type: 'rectangle'
          },
        });
      });
      $('#image-input').on('change', function check(e) {
        var file = e.target.files[0];
        var reader = new FileReader();
        reader.onload = function() {
          var base64data = reader.result;
          $('.base64-image' + index).val(base64data);
          preview.bind({
            url: base64data
          }).then(function() {
            console.log('Croppie bind complete');
          });
        }
        reader.readAsDataURL(file);
      });
      $('#uploadIMg').on('click', function duck(e) {
        e.preventDefault();
        preview.result('base64').then(function(result) {
          $('.base64-image' + index).val(result);
          console.log(index);
          $('.result_image' + index).find('img').attr('src', result);
        });
        $(function() {
          $('#exampleModalCenter2').modal('toggle');
        });
      });
    });
  </script>
@endsection