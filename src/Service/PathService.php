<?php

namespace App\Service;

use App\Entity\Path;
use App\Repository\PathRepository;

class PathService
{
    public function __construct(
        private readonly PathRepository $pathRepository,
    )
    {
    }

    public function findDefaultPath() : ?Path {
        return $this->pathRepository->findDefaultPath();
    }
}
