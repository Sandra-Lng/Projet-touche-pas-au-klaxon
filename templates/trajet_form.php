<?php
$editing = $trajetId !== null;
$action = $editing ? '/trajets/' . $trajetId . '/modifier' : '/trajets/creer';
$v = static fn (string $k): string => (string) ($trajet[$k] ?? '');
?>
<h1 class="h3 mb-4"><?= $editing ? 'Modifier le trajet' : 'Créer un trajet' ?></h1>
<?php if ($errors): ?>
  <div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>
<form method="post" action="<?= e($action) ?>" class="card card-body shadow-sm"><?= csrf_field() ?>
  <div class="row g-3">
    <div class="col-md-6"><label class="form-label">Nom</label><input class="form-control" value="<?= e($user['nom']) ?>" readonly></div>
    <div class="col-md-6"><label class="form-label">Prénom</label><input class="form-control" value="<?= e($user['prenom']) ?>" readonly></div>
    <div class="col-md-6"><label class="form-label">Email</label><input class="form-control" value="<?= e($user['email']) ?>" readonly></div>
    <div class="col-md-6"><label class="form-label">Téléphone</label><input class="form-control" value="<?= e($user['telephone']) ?>" readonly></div>

    <?php foreach (['agence_depart_id' => 'Agence de départ', 'agence_arrivee_id' => "Agence d'arrivée"] as $field => $label): ?>
    <div class="col-md-6">
      <label class="form-label" for="<?= $field ?>"><?= e($label) ?></label>
      <select class="form-select" id="<?= $field ?>" name="<?= $field ?>" required>
        <option value="">Choisir…</option>
        <?php foreach ($agences as $a): ?>
          <option value="<?= (int) $a['id'] ?>" <?= $v($field) === (string) $a['id'] ? 'selected' : '' ?>><?= e($a['nom']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <?php endforeach; ?>

    <div class="col-md-6"><label class="form-label" for="date_depart">Date et heure de départ</label>
      <input class="form-control" type="datetime-local" id="date_depart" name="date_depart" value="<?= e(input_datetime($v('date_depart'))) ?>" required></div>
    <div class="col-md-6"><label class="form-label" for="date_arrivee">Date et heure d'arrivée</label>
      <input class="form-control" type="datetime-local" id="date_arrivee" name="date_arrivee" value="<?= e(input_datetime($v('date_arrivee'))) ?>" required></div>
    <div class="col-md-6"><label class="form-label" for="places_total">Nombre total de places</label>
      <input class="form-control" type="number" min="1" id="places_total" name="places_total" value="<?= e($v('places_total')) ?>" required></div>
    <div class="col-md-6"><label class="form-label" for="places_dispo">Places disponibles</label>
      <input class="form-control" type="number" min="0" id="places_dispo" name="places_dispo" value="<?= e($v('places_dispo')) ?>" required></div>
  </div>
  <div class="mt-4 d-flex gap-2">
    <button class="btn btn-primary"><?= $editing ? 'Enregistrer' : 'Créer le trajet' ?></button>
    <a class="btn btn-outline-secondary" href="/">Annuler</a>
  </div>
</form>
