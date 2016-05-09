<?php

namespace Deuzu\RequestCollectorBundle\PostCollectHandler;

use Deuzu\RequestCollectorBundle\Entity\RequestObject;

/**
 * Interface PostCollectHandlerInterface.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
interface PostCollectHandlerInterface
{
    /**
     * @param RequestObject $requestObject
     *
     * @return Response|null
     */
    public function handle(RequestObject $requestObject);
}
