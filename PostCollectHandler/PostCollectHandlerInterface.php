<?php

namespace Deuzu\RequestCollectorBundle\PostCollectHandler;

use Deuzu\RequestCollectorBundle\Entity\RequestObject;
use Symfony\Component\HttpFoundation\Response;

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
