<?php
use App\Core\Session;

$user = Session::user();
$isAdmin = Session::isAdmin();
?><!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Touche pas au klaxon</title>
  <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= $isAdmin ? '/admin' : '/' ?>">Touche pas au klaxon</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-label="Menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="menu">
      <ul class="navbar-nav align-items-lg-center gap-lg-2">
        <?php if ($user === null): ?>
          <li class="nav-item"><a class="btn btn-primary" href="/connexion">Connexion</a></li>
        <?php elseif ($isAdmin): ?>
          <li class="nav-item"><a class="nav-link" href="/admin/utilisateurs">Utilisateurs</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/agences">Agences</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/trajets">Trajets</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="btn btn-primary" href="/trajets/creer">Créer un trajet</a></li>
          <li class="nav-item"><span class="navbar-text text-white"><?= e($user['prenom'] . ' ' . $user['nom']) ?></span></li>
        <?php endif; ?>
        <?php if ($user !== null): ?>
          <li class="nav-item">
            <form method="post" action="/deconnexion" class="d-inline"><?= csrf_field() ?>
              <button class="btn btn-outline-light">Déconnexion</button>
            </form>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<main class="container py-4 flex-grow-1">
  <?php foreach (Session::pullFlash() as $f): ?>
    <div class="alert alert-<?= e($f['type']) ?> alert-dismissible fade show" role="alert">
      <?= e($f['message']) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
  <?php endforeach; ?>
  <?= $content ?>
</main>

<footer class="bg-dark text-white-50 text-center py-3">
  Touche pas au klaxon &copy; <?= date('Y') ?>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
