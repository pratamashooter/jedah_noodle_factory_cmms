@foreach($schedules as $schedule)
<div class="dropdown-list" role="button" data-toggle="modal" data-target="#notifModal">
<div class="content-wrapper">
  <small class="name" style="color: #696ffb;">{{ $schedule->lane_name }} - {{ $schedule->machine_name }}</small><br>
  <small class="content-text">Period : {{ $schedule->time }} {{ $schedule->period }}</small>
</div>
</div>
@endforeach