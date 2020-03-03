<?php

namespace App\Base\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!$exception instanceof HttpExceptionInterface) {
            return;
        }

        $data = [
            'error' => [
                'code' => $exception->getStatusCode(),
                'message' => $exception->getMessage(),
            ],
        ];

        if ($_ENV['APP_DEBUG']) {
            $data['error']['trace'] = $exception->getTrace();
        }

        $response = new JsonResponse(
            $data,
            $exception->getStatusCode(),
            $exception->getHeaders()
        );

        $response->headers->set('Access-Control-Allow-Origin', '*');

        $event->setResponse($response);
    }
}
