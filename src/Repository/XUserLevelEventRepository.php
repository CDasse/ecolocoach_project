<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\EventPage;
use App\Entity\EventPart;
use App\Entity\User;
use App\Entity\XUserLevelEvent;
use App\Enum\EventPartType;
use App\Enum\EventStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<XUserLevelEvent>
 */
class XUserLevelEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, XUserLevelEvent::class);
    }

    /**
     * Fetches the unique active progression row for a given user.
     * This core query is leveraged by services to extract either the current Event or Level.
     */
    public function findUserActiveProgression(User $user): ?XUserLevelEvent
    {
        return $this->createQueryBuilder('x')
            ->andWhere('x.targetUser = :user')
            ->andWhere('x.eventStatus = :status')
            ->setParameter('user', $user)
            ->setParameter('status', EventStatus::ACTIVE)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Pinpoints a precise structural progression entry matching a distinct user and event combination.
     * Crucial for reviewing completion contexts before status transitions or loading custom view states.
     */
    public function findProgression(User $user, Event $event): ?XUserLevelEvent
    {
        return $this->createQueryBuilder('x')
            ->andWhere('x.targetUser = :user')
            ->andWhere('x.event = :event')
            ->setParameter('user', $user)
            ->setParameter('event', $event)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Retrieves the list of accepted but unfinished challenges for a specific user,
     * loading all necessary card data (image, label, description).
     */
    public function findAcceptedChallenges(User $user): array
    {
        return $this->createQueryBuilder('x')
            ->innerJoin('x.event', 'e')
            ->addSelect('e')

            ->innerJoin(EventPage::class, 'ep', 'WITH', 'ep.event = e.id')

            ->innerJoin(EventPart::class, 'eprt', 'WITH', 'eprt.eventPage = ep.id')
            ->addSelect('eprt')


            ->andWhere('x.targetUser = :user')
            ->andWhere('x.eventStatus = :status')
            ->andWhere('eprt.eventPartType IN (:types)')

            ->setParameter('user', $user)
            ->setParameter('status', EventStatus::ACCEPTED)
            ->setParameter('types', [EventPartType::PICTURE, EventPartType::LABEL, EventPartType::DESCRIPTION] )
            ->getQuery()
            ->getResult();
    }
}
