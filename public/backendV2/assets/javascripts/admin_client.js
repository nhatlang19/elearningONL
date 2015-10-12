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
    checkJson(response);
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

function checkJson(res) {
    console.log(res);
    
    if(res.action=='registred'){
        $('#status').html('<span class="label label-success">Registred</span>');
        $('#chat_button').removeAttr('disabled');
        $('#text_message').removeAttr('disabled');
        $('#chat-head').html('<b>User-'+res.user_id+'</b> ('+res.users_online+' Users Online)');
        user_id = res.user_id;
        
    }else if(res.action=='add_list'){
        if(res.user_id==user_id){
            $('#text_message').val('');
        }
        var new_entry = '<li><b>User-'+res.user_id+'&nbsp;&nbsp;</b>&nbsp;&nbsp;<span style="color: #DDD;width: 300px">'+res.date_time+' &nbsp;:&nbsp;</span>'+res.chat_text+'</li>'
        $("#chat_text_list").append(new_entry);
        $("#chat_text_list").animate({ scrollTop: 50000 }, "slow");
    }
}

function register_user(){
    payload = new Object();
    payload.action = 'register';
    payload.userinfo = 'admin';
    socket.send(JSON.stringify(payload));
}

