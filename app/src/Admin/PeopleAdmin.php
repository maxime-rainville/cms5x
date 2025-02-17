<?php

namespace App\Admin;

use SilverStripe\Admin\ModelAdmin;
use App\Model\Person;
use App\Model\Player;
use App\Model\Team;

/**
 * Provides CMS admin interface for managing People, Players and Teams
 */
class PeopleAdmin extends ModelAdmin
{
    private static $managed_models = [
        Person::class,
        Player::class,
        Team::class
    ];

    private static $url_segment = 'people';

    private static $menu_title = 'People';

    private static $menu_icon_class = 'font-icon-torso';
}
