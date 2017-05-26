<?php

namespace Deuzu\RequestCollectorBundle\DependencyInjection\Compiler;

use Monolog\Logger;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class LoggerPass.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class LoggerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $containerIsEmpty = !$container->hasDefinition('deuzu.request_collector.logger.container')
            || !$container->hasParameter('deuzu_request_collector');

        if ($containerIsEmpty) {
            return;
        }

        $loggerContainerDefinition = $container->findDefinition('deuzu.request_collector.logger.container');
        $collectors = $container->getParameter('deuzu_request_collector')['collectors'];

        foreach ($collectors as $collectorParams) {
            $loggerParams = $collectorParams['logger'];

            if (!$loggerParams['enabled']) {
                continue;
            }

            $loggerChannel = $loggerParams['channel'];
            $loggerServiceId = sprintf('monolog.logger.%s', $loggerChannel);

            if (!$container->hasDefinition($loggerServiceId)) {
                throw new \LogicException(sprintf('The channel %s is not configured on Monolog', $loggerChannel));
            }

            $loggerContainerDefinition->addMethodCall(
                'add',
                [new Reference($loggerServiceId), $loggerChannel]
            );
        }
    }
}
