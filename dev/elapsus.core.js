/* build socket connections */
const https = require('https');
const fs = require('fs');
const options = {
    key: fs.readFileSync('/etc/letsencrypt/live/elapsus.nl/privkey.pem'),
    cert: fs.readFileSync('/etc/letsencrypt/live/elapsus.nl/cert.pem')
};
var server = https.createServer(options);
var io = require('socket.io')(server);
var mysql = require('mysql');
var connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'Dv11020909',
    database: 'proxium'
});

console.log('online');
connection.connect();
io.on('connection', function (socket) {
    console.log('user connection established');
    socket.on('disconnect', function () {
        console.log('user connection closed');
    });
    /* test unit */
    socket.on('messages', function (data) {

        connection.query(' INSERT INTO `contact_lib` SET ?', {
            name: data.nameSender,
            email: data.emailSender,
            message: data.posted
        }, function (err, result) {
            if (err) throw err;
            console.log(result.insertId);
        });
        socket.emit('received', {recmessage: data.posted, recuser: data.nameSender, recsender: data.emailSender});
    });
});
server.listen(1916);
