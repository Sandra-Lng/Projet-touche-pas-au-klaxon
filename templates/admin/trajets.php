<h1 class="h3 mb-4">Trajets</h1>
<div class="table-responsive">
<table class="table table-striped align-middle bg-white shadow-sm">
  <thead class="table-dark"><tr><th>Départ</th><th>Date de départ</th><th>Arrivée</th><th>Date d'arrivée</th><th>Places (dispo / total)</th><th>Auteur</th><th class="text-end">Actions</th></tr></thead>
  <tbody>
  <?php foreach ($trajets as $t): ?>
    <tr>
      <td><?= e($t['agence_depart']) ?></td><td><?= e(format_date($t['date_depart'])) ?></td>
      <td><?= e($t['agence_arrivee']) ?></td><td><?= e(format_date($t['date_arrivee'])) ?></td>
      <td><?= (int) $t['places_dispo'] ?> / <?= (int) $t['places_total'] ?></td>
      <td><?= e($t['auteur_prenom'] . ' ' . $t['auteur_nom']) ?></td>
      <td class="text-end">
        <form method="post" action="/admin/trajets/<?= (int) $t['id'] ?>/supprimer" class="d-inline"
              onsubmit="return confirm('Supprimer ce trajet ?')"><?= csrf_field() ?>
          <button class="btn btn-sm btn-danger">Supprimer</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
