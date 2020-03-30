<?php

namespace App\Http\Controllers;

use Session;
use App\Lane;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class LaneManagement extends Controller
{
	// Lane Select
	public function LaneSelect(){
		$lanes = Lane::all();

		return view('lane_management.lane_select', compact('lanes'));
	}

	// Lane List
	public function LaneList(){
		$lanes = Lane::all();

		return view('lane_management.lane_list', compact('lanes'));
	}

    // Save Lane
    public function CreateLane(Request $request)
    {
    	$lanes = new Lane;
    	$lanes->lane = $request->lane;
    	$lanes->remember_token = Str::random(40);
    	$lanes->save();

    	echo "added";
    }

    // Delete Lane
    public function DeleteLane($id)
    {
    	$lanes = Lane::find($id);
    	$lanes->delete();

    	echo "deleted";
    }
}
