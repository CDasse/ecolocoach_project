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
}
