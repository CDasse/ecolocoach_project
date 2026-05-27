<?php

namespace App\Service;

use App\Entity\MessageEncouragement;
use App\Repository\MessageEncouragementRepository;

readonly class MessageEncouragementService
{
    public function __construct(
        private MessageEncouragementRepository $messageEncouragementRepository,
    )
    {
    }

    /**
     * Resolves and fetches a random encouragement message.
     * To optimize database performance and memory allocation, this method avoids
     * loading the entire table into memory. Instead, it counts the table rows,
     * generates a random offset in PHP, and queries exactly one specific row.
     *
     */
    public function findOneRandomMessageEncouragement(): ?MessageEncouragement
    {
        $count = $this->messageEncouragementRepository->findNumberOfMessagesEncouragement();

        if ($count === 0) {
            return null;
        }

        $randomOffset = rand(0, $count - 1);
        return $this->messageEncouragementRepository->findOneMessageEncouragement($randomOffset);
    }
}
