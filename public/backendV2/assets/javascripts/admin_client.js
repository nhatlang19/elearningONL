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
	var table = $('#datatable-editable').DataTable();
    if(res.action=='registred'){
    	console.log('Hello');
    } else if(res.action=='addList'){
        if(res.type != 'admin'){
        	var userInfo = $.parseJSON(res.userinfo);
        	var classNameIp = userInfo.ip_address.split('.').join('_');
        	var className = classNameIp + '_' + userInfo.student_id;
        	var listItem = $( 'table#datatable-editable tbody tr.' + className );
        	table.row( listItem ).remove().draw();
        	
        	var findItem = $( 'table#datatable-editable tbody tr.' + classNameIp );
        	var note = '';
        	if(findItem.length != 0) {
        		note = 'Có ' + (findItem.length + 1) + ' học sinh đang đăng nhập IP này';
        	}
        	var rowNode = table.row.add( [
	            userInfo.student_id,
	            userInfo.fullname,
	            userInfo.class_name,
	            userInfo.ip_address,
	            note
	        ] ).draw( false ).node();
        	
        	
        	$( rowNode ).addClass( classNameIp )
        				.addClass( className )
        				.attr("data-cnn", res.connection_id)
	            		.animate({ scrollTop: 50000 }, "slow");
        }
    } else if(res.action == 'removeList') {
    	if(res.type != 'admin'){
	    	var userInfo = $.parseJSON(res.userinfo);
	    	var className = userInfo.ip_address.split('.').join('_') + '_' + userInfo.student_id;
	    	var listItem = $( 'table#datatable-editable tbody tr.' + className );
        	table.row( listItem ).remove().draw();
    	}
    } else if(res.action == 'start') {
    	console.log('start Exam');
    	console.log('TODO: nothing');
    }
}

function register_user(){
    payload = new Object();
    payload.action = 'register';
    payload.userinfo = USERINFO;
    payload.type = 'admin';
    socket.send(JSON.stringify(payload));
}

$('#startExam').click(function() {
	 payload = new Object();
	 payload.action = 'start';
	 socket.send(JSON.stringify(payload));
});
