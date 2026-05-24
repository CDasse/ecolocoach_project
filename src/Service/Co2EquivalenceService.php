<?php

namespace App\Service;

class Co2EquivalenceService
{
    private const CATALOGUE = [
        'terre' => [
            'factor' => 7570,
            'icon' => '🌍',
            'template' => 'L\'équivalent de %s tour de la terre en voiture.',
            'min_value' => 1,
            'max_value' => 500,
        ],
        'avion' => [
            'factor' => 2060,
            'icon' => '✈️',
            'template' => 'L\'équivalent de %s A/R entre Paris et New-York en avion.',
            'min_value' => 1,
            'max_value' => 500,
        ],
        'voiture' => [
            'factor' => 0.142,
            'icon' => '🚗',
            'template' => 'L\'équivalent de %s kms en voiture thermique.',
            'min_value' => 1,
            'max_value' => 500,
        ],
        'smartphone' => [
            'factor' => 79.3,
            'icon' => '📱',
            'template' => 'L\'équivalent de la fabrication de %s smartphones.',
            'min_value' => 1,
            'max_value' => 500,
        ],
        'repas_végétarien' => [
            'factor' => 0.85,
            'icon' => '🥗',
            'template' => 'L\'équivalent de %s repas végétariens.',
            'min_value' => 1,
            'max_value' => 200,
        ],
        'arbre' => [
            'factor' => 25,
            'icon' => '🌳',
            'template' => 'L\'équivalent de l\'absorption de %s arbres pendant 1 an.',
            'min_value' => 1,
            'max_value' => 200,
        ],
        'jean' => [
            'factor' => 25.1,
            'icon' => '👖',
            'template' => 'L\'équivalent de la fabrication de %s jeans.',
            'min_value' => 1,
            'max_value' => 200,
        ],
        'streaming' => [
            'factor' => 7.86,
            'icon' => '📺',
            'template' => 'L\'équivalent de %s intégrale de friends en streaming.',
            'min_value' => 1,
            'max_value' => 200,
        ],
        'repas_porc' => [
            'factor' => 1.65,
            'icon' => '🥩',
            'template' => 'L\'équivalent de %s repas avec du porc.',
            'min_value' => 1,
            'max_value' => 200,
        ]
    ];

}
