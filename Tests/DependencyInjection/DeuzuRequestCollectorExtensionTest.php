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
    public function itShouldLoadWithFullConfiguration()
    {
        $configuration = [
            'assets' => [
                'bootstrap3_css' => true,
                'bootstrap3_js' => true,
                'jquery' => true,
            ],
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

    /**
     * @test
     */
    public function itShouldLoadWithoutLogFile()
    {
        $configuration = [
            'collectors' => [
                'test_collector' => [
                    'route_path' => '/test/collect',
                    'logger' => [
                        'enabled' => true,
                    ],
                ],
            ],
        ];

        $this->load($configuration);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function itShouldNotLoadWithoutEmail()
    {
        $configuration = [
            'collectors' => [
                'test_collector' => [
                    'route_path' => '/test/collect',
                    'mailer' => [
                        'enabled' => true,
                    ],
                ],
            ],
        ];

        $this->load($configuration);
    }

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
