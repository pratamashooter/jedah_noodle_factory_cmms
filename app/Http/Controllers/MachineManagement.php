<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Lane;
use App\Machine;
use App\Activitylog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MachineManagement extends Controller
{
    // Open MachineManagement
    public function MachineManagement()
    {
    	$max = Machine::max('machine_code');
        $check_max = Machine::select('machines.machine_code')->count();
        if($check_max == null){
            $max_code = "M0001";
        }else{
            $max_code = $max[1].$max[2].$max[3].$max[4];        
            $max_code++;
            if($max_code <= 9){
                $max_code = "M000".$max_code;
            }elseif ($max_code <= 99) {
                $max_code = "M00".$max_code;
            }elseif ($max_code <= 999) {
                $max_code = "M0".$max_code;
            }elseif ($max_code <= 99) {
                $max_code = "M".$max_code;
            }
        }
        $lanes = Lane::all();
    	$machines = Machine::join('lanes', 'machines.lane', '=', 'lanes.id')
        ->select('machines.*', 'lanes.lane as lane_name')
        ->orderBy('machine_code', 'ASC')
        ->get();
    	return view('machine_management.machine_management', compact('machines', 'max_code', 'lanes'));
    }

    // Create Machine
    public function CreateMachine(Request $request)
    {
    	$machines = new Machine;
        $machines->machine_code = $request->code;
        $machines->lane = $request->lane;
        $machines->machine_name = $request->machine;
        $machines->brand = $request->brand;
        $machines->capacity = $request->capacity;
        $machines->production_year = $request->production_year;
        $machines->remember_token = Str::random(40);
        $machines->save();

        $log = new Activitylog;
        $log->id_user = $request->user()->id;
        $log->user = $request->user()->name;
        $log->description = $request->user()->name." added a new Machine : ".$request->machine;
        $log->remember_token = Str::random(40);
        $log->save();

        Session::flash('added', 'Machine successfully added!');
        return redirect('/machine_management');
    }

    // Edit Machine
    public function EditMachine($id)
    {
        $machines = Machine::find($id);

        return response()->json($machines);
    }

    // Update Machine
    public function UpdateMachine(Request $request, $id)
    {
    	$machines = Machine::find($id);

        $log = new Activitylog;
        $log->id_user = $request->user()->id;
        $log->user = $request->user()->name;
        $log->description = $request->user()->name." changes Machine ".$machines->machine_name;
        $log->remember_token = Str::random(40);
        $log->save();

        $machines->lane = $request->lane;
        $machines->machine_name = $request->machine;
        $machines->brand = $request->brand;
        $machines->capacity = $request->capacity;
        $machines->production_year = $request->production_year;
        $machines->save();

    	Session::flash('updated', 'Machine successfully updated!');
    	echo "success";
    }

    // Delete Machine
    public function DeleteMachine($id)
    {
        $machines = Machine::find($id);

        $log = new Activitylog;
        $log->id_user = Auth::id();
        $log->user = Auth::user()->name;
        $log->description = Auth::user()->name." deletes Machine ".$machines->machine_name;
        $log->remember_token = Str::random(40);
        $log->save();

        $machines->delete();

        Session::flash('deleted', 'Machine successfully deleted!');
        return redirect('/machine_management');
    }
}
