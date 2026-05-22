<?php

namespace App\Enum;

enum EventStatus: string
{
    case ACTIVE = 'En cours';
    case ACCEPTED = 'Accepté';
    case REFUSED = 'Refusé';
    case FINISHED = 'Terminé';
}
