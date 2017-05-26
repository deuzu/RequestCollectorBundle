<?php

namespace Deuzu\RequestCollectorBundle;

use Deuzu\RequestCollectorBundle\DependencyInjection\Compiler\LoggerPass;
use Deuzu\RequestCollectorBundle\DependencyInjection\Compiler\PostCollectHandlerPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

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
        $container->addCompilerPass(new LoggerPass());
    }
}
