<?php

use App\Http\Controllers\AsignacionesController;
use App\Http\Controllers\IncidenciasController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/user",[UserController::class,"index"]);
Route::post("/user",[UserController::class,"store"]);
Route::get("/user/{id}",[UserController::class,"show"]);
Route::put("/user/{id}",[UserController::class,"update"]);
Route::delete("/user/{id}",[UserController::class,"destroy"]);

//Incidencias routes

Route::get("/incidencia",[IncidenciasController::class,"index"]);
Route::get("/incidencia/{id}",[IncidenciasController::class,"show"]);
Route::post("/incidencia",[IncidenciasController::class,"store"]);
Route::put("/incidencia/{id}",[IncidenciasController::class,"update"]);
Route::delete("/incidencia/{id}",[IncidenciasController::class,"destroy"]);

//asignaciones routes

Route::get("/asignacion",[AsignacionesController::class,"index"]);
Route::get("/asignacion/{id}",[AsignacionesController::class,"show"]);
Route::post("/asignacion",[AsignacionesController::class,"store"]);