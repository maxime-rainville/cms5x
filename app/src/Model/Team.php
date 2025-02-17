<?php

namespace App\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;

/**
 * Represents a team in the system
 *
 * @property string $Title
 * @method HasManyList Players()
 */
class Team extends DataObject
{
    private static $table_name = 'Team';

    private static $db = [
        'Title' => 'Varchar',
    ];

    private static $has_many = [
        'Players' => Player::class,
    ];

}
