<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\LogInfo;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'users/'], function(){
    Route::patch('/update', [UserController::class, 'updateUserRecord']);
})->middleware(LogInfo::class);
