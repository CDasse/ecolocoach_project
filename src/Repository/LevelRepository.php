<?php

namespace App\Repository;

use App\Entity\Level;
use App\Entity\Path;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Level>
 */
class LevelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Level::class);
    }

    /**
     * Resolves a single specific Level attached to a learning Path by its sequence order index.
     */
    public function findOneLevelInPath(Path $path, int $sequenceNumber): ?Level
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.path = :path')
            ->andWhere('l.sequenceNumber = :sequenceNumber')
            ->setParameter('path', $path)
            ->setParameter('sequenceNumber', $sequenceNumber)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
