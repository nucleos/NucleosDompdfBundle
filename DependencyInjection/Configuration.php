<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\DompdfBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('core23_dompdf')->children();

        $rootNode
            ->scalarNode('webDir')
                ->defaultValue('%kernel.root_dir%/../web')
                ->info('webDir is deprecated and will be removed with 2.0.')
            ->end()
            ->arrayNode('defaults')
                ->useAttributeAsKey('name')
                ->prototype('scalar')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
