<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\DompdfBundle\Wrapper;

use Core23\DompdfBundle\Events;
use Core23\DompdfBundle\Factory\DompdfFactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class DompdfWrapper implements DompdfWrapperInterface
{
    /**
     * @var DompdfFactoryInterface
     */
    private $dompdfFactory;

    /**
     * @var EventDispatcherInterface|null
     */
    private $eventDispatcher;

    /**
     * @param DompdfFactoryInterface        $dompdfFactory
     * @param EventDispatcherInterface|null $eventDispatcher
     */
    public function __construct(DompdfFactoryInterface $dompdfFactory, EventDispatcherInterface $eventDispatcher = null)
    {
        $this->dompdfFactory   = $dompdfFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function streamHtml(string $html, string $filename, array $options = []): void
    {
        $pdf = $this->dompdfFactory->create($options);
        $pdf->loadHtml($html);
        $pdf->render();

        if ($this->eventDispatcher instanceof EventDispatcherInterface) {
            $event = new GenericEvent($pdf, ['filename' => $filename, 'html' => $html]);
            $this->eventDispatcher->dispatch(Events::STREAM, $event);
        }

        $pdf->stream($filename, $options);
    }

    /**
     * @param string $html
     * @param string $filename
     * @param array  $options
     *
     * @return StreamedResponse
     */
    public function getStreamResponse(string $html, string $filename, array $options = []): StreamedResponse
    {
        $response = new StreamedResponse();
        $response->setCallback(function () use ($html, $filename, $options): void {
            $this->streamHtml($html, $filename, $options);
        });

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function getPdf(string $html, array $options = []): string
    {
        $pdf = $this->dompdfFactory->create($options);
        $pdf->loadHtml($html);
        $pdf->render();

        if ($this->eventDispatcher instanceof EventDispatcherInterface) {
            $event = new GenericEvent($pdf, ['html' => $html]);
            $this->eventDispatcher->dispatch(Events::OUTPUT, $event);
        }

        return $pdf->output();
    }
}
