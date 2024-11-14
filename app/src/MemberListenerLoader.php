<?php

use ArchiPro\EventDispatcher\ListenerProvider;
use ArchiPro\Silverstripe\EventDispatcher\Contract\ListenerLoaderInterface;
use ArchiPro\Silverstripe\EventDispatcher\Event\DataObjectEvent;
use ArchiPro\Silverstripe\EventDispatcher\Event\Operation;
use ArchiPro\Silverstripe\EventDispatcher\Listener\DataObjectEventListener;
use SilverStripe\Control\Email\Email;

use SilverStripe\Security\Member;


use function Amp\delay;

class MemberListenerLoader implements ListenerLoaderInterface
{
    public function loadListeners(ListenerProvider $provider): void
    {
        DataObjectEventListener::create(
            Closure::fromCallable([$this, 'onMemberCreated']),
            [Member::class],
            [Operation::CREATE]
        )->selfRegister($provider);
    }

    public function onMemberCreated(DataObjectEvent $event): void
    {
        $member = $event->getObject();
        delay(10);
        Email::create()
            ->setTo($member->Email)
            ->setSubject('Welcome to our site')
            ->setFrom('no-reply@example.com')
            ->setBody('Welcome to our site, ' . $member->FirstName)
            ->send();
    }
}

