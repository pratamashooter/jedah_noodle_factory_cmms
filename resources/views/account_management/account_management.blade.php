@extends('template')
@section('css')
<style type="text/css">
  .menu-drop:hover{
    color: #696ffb;
  }
</style>
@endsection
@section('nav')
<ul class="navigation-menu">
  <li class="nav-category-divider">MAIN</li>
  <li>
    <a href="{{ url('/dashboard') }}">
      <span class="link-title">Dashboard</span>
      <i class="mdi mdi-gauge link-icon"></i>
    </a>
  </li>
  <li>
    <a href="#managedata" data-toggle="collapse" aria-expanded="false">
      <span class="link-title" style="color: #4CCEAC;">Manage Data</span>
      <i class="mdi mdi-format-list-bulleted link-icon" style="color: #4CCEAC;"></i>
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
</ul>
@endsection
@section('content')
<div class="viewport-header">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb has-arrow">
      <li class="breadcrumb-item">
        <a href="{{ url('/dashboard') }}">Dashboard</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">Manage Account</li>
    </ol>
  </nav>
</div>
<div class="content-viewport">
  <div class="row">
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form method="POST" id="update_modal" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <button type="button" class="close mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="col-lg-12 text-center mt-4">
                  <img src="{{ asset('icons/undraw_account_490v.svg') }}" style="width: 150px;">
                  <h6 class="mt-4">Edit Account</h6>
                </div>
                @csrf
                <div class="col-lg-12 mt-4 mb-4">
                  <div class="row" id="username-alert" hidden="">
                    <div class="col-lg-12 col-md-12">
                      <div class="col-12 text-center mb-4">
                        <div class="btn btn-outline-danger" style="color: #DB504A; background-color: #fff;">
                          Username has been used
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="avatar">Picture</label>
                    </div>
                    <div class="col-md-9 showcase_content_area mb-1">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="avatar" name="avatar">
                        <label class="custom-file-label" for="avatar" id="file_name" style="overflow: hidden;">Choose picture</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="name">Name</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="text" class="form-control" id="id_user" value="" hidden="">
                      <input type="text" class="form-control" id="name" name="name" value="" required="">
                    </div>
                  </div>
                  <div class="row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label>Role</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <select class="custom-select" name="role" id="role" required="">
                        <option value="" id="select_role">-- Select Role --</option>
                        <option id="admin" value="admin">Admin</option>
                        <option id="supervisor" value="supervisor">Supervisor</option>
                        <option id="user" value="user">User</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="username">Username</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="text" class="form-control" id="username" name="username" value="" required="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="grid">
       <a href="{{ url('/add_account') }}" class="btn-hover">
        <div class="btn btn-primary has-icon row float-right border-0" style="margin:8px 10px 0px 10px;">
          <i class="mdi mdi-account-plus-outline"></i>Add Account</div>
       </a>
        <p class="grid-header">Manage Account</p>
        <div class="item-wrapper">
          <div class="form-group row showcase_row_area">
            <div class="col-lg-12 showcase_content_area pl-4 pr-4">
              <input type="text" class="form-control account-search" value="" placeholder="Search Account">
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Role</th>
                  <th>Username</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="table-content">
                @foreach($accounts as $account)
                  <tr>
                    <td class="d-flex align-items-center border-top-0">
                      <img class="profile-img img-sm img-rounded mr-2" src="{{ asset('picture/'.$account->avatar) }}" alt="profile image">
                      <span>{{ $account->name }}</span>
                    </td>
                    <td>{{ $account->role }}</td>
                    <td>{{ $account->username }}</td>
                    <td class="actions">
                      <div class="dropdown">
                        <a href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-boundary="window">
                          <i class="mdi mdi-dots-vertical mdi-1x"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                          <a class="dropdown-item menu-drop edit-btn" role="button" data-toggle="modal" data-target="#editModal" href="" id="{{ $account->id }}"><i class="mdi mdi-tooltip-edit"></i>Edit</a>
                          @if($account->role == 'supervisor' || $account->role == 'user')
                          <a class="dropdown-item menu-drop delete-btn" href="{{ url('delete_account/' . $account->id) }}"><i class="mdi mdi-delete-sweep"></i>Delete</a>
                          @endif
                        </div>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script src="{{ asset('assets/vendors/js/vendor.addons.js') }}"></script>
<script type="text/javascript">

$(document).ready(function(){
  $('.account-search').on('keyup', function(){
    var searchTerm = $(this).val().toLowerCase();
    $("#table-content tr").each(function(){
      var lineStr = $(this).text().toLowerCase();
      if(lineStr.indexOf(searchTerm) == -1){
        $(this).hide();
      }else{
        $(this).show();
      }
    });
  });
});

@if ($message = Session::get('added'))
Swal.fire({
  icon: 'success',
  text: '{{ $message }}',
  showConfirmButton: false,
  timer: 1500
})
@endif

@if ($message = Session::get('deleted'))
Swal.fire({
  icon: 'success',
  text: '{{ $message }}',
  showConfirmButton: false,
  timer: 1500
})
@endif

@if ($message = Session::get('updated'))
Swal.fire({
  icon: 'success',
  text: '{{ $message }}',
  showConfirmButton: false,
  timer: 1500
})
@endif

$(document).ready(function(){
    $('input[type="file"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('#file_name').html(fileName);
    });
});

$('#update_modal').submit(function(e){
  e.preventDefault();
  var id = $('#id_user').val();
  var request = new FormData(this);
  $.ajax({
    url: "{{ url('update_account') }}/" + id,
    method: "POST",
    data: request,
    contentType: false,
    processData: false,
    success:function(data){
      if(data == 'success'){
        window.location = "{{ url('/account_management') }}";
      }else if(data == 'failed'){
        $('#username-alert').prop('hidden', false);
      }
    }
  });
});

$(document).on('click', '.edit-btn', function(e) {
  e.preventDefault();
  var id = $(this).attr('id');
  $('#username-alert').prop('hidden', true);
  $.ajax({
    url: "{{ url('edit_account') }}/" + id,
    method: "GET",
    success:function(response){
      $('#id_user').val(response.id);
      $('#file_name').html(response.avatar);
      $('#name').val(response.name);
      if(response.role == 'admin'){
        $('#supervisor').prop('disabled', true);
        $('#user').prop('disabled', true);
        $('#select_role').prop('disabled', true);
      }else if(response.role == 'supervisor' || response.role == 'user'){
        $('#supervisor').prop('disabled', false);
        $('#user').prop('disabled', false);
        $('#select_role').prop('disabled', false);
      }
      $('#'+response.role+'').prop('selected', true);
      $('#username').val(response.username);
    }
  });
});
</script>
@endsection