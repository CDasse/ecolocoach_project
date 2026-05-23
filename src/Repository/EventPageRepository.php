<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\EventPage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EventPage>
 */
class EventPageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventPage::class);
    }

    /**
     * Locates a single specific page within an event based on its chronological sequence position.
     * Returns the matching EventPage instance or null if the page rank index does not exist.
     */
    public function findOneEventPageInEvent(Event $event, int $sequenceNumber): ?EventPage
    {
        return $this->createQueryBuilder('ep')
            ->andWhere('ep.event = :event')
            ->andWhere('ep.sequenceNumber = :sequenceNumber')
            ->setParameter('event', $event)
            ->setParameter('sequenceNumber', $sequenceNumber)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Counts the absolute volume of structural content pages linked to a specific event.
     * Used extensively to calculate overall progress ratios and maximum pagination boundaries.
     */
    public function countTotalPagesForEvent(Event $event): int
    {
        return $this->createQueryBuilder('ep')
            ->select('COUNT(ep.id)')
            ->andWhere('ep.event = :event')
            ->setParameter('event', $event)
            ->getQuery()
            ->getSingleScalarResult();
    }

}
