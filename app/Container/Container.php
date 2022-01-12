<?php

namespace App\Container;

use App\Contracts\ContainerInterface;
use App\Contracts\ResolverContainerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;
use App\Container\Exception\ContainerException;
use App\Container\Exception\NotFoundException;
use App\Container\ParserContainer;
use App\Container\ResolverContainer;

class Container implements ContainerInterface
{

    private array $services = [];

    private ResolverContainerInterface $resolver;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(string $includePath = null)
    {
        $this->resolver = new ResolverContainer();
        new ParserContainer($this->services);
    }

    public final function get(string $id): object
    {
        try {
            return !$this->has($id)
                ? $this->services[$id] = $this->resolver->get($id, $this->services)
                : $this->services[$id];
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            throw $e;
        }
    }

    public final function has(string $id): bool
    {
        return array_key_exists($id, $this->services) && is_object($this->services[$id]);
    }

    public final function call(string $id, string $action, array $arguments = []): mixed
    {
        try {
            $service = $this->get($id);
            $arguments = $this->resolver->resolve(
                (new ReflectionClass($id))->getMethod($action),
                $this->services,
                $arguments
            );
        } catch (ReflectionException $e) {
            throw new NotFoundException('Action "' . $action . '" Not Found');
        }
        return $service->{$action}(...$arguments);
    }

}
