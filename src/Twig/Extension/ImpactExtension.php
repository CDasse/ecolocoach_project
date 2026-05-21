<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\ImpactExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ImpactExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('format_co2', [ImpactExtensionRuntime::class, 'formatCo2']),
        ];
    }
}
