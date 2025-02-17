<?php

namespace App\Model;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;

class SSNExtension extends DataExtension
{
    private static $db = [
        'SSN' => 'Varchar',
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab('Root.Main', TextField::create('SSN', 'SSN'));
    }

    public function onBeforeWrite()
    {
        $this->owner->SSN = str_replace('-', '', $this->owner->SSN ?: '');
    }
}
