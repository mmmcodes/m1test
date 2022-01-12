<?php

namespace App\Contracts;

interface ResponseInterface
{
  public static function view($template, $variables);

  public static function json($data);
}