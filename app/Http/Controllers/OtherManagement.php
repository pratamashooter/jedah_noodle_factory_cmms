<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Message;
use App\Activitylog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class OtherManagement extends Controller
{
    // Open Other Manage View
    public function OtherManage()
    {
        $act_log = Activitylog::select('activitylogs.*')
        ->orderBy('created_at', 'DESC')
        ->paginate(25);

    	return view('other_management.other_management', compact('act_log'));
    }

    // Clear Message History
    public function ClearMessage()
    {
    	Message::query()->truncate();

        $log = new Activitylog;
        $log->id_user = Auth::id();
        $log->user = Auth::user()->name;
        $log->description = Auth::user()->name." clear message history";
        $log->remember_token = Str::random(40);
        $log->save();

    	Session::flash('clear_message', 'Message history successfully clear!');

    	return redirect('/other_manage');
    }

    // Clear Activity Log
    public function ClearActivity()
    {
    	Activitylog::query()->truncate();
    	Session::flash('clear_activity', 'Activity log successfully clear!');
    	
    	return redirect('/other_manage');
    }
}