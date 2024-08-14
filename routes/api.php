<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\BerkasController;
use App\Http\Controllers\Api\PenggunaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [AuthController::class, 'login']);


Route::get('/show-arsip', [BerkasController::class, 'showArsip']);
Route::get('/show-arsip-now', [BerkasController::class, 'showArsipNow']);
Route::get('/show-selesai-arsip', [BerkasController::class, 'showSelesaiArsip']);
Route::get('/show-setuju-arsip', [BerkasController::class, 'showSetujuArsip']);
Route::get('/show-ditolak-arsip', [BerkasController::class, 'showDitolakArsip']);
Route::get('/show-validasi-arsip', [BerkasController::class, 'showValidasiArsip']);


Route::get('/get-arsip', [BerkasController::class, 'getArsip']);
Route::post('/get-arsip-id', [BerkasController::class, 'getByIdArsip']);
Route::post('/delete-arsip-id', [BerkasController::class, 'deleteByIdArsip']);
Route::get('/get-selesai-arsip', [BerkasController::class, 'getSelesaiArsip']);
Route::get('/get-setuju-arsip', [BerkasController::class, 'getSetujuArsip']);
Route::get('/get-ditolak-arsip', [BerkasController::class, 'getDitolakArsip']);
Route::get('/get-validasi-arsip', [BerkasController::class, 'getValidasiArsip']);

Route::post('/set-status', [BerkasController::class, 'setStatusBerkas']);

Route::post('/create-arsip', [BerkasController::class, 'sendBerkas']);
Route::post('/update-arsip-akta', [BerkasController::class, 'updateBerkasAkta']);

Route::get('/show-pengguna', [PenggunaController::class, 'showPengguna']);
Route::post('/create-pengguna', [PenggunaController::class, 'sendPengguna']);

Route::get('/get-photo', [BerkasController::class, 'getPhoto']);