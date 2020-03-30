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
</ul>
@endsection
@section('content')
<div class="viewport-header">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb has-arrow">
      <li class="breadcrumb-item">
        <a href="{{ url('/dashboard') }}">Dashboard</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">My Work List</li>
    </ol>
  </nav>
</div>
<div class="content-viewport">
  <div class="row">
    <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidde="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="pdfModalLabel">Export PDF</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ url('/load_pdf_workorder') }}" target="_blank">
              @csrf
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Area</label>
                <div class="col-sm-9 offset-sm-1">
                  <input type="text" class="form-control" name="area" placeholder="Ex : Packing Area">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Priority</label>
                <div class="col-sm-9 offset-sm-1">
                  <select class="form-control" name="priority_1">
                    <option value="">-- Select Priority</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Cost Center</label>
                <div class="col-sm-9 offset-sm-1">
                  <input type="number" class="form-control" min="0" name="cost" placeholder="Ex : 5094">
                </div>
              </div>
              <hr>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Approximate duration</label>
                <div class="col-sm-3 offset-sm-1">
                  <input type="number" class="form-control number_prev" min="0" max="100" maxlength="3" name="approximate_h" placeholder="Ex : 5">
                </div>
                <label class="col-sm-1 col-form-label">H</label>
                <div class="col-sm-3 offset-sm-1">
                  <input type="number" class="form-control number_prev" min="0" max="59" maxlength="2" name="approximate_m" placeholder="Ex : 0">
                </div>
                <label class="col-sm-1 col-form-label">M</label>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Requires shutdown</label>
                <div class="col-sm-4 offset-sm-1">
                  <input type="number" class="form-control number_prev" min="0" max="31" name="shutdown_num" placeholder="Ex : 1">
                </div>
                <div class="col-sm-5">
                  <select class="form-control" name="shutdown_per">
                    <option value="">-- Select Period --</option>
                    <option value="day">Day</option>
                    <option value="week">Week</option>
                    <option value="month">Month</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Priority</label>
                <div class="col-sm-9 offset-sm-1">
                  <select class="form-control" name="priority_2">
                    <option value="">-- Select Priority</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                  </select>
                </div>
              </div>
              <div class="form-group row" hidden="">
                <input type="text" class="id_pdf" name="id_pdf">
              </div>
              <hr>
              <button type="submit" class="btn btn-primary btn-block">Export</button>
            </form>
          </div>
        </div>
      </div>
    </div>
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
            <form method="POST" id="update_my_job">
              @csrf
              <div class="row">
                  <div class="col-md-12">
                    <p class="text-gray">Your Job Information</p>
                  </div>
                  <div class="col-md-12">
                    <div class="d-flex justify-content-between text-muted mt-3">
                      <small>Process</small>
                      <small id="range-status"></small>
                    </div>
                    <input type="range" id="percent_detail" class="custom-range" min="0" max="100" step="1" value="0" name="percent">
                  </div>
                  <div class="col-md-12" hidden="">
                    <input type="text" name="schedule_list_code" id="schedule_list_code_detail">
                  </div>
                  <div class="col-md-12 mt-1">
                    <div class="form-row">
                      <div class="col">
                        <select class="custom-select work_status" name="status" disabled="">
                          <option class="open-status" value="open">open</option>
                          <option class="waiting-status" value="waiting">waiting</option>
                          <option class="close-status" value="close">close</option>
                        </select>
                        <!-- <input type="text" class="form-control" placeholder="Status" name="status" id="status_detail"> -->
                      </div>
                      <div class="col">
                        <input type="date" class="form-control" name="date_check" id="date_check_detail">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 mt-1">
                    <div class="form-row">
                      <div class="col">
                        <textarea placeholder="Comment" id="comment" name="comment" class="form-control" cols="12" rows="3"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 mt-3">
                    <button class="btn btn-primary btn-sm btn-block" type="submit">Update Job</button>
                  </div>
              </div>
            </form>
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
        <p class="grid-header">My Work List</p>
        <div class="item-wrapper">
          <div class="form-group row showcase_row_area">
            <div class="col-lg-12 col-md-12 pl-4 pr-4 showcase_content_area searching">
              <input type="text" class="form-control schedule-search" value="" placeholder="Search Schedule">
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Schedule List Code</th>
                  <th>Lane</th>
                  <th>Machine</th>
                  <th>Point Check</th>
                  <th>Description</th>
                  <th>Percent</th>
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
$(document).on('click', '.pdf-btn', function(e){
  e.preventDefault();
  var id = $(this).attr('data-pdf');
  $('.id_pdf').val(id);
});

function loadTableSchedule(){
  $.ajax({
    url: "{{ url('/my_work_list_table') }}",
    success:function(data){
      $('#table-content').html(data);
    }
  });
}

loadTableSchedule();

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

$(document).on('change', '#percent_detail', function(){
  $('#range-status').html($('#percent_detail').val() + '%');
});

$('#update_my_job').submit(function(e){
  e.preventDefault();
  var request = new FormData(this);
  $.ajax({
    url: "{{ url('/update_my_work') }}",
    method: "POST",
    data: request,
    contentType: false,
    processData: false,
    success:function(data){
      var schedule_list_code = ''+data+'';
      $.ajax({
        url: "{{ url('/table_worker') }}/" + schedule_list_code,
        method: "GET",
        success:function(response){
          var worklist_id = $('#schedule_list_code_detail').val();
          $.ajax({
            url: "{{ url('/my_work_list_detail') }}/" + worklist_id,
            method: "GET",
            success:function(response){
              $('#range-status').html(response.work_detail.percent + "%")
              $('#percent_detail').val(response.work_detail.percent);
              $('#comment').val(response.work_detail.comment);
              $('.'+response.work_detail.status_check+'-status').prop('selected', true);
              $('#date_check_detail').val(response.work_detail.date_check);
            }
          });
          var isi_table = "";
          var ket_percent = "";
          var nilai_percent = response.workers_s / response.workers.length;
          if(nilai_percent < 100 && nilai_percent != 0)
          {
            $.ajax({
              url: "{{ url('/update_status_list') }}/" + schedule_list_code + "/waiting",
              method: "GET",
              success:function(data){
                $('#status_v').html('<div class="badge badge-warning">'+data+'</div>');
                loadTableSchedule();
              }
            });
          }
          else if(nilai_percent == 100)
          {
            $.ajax({
              url: "{{ url('/update_status_list') }}/" + schedule_list_code + "/close",
              method: "GET",
              success:function(data){
                $('#status_v').html('<div class="badge badge-success">'+data+'</div>');
                loadTableSchedule();
              }
            });
          }
          else
          {
            $.ajax({
              url: "{{ url('/update_status_list') }}/" + schedule_list_code + "/open",
              method: "GET",
              success:function(data){
                $('#status_v').html('<div class="badge badge-primary">'+data+'</div>');
                loadTableSchedule();
              }
            });
          }

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
    }
  });
});

$(document).on('click', '.view-btn', function(e) {
  e.preventDefault();
  var id = $(this).attr('id');
  var worklist_id = $(this).attr('data-work');
  $.ajax({
    url: "{{ url('view_schedule_list') }}/" + id,
    method: "GET",
    success:function(response){
      var schedule_list_code = ''+response.schedule_list_code+'';
      $.ajax({
        url: "{{ url('/table_worker') }}/" + schedule_list_code,
        method: "GET",
        success:function(response){
          $.ajax({
            url: "{{ url('/my_work_list_detail') }}/" + worklist_id,
            method: "GET",
            success:function(response){
              $('#range-status').html(response.work_detail.percent + "%")
              $('#percent_detail').val(response.work_detail.percent);
              $('#comment').val(response.work_detail.comment);
              $('.'+response.work_detail.status_check+'-status').prop('selected', true);
              $('#date_check_detail').val(response.work_detail.date_check);
            }
          });
          var isi_table = "";
          var ket_percent = "";
          var nilai_percent = response.workers_s / response.workers.length;
          if(nilai_percent < 100 && nilai_percent != 0)
          {
            $.ajax({
              url: "{{ url('/update_status_list') }}/" + schedule_list_code + "/waiting",
              method: "GET",
              success:function(data){
                $('#status_v').html('<div class="badge badge-warning">'+data+'</div>');
                loadTableSchedule();
              }
            });
          }
          else if(nilai_percent == 100)
          {
            $.ajax({
              url: "{{ url('/update_status_list') }}/" + schedule_list_code + "/close",
              method: "GET",
              success:function(data){
                $('#status_v').html('<div class="badge badge-success">'+data+'</div>');
                loadTableSchedule();
              }
            });
          }
          else
          {
            $.ajax({
              url: "{{ url('/update_status_list') }}/" + schedule_list_code + "/open",
              method: "GET",
              success:function(data){
                $('#status_v').html('<div class="badge badge-primary">'+data+'</div>');
                loadTableSchedule();
              }
            });
          }

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
      $('#schedule_list_code_detail').val(worklist_id);
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
        $('#status_v').html('<div class="badge badge-success">'+response.status+'</div>')
      }
    }
  });
});

$(".number_prev").keypress(function (evt) {
    evt.preventDefault();
});
</script>
@endsection