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
<body>
	<div class="row">
		<div class="col-lg-12 text-center" style="margin: 20px;">
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
              <th>Repair Code</th>
              <th>Repair Date</th>
              <th>User</th>
              <th>Lane</th>
              <th>Machine</th>
              <th>Title</th>
              <th>Description</th>
              <th>Status</th>
	        </tr>
	      </thead>
	      <tbody id="table-content">
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
			    <td>{{ $repair->status }}</td>
			  </tr>
			@endforeach
	      </tbody>
	    </table>
	  </div>
</body>
</html>