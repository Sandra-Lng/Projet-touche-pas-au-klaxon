<h1 class="h3 mb-4">Agences</h1>
<form method="post" action="/admin/agences" class="row g-2 mb-4"><?= csrf_field() ?>
  <div class="col-sm-6 col-md-4"><input class="form-control" name="nom" placeholder="Nom de la nouvelle agence" maxlength="100" required></div>
  <div class="col-auto"><button class="btn btn-primary">Créer</button></div>
</form>
<div class="table-responsive">
<table class="table table-striped align-middle bg-white shadow-sm">
  <thead class="table-dark"><tr><th>Nom</th><th class="text-end">Actions</th></tr></thead>
  <tbody>
  <?php foreach ($agences as $a): ?>
    <tr>
      <td>
        <form method="post" action="/admin/agences/<?= (int) $a['id'] ?>/modifier" class="d-flex gap-2"><?= csrf_field() ?>
          <input class="form-control form-control-sm" name="nom" value="<?= e($a['nom']) ?>" maxlength="100" required>
          <button class="btn btn-sm btn-secondary">Modifier</button>
        </form>
      </td>
      <td class="text-end">
        <form method="post" action="/admin/agences/<?= (int) $a['id'] ?>/supprimer" class="d-inline"
              onsubmit="return confirm('Supprimer cette agence ?')"><?= csrf_field() ?>
          <button class="btn btn-sm btn-danger">Supprimer</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
