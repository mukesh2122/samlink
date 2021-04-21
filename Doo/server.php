<?php

Vertx::createHttpServer()->requestHandler(function($request) {
  $request->response->putHeader('Content-Type', 'text/plain');
  $request->response->end('Hello Php world');
})->listen(80);
?>