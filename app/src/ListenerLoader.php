<?php

use ArchiPro\EventDispatcher\ListenerProvider;
use ArchiPro\Silverstripe\EventDispatcher\Contract\ListenerLoaderInterface;
use ArchiPro\Silverstripe\EventDispatcher\Event\DataObjectEvent;
use ArchiPro\Silverstripe\EventDispatcher\Event\Operation;
use ArchiPro\Silverstripe\EventDispatcher\Listener\DataObjectEventListener;
use SilverStripe\Control\Email\Email;
use SilverStripe\Security\Member;

class MemberListenerLoader implements ListenerLoaderInterface
{
    public function loadListeners(ListenerProvider $provider): void
    {
        error_log('Loading listeners');
        DataObjectEventListener::create(
            Closure::fromCallable([self::class, 'onMemberCreated']),
            [Member::class],
            [Operation::CREATE, Operation::UPDATE]
        )->selfRegister($provider);
    }

    public static function onMemberCreated(DataObjectEvent $event): void
    {
        $member = $event->getObject();
        error_log('Member created: ' . $member->ID);
        sleep(10);
        Email::create()
            ->setTo($member->Email)
            ->setSubject('Welcome to our site')
            ->setFrom('no-reply@example.com')
            ->setBody('Welcome to our site')
            ->send();
    }
}

