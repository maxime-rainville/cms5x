<?php

class MyCustomEventListener
{
    public static function handleEvent(MyCustomEvent $event)
    {
        error_log('MyCustomEventListener::handleEvent was called');
    }
}
