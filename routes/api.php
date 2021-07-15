<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    if (rand(0,1))
    {
        $users = collect(json_decode(Storage::get('users'), true));
        return $users->where('email', $request->user()->email)->first();
    }
    return $request->user();
});
Route::middleware('auth:api')->put('/user', [UserController::class, 'update']);
