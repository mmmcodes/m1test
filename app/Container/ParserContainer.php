<?php

namespace App\Container;

use App\Contracts\ParserContainerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use App\Container\Exception\ContainerException;
use App\Container\Exception\NotFoundException;
use stdClass;

class ParserContainer implements ParserContainerInterface
{

    private stdClass $configuration;

    public final function get(string $id)
    {
        if ($this->has($id)) {
            return $this->configuration->parameters->{$id};
        }
        throw new NotFoundException('Container parameter "' . $id . '" Not Found');
    }

    public final function has(string $id): bool
    {
        return property_exists($this->configuration->parameters, $id);
    }

    public final function parse(array $services = []): stdClass
    {
        if (!($configuration = (object)require dirname(__DIR__, 2) . '/config/services.php')
            || !property_exists($configuration, 'parameters')
            || !property_exists($configuration, 'services')) {
            throw new ContainerException('Invalid configuration file');
        }
        $this->configuration = $configuration;
        foreach ($this->configuration->services as $id => $service) {
            $services[$id] = [];
            foreach ($service as $paramName => $paramValue) {
                $services[$id][$paramName] = str_starts_with($paramValue, ':')
                    ? $this->get(substr($paramValue, 1))
                    : $paramValue;
            }
        }

        return $this->configuration;
    }

}
