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
        // foreach ($data as $row):
        // $array[] = array(
        //   $row->created_at,
        //   $row->hum,
        // );
        // endforeach;
        return response()->json($data);
    }

    public function getHistoricalData()
    {
        $getDataLastMonth = Humidity::where('created_at', '>=', Carbon::today()->subDays(30))->avg('hum');

        return response()->json($getDataLastMonth);
    }

    public function getHistoricalData2()
    {
        $query = DB::select("select
        from_unixtime(round(unix_timestamp(created_at)/(60*60))*(60*60)) as timekey,
        substring_index(group_concat(hum order by created_at), ',', 1) as first_open,
        substring_index(group_concat(hum order by created_at desc), ',', 1) as last_close,
        MAX(hum) AS max_value,
        MIN(hum) As min_value
        FROM humidities
        GROUP BY timekey");

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
        // $query[] = array(
        //  '33',
        //  '80',
        //  '35',
        //  '28',
        //  '2021-04-17 20:00:00',
        // );
        // $query[] = array(
        //    '36',
        //    '60',
        //    '35',
        //    '24',
        //    '2021-04-17 20:30:00',
        // );
        // $query[] = array(
        //    '25',
        //    '45',
        //    '28',
        //    '40',
        //    '2021-04-17 21:00:00',
        // );
        return response()->json($query);
    }

    public function getHistoricalData3()
    {
        //avg values of hum for months which have data
        //  $query = DB::table('humidities')->selectRaw('MONTH(created_at) as month, round(avg(hum), 2) as avg')
        // ->groupBy('month')
        // ->get();
        //avg values of hum for each months, when null value is 0
        $query = DB::select("
          select
          sum(if(`month` = 1, hum, 0))  AS Jan,
          sum(if(`month` = 2, hum, 0))  AS Feb,
          sum(if(`month` = 3, hum, 0))  AS Mar,
          sum(if(`month` = 4, hum, 0))  AS Apr,
          sum(if(`month` = 5, hum, 0))  AS May,
          sum(if(`month` = 6, hum, 0))  AS Jun,
          sum(if(`month` = 7, hum, 0))  AS Jul,
          sum(if(`month` = 8, hum, 0))  AS Aug,
          sum(if(`month` = 9, hum, 0))  AS Sep,
          sum(if(`month` = 10, hum, 0)) AS Oct,
          sum(if(`month` = 11, hum, 0)) AS Nov,
          sum(if(`month` = 12, hum, 0)) AS `Dec`
        FROM
        (
          SELECT
            (month(created_at)) `month`,
            round(AVG(hum), 2) hum
          FROM humidities
          GROUP BY (month(created_at))
        ) AS T
          GROUP BY (month(`month`));
        ");
        return response()->json($query);
    }
}
