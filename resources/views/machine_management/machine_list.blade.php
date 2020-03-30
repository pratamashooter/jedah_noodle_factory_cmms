@foreach($machines as $machine)
<option value="{{ $machine->machine_code }}" id="{{ $machine->machine_code }}">{{ $machine->machine_name }}</option>
@endforeach