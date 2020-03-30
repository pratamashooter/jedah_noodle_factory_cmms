@foreach($repairs as $repair)
  <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $repair->repair_code }}</td>
    <td>{{ $repair->repair_date }}</td>
    <td>{{ $repair->user }}</td>
    <td>{{ $repair->lane_name }}</td>
    <td>{{ $repair->machines_name }}</td>
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