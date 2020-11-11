<?php

namespace App\Traits;

use React\EventLoop\LoopInterface;

/**
 * ReactableConfigurable
 * 
 * This trait is intended to be used for
 * any Object requiring ReactEventLoop Access
 */
trait ReactableConfigurable
{
  /**
   * React Loop
   */
  protected $loop;

  /**
   * Configuration Bag
   */
  protected $config;

  /**
   * Create a New Instance
   * 
   * @param $loop     React\EventLoop\LoopInterface;
   * @param $config   Array
   */
  public function __construct(LoopInterface $loop, array $config = [])
  {
    $this->loop    = $loop;
    $this->config  = $config;
  }
}