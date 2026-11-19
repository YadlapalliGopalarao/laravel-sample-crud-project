<?php
use App\Http\Controllers\Api\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/students/create',[Crud::class,'create']);

Route::get('/students',[Crud::class,'getting']);

Route::put('/students/{id}', [Crud::class, 'update']);

Route::delete('/students/{id}',[Crud::class,'destroy']);

Route::get('/students/{id}',[Crud::class,'show']);