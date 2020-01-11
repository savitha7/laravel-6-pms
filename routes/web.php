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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/refresh-csrf', function () {
    return csrf_token();
});

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('employees', 'EmployeeController')->middleware('auth');
Route::post('/employees/list', 'EmployeeController@getEmployees')->name('employees.list');
Route::resource('salary', 'SalaryController')->middleware('auth');
Route::post('/salary/list', 'SalaryController@getSalaries')->name('salary.list');
Route::get('/salary/{emp_id?}/list', 'SalaryController@index')->name('salary.elist')->middleware('auth');
Route::get('/salary/create/{emp_id?}', 'SalaryController@create')->name('salary.ecreate')->middleware('auth');