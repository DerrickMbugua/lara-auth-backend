<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Setup\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    // $accessToken = $request->bearerToken();
    // return $accessToken;
    $user = $request->user();
    $role = $user->roles->pluck('name')->first();
    $success = [
        "name" => $user->name,
        "email" => $user->email,
        "role" => $role
    ];
    return response()->json($success);
});

Route::post('/auth/register', [AuthController::class, "register"])->name('auth.register');
Route::post('/role/assign', [RoleController::class, "assign"])
    ->middleware('auth:api')
    ->name('role.assign');
Route::post('/role/create', [RoleController::class, "create"])->name('role.create');
