<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\DompdfBundle\Tests\Wrapper;

use Core23\DompdfBundle\Factory\DompdfFactory;
use Core23\DompdfBundle\Factory\DompdfFactoryInterface;
use Core23\DompdfBundle\Wrapper\DompdfWrapper;
use Dompdf\Dompdf;
use PHPUnit\Framework\TestCase;

class DompdfWrapperTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|DompdfFactory
     */
    private $dompdfFactory;

    /**
     * @var DompdfWrapper
     */
    private $dompdfWrapper;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Dompdf
     */
    private $dompdf;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->dompdf        = $this->createMock(Dompdf::class);
        $this->dompdfFactory = $this->createMock(DompdfFactoryInterface::class);

        $this->dompdfWrapper = new DompdfWrapper($this->dompdfFactory);
    }

    public function testStreamHtml()
    {
        $input = "<h1>Foo</h1>Bar <b>baz</b><img src='img/foo'>";

        $this->dompdfFactory->expects($this->any())
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

    public function testStreamHtmlWithImg()
    {
        $input  = "<h1>Foo</h1>Bar <b>baz</b><img src='img/foo'>";
        $output = "<h1>Foo</h1>Bar <b>baz</b><img src='img/foo'>";

        $this->dompdfFactory->expects($this->any())
            ->method('create')
            ->with($this->equalTo(array('tempDir' => 'bar')))
            ->will($this->returnValue($this->dompdf));

        $this->dompdf->expects($this->once())
            ->method('loadHtml')
            ->with($this->equalTo($output));
        $this->dompdf->expects($this->once())
            ->method('render');
        $this->dompdf->expects($this->once())
            ->method('stream')
            ->with($this->equalTo('file.pdf'));

        $this->dompdfWrapper->streamHtml($input, 'file.pdf', array('tempDir' => 'bar'));
    }

    public function testGetPdf()
    {
        $input = "<h1>Foo</h1>Bar <b>baz</b><img src='img/foo'>";

        $this->dompdfFactory->expects($this->any())
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

        $this->dompdfWrapper->getPdf($input, array('tempDir' => 'bar'));
    }
}
