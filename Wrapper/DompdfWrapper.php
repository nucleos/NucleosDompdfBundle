<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\DompdfBundle\Wrapper;

use Dompdf\Dompdf;
use Dompdf\Options;

class DompdfWrapper implements DompdfWrapperInterface
{
    /**
     * @var string[]
     */
    private $options;

    /**
     * @param string[] $options
     */
    public function __construct(array $options = array())
    {
        $this->options  = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function streamHtml(string $html, string $filename, array $options = array())
    {
        $pdf = $this->createDompdf();
        $pdf->setOptions($this->createOptions($options));
        $pdf->loadHtml($html);
        $pdf->render();
        $pdf->stream($filename);
    }

    /**
     * {@inheritdoc}
     */
    public function getPdf(string $html, array $options = array())
    {
        $pdf = $this->createDompdf();
        $pdf->setOptions($this->createOptions($options));
        $pdf->loadHtml($html);
        $pdf->render();

        return $pdf->output();
    }

    /**
     * {@inheritdoc}
     */
    public function createDompdf(): Dompdf
    {
        return new Dompdf();
    }

    /**
     * {@inheritdoc}
     */
    public function createOptions(array $options = array()): Options
    {
        return new Options(array_merge($this->options, $options));
    }
}
