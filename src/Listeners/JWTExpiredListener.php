<?php

namespace App\Listeners;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;

class JWTExpiredListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::JWT_EXPIRED => 'onJWTExpired',
        ];
    }

    public function onJWTExpired(JWTExpiredEvent $event)
    {
        $event->getResponse()->setStatusCode(Response::HTTP_I_AM_A_TEAPOT);
    }
}
