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

        public function findDefaultPath(): ?Path
        {
            return $this->createQueryBuilder('p')
                ->andWhere('p.name = :name')
                ->setParameter('name', "Éco-Pionnier : Les 4 Piliers")
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }
}
