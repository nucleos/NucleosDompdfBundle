<?php

namespace Core23\DompdfBundle\Factory;

use Dompdf\Dompdf;

interface DompdfFactoryInterface
{
    /**
     * Creates a new dompdf instance.
     *
     * @param array $options
     *
     * @return Dompdf
     */
    public function create(array $options = array()): Dompdf;
}
