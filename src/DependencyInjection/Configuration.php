<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\DompdfBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('core23_dompdf');

        // Keep compatibility with symfony/config < 4.2
        if (!method_exists(TreeBuilder::class, 'getRootNode')) {
            $rootNode = $treeBuilder->root('core23_dompdf');
        } else {
            $rootNode = $treeBuilder->getRootNode();
        }
        \assert($rootNode instanceof ArrayNodeDefinition);

        $rootNode
            ->children()
                ->arrayNode('defaults')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                    ->defaultValue([
                        'fontCache' => '%kernel.cache_dir%',
                    ])
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
