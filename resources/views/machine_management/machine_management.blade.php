@extends('template')
@section('css')
<style type="text/css">
  .menu-drop:hover{
    color: #696ffb;
  }
  
  @media only screen
  and (max-width : 770px) {
    .add-lane{
      margin-top: 20px;
    }
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
      <li class="breadcrumb-item active" aria-current="page">Manage Machine</li>
    </ol>
  </nav>
</div>
<div class="content-viewport">
  <div class="row">
    <div class="modal fade" id="addMachine" tabindex="-1" role="dialog" aria-labelledby="addMachineLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form method="POST" action="{{ url('/save_machine') }}" id="add_modal">
          <div class="modal-content">
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <button type="button" class="close mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="col-lg-12 text-center mt-4">
                  <img src="{{ asset('icons/undraw_elements_cipa.svg') }}" style="width: 150px;">
                  <h6 class="mt-4">Add Machine</h6>
                </div>
                @csrf
                <div class="col-lg-12 mt-4 mb-4">
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="code">Code</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="text" class="form-control" id="code" name="code" value="{{ $max_code }}" required="" readonly="">
                    </div>
                  </div>
                  <div class="row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="lane">Lane</label>
                    </div>
                    <div class="col-md-7 showcase_content_area">
                      <select class="custom-select lane-select" required="" name="lane">

                      </select>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 showcase_content_area add-lane">
                      <button class="btn btn-primary btn-sm btn-block" data-dismiss="modal" data-toggle="modal" data-target="#addLane" type="button"><i class="mdi mdi-library-plus"></i></button>
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="machine">Machine</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="text" class="form-control" id="machine" name="machine" value="" required="" placeholder="Ex : Flow Wrap">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="brand">Brand</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="text" class="form-control" id="brand" name="brand" value="" required="" placeholder="Ex : Tokiwa">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="capacity">Capacity</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="number" class="form-control" id="capacity" name="capacity" value="" required="" placeholder="Ex : 900">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="production_year">Production Year</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <select class="custom-select production_year" name="production_year" id="production_year" required="">
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary btn-block">Add Machine</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="modal fade" id="editMachine" tabindex="-1" role="dialog" aria-labelledby="editMachineLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form method="POST" id="update_machine">
          <div class="modal-content">
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <button type="button" class="close mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="col-lg-12 text-center mt-4">
                  <img src="{{ asset('icons/undraw_convert_2gjv.svg') }}" style="width: 150px;">
                  <h6 class="mt-4">Edit Machine</h6>
                </div>
                @csrf
                <div class="col-lg-12 mt-4 mb-4">
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="edit_code">Code</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="text" name="" class="id_machine" id="id_machine" hidden="">
                      <input type="text" class="form-control" id="edit_code" name="code" value="" required="" readonly="">
                    </div>
                  </div>
                  <div class="row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="edit_lane">Lane</label>
                    </div>
                    <div class="col-md-7 showcase_content_area">
                      <select class="custom-select lane-select" required="" name="lane" id="edit_lane">
                        
                      </select>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 showcase_content_area add-lane">
                      <button class="btn btn-primary btn-sm btn-block" data-dismiss="modal" data-toggle="modal" data-target="#addLane" type="button"><i class="mdi mdi-library-plus"></i></button>
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="edit_machine">Machine</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="text" class="form-control" id="edit_machine" name="machine" value="" required="">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="edit_brand">Brand</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="text" class="form-control" id="edit_brand" name="brand" value="" required="">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="edit_capacity">Capacity</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="number" class="form-control" id="edit_capacity" name="capacity" value="" required="">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="edit_production_year">Production Year</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <select class="custom-select production_year" name="production_year" id="edit_production_year" required="">
                      </select>
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
    <div class="modal fade" id="addLane" tabindex="-1" role="dialog" aria-labelledby="addLaneLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form method="POST" id="add_lane">
          <div class="modal-content">
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <button type="button" class="close mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="col-lg-12 text-center mt-4">
                  <img src="{{ asset('icons/undraw_convert_2gjv.svg') }}" style="width: 150px;">
                  <h6 class="mt-4">List Lane</h6>
                </div>
                @csrf
                <div class="col-lg-12 mt-4 mb-4">
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-12 showcase_content_area">
                      <ul class="list-group lane-list">
                        
                      </ul>
                    </div>
                    <div class="col-md-12 showcase_content_area mt-4">
                      <input type="text" class="form-control" placeholder="Type new Lane" id="input_lane" autocomplete="off" name="lane" value="" required="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary btn-block">Add Lane</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="grid">
       <a href="#" class="btn-hover" role="button" data-toggle="modal" data-target="#addMachine">
        <div class="btn btn-primary has-icon row float-right border-0" style="margin:8px 10px 0px 10px;">
          <i class="mdi mdi-shape-square-plus"></i>Add Machine</div>
       </a>
        <p class="grid-header">Manage Machine</p>
        <div class="item-wrapper">
          <div class="form-group row showcase_row_area">
            <div class="col-lg-12 pr-4 pl-4 showcase_content_area">
              <input type="text" class="form-control machine-search" value="" placeholder="Search Machine">
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Code</th>
                  <th>Lane</th>
                  <th>Machine</th>
                  <th>Brand</th>
                  <th>Capacity</th>
                  <th>Production Year</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="table-content">
                @foreach($machines as $machine)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $machine->machine_code }}</td>
                    <td>{{ $machine->lane_name }}</td>
                    <td>{{ $machine->machine_name }}</td>
                    <td>{{ $machine->brand }}</td>
                    <td>{{ $machine->capacity }}</td>
                    <td>{{ $machine->production_year }}</td>
                    <td class="actions">
                      <div class="dropdown">
                        <a href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-boundary="window">
                          <i class="mdi mdi-dots-vertical mdi-1x"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                          <a class="dropdown-item menu-drop edit-btn" role="button" data-toggle="modal" data-target="#editMachine" href="" id="{{ $machine->id }}"><i class="mdi mdi-tooltip-edit"></i>Edit</a>
                          <a class="dropdown-item menu-drop delete-btn" href="{{ url('delete_machine/'.$machine->id) }}"><i class="mdi mdi-delete-sweep"></i>Delete</a>
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
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script type="text/javascript">
// var keycode;
// $('#input_lane').keypress(function (event) {
//    keycode = (event.charCode) ? event.charCode : ((event.which) ? event.which : event.keyCode);
//    if (keycode == 32) {
//     Swal.fire({
//       icon: 'error',
//       text: 'Lane writing should not be followed by spaces, Please use underline to change spaces',
//       showConfirmButton: false,
//       timer: 1500
//     })
//     return false
//   };
// });

function loadLaneList(){
  $.ajax({
    url: "{{ url('/lane_list') }}",
    success:function(data){
      $('.lane-list').html(data);
    }
  });
}

loadLaneList();

function loadLaneSelect(){
  $.ajax({
    url: "{{ url('/lane_select') }}",
    success:function(data){
      $('.lane-select').html(data);
    }
  });
}

loadLaneSelect();

function successAddLane(){
  Swal.fire({
    icon: 'success',
    text: 'Lane successfully added!',
    showConfirmButton: false,
    timer: 1500
  })
}

function successDeleteLane(){
  Swal.fire({
    icon: 'success',
    text: 'Lane successfully deleted!',
    showConfirmButton: false,
    timer: 1500
  })
}

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

$('#add_lane').submit(function(e){
  e.preventDefault();
  var request = new FormData(this);
  $.ajax({
    url: "{{ url('/save_lane') }}",
    method: "POST",
    data: request,
    contentType: false,
    processData: false,
    success:function(data){
      if(data == 'added'){
        $('#input_lane').val('');
        successAddLane();
        loadLaneList();
        loadLaneSelect();
      }
    }
  });
});

$(document).on('click', '.delete-lane', function(e){
  e.preventDefault();
  var id_lane = $(this).attr('id');
  $.ajax({
    url: "{{ url('delete_lane') }}/" + id_lane,
    method: "GET",
    success:function(data){
      if(data == "deleted"){
        successDeleteLane();
        loadLaneList();
        loadLaneSelect();
      }
    } 
  }); 
});

$('#update_machine').submit(function(e){
  e.preventDefault();
  var id = $('#id_machine').val();
  var request = new FormData(this);
  $.ajax({
    url: "{{ url('update_machine') }}/" + id,
    method: "POST",
    data: request,
    contentType: false,
    processData: false,
    success:function(data){
      if(data == 'success'){
        window.location = "{{ url('/machine_management') }}";
      }
    }
  });
});

$(document).on('click', '.edit-btn', function(e) {
  e.preventDefault();
  var id = $(this).attr('id');
  $.ajax({
    url: "{{ url('edit_machine') }}/" + id,
    method: "GET",
    success:function(response){
      $('.id_machine').val(response.id);
      $('#edit_code').val(response.machine_code);
      $('#edit_machine').val(response.machine_name);
      $('.'+response.lane+'').prop('selected', true);
      $('.'+response.production_year+'').prop('selected', true);
      $('#edit_capacity').val(response.capacity);
      $('#edit_brand').val(response.brand);
    }
  });
});

$(document).ready(function(){
  $('.machine-search').on('keyup', function(){
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

$(function() {
  var start_year = new Date().getFullYear();

  for (var i = start_year; i > start_year - 30; i--) {
    $('.production_year').append('<option value="' + i + '" class="' + i + '">' + i + '</option>');
  }
});
</script>
@endsection