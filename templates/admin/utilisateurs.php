<h1 class="h3 mb-4">Utilisateurs</h1>
<div class="table-responsive">
<table class="table table-striped bg-white shadow-sm">
  <thead class="table-dark"><tr><th>Nom</th><th>Prénom</th><th>Téléphone</th><th>Email</th><th>Rôle</th></tr></thead>
  <tbody>
  <?php foreach ($utilisateurs as $u): ?>
    <tr><td><?= e($u['nom']) ?></td><td><?= e($u['prenom']) ?></td><td><?= e($u['telephone']) ?></td><td><?= e($u['email']) ?></td><td><?= e($u['role']) ?></td></tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
