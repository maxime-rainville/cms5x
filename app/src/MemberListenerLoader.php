<?php

use ArchiPro\EventDispatcher\ListenerProvider;
use ArchiPro\Silverstripe\EventDispatcher\Contract\ListenerLoaderInterface;
use ArchiPro\Silverstripe\EventDispatcher\Event\DataObjectEvent;
use ArchiPro\Silverstripe\EventDispatcher\Event\Operation;
use ArchiPro\Silverstripe\EventDispatcher\Listener\DataObjectEventListener;
use ArchiPro\Silverstripe\EventDispatcher\Service\EventService;
use SilverStripe\Control\Director;
use SilverStripe\Control\Email\Email;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;

class MemberListenerLoader implements ListenerLoaderInterface
{
    public function loadListeners(ListenerProvider $provider): void
    {
        DataObjectEventListener::create(
            Closure::fromCallable([self::class, 'onMemberCreated']),
            [Member::class],
        )->selfRegister($provider);
    }

    public static function onMemberCreated(DataObjectEvent $event): void
    {
        $member = $event->getObject();
        error_log('Member created: ' . $member->ID);

        $currentUser = Security::getCurrentUser();
        error_log('Current user is ' . $currentUser->ID . ' ' . $currentUser->Email);

        EventService::singleton()->dispatch(new MyCustomEvent());

        error_log(Director::absoluteURL('/'));

        Email::create()
            ->setTo($member->Email)
            ->setSubject('Welcome to our site')
            ->setFrom('no-reply@example.com')
            ->setBody('Welcome to our site')
            ->send();
    }
}

