<h1 class="h3 mb-4">Tableau de bord administrateur</h1>
<div class="row g-3">
  <?php foreach (['/admin/utilisateurs' => ['Utilisateurs', 'Lister les utilisateurs'],
                  '/admin/agences' => ['Agences', 'Créer, modifier et supprimer une agence'],
                  '/admin/trajets' => ['Trajets', 'Lister et supprimer les trajets']] as $url => [$titre, $desc]): ?>
  <div class="col-md-4">
    <a class="card h-100 text-decoration-none shadow-sm" href="<?= $url ?>">
      <div class="card-body"><h2 class="h5 text-primary"><?= e($titre) ?></h2><p class="mb-0 text-body"><?= e($desc) ?></p></div>
    </a>
  </div>
  <?php endforeach; ?>
</div>
