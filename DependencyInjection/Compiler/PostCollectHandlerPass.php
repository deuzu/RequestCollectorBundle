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
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $postCollectHandlerCollectionDefinition = $container->getDefinition('deuzu.request_collector.post_collect_handler_collection');
        $requestCollectorParams                 = $container->getParameter('deuzu_request_collector');
        $collectors                             = array_keys($requestCollectorParams['collectors']);

        foreach ($container->findTaggedServiceIds('post_collect_handler') as $serviceId => $tags) {
            if (!isset($tags[0]) || !isset($tags[0]['alias']) || empty($tags[0]['alias'])) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'The alias for the service %s must be defined. It must have the name of an existing collector : %s.',
                        $serviceId,
                        implode(', ', $collectors)
                    )
                );
            }

            $postCollectHandlerName = $tags[0]['alias'];

            if (!in_array($postCollectHandlerName, $collectors)) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'The collector %s defined as alias of your service %s cannot be found. Configured collectors are : %s.',
                        $postCollectHandlerName,
                        $serviceId,
                        implode(', ', $collectors)
                    )
                );
            }

            $postCollectHandlerCollectionDefinition->addMethodCall(
                'add',
                [new Reference($serviceId), $postCollectHandlerName]
            );
        }
    }
}
