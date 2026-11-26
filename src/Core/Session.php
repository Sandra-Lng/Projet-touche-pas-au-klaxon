<?php

declare(strict_types=1);

namespace App\Core;

/** Gestion de la session : utilisateur connecté, messages flash, jeton CSRF. */
final class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /** @return array{id: int, prenom: string, nom: string, email: string, telephone: string, role: string}|null */
    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function isAdmin(): bool
    {
        return (self::user()['role'] ?? '') === 'admin';
    }

    /** @param array<string, mixed> $u */
    public static function login(array $u): void
    {
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => (int) $u['id'],
            'prenom' => (string) $u['prenom'],
            'nom' => (string) $u['nom'],
            'email' => (string) $u['email'],
            'telephone' => (string) $u['telephone'],
            'role' => (string) $u['role'],
        ];
    }

    public static function logout(): void
    {
        unset($_SESSION['user']);
        session_regenerate_id(true);
    }

    public static function flash(string $type, string $message): void
    {
        $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
    }

    /** @return list<array{type: string, message: string}> */
    public static function pullFlash(): array
    {
        $flash = $_SESSION['flash'] ?? [];
        unset($_SESSION['flash']);

        return $flash;
    }

    public static function csrfToken(): string
    {
        if (!isset($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf'];
    }

    public static function verifyCsrf(?string $token): bool
    {
        return is_string($token) && hash_equals(self::csrfToken(), $token);
    }
}
