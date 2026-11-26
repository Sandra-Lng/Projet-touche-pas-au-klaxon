<div class="row justify-content-center">
  <div class="col-md-6 col-lg-4">
    <h1 class="h3 mb-4">Connexion</h1>
    <form method="post" action="/connexion" class="card card-body shadow-sm"><?= csrf_field() ?>
      <div class="mb-3">
        <label class="form-label" for="email">Adresse email</label>
        <input class="form-control" type="email" id="email" name="email" value="<?= e($email) ?>" required autofocus>
      </div>
      <div class="mb-3">
        <label class="form-label" for="password">Mot de passe</label>
        <input class="form-control" type="password" id="password" name="password" required>
      </div>
      <button class="btn btn-primary">Se connecter</button>
    </form>
  </div>
</div>
