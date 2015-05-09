<?php

namespace Deuzu\RequestCollectorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class PostCollectHandlerPass
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class PostCollectHandlerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $postCollectHandlerCollectionDefinition = $container->getDefinition('deuzu.request_collector.post_collect_handler_collection');

        foreach ($container->findTaggedServiceIds('post_collect_handler') as $serviceId => $tags) {
            $postCollectHandlerName = null;

            if (isset($tags[0]) && isset($tags[0]['alias'])) {
                $postCollectHandlerName = $tags[0]['alias'];
            }

            $postCollectHandlerCollectionDefinition->addMethodCall(
                'add',
                [new Reference($serviceId), $postCollectHandlerName]
            );
        }
    }
}
