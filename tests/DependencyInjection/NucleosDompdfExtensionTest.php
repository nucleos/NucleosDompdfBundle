<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\DompdfBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Nucleos\DompdfBundle\DependencyInjection\NucleosDompdfExtension;

final class NucleosDompdfExtensionTest extends AbstractExtensionTestCase
{
    public function testLoadDefault(): void
    {
        $this->load([
            'defaults' => [
                'foo' => 'bar',
                'bar' => 'baz',
            ],
        ]);

        $this->assertContainerBuilderHasParameter('nucleos_dompdf.options', [
            'foo' => 'bar',
            'bar' => 'baz',
        ]);
    }

    protected function getContainerExtensions(): array
    {
        return [
            new NucleosDompdfExtension(),
        ];
    }
}
