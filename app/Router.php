<?php

namespace App;

use App\Traits\ReactableConfigurable;
use App\Contracts\Router as RouterContract;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Main Router Object
 */
class Router implements RouterContract {

  use ReactableConfigurable;

  /**
   * Route Bag
   */
  protected $routes = [];

  /**
   * Map HTTP Method to ResourceHandler's Method
   */
  protected $methodMap = [
    "SHOW"    => "show",
    "GET"     => "index",
    "POST"    => "store",
    "PUT"     => "update",
    "DELETE"  => "destroy",
  ];

  /**
   * Route Register
   * 
   * This method registers the Routes. It is
   * inteded to be used by `bootstrap` process
   * registering the routes defined in `config/openapi-spec.yaml`
   * 
   * Spec must provide `x-micro-handler` attribute containing
   * the Handler Class as value
   */
  public function register($uri, $handler)
  {
    $this->routes[$uri] = new $handler($this->loop, $this->config);
  }

  /**
   * Request Handler
   * 
   * This method is called by React Handler. This method
   * forwards `$request` to registered route.
   */
  public function handle(ServerRequestInterface $request)
  {
    if($handler = $this->getHandler($request->getUri()->getPath())) {
      
      $method = $this->determineMethod($request);

      return $handler->$method($request);
    }
  }

  public function determineMethod(ServerRequestInterface $request)
  {
    /**
     * We are strictly following /{collection}/{item} pattern.
     * Even URI Segment means we're accessting COLLECTION
     */
    if(
      count(explode("/", $request->getUri()->getPath())) % 2 == 1 &&
      strtoupper($request->getMethod()) == "GET"
    ) {
      return $this->methodMap["SHOW"];
    }

    return $this->methodMap[strtoupper($request->getMethod())];
  }

  protected function getHandler($uri)
  {
    if(array_key_exists($uri, $this->routes)) {
      return $this->routes[$uri];
    }
  }
}