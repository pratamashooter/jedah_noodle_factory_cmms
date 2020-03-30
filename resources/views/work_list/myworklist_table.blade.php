@foreach($schedules as $schedule)
  <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $schedule->schedule_list_code }}</td>
    <td>{{ $schedule->lane_name }}</td>
    <td>{{ $schedule->machines_name }}</td>
    <td>{{ $schedule->point_check }}</td>
    <td>{{ $schedule->description }}</td>
    <td>{{ $schedule->percent }} %</td>
    <td>
        @if($schedule->status_check == 'open')
        <div class="badge badge-primary">{{ $schedule->status_check }}</div>
        @elseif($schedule->status_check == 'waiting')
        <div class="badge badge-warning">{{ $schedule->status_check }}</div>
        @elseif($schedule->status_check == 'close')
        <div class="badge badge-success">{{ $schedule->status_check }}</div>
        @endif
    </td>
    <td class="actions">
      <div class="dropdown">
        <a href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-boundary="window">
          <i class="mdi mdi-dots-vertical mdi-1x"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
          <a class="dropdown-item menu-drop view-btn" role="button" data-toggle="modal" data-target="#viewModal" href="" id="{{ $schedule->schedule_list_code }}" data-work="{{ $schedule->id }}"><i class="mdi mdi-eye"></i>View</a>
          <a class="dropdown-item menu-drop pdf-btn" role="button" data-toggle="modal" data-target="#pdfModal" href="" data-pdf="{{ $schedule->id }}"><i class="mdi mdi-file-pdf"></i>Print PDF</a>
        </div>
      </div>
    </td>
  </tr>
@endforeach