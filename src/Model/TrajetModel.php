<?php

declare(strict_types=1);

namespace App\Model;

use App\Core\Database;
use DateTimeImmutable;

/** Accès aux trajets. */
final class TrajetModel
{
    private const SELECT = 'SELECT t.*, ad.nom AS agence_depart, aa.nom AS agence_arrivee,
            u.prenom AS auteur_prenom, u.nom AS auteur_nom,
            u.telephone AS auteur_telephone, u.email AS auteur_email
        FROM trajet t
        JOIN agence ad ON ad.id = t.agence_depart_id
        JOIN agence aa ON aa.id = t.agence_arrivee_id
        JOIN utilisateur u ON u.id = t.auteur_id';

    /**
     * Trajets à venir avec des places disponibles, par date de départ croissante.
     *
     * @return list<array<string, mixed>>
     */
    public function upcomingAvailable(DateTimeImmutable $now): array
    {
        $st = Database::getConnection()->prepare(
            self::SELECT . ' WHERE t.places_dispo > 0 AND t.date_depart > :now ORDER BY t.date_depart ASC'
        );
        $st->execute(['now' => $now->format('Y-m-d H:i:s')]);

        return $st->fetchAll();
    }

    /** @return list<array<string, mixed>> */
    public function all(): array
    {
        return Database::getConnection()->query(self::SELECT . ' ORDER BY t.date_depart ASC')->fetchAll();
    }

    /** @return array<string, mixed>|null */
    public function find(int $id): ?array
    {
        $st = Database::getConnection()->prepare(self::SELECT . ' WHERE t.id = :id');
        $st->execute(['id' => $id]);
        $row = $st->fetch();

        return is_array($row) ? $row : null;
    }

    /** @param array<string, mixed> $d données validées par TrajetValidator */
    public function create(array $d, int $auteurId): int
    {
        $pdo = Database::getConnection();
        $pdo->prepare(
            'INSERT INTO trajet (agence_depart_id, agence_arrivee_id, date_depart, date_arrivee,
                places_total, places_dispo, auteur_id)
             VALUES (:dep, :arr, :dd, :da, :pt, :pd, :aut)'
        )->execute([
            'dep' => $d['agence_depart_id'], 'arr' => $d['agence_arrivee_id'],
            'dd' => $d['date_depart'], 'da' => $d['date_arrivee'],
            'pt' => $d['places_total'], 'pd' => $d['places_dispo'], 'aut' => $auteurId,
        ]);

        return (int) $pdo->lastInsertId();
    }

    /** @param array<string, mixed> $d données validées par TrajetValidator */
    public function update(int $id, array $d): bool
    {
        return Database::getConnection()->prepare(
            'UPDATE trajet SET agence_depart_id = :dep, agence_arrivee_id = :arr, date_depart = :dd,
                date_arrivee = :da, places_total = :pt, places_dispo = :pd WHERE id = :id'
        )->execute([
            'dep' => $d['agence_depart_id'], 'arr' => $d['agence_arrivee_id'],
            'dd' => $d['date_depart'], 'da' => $d['date_arrivee'],
            'pt' => $d['places_total'], 'pd' => $d['places_dispo'], 'id' => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $st = Database::getConnection()->prepare('DELETE FROM trajet WHERE id = :id');
        $st->execute(['id' => $id]);

        return $st->rowCount() > 0;
    }
}
