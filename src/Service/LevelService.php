<?php

namespace App\Service;


use App\Entity\Level;
use App\Entity\Path;
use App\Repository\LevelRepository;

class LevelService
{
    public function __construct(
        private readonly LevelRepository $levelRepository,
    )
    {
    }

    public function findLevelInPath(?Path $path, int $sequenceNumber) : ?Level {
        return $this->levelRepository->findLevelInPath($path, $sequenceNumber);
    }
}
