<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Session;
use App\Core\View;
use App\Model\AgenceModel;
use App\Model\TrajetModel;
use App\Validator\TrajetValidator;
use DateTimeImmutable;

/** Liste, création, modification et suppression des trajets. */
final class TrajetController extends Controller
{
    public function index(): void
    {
        $trajets = (new TrajetModel())->upcomingAvailable(new DateTimeImmutable());
        View::render('accueil', ['trajets' => $trajets, 'user' => Session::user()]);
    }

    public function creerForm(): void
    {
        $user = $this->requireLogin();
        $this->renderForm($user, null, null, []);
    }

    public function creer(): void
    {
        $user = $this->requireLogin();
        $this->checkCsrf();
        $result = $this->validate();
        if ($result['errors'] !== []) {
            $this->renderForm($user, null, $result['data'], $result['errors']);

            return;
        }

        (new TrajetModel())->create($result['data'], $user['id']);
        Session::flash('success', 'Le trajet a bien été créé.');
        $this->redirect('/');
    }

    public function modifierForm(string $id): void
    {
        $user = $this->requireLogin();
        $trajet = $this->findOwned((int) $id, $user['id']);
        $this->renderForm($user, (int) $trajet['id'], $trajet, []);
    }

    public function modifier(string $id): void
    {
        $user = $this->requireLogin();
        $this->checkCsrf();
        $this->findOwned((int) $id, $user['id']);
        $result = $this->validate();
        if ($result['errors'] !== []) {
            $this->renderForm($user, (int) $id, $result['data'], $result['errors']);

            return;
        }

        (new TrajetModel())->update((int) $id, $result['data']);
        Session::flash('success', 'Le trajet a bien été modifié.');
        $this->redirect('/');
    }

    public function supprimer(string $id): void
    {
        $user = $this->requireLogin();
        $this->checkCsrf();
        $this->findOwned((int) $id, $user['id']);
        (new TrajetModel())->delete((int) $id);
        Session::flash('success', 'Le trajet a bien été supprimé.');
        $this->redirect('/');
    }

    /**
     * Récupère un trajet dont l'utilisateur est l'auteur (404 / 403 sinon).
     *
     * @return array<string, mixed>
     */
    private function findOwned(int $id, int $userId): array
    {
        $trajet = (new TrajetModel())->find($id);
        if ($trajet === null) {
            $this->abort(404, "Ce trajet n'existe pas.");
        }
        if ((int) $trajet['auteur_id'] !== $userId) {
            $this->abort(403, "Vous n'êtes pas l'auteur de ce trajet.");
        }

        return $trajet;
    }

    /** @return array{errors: list<string>, data: array<string, mixed>} */
    private function validate(): array
    {
        $ids = array_map(static fn (array $a): int => (int) $a['id'], (new AgenceModel())->all());

        return TrajetValidator::validate($_POST, $ids, new DateTimeImmutable());
    }

    /**
     * @param array{id: int, prenom: string, nom: string, email: string, telephone: string, role: string} $user
     * @param array<string, mixed>|null $trajet
     * @param list<string> $errors
     */
    private function renderForm(array $user, ?int $trajetId, ?array $trajet, array $errors): void
    {
        View::render('trajet_form', [
            'user' => $user,
            'trajetId' => $trajetId,
            'trajet' => $trajet,
            'errors' => $errors,
            'agences' => (new AgenceModel())->all(),
        ]);
    }
}
