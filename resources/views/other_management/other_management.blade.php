@extends('template')
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
      <li class="breadcrumb-item active" aria-current="page">Other</li>
    </ol>
  </nav>
</div>
<div class="content-viewport">
  <div class="row">
    <div class="col-lg-6">
      <div class="grid">
        <div class="grid-body">
          <h2 class="grid-title">Clear Message History</h2>
          <div class="item-wrapper">
            <p>Useful for improving website performance, You can clear entire chat history by click the button below</p>
            <a href="{{ url('/clear_message') }}"><div class="btn btn-primary btn-block mt-4">Clear Message History</div></a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="grid">
        <div class="grid-body">
          <h2 class="grid-title">Clear Activity Log</h2>
          <div class="item-wrapper">
            <p>Useful for improving website performance, You can clear activity log by click the button below  </p>
            <a href="{{ url('/clear_activity') }}"><div class="btn btn-primary btn-block mt-4">Clear Activity Log</div></a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <div class="grid">
        <p class="grid-header">Activity Log</p>
        <div class="item-wrapper">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>User</th>
                  <th>Description</th>
                  <th>Date/Time</th>
                </tr>
              </thead>
              <tbody>
                @foreach($act_log as $log)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $log->user }}</td>
                  <td>{{ $log->description }}</td>
                  <td>{{ $log->created_at }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            {{ $act_log->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script src="{{ asset('assets/vendors/js/vendor.addons.js') }}"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
@if ($message = Session::get('clear_message'))
Swal.fire({
  icon: 'success',
  text: '{{ $message }}',
  showConfirmButton: false,
  timer: 1500
})
@endif

@if ($message = Session::get('clear_activity'))
Swal.fire({
  icon: 'success',
  text: '{{ $message }}',
  showConfirmButton: false,
  timer: 1500
})
@endif
</script>
@endsection