<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\DompdfBundle\Event;

use Dompdf\Dompdf;
use Symfony\Contracts\EventDispatcher\Event;

final class OutputEvent extends Event
{
    /**
     * @var Dompdf
     */
    private $pdf;

    /**
     * @var string
     */
    private $html;

    public function __construct(Dompdf $pdf, string $html)
    {
        $this->pdf      = $pdf;
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
     * Returns the html.
     */
    public function getHtml(): string
    {
        return $this->html;
    }
}
