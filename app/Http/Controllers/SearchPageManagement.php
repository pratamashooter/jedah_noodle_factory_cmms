<?php

namespace App\Http\Controllers;

use Auth;
use App\Worklist;
use Illuminate\Http\Request;

class SearchPageManagement extends Controller
{
    // Open Search Page
    public function searchPage(Request $request)
    {
    	$admin_pages = array(
    		'dashboard' => 'Dashboard',
    		'account_management' => 'Manage Account',
    		'add_account' => 'Add Account',
    		'setting_profile' => 'Setting Profile',
    		'machine_management' => 'Manage Machine',
    		'other_manage' => 'Other Setting',
    		'routine_schedule' => 'Routine Schedule',
    		'my_routine_schedule' => 'My Routine Schedule',
    		'routine_schedule_list' => 'Routine Schedule List',
    		'my_schedule_list' => 'My Schedule List',
    		'repair_machine' => 'Repair Machine',
    		'my_repair_machine' => 'My Repair Machine',
    		'my_work_list' => 'My Work List',
    		'report' => 'Report'
    	);
    	$supervisor_pages = array(
    		'dashboard' => 'Dashboard',
    		'setting_profile' => 'Setting Profile',
    		'routine_schedule' => 'Routine Schedule',
    		'my_routine_schedule' => 'My Routine Schedule',
    		'routine_schedule_list' => 'Routine Schedule List',
    		'my_schedule_list' => 'My Schedule List',
    		'repair_machine' => 'Repair Machine',
    		'my_repair_machine' => 'My Repair Machine',
    		'my_work_list' => 'My Work List',
    		'report' => 'Report'
    	);
    	$user_pages = array(
    		'dashboard' => 'Dashboard',
    		'setting_profile' => 'Setting Profile',
    		'routine_schedule' => 'Routine Schedule',
    		'routine_schedule_list' => 'Routine Schedule List',
    		'repair_machine' => 'Repair Machine',
    		'report' => 'Report'
    	);
    	$data_trash = array();
    	$data_result = array();
    	if(Auth::user()->role == 'admin'){
    		$number = 0;
    		foreach ($admin_pages as $key => $page) {
    			if (stripos($page, $request->name_pages) === FALSE) {
    				$data_trash[$number] = array(
    					'page_name' => $page,
    					'page_url' => $key
    				);
				}else{
					$data_result[$number] = array(
						'page_name' => $page,
						'page_url' => $key
					);
				$number += 1;
				}
    		}
    	}elseif(Auth::user()->role == 'supervisor'){
    		$number = 0;
    		foreach ($supervisor_pages as $key => $page) {
    			if (stripos($page, $request->name_pages) === FALSE) {
    				$data_trash[$number] = array(
    					'page_name' => $page,
    					'page_url' => $key
    				);
				}else{
					$data_result[$number] = array(
						'page_name' => $page,
						'page_url' => $key
					);
				$number += 1;
				}
    		}
    	}elseif(Auth::user()->role == 'user'){
    		$number = 0;
    		foreach ($user_pages as $key => $page) {
    			if (stripos($page, $request->name_pages) === FALSE) {
    				$data_trash[$number] = array(
    					'page_name' => $page,
    					'page_url' => $key
    				);
				}else{
					$data_result[$number] = array(
						'page_name' => $page,
						'page_url' => $key
					);
				$number += 1;
				}
    		}
    	}

    	// echo json_encode($data_result);
    	return response()->json($data_result);
    }
}
