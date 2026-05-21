<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class ImpactExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function formatCo2(?float $co2Impact) : string
    {
        if ($co2Impact === null || $co2Impact === 0.0) {
            return "0,0 kg";
        }

        if ($co2Impact >= 1000) {
            return number_format($co2Impact / 1000, 2, ",", " ") . " tonnes";
        }

        return number_format($co2Impact, 2, ",", " ") . " kg";
    }
}
