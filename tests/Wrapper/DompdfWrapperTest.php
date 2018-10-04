<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\DompdfBundle\Tests\Wrapper;

use Core23\DompdfBundle\Factory\DompdfFactoryInterface;
use Core23\DompdfBundle\Wrapper\DompdfWrapper;
use Dompdf\Dompdf;
use PHPUnit\Framework\TestCase;

final class DompdfWrapperTest extends TestCase
{
    private $dompdfFactory;

    /**
     * @var DompdfWrapper
     */
    private $dompdfWrapper;

    private $dompdf;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->dompdf        = $this->createMock(Dompdf::class);
        $this->dompdfFactory = $this->createMock(DompdfFactoryInterface::class);

        $this->dompdfWrapper = new DompdfWrapper($this->dompdfFactory);
    }

    public function testStreamHtml(): void
    {
        $input = "<h1>Foo</h1>Bar <b>baz</b><img src='img/foo'>";

        $this->dompdfFactory
            ->method('create')
            ->will($this->returnValue($this->dompdf));

        $this->dompdf->expects($this->once())
            ->method('loadHtml')
            ->with($this->equalTo($input));
        $this->dompdf->expects($this->once())
            ->method('render');
        $this->dompdf->expects($this->once())
            ->method('stream')
            ->with($this->equalTo('file.pdf'));

        $this->dompdfWrapper->streamHtml($input, 'file.pdf');
    }

    public function testStreamHtmlWithImg(): void
    {
        $input  = "<h1>Foo</h1>Bar <b>baz</b><img src='img/foo'>";
        $output = "<h1>Foo</h1>Bar <b>baz</b><img src='img/foo'>";

        $this->dompdfFactory
            ->method('create')
            ->with($this->equalTo(['tempDir' => 'bar']))
            ->will($this->returnValue($this->dompdf));

        $this->dompdf->expects($this->once())
            ->method('loadHtml')
            ->with($this->equalTo($output));
        $this->dompdf->expects($this->once())
            ->method('render');
        $this->dompdf->expects($this->once())
            ->method('stream')
            ->with($this->equalTo('file.pdf'));

        $this->dompdfWrapper->streamHtml($input, 'file.pdf', ['tempDir' => 'bar']);
    }

    public function testGetPdf(): void
    {
        $input = "<h1>Foo</h1>Bar <b>baz</b><img src='img/foo'>";

        $this->dompdfFactory
            ->method('create')
            ->will($this->returnValue($this->dompdf));

        $this->dompdf->expects($this->once())
            ->method('loadHtml')
            ->with($this->equalTo($input));
        $this->dompdf->expects($this->once())
            ->method('render');
        $this->dompdf->expects($this->once())
            ->method('output')
            ->willReturn('BINARY_CONTENT');

        $this->dompdfWrapper->getPdf($input, ['tempDir' => 'bar']);
    }
}
