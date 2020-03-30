@extends('template')
@section('nav')
<ul class="navigation-menu">
  <li class="nav-category-divider">MAIN</li>
  <li>
    <a href="{{ url('/dashboard') }}">
      <span class="link-title">Dashboard</span>
      <i class="mdi mdi-gauge link-icon"></i>
    </a>
  </li>
  @if(auth()->user()->role == 'admin')
  <li>
    <a href="#managedata" data-toggle="collapse" aria-expanded="false">
      <span class="link-title">Manage Data</span>
      <i class="mdi mdi-format-list-bulleted link-icon"></i>
    </a>
    <ul class="collapse navigation-submenu" id="managedata">
      <li>
        <a href="{{ url('/account_management') }}">Manage Account</a>
      </li>
      <li>
        <a href="{{ url('/machine_management') }}">Manage Machine</a>
      </li>
      <li>
        <a href="{{ url('/other_manage') }}">Other</a>
      </li>
    </ul>
  </li>
  <li>
    <a href="#allworkorder" data-toggle="collapse" aria-expanded="false">
      <span class="link-title">Work Order</span>
      <i class="mdi mdi-library-books link-icon"></i>
    </a>
    <ul class="collapse navigation-submenu" id="allworkorder">
      <li>
        <a href="{{ url('/routine_schedule') }}">Routine Schedule</a>
      </li>
      <li>
        <a href="{{ url('/routine_schedule_list') }}">Routine Schedule List</a>
      </li>
      <li>
        <a href="{{ url('/repair_machine') }}">Repair Machine</a>
      </li>
      <li>
        <a href="{{ url('/my_work_list') }}">My Work List</a>
      </li>
    </ul>
  </li>
  <li>
    <a href="{{ url('/report') }}">
      <span class="link-title">Report</span>
      <i class="mdi mdi-file-document-box link-icon"></i>
    </a>
  </li>
  @endif
  @if(auth()->user()->role == 'supervisor')
  <li>
    <a href="#allworkorder" data-toggle="collapse" aria-expanded="false">
      <span class="link-title">Work Order</span>
      <i class="mdi mdi-library-books link-icon"></i>
    </a>
    <ul class="collapse navigation-submenu" id="allworkorder">
      <li>
        <a href="{{ url('/routine_schedule') }}">Routine Schedule</a>
      </li>
      <li>
        <a href="{{ url('/routine_schedule_list') }}">Routine Schedule List</a>
      </li>
      <li>
        <a href="{{ url('/repair_machine') }}">Repair Machine</a>
      </li>
      <li>
        <a href="{{ url('/my_work_list') }}">My Work List</a>
      </li>
    </ul>
  </li>
  <li>
    <a href="{{ url('/report') }}">
      <span class="link-title">Report</span>
      <i class="mdi mdi-file-document-box link-icon"></i>
    </a>
  </li>
  @endif
  @if(auth()->user()->role == 'user')
  <li>
    <a href="#allworkorder" data-toggle="collapse" aria-expanded="false">
      <span class="link-title">Work Order</span>
      <i class="mdi mdi-library-books link-icon"></i>
    </a>
    <ul class="collapse navigation-submenu" id="allworkorder">
      <li>
        <a href="{{ url('/routine_schedule') }}">Routine Schedule</a>
      </li>
      <li>
        <a href="{{ url('/routine_schedule_list') }}">Routine Schedule List</a>
      </li>
      <li>
        <a href="{{ url('/repair_machine') }}">Repair Machine</a>
      </li>
    </ul>
  </li>
  <li>
    <a href="{{ url('/report') }}">
      <span class="link-title">Report</span>
      <i class="mdi mdi-file-document-box link-icon"></i>
    </a>
  </li>
  @endif
</ul>
@endsection
@section('content')
<div class="viewport-header">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb has-arrow">
      <li class="breadcrumb-item">
        <a href="{{ url('/dashboard') }}">Dashboard</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">Setting Profile</li>
    </ol>
  </nav>
</div>
<div class="content-viewport">
  <div class="row">
    <div class="col-lg-12">
      <div class="grid">
        <p class="grid-header">Setting Profile</p>
        <div class="grid-body">
          <div class="item-wrapper">
            <form action="{{ url('/update_profile/'.auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
              <div class="row mb-3">
                <div class="col-md-8">
                  @if ($message = Session::get('failed'))
                    <div class="col-12 text-center mb-4">
                      <div class="btn btn-outline-primary" style="color: #696ffb; background-color: #fff;">
                        {{ $message }}
                      </div>
                    </div>
                  @endif
                  @csrf
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                      <label for="Name">Name</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="text" class="form-control" id="Name" name="name" value="{{ auth()->user()->name }}" required="">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                      <label for="Username">Username</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="text" class="form-control" id="Username" name="username" value="{{ auth()->user()->username }}" required="">
                    </div>
                  </div>
                  <!-- <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                      <label for="Password">Password</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="password" class="form-control" id="Password" name="password" value="" required="">
                    </div>
                  </div> -->
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                      <label for="Role">Role</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <select class="custom-select" required="" name="role" disabled="">
                        <option value="">-- Select Role --</option>
                        @if(auth()->user()->role == 'admin')
                        <option value="admin" selected="">Admin</option>
                        <option value="supervisor">Supervisor</option>
                        @elseif(auth()->user()->role == 'supervisor')
                        <option value="admin">Admin</option>
                        <option value="supervisor" selected="">Supervisor</option>
                        @endif
                      </select>
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                    </div>
                    <div class="col-md-9 showcase_content_area"><br>
                      <button type="submit" class="btn btn-sm btn-primary float-right">Update Account</button>
                    </div>
                    
                  </div>
                </div>
                <div class="col-md-4 mx-auto sidebar" style="min-height: 0px; margin-top: -80px;">
                    <div class="user-profile ">
                        <div class="display-avatar animated-avatar">
                          <img id="preview_gambar" class="profile-img rounded-circle" style="width: 100px; height: 100px; background-color: #fff;" src="{{ asset('picture/'. auth()->user()->avatar) }}" alt="profile image">
                        </div>
                        <div class="info-wrapper">
                            <style>
                                .hover:hover{
                                    cursor: pointer;
                                }
                            </style>
                            <label for="avatar" class="hover btn btn-primary btn-xs text-center mdi mdi-camera border-0" style="margin-top:-10%; position: relative;background-color: #21D4FD; background-image: linear-gradient(19deg, #21D4FD 0%, #696ffb 100%); font-size: 14px;">
                            </label><br>
                          <a href="{{ url('/delete_profile_pict') }}" class="btn btn-warning btn-xs">Delete Picture</a>
                        </div>
                      </div>
                </div>
                <input type="file" class="uploads" id="avatar" name="avatar" hidden  onchange="readURL(this);">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="content-viewport">
  <div class="row">
    <div class="col-lg-12">
      <div class="grid">
        <p class="grid-header" style="border-left-color: #4CCEAC;">Change Password</p>
        <div class="grid-body">
          <div class="item-wrapper">
            <form action="{{ url('/change_password/'.auth()->user()->id) }}" method="POST">
              <div class="row mb-3">
                <div class="col-md-4 text-center mt-4 mb-4">
                  <img src="{{ asset('icons/undraw_Security_on_ff2u.svg') }}" style="width: 200px;">
                </div>
                <div class="col-md-8">
                  @if ($message = Session::get('failed_pass'))
                    <div class="col-12 text-center mb-4">
                      <div class="btn btn-outline-success" style="color: #4CCEAC; background-color: #fff;">
                        {{ $message }}
                      </div>
                    </div>
                  @endif
                  @csrf
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                      <label for="old_password">Old Password</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="password" class="form-control" id="old_password" name="old_password" value="" required="" placeholder="********">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                      <label for="new_password">New Password</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="password" class="form-control" id="new_password" name="new_password" value="" required="" placeholder="********">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                    </div>
                    <div class="col-md-9 showcase_content_area"><br>
                      <button type="submit" class="btn btn-sm btn-success float-right">Change Password</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script src="{{ asset('assets/vendors/js/vendor.addons.js') }}"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
@if ($message = Session::get('changed'))
Swal.fire({
  icon: 'success',
  text: '{{ $message }}',
  showConfirmButton: false,
  timer: 1500
})
@endif

@if ($message = Session::get('changed_pass'))
Swal.fire({
  icon: 'success',
  text: '{{ $message }}',
  showConfirmButton: false,
  timer: 1500
})
@endif

function readURL(input) { // Mulai membaca inputan gambar
    if (input.files && input.files[0]) {
    var reader = new FileReader(); // Membuat variabel reader untuk API FileReader

    reader.onload = function (e) { // Mulai pembacaan file
    $('#preview_gambar') // Tampilkan gambar yang dibaca ke area id #preview_gambar
    .attr('src', e.target.result)
    .width(100); // Menentukan lebar gambar preview (dalam pixel)
    //.height(200); // Jika ingin menentukan lebar gambar silahkan aktifkan perintah pada baris ini
  };

  reader.readAsDataURL(input.files[0]);
  }
}
</script>
@endsection