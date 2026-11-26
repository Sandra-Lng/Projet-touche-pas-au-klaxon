<?php

declare(strict_types=1);

namespace App\Model;

use App\Core\Database;

/** Accès aux agences (villes). */
final class AgenceModel
{
    /** @return list<array<string, mixed>> */
    public function all(): array
    {
        return Database::getConnection()->query('SELECT id, nom FROM agence ORDER BY nom')->fetchAll();
    }

    /** @return array<string, mixed>|null */
    public function find(int $id): ?array
    {
        $st = Database::getConnection()->prepare('SELECT id, nom FROM agence WHERE id = :id');
        $st->execute(['id' => $id]);
        $row = $st->fetch();

        return is_array($row) ? $row : null;
    }

    public function create(string $nom): int
    {
        $pdo = Database::getConnection();
        $pdo->prepare('INSERT INTO agence (nom) VALUES (:nom)')->execute(['nom' => $nom]);

        return (int) $pdo->lastInsertId();
    }

    public function update(int $id, string $nom): bool
    {
        return Database::getConnection()
            ->prepare('UPDATE agence SET nom = :nom WHERE id = :id')
            ->execute(['nom' => $nom, 'id' => $id]);
    }

    public function delete(int $id): bool
    {
        $st = Database::getConnection()->prepare('DELETE FROM agence WHERE id = :id');
        $st->execute(['id' => $id]);

        return $st->rowCount() > 0;
    }
}
