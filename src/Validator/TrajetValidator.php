<?php

declare(strict_types=1);

namespace App\Validator;

use DateTimeImmutable;

/** Contrôles de cohérence d'un trajet. */
final class TrajetValidator
{
    /**
     * @param array<string, mixed> $in données brutes du formulaire
     * @param list<int> $agenceIds identifiants d'agences valides
     *
     * @return array{errors: list<string>, data: array<string, mixed>}
     */
    public static function validate(array $in, array $agenceIds, DateTimeImmutable $now): array
    {
        $errors = [];
        $dep = (int) ($in['agence_depart_id'] ?? 0);
        $arr = (int) ($in['agence_arrivee_id'] ?? 0);

        if (!in_array($dep, $agenceIds, true)) {
            $errors[] = "L'agence de départ est invalide.";
        }
        if (!in_array($arr, $agenceIds, true)) {
            $errors[] = "L'agence d'arrivée est invalide.";
        }
        if ($dep === $arr && $dep !== 0) {
            $errors[] = "L'agence de départ et l'agence d'arrivée doivent être différentes.";
        }

        $d1 = self::parseDate($in['date_depart'] ?? null);
        $d2 = self::parseDate($in['date_arrivee'] ?? null);
        if ($d1 === null) {
            $errors[] = 'La date de départ est invalide.';
        }
        if ($d2 === null) {
            $errors[] = "La date d'arrivée est invalide.";
        }
        if ($d1 !== null && $d2 !== null && $d2 <= $d1) {
            $errors[] = "L'arrivée doit avoir lieu après le départ.";
        }
        if ($d1 !== null && $d1 <= $now) {
            $errors[] = 'Le départ doit être dans le futur.';
        }

        $total = filter_var($in['places_total'] ?? null, FILTER_VALIDATE_INT);
        $dispo = filter_var($in['places_dispo'] ?? null, FILTER_VALIDATE_INT);
        if ($total === false || $total < 1) {
            $errors[] = 'Le nombre total de places doit être un entier supérieur ou égal à 1.';
        }
        if ($dispo === false || $dispo < 0) {
            $errors[] = 'Le nombre de places disponibles doit être un entier positif ou nul.';
        } elseif ($total !== false && $dispo > $total) {
            $errors[] = 'Les places disponibles ne peuvent pas dépasser le nombre total de places.';
        }

        return [
            'errors' => $errors,
            'data' => [
                'agence_depart_id' => $dep,
                'agence_arrivee_id' => $arr,
                'date_depart' => $d1 !== null ? $d1->format('Y-m-d H:i:s') : '',
                'date_arrivee' => $d2 !== null ? $d2->format('Y-m-d H:i:s') : '',
                'places_total' => $total === false ? 0 : $total,
                'places_dispo' => $dispo === false ? 0 : $dispo,
            ],
        ];
    }

    private static function parseDate(mixed $value): ?DateTimeImmutable
    {
        if (!is_string($value)) {
            return null;
        }
        $date = DateTimeImmutable::createFromFormat('!Y-m-d\TH:i', $value);

        return $date === false ? null : $date;
    }
}
