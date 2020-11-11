<?php

namespace App\Contracts;

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

interface ResourceHandler
{
  public function index(ServerRequestInterface $request): Response;

  public function show(ServerRequestInterface $request): Response;

  public function store(ServerRequestInterface $request): Response;

  public function update(ServerRequestInterface $request): Response;

  public function delete(ServerRequestInterface $request): Response;
}