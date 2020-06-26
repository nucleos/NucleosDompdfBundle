<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\DompdfBundle\Tests\DependencyInjection;

use Nucleos\DompdfBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

final class ConfigurationTest extends TestCase
{
    public function testDefaultOptions(): void
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(new Configuration(), [[
        ]]);

        $expected = [
            'defaults' => [
                'fontCache' => '%kernel.cache_dir%',
            ],
        ];

        static::assertSame($expected, $config);
    }

    public function testOptions(): void
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(new Configuration(), [[
            'defaults' => [
                'foo' => 'bar',
                'bar' => 'baz',
            ],
        ]]);

        $expected = [
            'defaults' => [
                'foo' => 'bar',
                'bar' => 'baz',
            ],
        ];

        static::assertSame($expected, $config);
    }
}
