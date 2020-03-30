@foreach($schedules as $schedule)
  <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $schedule->schedule_code }}</td>
    <td>{{ $schedule->user_name }}</td>
    <td>{{ $schedule->lane_name }}</td>
    <td>{{ $schedule->machines_name }}</td>
    <td>{{ $schedule->time }} {{ $schedule->period }}</td>
  </tr>
@endforeach