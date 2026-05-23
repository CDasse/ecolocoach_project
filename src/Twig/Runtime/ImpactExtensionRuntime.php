<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class ImpactExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    /**
     * Formats a raw CO2 numeric weight into a human-readable French format text string.
     *  Automatically handles null/zero guardrails and dynamically switches unit metrics
     *  from kilograms to metric tonnes when thresholds are breached.
     */
    public function formatCo2(?float $co2Impact) : string
    {
        if ($co2Impact === null || $co2Impact === 0.0) {
            return "0,0 kg";
        }

        if ($co2Impact >= 1000) {
            $convertedValue = $co2Impact / 1000;
            $unit = $convertedValue >= 2 ? " tonnes" : " tonne";

            return number_format($convertedValue, 2, ",", " ") . $unit;
        }

        return number_format($co2Impact, 2, ",", " ") . " kg";
    }
}
