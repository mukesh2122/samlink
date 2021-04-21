var vertx = require('vertx');

vertx.createHttpServer().requestHandler(function(req) {
  req.response.end("Hello JavaScript World!");
}).listen(80, 'localhost');