<?php

require __DIR__ . "./../vendor/autoload.php";

use App\Router;
use React\Http\Server;
use React\EventLoop\Factory;
use Symfony\Component\Yaml\Yaml;
use React\Socket\Server as SocketServer;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Server Configs
 */
$config = Yaml::parseFile(__DIR__ . "/../config/app.yaml") ?? [];

/**
 * React Loop
 */
$loop = Factory::create();

/**
 * The Router
 */
$router = new Router($loop, $config);

/**
 * Register Routes from OpenAPI Spec
 */
$apispec = Yaml::parseFile(__DIR__ . "/../config/openapi-spec.yaml");

foreach($apispec["paths"] as $route => $routeConfig)
{
  foreach($routeConfig as $method => $methodConfig)
  {
    $router->register($route, $methodConfig["x-micro-handler"]);
  }
}

/**
 * Create the Server Instance
 */
$server = new Server($loop,
  /**
   * Logger Middelware
   */
  function(ServerRequestInterface $request, callable $next)
  {
    echo $request->getServerParams()["REMOTE_ADDR"]." "
       ."[".date("d/M/Y:H:i:s P"). "] "
       .$request->getMethod()." "
       .$request->getUri()->getPath()
       ."\n";

    return $next($request);
  },

  /**
   * Default Request Handler
   * We'll use `$router` which holds our routes to handle requests
   */
  function(ServerRequestInterface $request) use ($router)
  {
    return $router->handle($request);
  }
);

$socket = new SocketServer(8000, $loop);

$server->listen($socket);

echo "Server running at http://127.0.0.1:8000\n";

$loop->run();
