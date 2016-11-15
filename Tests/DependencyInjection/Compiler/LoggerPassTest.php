<?php

namespace Deuzu\RequestCollectorBundle\Tests\DependencyInjection\Compiler;

use Deuzu\RequestCollectorBundle\DependencyInjection\Compiler\LoggerPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class LoggerPassTest.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class LoggerPassTest extends AbstractCompilerPassTestCase
{
    /**
     * @test
     */
    public function itShouldAddLoggerToContainer()
    {
        $loggerName = 'test';
        $collectors = [
            'collectors' => [
                $loggerName => [
                    'route_path' => '/test/collect',
                    'logger' => [
                        'enabled' => true,
                        'channel' => $loggerName,
                    ],
                ],
            ],
        ];
        $loggerContainerDefinition = new Definition();
        $this->setDefinition('deuzu.request_collector.logger.container', $loggerContainerDefinition);
        $this->setParameter('deuzu_request_collector', $collectors);

        $loggerDefinition = new Definition();
        $monologLoggerServiceId = 'monolog.logger.'.$loggerName;
        $this->setDefinition($monologLoggerServiceId, $loggerDefinition);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'deuzu.request_collector.logger.container',
            'add',
            [new Reference($monologLoggerServiceId), $loggerName]
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new LoggerPass());
    }
}
