<?php

namespace Deuzu\RequestCollectorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Class Configuration.
 *
 * @author Florian Touya <florian.touya@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('deuzu_request_collector');

        $rootNode
            ->children()
                ->arrayNode('assets')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('bootstrap3_css')->defaultNull()->end()
                        ->scalarNode('bootstrap3_js')->defaultNull()->end()
                        ->scalarNode('jquery')->defaultNull()->end()
                    ->end()
                ->end()
                ->scalarNode('from_email')->defaultValue('example@domain.org')->end()
                ->arrayNode('collectors')
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('route_path')->isRequired()->end()
                            ->scalarNode('items_per_page')->defaultValue('25')->end()
                            ->arrayNode('persister')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->booleanNode('enabled')->defaultFalse()->end()
                                ->end()
                            ->end()
                            ->arrayNode('logger')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->booleanNode('enabled')->defaultFalse()->end()
                                    ->scalarNode('file')->defaultValue('request_collector.log')->end()
                                ->end()
                            ->end()
                            ->arrayNode('mailer')
                                ->beforeNormalization()
                                    ->ifTrue(function ($v) {
                                        return $v['enabled'] && !isset($v['email']);
                                    })
                                    ->thenInvalid('The child node "email" under the node "mail" of your collector must be configured.')
                                ->end()
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->booleanNode('enabled')->defaultFalse()->end()
                                    ->scalarNode('email')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
