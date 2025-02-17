<?php

namespace App\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Security\Permission;
use SilverStripe\ORM\FieldType\DBDateTime;

/**
 * Represents a person in the system
 *
 * @property string $FirstName
 * @property string $LastName
 * @property string $Email
 * @property-read int|null $Age
 * @property DBDateTime|string $DateOfBirth
 */
class Person extends DataObject
{
    private static $table_name = 'Person';

    private static $db = [
        'FirstName' => 'Varchar',
        'LastName' => 'Varchar',
        'Email' => 'Varchar',
        'DateOfBirth' => 'Datetime',
    ];

    private static $summary_fields = [
        'FirstName' => 'First Name',
        'LastName' => 'Last Name',
        'Email' => 'Email',
        'Age' => 'Age'
    ];

    private static $extensions = [
        SSNExtension::class,
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab('Root.Main', [
            ReadonlyField::create('Age'),
        ]);

        return $fields;
    }

    /** Accessor */
    public function getAge(): int|null
    {
        if ($this->DateOfBirth) {
            $date = new \DateTime($this->DateOfBirth);
            $now = new \DateTime(DBDateTime::now());
            return $date->diff($now)->y;
        }
        return null;
    }

    public function getTitle(): string
    {
        return $this->FirstName . ' ' . $this->LastName;
    }

    public function canView($member = null)
    {
        return Permission::check('CMS_ACCESS', 'any', $member);
    }

    public function canEdit($member = null)
    {
        return Permission::check('CMS_ACCESS', 'any', $member);
    }

    public function canDelete($member = null)
    {
        return Permission::check('CMS_ACCESS', 'any', $member);
    }

    public function canCreate($member = null, $context = [])
    {
        return Permission::check('CMS_ACCESS', 'any', $member);
    }
}
