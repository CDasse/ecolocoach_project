<?php

namespace App\Repository;

use App\Entity\MessageEncouragement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MessageEncouragement>
 */
class MessageEncouragementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessageEncouragement::class);
    }

    /**
     * Counts the total number of encouragement messages available in the database.
     * Used as the upper bound for the random offset calculation.
     */
    public function findNumberOfMessagesEncouragement(): int
    {
        return $this->createQueryBuilder('m')
            ->select('COUNT(m.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Retrieves a single encouragement message using an offset.
     */
    public function findOneMessageEncouragement(int $offset): ?MessageEncouragement
    {
        return $this->createQueryBuilder('m')
            ->setMaxResults(1)
            ->setFirstResult($offset)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
