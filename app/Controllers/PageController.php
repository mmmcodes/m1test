<?php

namespace App\Controllers;

use App\Response;

class PageController
{
  public function index()
  {
    Response::view('index');
  }
}
