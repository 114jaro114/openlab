<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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
    return $request->user();
});

Route::group(['prefix' => 'internal', 'middleware' => ['auth:api']], function () {
    Route::get('sockets/serve', function () {
        \Illuminate\Support\Facades\Artisan::call('websockets:serve');
    });
});

Route::post('/broadcast', function (Request $request) {
    $pusher = new Pusher\Pusher(
        env('PUSHER_APP_KEY'),
        env('PUSHER_APP_SECRET'),
        env('PUSHER_APP_ID'),
        array(
        'cluster' => env('PUSHER_APP_CLUSTER'),
        'useTLS' => false,
        'host' => '127.0.0.1',
        'port' => 6001,
        'scheme' => 'http',
        )
    );
    return $pusher->socket_auth($request->request->get('channel_name'), $request->request->get('socket_id'));
});

Route::post('/saveData', [ApiController::class, 'store']);
Route::post('/saveDataAllSensors', [ApiController::class, 'store2']);
Route::get('/getHum', [ApiController::class, 'getData']);
Route::get('/getHistoricalData', [ApiController::class, 'getHistoricalData']);
Route::get('/getHistoricalData2', [ApiController::class, 'getHistoricalData2']);
Route::get('/getHistoricalData3', [ApiController::class, 'getHistoricalData3']);

//for graph in home page
Route::get('/getDataHome', [ApiController::class, 'getDataDashed']);
Route::get('/getDataLine', [ApiController::class, 'getDataLine']);
Route::get('/getDataCircleMultiple', [ApiController::class, 'getDataCircleMultiple']);
Route::get('/getDataAreasGroup', [ApiController::class, 'getDataAreasGroup']);
