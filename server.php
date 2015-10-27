<?php
if( ! ini_get('date.timezone') )
{
    date_default_timezone_set('GMT');
}

set_time_limit(0);

include "./application/libraries/socket/Socket.php";
include "./application/libraries/socket/Server.php";
include "./application/libraries/socket/Connection.php";


echo "\033[2J";
echo "\033[0;0f";

class Application
{

    private $connections = array();
    private $portAdmin = 0;
 // Array to save
    public $server;

    public function __construct()
    {
        include "./application/config/socket_config.php";
        $this->server = new Server($config['socket.ipserver'], $config['socket.port'], false);
        $this->server->setMaxClients(100);
        $this->server->setCheckOrigin(false);
        // $this->server->setAllowedOrigin('192.168.1.153');
        $this->server->setMaxConnectionsPerIp(100000);
        $this->server->setMaxRequestsPerMinute(200000);
        $this->server->setHook($this);
        $this->server->run();
    }

    /* Fired when a socket trying to connect */
    public function onConnect($connection_id)
    {
        echo "\nOn connect called : $connection_id";
        return true;
    }

    /* Fired when a socket disconnected */
    public function onDisconnect($connection_id)
    {
        echo "\nOn disconnect called : $connection_id";
        
        if (isset($this->connections[$connection_id])) {
            unset($this->connections[$connection_id]);
        }
        
        // TODO: need to remove or update status of user when disconnect
        //$this->sendDataToConnection($this->portAdmin, 'addList', $data);
    }

    /* Fired when data received */
    public function onDataReceive($connection_id, $data)
    {
        echo "\nData received from $connection_id :";
        
        $data = json_decode($data, true);
        print_r($data['action']);
        
        if (isset($data['action'])) {
            $action = 'action_' . $data['action'];
            if (method_exists($this, $action)) {
                unset($data['action']);
                $this->$action($connection_id, $data);
            } else {
                echo "\n Caution : Action handler '$action' not found!";
            }
        }
    }

    /* Used to send data to particular connection */
    public function sendDataToConnection($connection_id, $action, $data)
    {
        $this->server->sendData($connection_id, $action, $data);
    }
    
    // /// ACTIONS ////
    public function action_register($connection_id, $data = [])
    {
        if(empty($this->connections)) {
            $this->connections[$connection_id] = 1;
        } else {
            $this->connections[$connection_id] = max($this->connections) + 1;
        }
       
        // keep port of admin
        if(isset($data['userinfo']) && $data['userinfo'] == 'admin') {
            $this->portAdmin = $connection_id;
        }
        $data['users_online'] = count($this->connections);
        $data['connection_id'] = $connection_id;
        // store user infor
        $this->sendDataToConnection($this->portAdmin, 'addList', $data);
    }
}

$app = new Application();