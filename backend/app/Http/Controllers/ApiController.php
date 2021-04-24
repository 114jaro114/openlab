<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Humidity;
use App\Models\AllSensors;
use App\Events\HumEvent;
use App\Events\AllSensorsEvent;
use Carbon\Carbon;

class ApiController extends Controller
{
    // public function store(Request $request)
    // {
    //     // $hum = DB::insert('insert into humidity (hum) values (?)', [$request->hum]);
    //     $humidity = Humidity::create([
    //         'hum' => $request->hum
    //     ]);
    //     broadcast(new HumEvent($humidity))->toOthers();
    //     return response()->json($humidity);
    // }

    public function store2(Request $request)
    {
        $gtmp = preg_replace('/(.*)"gtmp": "(.*)", "vol":(.*)/sm', '\2', $request->data); //regullr expression for get gtmp
        $vol = preg_replace('/(.*)"vol": "(.*)", "light":(.*)/sm', '\2', $request->data); //regullr expression for get vol
        $light = preg_replace('/(.*)"light": "(.*)", "pres":(.*)/sm', '\2', $request->data); //regullr expression for get light
        $pres = preg_replace('/(.*)"pres": "(.*)", "humi":(.*)/sm', '\2', $request->data); //regullr expression for get pres
        $humi = preg_replace('/(.*)"humi": "(.*)", "atmp":(.*)/sm', '\2', $request->data); //regullr expression for get humi
        $atmp = preg_replace('/(.*)"atmp": "(.*)", "ts":(.*)/sm', '\2', $request->data); //regullr expression for get atmp
        $ts = preg_replace('/(.*)"ts": (.*)}(.*)/sm', '\2', $request->data); //regullr expression for get timestamp
        $dataAllSensors = AllSensors::create([
            'gtmp' => $gtmp,
            'atmp' => $atmp,
            'vol' => $vol,
            'light' => $light,
            'pres' => $pres,
            'humi' => $humi,
        ]);
        broadcast(new AllSensorsEvent($dataAllSensors))->toOthers();
        return response()->json($dataAllSensors);
    }

    // HOME PAGE
    public function getDataDashed()
    {
        $array0 = [];
        $array1 = [];
        $array2 = [];
        $array3 = [];
        $query = DB::select("select *
        FROM (
            select * FROM all_sensors ORDER BY id DESC LIMIT 10
        ) sub
        ORDER BY id ASC");


        foreach ($query as $row):
          array_push($array0, $row->gtmp);
        array_push($array1, $row->atmp);
        array_push($array2, $row->humi);
        array_push($array3, date('H:i:s', strtotime($row->created_at)));
        endforeach;

        $allData[] = array(
          $array0,
          $array1,
          $array2,
          $array3
        );

        return response()->json($allData);
    }

    public function getDataLine()
    {
        $array = [];
        $array1 = [];
        $array2 = [];
        $query = DB::select("
                            select
                            sum(if(`month` = 1, gtmp, 0))  AS Jan,
                            sum(if(`month` = 2, gtmp, 0))  AS Feb,
                            sum(if(`month` = 3, gtmp, 0))  AS Mar,
                            sum(if(`month` = 4, gtmp, 0))  AS Apr,
                            sum(if(`month` = 5, gtmp, 0))  AS May,
                            sum(if(`month` = 6, gtmp, 0))  AS Jun,
                            sum(if(`month` = 7, gtmp, 0))  AS Jul,
                            sum(if(`month` = 8, gtmp, 0))  AS Aug,
                            sum(if(`month` = 9, gtmp, 0))  AS Sep,
                            sum(if(`month` = 10, gtmp, 0)) AS Oct,
                            sum(if(`month` = 11, gtmp, 0)) AS Nov,
                            sum(if(`month` = 12, gtmp, 0)) AS `Dec`
                          FROM
                          (
                            SELECT
                              (month(created_at)) `month`,
                              round(AVG(gtmp), 2) gtmp
                            FROM all_sensors
                            GROUP BY (month(created_at))
                          ) AS T
                            GROUP BY (month(`month`));
                          ");

        $query1 = DB::select("
                            select
                            sum(if(`month` = 1, atmp, 0))  AS Jan,
                            sum(if(`month` = 2, atmp, 0))  AS Feb,
                            sum(if(`month` = 3, atmp, 0))  AS Mar,
                            sum(if(`month` = 4, atmp, 0))  AS Apr,
                            sum(if(`month` = 5, atmp, 0))  AS May,
                            sum(if(`month` = 6, atmp, 0))  AS Jun,
                            sum(if(`month` = 7, atmp, 0))  AS Jul,
                            sum(if(`month` = 8, atmp, 0))  AS Aug,
                            sum(if(`month` = 9, atmp, 0))  AS Sep,
                            sum(if(`month` = 10, atmp, 0)) AS Oct,
                            sum(if(`month` = 11, atmp, 0)) AS Nov,
                            sum(if(`month` = 12, atmp, 0)) AS `Dec`
                          FROM
                          (
                            SELECT
                              (month(created_at)) `month`,
                              round(AVG(atmp), 2) atmp
                            FROM all_sensors
                            GROUP BY (month(created_at))
                          ) AS T
                            GROUP BY (month(`month`));
                          ");

        $query2 = DB::select("
                            select
                            sum(if(`month` = 1, humi, 0))  AS Jan,
                            sum(if(`month` = 2, humi, 0))  AS Feb,
                            sum(if(`month` = 3, humi, 0))  AS Mar,
                            sum(if(`month` = 4, humi, 0))  AS Apr,
                            sum(if(`month` = 5, humi, 0))  AS May,
                            sum(if(`month` = 6, humi, 0))  AS Jun,
                            sum(if(`month` = 7, humi, 0))  AS Jul,
                            sum(if(`month` = 8, humi, 0))  AS Aug,
                            sum(if(`month` = 9, humi, 0))  AS Sep,
                            sum(if(`month` = 10, humi, 0)) AS Oct,
                            sum(if(`month` = 11, humi, 0)) AS Nov,
                            sum(if(`month` = 12, humi, 0)) AS `Dec`
                          FROM
                          (
                            SELECT
                              (month(created_at)) `month`,
                              round(AVG(humi), 2) humi
                            FROM all_sensors
                            GROUP BY (month(created_at))
                          ) AS T
                            GROUP BY (month(`month`));
                          ");

        $allData[] = array(
          $query,
          $query1,
          $query2,
        );

        return response()->json($allData);
    }

    public function getDataCircleMultiple()
    {
        $query = DB::select("select *
      FROM (
          select * FROM all_sensors ORDER BY id DESC LIMIT 1
      ) sub
      ORDER BY id ASC");
        return response()->json($query);
    }

    public function getDataAreasGroup()
    {
        $query = DB::select("select
        from_unixtime(round(unix_timestamp(created_at)/(10*60))*(10*60)) as timekey,
        round(AVG(gtmp), 2) gtmp
        FROM all_sensors
        GROUP BY timekey");

        $query1 = DB::select("select
        from_unixtime(round(unix_timestamp(created_at)/(10*60))*(10*60)) as timekey,
        round(AVG(atmp), 2) atmp
        FROM all_sensors
        GROUP BY timekey");

        $query2 = DB::select("select
        from_unixtime(round(unix_timestamp(created_at)/(10*60))*(10*60)) as timekey,
        round(AVG(humi), 2) humi
        FROM all_sensors
        GROUP BY timekey");

        $query3 = DB::select("select
        from_unixtime(round(unix_timestamp(created_at)/(10*60))*(10*60)) as timekey,
        round(AVG(vol), 2) vol
        FROM all_sensors
        GROUP BY timekey");

        $query4 = DB::select("select
        from_unixtime(round(unix_timestamp(created_at)/(10*60))*(10*60)) as timekey,
        round(AVG(light), 2) light
        FROM all_sensors
        GROUP BY timekey");

        $query5 = DB::select("select
        from_unixtime(round(unix_timestamp(created_at)/(10*60))*(10*60)) as timekey,
        round(AVG(pres), 2) pres
        FROM all_sensors
        GROUP BY timekey");

        $allData[] = array(
          $query,
          $query1,
          $query2,
          $query3,
          $query4,
          $query5,
        );
        return response()->json($allData);
    }

    //HUMIDITY
    public function getDataRealtimeHumidity()
    {
        $query = DB::select("select id, humi, created_at
        FROM (
            select id, humi, created_at FROM all_sensors ORDER BY id DESC LIMIT 10
        ) sub
        ORDER BY id ASC");

        return response()->json($query);
    }

    public function getHistoricalDataHumidity()
    {
        // $getDataLastMonth = AllSensors::where('created_at', '>=', Carbon::today()->subDays(30))->avg('humi');
        $query = DB::select("select humi, created_at
        FROM all_sensors");

        return response()->json($query);
    }

    public function getHistoricalData2Humidity()
    {
        $query = DB::select("select
        from_unixtime(round(unix_timestamp(created_at)/(60*60))*(60*60)) as timekey,
        substring_index(group_concat(humi order by created_at), ',', 1) as first_open,
        substring_index(group_concat(humi order by created_at desc), ',', 1) as last_close,
        MAX(humi) AS max_value,
        MIN(humi) As min_value
        FROM all_sensors
        GROUP BY timekey");

        return response()->json($query);
    }

    public function getHistoricalData3Humidity()
    {
        //avg values of hum for each months, when null value is 0
        $query = DB::select("
          select
          sum(if(`month` = 1, humi, 0))  AS Jan,
          sum(if(`month` = 2, humi, 0))  AS Feb,
          sum(if(`month` = 3, humi, 0))  AS Mar,
          sum(if(`month` = 4, humi, 0))  AS Apr,
          sum(if(`month` = 5, humi, 0))  AS May,
          sum(if(`month` = 6, humi, 0))  AS Jun,
          sum(if(`month` = 7, humi, 0))  AS Jul,
          sum(if(`month` = 8, humi, 0))  AS Aug,
          sum(if(`month` = 9, humi, 0))  AS Sep,
          sum(if(`month` = 10, humi, 0)) AS Oct,
          sum(if(`month` = 11, humi, 0)) AS Nov,
          sum(if(`month` = 12, humi, 0)) AS `Dec`
        FROM
        (
          select
            (month(created_at)) `month`,
            round(AVG(humi), 2) humi
          FROM all_sensors
          GROUP BY (month(created_at))
        ) AS T
          GROUP BY (month(`month`));
        ");

        return response()->json($query);
    }

    //Temperature gtmp + atmp
    public function getDataRealtimeTemperature()
    {
        $query = DB::select("select id, gtmp, created_at
        FROM (
            select id, gtmp, created_at FROM all_sensors ORDER BY id DESC LIMIT 10
        ) sub
        ORDER BY id ASC");

        return response()->json($query);
    }

    public function getHistoricalDataTemperature()
    {
        // $getDataLastMonth = AllSensors::where('created_at', '>=', Carbon::today()->subDays(30))->avg('humi');
        $query = DB::select("select gtmp, created_at
        FROM all_sensors");

        return response()->json($query);
    }

    public function getHistoricalData2Temperature()
    {
        $query = DB::select("select
        from_unixtime(round(unix_timestamp(created_at)/(60*60))*(60*60)) as timekey,
        substring_index(group_concat(gtmp order by created_at), ',', 1) as first_open,
        substring_index(group_concat(gtmp order by created_at desc), ',', 1) as last_close,
        MAX(gtmp) AS max_value,
        MIN(gtmp) As min_value
        FROM all_sensors
        GROUP BY timekey");

        return response()->json($query);
    }

    public function getHistoricalData3Temperature()
    {
        //avg values of hum for each months, when null value is 0
        $query = DB::select("
          select
          sum(if(`month` = 1, gtmp, 0))  AS Jan,
          sum(if(`month` = 2, gtmp, 0))  AS Feb,
          sum(if(`month` = 3, gtmp, 0))  AS Mar,
          sum(if(`month` = 4, gtmp, 0))  AS Apr,
          sum(if(`month` = 5, gtmp, 0))  AS May,
          sum(if(`month` = 6, gtmp, 0))  AS Jun,
          sum(if(`month` = 7, gtmp, 0))  AS Jul,
          sum(if(`month` = 8, gtmp, 0))  AS Aug,
          sum(if(`month` = 9, gtmp, 0))  AS Sep,
          sum(if(`month` = 10, gtmp, 0)) AS Oct,
          sum(if(`month` = 11, gtmp, 0)) AS Nov,
          sum(if(`month` = 12, gtmp, 0)) AS `Dec`
        FROM
        (
          select
            (month(created_at)) `month`,
            round(AVG(gtmp), 2) gtmp
          FROM all_sensors
          GROUP BY (month(created_at))
        ) AS T
          GROUP BY (month(`month`));
        ");

        return response()->json($query);
    }

    //Light
    public function getDataRealtimeLight()
    {
        $query = DB::select("select id, light, created_at
        FROM (
            select id, light, created_at FROM all_sensors ORDER BY id DESC LIMIT 10
        ) sub
        ORDER BY id ASC");

        return response()->json($query);
    }

    public function getHistoricalDataLight()
    {
        // $getDataLastMonth = AllSensors::where('created_at', '>=', Carbon::today()->subDays(30))->avg('humi');
        $query = DB::select("select light, created_at
        FROM all_sensors");

        return response()->json($query);
    }

    public function getHistoricalData2Light()
    {
        $query = DB::select("select
        from_unixtime(round(unix_timestamp(created_at)/(60*60))*(60*60)) as timekey,
        substring_index(group_concat(light order by created_at), ',', 1) as first_open,
        substring_index(group_concat(light order by created_at desc), ',', 1) as last_close,
        MAX(light) AS max_value,
        MIN(light) As min_value
        FROM all_sensors
        GROUP BY timekey");

        return response()->json($query);
    }

    public function getHistoricalData3Light()
    {
        //avg values of hum for each months, when null value is 0
        $query = DB::select("
          select
          sum(if(`month` = 1, light, 0))  AS Jan,
          sum(if(`month` = 2, light, 0))  AS Feb,
          sum(if(`month` = 3, light, 0))  AS Mar,
          sum(if(`month` = 4, light, 0))  AS Apr,
          sum(if(`month` = 5, light, 0))  AS May,
          sum(if(`month` = 6, light, 0))  AS Jun,
          sum(if(`month` = 7, light, 0))  AS Jul,
          sum(if(`month` = 8, light, 0))  AS Aug,
          sum(if(`month` = 9, light, 0))  AS Sep,
          sum(if(`month` = 10, light, 0)) AS Oct,
          sum(if(`month` = 11, light, 0)) AS Nov,
          sum(if(`month` = 12, light, 0)) AS `Dec`
        FROM
        (
          select
            (month(created_at)) `month`,
            round(AVG(light), 2) light
          FROM all_sensors
          GROUP BY (month(created_at))
        ) AS T
          GROUP BY (month(`month`));
        ");

        return response()->json($query);
    }

    //Pressure
    public function getDataRealtimePressure()
    {
        $query = DB::select("select id, pres, created_at
        FROM (
            select id, pres, created_at FROM all_sensors ORDER BY id DESC LIMIT 10
        ) sub
        ORDER BY id ASC");

        return response()->json($query);
    }

    public function getHistoricalDataPressure()
    {
        // $getDataLastMonth = AllSensors::where('created_at', '>=', Carbon::today()->subDays(30))->avg('humi');
        $query = DB::select("select pres, created_at
        FROM all_sensors");

        return response()->json($query);
    }

    public function getHistoricalData2Pressure()
    {
        $query = DB::select("select
        from_unixtime(round(unix_timestamp(created_at)/(60*60))*(60*60)) as timekey,
        substring_index(group_concat(pres order by created_at), ',', 1) as first_open,
        substring_index(group_concat(pres order by created_at desc), ',', 1) as last_close,
        MAX(pres) AS max_value,
        MIN(pres) As min_value
        FROM all_sensors
        GROUP BY timekey");

        return response()->json($query);
    }

    public function getHistoricalData3Pressure()
    {
        //avg values of hum for each months, when null value is 0
        $query = DB::select("
          select
          sum(if(`month` = 1, pres, 0))  AS Jan,
          sum(if(`month` = 2, pres, 0))  AS Feb,
          sum(if(`month` = 3, pres, 0))  AS Mar,
          sum(if(`month` = 4, pres, 0))  AS Apr,
          sum(if(`month` = 5, pres, 0))  AS May,
          sum(if(`month` = 6, pres, 0))  AS Jun,
          sum(if(`month` = 7, pres, 0))  AS Jul,
          sum(if(`month` = 8, pres, 0))  AS Aug,
          sum(if(`month` = 9, pres, 0))  AS Sep,
          sum(if(`month` = 10, pres, 0)) AS Oct,
          sum(if(`month` = 11, pres, 0)) AS Nov,
          sum(if(`month` = 12, pres, 0)) AS `Dec`
        FROM
        (
          select
            (month(created_at)) `month`,
            round(AVG(pres), 2) pres
          FROM all_sensors
          GROUP BY (month(created_at))
        ) AS T
          GROUP BY (month(`month`));
        ");

        return response()->json($query);
    }

    //Sound
    public function getDataRealtimeSound()
    {
        $query = DB::select("select id, vol, created_at
        FROM (
            select id, vol, created_at FROM all_sensors ORDER BY id DESC LIMIT 10
        ) sub
        ORDER BY id ASC");

        return response()->json($query);
    }

    public function getHistoricalDataSound()
    {
        // $getDataLastMonth = AllSensors::where('created_at', '>=', Carbon::today()->subDays(30))->avg('humi');
        $query = DB::select("select vol, created_at
        FROM all_sensors");

        return response()->json($query);
    }

    public function getHistoricalData2Sound()
    {
        $query = DB::select("select
        from_unixtime(round(unix_timestamp(created_at)/(60*60))*(60*60)) as timekey,
        substring_index(group_concat(vol order by created_at), ',', 1) as first_open,
        substring_index(group_concat(vol order by created_at desc), ',', 1) as last_close,
        MAX(vol) AS max_value,
        MIN(vol) As min_value
        FROM all_sensors
        GROUP BY timekey");

        return response()->json($query);
    }

    public function getHistoricalData3Sound()
    {
        //avg values of hum for each months, when null value is 0
        $query = DB::select("
          select
          sum(if(`month` = 1, vol, 0))  AS Jan,
          sum(if(`month` = 2, vol, 0))  AS Feb,
          sum(if(`month` = 3, vol, 0))  AS Mar,
          sum(if(`month` = 4, vol, 0))  AS Apr,
          sum(if(`month` = 5, vol, 0))  AS May,
          sum(if(`month` = 6, vol, 0))  AS Jun,
          sum(if(`month` = 7, vol, 0))  AS Jul,
          sum(if(`month` = 8, vol, 0))  AS Aug,
          sum(if(`month` = 9, vol, 0))  AS Sep,
          sum(if(`month` = 10, vol, 0)) AS Oct,
          sum(if(`month` = 11, vol, 0)) AS Nov,
          sum(if(`month` = 12, vol, 0)) AS `Dec`
        FROM
        (
          select
            (month(created_at)) `month`,
            round(AVG(vol), 2) vol
          FROM all_sensors
          GROUP BY (month(created_at))
        ) AS T
          GROUP BY (month(`month`));
        ");

        return response()->json($query);
    }
}
