<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Chat;

    require dirname(__DIR__) . '/vendor/autoload.php';
    require dirname(__DIR__) . "/partials/dbcon.php";

    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new Chat($con)
            )
        ),
        8081
    );

    $server->run();