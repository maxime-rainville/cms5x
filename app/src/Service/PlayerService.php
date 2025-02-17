<?php

namespace App\Service;

use App\Model\Player;
use SilverStripe\Core\Injector\Injectable;

class PlayerService implements PlayerStatsServiceInterface
{
    use Injectable;

    public function getPlayerStats(Player $player): array
    {
        return [
            'position' => $player->Position,
        ];
    }
}
