<?php

namespace App\Service;

use App\Model\Player;

interface PlayerStatsServiceInterface
{
    public function getPlayerStats(Player $player): array;
}
