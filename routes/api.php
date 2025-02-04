<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\PostJobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('v1')->group(function () {
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/my/jobs/{id}/apply', [PostJobController::class, 'applyForJob']);
Route::get('/jobs', [JobListingController::class, 'index']);
Route::get("/search-jobs" , [JobListingController::class , "JobsSearch"]);
Route::get('/jobs/{id}', [JobListingController::class, 'getJobById']);
Route::middleware('auth:sanctum')->group(function (){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/my/jobs', [PostJobController::class, 'storeJob']);
    Route::post('/my/jobs/{id}', [PostJobController::class, 'editJob']);
    Route::delete('/my/jobs/{id}', [PostJobController::class, 'deleteJob']);
    Route::get('/my/jobs', [JobListingController::class, 'getUserJobs']);
    Route::get('/user', [JobListingController::class, 'getprofile']);
    Route::get('/my/jobs', [JobListingController::class, 'searchJobs']);
    Route::get('/my/jobs/{id}', [JobListingController::class, 'myJob']);
   
});
});
