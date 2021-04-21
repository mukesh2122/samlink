(ns example.http.server
  (:require [vertx.http :as http]))

(defn req-handler [req]
  (println "Got request:" (.uri req))
  (println "Headers are:" (pr-str (http/headers req)))
  (-> (http/server-response req)
      (http/add-header "Content-Type" "text/html; charset=UTF-8")
      (http/end "<html><body><h1>Hello clojure world, from vert.x!</h1></body></html>")))

(-> (http/server)
    (http/on-request req-handler)
    (http/listen 80 "localhost"))

(println "Starting Http server on localhost:80")