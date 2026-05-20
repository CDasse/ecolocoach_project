<?php

namespace App\Enum;

enum EventPartType: string
{
    case PICTURE = 'Image';
    case QUESTION = 'Question';
    case ANSWER = 'Réponse';
    case DESCRIPTION = 'Descritpion';
    case TAG = 'Tag';
    case LABEL = 'Label';
}
