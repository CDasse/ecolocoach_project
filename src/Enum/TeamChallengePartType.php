<?php

namespace App\Enum;

enum TeamChallengePartType: string
{
    case PICTURE = 'Image';
    case LABEL = 'Label';
    case DESCRIPTION = 'Description';
    case TAG = 'Tag';
}
