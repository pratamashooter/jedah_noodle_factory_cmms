@foreach($lanes as $lane)
<li class="list-group-item d-flex justify-content-between align-items-center">
  {{ $loop->iteration }} | &nbsp;&nbsp;&nbsp;&nbsp;{{ $lane->lane }}
  <a href="" class="delete-lane" id="{{ $lane->id }}">
    <span class="badge badge-primary badge-pill"><b>X</b></span>
  </a>
</li>
@endforeach