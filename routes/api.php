<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\TransactionController;


//les route de l'utilisateur
Route::get('/users', [UserController::class,'index']);
Route::post('/users', [UserController::class,'store']);
Route::get('/users/statut/{status}', [UserController::class,'statut']);
Route::get('/users/{id}', [UserController::class,'show']);
Route::put('users/{id}/statut ', [UserController::class,'active_desactive']);

//pour les contacts
Route::get('contacts',[ContactController::class,'index']);
Route::post('contacts',[ContactController::class,'store']);
Route::get('contacts/{id}',[ContactController::class,'show']);
Route::delete('contacts/{id}',[ContactController::class,'destroy']);
Route::put('contacts/{id}',[ContactController::class,'update']);
Route::get('contacts/user/{user_id}',[ContactController::class,'contactsUser']);


//pour les transactions

Route::post('transactions/depot',[TransactionController::class,'depot']);
Route::post('transactions/transfert',[TransactionController::class,'transfert']);
Route::get('transactions/{id}/solde',[TransactionController::class,'solde']);
Route::get('transactions/{id}/{type}',[TransactionController::class,'transactionsUserType']);
Route::get('transactions/{user_id}/depots/total',[TransactionController::class,'totalDepots']);
Route::get('transactions/{id}/transferts/total',[TransactionController::class,'totalTransferts']);
Route::get('transactions/user/{user_id}',[TransactionController::class,'contactsUser']);