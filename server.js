// Import net module.
var Net = require('net');
const WebSocket = require('ws');

var tmpWs;

const wss = new WebSocket.Server({ port: 8080 })
wss.on('connection', ws => {
    tmpWs = ws;
    ws.on('message', message => {
        console.log(`Received message => ${message}`)
    });
});

var server = Net.createServer(function(client) {
    client.setEncoding('utf-8');
    client.setTimeout(1000);
    client.on('data', function (data) {
        console.log(data);
        tmpWs.send(data);
    });
    client.on('end', function () {
        server.getConnections(function (err, count) {
            if(!err){
            }else{
                console.error(JSON.stringify(err));
            }
        });
    });
    client.on('timeout', function () {
        console.log('Client request time out. ');
    })
});

server.listen(2160, function () {
    var serverInfo = server.address();
    var serverInfoJson = JSON.stringify(serverInfo);
    console.log('TCP server listen on address : ' + serverInfoJson);
    server.on('close', function () {
        console.log('TCP server socket is closed.');
    });
    server.on('error', function (error) {
        console.error(JSON.stringify(error));
    });
});

//-----------------------------------------------



