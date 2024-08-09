<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/user",[UserController::class,"index"]);
Route::post("/user",[UserController::class,"store"]);
Route::get("/user/{id}",[UserController::class,"show"]);
Route::put("/user/{id}",[UserController::class,"update"]);
Route::delete("/user/{id}",[UserController::class,"destroy"]);
