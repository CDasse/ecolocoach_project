<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\Level;
use App\Entity\User;
use App\Entity\XUserLevelEvent;
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
}
