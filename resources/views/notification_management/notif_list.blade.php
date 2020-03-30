@foreach($schedules as $schedule)
<div class="list-group-item list-group-item-action">
	<div class="d-flex w-100 justify-content-between">
	  <h5 class="mb-1 year" style="color: #696ffb;">{{ $schedule->machine_name }} - {{ $schedule->brand }} {{ $schedule->production_year }}</h5>
	  <small>{{ $schedule->lane_name }}</small>
	</div>
	<p class="mb-1">Period : {{ $schedule->time }} {{ $schedule->period }}</p>
</div>
@endforeach