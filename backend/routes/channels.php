<?php

use Illuminate\Support\Facades\Broadcast;

use App\Models\Humidity;
use App\Models\AllSensors;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

//channel for humidity
// Broadcast::channel('test', function (Humidity $humidity) {
//     return $humidity;
// });
//
// Broadcast::channel('dataAllSensors', function (AllSensors $allsensors) {
//     return $allsensors;
// });
