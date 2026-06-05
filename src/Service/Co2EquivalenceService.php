<?php

namespace App\Service;

// TODO : Si l'application prend de l'ampleur, migrer ce catalogue vers une table en base de données


/**
 * Provides a gamified calculation engine that translates abstract carbon emission values (kg CO2)
 * into human-readable, real-world analogies. Parses a static comparison directory to select
 * and format a contextual equivalence based on the user's aggregated environmental score impact.
 */
class Co2EquivalenceService
{
    /**
     * Stores the mathematical transformation coefficients (factors), graphical assets (icons),
     * translation masks (templates), and boundaries (min/max values) required to filter
     * and scale realistic ecological metrics against user datasets.
     */
    private const array CATALOGUE = [
        'terre' => [
            'factor' => 7570,
            'icon' => '🌍',
            'template' => 'L\'équivalent de %s tour de la terre en voiture.',
            'max_value' => 500,
        ],
        'avion' => [
            'factor' => 2060,
            'icon' => '✈️',
            'template' => 'L\'équivalent de %s A/R entre Paris et New-York en avion.',
            'max_value' => 500,
        ],
        'voiture' => [
            'factor' => 0.142,
            'icon' => '🚗',
            'template' => 'L\'équivalent de %s kms en voiture thermique.',
            'max_value' => 500,
        ],
        'smartphone' => [
            'factor' => 79.3,
            'icon' => '📱',
            'template' => 'L\'équivalent de la fabrication de %s smartphones.',
            'max_value' => 500,
        ],
        'repas_végétarien' => [
            'factor' => 0.85,
            'icon' => '🥗',
            'template' => 'L\'équivalent de %s repas végétariens.',
            'max_value' => 200,
        ],
        'arbre' => [
            'factor' => 25,
            'icon' => '🌳',
            'template' => 'L\'équivalent de l\'absorption de %s arbres pendant 1 an.',
            'max_value' => 200,
        ],
        'jean' => [
            'factor' => 25.1,
            'icon' => '👖',
            'template' => 'L\'équivalent de la fabrication de %s jeans.',
            'max_value' => 200,
        ],
        'streaming' => [
            'factor' => 7.86,
            'icon' => '📺',
            'template' => 'L\'équivalent de %s intégrale de friends en streaming.',
            'max_value' => 200,
        ],
        'repas_porc' => [
            'factor' => 1.65,
            'icon' => '🥩',
            'template' => 'L\'équivalent de %s repas avec du porc.',
            'max_value' => 200,
        ]
    ];

    /**
     * Generates a randomized, scaled ecological comparison dataset.
     * Computes the mathematical ratios for each registered analogy, filters entries
     * that fall outside their realistic boundaries, and picks one random formatted payload.
     */
    public function getCo2Equivalence(float $userCo2Impact): ?array
    {
        if ($userCo2Impact < 1) {
            return null;
        }

        $eligibleComparaison = [];

        foreach (self::CATALOGUE as $data) {
            $calculatedValue = $userCo2Impact / $data["factor"];

            $minValue = 1;

            if ($calculatedValue >= $minValue && $calculatedValue <= $data["max_value"]) {
                $formattedValue = number_format($calculatedValue, 0, ",", " ");

                $eligibleComparaison[] = [
                    'icon' => $data['icon'],
                    'text' => sprintf($data['template'], $formattedValue),
                ];
            }
        }

        if (empty($eligibleComparaison)) {
            return null;
        }

        return $eligibleComparaison[array_rand($eligibleComparaison)];
    }
}
