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
    console.log(response);
    return true;
};
socket.onclose = function(msg) {
    $('#status').html('<span class="label label-danger">Disconnected</span>');
    return true;
};

function register_user(){
    payload = new Object();
    payload.action = 'register';
    payload.userinfo = USERINFO;
    socket.send(JSON.stringify(payload));
}


$(window).on('beforeunload', function(){
    socket.close();
});
