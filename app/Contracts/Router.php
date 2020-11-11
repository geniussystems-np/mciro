<?php

namespace App\Contracts;

/**
 * Router Contract
 */
interface Router
{
  public function register($uri, callable $handler);
}