<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Humidity;
use App\Events\HumEvent;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function store(Request $request)
    {
        // $hum = DB::insert('insert into humidity (hum) values (?)', [$request->hum]);
        $humidity = Humidity::create([
            'hum' => $request->hum
        ]);
        broadcast(new HumEvent($humidity))->toOthers();
        return response()->json($humidity);
    }

    public function getData()
    {
        $data = DB::table('humidities')->get();
        // Humidity::all();

        return response()->json($data);
    }

    public function getHistoricalData()
    {
        $getDataLastMonth = Humidity::where('created_at', '>=', Carbon::today()->subDays(30))->avg('hum');

        return response()->json($getDataLastMonth);
    }
}
