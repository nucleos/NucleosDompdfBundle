<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\DompdfBundle\Tests\Wrapper;

use Dompdf\Dompdf;
use Nucleos\DompdfBundle\DompdfEvents;
use Nucleos\DompdfBundle\Exception\PdfException;
use Nucleos\DompdfBundle\Factory\DompdfFactoryInterface;
use Nucleos\DompdfBundle\Wrapper\DompdfWrapper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class DompdfWrapperTest extends TestCase
{
    private DompdfFactoryInterface&MockObject $dompdfFactory;

    private EventDispatcherInterface&MockObject $eventDispatcher;

    private DompdfWrapper $dompdfWrapper;

    private Dompdf&MockObject $dompdf;

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

        $this->dompdf->expects(self::once())
            ->method('loadHtml')
            ->with(self::equalTo($input))
        ;
        $this->dompdf->expects(self::once())
            ->method('render')
        ;
        $this->dompdf->expects(self::once())
            ->method('stream')
            ->with(self::equalTo('file.pdf'))
        ;

        $this->eventDispatcher->expects(self::once())
            ->method('dispatch')
            ->with(self::anything(), self::equalTo(DompdfEvents::STREAM))
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
            ->with(self::equalTo(['tempDir' => 'bar']))
            ->willReturn($this->dompdf)
        ;

        $this->dompdf->expects(self::once())
            ->method('loadHtml')
            ->with(self::equalTo($output))
        ;
        $this->dompdf->expects(self::once())
            ->method('render')
        ;
        $this->dompdf->expects(self::once())
            ->method('stream')
            ->with(self::equalTo('file.pdf'))
        ;

        $this->eventDispatcher->expects(self::once())
            ->method('dispatch')
            ->with(self::anything(), self::equalTo(DompdfEvents::STREAM))
        ;

        $this->dompdfWrapper->streamHtml($input, 'file.pdf', ['tempDir' => 'bar']);
    }

    public function testGetPdf(): void
    {
        /** @noinspection HtmlRequiredAltAttribute */
        /** @noinspection HtmlUnknownTarget */
        $input = "<h1>Foo</h1>Bar <b>baz</b><img src='img/foo'>";

        $this->prepareOutput($input, 'BINARY_CONTENT');

        $this->eventDispatcher->expects(self::once())
            ->method('dispatch')
            ->with(self::anything(), self::equalTo(DompdfEvents::OUTPUT))
        ;

        $this->dompdfWrapper->getPdf($input, ['tempDir' => 'bar']);
    }

    public function testGetPdfWithError(): void
    {
        $this->expectException(PdfException::class);

        $input = '<h1>Foo</h1>Bar <b>baz</b>';

        $this->prepareOutput($input);

        $this->eventDispatcher->expects(self::once())
            ->method('dispatch')
            ->with(self::anything(), self::equalTo(DompdfEvents::OUTPUT))
        ;

        $this->dompdfWrapper->getPdf($input);
    }

    public function testGetStreamResponse(): void
    {
        $this->dompdfFactory
            ->method('create')
            ->willReturn($this->dompdf)
        ;

        $this->dompdf->expects(self::once())
            ->method('loadHtml')
            ->with(self::equalTo('<h1>Title</h1>'))
        ;
        $this->dompdf->expects(self::once())
            ->method('render')
        ;
        $this->dompdf->expects(self::once())
            ->method('stream')
            ->with(self::equalTo('file.pdf'))
        ;

        $response = $this->dompdfWrapper->getStreamResponse('<h1>Title</h1>', 'file.pdf');
        $response->sendContent();
    }

    private function prepareOutput(string $input, ?string $response = null): void
    {
        $this->dompdfFactory
            ->method('create')
            ->willReturn($this->dompdf)
        ;

        $this->dompdf->expects(self::once())
            ->method('loadHtml')
            ->with(self::equalTo($input))
        ;
        $this->dompdf->expects(self::once())
            ->method('render')
        ;
        $this->dompdf->expects(self::once())
            ->method('output')
            ->willReturn($response)
        ;
    }
}
