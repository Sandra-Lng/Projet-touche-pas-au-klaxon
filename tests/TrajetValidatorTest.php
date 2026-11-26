<?php

declare(strict_types=1);

use App\Validator\TrajetValidator;
use PHPUnit\Framework\TestCase;

final class TrajetValidatorTest extends TestCase
{
    /** @param array<string, string> $override */
    private function validate(array $override = []): array
    {
        $in = array_merge([
            'agence_depart_id' => '1', 'agence_arrivee_id' => '2',
            'date_depart' => '2030-01-10T08:00', 'date_arrivee' => '2030-01-10T10:00',
            'places_total' => '4', 'places_dispo' => '3',
        ], $override);

        return TrajetValidator::validate($in, [1, 2, 3], new DateTimeImmutable('2029-12-01 00:00:00'));
    }

    public function testTrajetValide(): void
    {
        $r = $this->validate();
        $this->assertSame([], $r['errors']);
        $this->assertSame('2030-01-10 08:00:00', $r['data']['date_depart']);
    }

    public function testAgencesIdentiques(): void
    {
        $this->assertNotEmpty($this->validate(['agence_arrivee_id' => '1'])['errors']);
    }

    public function testArriveeAvantDepart(): void
    {
        $this->assertNotEmpty($this->validate(['date_arrivee' => '2030-01-10T07:00'])['errors']);
    }

    public function testDepartDansLePasse(): void
    {
        $this->assertNotEmpty($this->validate(['date_depart' => '2020-01-10T08:00', 'date_arrivee' => '2020-01-10T09:00'])['errors']);
    }

    public function testPlacesDisponiblesSuperieuresAuTotal(): void
    {
        $this->assertNotEmpty($this->validate(['places_dispo' => '9'])['errors']);
    }

    public function testAgenceInconnue(): void
    {
        $this->assertNotEmpty($this->validate(['agence_depart_id' => '99'])['errors']);
    }
}
