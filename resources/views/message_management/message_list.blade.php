@foreach($messages as $message)
	@if($message->id_user == auth()->user()->id)
		<div class="activity-log my-activity-log">
			<p class="log-name">{{ $message->name }} (Me)</p>
			<div class="log-details">{{ $message->message }}</div>
			<small class="log-time">{{ Carbon\Carbon::parse($message->created_at)->diffForHumans()}}</small>
		</div>
	@else
		<div class="activity-log">
			<p class="log-name">{{ $message->name }}</p>
			<div class="log-details">{{ $message->message }}</div>
			<small class="log-time">{{ Carbon\Carbon::parse($message->created_at)->diffForHumans()}}</small>
		</div>
	@endif
@endforeach