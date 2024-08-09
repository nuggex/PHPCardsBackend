<?php

require_once dirname(__FILE__, 2) . '/autoloader.php';

$server = new OpenSwoole\Websocket\Server("127.0.0.1", 9502);

$players = [];

$server->on('open', function($server, $req) {
    global $players;
    echo "connection open: {$req->fd}\n";
    foreach ($server->connections as $fd){
        $connectionInfo = $server->getClientInfo($fd);
        echo "FD: $fd, IP: {$connectionInfo['remote_ip']}, Port: {$connectionInfo['remote_port']}\n";
    }
});

$server->on('message', function($server, $frame) {
    echo "received message: {$frame->data}\n";
    $data = json_decode($frame->data);

    if ($data->msg === "START"){
        $res = [
            "type" => "INIT_GAME", 
            "gameType" => "PASKAHOUSU", 
            "players" => iterator_count($server->connections)];
        $server->push($frame->fd, json_encode($res));
  } 
});

$server->on('close', function($server, $fd) {
    echo "connection close: {$fd}\n";
});

$server->start();
echo "started";
