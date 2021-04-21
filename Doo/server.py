import vertx

server = vertx.create_http_server()

@server.request_handler
def request_handler(req):
    req.response.end("Hello Python World!")
server.listen(80)