<?php

namespace App\Contracts;

interface RouterInterface
{
  public function processRequest($container);
}