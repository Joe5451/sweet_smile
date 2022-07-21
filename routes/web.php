<?php

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

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
    return view('app');
});

Route::get('/test', function () {
    $datetime = date('Y-m-d H:i:s');
    $carbon_datetime = new Carbon($datetime);

    echo $datetime . '<br>';
    echo $carbon_datetime;
});