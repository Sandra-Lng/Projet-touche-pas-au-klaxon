<?php

declare(strict_types=1);

use App\Core\Database;
use App\Model\AgenceModel;
use App\Model\TrajetModel;
use PHPUnit\Framework\TestCase;

/** Tests des opérations d'écriture en base (SQLite en mémoire). */
final class EcritureBddTest extends TestCase
{
    protected function setUp(): void
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->exec('CREATE TABLE agence (id INTEGER PRIMARY KEY AUTOINCREMENT, nom TEXT NOT NULL UNIQUE)');
        $pdo->exec('CREATE TABLE utilisateur (id INTEGER PRIMARY KEY AUTOINCREMENT, nom TEXT, prenom TEXT,
            telephone TEXT, email TEXT, mot_de_passe TEXT, role TEXT)');
        $pdo->exec('CREATE TABLE trajet (id INTEGER PRIMARY KEY AUTOINCREMENT, agence_depart_id INTEGER,
            agence_arrivee_id INTEGER, date_depart TEXT, date_arrivee TEXT, places_total INTEGER,
            places_dispo INTEGER, auteur_id INTEGER)');
        $pdo->exec("INSERT INTO agence (nom) VALUES ('Paris'), ('Lyon')");
        $pdo->exec("INSERT INTO utilisateur (nom, prenom, telephone, email, mot_de_passe, role)
            VALUES ('Martin', 'Alex', '0600000000', 'a@b.fr', 'x', 'employe')");
        Database::setConnection($pdo);
    }

    /** @return array<string, mixed> */
    private function data(): array
    {
        return [
            'agence_depart_id' => 1, 'agence_arrivee_id' => 2,
            'date_depart' => '2030-01-10 08:00:00', 'date_arrivee' => '2030-01-10 10:00:00',
            'places_total' => 4, 'places_dispo' => 3,
        ];
    }

    public function testCreationModificationSuppressionAgence(): void
    {
        $model = new AgenceModel();
        $id = $model->create('Nice');
        $this->assertSame('Nice', $model->find($id)['nom'] ?? null);

        $model->update($id, 'Nantes');
        $this->assertSame('Nantes', $model->find($id)['nom'] ?? null);

        $this->assertTrue($model->delete($id));
        $this->assertNull($model->find($id));
    }

    public function testAgenceEnDoublonRefusee(): void
    {
        $this->expectException(PDOException::class);
        (new AgenceModel())->create('Paris');
    }

    public function testCreationModificationSuppressionTrajet(): void
    {
        $model = new TrajetModel();
        $id = $model->create($this->data(), 1);
        $this->assertSame(3, (int) ($model->find($id)['places_dispo'] ?? -1));

        $changes = $this->data();
        $changes['places_dispo'] = 1;
        $model->update($id, $changes);
        $this->assertSame(1, (int) ($model->find($id)['places_dispo'] ?? -1));

        $this->assertTrue($model->delete($id));
        $this->assertNull($model->find($id));
    }
}
