<?php

namespace Deuzu\RequestCollectorBundle\Collector;

use Deuzu\RequestCollectorBundle\Entity\RequestObject;

interface CollectorInterface
{
    /**
     * @param RequestObject $requestObject
     * @param Rarray        $parameters
     */
    public function collect(RequestObject $requestObject, array $parameters = []);
}
