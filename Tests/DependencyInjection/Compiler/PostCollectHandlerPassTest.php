<?php

namespace Deuzu\RequestCollectorBundle\Tests\DependencyInjection\Compiler;

use Deuzu\RequestCollectorBundle\DependencyInjection\Compiler\PostCollectHandlerPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class PostCollectHandlerPassTest extends AbstractCompilerPassTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new PostCollectHandlerPass());
    }

    /**
     * @test
     */
    public function itShouldAddTaggedServiceToCollection()
    {
        $taggedServiceAlias = 'test_collector';
        $collectingService = new Definition();
        $this->setDefinition('deuzu.request_collector.post_collect_handler_collection', $collectingService);
        $this->setParameter('deuzu_request_collector', ['collectors' => [$taggedServiceAlias => ['route_path' => '/test/collect']]]);

        $collectedService = new Definition();
        $collectedService->addTag('request_collector.post_collect_handler', ['alias' => $taggedServiceAlias]);
        $this->setDefinition('collected_service', $collectedService);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'deuzu.request_collector.post_collect_handler_collection',
            'add',
            [new Reference('collected_service'), $taggedServiceAlias]
        );
    }

    // TODO handle exception cases
}
