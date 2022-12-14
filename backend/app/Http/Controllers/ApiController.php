<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\AllSensors;
//models for enery
use App\Models\Voltage;
use App\Models\Current;
use App\Models\ActivePower;
use App\Models\ReactivePower;
use App\Models\ComplexPower;
use App\Models\EnergyImport;
use App\Models\EnergyExport;
//event for websocket
use App\Events\AllSensorsEvent;
use App\Events\PowerConsumptionEvent;
use Carbon\Carbon;
//mqtt
use Salman\Mqtt\MqttClass\Mqtt;

class ApiController extends Controller
{
    public function store()
    {
        $topic = 'MeriTo/KPI/B4-E6-2D-B0-13-91/Data';
        $mqtt = new Mqtt();
        $mqtt->ConnectAndSubscribe($topic, function($topic, $msg){

          $getStringU = preg_replace('/(.*)"U":{(.*)},"I":(.*)/sm', '\2', $msg); //regullar expression to get U l1 l2 l3
          $L1_U = preg_replace('/(.*)"L1":(.*),"L2":(.*)/sm', '\2', $getStringU); //regullar expression to get U l1
          $L2_U = preg_replace('/(.*),"L2":(.*),"L3":(.*)/sm', '\2', $getStringU); //regullar expression to get U l2
          $L3_U = preg_replace('/(.*),"L3":(.*)(.*)/sm', '\2', $getStringU); //regullar expression to get U l3

          $dataU = Voltage::create([
              'L1' => $L1_U,
              'L2' => $L2_U,
              'L3' => $L3_U
          ]);
          //
          $getStringI = preg_replace('/(.*)"I":{(.*)},"P":(.*)/sm', '\2', $msg); //regullr expression for get I l1 l2 l3
          $L1_I = preg_replace('/(.*)"L1":(.*),"L2":(.*)/sm', '\2', $getStringI); //regullr expression for get I l1
          $L2_I = preg_replace('/(.*),"L2":(.*),"L3":(.*)/sm', '\2', $getStringI); //regullr expression for get I l2
          $L3_I = preg_replace('/(.*),"L3":(.*)(.*)/sm', '\2', $getStringI); //regullr expression for get get I l3

          $dataI = Current::create([
              'L1' => $L1_I,
              'L2' => $L2_I,
              'L3' => $L3_I
          ]);
          //
          $getStringP = preg_replace('/(.*)"P":{(.*)},"S":(.*)/sm', '\2', $msg); //regullr expression for get P l1 l2 l3
          $L1_P = preg_replace('/(.*)"L1":(.*),"L2":(.*)/sm', '\2', $getStringP); //regullr expression for get P l1
          $L2_P = preg_replace('/(.*),"L2":(.*),"L3":(.*)/sm', '\2', $getStringP); //regullr expression for get P l2
          $L3_P = preg_replace('/(.*),"L3":(.*)(.*)/sm', '\2', $getStringP); //regullr expression for get P l3

          $dataP = ActivePower::create([
              'L1' => $L1_P,
              'L2' => $L2_P,
              'L3' => $L3_P
          ]);
          //
          $getStringS = preg_replace('/(.*)"S":{(.*)},"Q":(.*)/sm', '\2', $msg); //regullr expression for get S l1 l2 l3
          $L1_S = preg_replace('/(.*)"L1":(.*),"L2":(.*)/sm', '\2', $getStringS); //regullr expression for get S l1
          $L2_S = preg_replace('/(.*),"L2":(.*),"L3":(.*)/sm', '\2', $getStringS); //regullr expression for get S l2
          $L3_S = preg_replace('/(.*),"L3":(.*)(.*)/sm', '\2', $getStringS); //regullr expression for get S l3

          $dataS = ComplexPower::create([
              'L1' => $L1_S,
              'L2' => $L2_S,
              'L3' => $L3_S
          ]);
          //
          $getStringQ = preg_replace('/(.*)"Q":{(.*)},"E_I":(.*)/sm', '\2', $msg); //regullr expression for get Q l1 l2 l3
          $L1_Q = preg_replace('/(.*)"L1":(.*),"L2":(.*)/sm', '\2', $getStringQ); //regullr expression for get Q l1
          $L2_Q = preg_replace('/(.*),"L2":(.*),"L3":(.*)/sm', '\2', $getStringQ); //regullr expression for get Q l2
          $L3_Q = preg_replace('/(.*),"L3":(.*)(.*)/sm', '\2', $getStringQ); //regullr expression for get Q l3

          $dataQ = ReactivePower::create([
              'L1' => $L1_Q,
              'L2' => $L2_Q,
              'L3' => $L3_Q
          ]);
          //
          $getStringE_I = preg_replace('/(.*)"E_I":{(.*)},"E_E":(.*)/sm', '\2', $msg); //regullr expression for get E_I l1 l2 l3
          $L1_E_I = preg_replace('/(.*)"L1":(.*),"L2":(.*)/sm', '\2', $getStringE_I); //regullr expression for get E_I l1
          $L2_E_I = preg_replace('/(.*),"L2":(.*),"L3":(.*)/sm', '\2', $getStringE_I); //regullr expression for get E_I l2
          $L3_E_I = preg_replace('/(.*),"L3":(.*)(.*)/sm', '\2', $getStringE_I); //regullr expression for get E_I l3

          $dataE_I = EnergyImport::create([
              'L1' => $L1_E_I,
              'L2' => $L2_E_I,
              'L3' => $L3_E_I
          ]);
          //
          $getStringE_E = preg_replace('/(.*)"E_E":{(.*)}}(.*)/sm', '\2', $msg); //regullr expression for get E_E l1 l2 l3
          $L1_E_E = preg_replace('/(.*)"L1":(.*),"L2":(.*)/sm', '\2', $getStringE_E); //regullr expression for get E_E l1
          $L2_E_E = preg_replace('/(.*),"L2":(.*),"L3":(.*)/sm', '\2', $getStringE_E); //regullr expression for get E_E l2
          $L3_E_E = preg_replace('/(.*),"L3":(.*)(.*)/sm', '\2', $getStringE_E); //regullr expression for get E_E l3

          $dataE_E = EnergyExport::create([
              'L1' => $L1_E_E,
              'L2' => $L2_E_E,
              'L3' => $L3_E_E
          ]);

          $allData[] = array(
            'U' => $dataU,
            'I' => $dataI,
            'P' => $dataP,
            'S' => $dataS,
            'Q' => $dataQ,
            'E_I' => $dataE_I,
            'E_E' => $dataE_E
          );

          broadcast(new PowerConsumptionEvent($allData))->toOthers();

          exit();
        });
        return response()->json("success");
    }

    public function store2()
    {
        $topic = 'openlab/sensorkits/B8:27:EB:2F:7B:7D/json';
        $mqtt = new Mqtt();
        $mqtt->ConnectAndSubscribe($topic, function($topic, $msg){
          $gtmp = preg_replace('/(.*)"gtmp": "(.*)", "vol":(.*)/sm', '\2', $msg); //regullar expression to get gtmp
          $vol = preg_replace('/(.*)"vol": "(.*)", "light":(.*)/sm', '\2', $msg); //regullar expression to get vol
          $light = preg_replace('/(.*)"light": "(.*)", "pres":(.*)/sm', '\2', $msg); //regullar expression to get light
          $pres = preg_replace('/(.*)"pres": "(.*)", "humi":(.*)/sm', '\2', $msg); //regullar expression to get pres
          $humi = preg_replace('/(.*)"humi": "(.*)", "atmp":(.*)/sm', '\2', $msg); //regullar expression to get humi
          $atmp = preg_replace('/(.*)"atmp": "(.*)", "ts":(.*)/sm', '\2', $msg); //regullar expression to get atmp
          $ts = preg_replace('/(.*)"ts": (.*)}(.*)/sm', '\2', $msg); //regullar expression to get timestamp
          $dataAllSensors = AllSensors::create([
              'gtmp' => $gtmp,
              'atmp' => $atmp,
              'vol' => $vol,
              'light' => $light,
              'pres' => $pres,
              'humi' => $humi,
          ]);
          broadcast(new AllSensorsEvent($dataAllSensors))->toOthers();
          exit();
        });
        return response()->json("success");
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
      // sum(WHEN(`month` = 1, gtmp) THEN 0  AS Jan,
      // sum(WHEN(`month` = 2, gtmp, 0))  AS Feb,
      // sum(WHEN(`month` = 3, gtmp, 0))  AS Mar,
      // sum(WHEN(`month` = 4, gtmp, 0))  AS Apr,
      // sum(WHEN(`month` = 5, gtmp, 0))  AS May,
      // sum(WHEN(`month` = 6, gtmp, 0))  AS Jun,
      // sum(WHEN(`month` = 7, gtmp, 0))  AS Jul,
      // sum(WHEN(`month` = 8, gtmp, 0))  AS Aug,
      // sum(WHEN(`month` = 9, gtmp, 0))  AS Sep,
      // sum(WHEN(`month` = 10, gtmp, 0)) AS Oct,
      // sum(WHEN(`month` = 11, gtmp, 0)) AS Nov,
      // sum(WHEN(`month` = 12, gtmp, 0)) AS `Dec`
        $array = [];
        $array1 = [];
        $array2 = [];
        $query = DB::select("
                            select
                            SUM(CASE WHEN (`month` = '01') THEN gtmp ELSE 0 END) AS Jan,
                            SUM(CASE WHEN (`month` = '02') THEN gtmp ELSE 0 END) AS Feb,
                            SUM(CASE WHEN (`month` = '03') THEN gtmp ELSE 0 END) AS Mar,
                            SUM(CASE WHEN (`month` = '04') THEN gtmp ELSE 0 END) AS Apr,
                            SUM(CASE WHEN (`month` = '05') THEN gtmp ELSE 0 END) AS May,
                            SUM(CASE WHEN (`month` = '06') THEN gtmp ELSE 0 END) AS Jun,
                            SUM(CASE WHEN (`month` = '07') THEN gtmp ELSE 0 END) AS Jul,
                            SUM(CASE WHEN (`month` = '08') THEN gtmp ELSE 0 END) AS Aug,
                            SUM(CASE WHEN (`month` = '09') THEN gtmp ELSE 0 END) AS Sep,
                            SUM(CASE WHEN (`month` = '10') THEN gtmp ELSE 0 END) AS Oct,
                            SUM(CASE WHEN (`month` = '11') THEN gtmp ELSE 0 END) AS Nov,
                            SUM(CASE WHEN (`month` = '12') THEN gtmp ELSE 0 END) AS Dec
                          FROM
                          (
                            SELECT
                              (strftime('%m', created_at)) `month`,
                              round(AVG(gtmp), 2) gtmp
                            FROM all_sensors
                            GROUP BY (strftime('%m', created_at))
                          ) AS T
                            GROUP BY (strftime('%m', `month`));
                          ");

        $query1 = DB::select("
                            select
                            SUM(CASE WHEN (`month` = '01') THEN atmp ELSE 0 END) AS Jan,
                            SUM(CASE WHEN (`month` = '02') THEN atmp ELSE 0 END) AS Feb,
                            SUM(CASE WHEN (`month` = '03') THEN atmp ELSE 0 END) AS Mar,
                            SUM(CASE WHEN (`month` = '04') THEN atmp ELSE 0 END) AS Apr,
                            SUM(CASE WHEN (`month` = '05') THEN atmp ELSE 0 END) AS May,
                            SUM(CASE WHEN (`month` = '06') THEN atmp ELSE 0 END) AS Jun,
                            SUM(CASE WHEN (`month` = '07') THEN atmp ELSE 0 END) AS Jul,
                            SUM(CASE WHEN (`month` = '08') THEN atmp ELSE 0 END) AS Aug,
                            SUM(CASE WHEN (`month` = '09') THEN atmp ELSE 0 END) AS Sep,
                            SUM(CASE WHEN (`month` = '10') THEN atmp ELSE 0 END) AS Oct,
                            SUM(CASE WHEN (`month` = '11') THEN atmp ELSE 0 END) AS Nov,
                            SUM(CASE WHEN (`month` = '12') THEN atmp ELSE 0 END) AS Dec
                          FROM
                          (
                            SELECT
                              (strftime('%m',created_at)) `month`,
                              round(AVG(atmp), 2) atmp
                            FROM all_sensors
                            GROUP BY (strftime('%m',created_at))
                          ) AS T
                            GROUP BY (strftime('%m',`month`));
                          ");

        $query2 = DB::select("
                            select
                            SUM(CASE WHEN (`month` = '01') THEN humi ELSE 0 END) AS Jan,
                            SUM(CASE WHEN (`month` = '02') THEN humi ELSE 0 END) AS Feb,
                            SUM(CASE WHEN (`month` = '03') THEN humi ELSE 0 END) AS Mar,
                            SUM(CASE WHEN (`month` = '04') THEN humi ELSE 0 END) AS Apr,
                            SUM(CASE WHEN (`month` = '05') THEN humi ELSE 0 END) AS May,
                            SUM(CASE WHEN (`month` = '06') THEN humi ELSE 0 END) AS Jun,
                            SUM(CASE WHEN (`month` = '07') THEN humi ELSE 0 END) AS Jul,
                            SUM(CASE WHEN (`month` = '08') THEN humi ELSE 0 END) AS Aug,
                            SUM(CASE WHEN (`month` = '09') THEN humi ELSE 0 END) AS Sep,
                            SUM(CASE WHEN (`month` = '10') THEN humi ELSE 0 END) AS Oct,
                            SUM(CASE WHEN (`month` = '11') THEN humi ELSE 0 END) AS Nov,
                            SUM(CASE WHEN (`month` = '12') THEN humi ELSE 0 END) AS Dec
                          FROM
                          (
                            SELECT
                              (strftime('%m',created_at)) `month`,
                              round(AVG(humi), 2) humi
                            FROM all_sensors
                            GROUP BY (strftime('%m',created_at))
                          ) AS T
                            GROUP BY (strftime('%m',`month`));
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
        DATETIME(round(strftime('%s', created_at)/(10*60))*(10*60), 'unixepoch') as timekey,
        round(AVG(gtmp), 2) gtmp
        FROM all_sensors
        GROUP BY timekey");

        $query1 = DB::select("select
        DATETIME(round(strftime('%s',created_at)/(10*60))*(10*60), 'unixepoch') as timekey,
        round(AVG(atmp), 2) atmp
        FROM all_sensors
        GROUP BY timekey");

        $query2 = DB::select("select
        DATETIME(round(strftime('%s',created_at)/(10*60))*(10*60), 'unixepoch') as timekey,
        round(AVG(humi), 2) humi
        FROM all_sensors
        GROUP BY timekey");

        $query3 = DB::select("select
        DATETIME(round(strftime('%s',created_at)/(10*60))*(10*60), 'unixepoch') as timekey,
        round(AVG(vol), 2) vol
        FROM all_sensors
        GROUP BY timekey");

        $query4 = DB::select("select
        DATETIME(round(strftime('%s',created_at)/(10*60))*(10*60), 'unixepoch') as timekey,
        round(AVG(light), 2) light
        FROM all_sensors
        GROUP BY timekey");

        $query5 = DB::select("select
        DATETIME(round(strftime('%s',created_at)/(10*60))*(10*60), 'unixepoch') as timekey,
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
      //
      // (
      // select humi
      // from all_sensors
      // order by created_at asc limit 1
      // ) as first_open,
      //
      // (
      // select humi
      // from all_sensors
      // group by DATETIME(round(strftime('%s', created_at)/(60*60))*(60*60), 'unixepoch')
      // order by created_at desc limit 1
      // ) as last_close,

              //
              // MAX(humi) AS max_value,
              // MIN(humi) As min_value
      // substring_index(group_concat(humi ORDER BY created_at), ',', 1) as first_open,
      // substring_index(group_concat(humi ORDER BY created_at desc), ',', 1) as last_close,

        $query = DB::select("
        select DISTINCT FIRST_VALUE(s2.humi) OVER (PARTITION by s2.timekey) as first_open,
        LAST_VALUE(s2.humi) OVER (PARTITION by s2.timekey) as last_close,
        MAX(s2.humi) OVER (PARTITION by s2.timekey) AS max_value,
        MIN(s2.humi) OVER (PARTITION by s2.timekey) As min_value,
        s2.timekey
        from
        (select humi,
        DATETIME(round(strftime('%s', created_at)/(60*60))*(60*60), 'unixepoch') as timekey
        FROM all_sensors) as s2");

        return response()->json($query);
    }

    public function getHistoricalData3Humidity()
    {
        //avg values of hum for each months, when null value is 0
        $query = DB::select("
                            select
                            SUM(CASE WHEN (`month` = '01') THEN humi ELSE 0 END) AS Jan,
                            SUM(CASE WHEN (`month` = '02') THEN humi ELSE 0 END) AS Feb,
                            SUM(CASE WHEN (`month` = '03') THEN humi ELSE 0 END) AS Mar,
                            SUM(CASE WHEN (`month` = '04') THEN humi ELSE 0 END) AS Apr,
                            SUM(CASE WHEN (`month` = '05') THEN humi ELSE 0 END) AS May,
                            SUM(CASE WHEN (`month` = '06') THEN humi ELSE 0 END) AS Jun,
                            SUM(CASE WHEN (`month` = '07') THEN humi ELSE 0 END) AS Jul,
                            SUM(CASE WHEN (`month` = '08') THEN humi ELSE 0 END) AS Aug,
                            SUM(CASE WHEN (`month` = '09') THEN humi ELSE 0 END) AS Sep,
                            SUM(CASE WHEN (`month` = '10') THEN humi ELSE 0 END) AS Oct,
                            SUM(CASE WHEN (`month` = '11') THEN humi ELSE 0 END) AS Nov,
                            SUM(CASE WHEN (`month` = '12') THEN humi ELSE 0 END) AS Dec
                          FROM
                          (
                            SELECT
                              (strftime('%m',created_at)) `month`,
                              round(AVG(humi), 2) humi
                            FROM all_sensors
                            GROUP BY (strftime('%m',created_at))
                          ) AS T
                            GROUP BY (strftime('%m',`month`));
                          ");
        return response()->json($query);
    }

    //Temperature gtmp + atmp
    public function getDataRealtimeTemperatureGtmp()
    {
        $query = DB::select("select id, gtmp, created_at
        FROM (
            select id, gtmp, created_at FROM all_sensors ORDER BY id DESC LIMIT 10
        ) sub
        ORDER BY id ASC");

        return response()->json($query);
    }

    public function getHistoricalDataTemperatureGtmp()
    {
        $query = DB::select("select gtmp, created_at
        FROM all_sensors");

        return response()->json($query);
    }

    public function getHistoricalData2TemperatureGtmp()
    {
        $query = DB::select("
        select DISTINCT FIRST_VALUE(s2.gtmp) OVER (PARTITION by s2.timekey) as first_open,
        LAST_VALUE(s2.gtmp) OVER (PARTITION by s2.timekey) as last_close,
        MAX(s2.gtmp) OVER (PARTITION by s2.timekey) AS max_value,
        MIN(s2.gtmp) OVER (PARTITION by s2.timekey) As min_value,
        s2.timekey
        from
        (select gtmp,
        DATETIME(round(strftime('%s', created_at)/(60*60))*(60*60), 'unixepoch') as timekey
        FROM all_sensors) as s2");

        return response()->json($query);
    }

    public function getHistoricalData3TemperatureGtmp()
    {
        //avg values of hum for each months, when null value is 0
        $query = DB::select("
        select
        SUM(CASE WHEN (`month` = '01') THEN gtmp ELSE 0 END) AS Jan,
        SUM(CASE WHEN (`month` = '02') THEN gtmp ELSE 0 END) AS Feb,
        SUM(CASE WHEN (`month` = '03') THEN gtmp ELSE 0 END) AS Mar,
        SUM(CASE WHEN (`month` = '04') THEN gtmp ELSE 0 END) AS Apr,
        SUM(CASE WHEN (`month` = '05') THEN gtmp ELSE 0 END) AS May,
        SUM(CASE WHEN (`month` = '06') THEN gtmp ELSE 0 END) AS Jun,
        SUM(CASE WHEN (`month` = '07') THEN gtmp ELSE 0 END) AS Jul,
        SUM(CASE WHEN (`month` = '08') THEN gtmp ELSE 0 END) AS Aug,
        SUM(CASE WHEN (`month` = '09') THEN gtmp ELSE 0 END) AS Sep,
        SUM(CASE WHEN (`month` = '10') THEN gtmp ELSE 0 END) AS Oct,
        SUM(CASE WHEN (`month` = '11') THEN gtmp ELSE 0 END) AS Nov,
        SUM(CASE WHEN (`month` = '12') THEN gtmp ELSE 0 END) AS Dec
      FROM
      (
        SELECT
          (strftime('%m', created_at)) `month`,
          round(AVG(gtmp), 2) gtmp
        FROM all_sensors
        GROUP BY (strftime('%m', created_at))
      ) AS T
        GROUP BY (strftime('%m', `month`));
      ");

        return response()->json($query);
    }
    public function getDataRealtimeTemperatureAtmp()
    {
        $query = DB::select("select id, atmp, created_at
        FROM (
            select id, atmp, created_at FROM all_sensors ORDER BY id DESC LIMIT 10
        ) sub
        ORDER BY id ASC");

        return response()->json($query);
    }

    public function getHistoricalDataTemperatureAtmp()
    {
        $query = DB::select("select atmp, created_at
        FROM all_sensors");

        return response()->json($query);
    }

    public function getHistoricalData2TemperatureAtmp()
    {
        $query = DB::select("
        select DISTINCT FIRST_VALUE(s2.atmp) OVER (PARTITION by s2.timekey) as first_open,
        LAST_VALUE(s2.atmp) OVER (PARTITION by s2.timekey) as last_close,
        MAX(s2.atmp) OVER (PARTITION by s2.timekey) AS max_value,
        MIN(s2.atmp) OVER (PARTITION by s2.timekey) As min_value,
        s2.timekey
        from
        (select atmp,
        DATETIME(round(strftime('%s', created_at)/(60*60))*(60*60), 'unixepoch') as timekey
        FROM all_sensors) as s2");

        return response()->json($query);
    }

    public function getHistoricalData3TemperatureAtmp()
    {
        //avg values of hum for each months, when null value is 0
        $query = DB::select("
        select
        SUM(CASE WHEN (`month` = '01') THEN atmp ELSE 0 END) AS Jan,
        SUM(CASE WHEN (`month` = '02') THEN atmp ELSE 0 END) AS Feb,
        SUM(CASE WHEN (`month` = '03') THEN atmp ELSE 0 END) AS Mar,
        SUM(CASE WHEN (`month` = '04') THEN atmp ELSE 0 END) AS Apr,
        SUM(CASE WHEN (`month` = '05') THEN atmp ELSE 0 END) AS May,
        SUM(CASE WHEN (`month` = '06') THEN atmp ELSE 0 END) AS Jun,
        SUM(CASE WHEN (`month` = '07') THEN atmp ELSE 0 END) AS Jul,
        SUM(CASE WHEN (`month` = '08') THEN atmp ELSE 0 END) AS Aug,
        SUM(CASE WHEN (`month` = '09') THEN atmp ELSE 0 END) AS Sep,
        SUM(CASE WHEN (`month` = '10') THEN atmp ELSE 0 END) AS Oct,
        SUM(CASE WHEN (`month` = '11') THEN atmp ELSE 0 END) AS Nov,
        SUM(CASE WHEN (`month` = '12') THEN atmp ELSE 0 END) AS Dec
      FROM
      (
        SELECT
          (strftime('%m',created_at)) `month`,
          round(AVG(atmp), 2) atmp
        FROM all_sensors
        GROUP BY (strftime('%m',created_at))
      ) AS T
        GROUP BY (strftime('%m',`month`));
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
        $query = DB::select("
        select DISTINCT FIRST_VALUE(s2.light) OVER (PARTITION by s2.timekey) as first_open,
        LAST_VALUE(s2.light) OVER (PARTITION by s2.timekey) as last_close,
        MAX(s2.light) OVER (PARTITION by s2.timekey) AS max_value,
        MIN(s2.light) OVER (PARTITION by s2.timekey) As min_value,
        s2.timekey
        from
        (select light,
        DATETIME(round(strftime('%s', created_at)/(60*60))*(60*60), 'unixepoch') as timekey
        FROM all_sensors) as s2");

        return response()->json($query);
    }

    public function getHistoricalData3Light()
    {
        //avg values of hum for each months, when null value is 0
        $query = DB::select("
        select
        SUM(CASE WHEN (`month` = '01') THEN light ELSE 0 END) AS Jan,
        SUM(CASE WHEN (`month` = '02') THEN light ELSE 0 END) AS Feb,
        SUM(CASE WHEN (`month` = '03') THEN light ELSE 0 END) AS Mar,
        SUM(CASE WHEN (`month` = '04') THEN light ELSE 0 END) AS Apr,
        SUM(CASE WHEN (`month` = '05') THEN light ELSE 0 END) AS May,
        SUM(CASE WHEN (`month` = '06') THEN light ELSE 0 END) AS Jun,
        SUM(CASE WHEN (`month` = '07') THEN light ELSE 0 END) AS Jul,
        SUM(CASE WHEN (`month` = '08') THEN light ELSE 0 END) AS Aug,
        SUM(CASE WHEN (`month` = '09') THEN light ELSE 0 END) AS Sep,
        SUM(CASE WHEN (`month` = '10') THEN light ELSE 0 END) AS Oct,
        SUM(CASE WHEN (`month` = '11') THEN light ELSE 0 END) AS Nov,
        SUM(CASE WHEN (`month` = '12') THEN light ELSE 0 END) AS Dec
      FROM
      (
        SELECT
          (strftime('%m',created_at)) `month`,
          round(AVG(light), 2) light
        FROM all_sensors
        GROUP BY (strftime('%m',created_at))
      ) AS T
        GROUP BY (strftime('%m',`month`));
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
        $query = DB::select("
        select DISTINCT FIRST_VALUE(s2.pres) OVER (PARTITION by s2.timekey) as first_open,
        LAST_VALUE(s2.pres) OVER (PARTITION by s2.timekey) as last_close,
        MAX(s2.pres) OVER (PARTITION by s2.timekey) AS max_value,
        MIN(s2.pres) OVER (PARTITION by s2.timekey) As min_value,
        s2.timekey
        from
        (select pres,
        DATETIME(round(strftime('%s', created_at)/(60*60))*(60*60), 'unixepoch') as timekey
        FROM all_sensors) as s2");

        return response()->json($query);
    }

    public function getHistoricalData3Pressure()
    {
        //avg values of hum for each months, when null value is 0
        $query = DB::select("
        select
        SUM(CASE WHEN (`month` = '01') THEN pres ELSE 0 END) AS Jan,
        SUM(CASE WHEN (`month` = '02') THEN pres ELSE 0 END) AS Feb,
        SUM(CASE WHEN (`month` = '03') THEN pres ELSE 0 END) AS Mar,
        SUM(CASE WHEN (`month` = '04') THEN pres ELSE 0 END) AS Apr,
        SUM(CASE WHEN (`month` = '05') THEN pres ELSE 0 END) AS May,
        SUM(CASE WHEN (`month` = '06') THEN pres ELSE 0 END) AS Jun,
        SUM(CASE WHEN (`month` = '07') THEN pres ELSE 0 END) AS Jul,
        SUM(CASE WHEN (`month` = '08') THEN pres ELSE 0 END) AS Aug,
        SUM(CASE WHEN (`month` = '09') THEN pres ELSE 0 END) AS Sep,
        SUM(CASE WHEN (`month` = '10') THEN pres ELSE 0 END) AS Oct,
        SUM(CASE WHEN (`month` = '11') THEN pres ELSE 0 END) AS Nov,
        SUM(CASE WHEN (`month` = '12') THEN pres ELSE 0 END) AS Dec
      FROM
      (
        SELECT
          (strftime('%m',created_at)) `month`,
          round(AVG(pres), 2) pres
        FROM all_sensors
        GROUP BY (strftime('%m',created_at))
      ) AS T
        GROUP BY (strftime('%m',`month`));
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
        $query = DB::select("
        select DISTINCT FIRST_VALUE(s2.vol) OVER (PARTITION by s2.timekey) as first_open,
        LAST_VALUE(s2.vol) OVER (PARTITION by s2.timekey) as last_close,
        MAX(s2.vol) OVER (PARTITION by s2.timekey) AS max_value,
        MIN(s2.vol) OVER (PARTITION by s2.timekey) As min_value,
        s2.timekey
        from
        (select vol,
        DATETIME(round(strftime('%s', created_at)/(60*60))*(60*60), 'unixepoch') as timekey
        FROM all_sensors) as s2");

        return response()->json($query);
    }

    public function getHistoricalData3Sound()
    {
        //avg values of hum for each months, when null value is 0
        $query = DB::select("
        select
        SUM(CASE WHEN (`month` = '01') THEN vol ELSE 0 END) AS Jan,
        SUM(CASE WHEN (`month` = '02') THEN vol ELSE 0 END) AS Feb,
        SUM(CASE WHEN (`month` = '03') THEN vol ELSE 0 END) AS Mar,
        SUM(CASE WHEN (`month` = '04') THEN vol ELSE 0 END) AS Apr,
        SUM(CASE WHEN (`month` = '05') THEN vol ELSE 0 END) AS May,
        SUM(CASE WHEN (`month` = '06') THEN vol ELSE 0 END) AS Jun,
        SUM(CASE WHEN (`month` = '07') THEN vol ELSE 0 END) AS Jul,
        SUM(CASE WHEN (`month` = '08') THEN vol ELSE 0 END) AS Aug,
        SUM(CASE WHEN (`month` = '09') THEN vol ELSE 0 END) AS Sep,
        SUM(CASE WHEN (`month` = '10') THEN vol ELSE 0 END) AS Oct,
        SUM(CASE WHEN (`month` = '11') THEN vol ELSE 0 END) AS Nov,
        SUM(CASE WHEN (`month` = '12') THEN vol ELSE 0 END) AS Dec
      FROM
      (
        SELECT
          (strftime('%m',created_at)) `month`,
          round(AVG(vol), 2) vol
        FROM all_sensors
        GROUP BY (strftime('%m',created_at))
      ) AS T
        GROUP BY (strftime('%m',`month`));
      ");

        return response()->json($query);
    }


    ///Energy
    // U
    public function getDataDashedU()
    {
        $array0 = [];
        $array1 = [];
        $array2 = [];
        $array3 = [];
        $query = DB::select("select *
        FROM (
            select * FROM voltages ORDER BY id DESC LIMIT 10
        ) sub
        ORDER BY id ASC");


        foreach ($query as $row):
          array_push($array0, $row->L1);
        array_push($array1, $row->L2);
        array_push($array2, $row->L3);
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
    // I
    public function getDataDashedI()
    {
        $array0 = [];
        $array1 = [];
        $array2 = [];
        $array3 = [];
        $query = DB::select("select *
        FROM (
            select * FROM currents ORDER BY id DESC LIMIT 10
        ) sub
        ORDER BY id ASC");


        foreach ($query as $row):
          array_push($array0, $row->L1);
        array_push($array1, $row->L2);
        array_push($array2, $row->L3);
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
    // P
    public function getDataDashedP()
    {
        $array0 = [];
        $array1 = [];
        $array2 = [];
        $array3 = [];
        $query = DB::select("select *
        FROM (
            select * FROM active_powers ORDER BY id DESC LIMIT 10
        ) sub
        ORDER BY id ASC");


        foreach ($query as $row):
          array_push($array0, $row->L1);
        array_push($array1, $row->L2);
        array_push($array2, $row->L3);
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
    // S
    public function getDataDashedS()
    {
        $array0 = [];
        $array1 = [];
        $array2 = [];
        $array3 = [];
        $query = DB::select("select *
        FROM (
            select * FROM complex_powers ORDER BY id DESC LIMIT 10
        ) sub
        ORDER BY id ASC");


        foreach ($query as $row):
          array_push($array0, $row->L1);
        array_push($array1, $row->L2);
        array_push($array2, $row->L3);
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
    // Q
    public function getDataDashedQ()
    {
        $array0 = [];
        $array1 = [];
        $array2 = [];
        $array3 = [];
        $query = DB::select("select *
        FROM (
            select * FROM reactive_powers ORDER BY id DESC LIMIT 10
        ) sub
        ORDER BY id ASC");


        foreach ($query as $row):
          array_push($array0, $row->L1);
        array_push($array1, $row->L2);
        array_push($array2, $row->L3);
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

    public function getDataDashedE_I()
    {
        $array0 = [];
        $array1 = [];
        $array2 = [];
        $array3 = [];
        $query = DB::select("select *
        FROM (
            select * FROM energy_imports ORDER BY id DESC LIMIT 10
        ) sub
        ORDER BY id ASC");


        foreach ($query as $row):
          array_push($array0, $row->L1);
        array_push($array1, $row->L2);
        array_push($array2, $row->L3);
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

    public function getDataDashedE_E()
    {
        $array0 = [];
        $array1 = [];
        $array2 = [];
        $array3 = [];
        $query = DB::select("select *
        FROM (
            select * FROM energy_exports ORDER BY id DESC LIMIT 10
        ) sub
        ORDER BY id ASC");


        foreach ($query as $row):
          array_push($array0, $row->L1);
        array_push($array1, $row->L2);
        array_push($array2, $row->L3);
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
}
