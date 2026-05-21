<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\Level;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findEventInLevel(?Level $level, int $sequenceNumber): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.level = :level')
            ->andWhere('e.sequenceNumber = :sequenceNumber')
            ->setParameter('level', $level)
            ->setParameter('sequenceNumber', $sequenceNumber)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
