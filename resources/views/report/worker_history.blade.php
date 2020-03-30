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
      <li class="breadcrumb-item">
        <a href="{{ url('/report') }}">Report</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">Worker History</li>
    </ol>
  </nav>
</div>
<div class="content-viewport">
  <div class="row">
    <div class="modal fade" id="exportPdfModal" tabindex="-1" role="dialog" aria-labelledby="exportPdfModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exportPdfModalLabel">Export PDF</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ url('/load_worker_history/' . $id) }}" target="_blank">
            @csrf
            <div class="form-group row">
              <div class="col-sm-12">
                <select class="custom-select" required="" name="report_type">
                  <option value="">-- Select Report --</option>
                  <option value="routine_schedule">Routine Schedule</option>
                  <option value="non_routine_schedule">Non Routine Schedule</option>
                  <option value="all">All</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Status</label>
              <div class="col-sm-9 offset-sm-1">
                <select class="custom-select" required="" name="status">
                  <option value="">-- Select Status --</option>
                  <option value="open">Open</option>
                  <option value="waiting">Waiting</option>
                  <option value="close">Close</option>
                  <option value="all">All</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label label_date_machine">Start Date</label>
              <div class="col-sm-9 offset-sm-1">
                <input type="date" class="form-control start_date_machine" name="start_date" value="" required="">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label label_date_machine">End Date</label>
              <div class="col-sm-9 offset-sm-1">
                <input type="date" class="form-control end_date_machine" name="end_date" value="" required="">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-9 offset-sm-3 checkbox mb-3">
                <label>
                  <input type="checkbox" class="form-check-input check-history" id="check_history" name="check_history" value="true"> All history <i class="input-frame"></i>
                </label>
              </div>
            </div><hr>
            <button type="submit" class="btn btn-primary btn-block">Export</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="grid">
        <a href="" class="btn-hover" data-toggle="modal" data-target="#exportPdfModal" role="button">
        <div class="btn btn-primary has-icon row float-right border-0" style="margin:8px 10px 0px 10px;">
          <i class="mdi mdi-printer"></i>Print History
        </div>
       </a>
        <div class="grid-header">
          <img class="profile-img img-sm img-rounded mr-2" src="{{ asset('picture/'.$users->avatar) }}" alt="profile image">
          <span>{{ $users->name }} - {{ $users->role }}</span>
        </div>
        <div class="grid-body">
          <div class="item-wrapper">
            <div class="row mb-3">
              <div class="col-md-12">
                <div class="btn-group mb-0" data-toggle="buttons">
                  <label class="btn btn-outline-info active">
                    <input type="radio" onchange="routine_schedule_list_btn()" value="routine_schedule_list_btn" name="options" id="option1_1" checked>
                    Routine Schedule
                  </label>
                  <label class="btn btn-outline-info">
                    <input type="radio" onchange="repair_machine_btn()" value="repair_machine_btn" name="options" id="option1_2">
                    Non Routine Schedule
                  </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12" id="worklist_table">
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
                        <th>Status Check</th>
                        <th>Date Check</th>
                      </tr>
                    </thead>
                    <tbody id="table-content">
                      @foreach($worklists as $worklist)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $worklist->schedule_list_code }}</td>
                        <td>{{ $worklist->lane_name }}</td>
                        <td>{{ $worklist->machine_name }}</td>
                        <td>{{ $worklist->point_check }}</td>
                        <td>{{ $worklist->description }}</td>
                        <td>
                          <div class="progress progress-slim">
                            @if($worklist->percent < 100)
                            <div class="progress-bar bg-info progress-bar-striped" role="progressbar" style="width: {{ $worklist->percent }}%" aria-valuenow="{{ $worklist->percent }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                            @elseif($worklist->percent == 100)
                            <div class="progress-bar bg-success progress-bar-striped" role="progressbar" style="width: {{ $worklist->percent }}%" aria-valuenow="{{ $worklist->percent }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                            @endif
                          </div>
                        </td>
                        <td>{{ $worklist->status_check }}</td>
                        <td>{{ $worklist->date_check }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-12" id="repair_machine_table" hidden="">
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
                      </tr>
                    </thead>
                    <tbody id="table-content">
                      @foreach($repairs as $repair)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $repair->repair_code }}</td>
                        <td>{{ $repair->repair_date }}</td>
                        <td>{{ $repair->lane_name }}</td>
                        <td>{{ $repair->machine_name }}</td>
                        <td>{{ $repair->title }}</td>
                        <td>{{ $repair->description }}</td>
                        <td>
                          @if($repair->status == 'open')
                          <div class="badge badge-primary">{{ $repair->status }}</div>
                          @elseif($repair->status == 'waiting')
                          <div class="badge badge-warning">{{ $repair->status }}</div>
                          @elseif($repair->status == 'close')
                          <div class="badge badge-success">{{ $repair->status }}</div>
                          @endif
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

function routine_schedule_list_btn() {
  $('#worklist_table').prop('hidden', false);
  $('#repair_machine_table').prop('hidden', true);
}

function repair_machine_btn() {
  $('#worklist_table').prop('hidden', true);
  $('#repair_machine_table').prop('hidden', false);
}
</script>
@endsection