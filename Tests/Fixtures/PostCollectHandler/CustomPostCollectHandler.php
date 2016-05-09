<?php

namespace Deuzu\RequestCollectorBundle\Tests\Fixtures\PostCollectHandler;

use Deuzu\RequestCollectorBundle\Entity\RequestObject;
use Deuzu\RequestCollectorBundle\PostCollectHandler\PostCollectHandlerInterface;

/**
 * Class CustomPostCollecthandler.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class CustomPostCollecthandler implements PostCollectHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle(RequestObject $requestObject)
    {
        return null;
    }
}
