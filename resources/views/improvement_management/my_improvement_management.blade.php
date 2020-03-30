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
      <span class="link-title" style="color: #4CCEAC;">Work Order</span>
      <i class="mdi mdi-library-books link-icon" style="color: #4CCEAC;"></i>
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
      <span class="link-title" style="color: #4CCEAC;">Work Order</span>
      <i class="mdi mdi-library-books link-icon" style="color: #4CCEAC;"></i>
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
</ul>
@endsection
@section('content')
<div class="viewport-header">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb has-arrow">
      <li class="breadcrumb-item">
        <a href="{{ url('/dashboard') }}">Dashboard</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ url('/repair_machine') }}">Repair Machine</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">My Repair Machine</li>
    </ol>
  </nav>
</div>
<div class="content-viewport">
  <div class="row">
    <div class="modal fade" id="addRepair" tabindex="-1" role="dialog" aria-labelledby="addRepairLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form method="POST" action="{{ url('/save_repair') }}" id="add_modal">
          <div class="modal-content">
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <button type="button" class="close mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="col-lg-12 text-center mt-4">
                  <img src="{{ asset('icons/undraw_bug_fixing_oc7a.svg') }}" style="width: 150px;">
                  <h6 class="mt-4">Add Repair Machine</h6>
                </div>
                @csrf
                <div class="col-lg-12 mt-4 mb-4">
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="repair_code">Code</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="text" class="form-control" id="repair_code" name="code" value="{{ $max_code }}" required="" readonly="">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="repair_date">Schedule Date</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="date" class="form-control repair_date" id="repair_date" name="repair_date" value="" required="">
                    </div>
                  </div>
                  <div class="row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="lane">Lane</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <select class="custom-select lane-select" required="" name="lane">
                        <option value="" id="default">-- Select Lane --</option>
                        @foreach($lanes as $lane)
                        <option value="{{ $lane->id }}">{{ $lane->lane }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="machine">Machine</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <select class="custom-select machine-select" required="" name="machine">

                      </select>
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="title">Point Check</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="text" class="form-control" id="title" name="title" value="" required="">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="description">Description</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <textarea class="form-control" id="description" cols="3" rows="3" name="description" autocomplete="off" required=""></textarea>
                    </div>
                  </div>
                  <div class="row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="status">Status</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <select class="custom-select" required="" name="status">
                        <option value="">-- Select Status --</option>
                        <option value="open">Open</option>
                        <option value="waiting">Waiting</option>
                        <option value="close">Close</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary btn-block">Save Repair</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="modal fade" id="editRepair" tabindex="-1" role="dialog" aria-labelledby="editRepairLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form method="POST" id="update_modal">
          <div class="modal-content">
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <button type="button" class="close mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="col-lg-12 text-center mt-4">
                  <img src="{{ asset('icons/undraw_bug_fixing_oc7a.svg') }}" style="width: 150px;">
                  <h6 class="mt-4">Edit Schedule</h6>
                </div>
                @csrf
                <div class="col-lg-12 mt-4 mb-4">
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="edit_repair_code">Code</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="text" class="id_repair" name="" hidden="">
                      <input type="text" class="form-control" id="edit_repair_code" name="code" value="" required="" readonly="">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="edit_repair_date">Schedule Date</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="date" class="form-control repair_date" id="edit_repair_date" name="repair_date" value="" required="">
                    </div>
                  </div>
                  <div class="row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="lane">Lane</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <select class="custom-select lane-select" required="" name="lane">
                        <option value="">-- Select Lane --</option>
                        @foreach($lanes as $lane)
                        <option value="{{ $lane->id }}" id="lane-{{ $lane->id }}">{{ $lane->lane }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="machine">Machine</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <select class="custom-select machine-select" required="" name="machine">

                      </select>
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="edit_title">Point Check</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="text" class="form-control" id="edit_title" name="title" value="" required="">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 ml-4 showcase_text_area">
                      <label for="edit_description">Description</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <textarea class="form-control" id="edit_description" cols="3" rows="3" name="description" autocomplete="off" required=""></textarea>
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-12 showcase_text_area text-center">
                      <p>Status can be changed directly in the table</p>
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
       <a href="#" role="button" data-toggle="modal" data-target="#addRepair" class="btn-hover btn-add">
        <div class="btn btn-primary has-icon row float-right border-0" style="margin:8px 10px 0px 10px;">
          <i class="mdi mdi-library-plus"></i>Add Repair Machine</div>
       </a>
        <p class="grid-header">My Repair Machine</p>
        <div class="item-wrapper">
          <div class="form-group row showcase_row_area">
            <div class="col-lg-12 showcase_content_area pl-4 pr-4">
              <input type="text" class="form-control repair-search" value="" placeholder="Search Repair">
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Repair Code</th>
                  <th>Repair Date</th>
                  <th>Lane</th>
                  <th>Machine</th>
                  <th>Point Check</th>
                  <th>Description</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="table-content">
                @foreach($repairs as $repair)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $repair->repair_code }}</td>
                    <td>{{ $repair->repair_date }}</td>
                    <td>{{ $repair->lane_name }}</td>
                    <td>{{ $repair->machines_name }}</td>
                    <td>{{ $repair->title }}</td>
                    <td>{{ $repair->description }}</td>
                    <td>
                      @if($repair->status == 'open')
                      <form method="POST" action="{{ url('update_status_repair/'.$repair->id) }}">
                        @csrf
                        <div class="dropdown">
                          <a href="#" class="btn btn-primary btn-block btn-xs" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-boundary="window">
                            {{ $repair->status }}
                          </a>
                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <input type="text" class="status-change" hidden="" name="status" value="">
                            <button class="dropdown-item menu-drop waiting-btn" type="submit">Waiting</button>
                            <button class="dropdown-item menu-drop close-btn" type="submit">Close</button>
                          </div>
                        </div>
                      </form>
                      @elseif($repair->status == 'waiting')
                      <form method="POST" action="{{ url('update_status_repair/'.$repair->id) }}">
                        @csrf
                        <div class="dropdown">
                          <a href="#" class="btn btn-warning btn-block btn-xs" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-boundary="window">
                            {{ $repair->status }}
                          </a>
                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <input type="text" class="status-change" hidden="" name="status" value="">
                            <button class="dropdown-item menu-drop open-btn" type="submit">Open</button>
                            <button class="dropdown-item menu-drop close-btn" type="submit">Close</button>
                          </div>
                        </div>
                      </form>
                      @elseif($repair->status == 'close')
                      <form method="POST" action="{{ url('update_status_repair/'.$repair->id) }}">
                        @csrf
                        <div class="dropdown">
                          <a href="#" class="btn btn-success btn-block btn-xs" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-boundary="window">
                            {{ $repair->status }}
                          </a>
                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <input type="text" class="status-change" hidden="" name="status" value="">
                            <button class="dropdown-item menu-drop open-btn" type="submit">Open</button>
                            <button class="dropdown-item menu-drop waiting-btn" type="submit">Waiting</button>
                          </div>
                        </div>
                      </form>
                      @endif
                    </td>
                    <td class="actions">
                      <div class="dropdown">
                        <a href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-boundary="window">
                          <i class="mdi mdi-dots-vertical mdi-1x"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                          <a class="dropdown-item menu-drop edit-btn" role="button" data-toggle="modal" data-target="#editRepair" href="" id="{{ $repair->id }}"><i class="mdi mdi-tooltip-edit"></i>Edit</a>
                          <a class="dropdown-item menu-drop delete-btn" href="{{ url('delete_repair/'. $repair->id ) }}"><i class="mdi mdi-delete-sweep"></i>Delete</a>
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
  $('.repair-search').on('keyup', function(){
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

$(document).on('click', '.waiting-btn', function() {
  $('.status-change').val('waiting');
});

$(document).on('click', '.open-btn', function() {
  $('.status-change').val('open');
});

$(document).on('click', '.close-btn', function() {
  $('.status-change').val('close');
});

@if ($message = Session::get('created'))
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

@if ($message = Session::get('status_updated'))
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

function loadLaneSelect(lanes){
  $.ajax({
    url: "{{ url('machine_select') }}/" + lanes,
    success:function(data){
      $('.machine-select').html(data);
    }
  });
}

$(document).on('click', '.btn-add', function(){
  $('#default').prop('selected', true);
  loadLaneSelect(0);
});

$('#update_modal').submit(function(e){
  e.preventDefault();
  var id = $('.id_repair').val();
  var request = new FormData(this);
  $.ajax({
    url: "{{ url('update_repair') }}/" + id,
    method: "POST",
    data: request,
    contentType: false,
    processData: false,
    success:function(data){
      if(data == 'success'){
        window.location = "{{ url('/my_repair_machine') }}";
      }
    }
  });
});


$(document).on('click', '.edit-btn', function(e) {
  e.preventDefault();
  var id = $(this).attr('id');
  $.ajax({
    url: "{{ url('edit_repair') }}/" + id,
    method: "GET",
    success:function(response){
      $('.id_repair').val(response.id);
      $('#edit_repair_code').val(response.repair_code);
      $('#edit_repair_date').val(response.repair_date);
      $('#edit_title').val(response.title);
      $('#edit_description').val(response.description);
      $('#lane-'+response.lane+'').prop('selected', true);
      loadLaneSelect(response.lane);
      $('#'+response.machine_name+'').prop('selected', true);
    }
  });
});

$(document).ready( function() {
  $('.lane-select').change(function() {
    if($(this).val() == ""){
      $('.machine-select').html("");
    }else{
      var lanes = $(this).val();
      $.ajax({
        url: "{{ url('machine_select') }}/" + lanes,
        success:function(data){
          $('.machine-select').html(data);
        }
      });
    }
  });
});
</script>
@endsection