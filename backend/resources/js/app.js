require('./bootstrap');

var ms2 = 0;
const mqtt2 = require('mqtt')

const client2 = mqtt2.connect('ws://openlab.kpi.fei.tuke.sk/mqtt')

client2.on('connect', () => {
    client2.subscribe('openlab/sensorkits/B8:27:EB:2F:7B:7D/json', {
        qos: 0
    });
})

client2.on('message', function(topic2, message2) {
    // console.log('this message :', message2.toString());
    ms2 = message2.toString();
});

//insert data to db every 10sec
let timerId2 = setInterval(() => {
    if (ms2 != 0) {
        $.ajax({
            type: "POST",
            url: 'api/saveDataAllSensors',
            data: {
                data: ms2
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



var ms = 0;
const mqtt = require('mqtt')
const client = mqtt.connect('ws://openlab.kpi.fei.tuke.sk/mqtt')
client.on('connect', () => {
    client.subscribe('MeriTo/KPI/B4-E6-2D-B0-13-91/Data', {
        qos: 0
    });
})
client.on('message', function(topic, message) {
    ms = message.toString();
});

// insert data to db every 10sec (without this 1sec)
let timerId = setInterval(() => {
    if (ms != 0) {
        $.ajax({
            type: "POST",
            url: 'api/saveDataPowerConsumption',
            data: {
                data: ms
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