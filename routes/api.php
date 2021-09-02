<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('createdept',[DepartmentController::class,'store']);
    Route::get('listdept',[DepartmentController::class,'index']);
    Route::delete('{id}/deletedept',[DepartmentController::class,'destroy']);
    Route::get('{id}/viewdeptById',[DepartmentController::class,'show']);
    Route::post('{id}/updatedept',[DepartmentController::class,'update']);

    Route::post('createmp',[EmployeeController::class,'store']);
    Route::get('listemp',[EmployeeController::class,'index']);
    Route::delete('{id}/deletemp',[EmployeeController::class,'destroy']);
    Route::get('{id}/viewempById',[EmployeeController::class,'show']);
    Route::post('{id}/updatemp',[EmployeeController::class,'update']);
    Route::get('{title}/searchByTitlemp',[EmployeeController::class,'searchByTitle']);

    