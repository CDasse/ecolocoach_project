<?php

namespace App\Enum;

/**
 * Categorizes the core operational nature of timeline roadmap steps.
 * Distinguishes between theoretical, multipage modules (LESSON)
 * and practical, actionable environmental tasks (DEFI) that yields carbon telemetry points.
 */
enum EventType: string
{
    case LESSON = 'leçon';
    case DEFI = 'défi';
}
