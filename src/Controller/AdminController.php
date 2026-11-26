<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Session;
use App\Core\View;
use App\Model\AgenceModel;
use App\Model\TrajetModel;
use App\Model\UserModel;
use PDOException;

/** Tableau de bord administrateur. */
final class AdminController extends Controller
{
    public function tableau(): void
    {
        $this->requireAdmin();
        View::render('admin/tableau');
    }

    public function utilisateurs(): void
    {
        $this->requireAdmin();
        View::render('admin/utilisateurs', ['utilisateurs' => (new UserModel())->all()]);
    }

    public function agences(): void
    {
        $this->requireAdmin();
        View::render('admin/agences', ['agences' => (new AgenceModel())->all()]);
    }

    public function agenceCreer(): void
    {
        $this->requireAdmin();
        $this->checkCsrf();
        $nom = trim((string) ($_POST['nom'] ?? ''));
        $error = $this->checkNom($nom);
        if ($error === null) {
            try {
                (new AgenceModel())->create($nom);
                Session::flash('success', "L'agence a bien été créée.");
            } catch (PDOException) {
                $error = 'Cette agence existe déjà.';
            }
        }
        if ($error !== null) {
            Session::flash('danger', $error);
        }
        $this->redirect('/admin/agences');
    }

    public function agenceModifier(string $id): void
    {
        $this->requireAdmin();
        $this->checkCsrf();
        $nom = trim((string) ($_POST['nom'] ?? ''));
        $error = $this->checkNom($nom);
        if ($error === null) {
            try {
                (new AgenceModel())->update((int) $id, $nom);
                Session::flash('success', "L'agence a bien été modifiée.");
            } catch (PDOException) {
                $error = 'Ce nom est déjà utilisé par une autre agence.';
            }
        }
        if ($error !== null) {
            Session::flash('danger', $error);
        }
        $this->redirect('/admin/agences');
    }

    public function agenceSupprimer(string $id): void
    {
        $this->requireAdmin();
        $this->checkCsrf();
        try {
            (new AgenceModel())->delete((int) $id);
            Session::flash('success', "L'agence a bien été supprimée.");
        } catch (PDOException) {
            Session::flash('danger', 'Suppression impossible : des trajets utilisent cette agence.');
        }
        $this->redirect('/admin/agences');
    }

    public function trajets(): void
    {
        $this->requireAdmin();
        View::render('admin/trajets', ['trajets' => (new TrajetModel())->all()]);
    }

    public function trajetSupprimer(string $id): void
    {
        $this->requireAdmin();
        $this->checkCsrf();
        (new TrajetModel())->delete((int) $id);
        Session::flash('success', 'Le trajet a bien été supprimé.');
        $this->redirect('/admin/trajets');
    }

    private function checkNom(string $nom): ?string
    {
        if ($nom === '' || mb_strlen($nom) > 100) {
            return "Le nom de l'agence est obligatoire (100 caractères maximum).";
        }

        return null;
    }
}
