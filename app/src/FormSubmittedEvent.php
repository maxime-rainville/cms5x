<?php

class FormSubmittedEvent
{
    public function __construct(
        public string $formName,
        public array $data
    ) {}
}
