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
      <li class="breadcrumb-item active" aria-current="page">Repair Machine</li>
    </ol>
  </nav>
</div>
<div class="content-viewport">
  <div class="row">
    <div class="col-lg-12">
      <div class="grid">
        @if(auth()->user()->role != 'user')
       <a href="{{ url('/my_repair_machine') }}" class="btn-hover">
        <div class="btn btn-primary has-icon row float-right border-0" style="margin:8px 10px 0px 10px;">
          <i class="mdi mdi-book-multiple"></i>My Repair Machine</div>
       </a>
       @endif
        <p class="grid-header">Repair Machine</p>
        <div class="item-wrapper">
          <div class="form-group row showcase_row_area">
            <div class="col-lg-8 col-md-8 showcase_content_area pl-4 searching">
              <input type="text" class="form-control repair-search" value="" placeholder="Search Repair">
            </div>
            <div class="col-lg-4 col-md-4 showcase_content_area pr-4 sorting">
              <select class="custom-select sort-select">
                <option value="">-- Sort Repair By --</option>
                <option value="repair_code">Repair Code</option>
                <option value="repair_date">Repair Date</option>
                <option value="user">User</option>
                <option value="lane_name">Lane</option>
                <option value="machines_name">Machine</option>
                <option value="title">Point Check</option>
                <option value="description">Description</option>
                <option value="status">Status</option>
              </select>
            </div>
          </div>
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
                  <th>Point Check</th>
                  <th>Description</th>
                  <th>Status</th>
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

function loadTableRepair(){
  $.ajax({
    url: "{{ url('/table_repair') }}",
    success:function(data){
      $('#table-content').html(data);
    }
  });
}

loadTableRepair();

$(document).ready( function() {
  $('.sort-select').change(function() {
    if($(this).val() == ""){
      loadTableSchedule();
    }else{
      var sort_by = $(this).val();
      $.ajax({
        url: "{{ url('sort_table_repair') }}/" + sort_by,
        success:function(data){
          $('#table-content').html(data);
        }
      });
    }
  });
});
</script>
@endsection