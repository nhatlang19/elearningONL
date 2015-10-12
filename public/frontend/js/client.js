var serverUrl = 'ws://127.0.0.1:8000';
if (window.MozWebSocket) {
    socket = new MozWebSocket(serverUrl);
} else if (window.WebSocket) {
    socket = new WebSocket(serverUrl);
}
socket.binaryType = 'blob';
socket.onopen = function(msg) {
    $('#status').html('<span class="label label-info">Registering</span>');
    register_user();
    return true;
};

socket.onmessage = function(msg) {
    var response;
    response = JSON.parse(msg.data);
    return true;
};
socket.onclose = function(msg) {
    $('#status').html('<span class="label label-danger">Disconnected</span>');
    setTimeout(function(){
            $('#status').html('<span class="label label-warning">Reconnecting</span>');
        }
    ,5000);
    setTimeout(function(){
            location.reload();
        }
    ,10000);
    return true;
};

function register_user(){
    payload = new Object();
    payload.action = 'register';
    payload.userinfo = USERINFO;
    socket.send(JSON.stringify(payload));
}

