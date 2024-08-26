<?php

namespace App\EventListener;

use App\Attribute\ValidateNonEmptyBody;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

final class ValidateNonEmptyBodyListener
{
    #[AsEventListener(event: KernelEvents::CONTROLLER)]
    public function onKernelController(ControllerEvent $event): void
    {
        if ($event->getControllerReflector()->getAttributes(ValidateNonEmptyBody::class)) {
            $request = $event->getRequest();
            $content = $request->getContent();

            if (empty($content)) {
                throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, 'Request body cannot be empty');
            }
        }
    }
}
