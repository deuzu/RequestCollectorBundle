<?php

namespace Deuzu\RequestCollectorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

/**
 * Class DeuzuRequestCollectorExtension
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class DeuzuRequestCollectorExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $processor     = new Processor();
        $config        = $processor->processConfiguration($configuration, $configs);
        $container->setParameter('deuzu_request_collector', $config);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        // @moulox
        $logger = false;
        $mailer = false;
        $persister = false;

        foreach ($config['collectors'] as $collectorName => $collector) {
            if ($collector['logger']['enabled']) {
                $logger = true;
            }

            if ($collector['mailer']['enabled']) {
                $mailer = true;
            }

            if ($collector['persister']['enabled']) {
                $persister = true;
            }
        }

        if (!$logger) {
            $container->removeDefinition('deuzu.request_collector.collector.logger');
        }

        if (!$persister) {
            $container->removeDefinition('deuzu.request_collector.collector.persister');
        }

        if (!$mailer) {
            $container->removeDefinition('deuzu.request_collector.collector.mailer');
        }
    }
}
