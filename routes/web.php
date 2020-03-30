<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'FirstAccountManagement@OpenCreate');
Route::post('/create_first', 'FirstAccountManagement@FirstAccount');
Route::get('/login', 'AuthenticationManagement@Login')->name('login');
Route::post('/account_login', 'AuthenticationManagement@VerifyLogin');

Route::group(['middleware' => ['auth', 'checkRole:admin,supervisor,user']], function(){
	Route::get('/logout', 'AuthenticationManagement@Logout');
	Route::get('/dashboard', 'DashboardManagement@Dashboard');
	Route::get('/message_nav', 'MessageManagement@ShowMessageNav');
	Route::get('/notif_nav', 'NotificationController@ShowNotifNav');
	Route::get('/notif_count', 'NotificationController@notificationCount');
	Route::get('/message_list', 'MessageManagement@ShowMessageList');
	Route::get('/notif_list', 'NotificationController@ShowNotifList');
	Route::post('/send_message', 'MessageManagement@SendMessage');
	Route::get('/setting_profile', 'ProfileManagement@ShowProfile');
	Route::get('/delete_profile_pict', 'ProfileManagement@DeletePictProfile');
	Route::post('/update_profile/{id}', 'ProfileManagement@UpdateProfile');
	Route::post('/change_password/{id}', 'ProfileManagement@ChangePass');
	Route::get('/schedule_list', 'DashboardManagement@scheduleList');
	Route::post('/search_page', 'SearchPageManagement@searchPage');
	Route::get('/routine_schedule', 'AnnualScheduleManagement@AnnualSchedule');
	Route::get('/table_schedule', 'AnnualScheduleManagement@TableSchedule');
	Route::get('/repair_machine', 'ImprovementsManagement@ImprovementManagement');
	Route::get('/table_repair', 'ImprovementsManagement@TableRepair');
	Route::get('/table_worker/{id}', 'AnnualScheduleListManagement@TableWorker');
	Route::get('/sort_table_schedule/{id}', 'AnnualScheduleManagement@SortTableSchedule');
	Route::get('/sort_table_repair/{id}', 'ImprovementsManagement@SortTableRepair');
	Route::get('/machine_select/{id}', 'AnnualScheduleManagement@MachineSelect');
	Route::get('/view_schedule_list/{id}', 'AnnualScheduleListManagement@view_schedule_list');
	Route::get('/routine_schedule_list', 'AnnualScheduleListManagement@routineScheduleList');
	Route::get('/table_schedule_list', 'AnnualScheduleListManagement@tableScheduleList');
	Route::get('/sort_table_schedule_list/{id}', 'AnnualScheduleListManagement@sortTableScheduleList');
	Route::get('/report', 'ReportManagement@ReportManagement');
	Route::post('/filter_schedule', 'ReportManagement@FilterAnnual');
	Route::post('/filter_repair', 'ReportManagement@FilterRepair');
	Route::post('/pdf_annual', 'ReportManagement@PDFAnnual');
	Route::post('/print_annual', 'ReportManagement@PRINTAnnual');
	Route::post('/pdf_repair', 'ReportManagement@PDFRepair');
	Route::post('/print_repair', 'ReportManagement@PRINTRepair');
	Route::post('/load_worker_history/{id}', 'ReportManagement@PrintWorkerHistory');
	Route::post('/load_pdf_machine', 'ReportManagement@loadReportMachine');
	Route::get('/worker_history/{id}', 'ReportManagement@WorkerHistory');
});

Route::group(['middleware' => ['auth', 'checkRole:admin,supervisor']], function(){
	Route::get('/my_routine_schedule', 'AnnualScheduleManagement@MyAnnualSchedule');
	Route::get('/my_schedule_list', 'AnnualScheduleListManagement@myRoutineScheduleList');
	Route::get('/my_table_schedule_list', 'AnnualScheduleListManagement@myTableScheduleList');
	Route::get('/my_repair_machine', 'ImprovementsManagement@MyImprovement');
	Route::get('/my_work_list', 'AnnualScheduleListManagement@MyWorkList');
	Route::post('/save_schedule', 'AnnualScheduleManagement@CreateSchedule');
	Route::post('/save_repair', 'ImprovementsManagement@CreateImprovement');
	Route::post('/save_worker', 'AnnualScheduleListManagement@SaveWorker');
	Route::get('/edit_repair/{id}', 'ImprovementsManagement@EditImprovement');
	Route::post('/update_schedule/{id}', 'AnnualScheduleManagement@UpdateSchedule');
	Route::post('/update_repair/{id}', 'ImprovementsManagement@UpdateImprovement');
	Route::get('/update_status_list/{id}/{status}', 'AnnualScheduleListManagement@UpdateStatusList');
	Route::post('/update_status_repair/{id}', 'ImprovementsManagement@UpdateStatus');
	Route::post('/update_my_work', 'AnnualScheduleListManagement@UpdateMyWork');
	Route::get('/delete_schedule/{id}', 'AnnualScheduleManagement@DeleteSchedule');
	Route::get('/delete_schedule_list/{id}', 'AnnualScheduleListManagement@DeleteScheduleList');
	Route::get('/delete_repair/{id}', 'ImprovementsManagement@DeleteImprovement');
	Route::get('/delete_worker/{id}', 'AnnualScheduleListManagement@DeleteWorker');
	Route::get('/my_routine_schedule_list', 'AnnualScheduleListManagement@myRoutineScheduleList');
	Route::get('/my_work_list_table', 'AnnualScheduleListManagement@MyWorkTable');
	Route::get('/my_work_list_table_sort/{id}', 'AnnualScheduleListManagement@sortMyWorkTable');
	Route::get('/my_work_list_detail/{id}', 'AnnualScheduleListManagement@myWorkListDetail');
	Route::post('/load_pdf_workorder', 'AnnualScheduleListManagement@loadReportWorkOrder');

	// Route::get('/cekpunk', 'AnnualScheduleListManagement@checkFunct');
});

Route::group(['middleware' => ['auth', 'checkRole:admin']], function(){
	Route::get('/account_management', 'AccountManagement@AccountManagement');
	Route::get('/machine_management', 'MachineManagement@MachineManagement');
	Route::get('/add_account', 'AccountManagement@AddAccount');
	Route::get('/lane_select', 'LaneManagement@LaneSelect');
	Route::get('/lane_list', 'LaneManagement@LaneList');
	Route::post('/save_account', 'AccountManagement@CreateAccount');
	Route::post('/save_machine', 'MachineManagement@CreateMachine');
	Route::post('/save_lane', 'LaneManagement@CreateLane');
	Route::get('/edit_account/{id}', 'AccountManagement@EditAccount');
	Route::get('/edit_machine/{id}', 'MachineManagement@EditMachine');
	Route::post('/update_account/{id}', 'AccountManagement@UpdateAccount');
	Route::post('/update_machine/{id}', 'MachineManagement@UpdateMachine');
	Route::get('/delete_account/{id}', 'AccountManagement@DeleteAccount');
	Route::get('/delete_machine/{id}', 'MachineManagement@DeleteMachine');
	Route::get('/delete_lane/{id}', 'LaneManagement@DeleteLane');
	Route::get('/other_manage', 'OtherManagement@OtherManage');
	Route::get('/clear_message', 'OtherManagement@ClearMessage');
	Route::get('/clear_activity', 'OtherManagement@ClearActivity');
});