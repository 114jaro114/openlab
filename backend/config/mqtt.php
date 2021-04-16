<?php
/**
 * Created by PhpStorm.
 * User: salman
 * Date: 2/22/19
 * Time: 1:29 PM
 */

return [
    'host'      => env('MQTT_HOST', 'openlab.kpi.fei.tuke.sk'),
    'password'  => env('MQTT_PASSWORD', ''),
    'username'  => env('MQTT_USERNAME', ''),
    'certfile'  => env('MQTT_CERT_FILE', ''),
    'localcert' => env('MQTT_LOCAL_CERT', 'ws://'),
    'localpk'   => env('MQTT_LOCAL_PK', '/mqtt'),
    'port'      => env('MQTT_PORT', '80'),
    'timeout'   => (int) env('MQTT_TIMEOUT', 4000),
    'debug'     => (bool) env('MQTT_DEBUG', false), //Optional Parameter to enable debugging set it to True
    'qos'       => env('MQTT_QOS', 0), // set quality of service here
    // 'retain'    => env('MQTT_RETAIN', 0) // it should be 0 or 1 Whether the message should be retained.- Retain Flag
];
