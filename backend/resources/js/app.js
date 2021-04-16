require('./bootstrap');


$("#test")
    .click(function() {
        $.ajax({
            type: "POST",
            url: 'api/saveData',
            data: {
                hum: "100"
            },
            success: function(response) {
                console.log("super");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log("error");
            }
        });
    });

const mqtt = require('mqtt')
const client = mqtt.connect('ws://openlab.kpi.fei.tuke.sk/mqtt')
client.on('connect', () => {
    client.subscribe('openlab/sensorkits/B8:27:EB:2F:7B:7D/humi', {
        qos: 0
    })
})
client.on('message', function(topic, message) {
    // console.log('this message :', message.toString());
    $.ajax({
        type: "POST",
        url: 'api/saveData',
        data: {
            hum: message.toString()
        },
        success: function(response) {
            console.log(response);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log("error");
        }
    })
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