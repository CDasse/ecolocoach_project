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
     * Retrieves the list of challenges for a specific user and with a specific status,
     * loading all necessary card data (co2Impact, image, title, description).
     */
    public function findChallengesByStatus(User $user, EventStatus $eventStatus): array
    {
        return $this->createQueryBuilder('x')
            ->select('
            e.uid AS uid,
            e.co2Impact AS co2Impact,
            MAX(eprt_label.label) AS title,
            MAX(eprt_pic.picturePath) AS picture,
            MAX(eprt_desc.description) AS description
        ')
            ->innerJoin('x.event', 'e')
            ->innerJoin(EventPage::class, 'ep', 'WITH', 'ep.event = e.id')

            ->leftJoin(EventPart::class, 'eprt_label', 'WITH', 'eprt_label.eventPage = ep.id AND eprt_label.eventPartType = :typeLabel')
            ->leftJoin(EventPart::class, 'eprt_pic', 'WITH', 'eprt_pic.eventPage = ep.id AND eprt_pic.eventPartType = :typePic')
            ->leftJoin(EventPart::class, 'eprt_desc', 'WITH', 'eprt_desc.eventPage = ep.id AND eprt_desc.eventPartType = :typeDesc')

            ->andWhere('x.targetUser = :user')
            ->andWhere('x.eventStatus = :status')

            ->groupBy('e.id')

            ->setParameter('user', $user)
            ->setParameter('status', $eventStatus)
            ->setParameter('typeLabel', EventPartType::LABEL)
            ->setParameter('typePic', EventPartType::PICTURE)
            ->setParameter('typeDesc', EventPartType::DESCRIPTION)

            ->getQuery()
            ->getResult();
    }
}
