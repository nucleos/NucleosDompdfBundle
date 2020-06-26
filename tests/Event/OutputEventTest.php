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
use Nucleos\DompdfBundle\Event\OutputEvent;
use PHPUnit\Framework\TestCase;

final class OutputEventTest extends TestCase
{
    public function testEvent(): void
    {
        $dompdf = $this->createMock(Dompdf::class);
        /** @noinspection HtmlRequiredAltAttribute */
        /** @noinspection HtmlUnknownTarget */
        $html = "<h1>Foo</h1>Bar <b>baz</b><img src='img/foo'>";

        $event = new OutputEvent($dompdf, $html);

        static::assertSame($dompdf, $event->getPdf());
        static::assertSame($html, $event->getHtml());
    }
}
