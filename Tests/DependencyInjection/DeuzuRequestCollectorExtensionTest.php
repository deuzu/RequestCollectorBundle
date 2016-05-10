<?php

namespace Deuzu\RequestCollectorBundle\Test\DependencyInjection;

use Deuzu\RequestCollectorBundle\DependencyInjection\DeuzuRequestCollectorExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class DeuzuRequestCollectorExtensionTest extends AbstractExtensionTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions()
    {
        return [
            new DeuzuRequestCollectorExtension()
        ];
    }
    //
    // /**
    //  * {@inheritdoc}
    //  */
    // protected function getMinimalConfiguration()
    // {
    //     return [];
    // }

    /**
     * @test
     */
    public function itShouldLoad()
    {
        $configuration = [
            'deuzu_request_collector' => [
                'collectors' => [
                    'test_collector' => [
                        'logger' => [
                            'enabled' => true,
                            'file' => 'test.log',
                        ]
                    ]
                ]
            ]
        ];

        $this->load($configuration);

        $this->assertContainerBuilderHasParameter('deuzu_request_collector', $configuration['deuzu_request_collector']);
    }
}
