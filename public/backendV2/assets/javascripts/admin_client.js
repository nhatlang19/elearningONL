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
    return true;
};

$(window).on('beforeunload', function(){
    socket.close();
});

function checkJson(res) {
	console.log(res);
    if(res.action=='registred'){
    	console.log('Hello');
    } else if(res.action=='addList'){
        if(res.userinfo != 'admin'){
        	var userInfo = $.parseJSON(res.userinfo);
        	
        	var className = userInfo.ip_address.split('.').join('_');
        	
        	$('table tbody tr.' + className).remove();
			var new_entry = '';
			new_entry += '<tr class="gradeX ' + className + '">';
			new_entry += '<td>' + userInfo.student_id + '</td>';
			new_entry += '<td>' + userInfo.fullname + '</td>';
			new_entry += '<td>' + userInfo.class_name + '</td>';
			new_entry += '<td>' + userInfo.ip_address + '</td>';
			new_entry += '</tr>';	
	        $("table tbody").append(new_entry);
	        $("table tbody").animate({ scrollTop: 50000 }, "slow");
        }
    }
}

function register_user(){
    payload = new Object();
    payload.action = 'register';
    payload.userinfo = 'admin';
    socket.send(JSON.stringify(payload));
}
