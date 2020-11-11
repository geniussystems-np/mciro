<?php

namespace App\RouteHandlers;

use App\Contracts\ResourceHandler as ResourceHandlerContract;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

class ResourceHandler implements ResourceHandlerContract
{
  public function index(ServerRequestInterface $request): Response
  {
    return $this->notImplemented($request->getMethod(), $request->getUri()->getPath());
  }

  public function show(ServerRequestInterface $request): Response
  {
    return $this->notImplemented($request->getMethod(), $request->getUri()->getPath());
  }

  public function store(ServerRequestInterface $request): Response
  {
    return $this->notImplemented($request->getMethod(), $request->getUri()->getPath());
  }

  public function delete(ServerRequestInterface $request): Response
  {
    return $this->notImplemented($request->getMethod(), $request->getUri()->getPath());
  }

  public function update(ServerRequestInterface $request): Response
  {
    return $this->notImplemented($request->getMethod(), $request->getUri()->getPath());
  }

  protected function notImplemented($method, $uri): Response
  {
    return new Response(501, [], $method . ": " . $uri . " - Not Implemented\n");
  }
}