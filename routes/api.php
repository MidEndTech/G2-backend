<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\Api\Logincontroller;
use App\Http\Controllers\Blog\Blogcontroller;
use App\Http\Controllers\Api\Registercontroller;

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


Route::post('register',[Registercontroller::class,'register']);
Route::post('login', [Logincontroller::class , 'login']);
Route::get('index' , [Blogcontroller::class , 'index']);

Route::middleware('auth:sanctum')->group(
     function () {
        // store blog
        Route::post('store', [Blogcontroller::class, 'store']);
        Route::post('edit/{blog}' , [Blogcontroller::class , 'edit']);
        Route::post('delete/{blog}',[Blogcontroller::class , 'delete'] );

        Route::get('show/{blog}' , [Blogcontroller::class , 'show']);
    }
);
