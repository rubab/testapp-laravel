<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-sqlite', function () {
    try {
        DB::connection('sqlite')->getPdo();
        return 'SQLite connection is working!';
    } catch (\Exception $e) {
        return 'SQLite connection failed: ' . $e->getMessage();
    }
});