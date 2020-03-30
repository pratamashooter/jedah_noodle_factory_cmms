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
        <a href="{{ url('/routine_schedule') }}">Routine Schedule</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">My Routine Schedule</li>
    </ol>
  </nav>
</div>
<div class="content-viewport">
  <div class="row">
    <div class="modal fade" id="addSchedule" tabindex="-1" role="dialog" aria-labelledby="addScheduleLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form method="POST" action="{{ url('/save_schedule') }}" id="add_modal">
          <div class="modal-content">
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <button type="button" class="close mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="col-lg-12 text-center mt-4">
                  <img src="{{ asset('icons/undraw_timeline_9u4u.svg') }}" style="width: 150px;">
                  <h6 class="mt-4">Add Schedule</h6>
                </div>
                @csrf
                <div class="col-lg-12 mt-4 mb-4">
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-3 ml-4 text-left">
                      <label for="schedule_code">Code</label>
                    </div>
                    <div class="col-md-8 showcase_content_area">
                      <input type="text" class="form-control" id="schedule_code" name="code" value="{{ $max_code }}" required="" readonly="">
                    </div>
                  </div>
                  <div class="row showcase_row_area">
                    <div class="col-md-3 ml-4 text-left">
                      <label for="lane">Lane</label>
                    </div>
                    <div class="col-md-8 showcase_content_area">
                      <select class="custom-select lane-select" required="" name="lane">
                        <option value="" id="default">-- Select Lane --</option>
                        @foreach($lanes as $lane)
                        <option value="{{ $lane->id }}">{{ $lane->lane }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-3 ml-4 text-left">
                      <label for="machine">Machine</label>
                    </div>
                    <div class="col-md-8 showcase_content_area">
                      <select class="custom-select machine-select" required="" name="machine">

                      </select>
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-3 ml-4 text-left">
                      <label for="point_check">Period Of Time</label>
                    </div>
                    <div class="col-md-5 showcase_content_area">
                      <select class="custom-select" required="" name="period">
                        <option value="">-- Period --</option>
                        <option value="week">Week</option>
                        <option value="month">Month</option>
                        <option value="year">Year</option>
                      </select>
                    </div>
                    <div class="col-md-3 showcase_content_area">
                      <input type="number" class="form-control" name="time" min="1" max="12" maxlength="2" required="" placeholder="Ex : 3">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-3 ml-4 text-left">
                      <label>Amount</label>
                    </div>
                    <div class="col-md-3 showcase_content_area">
                      <input type="number" class="form-control" name="amount" min="1" max="12" maxlength="2" required="" placeholder="Ex : 10">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary btn-block">Add Schedule</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="grid">
       <a href="#" role="button" data-toggle="modal" data-target="#addSchedule" class="btn-hover btn-add">
        <div class="btn btn-primary has-icon row float-right border-0" style="margin:8px 10px 0px 10px;">
          <i class="mdi mdi-calendar-plus"></i>Add Schedule</div>
       </a>
        <p class="grid-header">My Routine Schedule</p>
        <div class="item-wrapper">
          <div class="form-group row showcase_row_area">
            <div class="col-lg-12 showcase_content_area pl-4 pr-4">
              <input type="text" class="form-control schedule-search" value="" placeholder="Search Schedule">
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Schedule Code</th>
                  <th>Lane</th>
                  <th>Machine</th>
                  <th>Period Of Time</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="table-content">
                @foreach($schedules as $schedule)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $schedule->schedule_code }}</td>
                    <td>{{ $schedule->lane_name }}</td>
                    <td>{{ $schedule->machines_name }}</td>
                    <td>{{ $schedule->time }} {{ $schedule->period }}</td>
                    <td class="actions">
                      <a class="btn btn-xs btn-warning delete-btn" href="{{ url('delete_schedule/'. $schedule->id ) }}"><i class="mdi mdi-delete-sweep"></i>&nbsp; Delete</a>
                      <!-- <div class="dropdown">
                        <a href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-boundary="window">
                          <i class="mdi mdi-dots-vertical mdi-1x"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                          <a class="dropdown-item menu-drop edit-btn" role="button" data-toggle="modal" data-target="#editSchedule" href="" id="{{ $schedule->id }}"><i class="mdi mdi-tooltip-edit"></i>Edit</a>
                          <a class="dropdown-item menu-drop delete-btn" href="{{ url('delete_schedule/'. $schedule->id ) }}"><i class="mdi mdi-delete-sweep"></i>Delete</a>
                        </div>
                      </div> -->
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
  $('.schedule-search').on('keyup', function(){
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
  var id = $('.id_schedule').val();
  var request = new FormData(this);
  $.ajax({
    url: "{{ url('update_schedule') }}/" + id,
    method: "POST",
    data: request,
    contentType: false,
    processData: false,
    success:function(data){
      if(data == 'success'){
        window.location = "{{ url('/my_routine_schedule') }}";
      }
    }
  });
});


// $(document).on('click', '.edit-btn', function(e) {
//   e.preventDefault();
//   var id = $(this).attr('id');
//   $.ajax({
//     url: "{{ url('edit_schedule') }}/" + id,
//     method: "GET",
//     success:function(response){
//       $('.id_schedule').val(response.id);
//       $('#edit_schedule_code').val(response.schedule_code);
//       $('#lane-'+response.lane+'').prop('selected', true);
//       loadLaneSelect(response.lane);
//       $('#'+response.machine_name+'').prop('selected', true);
//       $('#time-input').val(response.time);
//       $('#'+response.period+'').prop('selected', true);
//     }
//   });
// });

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

$("[type='number']").keypress(function (evt) {
    evt.preventDefault();
});
</script>
@endsection