<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\LogInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'users/', 'middleware' => 'loginfo'], function(){
    Route::patch('/update', [UserController::class, 'updateUserRecord']);
});

