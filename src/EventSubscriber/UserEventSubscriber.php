<?php


namespace App\EventSubscriber;

//use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
//use Symfony\Component\HttpKernel\KernelEvents;

class UserEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents() 
    {
        return [
            // KernelEvents::VIEW => ['me', EventPriorities::PRE_READ],
        ];
    }

    public static function me(ViewEvent $event)
    {
        dd($event);
        // return $event;
    }
}