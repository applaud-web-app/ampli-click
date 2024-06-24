@extends('layouts.master')
@section('title','Add Learner')
@section('content')
<div class="content-body">
  <div class="container-fluid">
    <form action="/add-student" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-xl-12">
          <div class="card h-auto">
            <div class="card-header">
              <h5 class="mb-0 card-title">Add Learner Details</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-xl-2 col-lg-3 text-center">
                  <label class="form-label">Photo</label>
                  <div class="result_image0">
                    <img src="{{asset('images/no-img-avatar.png')}}" class="img-thumbnail" width="auto" height="120px" alt="">
                    <button type="button" class="model_open mt-3 mb-0 btn btn-primary btn-sm" data-width="192"
                      data-height="192" data-index="0" data-bs-toggle="modal"
                      data-bs-target="#exampleModalCenter2">Choose File</button>
                  </div>
                  <input type="hidden" class="base64-image0" name="image" value="{{old('image')}}">
                  @error('image') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="col-xl-10 col-lg-9">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                      <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">First Name<span
                            class="required">*</span></label>
                        <input type="text" name="fname" class="form-control" id="exampleFormControlInput1"
                          placeholder="First Name" value="{{old('fname')}}" required>
                        <span class="text-danger"> @error('fname') <div class="alert alert-danger">{{ $message }}</div>
                          @enderror</span>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                      <div class="mb-3">
                        <label for="exampleFormControlInput4" class="form-label">Last Name</label>
                        <input type="text" name="lname" class="form-control" id="exampleFormControlInput4"
                          placeholder="Last Name" value="{{old('lname')}}">
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                      <div class="mb-3">
                        <label for="exampleFormControlUsername" class="form-label">Username<span
                            class="required">*</span></label>
                        <input type="text" name="username" class="form-control" id="exampleFormControlUsername"
                          placeholder="Username" value="{{old('username')}}" required>
                        <span class="text-danger"> @error('username') <div class="alert alert-danger">{{ $message }}
                          </div> @enderror</span>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                      <div class="mb-3">
                        <label class="form-label">Date of Birth</label>
                        <div class="d-flex">
                          <input type="date" name="dob" value="{{old('dob')}}" class="form-control"
                            placeholder="2017-06-04" id="datepicker">
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                      <div class="mb-3">
                        <label for="exampleFormControlInput7" class="form-label">Phone Number<span
                            class="required">*</span></label>
                        <input type="text" name="mobile" class="form-control" id="exampleFormControlInput7"
                          placeholder="Phone Number" value="{{old('mobile')}}" required maxlength="10"
                          pattern="[1-9]{1}[0-9]{9}">
                        <span class="text-danger"> @error('mobile') <div class="alert alert-danger">{{ $message }}</div>
                          @enderror</span>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                      <div class="mb-3">
                        <label for="exampleFormControlInput3" class="form-label">Email Id <span
                            class="text-danger">*</span></label>
                        <input type="email" class="form-control" value="{{old('email')}}" name="email"
                          id="exampleFormControlInput3" placeholder="Email Id" required>
                        @error('email') <span class="text-danger">{{$message}}</span> @enderror
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                      <div class="mb-3">
                        <label for="exampleFormControlpass" class="form-label">Password<span
                            class="required">*</span></label>
                        <input type="password" class="form-control" name="password" id="exampleFormControlpass"
                          placeholder="Password" required>
                        <span class="text-danger"> @error('password') <div class="alert alert-danger">{{ $message }}
                          </div> @enderror</span>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                      <div class="mb-3">
                        <label for="exampleFormControldevice" class="form-label">Allowed Device<span
                            class="required">*</span></label>
                        <select name="allowed_device" class="form-control" id="exampleFormControldevice"
                          placeholder="Allowed Device" value="{{old('allowed_device')}}" required>
                          @for ($i = 1; $i <= 20; $i++)
                            <option value="{{$i}}">{{$i}}</option>                              
                          @endfor
                        </select>
                        <span class="text-danger"> @error('allowed_device') <div class="alert alert-danger">
                            {{ $message }}</div> @enderror</span>
                      </div>
                    </div>
                    <div class="col-sm-4 m-b30">
                      <label class="form-label">Gender<span class="required">*</span></label>
                      <div class="mb-3 mb-0">
                        <div class="form-check custom-checkbox d-inline-block mb-2 checkbox-primary">
                          <input type="radio" class="form-check-input" id="customRadioBox7" value="1" name="gender"
                            required>
                          <label class="form-check-label" for="customRadioBox7">Male</label>
                        </div>
                        <div class="form-check custom-checkbox d-inline-block mb-2 mx-2 checkbox-primary">
                          <input type="radio" class="form-check-input" id="customRadioBox8" value="2" name="gender"
                            required>
                          <label class="form-check-label" for="customRadioBox8">Female</label>
                        </div>
                        <div class="form-check custom-checkbox d-inline-block mb-2 checkbox-primary">
                          <input type="radio" class="form-check-input" id="customRadioBox9" value="3" name="gender"
                            required>
                          <label class="form-check-label" for="customRadioBox9">other</label>
                        </div>
                      </div>
                      <span class="text-danger"> @error('gender') <div class="alert alert-danger">{{ $message }}</div>
                        @enderror</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-12">
        <div class="card h-auto">
          <div class="card-header">
            <h5 class="mb-0 card-title">KYC Details</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-12">
                <div class="mb-3">
                  <label for="exampleFormControlInput6" class="form-label">Aadhar Number<span
                      class="required">*</span></label>
                  <input type="number" class="form-control" name="aadhar" id="exampleFormControlInput6"
                    placeholder="Aadhar Number" value="{{old('aadhar')}}" required maxlength="12">
                </div>
              </div>
              <div class="col-lg-6 col-12 ">
                <label class="form-label">Aadhar Front-Side Image <span
                    class="text-danger">*</span></label>
                <div class="result_image1">
                  <img src="{{asset('images/upload-default.png')}}" class="img-fluid" width="auto" height="200px" alt=""><br>
                  <button type="button" class="model_open mt-3 mb-0 btn btn-primary btn-sm" data-width="325"
                    data-height="204" data-index="1" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2">Choose
                    File</button>
                </div>
                <input type="hidden" class="base64-image1" name="front_aadhar" value="{{old('front_aadhar')}}">
                @error('front_aadhar') <span class="text-danger">{{$message}}</span> @enderror
              </div>
              <div class="col-lg-6 col-12 ">
                <label class="form-label">Aadhar Back-Side Image <span class="text-danger">*</span></label>
                <div class="result_image2">
                  <img src="{{asset('images/upload-default.png')}}" class="img-fluid" width="auto" height="200px" alt=""><br>
                  <button type="button" class="model_open mt-3 mb-0 btn btn-primary btn-sm" data-width="325"
                    data-height="204" data-index="2" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2">Choose
                    File</button>
                </div>
                <input type="hidden" class="base64-image2" name="front_back" value="{{old('front_back')}}">
                @error('front_back') <span class="text-danger">{{$message}}</span> @enderror
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-12">
          <div class="card h-auto">
            <div class="card-header">
              <h5 class="mb-0 card-title">Permanent Address</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-xl-6 col-sm-6">
                  <div class="mb-3">
                    <label for="exampleFormControlCountry" class="form-label">State <span
                        class="text-danger">*</span></label>
                    <select name="state" class="default-select form-control wide states_choose" data-id="1"
                      value="{{old('state')}}" tabindex="null" required>
                      <option selected disabled>Select State</option>
                      @foreach ($states as $state)
                      <option value="{{$state->id}}">{{$state->name}}</option>
                      @endforeach
                    </select>
                    @error('state') <span class="text-danger">{{$message}}</span> @enderror
                  </div>
                </div>
                <div class="col-xl-6 col-sm-6">
                  <div class="mb-3">
                    <label for="exampleFormControlCountry" class="form-label">City <span
                        class="text-danger">*</span></label>
                    <select name="city" class="courseBatch1 default-select form-control wide city_choose"
                      value="{{old('city')}}" tabindex="null" required>
                      <option selected disabled>Select City</option>
                    </select>
                    @error('city') <span class="text-danger">{{$message}}</span> @enderror
                  </div>
                </div>
                <div class="col-xl-12 col-sm-12">
                  <div class="mb-3">
                    <label for="exampleFormControlTextarea2" class="form-label">Permanent Address<span
                        class="required">*</span></label>
                    <textarea class="form-control" name="address" id="exampleFormControlTextarea2" rows="6" required
                      placeholder="Enter Permanent Address">{{old('address')}}</textarea>
                    <span class="text-danger"> @error('address') <div class="alert alert-danger">{{ $message }}
                      </div> @enderror</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-12">
          <div class="card h-auto">
            <div class="card-header">
              <h5 class="mb-0 card-title">Local Address (Optional)</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-xl-6 col-sm-6">
                  <div class="mb-3">
                    <label for="exampleFormControlCountry" class="form-label">State</label>
                    <select name="local_state" class="default-select form-control wide states_choose" data-id="2"
                      value="{{old('local_state')}}" tabindex="null">
                      <option selected disabled>Select State</option>
                      @foreach ($states as $state)
                      <option value="{{$state->id}}">{{$state->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-xl-6 col-sm-6">
                  <div class="mb-3">
                    <label for="exampleFormControlCountry" class="form-label">City</label>
                    <select name="local_city" class="courseBatch2 default-select form-control wide city_choose"
                      value="{{old('local_city')}}" tabindex="null">
                      <option selected disabled>Select City</option>
                    </select>
                  </div>
                </div>
                <div class="col-xl-12 col-sm-12">
                  <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Local Address</label>
                    <textarea class="form-control" name="local_address" id="exampleFormControlTextarea1" rows="6"
                      placeholder="Enter Local Address">{{old('local_address')}}</textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-12">
          <div class="card h-auto">
            <div class="card-header">
              <h5 class="mb-0 card-title">Guardian Details (Optional)</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-xl-6 col-sm-6">
                  <div class="mb-3">
                    <label for="exampleFormControlInput8" class="form-label">First Name</label>
                    <input type="text" class="form-control" value="{{old('p_fname')}}" name="p_fname"
                      id="exampleFormControlInput8" placeholder="First Name">
                  </div>
                  <div class="mb-3">
                    <label for="exampleFormControlInput9" class="form-label">Email Id</label>
                    <input type="email" class="form-control" value="{{old('p_email')}}" name="p_email"
                      id="exampleFormControlInput9" placeholder="Email Id">
                  </div>
                </div>
                <div class="col-xl-6 col-sm-6">
                  <div class="mb-3">
                    <label for="exampleFormControlInput10" class="form-label">Last Name</label>
                    <input type="text" class="form-control" value="{{old('p_lname')}}" name="p_lname"
                      id="exampleFormControlInput10" placeholder="Last Name">
                  </div>
                  <div class="mb-3">
                    <label for="exampleFormControlInput11" class="form-label">Phone Number</label>
                    <input type="number" class="form-control" value="{{old('p_number')}}" name="p_number"
                      id="exampleFormControlInput11" placeholder="Phone Number">
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-end">
                <button class="btn btn-primary" type="submit">Save</button>
              </div>
            </div>
          </div>
        </div>
    </form>
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
        url: '{{ url("/fetch-city")}}',
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