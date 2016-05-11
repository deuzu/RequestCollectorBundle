<?php

namespace Deuzu\RequestCollectorBundle\Tests\DependencyInjection\Compiler;

use Deuzu\RequestCollectorBundle\DependencyInjection\Compiler\PostCollectHandlerPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class PostCollectHandlerPassTest.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class PostCollectHandlerPassTest extends AbstractCompilerPassTestCase
{
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

    /**
     * @test
     */
    public function itShouldPassWithConfigurationAndNoPostCollectHandler()
    {
        $taggedServiceAlias = 'test_collector';
        $collectingService = new Definition();
        $this->setDefinition('deuzu.request_collector.post_collect_handler_collection', $collectingService);
        $this->setParameter('deuzu_request_collector', ['collectors' => [$taggedServiceAlias => ['route_path' => '/test/collect']]]);

        $this->compile();
        $this->assertTrue(true);
    }

    /**
     * @test
     * @expectedException \LogicException
     * @expectedExceptionMessageRegExp /No collectors found(.*)?/
     */
    public function itShouldThrowAnExceptionIfPostCollectHandlerWithNoConfiguration()
    {
        $taggedServiceAlias = 'test_collector';
        $collectingService = new Definition();
        $this->setDefinition('deuzu.request_collector.post_collect_handler_collection', $collectingService);

        $collectedService = new Definition();
        $collectedService->addTag('request_collector.post_collect_handler', ['alias' => $taggedServiceAlias]);
        $this->setDefinition('collected_service', $collectedService);

        $this->compile();
    }

    /**
     * @test
     * @expectedException \LogicException
     * @expectedExceptionMessageRegExp /The collector different_alias defined(.*)?/
     */
    public function itShouldThrowAnExceptionIfPostCollectHandlerAsNoAssociatedCollector()
    {
        $taggedServiceAlias = 'test_collector';
        $collectingService = new Definition();
        $this->setDefinition('deuzu.request_collector.post_collect_handler_collection', $collectingService);
        $this->setParameter('deuzu_request_collector', ['collectors' => [$taggedServiceAlias => ['route_path' => '/test/collect']]]);

        $collectedService = new Definition();
        $collectedService->addTag('request_collector.post_collect_handler', ['alias' => 'different_alias']);
        $this->setDefinition('collected_service', $collectedService);

        $this->compile();
    }

    /**
     * @test
     * @expectedException \LogicException
     * @expectedExceptionMessageRegExp /The alias for the service collected_service(.*)?/
     */
    public function itShouldThrowAnExceptionIfPostCollectHandlerAsNoAlias()
    {
        $taggedServiceAlias = 'test_collector';
        $collectingService = new Definition();
        $this->setDefinition('deuzu.request_collector.post_collect_handler_collection', $collectingService);
        $this->setParameter('deuzu_request_collector', ['collectors' => [$taggedServiceAlias => ['route_path' => '/test/collect']]]);

        $collectedService = new Definition();
        $collectedService->addTag('request_collector.post_collect_handler');
        $this->setDefinition('collected_service', $collectedService);

        $this->compile();
    }

    /**
     * {@inheritdoc}
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new PostCollectHandlerPass());
    }
}
