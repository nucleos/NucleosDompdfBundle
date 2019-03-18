<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\DompdfBundle\Tests\Wrapper;

use Core23\DompdfBundle\DompdfEvents;
use Core23\DompdfBundle\Exception\PdfException;
use Core23\DompdfBundle\Factory\DompdfFactoryInterface;
use Core23\DompdfBundle\Wrapper\DompdfWrapper;
use Dompdf\Dompdf;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class DompdfWrapperTest extends TestCase
{
    private $dompdfFactory;

    private $eventDispatcher;

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
        $this->dompdf          = $this->createMock(Dompdf::class);
        $this->dompdfFactory   = $this->createMock(DompdfFactoryInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->dompdfWrapper   = new DompdfWrapper($this->dompdfFactory, $this->eventDispatcher);
    }

    public function testStreamHtml(): void
    {
        /** @noinspection HtmlRequiredAltAttribute */
        /** @noinspection HtmlUnknownTarget */
        $input = "<h1>Foo</h1>Bar <b>baz</b><img src='img/foo'>";

        $this->dompdfFactory
            ->method('create')
            ->willReturn($this->dompdf)
        ;

        $this->dompdf->expects($this->once())
            ->method('loadHtml')
            ->with($this->equalTo($input))
        ;
        $this->dompdf->expects($this->once())
            ->method('render')
        ;
        $this->dompdf->expects($this->once())
            ->method('stream')
            ->with($this->equalTo('file.pdf'))
        ;

        $this->eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->equalTo(DompdfEvents::STREAM))
        ;

        $this->dompdfWrapper->streamHtml($input, 'file.pdf');
    }

    public function testStreamHtmlWithImg(): void
    {
        /** @noinspection HtmlRequiredAltAttribute */
        /** @noinspection HtmlUnknownTarget */
        $input  = "<h1>Foo</h1>Bar <b>baz</b><img src='img/foo'>";
        /** @noinspection HtmlRequiredAltAttribute */
        /** @noinspection HtmlUnknownTarget */
        $output = "<h1>Foo</h1>Bar <b>baz</b><img src='img/foo'>";

        $this->dompdfFactory
            ->method('create')
            ->with($this->equalTo(['tempDir' => 'bar']))
            ->willReturn($this->dompdf)
        ;

        $this->dompdf->expects($this->once())
            ->method('loadHtml')
            ->with($this->equalTo($output))
        ;
        $this->dompdf->expects($this->once())
            ->method('render')
        ;
        $this->dompdf->expects($this->once())
            ->method('stream')
            ->with($this->equalTo('file.pdf'))
        ;

        $this->eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->equalTo(DompdfEvents::STREAM))
        ;

        $this->dompdfWrapper->streamHtml($input, 'file.pdf', ['tempDir' => 'bar']);
    }

    public function testGetPdf(): void
    {
        /** @noinspection HtmlRequiredAltAttribute */
        /** @noinspection HtmlUnknownTarget */
        $input = "<h1>Foo</h1>Bar <b>baz</b><img src='img/foo'>";

        $this->prepareOutput($input, 'BINARY_CONTENT');

        $this->eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->equalTo(DompdfEvents::OUTPUT))
        ;

        $this->dompdfWrapper->getPdf($input, ['tempDir' => 'bar']);
    }

    public function testGetPdfWithError(): void
    {
        $this->expectException(PdfException::class);

        $input = '<h1>Foo</h1>Bar <b>baz</b>';

        $this->prepareOutput($input);

        $this->eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->equalTo(DompdfEvents::OUTPUT))
        ;

        $this->dompdfWrapper->getPdf($input);
    }

    public function testGetStreamResponse(): void
    {
        $this->dompdfFactory
            ->method('create')
            ->willReturn($this->dompdf)
        ;

        $this->dompdf->expects($this->once())
            ->method('loadHtml')
            ->with($this->equalTo('<h1>Title</h1>'))
        ;
        $this->dompdf->expects($this->once())
            ->method('render')
        ;
        $this->dompdf->expects($this->once())
            ->method('stream')
            ->with($this->equalTo('file.pdf'))
        ;

        $response = $this->dompdfWrapper->getStreamResponse('<h1>Title</h1>', 'file.pdf');
        $response->sendContent();
    }

    /**
     * @param string      $input
     * @param string|null $response
     */
    private function prepareOutput(string $input, string $response = null): void
    {
        $this->dompdfFactory
            ->method('create')
            ->willReturn($this->dompdf)
        ;

        $this->dompdf->expects($this->once())
            ->method('loadHtml')
            ->with($this->equalTo($input))
        ;
        $this->dompdf->expects($this->once())
            ->method('render')
        ;
        $this->dompdf->expects($this->once())
            ->method('output')
            ->willReturn($response)
        ;
    }
}
