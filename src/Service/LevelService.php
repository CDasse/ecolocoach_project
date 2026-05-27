<?php

namespace App\Service;


use App\Entity\Level;
use App\Entity\Path;
use App\Repository\LevelRepository;

readonly class LevelService
{
    public function __construct(
        private LevelRepository $levelRepository,
    )
    {
    }

    public function findOneLevelInPath(Path $path, int $sequenceNumber) : ?Level
    {
        return $this->levelRepository->findOneLevelInPath($path, $sequenceNumber);
    }
}
