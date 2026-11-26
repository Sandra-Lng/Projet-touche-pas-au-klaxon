<h1 class="h3 mb-4">Trajets proposés</h1>
<?php if ($trajets === []): ?>
  <div class="alert alert-info">Aucun trajet disponible pour le moment.</div>
<?php else: ?>
<div class="table-responsive">
  <table class="table table-striped align-middle bg-white shadow-sm">
    <thead class="table-dark">
      <tr>
        <th>Départ</th><th>Date de départ</th><th>Arrivée</th><th>Date d'arrivée</th><th>Places disponibles</th>
        <?php if ($user): ?><th class="text-end">Actions</th><?php endif; ?>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($trajets as $t): ?>
      <tr>
        <td><?= e($t['agence_depart']) ?></td>
        <td><?= e(format_date($t['date_depart'])) ?></td>
        <td><?= e($t['agence_arrivee']) ?></td>
        <td><?= e(format_date($t['date_arrivee'])) ?></td>
        <td><?= (int) $t['places_dispo'] ?></td>
        <?php if ($user): ?>
        <td class="text-end">
          <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#trajet-<?= (int) $t['id'] ?>">Détails</button>
          <?php if ((int) $t['auteur_id'] === $user['id']): ?>
            <a class="btn btn-sm btn-secondary" href="/trajets/<?= (int) $t['id'] ?>/modifier">Modifier</a>
            <form method="post" action="/trajets/<?= (int) $t['id'] ?>/supprimer" class="d-inline"
                  onsubmit="return confirm('Supprimer ce trajet ?')"><?= csrf_field() ?>
              <button class="btn btn-sm btn-danger">Supprimer</button>
            </form>
          <?php endif; ?>
        </td>
        <?php endif; ?>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php if ($user): foreach ($trajets as $t): ?>
<div class="modal fade" id="trajet-<?= (int) $t['id'] ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title h5"><?= e($t['agence_depart']) ?> &rarr; <?= e($t['agence_arrivee']) ?></h2>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
    </div>
    <div class="modal-body">
      <p><strong>Proposé par :</strong> <?= e($t['auteur_prenom'] . ' ' . $t['auteur_nom']) ?></p>
      <p><strong>Téléphone :</strong> <?= e($t['auteur_telephone']) ?></p>
      <p><strong>Email :</strong> <?= e($t['auteur_email']) ?></p>
      <p class="mb-0"><strong>Nombre total de places :</strong> <?= (int) $t['places_total'] ?></p>
    </div>
  </div></div>
</div>
<?php endforeach; endif; ?>
<?php endif; ?>
