<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Indofood CMMS</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/iconfonts/mdi/css/materialdesignicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/shared/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo_1/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('asssets/images/favicon.ico') }}"/>
</head>
<body onload="window.print()">
	<div class="row">
		<div class="col-lg-12 text-center m-4">
			@if ($message = Session::get('loaded'))
				<h4>{{ $message }}</h4>
			@endif
		</div>
	</div><hr>
	<div class="table-responsive">
	    <table class="table table-hover">
	      <thead>
	        <tr>
	          <th>No</th>
	          <th>Schedule Code</th>
	          <th>User</th>
	          <th>Lane</th>
	          <th>Machine</th>
	          <th>Point Check</th>
	          <th>Schedule Date</th>
	          <th>Status</th>
	        </tr>
	      </thead>
	      <tbody id="table-content">
	      	@foreach($schedules as $schedule)
			  <tr>
			    <td>{{ $loop->iteration }}</td>
			    <td>{{ $schedule->schedule_code }}</td>
			    <td>{{ $schedule->user }}</td>
			    <td>{{ $schedule->lane_name }}</td>
			    <td>{{ $schedule->machines_name }}</td>
			    <td>{{ $schedule->point_check }}</td>
			    <td>{{ $schedule->schedule_date }}</td>
			    <td>{{ $schedule->status }}</td>
			  </tr>
			@endforeach
	      </tbody>
	    </table>
	  </div>
</body>
</html>