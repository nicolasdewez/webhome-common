<?php

namespace Ndewez\WebHome\CommonBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('webhome_common');

        $rootNode
            ->children()
                ->scalarNode('auth')->defaultTrue()->end()
                ->arrayNode('menu')
                    ->children()
                        ->scalarNode('session')->defaultTrue()->end()
                        ->scalarNode('getter')->end()
                        ->scalarNode('builder')->end()
                    ->end()
                ->end()
                ->arrayNode('api_user_connected')
                    ->children()
                        ->scalarNode('session_key')->defaultValue('user')->end()
                        ->arrayNode('access_token_key')
                            ->children()
                                ->scalarNode('header')->defaultValue('access-token')->end()
                                ->scalarNode('get')->defaultValue('access_token')->end()
                            ->end()
                        ->end()
                        ->arrayNode('required_paths')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('optional_paths')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('api_client')->defaultTrue()->end()
                ->scalarNode('validator')->defaultTrue()->end()
            ->end();

        return $treeBuilder;
    }
}
