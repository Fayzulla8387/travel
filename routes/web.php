<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/',[\App\Http\Controllers\HomeController::class,'index'])->name("index");
Route::get('contact',[\App\Http\Controllers\HomeController::class,'contact'])->name("contact");
Route::get('about',[\App\Http\Controllers\HomeController::class,'about'])->name("about");
Route::get('property-list',[\App\Http\Controllers\HomeController::class,'property_list'])->name("property-list");
Route::get('property-type',[\App\Http\Controllers\HomeController::class,'property_type'])->name("property-type");
Route::get('property-agent',[\App\Http\Controllers\HomeController::class,'property_agent'])->name("property-agent");