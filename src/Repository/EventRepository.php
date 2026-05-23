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

    /**
     * Locates a single explicit Event within a target level by its sequence rank index.
     */
    public function findOneEventInLevel(Level $level, int $sequenceNumber): ?Event
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

    /**
     * Returns the full collection of Events belonging to a precise structural Level.
     * The results are ordered ascendingly by sequence number.
     */
    public function findEventsInLevel(Level $level): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.level = :level')
            ->setParameter('level', $level)
            ->orderBy('e.sequenceNumber', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Attempts to resolve the next logical chronological Event inside the player path.
     * Note: Currently locked by design to evaluate sequence metrics strictly within the same Level.
     */
    public function findNextEvent(Event $currentEvent): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.level = :level')
            ->andWhere('e.sequenceNumber = :sequenceNumber')
            ->setParameter('level', $currentEvent->getLevel())
            ->setParameter('sequenceNumber', $currentEvent->getSequenceNumber() + 1)
            ->getQuery()
            ->getOneOrNullResult();
    }


}
