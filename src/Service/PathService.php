<?php

namespace App\Service;

use App\Entity\Path;
use App\Repository\PathRepository;

readonly class PathService
{
    public function __construct(
        private PathRepository $pathRepository,
    )
    {
    }

    public function findDefaultPath() : ?Path
    {
        return $this->pathRepository->findDefaultPath();
    }
}
