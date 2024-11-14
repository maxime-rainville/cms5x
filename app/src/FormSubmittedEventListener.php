<?php

use function Amp\delay;

class FormSubmittedEventListener
{
    public static function handleEvent(FormSubmittedEvent $event)
    {
        delay(10);
        error_log('Form submitted: ' . $event->formName . ' ' . json_encode($event->data));
    }
}
