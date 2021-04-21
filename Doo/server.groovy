vertx.createHttpServer().requestHandler { req ->
    req.response.end "Hello Groovy World!"
}.listen(80)