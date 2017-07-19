<?php

namespace Core23\DompdfBundle\Factory;

use Dompdf\Dompdf;
use Dompdf\Options;

final class DompdfFactory implements DompdfFactoryInterface
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
    public function create(array $options = array()): Dompdf
    {
        return new Dompdf($this->createOptions($options));
    }

    /**
     * {@inheritdoc}
     */
    private function createOptions(array $options = array()): Options
    {
        return new Options(array_merge($this->options, $options));
    }
}
