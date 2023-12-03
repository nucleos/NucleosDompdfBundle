<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Nucleos\DompdfBundle\Factory\DompdfFactory;
use Nucleos\DompdfBundle\Factory\DompdfFactoryInterface;
use Nucleos\DompdfBundle\Wrapper\DompdfWrapper;
use Nucleos\DompdfBundle\Wrapper\DompdfWrapperInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $container): void {
    $container->services()

        ->alias('dompdf', DompdfWrapper::class)
            ->public()

        ->alias('dompdf.factory', DompdfFactory::class)
            ->public()

        ->alias(DompdfWrapperInterface::class, DompdfWrapper::class)
            ->public()

        ->alias(DompdfFactoryInterface::class, DompdfFactory::class)
            ->public()

        ->set(DompdfWrapper::class)
            ->args([
                new Reference('dompdf.factory'),
                new Reference('event_dispatcher', ContainerInterface::NULL_ON_INVALID_REFERENCE),
            ])

        ->set(DompdfFactory::class)
            ->args([
                new Parameter('nucleos_dompdf.options'),
            ])
    ;
};
