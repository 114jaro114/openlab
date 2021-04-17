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

    public function getHistoricalData2()
    {
      DB::('humidities')
      ->select(timestamp(concat(date('created_at'), ' ', hour('created_at'), ':', minute('created_at') div 5 * 5)),
      min('hum'),max('hum'))
      ->groupBy(date('created_at'), hour('created_at'), minute('created_at') div 5 * 5);

        // results
        foreach ($rawQuery as $deal) {
            $array[] = array(
              $deal->hum
            );
        }
        // // $getAllRecords = Humidity::all();
        // // foreach ($getAllRecords as $row)
        // // endforeach
        // $getDataLastHalfHour = Humidity::where('created_at', '>=', Carbon::now()->subHours(5)->toDateTimeString())->get();
        // $highest = Humidity::where('created_at', '>=', Carbon::now()->subHours(5)->toDateTimeString())->max('hum');
        // $lowest = Humidity::where('created_at', '>=', Carbon::now()->subHours(5)->toDateTimeString())->min('hum');
        // $array[] = array(
        //   //open
        //   $getDataLastHalfHour[0]->hum,
        //   $highest,
        //   $lowest,
        //   //close
        //   $getDataLastHalfHour[count($getDataLastHalfHour)-1]->hum,
        //   $getDataLastHalfHour[0]->created_at,
        // );
        return response()->json($array);
    }
}
