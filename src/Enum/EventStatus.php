<?php

namespace App\Enum;

enum EventStatus: string
{
    /**
     * The event is currently available and unlocked for the user.
     */
    case ACTIVE = 'En cours';

    /**
     * The challenge has been accepted by the user but not realize yet.
     */
    case ACCEPTED = 'Accepté';

    /**
     * The challenge has been dismissed or skipped, after being accepted, by the user for now.
     */
    case REFUSED = 'Refusé';

    /**
     * The event has been successfully completed.
     * For a lesson, it means the user reached the final page and validated the quiz.
     * For a challenge, it means the user successfully carried out the action in real life.
     */
    case FINISHED = 'Terminé';
}
