require('./bootstrap');

var ms = 0;
const mqtt = require('mqtt')
const client = mqtt.connect('ws://openlab.kpi.fei.tuke.sk/mqtt')
client.on('connect', () => {
    client.subscribe('openlab/sensorkits/B8:27:EB:2F:7B:7D/humi', {
        qos: 0
    })
})
client.on('message', function(topic, message) {
    // console.log('this message :', message.toString());
    ms = message.toString();
    //send the post request to laravel app
    // var sendDATA = message.toString();
    // var http = require('http');
    // var querystring = require('querystring');
    // const options = {
    //     hostname: '127.0.0.1',
    //     port: 8000,
    //     path: '/api/test',
    //     method: 'POST',
    //     headers: {
    //         'Content-Type': 'application/x-www-form-urlencoded',
    //         'Content-Length': Buffer.byteLength(postData)
    //     }
    // };
    // const req = http.request(options, (res) => {
    //     console.log(`STATUS: ${res.statusCode}`);
    //     console.log(`HEADERS: ${JSON.stringify(res.headers)}`);
    //     res.setEncoding('utf8');
    //     res.on('data', (chunk) => {
    //         console.log(`BODY: ${chunk}`);
    //     });
    //     res.on('end', () => {
    //         console.log('No more data in response.');
    //     });
    // });
    // req.on('error', (e) => {
    //     console.error(`problem with request: ${e.message}`);
    // });
    // req.write(postData);
    // req.end();
});

//insert data to db every 10sec (without this 1sec)
let timerId = setInterval(() => {
    if (ms != 0) {
        $.ajax({
            type: "POST",
            url: 'api/saveData',
            data: {
                hum: ms
            },
            success: function(response) {
                console.log(response);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log("error");
            }
        });
    } else {
        console.log("no connection to openlab kpi fei");
    }
}, 10000);