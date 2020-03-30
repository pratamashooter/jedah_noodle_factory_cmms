<?php

namespace App\Http\Controllers;

use Carbon;
use Auth;
use App\Annualschedulelist;

class NotificationController extends Controller
{
	// Show Notification List
	public function ShowNotifList()
	{
		$schedules = Annualschedulelist::join('annualschedules', 'annualschedules.schedule_code', '=', 'annualschedulelists.schedule_code')
        ->join('machines', 'machines.machine_code', '=', 'annualschedulelists.machine_code')
        ->join('lanes', 'lanes.id', '=', 'annualschedulelists.lane')
        ->select('annualschedulelists.*', 'machines.machine_name', 'machines.brand', 'machines.production_year', 'lanes.lane as lane_name', 'annualschedules.time', 'annualschedules.period')
        ->where('schedule_date', Carbon::today()->format('Y-m-d'))
        ->get();

		return view('notification_management.notif_list', compact('schedules'));
	}

    // Show Notification Nav
    public function ShowNotifNav()
    {
        $schedules = Annualschedulelist::join('annualschedules', 'annualschedules.schedule_code', '=', 'annualschedulelists.schedule_code')
        ->join('machines', 'machines.machine_code', '=', 'annualschedulelists.machine_code')
        ->join('lanes', 'lanes.id', '=', 'annualschedulelists.lane')
        ->select('annualschedulelists.*', 'machines.machine_name', 'lanes.lane as lane_name', 'annualschedules.time', 'annualschedules.period')
        ->where('schedule_date', Carbon::today()->format('Y-m-d'))
        ->take(3)
        ->get();

        return view('notification_management.notif_nav', compact('schedules'));
    }

    // Check Notification Count
    public function notificationCount()
    {
        $schedules = Annualschedulelist::where('schedule_date', Carbon::today()->format('Y-m-d'))
        ->count();

        echo $schedules;
    }
}
