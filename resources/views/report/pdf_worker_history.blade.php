<!DOCTYPE html>
<html>
<head>
	<title>Worker History - {{ $users->name }}</title>
	<style type="text/css">
		html{
    		font-family: Arial, Helvetica, sans-serif;
    	}
    	.page-break {
		    page-break-after: always;
		}
    	.responsive-table, td, th {  
		  border: 1px solid #ddd;
		  text-align: left;
		  font-size: 12px;
		}

		.responsive-table{
		  border-collapse: collapse;
		  width: 100%;
		}

		th, td {
		  padding: 6px;
		}

		th{
			text-align: center;
		}

		.judul2{
			margin-top: -30px;
		}
		.text-center{
			text-align: center;
		}
		.underline{
			text-decoration: underline;
		}
	</style>
</head>
<body>
	@if($routines != '' && $routines->count() != 0)
	<div class="header">
		<div class="judul1 text-center">
			<h2>Jedah Noodle Factory</h2>
		</div>
		<div class="judul2 text-center">
			<h3>Worker History</h3>
		</div>
	</div>
	<div class="body">
		<div class="body-header">
			<table style="border: none;">
				<tr>
					<td style="border: none; padding: 2px;">Worker Id</td>
					<td style="border: none; padding: 2px;">:</td>
					<td style="border: none; padding: 2px;">{{ $users->id }}</td>
				</tr>
				<tr>
					<td style="border: none; padding: 2px;">Name</td>
					<td style="border: none; padding: 2px;">:</td>
					<td style="border: none; padding: 2px;">{{ $users->name }}</td>
				</tr>
				<tr>
					<td style="border: none; padding: 2px;">Role</td>
					<td style="border: none; padding: 2px;">:</td>
					<td style="border: none; padding: 2px;">{{ $users->role }}</td>
				</tr>
			</table>
		</div><hr>
		<div class="body-content">
			<div class="text-center underline">
				<p style="font-style: italic;">Routine Activities</p>
			</div>
			<div>
				<table style="border-collapse: collapse; border: none; margin-left: 30px;">
					<tr>
						<td style="color: #a4a4a4; border: none; padding-top: -2px; text-align: right;">Open amount :</td>
						<td style="color: #000; border: none; padding-top: -2px;">{{ $routines->where('status_check', 'open')->count() }}</td>
					</tr>
					<tr>
						<td style="color: #a4a4a4; border: none; padding-top: -2px; text-align: right;">Waiting amount :</td>
						<td style="color: #000; border: none; padding-top: -2px;">{{ $routines->where('status_check', 'waiting')->count() }}</td>
					</tr>
					<tr>
						<td style="color: #a4a4a4; border: none; padding-top: -2px; text-align: right;">Close amount :</td>
						<td style="color: #000; border: none; padding-top: -2px;">{{ $routines->where('status_check', 'close')->count() }}</td>
					</tr>
				</table>
			</div>
			<div class="worker-data">
				<table class="responsive-table">
					<tr>
						<th>No</th>
						<th>Date</th>
						<th>Machine</th>
						<th>Point Check</th>
						<th>Description</th>
						<th>Progress(%)</th>
						<th>Status</th>
					</tr>
					@foreach($routines as $routine)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $routine->date_check }}</td>
						<td>{{ $routine->machine_name . ' ' . $routine->capacity . ' ' . $routine->brand . ' ' . $routine->prodution_year }}</td>
						<td>{{ $routine->point_check }}</td>
						<td>{{ $routine->description }}</td>
						<td>{{ $routine->percent }} %</td>
						<td style="text-align: center; color: #fff; @if($routine->status_check == 'open') background-color: #696ffb; @elseif($routine->status_check == 'waiting') background-color: #FF6F59; @elseif($routine->status_check == 'close') background-color: #4CCEAC; @endif">{{ $routine->status_check }}</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
		<div class="body-footer">
			<p style="font-size: 11px; color: #a4a4a4;">Comments:</p>
			<p style="font-size: 11px; color: #000;">
				@foreach($routines as $routine)
				{{ $loop->iteration . '. ' . $routine->comment . ', ' }}
				@endforeach
			</p>
		</div>
	</div>
	<div class="page-break"></div>
	@endif
	@if($repairs != '' && $repairs->count() != 0)
	<div class="header">
		<div class="judul1 text-center">
			<h2>Jedah Noodle Factory</h2>
		</div>
		<div class="judul2 text-center">
			<h3>Worker History</h3>
		</div>
	</div>
	<div class="body">
		<div class="body-header">
			<table style="border: none;">
				<tr>
					<td style="border: none; padding: 2px;">Worker Id</td>
					<td style="border: none; padding: 2px;">:</td>
					<td style="border: none; padding: 2px;">{{ $users->id }}</td>
				</tr>
				<tr>
					<td style="border: none; padding: 2px;">Name</td>
					<td style="border: none; padding: 2px;">:</td>
					<td style="border: none; padding: 2px;">{{ $users->name }}</td>
				</tr>
				<tr>
					<td style="border: none; padding: 2px;">Role</td>
					<td style="border: none; padding: 2px;">:</td>
					<td style="border: none; padding: 2px;">{{ $users->role }}</td>
				</tr>
			</table>
		</div><hr>
		<div class="body-content">
			<div class="text-center underline">
				<p style="font-style: italic;">Non Routine Activities</p>
			</div>
			<div>
				<table style="border-collapse: collapse; border: none; margin-left: 30px;">
					<tr>
						<td style="color: #a4a4a4; border: none; padding-top: -2px; text-align: right;">Open amount :</td>
						<td style="color: #000; border: none; padding-top: -2px;">{{ $repairs->where('status', 'open')->count() }}</td>
					</tr>
					<tr>
						<td style="color: #a4a4a4; border: none; padding-top: -2px; text-align: right;">Waiting amount :</td>
						<td style="color: #000; border: none; padding-top: -2px;">{{ $repairs->where('status', 'waiting')->count() }}</td>
					</tr>
					<tr>
						<td style="color: #a4a4a4; border: none; padding-top: -2px; text-align: right;">Close amount :</td>
						<td style="color: #000; border: none; padding-top: -2px;">{{ $repairs->where('status', 'close')->count() }}</td>
					</tr>
				</table>
			</div>
			<div class="worker-data">
				<table class="responsive-table">
					<tr>
						<th>No</th>
						<th>Date</th>
						<th>Machine</th>
						<th>Point Check</th>
						<th>Description</th>
						<th>Status</th>
					</tr>
					@foreach($repairs as $repair)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $repair->repair_date }}</td>
						<td>{{ $repair->machine_name . ' ' . $repair->capacity . ' ' . $repair->brand . ' ' . $repair->prodution_year }}</td>
						<td>{{ $repair->title }}</td>
						<td>{{ $repair->description }}</td>
						<td style="text-align: center; color: #fff; @if($repair->status == 'open') background-color: #696ffb; @elseif($repair->status == 'waiting') background-color: #FF6F59; @elseif($repair->status == 'close') background-color: #4CCEAC; @endif">{{ $repair->status }}</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
	@endif
</body>
</html>