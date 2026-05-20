<?php

namespace App\Repository;

use App\Entity\XUserTeamChallengeProgress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<XUserTeamChallengeProgress>
 */
class XUserTeamChallengeProgressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, XUserTeamChallengeProgress::class);
    }

    //    /**
    //     * @return XUserTeamChallengeProgress[] Returns an array of XUserTeamChallengeProgress objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('x')
    //            ->andWhere('x.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('x.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?XUserTeamChallengeProgress
    //    {
    //        return $this->createQueryBuilder('x')
    //            ->andWhere('x.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
