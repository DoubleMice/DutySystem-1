<?php

Route::get('/', 'IndexController@index');
Route::post('/', 'IndexController@search');

Auth::routes();

Route::get('home', 'HomeController@index');
Route::get('superhome', 'HomeController@superadmin');

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
	Route::get('actions', 'HomeController@show_action');
	Route::get('actions_all', 'ActionRecordController@show_all_action_records');
	Route::get('actions/{id}', 'HomeController@show_action_test');
});

// ALl check in condition
Route::group(['middleware' => 'auth'], function(){
	// Route::get('graph', 'RouteController@graph');
	// Route::get('correct', 'RouteController@correct');
	Route::get('valid', 'RouteController@valid');
	Route::post('valid', 'RouteController@valid_date');
	Route::get('report', 'RouteController@report');
	Route::post('report', 'RouteController@report');
	Route::get('holidays', 'RouteController@holidays');
	Route::post('holidays', 'RouteController@holidays_search');
	Route::put('holidays', 'RouteController@holidays_update');
	Route::delete('holidays', 'RouteController@holidays_delete');
	Route::get('timeedit', 'RouteController@timeedit');
	Route::put('timeedit/update', 'TimeNodeController@update');

	// Route::get('holidays_content', 'RouteController@holidays_content');


	Route::get('absence', 'AbsenceValidRecordController@show_all');

});

// Rotues for modifying admin info
Route::group(['middleware' => 'auth', 'prefix' => 'admin', 'namespace' => 'Auth'], function(){
	Route::post('resetpassword', 'ResetPasswordController@resetPassword');
	// Route::post('resetemail', 'ResetInfoController@resetemail');
});

// Route for test SQL Server connection;
// Route::get('test', function(){
// 	$employees = DB::connection('sqlsrv')->select('select * from employees');
// 	return view('test', ['employees' => $employees]);
// });

// Routes for employee & record information;
Route::group(['middleware' => 'auth'], function() {
	Route::get('employees', 'EmployeeController@show_all');
	Route::get('employees/{work_number}', 'EmployeeController@show_records');
	Route::put('employees/{work_number}/records/{id}', 'RecordController@update');
	Route::get('records', 'RecordController@show_records');
});