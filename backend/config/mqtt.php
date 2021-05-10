<?php
// MQTT broker: openlab.kpi.fei.tuke.sk (connectable only from TUKE network or TUKE VPN)
// available ports
// 80 - WebSocket
// 443 - Secure WebSocket (HTTPS)
// 1883 - TCP
// 8883 - Secure TCP (SSL)
// WebSocket uses default /mqtt path

return [
    'host'      => env('MQTT_HOST', 'openlab.kpi.fei.tuke.sk'),
    'password'  => env('MQTT_PASSWORD', ''),
    'username'  => env('MQTT_USERNAME', ''),
    'certfile'  => env('MQTT_CERT_FILE', ''),
    'localcert' => env('MQTT_LOCAL_CERT', ''),
    'localpk'   => env('MQTT_LOCAL_PK', ''),
    'port'      => env('MQTT_PORT', '1883'),
    'timeout'   => (int) env('MQTT_TIMEOUT', 4000),
    'debug'     => (bool) env('MQTT_DEBUG', true), //Optional Parameter to enable debugging set it to True
    'qos'       => env('MQTT_QOS', 0), // set quality of service here
    'retain'    => env('MQTT_RETAIN', 0) // it should be 0 or 1 Whether the message should be retained.- Retain Flag
];

//
// return [
//     'host'      => env('MQTT_HOST', 'openlab.kpi.fei.tuke.sk'),
//     'password'  => env('MQTT_PASSWORD', ''),
//     'username'  => env('MQTT_USERNAME', ''),
//     'certfile'  => env('MQTT_CERT_FILE', ''),
//     'localcert' => env('MQTT_LOCAL_CERT', 'ws://'),
//     'localpk'   => env('MQTT_LOCAL_PK', '/mqtt'),
//     'port'      => env('MQTT_PORT', '80'),
//     'timeout'   => (int) env('MQTT_TIMEOUT', 4000),
//     'debug'     => (bool) env('MQTT_DEBUG', false), //Optional Parameter to enable debugging set it to True
//     'qos'       => env('MQTT_QOS', 0), // set quality of service here
//     'retain'    => env('MQTT_RETAIN', 0) // it should be 0 or 1 Whether the message should be retained.- Retain Flag
// ];
