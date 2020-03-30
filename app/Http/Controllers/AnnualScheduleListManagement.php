<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use Session;
use App\User;
use App\Worklist;
use App\Activitylog;
use App\Annualschedule;
use App\Annualschedulelist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnnualScheduleListManagement extends Controller
{
    // View Routine Schedule List
    public function routineScheduleList()
    {
    	return view('routine_schedule_list.routine_schedule_list');
    }

    // View My Routine Schedule List
    public function myRoutineScheduleList()
    {
        $users = User::all();

        return view('routine_schedule_list.my_schedule_list', compact('users'));
    }

    // View Schedule List
    public function view_schedule_list($id)
    {
        $views = Annualschedulelist::where('annualschedulelists.schedule_list_code', $id)
        ->join('lanes', 'annualschedulelists.lane', '=', 'lanes.id')
        ->join('machines', 'annualschedulelists.machine_code', '=', 'machines.machine_code')
        ->join('users', 'annualschedulelists.id_user', '=', 'users.id')
        ->select('annualschedulelists.*', 'lanes.lane as lane_name', 'machines.machine_name as machines_name', 'users.name as user_name')
        ->first();

        return response()->json($views);
    }

    // View My Work List
    public function MyWorkList()
    {
        return view('work_list.my_work_list');
    }

    // Table Worker
    public function TableWorker($id)
    {
        $workers = Worklist::join('users', 'users.id', '=', 'worklists.worker')
        ->where('worklists.schedule_list_code', $id)
        ->select('worklists.*', 'users.name as user_name')
        ->get();
        $workers_s = Worklist::where('schedule_list_code', $id)
        ->sum('percent');

        return response()->json([
            'workers' => $workers,
            'workers_s' => $workers_s
        ]);
    }

    // My Work List Table
    public function MyWorkTable()
    {
        $id_user = Auth::id();
        $schedules = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
        ->join('lanes', 'annualschedulelists.lane', '=', 'lanes.id')
        ->join('machines', 'annualschedulelists.machine_code', '=', 'machines.machine_code')
        ->join('users', 'worklists.worker', '=', 'users.id')
        ->select('worklists.*', 'lanes.lane as lane_name', 'machines.machine_name as machines_name', 'users.name as user_name')
        ->where('worklists.worker', $id_user)
        ->get();

        return view('work_list.myworklist_table', compact('schedules'));
    }

    // Sort My Work List Table
    public function sortMyWorkTable($id)
    {
        $id_user = Auth::id();
        $schedules = Annualschedulelist::join('worklists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
        ->join('lanes', 'annualschedulelists.lane', '=', 'lanes.id')
        ->join('machines', 'annualschedulelists.machine_code', '=', 'machines.machine_code')
        ->join('users', 'annualschedulelists.id_user', '=', 'users.id')
        ->where('worklists.worker', $id_user)
        ->select('annualschedulelists.*', 'lanes.lane as lane_name', 'machines.machine_name as machines_name', 'users.name as user_name')
        ->orderBy($id, 'ASC')
        ->get();

        return view('work_list.myworklist_sort_table', compact('schedules'));
    }

    // Table Schedule List
    public function tableScheduleList()
    {
        $schedules = Annualschedulelist::join('lanes', 'annualschedulelists.lane', '=', 'lanes.id')
        ->join('machines', 'annualschedulelists.machine_code', '=', 'machines.machine_code')
        ->join('users', 'annualschedulelists.id_user', '=', 'users.id')
        ->select('annualschedulelists.*', 'lanes.lane as lane_name', 'machines.machine_name as machines_name', 'users.name as user_name')
        ->orderBy('schedule_list_code', 'ASC')
        ->get();

        return view('routine_schedule_list.table_schedule_list', compact('schedules'));
    }

    // Sort Table Schedule List
    public function sortTableScheduleList($id)
    {
        $schedules = Annualschedulelist::join('lanes', 'annualschedulelists.lane', '=', 'lanes.id')
        ->join('machines', 'annualschedulelists.machine_code', '=', 'machines.machine_code')
        ->join('users', 'annualschedulelists.id_user', '=', 'users.id')
        ->select('annualschedulelists.*', 'lanes.lane as lane_name', 'machines.machine_name as machines_name', 'users.name as user_name')
        ->orderBy($id, 'ASC')
        ->get();
        
        return view('routine_schedule_list.sorttable_schedule_list', compact('schedules'));
    }

    // My Table Schedule List
    public function myTableScheduleList()
    {
        $id_user = Auth::id();
        $schedules = Annualschedulelist::join('lanes', 'annualschedulelists.lane', '=', 'lanes.id')
        ->join('machines', 'annualschedulelists.machine_code', '=', 'machines.machine_code')
        ->join('users', 'annualschedulelists.id_user', '=', 'users.id')
        ->select('annualschedulelists.*', 'lanes.lane as lane_name', 'machines.machine_name as machines_name', 'users.name as user_name')
        ->orderBy('schedule_list_code', 'ASC')
        ->where('id_user', '=', $id_user)
        ->get();

        return view('routine_schedule_list.my_table_schedule_list', compact('schedules'));
    }

    // My Work List Detail
    public function myWorkListDetail($id)
    {
        $id_user = Auth::id();
        $work_detail = Worklist::where('worklists.id', $id)
        ->where('worker', $id_user)
        ->select('worklists.*')
        ->first();

        return response()->json([
            'work_detail' => $work_detail
        ]);
    }

    // Save Worker
    public function SaveWorker(Request $request)
    {
        $workers = new Worklist;
        $workers->schedule_list_code = $request->schedule_list_code;
        $workers->worker = $request->worker;
        $workers->point_check = $request->point_check;
        $workers->description = $request->description;
        $workers->status_check = 'open';
        $workers->percent = 0;
        $workers->save();

        $log = new Activitylog;
        $log->id_user = Auth::id();
        $log->user = Auth::user()->name;
        $log->description = Auth::user()->name." add workers to the Routine Schedule List ". $request->schedule_list_code;
        $log->remember_token = Str::random(40);
        $log->save();

        echo $request->schedule_list_code;
    }

    // Update My Work
    public function UpdateMyWork(Request $request)
    {
        $currentDate = \Carbon\Carbon::now();
        $id_user = Auth::id();
        $my_work = Worklist::where('worklists.id', $request->schedule_list_code)
        ->where('worker', $id_user)
        ->select('worklists.*')
        ->first();
        $schedule_list_code = $my_work->schedule_list_code;
        $my_work->percent = $request->percent;
        if($request->percent == 0){
            $my_work->status_check = "open";
        }elseif($request->percent < 100){
            $my_work->status_check = "waiting";
        }elseif($request->percent == 100){
            $my_work->status_check = "close";
        }

        if($request->comment == '')
        {
            $my_work->comment = 'no comment';
        }else{
            $my_work->comment = $request->comment;
        }

        if($request->date_check == ''){
            $my_work->date_check = $currentDate = \Carbon\Carbon::now();
        }else{
            $my_work->date_check = $request->date_check;
        }

        $my_work->save();

        $log = new Activitylog;
        $log->id_user = $id_user;
        $log->user = Auth::user()->name;
        $log->description = Auth::user()->name." completing ". $request->percent ."% of the worklist";
        $log->remember_token = Str::random(40);
        $log->save();

        echo $schedule_list_code;
    }

    // Update Status
    public function UpdateStatusList($id, $status)
    {
        $schedule_list = Annualschedulelist::select('annualschedulelists.*')
        ->where('annualschedulelists.schedule_list_code', $id)
        ->first();
        $schedule_list->status = $status;
        $schedule_list->save();

        echo $status;
    }

    // Delete Schedule List
    public function DeleteScheduleList($id)
    {
        $code = Annualschedulelist::find($id);

        $log = new Activitylog;
        $log->id_user = Auth::id();
        $log->user = Auth::user()->name;
        $log->description = Auth::user()->name." delete the Routine Schedule List ". $code->schedule_list_code;
        $log->remember_token = Str::random(40);
        $log->save();

        Annualschedulelist::destroy($id);
        Worklist::where('schedule_list_code', $code->schedule_list_code)
        ->delete();

        Session::flash('deleted', 'Schedule List successfully deleted!');
        return redirect('/my_schedule_list');
    }

    // Delete Worker
    public function DeleteWorker($id)
    {
        $workers = Worklist::find($id);
        $users = User::find($workers->worker);

        $log = new Activitylog;
        $log->id_user = Auth::id();
        $log->user = Auth::user()->name;
        $log->description = Auth::user()->name ." delete " . $users->name . " from Routine Schedule List ". $workers->schedule_list_code;
        $log->remember_token = Str::random(40);
        $log->save();

        Worklist::destroy($id);

        return response()->json($workers);
    }

    // Open PDF Work Order
    public function loadReportWorkOrder(Request $request)
    {
        $id = $request->id_pdf;

        $log = new Activitylog;
        $log->id_user = Auth::id();
        $log->user = Auth::user()->name;
        $log->description = Auth::user()->name." print a worklist report";
        $log->remember_token = Str::random(40);
        $log->save();

        $worklists = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
        ->join('annualschedules', 'annualschedules.schedule_code', '=', 'annualschedulelists.schedule_code')
        ->join('machines', 'machines.machine_code', '=', 'annualschedulelists.machine_code')
        ->join('lanes', 'lanes.id', '=', 'annualschedulelists.lane')
        ->select('worklists.*', 'machines.machine_name', 'machines.brand', 'machines.capacity', 'machines.production_year', 'lanes.lane as lane_name', 'annualschedules.time', 'annualschedules.period')
        ->where('worklists.id', $id)
        ->first();

        $take_date = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
        ->join('annualschedules', 'annualschedules.schedule_code', '=', 'annualschedulelists.schedule_code')
        ->select('worklists.*', 'annualschedules.start_date')
        ->where('worklists.id', $id)
        ->first();

        $start_date = \Carbon::parse($take_date->start_date);
        $end_date = \Carbon::parse($take_date->date_check);
        $period = \Carbon\CarbonPeriod::create($start_date, $end_date);
        $periods = $period->toArray();


        $pdf = PDF::loadview('report.pdf_work_order', [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'periods' => $periods,
            'worklists' => $worklists,
            'area' => $request->area,
            'priority_1' => $request->priority_1,
            'cost' => $request->cost,
            'approximate_h' => $request->approximate_h,
            'approximate_m' => $request->approximate_m,
            'shutdown_num' => $request->shutdown_num,
            'shutdown_per' => $request->shutdown_per,
            'priority_2' => $request->priority_2
        ]);

        return $pdf->stream();
    }


    public function checkFunct()
    {
        $ss = [1,2,2,2,2,2,2,2,2];
        $k = 0;
        foreach ($ss as $s) {
            echo $k;
            echo $s.'<br>';
            $k += 1;
        }
    }
}
