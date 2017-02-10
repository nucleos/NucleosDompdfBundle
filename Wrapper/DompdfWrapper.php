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
     * @var string
     */
    private $basePath;

    /**
     * @var string[]
     */
    private $options;

    /**
     * @param string   $basePath
     * @param string[] $options
     */
    public function __construct(string $basePath, array $options = array())
    {
        $this->basePath = $basePath;
        $this->options  = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function streamHtml(string $html, string $filename, array $options = array(), bool $replacePaths = true)
    {
        if ($replacePaths) {
            $html = $this->replaceBasePath($html);
        }

        $pdf = $this->createDompdf();
        $pdf->setOptions($this->createOptions($options));
        $pdf->loadHtml($html);
        $pdf->render();
        $pdf->stream($filename);
    }

    /**
     * {@inheritdoc}
     */
    public function getPdf(string $html, array $options = array(), bool $replacePaths = true)
    {
        if ($replacePaths) {
            $html = $this->replaceBasePath($html);
        }

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

    /**
     * Replaces relative paths with absolute paths.
     *
     * @param string $html The html sourcecode
     *
     * @return string Modified html sourcecode
     *
     * @deprecated
     */
    private function replaceBasePath($html): string
    {
        @trigger_error('Replacing paths is deprecated and will be removed with 2.0.', E_USER_DEPRECATED);

        $pattern = '#<([^>]* )(src|href)=([\'"])(?![A-z]*:)([^"]*)([\'"])#';
        $replace = '<$1$2=$3'.$this->basePath.'$4$5';

        return preg_replace($pattern, $replace, $html);
    }
}
