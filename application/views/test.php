<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
    <head>
        <link rel="stylesheet" href="./css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/todc-bootstrap.min.css">
        <title>InstantChat : An Implementation of PHP Websockets Library</title>
    </head>
    <body>
        
        <nav class="navbar navbar-toolbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".bs-example-toolbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="http://www.techzonemind.com/php-websocket-library-two-way-real-time-communication/" class="navbar-brand dropdown-toggle" data-toggle="dropdown">PHP Websocket Library - Two way real time communication</a>
                </div>
                <div class="collapse navbar-collapse bs-example-toolbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="#">View Article</a></li>
                        <li class="active"><a href="#">Demo</a></li>
                        <li><a href="#">Ask A Question</a></li>
                    </ul>
                    <div class="navbar-right">
                        <a href="http://www.techzonemind.com/poojyam-realtime-multiplayer-game-using-websockets/" class="navbar-brand dropdown-toggle" data-toggle="dropdown">Poojyam.in : Realtime Multiplayer Game Using Websockets &nbsp;&nbsp; >></a>
                    </div>
                </div>
            </div>
        </nav>
        
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="page-header">
                        <h1>InstantChat<small>&nbsp;&nbsp;An Implementation of PHP Websockets Library</small></h1>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <span id="chat-head">Instant Chat</span>
                            <span id="status" style="float:right">
                                <span class="label label-info">Info</span>
                            </span>
                        </div>
                        <div class="panel-body" style="min-height:250px">
                            <ul style="padding: 0px;list-style: none;max-height: 225px;overflow-x: hidden;overflow-y: auto;" id="chat_text_list">
                                <li>
                                    <span style="color: #DDD;width: 300px">10th Jan 10:00 &nbsp;:&nbsp;</span> This is the first test message
                                </li>
                            </ul>
                        </div>
                        <div class="panel-footer">
                            <div class="input-group">
                                <input type="text" class="form-control" id="text_message">
                                <span class="input-group-btn">
                                  <button class="btn btn-primary" type="button"  id="chat_button" >SEND CHAT REQUEST</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <nav class="navbar navbar-toolbar navbar-default navbar-fixed-bottom" role="navigation">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="bs-example-navbar-toolbar-collapse-7">
                    <ul class="nav navbar-nav" style="width: 100%">
                        <li class="active"><a class="navbar-brand" href="http://www.techzonemind.com/" style="color: #DD4B39;background-color: white">TZM Labs</a></li>
                        <li><a href="http://www.techzonemind.com/category/articles/">Article</a></li>
                        <li><a href="http://www.techzonemind.com/category/hall-of-frame/">Hall Of frame</a></li>
                        <li><a href="http://www.techzonemind.com/category/libraries/">Libraries</a></li>
                        <li><a href="http://www.techzonemind.com/category/tutorials/">Tutorials</a></li>
                        <li><a href="http://www.techzonemind.com/category/tools/">Tools</a></li>
                        <li style="float: right"><a href="">Copyright 2014 TechZoneMind</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        
        
        <script>document.write('<script src="<?php echo JS_PATH; ?>vendor/jquery-1.10.2.min.js"><\/script>')</script>
        <script src="./js/bootstrap.min.js"></script>
        <script>
            var user_id = 0;
            
            $(document).ready(function() {
		
                serverUrl = 'ws://127.0.0.1:8000';
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
                        
                    }else if(res.action=='chat_text'){
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
                    payload.action 		= 'register';
                    socket.send(JSON.stringify(payload));
                }
                
                
                $("#chat_button").click(function(){
                    console.log('Triggred');
                    payload = new Object();
                    payload.action 		= 'chat_text';
                    payload.user_id 	= user_id;
                    payload.chat_text   = $('#text_message').val();
                    socket.send(JSON.stringify(payload));
                });
                
                $("#text_message").on("keypress", function(e) {
                    if (e.keyCode == 13){
                        $("#chat_button").click();
                    }
                });
                
            });
        </script>
    </body>
</html>