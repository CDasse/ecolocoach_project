<?php

namespace App\Repository;

use App\Entity\EventPage;
use App\Entity\EventPart;
use App\Enum\EventPartType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EventPart>
 */
class EventPartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventPart::class);
    }

    public function findEventPartsInEventPage(EventPage $eventPage): array
    {
        return $this->createQueryBuilder('ep')
            ->andWhere('ep.eventPage = :eventPage')
            ->setParameter('eventPage', $eventPage)
            ->orderBy('ep.sequenceNumber', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findRightAnswerOfPage(EventPage $page): ?EventPart
    {
        return $this->createQueryBuilder('ep')
            ->andWhere('ep.eventPartType = :eventPartType')
            ->andWhere('ep.eventPage = :eventPage')
            ->setParameter('eventPartType', EventPartType::ANSWER)
            ->setParameter('eventPage', $page)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
