<?php

namespace App\Contracts;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;

interface ContainerInterface extends \Psr\Container\ContainerInterface
{

    /**
     * @param string $id
     * @param string $action
     * @param array $arguments
     * @return mixed
     *
     * @throws NotFoundExceptionInterface.
     * @throws ContainerExceptionInterface
     * @throws Throwable
     */
    public function call(string $id, string $action, array $arguments = []): mixed;

}
