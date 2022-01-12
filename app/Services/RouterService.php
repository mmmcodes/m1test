<?php
namespace App\Services;

use App\Contracts\RequestInterface;
use App\Contracts\RouterInterface;

class RouterService implements RouterInterface
{
  public RequestInterface $request;
  private array $routes;

  const CALLABLES_NAMESPACE = 'App\Controllers\\';

  public function __construct(RequestInterface $request)
  {
    $this->request = $request;
    $this->routes = require 'config/routes.php';
  }

  public function processRequest($container)
  {
    $route = $this->getRoute($this->request->path());

    if (!$route) {
      $this->notFound();
    }

    $call = explode('@', $route['call']);
    $callingClass = self::CALLABLES_NAMESPACE . $call[0];
    $callingMethod = $call[1] ?? 'index';
    $container->call($callingClass, $callingMethod);
  }

  public function getRoute($path): array|bool
  {
    $matchedRoute = $this->matchSimple($path) ?? $this->matchComplex($path);

    if ($matchedRoute) {
      $matchedRoute['path'] = $path;

      if (isset($matchedRoute['params'])){
        $this->setRequestGetParams($matchedRoute);
      }
    }

    return $matchedRoute;
  }

  public function notFound()
  {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit;
  }

  private function matchSimple($path): bool|array
  {
    if (array_key_exists($path, $this->routes)) {
      return $this->routes[$path];
    }
    return false;
  }

  private function matchComplex($segments): bool|array
  {
    $routes = $this->getSameMethodDynamicRoutes($this->request->method(), $this->routes);

    foreach ($routes as $url => $route) {
      $routeSegments = $this->getRouteSegments($url, $route['params']);

      if ($this->compareSegments($segments, $routeSegments)) {
         return $this->routes[$url];
      }
    }

    return false;
  }

  private function getSameMethodDynamicRoutes(string $method, array $routes): array
  {
    return array_filter($routes, function ($value) use ($method) {
      return is_array($value)
          && array_key_exists('params', $value)
          && array_key_exists('method', $value)
          && strtoupper($value['method']) === strtoupper($method);
    });
  }

  private function getRouteSegments($routeKey, $params): array
  {
    $flatSegments = explode('/', $routeKey);
    $segments = [];
    $requestGetParams = [];

    foreach ($flatSegments as $segment) {
      $segmentParameter = $this->findRouteSegmentParam($segment, $params);

      if ($segmentParameter) {
        $paramKey = key($segmentParameter);
        $paramRule = reset($segmentParameter);
        $requestGetParams[$paramKey] = $segment;
      }

      $segments[] = [
          'path' => $segment,
          'dynamic' => (bool)$segmentParameter,
          'paramKey' => $paramKey ?? null,
          'paramRule' => $paramRule ??  null
      ];
    }

    if (!empty($requestGetParams)) {
      $this->setRequestGetParams($requestGetParams);
    }

    return $segments;
  }

  private function findRouteSegmentParam($segment, $params): array|bool
  {
    $matches = [];
    $paramKey = null;
    preg_match('/{([a-zZ-a]+)}/', $segment, $matches);

    if (count($matches) < 2) {
      return false;
    }

    $paramKey = $matches[1];

    if (!array_key_exists($paramKey, $params)) {
      return false;
    }

    return [$paramKey => $params[$paramKey]];
  }

  private function compareSegments(array $requestSegments, array $routeSegments): array|bool
  {
    if (count($requestSegments) !== count($routeSegments)) {
      return false;
    }

    foreach ($requestSegments as $key => $requestSegment) {
      $routeSegment = $routeSegments[$key];
      if ($requestSegment !== $routeSegment['path'] && !$this->validateSegment($requestSegment, $routeSegment['rule'])) {
        return false;
      }
    }

    return true;
  }

  private function validateSegment(string $segment, string $rule): bool
  {
    $matches = [];
    preg_match($rule, $segment, $matches);

    return !empty($matches);
  }

  private function setRequestGetParams($params)
  {
    $this->request->setParams($params);
  }

}
