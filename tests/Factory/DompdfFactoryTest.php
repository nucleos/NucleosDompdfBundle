<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\DompdfBundle\Tests\Factory;

use Nucleos\DompdfBundle\Factory\DompdfFactory;
use PHPUnit\Framework\TestCase;

final class DompdfFactoryTest extends TestCase
{
    private DompdfFactory $dompdfFactory;

    protected function setUp(): void
    {
        $this->dompdfFactory = new DompdfFactory([
            'dpi' => 100,
        ]);
    }

    public function testCreate(): void
    {
        $dompdf = $this->dompdfFactory->create();

        $options = $dompdf->getOptions();

        self::assertSame(100, $options->getDpi());
    }

    public function testCreateWithOptions(): void
    {
        $dompdf = $this->dompdfFactory->create([
            'dpi'     => 200,
            'tempDir' => 'foo',
        ]);

        $options = $dompdf->getOptions();

        self::assertSame('foo', $options->getTempDir());
        self::assertSame(200, $options->getDpi());
    }
}
