//var socket = io('https://127.0.0.1');
//var socket = io.connect('https://127.0.0.1:8080', {secure: true});
/*
 $('form').submit(function(){
 socket.emit('chat message', $('#m').val());
 $('#m').val('');
 return false;
 });
 socket.on('chat message', function(msg){
 $('#messages').append($('<li>').text(msg));
 });
 */
/*
var socket = io.connect('https://elapsus.nl:1916');

socket.on('connect', function(){
    $('.f').submit(function(e){
        e.preventDefault();
        var message = $('#message').val();
        var name = $('#name').val();
        var email = $('#email').val();
        socket.emit( 'messages' , { nameSender: name, emailSender: email, posted : message });
        return false;
    });
    socket.on('received', function(data){
        $('ul#received').append('<li class="list-item"><span>Re:' + data.recsender + '</span><br/><span>Na:' + data.recuser + '</span><p>Be:' + data.recmessage + '</p></li>');
    });
    socket.on('event', function(data){});
    socket.on('disconnect', function(){});
});

socket.on('news', function (data) {
    console.log(data);
});
*/