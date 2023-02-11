<?php

use App\Http\Controllers\api\FileController;
use App\Http\Controllers\api\StudensController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('user', [StudensController::class, 'User']);
Route::post('studentsearch', [StudensController::class, 'studentSearch']);


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('me', 'me')->middleware('auth:api');

});



Route::post('upload', [FileController::class, 'UploadFIle']);
Route::get('file/{id}', [FileController::class, 'DownloadFile']);



