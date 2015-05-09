<?php

namespace Deuzu\RequestCollectorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Deuzu\RequestCollectorBundle\DependencyInjection\Compiler\PostCollectHandlerPass;

/**
 * Class DeuzuRequestCollectorBundle
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class DeuzuRequestCollectorBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new PostCollectHandlerPass());
    }
}
