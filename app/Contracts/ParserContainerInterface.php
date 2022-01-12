<?php

namespace App\Contracts;

use Psr\Container\ContainerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use stdClass;

interface ParserContainerInterface extends ContainerInterface
{

    /**
     * @param string $filename
     * @return stdClass
     *
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function parse(array $services): stdClass;

}
