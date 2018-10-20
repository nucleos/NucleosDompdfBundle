<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\DompdfBundle\Tests\Event;

use Core23\DompdfBundle\Event\StreamEvent;
use Dompdf\Dompdf;
use PHPUnit\Framework\TestCase;

final class StreamEventTest extends TestCase
{
    public function testEvent(): void
    {
        $dompdf   = $this->createMock(Dompdf::class);
        $filename = 'file.pdf';
        $html     = "<h1>Foo</h1>Bar <b>baz</b><img src='img/foo'>";

        $event = new StreamEvent($dompdf, $filename, $html);

        $this->assertInstanceOf(Dompdf::class, $event->getPdf());
        $this->assertSame($dompdf, $event->getPdf());
        $this->assertSame($filename, $event->getFilename());
        $this->assertSame($html, $event->getHtml());
    }
}
