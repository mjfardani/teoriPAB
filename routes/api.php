<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\CardController;
use App\Http\Controllers\api\TerminalController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum', 'admin'])->post(
    '/user/register_admin',
    [UserController::class, 'register_admin']
);
Route::middleware(['auth:sanctum', 'admin'])->post(
    '/user/register_terminal',
    [UserController::class, 'register_terminal']
);
Route::middleware(['auth:sanctum', 'admin'])->post(
    '/logout',
    [UserController::class, 'logout']
);
Route::post('/login', [UserController::class, 'login']);

Route::middleware(['auth:sanctum', 'admin'])->post(
    '/user/token',
    [UserController::class, 'terminal_token']
);
Route::middleware(['auth:sanctum', 'admin'])->get(
    '/user/list',
    [UserController::class, 'list']
);


Route::middleware(['auth:sanctum', 'admin'])->post(
    '/terminal/create',
    [TerminalController::class, 'create']
);
Route::middleware(['auth:sanctum', 'admin'])->get(
    '/terminal/list',
    [TerminalController::class, 'list']
);
Route::middleware(['auth:sanctum', 'admin'])->post(
    '/card/create',
    [CardController::class, 'create']
);
Route::middleware(['auth:sanctum', 'admin'])->get(
    '/card/list',
    [CardController::class, 'list']
);
