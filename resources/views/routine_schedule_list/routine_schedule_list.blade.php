@extends('template')
@section('css')
<style type="text/css">
  .menu-drop:hover{
    color: #696ffb;
  }

  @media only screen
  and (max-width : 770px) {
    .searching{
      padding-right: 20px;
    }
    .sorting{
      margin-top: 20px;
      padding-left: 20px;
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
  @if(auth()->user()->role == 'user')
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
      <li class="breadcrumb-item active" aria-current="page">Routine Schedule List</li>
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
                  <p class="grid-header">Work List</p>
                  <div class="item-wrapper">
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
        @if(auth()->user()->role != 'user')
       <a href="{{ url('/my_schedule_list') }}" class="btn-hover">
        <div class="btn btn-primary has-icon row float-right border-0" style="margin:8px 10px 0px 10px;">
          <i class="mdi mdi-book-multiple"></i>My Schedule List</div>
       </a>
       @endif
        <p class="grid-header">Routine Schedule List</p>
        <div class="item-wrapper">
          <div class="form-group row showcase_row_area">
            <div class="col-lg-8 col-md-8 showcase_content_area pl-4 searching">
              <input type="text" class="form-control schedule-search" value="" placeholder="Search Schedule">
            </div>
            <div class="col-lg-4 col-md-4 showcase_content_area pr-4 sorting">
              <select class="custom-select sort-select">
                <option value="">-- Sort Schedule By --</option>
                <option value="schedule_list_code">Schedule List Code</option>
                <option value="schedule_code">Schedule Code</option>
                <option value="user_name">Scheduler</option>
                <option value="lane">Lane</option>
                <option value="machines_name">Machine</option>
                <option value="schedule_date">Schedule Date</option>
                <option value="status">Status</option>
              </select>
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

function loadTableSchedule(){
  $.ajax({
    url: "{{ url('/table_schedule_list') }}",
    success:function(data){
      $('#table-content').html(data);
    }
  });
}

loadTableSchedule();

$(document).ready( function() {
  $('.sort-select').change(function() {
    if($(this).val() == ""){
      loadTableSchedule();
    }else{
      var sort_by = $(this).val();
      $.ajax({
        url: "{{ url('sort_table_schedule_list') }}/" + sort_by,
        success:function(data){
          $('#table-content').html(data);
        }
      });
    }
  });
});

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
              isi_table += '<tr><td>'+no+'</td><td>'+response.workers[i].user_name+'</td><td>'+response.workers[i].point_check+'</td><td>'+response.workers[i].description+'</td><td><div class="progress progress-slim"><div class="progress-bar bg-info progress-bar-striped" role="progressbar" style="width: '+response.workers[i].percent+'%" aria-valuenow="'+response.workers[i].percent+'" aria-valuemin="0" aria-valuemax="100"></div></div></td><td>'+response.workers[i].status_check+'</td><td>'+response.workers[i].comment+'</td><td>'+response.workers[i].date_check+'</td></tr>';
            }
            else if(response.workers[i].percent == 100)
            {
              isi_table += '<tr><td>'+no+'</td><td>'+response.workers[i].user_name+'</td><td>'+response.workers[i].point_check+'</td><td>'+response.workers[i].description+'</td><td><div class="progress progress-slim"><div class="progress-bar bg-success progress-bar-striped" role="progressbar" style="width: '+response.workers[i].percent+'%" aria-valuenow="'+response.workers[i].percent+'" aria-valuemin="0" aria-valuemax="100"></div></div></td><td>'+response.workers[i].status_check+'</td><td>'+response.workers[i].comment+'</td><td>'+response.workers[i].date_check+'</td></tr>';
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
        $('#status_v').html('<div class="badge badge-success">'+response.status+'</div>');warning
      }
    }
  });
});
</script>
@endsection