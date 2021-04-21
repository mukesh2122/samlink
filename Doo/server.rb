require "vertx"

Vertx::HttpServer.new.request_handler do |req|
    req.response.end "Hello Ruby World!"
end.listen(80)