<?php

namespace App\Enum;

enum EventStatus: string
{
    case ACTIVE = 'En cours';
    case FINISHED = 'Terminé';
    case REFUSED = 'Refusé';
}
