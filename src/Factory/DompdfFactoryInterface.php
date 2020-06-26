<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\DompdfBundle\Factory;

use Dompdf\Dompdf;

interface DompdfFactoryInterface
{
    /**
     * Creates a new dompdf instance.
     *
     * @param array<string, mixed> $options
     */
    public function create(array $options = []): Dompdf;
}
