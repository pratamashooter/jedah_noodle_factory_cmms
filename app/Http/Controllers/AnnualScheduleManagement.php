<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use Carbon\Carbon;
use App\Lane;
use App\Machine;
use App\Worklist;
use App\Activitylog;
use App\Annualschedule;
use App\Annualschedulelist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnnualScheduleManagement extends Controller
{
	// Open Routine Schedule View
	public function AnnualSchedule()
	{
		return view('annual_schedule_management.annual_schedule');
	}

    // Table Schedule
    public function TableSchedule()
    {
    	$schedules = Annualschedule::join('lanes', 'annualschedules.lane', '=', 'lanes.id')
        ->join('machines', 'annualschedules.machine_code', '=', 'machines.machine_code')
        ->join('users', 'annualschedules.id_user', '=', 'users.id')
        ->select('annualschedules.*', 'lanes.lane as lane_name', 'machines.machine_name as machines_name', 'users.name as user_name')
        ->get();

    	return view('annual_schedule_management.table_schedule', compact('schedules'));
    }

    // Sorting Table Schedule
    public function SortTableSchedule($id)
    {
    	$schedules = Annualschedule::join('lanes', 'annualschedules.lane', '=', 'lanes.id')
        ->join('machines', 'annualschedules.machine_code', '=', 'machines.machine_code')
        ->join('users', 'annualschedules.id_user', '=', 'users.id')
        ->select('annualschedules.*', 'lanes.lane as lane_name', 'machines.machine_name as machines_name', 'users.name as user_name')
        ->orderBy($id, 'ASC')
        ->get();

        return view('annual_schedule_management.sort_table_schedule', compact('schedules'));
    }

    // Open My Routine Schedule View
    public function MyAnnualSchedule()
    {
    	$max = Annualschedule::max('schedule_code');
        $check_max = Annualschedule::select('annualschedules.schedule_code')->count();
        if($check_max == null){
            $max_code = "S0001";
        }else{
            $max_code = $max[1].$max[2].$max[3].$max[4];        
            $max_code++;
            if($max_code <= 9){
                $max_code = "S000".$max_code;
            }elseif ($max_code <= 99) {
                $max_code = "S00".$max_code;
            }elseif ($max_code <= 999) {
                $max_code = "S0".$max_code;
            }elseif ($max_code <= 99) {
                $max_code = "S".$max_code;
            }
        }
        $id_user = Auth::id();
        $lanes = Lane::all();
        $schedules = Annualschedule::join('lanes', 'annualschedules.lane', '=', 'lanes.id')
        ->join('machines', 'annualschedules.machine_code', '=', 'machines.machine_code')
        ->join('users', 'annualschedules.id_user', '=', 'users.id')
        ->select('annualschedules.*', 'lanes.lane as lane_name', 'machines.machine_name as machines_name', 'users.name as user_name')
        ->orderBy('schedule_code', 'ASC')
        ->where('id_user', '=', $id_user)
        ->get();
    	return view('annual_schedule_management.my_annual_schedule', compact('schedules', 'max_code', 'lanes'));
    }

    // Create Schedule
    public function CreateSchedule(Request $request)
    {
        $currentDate = \Carbon\Carbon::now();
    	$id = Auth::id();
    	$schedules = new Annualschedule;
    	$schedules->schedule_code = $request->code;
        $schedules->id_user = $id;
    	$schedules->lane = $request->lane;
    	$schedules->machine_code = $request->machine;
    	$schedules->time = $request->time;
        $schedules->period = $request->period;
        $schedules->start_date = $currentDate->isoFormat('Y-M-D');
    	$schedules->save();

        $currentDate = \Carbon\Carbon::now();
        $currentDate1 = $currentDate->isoFormat('Y-M-D');

        $maxs = Annualschedulelist::max('schedule_list_code');
        $check_maxs = Annualschedulelist::select('annualschedulelists.schedule_list_code')->count();
        if($check_maxs == null){
            $max_codes = "L0001";
        }else{
            $max_codes = $maxs[1].$maxs[2].$maxs[3].$maxs[4];
            $max_codes++;
            if($max_codes <= 9){
                $max_codes = "L000".$max_codes;
            }elseif ($max_codes <= 99) {
                $max_codes = "L00".$max_codes;
            }elseif ($max_codes <= 999) {
                $max_codes = "L0".$max_codes;
            }elseif ($max_codes <= 99) {
                $max_codes = "L".$max_codes;
            }
        }
        $schedule_lists = new Annualschedulelist;
        $schedule_lists->schedule_list_code = $max_codes;
        $schedule_lists->schedule_code = $request->code;
        $schedule_lists->id_user = $id;
        $schedule_lists->lane = $request->lane;
        $schedule_lists->machine_code = $request->machine;
        $schedule_lists->schedule_date = $currentDate1;
        $schedule_lists->status = 'open';
        $schedule_lists->save();

        for($i = 1; $i < $request->amount; $i ++)
        {
            $max = Annualschedulelist::max('schedule_list_code');
            $check_max = Annualschedulelist::select('annualschedulelists.schedule_list_code')->count();
            if($check_max == null){
                $max_code = "L0001";
            }else{
                $max_code = $max[1].$max[2].$max[3].$max[4];
                $max_code++;
                if($max_code <= 9){
                    $max_code = "L000".$max_code;
                }elseif ($max_code <= 99) {
                    $max_code = "L00".$max_code;
                }elseif ($max_code <= 999) {
                    $max_code = "L0".$max_code;
                }elseif ($max_code <= 99) {
                    $max_code = "L".$max_code;
                }
            }
            $schedule_list = new Annualschedulelist;
            $schedule_list->schedule_list_code = $max_code;
            $schedule_list->schedule_code = $request->code;
            $schedule_list->id_user = $id;
            $schedule_list->lane = $request->lane;
            $schedule_list->machine_code = $request->machine;
            if($request->period == 'week')
            {
                $week = $currentDate->add($request->time, 'week');
                $schedule_list->schedule_date = $week->isoFormat('Y-M-D');
            }
            elseif ($request->period == 'month') 
            {
                $month = $currentDate->add($request->time, 'month');
                $schedule_list->schedule_date = $month->isoFormat('Y-M-D');
            }
            elseif ($request->period == 'year') 
            {
                $year = $currentDate->add($request->time, 'year');
                $schedule_list->schedule_date = $year->isoFormat('Y-M-D');
            }
            $schedule_list->status = 'open';
            $schedule_list->save();
        }

        $log = new Activitylog;
        $log->id_user = $request->user()->id;
        $log->user = $request->user()->name;
        $log->description = $request->user()->name." added a new Routine Schedule";
        $log->remember_token = Str::random(40);
        $log->save();

    	Session::flash('created', 'Schedule successfully created!');
    	return redirect('/my_routine_schedule');
    }

    // Select Machine By Lane
    public function MachineSelect($id)
    {
    	$machines = Machine::orderBy('machine_code', 'ASC')
        ->where('lane', $id)
        ->get();

    	return view('machine_management.machine_list', compact('machines'));
    }

    // Edit Schedule
    public function EditSchedule($id)
    {
    	$schedules = Annualschedule::find($id);

    	return response()->json($schedules);
    }

    // Update Schedule
    public function UpdateSchedule(Request $request, $id)
    {
        $currentDate = \Carbon\Carbon::now();
    	$schedules = Annualschedule::find($id);
    	$schedules->lane = $request->lane;
        $schedules->machine_code = $request->machine;
        $schedules->time = $request->time;
        $schedules->period = $request->period;
        $schedules->start_date = $currentDate->isoFormat('Y-M-D');
    	$schedules->save();

        $log = new Activitylog;
        $log->id_user = $request->user()->id;
        $log->user = $request->user()->name;
        $log->description = $request->user()->name . " changes the Routine Schedule " . $schedules->schedule_code;
        $log->remember_token = Str::random(40);
        $log->save();

    	Session::flash('updated', 'Schedule successfully updated!');
    	echo "success";
    }

    // Delete Schedule
    public function DeleteSchedule($id)
    {
    	$schedules = Annualschedule::find($id);
        $schedules->delete();

        $worklist = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
        ->where('annualschedulelists.schedule_code', $schedules->schedule_code)
        ->select('worklists.*')
        ->first();

        if($worklist){
            $delete_work_list = Worklist::where('schedule_list_code', $worklist->schedule_list_code)
            ->delete();
        }

        $schedule_list = Annualschedulelist::where('schedule_code', $schedules->schedule_code)
        ->delete();

        $log = new Activitylog;
        $log->id_user = Auth::id();
        $log->user = Auth::user()->name;
        $log->description = Auth::user()->name." deletes the Routine Schedule " . $schedules->schedule_code;
        $log->remember_token = Str::random(40);
        $log->save();

    	Session::flash('deleted', 'Schedule successfully deleted!');
    	return redirect('/my_routine_schedule');
    }
}