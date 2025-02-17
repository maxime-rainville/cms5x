<?php

namespace App\Tests;

use SilverStripe\Dev\SapphireTest;
use App\Model\Person;
use App\Model\Player;
use App\Model\Team;
use App\Service\PlayerService;
use App\Service\PlayerStatsServiceInterface;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\ORM\FieldType\DBDatetime;

class PersonTest extends SapphireTest
{
    protected static $fixture_file = 'app/tests/PersonTest.yml';

    protected static $extra_dataobjects = [
        Person::class,
        Player::class,
        Team::class,
    ];

    public function testPersonAge()
    {
        $person = Person::create();
        $person->DateOfBirth = '1990-01-01 00:00:00';

        DBDatetime::set_mock_now('2000-01-01 00:00:00');

        // Note: This test will need updating yearly
        $expectedAge = 10;
        $this->assertEquals($expectedAge, $person->getAge());
    }

    public function testPlayerTeamRelation()
    {
        $team = Team::create();
        $team->Title = 'Test Team';
        $team->write();

        $player = Player::create();
        $player->FirstName = 'John';
        $player->LastName = 'Doe';
        $player->Position = 'Forward';
        $player->TeamID = $team->ID;
        $player->write();

        $this->assertEquals($team->ID, $player->TeamID);
        $this->assertEquals(1, $team->Players()->count());
    }

    public function testCanViewPerson()
    {
        $player = $this->objFromFixture(Player::class, 'player1');
        $this->logOut();
        $this->assertFalse($player->canView());

        $this->logInWithPermission('CMS_ACCESS');
        $this->assertTrue($player->canView());

        $this->logInWithPermission('Admin');
        $this->assertTrue($player->canView());
    }

    public function testPlayerStatsService()
    {
        $player = $this->objFromFixture(Player::class, 'player1');

        $service = Injector::inst()->get(PlayerStatsServiceInterface::class);
        // or
        $service = PlayerService::singleton();
        // or
        $service = PlayerService::create();

        $stats = $service->getPlayerStats($player);
        $stats = $service->getPlayerStats($player);
        $this->assertEquals('Forward', $stats['position']);
    }
}
