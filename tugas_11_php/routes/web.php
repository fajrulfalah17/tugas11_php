<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;

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

Route::get('/karyawan', 'KaryawanController@index');
Route::post('/create-karyawan', 'KaryawanController@store');
Route::post('/update-karyawan', 'KaryawanController@update');
Route::get('/delete-karyawan/{id}', 'KaryawanController@delete');
Route::get('/details-karyawan/{id}', 'KaryawanController@show');

