<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ContactController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//les route de l'utilisateur
Route::get('/users', [UserController::class,'index']);
Route::post('/users', [UserController::class,'store']);
Route::get('/users/statut/{status}', [UserController::class,'statut']);
Route::get('/users/{id}', [UserController::class,'show']);
Route::put('users/{id}/statut ', [UserController::class,'active_desactive']);

//pour les contacts
Route::get('contacts',[ContactController::class,'index']);