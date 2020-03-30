<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Lane;
use App\Machine;
use App\Activitylog;
use App\Improvement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ImprovementsManagement extends Controller
{
    // Open Improvement Management View
    public function ImprovementManagement()
    {
    	return view('improvement_management.improvement_management');
    }

    // Table Repair
    public function TableRepair()
    {
    	$repairs = DB::table('improvements')
        ->join('lanes', 'improvements.lane', '=', 'lanes.id')
        ->join('machines', 'improvements.machine', '=', 'machines.machine_code')
        ->select('improvements.*', 'lanes.lane as lane_name', 'machines.machine_name as machines_name')
        ->get();

    	return view('improvement_management.table_repair', compact('repairs'));
    }

    // Sorting Table Repair
    public function SortTableRepair($id)
    {
    	$repairs = DB::table('improvements')
    	->join('lanes', 'improvements.lane', '=', 'lanes.id')
        ->join('machines', 'improvements.machine', '=', 'machines.machine_code')
        ->select('improvements.*', 'lanes.lane as lane_name', 'machines.machine_name as machines_name')
        ->orderBy($id, 'ASC')
        ->get();

        return view('improvement_management.sort_table_repair', compact('repairs'));
    }

    // Open My Improvement View
    public function MyImprovement()
    {
    	$max = Improvement::max('repair_code');
        $check_max = Improvement::select('improvements.repair_code')->count();
        if ($check_max == null) {
            $max_code = "R0001";
        }else{
            $max_code = $max[1].$max[2].$max[3].$max[4];        
            $max_code++;
            if($max_code <= 9){
                $max_code = "R000".$max_code;
            }elseif ($max_code <= 99) {
                $max_code = "R00".$max_code;
            }elseif ($max_code <= 999) {
                $max_code = "R0".$max_code;
            }elseif ($max_code <= 99) {
                $max_code = "R".$max_code;
            }
        }
        $id_user = Auth::id();
        $lanes = Lane::all();
        $repairs = DB::table('improvements')
        ->join('lanes', 'improvements.lane', '=', 'lanes.id')
        ->join('machines', 'improvements.machine', '=', 'machines.machine_code')
        ->select('improvements.*', 'lanes.lane as lane_name', 'machines.machine_name as machines_name')
        ->where('id_user', '=', $id_user)
        ->orderBy('repair_code', 'ASC')
        ->get();
    	return view('improvement_management.my_improvement_management', compact('repairs', 'max_code', 'lanes'));
    }

	// Create Improvement
    public function CreateImprovement(Request $request)
    {
    	$id = Auth::id();
    	$repairs = new Improvement;
    	$repairs->id_user = $request->user()->id;
    	$repairs->user = $request->user()->name;
    	$repairs->repair_code = $request->code;
    	$repairs->repair_date = $request->repair_date;
    	$repairs->lane = $request->lane;
    	$repairs->machine = $request->machine;
    	$repairs->title = $request->title;
    	$repairs->description = $request->description;
    	$repairs->status = $request->status;
    	$repairs->save();

        $log = new Activitylog;
        $log->id_user = $request->user()->id;
        $log->user = $request->user()->name;
        $log->description = $request->user()->name." added a new Repair Machine";
        $log->remember_token = Str::random(40);
        $log->save();

    	Session::flash('created', 'Repair successfully created!');
    	return redirect('/my_repair_machine');
    }

    // Edit Improvement
    public function EditImprovement($id)
    {
    	$repairs = Improvement::find($id);

    	return response()->json($repairs);
    }

    // Update Improvement
    public function UpdateImprovement(Request $request, $id)
    {
    	$repairs = Improvement::find($id);
    	$repairs->repair_date = $request->repair_date;
    	$repairs->lane = $request->lane;
    	$repairs->machine = $request->machine;
    	$repairs->title = $request->title;
    	$repairs->description = $request->description;
    	$repairs->save();

        $log = new Activitylog;
        $log->id_user = $request->user()->id;
        $log->user = $request->user()->name;
        $log->description = $request->user()->name." changes the Repair Machine " . $repairs->repair_code;
        $log->remember_token = Str::random(40);
        $log->save();

    	Session::flash('updated', 'Repair successfully updated!');
    	echo "success";
    }

    // Delete Improvement
    public function DeleteImprovement($id)
    {
    	$repairs = Improvement::find($id);
        $repairs->delete();

        $log = new Activitylog;
        $log->id_user = Auth::id();
        $log->user = Auth::user()->name;
        $log->description = Auth::user()->name." deletes the Repair Machine ". $repairs->repair_code;
        $log->remember_token = Str::random(40);
        $log->save();

    	Session::flash('deleted', 'Repair successfully deleted!');
    	return redirect('/my_repair_machine');
    }

    // Update Status
    public function UpdateStatus(Request $request, $id)
    {
        $repairs = Improvement::find($id);
        $repairs->status = $request->status;
        $repairs->save();

        $log = new Activitylog;
        $log->id_user = $request->user()->id;
        $log->user = $request->user()->name;
        $log->description = $request->user()->name." changes status on the Repair Machine " . $repairs->repair_code;
        $log->remember_token = Str::random(40);
        $log->save();

        Session::flash('status_updated', 'Status successfully updated!');
        return redirect('/my_repair_machine');
    }
}