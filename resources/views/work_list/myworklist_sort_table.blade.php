@foreach($schedules as $schedule)
  <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $schedule->schedule_list_code }}</td>
    <td>{{ $schedule->schedule_code }}</td>
    <td>{{ $schedule->user_name }}</td>
    <td>{{ $schedule->lane_name }}</td>
    <td>{{ $schedule->machines_name }}</td>
    <td>{{ $schedule->schedule_date }}</td>
    <td>
        @if($schedule->status == 'open')
        <div class="badge badge-primary">{{ $schedule->status }}</div>
        @elseif($schedule->status == 'waiting')
        <div class="badge badge-warning">{{ $schedule->status }}</div>
        @elseif($schedule->status == 'close')
        <div class="badge badge-success">{{ $schedule->status }}</div>
        @endif
    </td>
    <td class="actions">
      <div class="dropdown">
        <a href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-boundary="window">
          <i class="mdi mdi-dots-vertical mdi-1x"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
          <a class="dropdown-item menu-drop view-btn" role="button" data-toggle="modal" data-target="#viewModal" href="" id="{{ $schedule->id }}"><i class="mdi mdi-eye"></i>View</a>
        </div>
      </div>
    </td>
  </tr>
@endforeach