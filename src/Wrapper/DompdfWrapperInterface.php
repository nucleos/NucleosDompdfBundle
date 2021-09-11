<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\DompdfBundle\Wrapper;

use Nucleos\DompdfBundle\Exception\PdfException;

/**
 * @method StreamedResponse getStreamResponse(string $html, string $filename, array $options = [])
 */
interface DompdfWrapperInterface
{
    /**
     * Renders a pdf document and streams it to the browser.
     *
     * @param string               $html     The html sourcecode to render
     * @param string               $filename The name of the docuemtn
     * @param array<string, mixed> $options  The rendering options (see dompdf docs)
     *
     * @deprecated use getStreamResponse instead
     */
    public function streamHtml(string $html, string $filename, array $options = []): void;

    /**
     * Renders a pdf document and return the binary content.
     *
     * @param string               $html    The html sourcecode to render
     * @param array<string, mixed> $options The rendering options (see dompdf docs)
     *
     * @throws PdfException
     */
    public function getPdf(string $html, array $options = []): string;
}
