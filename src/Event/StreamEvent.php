<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\DompdfBundle\Event;

use Dompdf\Dompdf;
use Symfony\Contracts\EventDispatcher\Event;

final class StreamEvent extends Event
{
    private Dompdf $pdf;

    private string $filename;

    private string $html;

    public function __construct(Dompdf $pdf, string $filename, string $html)
    {
        $this->pdf      = $pdf;
        $this->filename = $filename;
        $this->html     = $html;
    }

    /**
     * Returns the dompdf instance.
     */
    public function getPdf(): Dompdf
    {
        return $this->pdf;
    }

    /**
     * Returns the filename.
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * Returns the html.
     */
    public function getHtml(): string
    {
        return $this->html;
    }
}
