vertx.createHttpServer.requestHandler { req: HttpServerRequest =>
  req.response.end("Hello scala world!")
}.listen(80)