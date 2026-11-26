<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Session;
use App\Core\View;
use App\Model\UserModel;

/** Connexion et déconnexion. */
final class AuthController extends Controller
{
    public function loginForm(): void
    {
        if (Session::user() !== null) {
            $this->redirect('/');
        }
        View::render('connexion', ['email' => '']);
    }

    public function login(): void
    {
        $this->checkCsrf();
        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        $user = (new UserModel())->findByEmail($email);
        if ($user === null || !password_verify($password, (string) $user['mot_de_passe'])) {
            Session::flash('danger', 'Identifiant ou mot de passe incorrect.');
            View::render('connexion', ['email' => $email]);

            return;
        }

        Session::login($user);
        Session::flash('success', 'Bienvenue ' . $user['prenom'] . ' !');
        $this->redirect($user['role'] === 'admin' ? '/admin' : '/');
    }

    public function logout(): void
    {
        $this->checkCsrf();
        Session::logout();
        Session::flash('info', 'Vous avez été déconnecté.');
        $this->redirect('/');
    }
}
