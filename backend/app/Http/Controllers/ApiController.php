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
    public function store(Request $request)
    {
        // $hum = DB::insert('insert into humidity (hum) values (?)', [$request->hum]);
        $humidity = Humidity::create([
            'hum' => $request->hum
        ]);
        broadcast(new HumEvent($humidity))->toOthers();
        return response()->json($humidity);
    }

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

    public function getData()
    {
        // $data = DB::table('humidities')->get();
        $query = DB::select("select *
        FROM (
            select * FROM humidities ORDER BY id DESC LIMIT 10
        ) sub
        ORDER BY id ASC");
        // Humidity::all();
        // foreach ($data as $row):
        // $array[] = array(
        //   $row->created_at,
        //   $row->hum,
        // );
        // endforeach;
        return response()->json($query);
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
