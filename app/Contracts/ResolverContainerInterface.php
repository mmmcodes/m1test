<?php

namespace App\Contracts;

use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionMethod;

interface ResolverContainerInterface extends ContainerInterface
{

    /**
     * @param ReflectionMethod $method
     * @return array
     * @throws NotFoundExceptionInterface
     */
    public function resolve(ReflectionMethod $method): array;

}
