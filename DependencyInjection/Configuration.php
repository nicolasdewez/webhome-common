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
                ->scalarNode('api_client')->defaultTrue()->end()
                ->scalarNode('validator')->defaultTrue()->end()
            ->end();

        return $treeBuilder;
    }
}
