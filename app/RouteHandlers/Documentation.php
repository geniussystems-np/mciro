<?php

namespace App\RouteHandlers;

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

class Documentation extends ResourceHandler
{
  function index(ServerRequestInterface $request): Response
  {
    return 
      (new Response(200, [
        "Content-Type" => "application/json",
        ],
        json_encode([
          "content" => "This is sample Handler. It was originally created for Documentation purpose."
        ]))
      );
  }
}
