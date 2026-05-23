<?php

namespace App\Repository;

use App\Entity\Path;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Path>
 */
class PathRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Path::class);
    }

    /**
     * Resolves the primary default learning roadmap used to onboard new accounts.
     * NOTE: The target path name is currently hardcoded for initial deployment.
     * In a future release, this logic will be refactored to support a dynamic feature
     * allowing users to actively select their preferred starting path from an available list.
     */
    public function findDefaultPath(): ?Path
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name = :name')
            ->setParameter('name', "Éco-Pionnier : Les 4 Piliers")
            ->getQuery()
            ->getOneOrNullResult();
    }
}
