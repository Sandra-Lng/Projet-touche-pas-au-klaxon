<?php

declare(strict_types=1);

namespace App\Model;

use App\Core\Database;

/** Accès en lecture aux utilisateurs (données issues du SI RH). */
final class UserModel
{
    /** @return array<string, mixed>|null */
    public function findByEmail(string $email): ?array
    {
        $st = Database::getConnection()->prepare('SELECT * FROM utilisateur WHERE email = :email');
        $st->execute(['email' => $email]);
        $row = $st->fetch();

        return is_array($row) ? $row : null;
    }

    /** @return list<array<string, mixed>> */
    public function all(): array
    {
        return Database::getConnection()
            ->query('SELECT id, nom, prenom, telephone, email, role FROM utilisateur ORDER BY nom, prenom')
            ->fetchAll();
    }
}
