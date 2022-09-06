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


Route::post('/saveDataPowerConsumption', [ApiController::class, 'store']);
Route::post('/saveDataAllSensors', [ApiController::class, 'store2']);
// Route::get('/saveDataPowerConsumption', [ApiController::class, 'store']);
// Route::get('/saveDataAllSensors', [ApiController::class, 'store2']);

//for graph in humidity page
Route::get('/getDataRealtimeHumidity', [ApiController::class, 'getDataRealtimeHumidity']);
Route::get('/getHistoricalDataHumidity', [ApiController::class, 'getHistoricalDataHumidity']);
Route::get('/getHistoricalData2Humidity', [ApiController::class, 'getHistoricalData2Humidity']);
Route::get('/getHistoricalData3Humidity', [ApiController::class, 'getHistoricalData3Humidity']);

//for graph in temperature page gtmp + atmp
Route::get('/getDataRealtimeTemperatureGtmp', [ApiController::class, 'getDataRealtimeTemperatureGtmp']);
Route::get('/getHistoricalDataTemperatureGtmp', [ApiController::class, 'getHistoricalDataTemperatureGtmp']);
Route::get('/getHistoricalData2TemperatureGtmp', [ApiController::class, 'getHistoricalData2TemperatureGtmp']);
Route::get('/getHistoricalData3TemperatureGtmp', [ApiController::class, 'getHistoricalData3TemperatureGtmp']);

Route::get('/getDataRealtimeTemperatureAtmp', [ApiController::class, 'getDataRealtimeTemperatureAtmp']);
Route::get('/getHistoricalDataTemperatureAtmp', [ApiController::class, 'getHistoricalDataTemperatureAtmp']);
Route::get('/getHistoricalData2TemperatureAtmp', [ApiController::class, 'getHistoricalData2TemperatureAtmp']);
Route::get('/getHistoricalData3TemperatureAtmp', [ApiController::class, 'getHistoricalData3TemperatureAtmp']);

//for graph in lights page
Route::get('/getDataRealtimeLight', [ApiController::class, 'getDataRealtimeLight']);
Route::get('/getHistoricalDataLight', [ApiController::class, 'getHistoricalDataLight']);
Route::get('/getHistoricalData2Light', [ApiController::class, 'getHistoricalData2Light']);
Route::get('/getHistoricalData3Light', [ApiController::class, 'getHistoricalData3Light']);

//for graph in pressure page
Route::get('/getDataRealtimePressure', [ApiController::class, 'getDataRealtimePressure']);
Route::get('/getHistoricalDataPressure', [ApiController::class, 'getHistoricalDataPressure']);
Route::get('/getHistoricalData2Pressure', [ApiController::class, 'getHistoricalData2Pressure']);
Route::get('/getHistoricalData3Pressure', [ApiController::class, 'getHistoricalData3Pressure']);

//for graph in sound page
Route::get('/getDataRealtimeSound', [ApiController::class, 'getDataRealtimeSound']);
Route::get('/getHistoricalDataSound', [ApiController::class, 'getHistoricalDataSound']);
Route::get('/getHistoricalData2Sound', [ApiController::class, 'getHistoricalData2Sound']);
Route::get('/getHistoricalData3Sound', [ApiController::class, 'getHistoricalData3Sound']);

//for graph in home page
Route::get('/getDataHome', [ApiController::class, 'getDataDashed']);
Route::get('/getDataLine', [ApiController::class, 'getDataLine']);
Route::get('/getDataCircleMultiple', [ApiController::class, 'getDataCircleMultiple']);
Route::get('/getDataAreasGroup', [ApiController::class, 'getDataAreasGroup']);

//for graph in energy page
Route::get('/getDataDashedU', [ApiController::class, 'getDataDashedU']);
Route::get('/getDataDashedI', [ApiController::class, 'getDataDashedI']);
Route::get('/getDataDashedP', [ApiController::class, 'getDataDashedP']);
Route::get('/getDataDashedS', [ApiController::class, 'getDataDashedS']);
Route::get('/getDataDashedQ', [ApiController::class, 'getDataDashedQ']);
Route::get('/getDataDashedE_I', [ApiController::class, 'getDataDashedE_I']);
Route::get('/getDataDashedE_E', [ApiController::class, 'getDataDashedE_E']);
