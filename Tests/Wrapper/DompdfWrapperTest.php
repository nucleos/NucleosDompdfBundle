<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\DompdfBundle\Tests\Wrapper;

use Core23\DompdfBundle\Wrapper\DompdfWrapper;
use Dompdf\Dompdf;
use PHPUnit\Framework\TestCase;

class DompdfWrapperTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|DompdfWrapper
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
        $this->dompdf = $this->createMock('Dompdf\Dompdf');

        $this->dompdfWrapper = $this->getMockBuilder('Core23\DompdfBundle\Wrapper\DompdfWrapper')
            ->setConstructorArgs(array('web_prefix/', array('dpi' => '200')))
            ->setMethods(array('createDompdf'))
            ->getMock();
        $this->dompdfWrapper->expects($this->any())
            ->method('createDompdf')
            ->will($this->returnValue($this->dompdf));
    }

    public function testCreateDompdf()
    {
        $this->assertSame($this->dompdf, $this->dompdfWrapper->createDompdf());
    }

    public function testCreateOptions()
    {
        $options = $this->dompdfWrapper->createOptions(array('tempDir' => 'foo'));

        $this->assertInstanceOf('Dompdf\Options', $options);
        $this->assertSame('foo', $options->getTempDir());
        $this->assertSame('200', $options->getDpi());
    }

    public function testStreamHtml()
    {
        $input = "<h1>Foo</h1>Bar <b>baz</b><img src='img/foo'>";

        /* @var \PHPUnit_Framework_MockObject_MockObject|Dompdf $dompdf */
        $this->dompdf->expects($this->once())
            ->method('setOptions');
        $this->dompdf->expects($this->once())
            ->method('loadHtml')
            ->with($this->equalTo($input));
        $this->dompdf->expects($this->once())
            ->method('render');
        $this->dompdf->expects($this->once())
            ->method('stream')
            ->with($this->equalTo('file.pdf'));

        $this->dompdfWrapper->expects($this->once())
            ->method('createDompdf')
            ->will($this->returnValue($this->dompdf));

        $this->dompdfWrapper->streamHtml($input, 'file.pdf', array('tempDir' => 'bar'), false);
    }

    public function testStreamHtmlWithImg()
    {
        $input  = "<h1>Foo</h1>Bar <b>baz</b><img src='img/foo'>";
        $output = "<h1>Foo</h1>Bar <b>baz</b><img src='web_prefix/img/foo'>";

        /* @var \PHPUnit_Framework_MockObject_MockObject|Dompdf $dompdf */
        $this->dompdf->expects($this->once())
            ->method('setOptions');
        $this->dompdf->expects($this->once())
            ->method('loadHtml')
            ->with($this->equalTo($output));
        $this->dompdf->expects($this->once())
            ->method('render');
        $this->dompdf->expects($this->once())
            ->method('stream')
            ->with($this->equalTo('file.pdf'));

        $this->dompdfWrapper->expects($this->once())
            ->method('createDompdf')
            ->will($this->returnValue($this->dompdf));

        $this->dompdfWrapper->streamHtml($input, 'file.pdf', array('tempDir' => 'bar'), true);
    }

    public function testGetPdf()
    {
        $input = "<h1>Foo</h1>Bar <b>baz</b><img src='img/foo'>";

        /* @var \PHPUnit_Framework_MockObject_MockObject|Dompdf $dompdf */
        $this->dompdf->expects($this->once())
            ->method('setOptions');
        $this->dompdf->expects($this->once())
            ->method('loadHtml')
            ->with($this->equalTo($input));
        $this->dompdf->expects($this->once())
            ->method('render');
        $this->dompdf->expects($this->once())
            ->method('output');

        $this->dompdfWrapper->expects($this->once())
            ->method('createDompdf')
            ->will($this->returnValue($this->dompdf));

        $this->dompdfWrapper->getPdf($input, array('tempDir' => 'bar'), false);
    }

    public function testGetPdfWithImg()
    {
        $input  = "<h1>Foo</h1>Bar <b>baz</b><img src='img/foo'>";
        $output = "<h1>Foo</h1>Bar <b>baz</b><img src='web_prefix/img/foo'>";

        /* @var \PHPUnit_Framework_MockObject_MockObject|Dompdf $dompdf */
        $this->dompdf->expects($this->once())
            ->method('setOptions');
        $this->dompdf->expects($this->once())
            ->method('loadHtml')
            ->with($this->equalTo($output));
        $this->dompdf->expects($this->once())
            ->method('render');
        $this->dompdf->expects($this->once())
            ->method('output');

        $this->dompdfWrapper->expects($this->once())
            ->method('createDompdf')
            ->will($this->returnValue($this->dompdf));

        $this->dompdfWrapper->getPdf($input, array('tempDir' => 'bar'), true);
    }
}
