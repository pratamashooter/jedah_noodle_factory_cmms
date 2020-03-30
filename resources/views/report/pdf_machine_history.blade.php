<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width">
	<title>Machine History</title>
	<style type="text/css">
		html{
    		font-family: Arial, Helvetica, sans-serif;
    	}
    	.page-break {
		    page-break-after: always;
		}
		.worker-data{
			margin-left: 30px;
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
		.content{
			width: 100%;
			font-size: 0;
		}
		.content > div{
			display: inline-block;
			font-size: 13px;
			text-align: center;
			border: 1px solid black;
			width: 20px;
		}

		th{
			text-align: center;
		}

		.judul2{
			margin-top: 0px;
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
	<div class="header">
		<div class="judul1 text-center">
			<h2>PINEHILL ARABIA FOOD LTD</h2>
			<p style="margin-top: -20px;">TECHINC JNF</p>
		</div>
		<div class="judul2 text-center">
			<p>
				@if($status == 'open')
				Open
				@elseif($status == 'waiting')
				Waiting
				@elseif($status == 'close')
				Close
				@else
				All
				@endif
				 Work Order
			</p>
		</div>
	</div>
	<div class="body">
		<div class="body-header">
			<table style="border: none; width: 100%; margin-bottom: -10px;">
				<tr>
					<td style="border: none; text-align: left;">Responsible person :</td>
					<td style="border: none; text-align: right;">
						@if(!empty($machine_name))
						@php
						$routines_max_date = \App\Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')->select(DB::raw('max(worklists.date_check) as max_date'))->where('annualschedulelists.lane', $machine_name->code_lane)->where('annualschedulelists.machine_code', $machine_name->code_machine)->first();
				        $routines_min_date = \App\Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')->select(DB::raw('min(worklists.date_check) as min_date'))->where('annualschedulelists.lane', $machine_name->code_lane)->where('annualschedulelists.machine_code', $machine_name->code_machine)->first();
						@endphp
						@endif
						

						@if($start_date != '' && $end_date != '')
						from: {{ DateTime::createFromFormat('Y-m-d', $start_date)->format('d-M-Y') }} to: {{ DateTime::createFromFormat('Y-m-d', $end_date)->format('d-M-Y') }}
						@elseif(!empty($routines_max_date) && $routines_max_date->max_date != '')
						from: {{ DateTime::createFromFormat('Y-m-d', $routines_min_date->min_date)->format('d-M-Y') }} to: {{ DateTime::createFromFormat('Y-m-d', $routines_max_date->max_date)->format('d-M-Y') }}
						@else
						No data
						@endif
					</td>
				</tr>
			</table>
		</div><hr>
		<div class="body-content">
			<table style="border: 1px solid #000; width: 100%; margin-top: -5px; background-color: #e0e0e3;">
				<tr>
					<td style="font-size: 14px; padding: 1px;">
						@if(!empty($machine_name->lane_name))
						{{ $machine_name->machine_name . ' ' . $machine_name->capacity . ' ' . $machine_name->brand . ' ' . $machine_name->production_year }}
						@else
						No data
						@endif
					</td>
				</tr>
			</table>
			<div class="text-center underline">
				<p style="font-size: 13px; font-style: italic; text-align: left; margin-left: 35px;">Routine Activities</p>
			</div>
			@foreach($routines as $routine)
			<div class="data-content">
				<div class="work-title">
					<p style="font-size: 12px;">{{ $loop->iteration . '. ' . $routine->point_check }}</p>
				</div>
				<div class="worker-data">
					<div class="content">@foreach($routines_date as $date)<div class="data">@php $worklists = \App\Worklist::select('worklists.*')->where('point_check', $routine->point_check)->where('date_check', $date->format('Y-m-d'))->first(); @endphp @if(!empty($worklists->date_check) && $worklists->date_check == $date->format('Y-m-d'))<b style="@if($worklists->status_check == 'open') color: #696ffb; @elseif($worklists->status_check == 'waiting') color:#FF6F59; @elseif($worklists->status_check == 'close') color: #4CCEAC; @endif">{{ $date->format('d') }}</b>@else{{$date->format('d')}}@endif</div>@endforeach</div>
				</div>
			</div>
			@endforeach
		</div>
		<div class="body-footer">
			<p style="font-size: 11px; color: grey;">Comments:</p>
			<p style="font-size: 11px; color: #000;">@foreach($routines as $routine) @php $worklists = \App\Worklist::select('worklists.*')->where('point_check', $routine->point_check)->first(); @endphp {{ $loop->iteration . '. ' . $worklists->comment . ', ' }} @endforeach</p>
		</div>
	</div>
	<div class="page-break"></div>
	<div class="header">
		<div class="judul1 text-center">
			<h2>PINEHILL ARABIA FOOD LTD</h2>
			<p style="margin-top: -20px;">TECHINC JNF</p>
		</div>
		<div class="judul2 text-center">
			<p>
				@if($status == 'open')
				Open
				@elseif($status == 'waiting')
				Waiting
				@elseif($status == 'close')
				Close
				@else
				All
				@endif
				 Work Order
			</p>
		</div>
	</div>
	<div class="body">
		<div class="body-header">
			<table style="border: none; width: 100%; margin-bottom: -10px;">
				<tr>
					<td style="border: none; text-align: left;">Responsible person :</td>
					<td style="border: none; text-align: right;">
						@if(!empty($machine_name))
						@php
						$repairs_max_date = \App\Improvement::select(DB::raw('max(improvements.repair_date) as max_date'))->where('improvements.lane', $machine_name->code_lane)->where('improvements.machine', $machine_name->code_machine)->first();
				        $repairs_min_date = \App\Improvement::select(DB::raw('min(improvements.repair_date) as min_date'))->where('improvements.lane', $machine_name->code_lane)->where('improvements.machine', $machine_name->code_machine)->first();
						@endphp
						@endif
						
						@if($start_date != '' && $end_date != '')
						from: {{ $start_date }} to: {{ $end_date }}
						@elseif(!empty($repairs_max_date) && $repairs_max_date->max_date != '')
						from: {{ $repairs_min_date->min_date }} to: {{ $repairs_max_date->max_date }}
						@else
						No data
						@endif
					</td>
				</tr>
			</table>
		</div><hr>
		<div class="body-content">
			<table style="border: 1px solid #000; width: 100%; margin-top: -5px; background-color: #e0e0e3;">
				<tr>
					<td style="font-size: 14px; padding: 1px;">
						@if(!empty($machine_name->lane_name))
						{{ $machine_name->machine_name . ' ' . $machine_name->capacity . ' ' . $machine_name->brand . ' ' . $machine_name->production_year }}
						@else
						No data
						@endif
					</td>
				</tr>
			</table>
			<div class="text-center underline">
				<p style="font-size: 13px; font-style: italic; text-align: left; margin-left: 35px;">Non Routine Activities</p>
			</div>
			@foreach($repairs as $repair)
			<div class="data-content">
				<div class="work-title">
					<p style="font-size: 12px;">{{ $loop->iteration . '. ' . $repair->title }}</p>
				</div>
				<div class="worker-data">
					<div class="content">@foreach($repairs_date as $date)<div class="data">@php $improvements = \App\Improvement::select('improvements.*')->where('title', $repair->title)->where('repair_date', $date->format('Y-m-d'))->first(); @endphp @if(!empty($improvements->repair_date) && $improvements->repair_date == $date->format('Y-m-d'))<b style="@if($improvements->status == 'open') color: #696ffb; @elseif($improvements->status == 'waiting') color:#FF6F59; @elseif($improvements->status == 'close') color: #4CCEAC; @endif">{{ $date->format('d') }}</b>@else{{$date->format('d')}}@endif</div>@endforeach</div>
				</div>
			</div>
			@endforeach
		</div>
		<div class="body-footer">
			<p style="font-size: 11px; color: grey;">Description:</p>
			<p style="font-size: 11px; color: #000;">@foreach($repairs as $repair) @php $improvements = \App\Improvement::select('improvements.*')->where('title', $repair->title)->first(); @endphp {{ $loop->iteration . '. ' . $improvements->description . ', ' }} @endforeach</p>
		</div>
	</div>
</body>
</html>