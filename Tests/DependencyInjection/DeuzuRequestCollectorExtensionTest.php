<?php

namespace Deuzu\RequestCollectorBundle\Test\DependencyInjection;

use Deuzu\RequestCollectorBundle\DependencyInjection\DeuzuRequestCollectorExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

/**
 * Class DeuzuRequestCollectorExtensionTest.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class DeuzuRequestCollectorExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @test
     */
    public function itShouldLoadWithoutConfiguration()
    {
        $this->load();

        $this->assertContainerBuilderHasParameter('deuzu_request_collector');
        $this->assertContainerBuilderNotHasService('deuzu.request_collector.collector.logger');
        $this->assertContainerBuilderNotHasService('deuzu.request_collector.collector.persister');
        $this->assertContainerBuilderNotHasService('deuzu.request_collector.collector.mailer');
    }

    /**
     * @test
     */
    public function itShouldLoadWithASingleLoggerCollector()
    {
        $configuration = [
            'collectors' => [
                'test_collector' => [
                    'route_path' => '/test/collect',
                    'logger' => [
                        'enabled' => true,
                        'file' => 'test.log',
                    ],
                ],
            ],
        ];

        $this->load($configuration);

        $this->assertContainerBuilderHasParameter('deuzu_request_collector');
        $this->assertContainerBuilderHasService('deuzu.request_collector.collector.logger');
        $this->assertContainerBuilderNotHasService('deuzu.request_collector.collector.persister');
        $this->assertContainerBuilderNotHasService('deuzu.request_collector.collector.mailer');
    }

    /**
     * @test
     */
    public function itShouldLoadWithMultipleCollector()
    {
        $configuration = [
            'collectors' => [
                'test_collector' => [
                    'route_path' => '/test/collect',
                    'logger' => [
                        'enabled' => true,
                        'file' => 'test.log',
                    ],
                ],
                'test_collector_2' => [
                    'route_path' => '/test-2/collect',
                    'logger' => [
                        'enabled' => true,
                        'file' => 'test.log',
                    ],
                    'persister' => [
                        'enabled' => true,
                    ],
                    'mailer' => [
                        'enabled' => true,
                        'email' => 'test@deuzu.com',
                    ],
                ],
            ],
        ];

        $this->load($configuration);

        $this->assertContainerBuilderHasParameter('deuzu_request_collector');
        $this->assertContainerBuilderHasService('deuzu.request_collector.collector.logger');
        $this->assertContainerBuilderHasService('deuzu.request_collector.collector.persister');
        $this->assertContainerBuilderHasService('deuzu.request_collector.collector.mailer');
    }

    // TODO handle error cases (ie mailer enabled with no email defined)

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions()
    {
        return [
            new DeuzuRequestCollectorExtension(),
        ];
    }
}
