<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\DompdfBundle\Tests\Factory;

use Core23\DompdfBundle\Factory\DompdfFactory;
use Dompdf\Dompdf;
use Dompdf\Options;
use PHPUnit\Framework\TestCase;

class DompdfFactoryTest extends TestCase
{
    /**
     * @var DompdfFactory
     */
    private $dompdfFactory;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->dompdfFactory = new DompdfFactory([
            'dpi' => '100',
        ]);
    }

    public function testCreate(): void
    {
        $dompdf = $this->dompdfFactory->create();

        $this->assertInstanceOf(Dompdf::class, $dompdf);

        $options = $dompdf->getOptions();

        $this->assertInstanceOf(Options::class, $options);
        $this->assertSame('100', $options->getDpi());
    }

    public function testCreateWithOptions(): void
    {
        $dompdf = $this->dompdfFactory->create([
            'dpi'     => '200',
            'tempDir' => 'foo',
        ]);

        $this->assertInstanceOf(Dompdf::class, $dompdf);

        $options = $dompdf->getOptions();

        $this->assertInstanceOf(Options::class, $options);
        $this->assertSame('foo', $options->getTempDir());
        $this->assertSame('200', $options->getDpi());
    }
}
