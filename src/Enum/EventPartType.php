<?php

namespace App\Enum;

enum EventPartType: string
{
    case PICTURE = 'Image';
    case QUESTION = 'Question';
    case ANSWER = 'Réponse';
    case DESCRIPTION = 'Description';
    case TAG = 'Tag';
    case LABEL = 'Label';
    case SUBTITLE = 'Sous-titre';
    case SUBDESCRIPTION = 'Sous-description';
}
