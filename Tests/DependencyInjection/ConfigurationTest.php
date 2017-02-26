<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\DompdfBundle\Tests\DependencyInjection;

use Core23\DompdfBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testDefaultOptions()
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(new Configuration(), array(array(
        )));

        $expected = array(
            'webDir'   => '%kernel.root_dir%/../web',
            'defaults' => array(),
        );

        $this->assertSame($expected, $config);
    }

    public function testOptions()
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(new Configuration(), array(array(
            'webDir'   => '%kernel.root_dir%/../customWeb',
            'defaults' => array(
                'foo' => 'bar',
                'bar' => 'baz',
            ),
        )));

        $expected = array(
            'webDir'   => '%kernel.root_dir%/../customWeb',
            'defaults' => array(
                'foo' => 'bar',
                'bar' => 'baz',
            ),
        );

        $this->assertSame($expected, $config);
    }
}
