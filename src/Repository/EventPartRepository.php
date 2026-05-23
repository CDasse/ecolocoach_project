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

    /**
     * Retrieves all content components attached to a single specific EventPage.
     * The results are loaded chronologically according to their sequence rank.
     */
    public function findEventPartsInEventPage(EventPage $eventPage): array
    {
        return $this->createQueryBuilder('eprt')
            ->andWhere('eprt.eventPage = :eventPage')
            ->setParameter('eventPage', $eventPage)
            ->orderBy('eprt.sequenceNumber', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Extracts the specific answer validation block associated with an EventPage.
     */
    public function findRightAnswerOfPage(EventPage $page): ?EventPart
    {
        return $this->createQueryBuilder('eprt')
            ->andWhere('eprt.eventPartType = :eventPartType')
            ->andWhere('eprt.eventPage = :eventPage')
            ->setParameter('eventPartType', EventPartType::ANSWER)
            ->setParameter('eventPage', $page)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
