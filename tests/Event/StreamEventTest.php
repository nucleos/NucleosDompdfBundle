<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\DompdfBundle\Tests\Event;

use Dompdf\Dompdf;
use Nucleos\DompdfBundle\Event\StreamEvent;
use PHPUnit\Framework\TestCase;

final class StreamEventTest extends TestCase
{
    public function testEvent(): void
    {
        $dompdf   = $this->createMock(Dompdf::class);
        $filename = 'file.pdf';

        /** @noinspection HtmlRequiredAltAttribute */
        /** @noinspection HtmlUnknownTarget */
        $html = "<h1>Foo</h1>Bar <b>baz</b><img src='img/foo'>";

        $event = new StreamEvent($dompdf, $filename, $html);

        self::assertSame($dompdf, $event->getPdf());
        self::assertSame($filename, $event->getFilename());
        self::assertSame($html, $event->getHtml());
    }
}
