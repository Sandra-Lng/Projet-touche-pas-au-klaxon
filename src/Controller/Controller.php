<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Session;
use App\Core\View;

/** Outils communs aux contrôleurs (redirection, droits d'accès, CSRF). */
abstract class Controller
{
    protected function redirect(string $path): never
    {
        header('Location: ' . $path);
        exit;
    }

    protected function abort(int $code, string $message): never
    {
        http_response_code($code);
        View::render('erreur', ['code' => $code, 'message' => $message]);
        exit;
    }

    /** @return array{id: int, prenom: string, nom: string, email: string, telephone: string, role: string} */
    protected function requireLogin(): array
    {
        $user = Session::user();
        if ($user === null) {
            Session::flash('warning', 'Veuillez vous connecter pour accéder à cette page.');
            $this->redirect('/connexion');
        }

        return $user;
    }

    /** @return array{id: int, prenom: string, nom: string, email: string, telephone: string, role: string} */
    protected function requireAdmin(): array
    {
        $user = $this->requireLogin();
        if ($user['role'] !== 'admin') {
            $this->abort(403, 'Accès réservé aux administrateurs.');
        }

        return $user;
    }

    protected function checkCsrf(): void
    {
        $token = $_POST['csrf'] ?? null;
        if (!Session::verifyCsrf(is_string($token) ? $token : null)) {
            $this->abort(419, 'Session expirée ou jeton invalide. Rechargez la page.');
        }
    }
}
