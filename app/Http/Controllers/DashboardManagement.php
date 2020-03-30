<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\User;
use App\Machine;
use App\Worklist;
use App\Activitylog;
use App\Improvement;
use App\Annualschedule;
use App\Annualschedulelist;
use Illuminate\Http\Request;

class DashboardManagement extends Controller
{
    // Send Schedule List for Calendar
    public function scheduleList()
    {
        $schedule = Annualschedulelist::join('machines', 'machines.machine_code', '=', 'annualschedulelists.machine_code')
        ->join('lanes', 'lanes.id', '=', 'annualschedulelists.lane')
        ->select('annualschedulelists.*', 'machines.machine_name', 'lanes.lane as lane_name')
        ->get();
        $repairs = Improvement::join('machines', 'machines.machine_code', '=', 'improvements.machine')
        ->join('lanes', 'lanes.id', '=', 'improvements.lane')
        ->select('improvements.*', 'machines.machine_name', 'lanes.lane as lane_name')
        ->get();
        return response()->json(['schedule' => $schedule, 'repairs' => $repairs]);
    }

    // Open Dashboard View
    public function Dashboard()
    {
        $id_user = Auth::id();
        $activity_log = Activitylog::orderBy('id', 'DESC')->take(6)->get();
    	$user = User::all()->count();
    	$machine = Machine::all()->count();
    	$annual = Annualschedulelist::all()->count();
    	$repair = Improvement::all()->count();
    	$admin = User::select('users.*')->where('role', 'admin')->count();
    	$supervisor = User::select('users.*')->where('role', 'supervisor')->count();
    	$users = User::select('users.*')->where('role', 'user')->count();
    	$open_a = Annualschedulelist::select('annualschedulelists.*')->where('status', 'open')->count();
    	$waiting_a = Annualschedulelist::select('annualschedulelists.*')->where('status', 'waiting')->count();
    	$close_a = Annualschedulelist::select('annualschedulelists.*')->where('status', 'close')->count();
    	$open_r = Improvement::select('improvements.*')->where('status', 'open')->count();
    	$waiting_r = Improvement::select('improvements.*')->where('status', 'waiting')->count();
    	$close_r = Improvement::select('improvements.*')->where('status', 'close')->count();
    	$count_0 = $annual + $repair;
    	$count_2 = null;
        if($close_a + $close_r == 0)
        {
            $count_2 = 0;
        }else{
            $count_2 = ($close_a + $close_r)/$count_0 * 100;
        }
    	$open = $open_a + $open_r;
    	$waiting = $waiting_a + $waiting_r;
    	$close = $close_a + $close_r;
    	$repair_5 = Worklist::join('annualschedulelists', 'annualschedulelists.schedule_list_code', '=', 'worklists.schedule_list_code')
        ->join('users', 'users.id', '=', 'worklists.worker')
        ->join('lanes', 'annualschedulelists.lane', '=', 'lanes.id')
        ->join('machines', 'annualschedulelists.machine_code', '=', 'machines.machine_code')
        ->select('worklists.*', 'lanes.lane as lane_name', 'machines.machine_name', 'machines.production_year', 'machines.brand', 'machines.capacity', 'users.name')
        ->orderBy('worklists.date_check', 'DESC')
        ->take(5)
        ->get();
        $annual_4 = Annualschedule::join('lanes', 'annualschedules.lane', '=', 'lanes.id')
        ->join('users', 'users.id', '=', 'annualschedules.id_user')
        ->join('machines', 'annualschedules.machine_code', '=', 'machines.machine_code')
        ->select('annualschedules.*', 'lanes.lane as lane_name', 'machines.machine_name as machines_name', 'users.avatar', 'users.name as user_name')
        ->orderBy('id', 'DESC')
        ->take(4)
        ->get();

    	return view('dashboard', compact('user', 'machine', 'annual', 'repair', 'admin', 'supervisor', 'users', 'open_a', 'waiting_a', 'close_a', 'open_r', 'waiting_r', 'close_r', 'count_2', 'open', 'waiting', 'close', 'repair_5', 'annual_4', 'activity_log'));
    }
    
}
