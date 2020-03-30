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
        <a href="{{ url('/routine_schedule_list') }}">Routine Schedule List</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">My Schedule List</li>
    </ol>
  </nav>
</div>
<div class="content-viewport">
  <div class="row">
    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="viewModalLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <table border="0" cellspacing="5" cellpadding="5">
                  <tr>
                    <td>Schedule Code</td>
                    <td>:</td>
                    <td id="schedule_code_v"></td>
                  </tr>
                  <tr>
                    <td>Scheduler</td>
                    <td>:</td>
                    <td id="scheduler_v"></td>
                  </tr>
                  <tr>
                    <td>Lane</td>
                    <td>:</td>
                    <td id="lane_v"></td>
                  </tr>
                </table>
              </div>
              <div class="col-md-6">
                <table border="0" cellspacing="5" cellpadding="5">
                  <tr>
                    <td>Machine</td>
                    <td>:</td>
                    <td id="machine_v"></td>
                  </tr>
                  <tr>
                    <td>Schedule Date</td>
                    <td>:</td>
                    <td id="schedule_date_v"></td>
                  </tr>
                  <tr>
                    <td>Status</td>
                    <td>:</td>
                    <td id="status_v"></td>
                  </tr>
                </table>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12">
                <p class="text-gray">Repair Process</p>
                  <div id="percent-status">
                    
                  </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12">
                <div class="grid">
                  <a href="#" class="btn-hover add-worker-btn">
                    <div class="btn btn-primary btn-sm row float-right border-0" style="margin:8px 10px 0px 10px;">
                      <i class="mdi mdi-plus-box"></i>
                    </div>
                   </a>
                   <a href="#" class="btn-hover close-worker-btn" hidden="">
                    <div class="btn btn-primary btn-sm row float-right border-0" style="margin:8px 10px 0px 10px;">
                      <i class="mdi mdi-close-box"></i>
                    </div>
                   </a>
                  <p class="grid-header">Work List</p>
                  <div class="item-wrapper">
                    <div id="add-worker" hidden="">
                      <form id="add-worker-form">
                        @csrf
                        <div class="form-row mb-3">
                          <div class="col-sm-6 mt-2">
                            <input class="schedule_inform" type="text" hidden="" name="schedule_list_code">
                            <select class="custom-select" required="" name="worker">
                              <option value="" id="empty-select">-- Select Worker --</option>
                              @foreach($users as $user)
                              <option value="{{ $user->id }}">{{ $user->name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-sm-6 mt-2">
                            <input type="text" class="form-control empty-input" placeholder="Point Check" required="" name="point_check">
                          </div>
                          <div class="col-sm-6 mt-2">
                            <input type="text" class="form-control empty-input" placeholder="Description" required="" name="description">
                          </div>
                          <div class="col-sm-6 mt-2">
                            <button type="submit" class="btn btn-primary btn-sm btn-block">Add Worker</button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Worker</th>
                            <th>Point Check</th>
                            <th>Description</th>
                            <th>Percent</th>
                            <th>Status Check</th>
                            <th>Comment</th>
                            <th>Date Check</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody id="table-work-list">
                          
                        </tbody>
                      </table>
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
  <div class="row">
    <div class="col-lg-12">
      <div class="grid">
        <p class="grid-header">My Schedule List</p>
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
                  <th>Schedule List Code</th>
                  <th>Schedule Code</th>
                  <th>Scheduler</th>
                  <th>Lane</th>
                  <th>Machine</th>
                  <th>Schedule Date</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="table-content">
                
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
$('.add-worker-btn').on('click', function(e){
  e.preventDefault();
  $('.add-worker-btn').prop('hidden', true);
  $('.close-worker-btn').prop('hidden', false);
  $('#add-worker').prop('hidden', false);
});

$('.close-worker-btn').on('click', function(e){
  e.preventDefault();
  $('.add-worker-btn').prop('hidden', false);
  $('.close-worker-btn').prop('hidden', true);
  $('#add-worker').prop('hidden', true);
});

function loadMyTableScheduleList(){
  $.ajax({
    url: "{{ url('/my_table_schedule_list') }}",
    success:function(data){
      $('#table-content').html(data);
    }
  });
}

loadMyTableScheduleList();

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

$(document).on('click', '.view-btn', function(e) {
  e.preventDefault();
  var id = $(this).attr('data-code');
  $.ajax({
    url: "{{ url('view_schedule_list') }}/" + id,
    method: "GET",
    success:function(response){
      var schedule_list_code = ''+response.schedule_list_code+'';
      $.ajax({
        url: "{{ url('/table_worker') }}/" + schedule_list_code,
        method: "GET",
        success:function(response){
          var isi_table = "";
          var ket_percent = "";
          var nilai_percent = response.workers_s / response.workers.length;
          if(nilai_percent < 100)
          {
            ket_percent += '<div class="d-flex justify-content-between text-muted mt-3"><small>Process</small> <small>'+Math.round(nilai_percent)+'% / 100%</small></div><div class="progress progress-slim mt-2"><div class="progress-bar bg-primary" role="progressbar" style="width: '+nilai_percent+'%" aria-valuenow="'+nilai_percent+'" aria-valuemin="0" aria-valuemax="100"></div></div>';
          }
          else if(nilai_percent == 100)
          {
            ket_percent += '<div class="d-flex justify-content-between text-muted mt-3"><small>Completed</small> <small>'+nilai_percent+'% / 100%</small></div><div class="progress progress-slim mt-2"><div class="progress-bar bg-success" role="progressbar" style="width: '+nilai_percent+'%" aria-valuenow="'+nilai_percent+'" aria-valuemin="0" aria-valuemax="100"></div></div>';
          }
          for(var i = 0; i<response.workers.length; i++){
            var no = i + 1;
            if(response.workers[i].percent < 100)
            {
              isi_table += '<tr><td>'+no+'</td><td>'+response.workers[i].user_name+'</td><td>'+response.workers[i].point_check+'</td><td>'+response.workers[i].description+'</td><td><div class="progress progress-slim"><div class="progress-bar bg-info progress-bar-striped" role="progressbar" style="width: '+response.workers[i].percent+'%" aria-valuenow="'+response.workers[i].percent+'" aria-valuemin="0" aria-valuemax="100"></div></div></td><td>'+response.workers[i].status_check+'</td><td>'+response.workers[i].comment+'</td><td>'+response.workers[i].date_check+'</td><td><a class="btn btn-danger btn-xs delete-worker-btn" data-delete="'+response.workers[i].id+'" href="#"><i class="mdi mdi-close-box-outline"></i></a></td></tr>';
            }
            else if(response.workers[i].percent == 100)
            {
              isi_table += '<tr><td>'+no+'</td><td>'+response.workers[i].user_name+'</td><td>'+response.workers[i].point_check+'</td><td>'+response.workers[i].description+'</td><td><div class="progress progress-slim"><div class="progress-bar bg-success progress-bar-striped" role="progressbar" style="width: '+response.workers[i].percent+'%" aria-valuenow="'+response.workers[i].percent+'" aria-valuemin="0" aria-valuemax="100"></div></div></td><td>'+response.workers[i].status_check+'</td><td>'+response.workers[i].comment+'</td><td>'+response.workers[i].date_check+'</td><td><a class="btn btn-danger btn-xs delete-worker-btn" data-delete="'+response.workers[i].id+'" href="#"><i class="mdi mdi-close-box-outline"></i></a></td></tr>';
            }
          }
          $('#percent-status').html(ket_percent);
          $('#table-work-list').html(isi_table);
        }
      });
      $('#viewModalLabel').html('List Code : ' + response.schedule_list_code);
      $('.schedule_inform').val(response.schedule_list_code);
      $('#schedule_code_v').html(response.schedule_code);
      $('#scheduler_v').html(response.user_name);
      $('#lane_v').html(response.lane_name);
      $('#machine_v').html(response.machines_name);
      $('#schedule_date_v').html(response.schedule_date);
      if(response.status == 'open'){
        $('#status_v').html('<div class="badge badge-primary">'+response.status+'</div>');
      }else if(response.status == 'waiting'){
        $('#status_v').html('<div class="badge badge-warning">'+response.status+'</div>');
      }else if(response.status == 'close'){
        $('#status_v').html('<div class="badge badge-success">'+response.status+'</div>');
      }
    }
  });
});

$(document).on('click', '.delete-worker-btn', function(e) {
  e.preventDefault();
  var id = $(this).attr('data-delete');
  $.ajax({
    url: "{{ url('/delete_worker') }}/" + id,
    method: "GET",
    success:function(response) {
      var schedule_list_code = ''+response.schedule_list_code+'';
      $.ajax({
        url: "{{ url('/table_worker') }}/" + schedule_list_code,
        method: "GET",
        success:function(response){
          var isi_table = "";
          var ket_percent = "";
          var nilai_percent = response.workers_s / response.workers.length;
          if(nilai_percent == 100)
          {
            ket_percent += '<div class="d-flex justify-content-between text-muted mt-3"><small>Completed</small> <small>'+nilai_percent+'% / 100%</small></div><div class="progress progress-slim mt-2"><div class="progress-bar bg-success" role="progressbar" style="width: '+nilai_percent+'%" aria-valuenow="'+nilai_percent+'" aria-valuemin="0" aria-valuemax="100"></div></div>';
            $.ajax({
              url: "{{ url('/update_status_list') }}/" + schedule_list_code + '/close',
              method: "GET",
              success:function(data){
                $('#status_v').html('<div class="badge badge-success">'+data+'</div>');
                loadMyTableScheduleList();
              }
            });
          }
          else if(nilai_percent == 0)
          {
            $.ajax({
              url: "{{ url('/update_status_list') }}/" + schedule_list_code + '/open',
              method: "GET",
              success:function(data){
                $('#status_v').html('<div class="badge badge-primary">'+data+'</div>');
                loadMyTableScheduleList();
              }
            });
          }
          else if(nilai_percent < 100)
          {
            ket_percent += '<div class="d-flex justify-content-between text-muted mt-3"><small>Process</small> <small>'+Math.round(nilai_percent)+'% / 100%</small></div><div class="progress progress-slim mt-2"><div class="progress-bar bg-primary" role="progressbar" style="width: '+nilai_percent+'%" aria-valuenow="'+nilai_percent+'" aria-valuemin="0" aria-valuemax="100"></div></div>';
            $.ajax({
              url: "{{ url('/update_status_list') }}/" + schedule_list_code + '/waiting',
              method: "GET",
              success:function(data){
                $('#status_v').html('<div class="badge badge-warning">'+data+'</div>');
                loadMyTableScheduleList();
              }
            });
          }
          for(var i = 0; i<response.workers.length; i++){
            var no = i + 1;
            if(response.workers[i].percent < 100)
            {
              isi_table += '<tr><td>'+no+'</td><td>'+response.workers[i].user_name+'</td><td>'+response.workers[i].point_check+'</td><td>'+response.workers[i].description+'</td><td><div class="progress progress-slim"><div class="progress-bar bg-info progress-bar-striped" role="progressbar" style="width: '+response.workers[i].percent+'%" aria-valuenow="'+response.workers[i].percent+'" aria-valuemin="0" aria-valuemax="100"></div></div></td><td>'+response.workers[i].status_check+'</td><td>'+response.workers[i].comment+'</td><td>'+response.workers[i].date_check+'</td><td><a class="btn btn-danger btn-xs delete-worker-btn" data-delete="'+response.workers[i].id+'" href="#"><i class="mdi mdi-close-box-outline"></i></a></td></tr>';
            }
            else if(response.workers[i].percent == 100)
            {
              isi_table += '<tr><td>'+no+'</td><td>'+response.workers[i].user_name+'</td><td>'+response.workers[i].point_check+'</td><td>'+response.workers[i].description+'</td><td><div class="progress progress-slim"><div class="progress-bar bg-success progress-bar-striped" role="progressbar" style="width: '+response.workers[i].percent+'%" aria-valuenow="'+response.workers[i].percent+'" aria-valuemin="0" aria-valuemax="100"></div></div></td><td>'+response.workers[i].status_check+'</td><td>'+response.workers[i].comment+'</td><td>'+response.workers[i].date_check+'</td><td><a class="btn btn-danger btn-xs delete-worker-btn" data-delete="'+response.workers[i].id+'" href="#"><i class="mdi mdi-close-box-outline"></i></a></td></tr>';
            }
          }
          $('#percent-status').html(ket_percent);
          $('#table-work-list').html(isi_table);
        }
      });
    }
  });
});

$('#add-worker-form').submit(function(e){
  e.preventDefault();
  var request = new FormData(this);
  $.ajax({
    url: "{{ url('/save_worker') }}",
    method: "POST",
    data: request,
    contentType: false,
    processData: false,
    success:function(data){
      var schedule_list_code = data;
      $.ajax({
        url: "{{ url('/table_worker') }}/" + schedule_list_code,
        method: "GET",
        success:function(response){
          var isi_table = "";
          var ket_percent = "";
          var nilai_percent = response.workers_s / response.workers.length;
          if(nilai_percent == 100)
          {
            ket_percent += '<div class="d-flex justify-content-between text-muted mt-3"><small>Completed</small> <small>'+nilai_percent+'% / 100%</small></div><div class="progress progress-slim mt-2"><div class="progress-bar bg-success" role="progressbar" style="width: '+nilai_percent+'%" aria-valuenow="'+nilai_percent+'" aria-valuemin="0" aria-valuemax="100"></div></div>';
            $.ajax({
              url: "{{ url('/update_status_list') }}/" + schedule_list_code + '/close',
              method: "GET",
              success:function(data){
                $('#status_v').html('<div class="badge badge-success">'+data+'</div>');
                loadMyTableScheduleList();
              }
            });
          }
          else if(nilai_percent == 0)
          {
            $.ajax({
              url: "{{ url('/update_status_list') }}/" + schedule_list_code + '/open',
              method: "GET",
              success:function(data){
                $('#status_v').html('<div class="badge badge-primary">'+data+'</div>');
                loadMyTableScheduleList();
              }
            });
          }
          else if(nilai_percent < 100)
          {
            ket_percent += '<div class="d-flex justify-content-between text-muted mt-3"><small>Process</small> <small>'+Math.round(nilai_percent)+'% / 100%</small></div><div class="progress progress-slim mt-2"><div class="progress-bar bg-primary" role="progressbar" style="width: '+nilai_percent+'%" aria-valuenow="'+nilai_percent+'" aria-valuemin="0" aria-valuemax="100"></div></div>';
            $.ajax({
              url: "{{ url('/update_status_list') }}/" + schedule_list_code + '/waiting',
              method: "GET",
              success:function(data){
                $('#status_v').html('<div class="badge badge-warning">'+data+'</div>');
                loadMyTableScheduleList();
              }
            });
          }

          for(var i = 0; i<response.workers.length; i++){
            var no = i + 1;
            if(response.workers[i].percent < 100)
            {
              isi_table += '<tr><td>'+no+'</td><td>'+response.workers[i].user_name+'</td><td>'+response.workers[i].point_check+'</td><td>'+response.workers[i].description+'</td><td><div class="progress progress-slim"><div class="progress-bar bg-info progress-bar-striped" role="progressbar" style="width: '+response.workers[i].percent+'%" aria-valuenow="'+response.workers[i].percent+'" aria-valuemin="0" aria-valuemax="100"></div></div></td><td>'+response.workers[i].status_check+'</td><td>'+response.workers[i].comment+'</td><td>'+response.workers[i].date_check+'</td><td><a class="btn btn-danger btn-xs delete-worker-btn" data-delete="'+response.workers[i].id+'" href="#"><i class="mdi mdi-close-box-outline"></i></a></td></tr>';
            }
            else if(response.workers[i].percent == 100)
            {
              isi_table += '<tr><td>'+no+'</td><td>'+response.workers[i].user_name+'</td><td>'+response.workers[i].point_check+'</td><td>'+response.workers[i].description+'</td><td><div class="progress progress-slim"><div class="progress-bar bg-success progress-bar-striped" role="progressbar" style="width: '+response.workers[i].percent+'%" aria-valuenow="'+response.workers[i].percent+'" aria-valuemin="0" aria-valuemax="100"></div></div></td><td>'+response.workers[i].status_check+'</td><td>'+response.workers[i].comment+'</td><td>'+response.workers[i].date_check+'</td><td><a class="btn btn-danger btn-xs delete-worker-btn" data-delete="'+response.workers[i].id+'" href="#"><i class="mdi mdi-close-box-outline"></i></a></td></tr>';
            }
          }
          $('#percent-status').html(ket_percent);
          $('#table-work-list').html(isi_table);
        }
      });
      $('.empty-input').val('');
      $('#empty-select').prop('selected', true);
    }
  });
});
</script>
@endsection