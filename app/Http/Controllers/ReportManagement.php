<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use Session;
use App\Lane;
use App\User;
use App\Machine;
use App\Worklist;
use App\Improvement;
use App\Activitylog;
use App\Annualschedule;
use App\Annualschedulelist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReportManagement extends Controller
{
    // Open Report View
    public function ReportManagement()
    {
        $users = User::all();
        $lanes = Lane::all();

    	return view('report.report', compact('users', 'lanes'));
    }

    // Open Worker History
    public function WorkerHistory($id)
    {
        $users = User::find($id);
        $worklists = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
        ->join('annualschedules', 'annualschedules.schedule_code', '=', 'annualschedulelists.schedule_code')
        ->join('machines', 'machines.machine_code', '=', 'annualschedules.machine_code')
        ->join('lanes', 'lanes.id', '=', 'annualschedules.lane')
        ->where('worklists.worker', $id)
        ->select('worklists.*', 'machines.machine_name', 'lanes.lane as lane_name')
        ->get();
        $repairs = Improvement::join('lanes', 'lanes.id', '=', 'improvements.lane')
        ->join('machines', 'machines.machine_code', '=', 'improvements.machine')
        ->where('improvements.id_user', $id)
        ->select('improvements.*', 'lanes.lane as lane_name', 'machines.machine_name as machine_name')
        ->get();

        return view('report.worker_history', compact('users', 'worklists', 'repairs', 'id'));
    }

    // Filter Annual Schedule
    public function FilterAnnual(Request $request)
    {	
    	$schedules = DB::table('annualschedules')
        ->join('lanes', 'annualschedules.lane', '=', 'lanes.id')
        ->join('machines', 'annualschedules.machine_name', '=', 'machines.machine_code')
        ->select('annualschedules.*', 'lanes.lane as lane_name', 'machines.machine_name as machines_name')
        ->whereBetween('schedule_date', array($request->start_date, $request->end_date))
        ->get();
        $start_date = $request->start_date;
        $end_date = $request->end_date;

    	return response()->json(['schedules' => $schedules, 'start_date' => $start_date, 'end_date' => $end_date]);
    }

    // Filter Repair
    public function FilterRepair(Request $request)
    {	
    	$repairs = DB::table('improvements')
        ->join('lanes', 'improvements.lane', '=', 'lanes.id')
        ->join('machines', 'improvements.machine', '=', 'machines.machine_code')
        ->select('improvements.*', 'lanes.lane as lane_name', 'machines.machine_name as machines_name')
        ->whereBetween('repair_date', array($request->start_date, $request->end_date))
        ->get();
        $start_date = $request->start_date;
        $end_date = $request->end_date;

    	return response()->json(['repairs' => $repairs, 'start_date' => $start_date, 'end_date' => $end_date]);
    }

    // Open PRINTAnnual Page
    public function PRINTAnnual(Request $request)
    {
    	$schedules = DB::table('annualschedules')
        ->join('lanes', 'annualschedules.lane', '=', 'lanes.id')
        ->join('machines', 'annualschedules.machine_name', '=', 'machines.machine_code')
        ->select('annualschedules.*', 'lanes.lane as lane_name', 'machines.machine_name as machines_name')
        ->whereBetween('schedule_date', array($request->start_date, $request->end_date))
        ->get();
        $loaded = "Annual Schedule Report From ".$request->start_date." To ".$request->end_date;

        Session::flash('loaded', $loaded);
        return view('report.print_annual', compact('schedules'));
    }

    // Open PDFAnnual Page
    public function PDFAnnual(Request $request)
    {
    	$schedules = DB::table('annualschedules')
        ->join('lanes', 'annualschedules.lane', '=', 'lanes.id')
        ->join('machines', 'annualschedules.machine_name', '=', 'machines.machine_code')
        ->select('annualschedules.*', 'lanes.lane as lane_name', 'machines.machine_name as machines_name')
        ->whereBetween('schedule_date', array($request->start_date, $request->end_date))
        ->get();
        $loaded = "Annual Schedule Report From ".$request->start_date." To ".$request->end_date;

        Session::flash('loaded', $loaded);
        $pdf = PDF::loadView('report.pdf_annual', ['schedules' => $schedules]);
        return $pdf->download('annual_schedule_report.pdf');
    }

    // Open PRINTRepair Page
    public function PRINTRepair(Request $request)
    {
    	$repairs = DB::table('improvements')
        ->join('lanes', 'improvements.lane', '=', 'lanes.id')
        ->join('machines', 'improvements.machine', '=', 'machines.machine_code')
        ->select('improvements.*', 'lanes.lane as lane_name', 'machines.machine_name as machines_name')
        ->whereBetween('repair_date', array($request->start_date, $request->end_date))
        ->get();
        $loaded = "Repair Report From ".$request->start_date." To ".$request->end_date;

        Session::flash('loaded', $loaded);
        return view('report.print_repair', compact('repairs'));
    }

    // Open PDFRepair Page
    public function PDFRepair(Request $request)
    {
    	$repairs = DB::table('improvements')
        ->join('lanes', 'improvements.lane', '=', 'lanes.id')
        ->join('machines', 'improvements.machine', '=', 'machines.machine_code')
        ->select('improvements.*', 'lanes.lane as lane_name', 'machines.machine_name as machines_name')
        ->whereBetween('repair_date', array($request->start_date, $request->end_date))
        ->get();
        $loaded = "Repair Report From ".$request->start_date." To ".$request->end_date;

        Session::flash('loaded', $loaded);
        $pdf = PDF::loadView('report.pdf_repair', [
            'repairs' => $repairs
        ]);
        return $pdf->download('repair_report.pdf');
    }

    // Open PDF Worker History
    public function PrintWorkerHistory(Request $request, $id)
    {
        $users = User::find($id);

        $log = new Activitylog;
        $log->id_user = Auth::id();
        $log->user = Auth::user()->name;
        $log->description = Auth::user()->name." print a worker history report";
        $log->remember_token = Str::random(40);
        $log->save();

        if($request->report_type == 'all'){
            if($request->status != 'all'){
                if($request->check_history != 'true'){
                    $routines = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
                    ->join('annualschedules', 'annualschedules.schedule_code', '=', 'annualschedulelists.schedule_code')
                    ->join('machines', 'machines.machine_code', '=', 'annualschedules.machine_code')
                    ->join('lanes', 'lanes.id', '=', 'annualschedules.lane')
                    ->where('worklists.worker', $id)
                    ->where('worklists.status_check', $request->status)
                    ->whereBetween('worklists.date_check', array($request->start_date, $request->end_date))
                    ->select('worklists.*', 'machines.machine_name', 'lanes.lane as lane_name', 'machines.brand', 'machines.capacity', 'machines.production_year')
                    ->get();
                    $repairs = Improvement::join('lanes', 'lanes.id', '=', 'improvements.lane')
                    ->join('machines', 'machines.machine_code', '=', 'improvements.machine')
                    ->where('improvements.id_user', $id)
                    ->where('improvements.status', $request->status)
                    ->whereBetween('improvements.repair_date', array($request->start_date, $request->end_date))
                    ->select('improvements.*', 'lanes.lane as lane_name', 'machines.brand', 'machines.capacity', 'machines.production_year', 'machines.machine_name as machine_name')
                    ->get();
                }else{
                    $routines = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
                    ->join('annualschedules', 'annualschedules.schedule_code', '=', 'annualschedulelists.schedule_code')
                    ->join('machines', 'machines.machine_code', '=', 'annualschedules.machine_code')
                    ->join('lanes', 'lanes.id', '=', 'annualschedules.lane')
                    ->where('worklists.worker', $id)
                    ->where('worklists.status_check', $request->status)
                    ->select('worklists.*', 'machines.machine_name', 'lanes.lane as lane_name', 'machines.brand', 'machines.capacity', 'machines.production_year')
                    ->get();
                    $repairs = Improvement::join('lanes', 'lanes.id', '=', 'improvements.lane')
                    ->join('machines', 'machines.machine_code', '=', 'improvements.machine')
                    ->where('improvements.id_user', $id)
                    ->where('improvements.status', $request->status)
                    ->select('improvements.*', 'lanes.lane as lane_name', 'machines.brand', 'machines.capacity', 'machines.production_year', 'machines.machine_name as machine_name')
                    ->get();
                }
            }else{
                if($request->check_history != 'true'){
                    $routines = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
                    ->join('annualschedules', 'annualschedules.schedule_code', '=', 'annualschedulelists.schedule_code')
                    ->join('machines', 'machines.machine_code', '=', 'annualschedules.machine_code')
                    ->join('lanes', 'lanes.id', '=', 'annualschedules.lane')
                    ->where('worklists.worker', $id)
                    ->whereBetween('worklists.date_check', array($request->start_date, $request->end_date))
                    ->select('worklists.*', 'machines.machine_name', 'lanes.lane as lane_name', 'machines.brand', 'machines.capacity', 'machines.production_year')
                    ->get();
                    $repairs = Improvement::join('lanes', 'lanes.id', '=', 'improvements.lane')
                    ->join('machines', 'machines.machine_code', '=', 'improvements.machine')
                    ->where('improvements.id_user', $id)
                    ->whereBetween('improvements.repair_date', array($request->start_date, $request->end_date))
                    ->select('improvements.*', 'lanes.lane as lane_name', 'machines.brand', 'machines.capacity', 'machines.production_year', 'machines.machine_name as machine_name')
                    ->get();
                }else{
                    $routines = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
                    ->join('annualschedules', 'annualschedules.schedule_code', '=', 'annualschedulelists.schedule_code')
                    ->join('machines', 'machines.machine_code', '=', 'annualschedules.machine_code')
                    ->join('lanes', 'lanes.id', '=', 'annualschedules.lane')
                    ->where('worklists.worker', $id)
                    ->select('worklists.*', 'machines.machine_name', 'lanes.lane as lane_name', 'machines.brand', 'machines.capacity', 'machines.production_year')
                    ->get();
                    $repairs = Improvement::join('lanes', 'lanes.id', '=', 'improvements.lane')
                    ->join('machines', 'machines.machine_code', '=', 'improvements.machine')
                    ->where('improvements.id_user', $id)
                    ->select('improvements.*', 'lanes.lane as lane_name', 'machines.brand', 'machines.capacity', 'machines.production_year', 'machines.machine_name as machine_name')
                    ->get();
                }
            }
        }elseif($request->report_type == 'routine_schedule'){
            if($request->status != 'all'){
                if($request->check_history != 'true'){
                    $routines = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
                    ->join('annualschedules', 'annualschedules.schedule_code', '=', 'annualschedulelists.schedule_code')
                    ->join('machines', 'machines.machine_code', '=', 'annualschedules.machine_code')
                    ->join('lanes', 'lanes.id', '=', 'annualschedules.lane')
                    ->where('worklists.worker', $id)
                    ->where('worklists.status_check', $request->status)
                    ->whereBetween('worklists.date_check', array($request->start_date, $request->end_date))
                    ->select('worklists.*', 'machines.machine_name', 'lanes.lane as lane_name', 'machines.brand', 'machines.capacity', 'machines.production_year')
                    ->get();
                    $repairs = '';
                }else{
                    $routines = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
                    ->join('annualschedules', 'annualschedules.schedule_code', '=', 'annualschedulelists.schedule_code')
                    ->join('machines', 'machines.machine_code', '=', 'annualschedules.machine_code')
                    ->join('lanes', 'lanes.id', '=', 'annualschedules.lane')
                    ->where('worklists.worker', $id)
                    ->where('worklists.status_check', $request->status)
                    ->select('worklists.*', 'machines.machine_name', 'lanes.lane as lane_name', 'machines.brand', 'machines.capacity', 'machines.production_year')
                    ->get();
                    $repairs = '';
                }
            }else{
                if($request->check_history != 'true'){
                    $routines = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
                    ->join('annualschedules', 'annualschedules.schedule_code', '=', 'annualschedulelists.schedule_code')
                    ->join('machines', 'machines.machine_code', '=', 'annualschedules.machine_code')
                    ->join('lanes', 'lanes.id', '=', 'annualschedules.lane')
                    ->where('worklists.worker', $id)
                    ->whereBetween('worklists.date_check', array($request->start_date, $request->end_date))
                    ->select('worklists.*', 'machines.machine_name', 'lanes.lane as lane_name', 'machines.brand', 'machines.capacity', 'machines.production_year')
                    ->get();
                    $repairs = '';
                }else{
                    $routines = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
                    ->join('annualschedules', 'annualschedules.schedule_code', '=', 'annualschedulelists.schedule_code')
                    ->join('machines', 'machines.machine_code', '=', 'annualschedules.machine_code')
                    ->join('lanes', 'lanes.id', '=', 'annualschedules.lane')
                    ->where('worklists.worker', $id)
                    ->select('worklists.*', 'machines.machine_name', 'lanes.lane as lane_name', 'machines.brand', 'machines.capacity', 'machines.production_year')
                    ->get();
                    $repairs = '';
                }
            }
        }elseif($request->report_type == 'non_routine_schedule') {
            if($request->status != 'all'){
                if($request->check_history != 'true'){
                    $routines = '';
                    $repairs = Improvement::join('lanes', 'lanes.id', '=', 'improvements.lane')
                    ->join('machines', 'machines.machine_code', '=', 'improvements.machine')
                    ->where('improvements.id_user', $id)
                    ->where('improvements.status', $request->status)
                    ->whereBetween('improvements.repair_date', array($request->start_date, $request->end_date))
                    ->select('improvements.*', 'lanes.lane as lane_name', 'machines.brand', 'machines.capacity', 'machines.production_year', 'machines.machine_name as machine_name')
                    ->get();
                }else{
                    $routines = '';
                    $repairs = Improvement::join('lanes', 'lanes.id', '=', 'improvements.lane')
                    ->join('machines', 'machines.machine_code', '=', 'improvements.machine')
                    ->where('improvements.id_user', $id)
                    ->where('improvements.status', $request->status)
                    ->select('improvements.*', 'lanes.lane as lane_name', 'machines.brand', 'machines.capacity', 'machines.production_year', 'machines.machine_name as machine_name')
                    ->get();
                }
            }else{
                if($request->check_history != 'true'){
                    $routines = '';
                    $repairs = Improvement::join('lanes', 'lanes.id', '=', 'improvements.lane')
                    ->join('machines', 'machines.machine_code', '=', 'improvements.machine')
                    ->where('improvements.id_user', $id)
                    ->whereBetween('improvements.repair_date', array($request->start_date, $request->end_date))
                    ->select('improvements.*', 'lanes.lane as lane_name', 'machines.brand', 'machines.capacity', 'machines.production_year', 'machines.machine_name as machine_name')
                    ->get();
                }else{
                    $routines = '';
                    $repairs = Improvement::join('lanes', 'lanes.id', '=', 'improvements.lane')
                    ->join('machines', 'machines.machine_code', '=', 'improvements.machine')
                    ->where('improvements.id_user', $id)
                    ->select('improvements.*', 'lanes.lane as lane_name', 'machines.brand', 'machines.capacity', 'machines.production_year', 'machines.machine_name as machine_name')
                    ->get();
                }
            }
        }

        $pdf = PDF::loadview('report.pdf_worker_history', [
            'users' => $users, 
            'routines' => $routines, 
            'repairs' => $repairs
        ]);
        return $pdf->stream();
    }

    // Open PDF Machine History
    public function loadReportMachine(Request $request)
    {
        if($request->status == 'open'){
            $status = 'open';
        }else if($request->status == 'waiting'){
            $status = 'waiting';
        }else if($request->status == 'close'){
            $status = 'close';
        }else{
            $status = 'all';
        }

        $log = new Activitylog;
        $log->id_user = Auth::id();
        $log->user = Auth::user()->name;
        $log->description = Auth::user()->name." print a machine history report";
        $log->remember_token = Str::random(40);
        $log->save();

        $worklist_count = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
        ->select('worklists.*')
        ->where('annualschedulelists.lane', $request->lane)
        ->where('annualschedulelists.machine_code', $request->machine)
        ->count();
        $repairs_count = Improvement::select('improvements.*')
        ->where('improvements.lane', $request->lane)
        ->where('improvements.machine', $request->machine)
        ->count();

        if($worklist_count != 0){
            $machine_name = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
            ->join('annualschedules', 'annualschedules.schedule_code', '=', 'annualschedulelists.schedule_code')
            ->join('machines', 'machines.machine_code', '=', 'annualschedules.machine_code')
            ->join('lanes', 'lanes.id', '=', 'annualschedules.lane')
            ->select('worklists.*', 'machines.machine_code as code_machine', 'machines.machine_name as machine_name', 'machines.brand', 'machines.capacity', 'machines.production_year', 'lanes.id as code_lane', 'lanes.lane as lane_name')
            ->where('annualschedulelists.lane', $request->lane)
            ->where('annualschedulelists.machine_code', $request->machine)
            ->first();
        }else if($repairs_count != 0){
            $machine_name = Improvement::join('machines', 'machines.machine_code', '=', 'improvements.machine')
            ->join('lanes', 'lanes.id', '=', 'improvements.lane')
            ->select('improvements.*', 'machines.machine_code as code_machine', 'machines.machine_name as machine_name', 'machines.brand', 'machines.capacity', 'machines.production_year', 'lanes.id as code_lane', 'lanes.lane as lane_name')
            ->where('improvements.lane', $request->lane)
            ->where('improvements.machine', $request->machine)
            ->first();
        }else{
            $machine_name = '';
        }

        if($status != 'all')
        {
            if($request->check_history != 'true')
            {
                $routines = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
                ->select('worklists.point_check')
                ->where('annualschedulelists.lane', $request->lane)
                ->where('annualschedulelists.machine_code', $request->machine)
                ->where('worklists.status_check', $status)
                ->whereBetween('worklists.date_check', array($request->start_date, $request->end_date))
                ->distinct()
                ->get();
                $repairs = Improvement::select('improvements.title')
                ->where('improvements.lane', $request->lane)
                ->where('improvements.machine', $request->machine)
                ->where('improvements.status', $status)
                ->whereBetween('improvements.repair_date', array($request->start_date, $request->end_date))
                ->distinct()
                ->get();
            }else{
                $routines = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
                ->select('worklists.point_check')
                ->where('annualschedulelists.lane', $request->lane)
                ->where('annualschedulelists.machine_code', $request->machine)
                ->where('worklists.status_check', $status)
                ->distinct()
                ->get();
                $repairs = Improvement::select('improvements.title')
                ->where('improvements.lane', $request->lane)
                ->where('improvements.machine', $request->machine)
                ->where('improvements.status', $status)
                ->distinct()
                ->get();
            }
        }else{
            if($request->check_history != 'true')
            {
                $routines = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
                ->select('worklists.point_check')
                ->where('annualschedulelists.lane', $request->lane)
                ->where('annualschedulelists.machine_code', $request->machine)
                ->whereBetween('worklists.date_check', array($request->start_date, $request->end_date))
                ->distinct()
                ->get();
                $repairs = Improvement::select('improvements.title')
                ->where('improvements.lane', $request->lane)
                ->where('improvements.machine', $request->machine)
                ->whereBetween('improvements.repair_date', array($request->start_date, $request->end_date))
                ->distinct()
                ->get();
            }else{
                $routines = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
                ->select('worklists.point_check')
                ->where('annualschedulelists.lane', $request->lane)
                ->where('annualschedulelists.machine_code', $request->machine)
                ->distinct()
                ->get();
                $repairs = Improvement::select('improvements.title')
                ->where('improvements.lane', $request->lane)
                ->where('improvements.machine', $request->machine)
                ->distinct()
                ->get();
            }
        }

        $routines_max_date = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
        ->select(DB::raw('max(worklists.date_check) as max_date'))
        ->where('annualschedulelists.lane', $request->lane)
        ->where('annualschedulelists.machine_code', $request->machine)
        ->first();
        $routines_min_date = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
        ->select(DB::raw('min(worklists.date_check) as min_date'))
        ->where('annualschedulelists.lane', $request->lane)
        ->where('annualschedulelists.machine_code', $request->machine)
        ->first();
        $repairs_max_date = Improvement::select(DB::raw('max(improvements.repair_date) as max_date'))
        ->where('improvements.lane', $request->lane)
        ->where('improvements.machine', $request->machine)
        ->first();
        $repairs_min_date = Improvement::select(DB::raw('min(improvements.repair_date) as min_date'))
        ->where('improvements.lane', $request->lane)
        ->where('improvements.machine', $request->machine)
        ->first();

        if($request->check_history != 'true'){
            $period = \Carbon\CarbonPeriod::create($request->start_date, $request->end_date);
            $routines_date = $period->toArray();
            $repairs_date = $period->toArray();
        }else{
            $ro_min_d = \Carbon::parse($routines_min_date->min_date);
            $ro_max_d = \Carbon::parse($routines_max_date->max_date);
            $re_min_d = \Carbon::parse($repairs_min_date->min_date);
            $re_max_d = \Carbon::parse($repairs_max_date->max_date);
            $period_routines = \Carbon\CarbonPeriod::create($ro_min_d, $ro_max_d);
            $period_repairs = \Carbon\CarbonPeriod::create($re_min_d, $re_max_d);
            $routines_date = $period_routines->toArray();
            $repairs_date = $period_repairs->toArray();
        }

        $pdf = PDF::loadview('report.pdf_machine_history', [
            'machine_name' => $machine_name,
            'routines' => $routines,
            'repairs' => $repairs,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'repairs_date' => $repairs_date,
            'routines_date' => $routines_date
        ]);
        return $pdf->stream();
    }

    public function checkLeftJoin()
    {
        $routines_max_date = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
        ->select(DB::raw('max(worklists.date_check) as max_date'))
        ->where('annualschedulelists.lane', '1')
        ->where('annualschedulelists.machine_code', 'M0001')
        ->first();
        $routines_min_date = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
        ->select(DB::raw('min(worklists.date_check) as min_date'))
        ->where('annualschedulelists.lane', '1')
        ->where('annualschedulelists.machine_code', 'M0001')
        ->first();
        $repairs_max_date = Improvement::select(DB::raw('max(improvements.repair_date) as max_date'))
        ->where('improvements.lane', '1')
        ->where('improvements.machine', 'M0001')
        ->first();
        $repairs_min_date = Improvement::select(DB::raw('min(improvements.repair_date) as min_date'))
        ->where('improvements.lane', '1')
        ->where('improvements.machine', 'M0001')
        ->first();

        echo $routines_max_date->max_date;
    }
}