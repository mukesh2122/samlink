<?php

require './protected/config/common.conf.php';
require './protected/config/routes.conf.php';
require $config['BASE_PATH'].'Doo.php';
require $config['BASE_PATH'].'app/DooConfig.php';
require $config['BASE_PATH'].'app/DooWebApp.php';
require $config['BASE_PATH'].'uri/DooUriRouter.php';
require $config['BASE_PATH']."controller/DooController.php";


// =========== Configure server ==========

$serverConf = Vertx::config();
$port = $serverConf['port'];
$ip = $serverConf['ip'];

if(empty($port)){
    $port = 9090;
}

if(empty($ip)){
    $ip = '127.0.0.1';
}

$config['SERVER_ID'] = 'proxy';

$server = Vertx::createHttpServer();
$server->acceptBacklog(100000);

set_time_limit(0);
$c = new DooConfig();
$c->set($config);

//autoload classes
spl_autoload_register(function($class) use ($c){
    if(class_exists($class,false)===false){
        Doo::autoload($class, $c);
    }
});

// =========== deploy http proxy server ===========
Vertx::logger()->info("Proxy server deployed at port " . $port);
Vertx::logger()->info("Server ID " . $config['SERVER_ID']);

$server->setCompressionSupported(true);

$server->requestHandler(function($request) use ($config, $route) {

    $conf = new DooConfig();
    $conf->set($config);

    $app = new DooWebApp();
    $app->proxy = 'myapp.web';
//    $app->proxy = [
//        '^/admin/.?' => 'myapp.admin',
//        '^/api/user' => 'myapp.api.user',
//        '^/api/email' => 'myapp.api.email',
//        '_others'  => 'myapp.frontend'
//    ];

    //server handle request 60 sec timeout
    if($request->uri != '/favicon.ico'){
        $timerId = Vertx::setTimer(60*1000, function() use ($app){
            $app->logDebug('HTTP TIMEOUT END');
            $app->statusCode = 408;
            $app->end();
        });
    }

    //hook function that would be executed when the request is ended
    $app->endCallback = function($app) use ($timerId){
        $app = null;

        if(is_int($timerId)){
            Vertx::cancelTimer($timerId);
        }
    };

    $app->exec($conf, $route, $request);

})->listen($port, $ip);
