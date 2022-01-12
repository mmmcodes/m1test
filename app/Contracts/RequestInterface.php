<?php

namespace App\Contracts;

interface RequestInterface
{
  public function get(): array;

  public function post(): array;

  public function method(): string;

  public function path(): string;

  public function segments(): array;
}