<?php

/*
 * This file is part of the ni-ju-san CMS.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\DompdfBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('core23_dompdf')->children();

        $rootNode
            ->arrayNode('config')
                ->defaultValue(array())
                ->useAttributeAsKey('name')
                ->prototype('scalar')->end()
            ->validate()
            ->ifTrue(function ($element) {
                foreach ($element as $key => $value) {
                    if (0 !== stripos($key, 'dompdf_')) {
                        return true;
                    }
                }

                return false;
            })->thenInvalid('The config has invalid dompdf keys. A key should start with "DOMPDF_"')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
