<?php

namespace App\Tests\Service;

use App\Service\Co2EquivalenceService;
use PHPUnit\Framework\TestCase;

class Co2EquivalenceServiceTest extends TestCase
{
    private Co2EquivalenceService $service;

    /**
     * Scenario 1: Verifies that the service returns null when the user's CO2 impact
     * is strictly less than the minimum required threshold (1 kg).
     */
    public function testReturnsNullIfImpactIsLessThanOne(): void
    {
        $co2Impact = 0.5;

        $result = $this->service->getCo2Equivalence($co2Impact);

        $this->assertNull($result);
    }

    /**
     * Scenario 2: Ensures that the service returns null when the CO2 impact is too high,
     * causing all calculated equivalences to exceed their defined maximum boundaries
     * in the catalog.
     */
    public function testReturnsNullIfNoEquivalenceIsEligible(): void
    {
        $co2Impact = 3785001;

        $result = $this->service->getCo2Equivalence($co2Impact);

        $this->assertNull($result);
    }

    /**
     * Scenario 3: Asserts that providing a valid CO2 impact yields a properly formatted
     * associative array. The returned array must match one of the expected eligible
     * items, containing both an 'icon' and a 'text' representation.
     */
    public function testReturnsValidEquivalenceArray(): void
    {
        $co2Impact = 100;
        $arrayOfPossibleEquivalences = [
            ['icon' => '🚗', 'text' => 'L\'équivalent de 704.2 kms en voiture thermique.'],
            ['icon' => '🥗', 'text' => 'L\'équivalent de 117,6 repas végétariens.'],
            ['icon' => '🌳', 'text' => 'L\'équivalent de l\'absorption de 4,0 arbres pendant 1 an.'],
            ['icon' => '👖', 'text' => 'L\'équivalent de la fabrication de 4,0 jeans.'],
            ['icon' => '📱', 'text' => 'L\'équivalent de la fabrication de 1,3 smartphones.'],
            ['icon' => '📺', 'text' => 'L\'équivalent de 12,7 intégrale de friends en streaming.'],
            ['icon' => '🥩', 'text' => 'L\'équivalent de 60,6 repas avec du porc.'],
        ];

        $result = $this->service->getCo2Equivalence($co2Impact);

        $this->assertContains($result, $arrayOfPossibleEquivalences);
    }

    protected function setUp(): void
    {
        $this->service = new Co2EquivalenceService();
    }
}
