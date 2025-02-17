<?php

namespace App\Model;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;

/**
 * Represents a player in the system
 * Extends Person to add sports-specific attributes
 *
 * @property string $Position
 * @property string $JerseyNumber
 * @property int $TeamID
 * @method Team Team()
 */
class Player extends Person
{
    private static $table_name = 'Player';

    private static $db = [
        'Position' => 'Varchar',
        'JerseyNumber' => 'Varchar(10)',
    ];

    private static $has_one = [
        'Team' => Team::class,
    ];

    private static $has_many = [
    ];

    private static $many_many = [
    ];

    private static $summary_fields = [
        'FirstName' => 'First Name',
        'LastName' => 'Last Name',
        'Position' => 'Position',
        'JerseyNumber' => 'Jersey Number',
        'Team.Title' => 'Team'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab('Root.Player', [
            TextField::create('Position', 'Position'),
            TextField::create('JerseyNumber', 'Jersey Number'),
            DropdownField::create(
                'TeamID',
                'Team',
                Team::get()->map('ID', 'Title')
            )->setEmptyString('Select a team'),
        ]);
        return $fields;
    }
}
