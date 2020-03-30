@extends('template')
@section('css')
<link href="{{ asset('packages/core/main.css') }}" rel="stylesheet" />
<link href="{{ asset('packages/daygrid/main.css') }}" rel="stylesheet" />
<script src="{{ asset('packages/core/main.js') }}"></script>
<script src="{{ asset('packages/interaction/main.js') }}"></script>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('packages/daygrid/main.js') }}"></script>
<script>
var getEvent = [];
function loadListSchedule(){
  $.ajax({
    url: "{{ url('/schedule_list') }}",
    success:function(response){
      for(var i = 0; i < response.repairs.length; i++)
      {
        var titleEvent = 'R | ' + response.repairs[i].lane_name + ' : ' + response.repairs[i].machine_name;
        var dateEvent = response.repairs[i].repair_date;

        var insertEvent =  {};
        insertEvent = {title:titleEvent,start:dateEvent,color:'#FF6F59',textColor:'white'}
        getEvent.push(insertEvent);
      }
      for(var i = 0; i < response.schedule.length; i++)
      {
        var titleEvent = 'S | ' + response.schedule[i].lane_name + ' : ' + response.schedule[i].machine_name;
        var dateEvent = response.schedule[i].schedule_date;

        var insertEvent =  {};
        insertEvent = {title:titleEvent,start:dateEvent,textColor:'white'}
        getEvent.push(insertEvent);
      }
    }
  });
}
loadListSchedule();

document.addEventListener('DOMContentLoaded', function() {
var calendarEl = document.getElementById('calendar');
var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();
today = yyyy + '-' + mm + '-' + dd;
var calendar = new FullCalendar.Calendar(calendarEl, {
  plugins: [ 'interaction', 'dayGrid' ],
  defaultDate: today,
  editable: false,
  eventLimit: true, // allow "more" link when too many events
  events: getEvent
});

calendar.render();
});

</script>
@endsection
@section('nav')
<ul class="navigation-menu">
  <li class="nav-category-divider">MAIN</li>
  <li>
    <a href="{{ url('/dashboard') }}">
      <span class="link-title" style="color: #4CCEAC;">Dashboard</span>
      <i class="mdi mdi-gauge link-icon" style="color: #4CCEAC;"></i>
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
      <span class="link-title">Report</span>
      <i class="mdi mdi-file-document-box link-icon"></i>
    </a>
  </li>
  @endif
  @if(auth()->user()->role == 'supervisor')
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
  @endif
  @if(auth()->user()->role == 'user')
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
      <span class="link-title">Report</span>
      <i class="mdi mdi-file-document-box link-icon"></i>
    </a>
  </li>
  @endif
</ul>
@endsection
@section('content')
<div class="content-viewport">
  <div class="row">
    <div class="col-12 py-5">
      <h4>Dashboard</h4>
      <p class="text-gray">Welcome aboard, {{ auth()->user()->name }}</p>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3 col-sm-6 col-6 equel-grid">
      <div class="grid">
        <div class="grid-body text-gray">
          <div class="mb-3">
            <p class="text-black">USER</p>
          </div>
          <div class="d-flex justify-content-between">
            <p><b>{{ $user }}</b></p>
            <p>A : {{ $admin }} | S : {{ $supervisor }} | U : {{ $users }}</p>
          </div>
          <div class="wrapper w-50 mt-4">
            <canvas height="45" id="stat-line_1"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-6 equel-grid">
      <div class="grid">
        <div class="grid-body text-gray">
          <div class="mb-3">
            <p class="text-black">MACHINE</p>
          </div>
          <div class="d-flex justify-content-between">
            <p><b>{{ $machine }}</b></p>
          </div>
          <div class="wrapper w-50 mt-4">
            <canvas height="45" id="stat-line_2"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-6 equel-grid">
      <div class="grid">
        <div class="grid-body text-gray">
          <div class="mb-3">
            <p class="text-black">ROUTINE SCHEDULE</p>
          </div>
          <div class="d-flex justify-content-between">
            <p><b>{{ $annual }}</b></p>
            <p>O : {{ $open_a }} | W : {{ $waiting_a }} | C : {{ $close_a }}</p>
          </div>
          <div class="wrapper w-50 mt-4">
            <canvas height="45" id="stat-line_3"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-6 equel-grid">
      <div class="grid">
        <div class="grid-body text-gray">
          <div class="mb-3">
            <p class="text-black">REPAIR DATA</p>
          </div>
          <div class="d-flex justify-content-between">
            <p><b>{{ $repair }}</b></p>
            <p>O : {{ $open_r }} | W : {{ $waiting_r }} | C : {{ $close_r }}</p>
          </div>
          <div class="wrapper w-50 mt-4">
            <canvas height="45" id="stat-line_4"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 equel-grid">
      <div class="grid">
        <div class="grid-body">
          <div id='calendar'></div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-8 equel-grid">
      <div class="grid">
        <div class="grid-body">
          <p class="card-title">Calculation</p>
          <input type="text" name="" class="repair-complete" value="{{ number_format($count_2, 2, '.', ',') }}" hidden="">
          <div id="radial-chart"></div>
          <h4 class="text-center">O:{{$open}} | W:{{$waiting}} | C:{{$close}}</h4>
          <p class="text-center text-muted">Calculation of work order</p>
        </div>
      </div>
    </div>
    <div class="col-lg-8 col-md-6 equel-grid">
      <div class="grid table-responsive">
        <table class="table table-stretched">
          <thead>
            <tr>
              <th>User</th>
              <th>Date</th>
              <th>Machine</th>
              <th>Percent</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach($repair_5 as $r)
            <tr>
              <td class="font-weight-medium">{{ $r->name }}</td>
              <td>{{ $r->date_check }}</td>
              <td>
                <p class="mb-n1 font-weight-medium">{{ $r->lane_name }}</p>
                <small class="text-gray">{{ $r->machine_name . ' ' . $r->capacity . ' ' . $r->brand . ' ' . $r->production_year }}</small>
              </td>
              <td>{{ $r->percent . '%' }}</td>
              <td class="text-danger font-weight-medium">
                @if($r->status_check == 'open')
                <div class="badge badge-primary">{{ $r->status_check }}</div>
                @elseif($r->status_check == 'waiting')
                <div class="badge badge-warning">{{ $r->status_check }}</div>
                @elseif($r->status_check == 'close')
                <div class="badge badge-success">{{ $r->status_check }}</div>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-md-12 col-lg-7 equel-grid">
      <div class="grid">
        <div class="grid-body py-3">
          <p class="card-title ml-n1">Routine Schedule</p>
        </div>
        <div class="table-responsive">
          <table class="table table-hover table-sm">
            <thead>
              <tr class="solid-header">
                <th colspan="2" class="pl-4">Scheduler</th>
                <th>Lane</th>
                <th>Machine</th>
                <th>Period</th>
              </tr>
            </thead>
            <tbody>
              @foreach($annual_4 as $a)
              <tr>
                <td class="pr-0 pl-4">
                  <img class="profile-img img-sm" src="{{ asset('picture/'.$a->avatar) }}" alt="profile image">
                </td>
                <td class="pl-md-0" >
                  <small class="text-black font-weight-medium d-block">{{ $a->name }}</small>
                  <span class="text-gray">
                    <span class="status-indicator rounded-indicator small bg-success"></span>{{ $a->user_name }}</span>
                </td>
                <td>{{ $a->lane_name }}</td>
                <td>{{ $a->machines_name }}</td>
                <td>{{ $a->time . ' ' .  $a->period}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <a class="border-top px-3 py-2 d-block text-gray schedule-btn" href="{{ url('routine_schedule') }}" id="schedule-{{ auth()->user()->role }}">
          <small class="font-weight-medium"><i class="mdi mdi-chevron-down mr-2"></i>View All Routine Schedule</small>
        </a>
      </div>
    </div>
    <div class="col-md-4 equel-grid">
      <div class="grid">
        <div class="grid-body">
          <div class="split-header">
            <p class="card-title">Activity Log</p>
          </div>
          <div class="vertical-timeline-wrapper">
            <hr>
            <div class="timeline-vertical dashboard-timeline">
              @foreach($activity_log as $act)
              <div class="activity-log">
                <p class="log-name">{{ $act->user }}</p>
                <div class="log-details">{{ $act->description }}</div>
                <small class="log-time">{{ Carbon\Carbon::parse($act->created_at)->diffForHumans()}}</small>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        @if(auth()->user()->role == 'admin')
        <a class="border-top px-3 py-2 d-block text-gray view-activity" href="{{ url('/other_manage') }}" id="activity-{{ auth()->user()->role }}">
          <small class="font-weight-medium"><i class="mdi mdi-chevron-down mr-2"></i> View All </small>
        </a>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
<script type="text/javascript">
// $('.repair-btn').on('click', function() {
//   var id = $(this).attr('id');
//   if(id == 'repair-admin' || id == 'repair-supervisor')
//   {
//     window.location.replace("{{ url('/repair_machine') }}");
//   }else{
//     Swal.fire({
//       icon: 'error',
//       title: 'Sorry',
//       text: 'You do not have access to this page',
//       showConfirmButton: false,
//       timer: 1500
//     })
//   }
// });

// $('.schedule-btn').on('click', function() {
//   var id = $(this).attr('id');
//   if(id == 'schedule-admin' || id == 'schedule-supervisor')
//   {
//     window.location.replace("{{ url('/routine_schedule') }}");
//   }else{
//     Swal.fire({
//       icon: 'error',
//       title: 'Sorry',
//       text: 'You do not have access to this page',
//       showConfirmButton: false,
//       timer: 1500
//     })
//   }
// });

// $('.view-activity').on('click', function() {
//   var id = $(this).attr('id');
//   if(id == 'activity-admin')
//   {
//     window.location.replace("{{ url('/other_manage') }}");
//   }else{
//     Swal.fire({
//       icon: 'error',
//       title: 'Sorry',
//       text: 'You do not have access to this page',
//       showConfirmButton: false,
//       timer: 1500
//     })
//   }
// });

// $('.setting-activity').on('click', function() {
//   var id = $(this).attr('id');
//   if(id == 'setting-admin')
//   {
//     window.location.replace("{{ url('/other_manage') }}");
//   }else{
//     Swal.fire({
//       icon: 'error',
//       title: 'Sorry',
//       text: 'You do not have access to this page',
//       showConfirmButton: false,
//       timer: 1500
//     })
//   }
// });

</script>
@endsection