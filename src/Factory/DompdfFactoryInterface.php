<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
    public function create(array $options = []): Dompdf;
}
