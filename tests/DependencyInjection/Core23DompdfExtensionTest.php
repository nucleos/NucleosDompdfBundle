<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\DompdfBundle\Tests\DependencyInjection;

use Core23\DompdfBundle\DependencyInjection\Core23DompdfExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

final class Core23DompdfExtensionTest extends AbstractExtensionTestCase
{
    public function testLoadDefault(): void
    {
        $this->load([
            'defaults' => [
                'foo' => 'bar',
                'bar' => 'baz',
            ],
        ]);

        $this->assertContainerBuilderHasParameter('core23_dompdf.options', [
            'foo' => 'bar',
            'bar' => 'baz',
        ]);
    }

    protected function getContainerExtensions()
    {
        return [
            new Core23DompdfExtension(),
        ];
    }
}
