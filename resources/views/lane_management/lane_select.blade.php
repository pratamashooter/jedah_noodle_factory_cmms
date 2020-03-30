<option value="">-- Select Lane --</option>
@foreach($lanes as $lane)
<option value="{{ $lane->id }}" class="{{ $lane->id }}">{{ $lane->lane }}</option>
@endforeach