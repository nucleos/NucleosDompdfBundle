<?php

/*
 * This file is part of the ni-ju-san CMS.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\DompdfBundle\Wrapper;

use Symfony\Component\HttpKernel\KernelInterface;

class DompdfWrapper
{
    /**
     * @var string
     */
    private $basePath;

    /**
     * @param KernelInterface $kernel
     * @param array           $config
     */
    public function __construct(KernelInterface $kernel, array $config = array())
    {
        $this->basePath = $kernel->getRootdir().'/../web';

        require_once dirname(__FILE__).'/../../../../vendor/dompdf/dompdf/dompdf_config.inc.php';

        foreach ($config as $key => $value) {
            def(strtoupper($key), $value);
        }
    }

    /**
     * Renders a pdf document and streams it to the browser.
     *
     * @param string     $html     The html sourcecode to render
     * @param string     $filename The name of the docuemtn
     * @param array|null $options  The rendering options (see dompdf docs)
     *
     * @throws \Exception
     */
    public function streamHtml($html, $filename, $options = null)
    {
        $html = $this->replaceBasePath($html);

        $pdf = $this->getPdfContent($html);
        $pdf->stream($filename, $options);
    }

    /**
     * Renders a pdf document and return the binary content.
     *
     * @param string     $html    The html sourcecode to render
     * @param array|null $options The rendering options (see dompdf docs)
     *
     * @throws \Exception
     *
     * @return string
     */
    public function getPdf($html, $options = null)
    {
        $html = $this->replaceBasePath($html);

        $pdf = $this->getPdfContent($html);

        return $pdf->output($options);
    }

    /**
     * Renders a pdf document and streams it to the browser.
     *
     * @param string $html The html sourcecode to render
     *
     * @return \DOMPDF
     */
    private function getPdfContent($html)
    {
        $pdf = new \DOMPDF();

        if (defined('DOMPDF_DEFAULT_PAPER_SIZE')) {
            $pdf->set_paper(DOMPDF_DEFAULT_PAPER_SIZE);
        }

        $pdf->load_html($html);
        $pdf->render();

        return $pdf;
    }

    /**
     * Replaces relative paths with absolute paths.
     *
     * @param string $html The html sourcecode
     *
     * @return string sourceode
     */
    private function replaceBasePath($html)
    {
        $pattern = '#<([^>]* )(src|href)="(?![A-z]*:)([^"]*)"#';
        $replace = '<$1$2="'.$this->basePath.'$3"';

        return preg_replace($pattern, $replace, $html);
    }
}
