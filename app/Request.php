<?php

namespace App;

use App\Contracts\RequestInterface;

class Request implements RequestInterface
{
  protected array $get;
  protected array $post;
  protected string $path;
  protected array $segments;
  protected array $params;

  public function __construct()
  {
    $this->get = $_GET;
    $this->post = $_POST;
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
    $this->path = str_ends_with($path, '/') && strlen($path) > 1 ? substr($path, 0, -1) : $path;
    $this->segments = explode('/', $this->path);
  }

  public function get($key = false): array
  {
    if ($key && isset($this->params[$key])) {
      return $this->params[$key];
    }
    return $this->get;
  }

  public function post($key = false): array
  {
    if ($key && isset($this->post[$key])) {
      return $this->post[$key];
    }
    return$this->post;
  }

  public function method(): string
  {
    $method = $_SERVER['REQUEST_METHOD'];
    if ($_SERVER['REQUEST_METHOD'] == 'HEAD') {
      ob_start();
      $method = 'GET';
    }elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $headers = $this->getHeaders();
      if (isset($headers['X-HTTP-Method-Override']) && in_array($headers['X-HTTP-Method-Override'], array('PUT', 'DELETE', 'PATCH'))) {
        $method = $headers['X-HTTP-Method-Override'];
      }
    }
    return $method;
  }

  public function path(): string
  {
    return $this->path;
  }

  public function segments(): array
  {
    return $this->segments;
  }

  public function params(): array
  {
    return $this->params;
  }

  public function setParams(array $params)
  {
    $this->params = $params;
  }

  private function getHeaders(): array|bool
  {
    $headers = getallheaders() ?? [];
    if ($headers !== false) {
      return $headers;
    }

    foreach ($_SERVER as $name => $value) {
      if (str_starts_with($name, 'HTTP_') || $name == 'CONTENT_TYPE' || $name == 'CONTENT_LENGTH') {
        $headers[str_replace(array(' ', 'Http'), array('-', 'HTTP'), ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
      }
    }
    return $headers;
  }
}
