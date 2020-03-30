@extends('template')
@section('css')
<style type="text/css">
  .menu-drop:hover{
    color: #696ffb;
  }
  .worker_h_table{
    width: 100%;
  }
  .tbody_worker, .thead_worker, .tr_worker, .th_worker, .td_worker{
    display: block;
  }
  .tr_worker:after{
    content: ' ';
    display: block;
    visibility: hidden;
    clear: both;
  }
  .thead_worker th{
    height: 50px;
  }
  .tbody_worker{
    height: 170px;
    overflow-y: auto;
  }
  .tbody_worker td, .thead_worker th 
  {
    width: 20%;
    float: left;
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
      <span class="link-title" style="color: #4CCEAC;">Report</span>
      <i class="mdi mdi-file-document-box link-icon" style="color: #4CCEAC;"></i>
    </a>
  </li>
    @elseif(auth()->user()->role == 'supervisor')
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
      <span class="link-title" style="color: #4CCEAC;">Report</span>
      <i class="mdi mdi-file-document-box link-icon" style="color: #4CCEAC;"></i>
    </a>
  </li>
  @elseif(auth()->user()->role == 'user')
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
      <span class="link-title" style="color: #4CCEAC;">Report</span>
      <i class="mdi mdi-file-document-box link-icon" style="color: #4CCEAC;"></i>
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
      <li class="breadcrumb-item active" aria-current="page">Report</li>
    </ol>
  </nav>
</div>
<div class="content-viewport">
  <div class="row" hidden="">
    <button type="button" data-toggle="modal" data-target=".schedule_modal" id="annual_schedule_modal"></button>
    <button type="button" data-toggle="modal" data-target=".repair_modal" id="repair_modal"></button>
  </div>
  <!-- <div class="row">
    <div class="modal fade bd-example-modal-xl schedule_modal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row mr-1 mb-4">
              <div class="col-lg-12">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            </div>
            <div id="table_print">
              <div class="row mb-4">
                <div class="col-lg-12 text-center">
                  <h5 id="title"></h5>
                </div>
              </div><hr>
              <div class="row">
                <div class="col-lg-12">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Schedule Code</th>
                          <th>User</th>
                          <th>Lane</th>
                          <th>Machine</th>
                          <th>Point Check</th>
                          <th>Schedule Date</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody id="table-content">

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div><hr>
            <div class="row mt-3 mb-1">
              <div class="col-lg-6 pl-2">
                <form target="_blank" method="POST" action="{{ url('/pdf_annual') }}">
                  @csrf
                  <input type="text" name="start_date" class="start_date_modal" value="" hidden="">
                  <input type="text" name="end_date" class="end_date_modal" value="" hidden="">
                  <button class="btn btn-block btn-outline-light text-gray component-flat" type="submit">
                    <span class=" mdi mdi-file-pdf"></span>&nbsp; EKSPORT PDF 
                  </button>
                </form>
              </div>
              <div class="col-lg-6 pr-2">
                <form target="_blank" method="POST" action="{{ url('/print_annual') }}">
                  @csrf
                  <input type="text" name="start_date" class="start_date_modal" value="" hidden="">
                  <input type="text" name="end_date" class="end_date_modal" value="" hidden="">
                  <button class="btn btn-block btn-primary print_annual" type="submit">
                    <span class="mdi mdi-printer"></span>&nbsp; PRINT
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade bd-example-modal-xl repair_modal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row mr-1 mb-4">
              <div class="col-lg-12">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            </div>
            <div id="table_print_2">
              <div class="row mb-4">
                <div class="col-lg-12 text-center">
                  <h5 id="title_2"></h5>
                </div>
              </div><hr>
              <div class="row">
                <div class="col-lg-12">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Repair Code</th>
                          <th>Repair Date</th>
                          <th>User</th>
                          <th>Lane</th>
                          <th>Machine</th>
                          <th>Title</th>
                          <th>Description</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody id="table-content-2">

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <div class="row mt-3 mb-1">
              <div class="col-lg-6 pl-2">
                <form target="_blank" method="POST" action="{{ url('/pdf_repair') }}">
                  @csrf
                  <input type="text" name="start_date" class="start_date_modal" value="" hidden="">
                  <input type="text" name="end_date" class="end_date_modal" value="" hidden="">
                  <button class="btn btn-block btn-outline-light text-gray component-flat" type="submit">
                    <span class=" mdi mdi-file-pdf"></span>&nbsp; EKSPORT PDF 
                  </button>
                </form>
              </div>
              <div class="col-lg-6 pr-2">
                <form target="_blank" method="POST" action="{{ url('/print_repair') }}">
                  @csrf
                  <input type="text" name="start_date" class="start_date_modal" value="" hidden="">
                  <input type="text" name="end_date" class="end_date_modal" value="" hidden="">
                  <button class="btn btn-block btn-primary print_repair" type="submit">
                    <span class="mdi mdi-printer"></span>&nbsp; PRINT
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->
  <div class="row">
    <div class="col-lg-12">
      <div class="grid">
        <p class="grid-header">Worker History</p>
        <div class="grid-body">
          <div class="item-wrapper">
            <div class="row mb-3">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-hover worker_h_table">
                    <thead class="thead_worker">
                      <tr class="tr_worker">
                        <th class="th_worker">No</th>
                        <th class="th_worker">User</th>
                        <th class="th_worker">Role</th>
                        <th class="th_worker">Amount of Work</th>
                        <th class="th_worker"></th>
                      </tr>
                    </thead>
                    <tbody class="tbody_worker">
                      @foreach($users as $user)
                      <tr class="tr_worker">
                        <td class="td_worker">{{ $loop->iteration }}</td>
                        <td class="td_worker d-flex align-items-center border-top-0">
                          <img class="profile-img img-sm img-rounded mr-2" src="{{ asset('picture/'.$user->avatar) }}" alt="profile image">
                          <span>{{ $user->name }}</span>
                        </td>
                        <td class="td_worker">{{ $user->role }}</td>
                        <td class="td_worker">
                          @php
                          $worklist = \App\Worklist::select('worklists.*')->where('worklists.worker', $user->id)->count();
                          $improvement = \App\Improvement::select('improvements.*')->where('improvements.id_user', $user->id)->count();
                          $counting = $worklist + $improvement;
                          echo $counting;
                          @endphp
                        </td>
                        <td class="td_worker">
                          <a href="{{ url('/worker_history/'.$user->id) }}" class="btn btn-xs btn-primary has-icon">
                            <i class="mdi mdi-eye"></i>View
                          </a>
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
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="grid">
        <p class="grid-header">Machine History</p>
        <div class="grid-body">
          <div class="item-wrapper">
            <form method="POST" action="{{ url('/load_pdf_machine') }}" target="_blank">
              @csrf
              <div class="row mb-3">
                <div class="col-md-4 text-center">
                  <img src="{{ asset('icons/undraw_Firmware_jw6u.svg') }}" style="width: 200px;">
                </div>
                <div class="col-md-8">
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 showcase_text_area">
                      <label for="start_date_schedule">Lane</label>
                    </div>
                    <div class="col-md-4 showcase_content_area">
                      <select class="custom-select lane-select" required="" name="lane">
                        <option value="" id="default">-- Select Lane --</option>
                        @foreach($lanes as $lane)
                        <option value="{{ $lane->id }}">{{ $lane->lane }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-2 showcase_text_area">
                      <label for="start_date_schedule" class="label_date_machine">Start date</label>
                    </div>
                    <div class="col-md-4 showcase_content_area">
                      <input type="date" class="form-control start_date_machine" name="start_date" value="" required="">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 showcase_text_area">
                      <label for="start_date_schedule">Machine</label>
                    </div>
                    <div class="col-md-4 showcase_content_area">
                      <select class="custom-select machine-select" required="" name="machine">

                      </select>
                    </div>
                    <div class="col-md-2 showcase_text_area">
                      <label for="start_date_schedule" class="label_date_machine">End date</label>
                    </div>
                    <div class="col-md-4 showcase_content_area">
                      <input type="date" class="form-control end_date_machine" name="end_date" value="" required="">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 showcase_text_area">
                      <label for="start_date_schedule">Status</label>
                    </div>
                    <div class="col-md-4 showcase_content_area">
                      <select class="custom-select" required="" name="status">
                        <option value="">-- Select Status --</option>
                        <option value="open">Open</option>
                        <option value="waiting">Waiting</option>
                        <option value="close">Close</option>
                        <option value="all">All Status</option>
                      </select>
                    </div>
                    <div class="col-md-5 ml-5 mt-2 showcase_text_area form-inline">
                      <div class="checkbox mb-3">
                        <label>
                          <input type="checkbox" class="form-check-input check-history" id="check_history" name="check_history" value="true"> All history <i class="input-frame"></i>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-12 showcase_content_area"><br>
                      <button type="submit" class="btn btn-sm btn-primary filter-machine-btn float-right">Filter</button>
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
  <!-- <div class="row">
    <div class="col-lg-12">
      <div class="grid">
        <p class="grid-header">Routine Schedule Report</p>
        <div class="grid-body">
          <div class="item-wrapper">
            <form method="POST" id="filter_annual_schedule">
              <div class="row mb-3">
                <div class="col-md-4 text-center mt-4 mb-4">
                  <img src="{{ asset('icons/undraw_schedule_pnbk.svg') }}" style="width: 220px;">
                </div>
                <div class="col-md-8">
                  @csrf
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                      <label for="start_date_schedule">Start Date</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="date" class="form-control" id="start_date_schedule" name="start_date" value="" required="">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                      <label for="end_date_schedule">End Date</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="date" class="form-control" id="end_date_schedule" name="end_date" value="" required="">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                    </div>
                    <div class="col-md-9 showcase_content_area"><br>
                      <button type="submit" class="btn btn-sm btn-primary float-right">Filter</button>
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
  <div class="row">
    <div class="col-lg-12">
      <div class="grid">
        <p class="grid-header">Repair Machine Report</p>
        <div class="grid-body">
          <div class="item-wrapper">
            <form method="POST" id="filter_repair">
              <div class="row mb-3">
                <div class="col-md-4 text-center mt-4 mb-4">
                  <img src="{{ asset('icons/undraw_maintenance_cn7j.svg') }}" style="width: 150px;">
                </div>
                <div class="col-md-8">
                  @csrf
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                      <label for="start_date_repair">Start Date</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="date" class="form-control" id="start_date_repair" name="start_date" value="" required="">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                      <label for="end_date_repair">End Date</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                      <input type="date" class="form-control" id="end_date_repair" name="end_date" value="" required="">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                    </div>
                    <div class="col-md-9 showcase_content_area"><br>
                      <button type="submit" class="btn btn-sm btn-primary float-right">Filter</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div> -->
</div>
@endsection
@section('javascript')
<script src="{{ asset('assets/vendors/js/vendor.addons.js') }}"></script>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script type="text/javascript">

$('.check-history').on('click', function(){
  if(this.checked == true){
    $('.start_date_machine').prop('readOnly', true);
    $('.end_date_machine').prop('readOnly', true);
    $('.start_date_machine').val('');
    $('.end_date_machine').val('');
    $('.start_date_machine').attr('required', false);
    $('.end_date_machine').attr('required', false);
    $('.label_date_machine').css('text-decoration', 'line-through');
  }else{
    $('.start_date_machine').prop('readOnly', false);
    $('.end_date_machine').prop('readOnly', false);
    $('.start_date_machine').attr('required', true);
    $('.end_date_machine').attr('required', true);
    $('.label_date_machine').css('text-decoration', 'none');
  }
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

$('#filter_annual_schedule').submit(function(e){
  e.preventDefault();
  var request = new FormData(this);
  $.ajax({
    url: "{{ url('/filter_schedule') }}",
    method: "POST",
    data: request,
    contentType: false,
    processData: false,
    success:function(response){
      var table_content = "";
      for(var i = 0; i < response.schedules.length; i++){
        var index = i + 1;
        table_content = table_content + '<tr><td>'+ index +'</td><td>'+ response.schedules[i].schedule_code +'</td><td>'+ response.schedules[i].user +'</td><td>'+ response.schedules[i].lane_name +'</td><td>'+ response.schedules[i].machines_name +'</td><td>'+ response.schedules[i].point_check +'</td><td>'+ response.schedules[i].schedule_date +'</td><td>'+ response.schedules[i].status +'</td></tr>';
      }
      var start_date = $('#start_date_schedule').val();
      var end_date = $('#end_date_schedule').val();
      var title_val = "Annual Schedule Report From <u>" + start_date + "</u> To <u>" + end_date + "</u>";
      $('.start_date_modal').val(response.start_date);
      $('.end_date_modal').val(response.end_date);
      $('#title').html(title_val);
      $('#annual_schedule_modal').click();
      $('#table-content').html(table_content);
    }
  });
});

$('#filter_repair').submit(function(e){
  e.preventDefault();
  var request = new FormData(this);
  $.ajax({
    url: "{{ url('/filter_repair') }}",
    method: "POST",
    data: request,
    contentType: false,
    processData: false,
    success:function(response){
      var table_content = "";
      for(var i = 0; i < response.repairs.length; i++){
        var index = i + 1;
        table_content = table_content + '<tr><td>'+ index +'</td><td>'+ response.repairs[i].repair_code +'</td><td>'+ response.repairs[i].repair_date +'</td><td>'+ response.repairs[i].user +'</td><td>'+ response.repairs[i].lane_name +'</td><td>'+ response.repairs[i].machines_name +'</td><td>'+ response.repairs[i].title +'</td><td>'+ response.repairs[i].description +'</td><td>'+ response.repairs[i].status +'</td></tr>';
      }
      var start_date = $('#start_date_repair').val();
      var end_date = $('#end_date_repair').val();
      var title_val = "Repair Report From <u>" + start_date + "</u> To <u>" + end_date + "</u>";
      $('.start_date_modal').val(response.start_date);
      $('.end_date_modal').val(response.end_date);
      $('#title_2').html(title_val);
      $('#repair_modal').click();
      $('#table-content-2').html(table_content);
    }
  });
});
</script>
@endsection