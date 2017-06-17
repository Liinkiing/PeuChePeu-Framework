<?php
// Fichier servant de benchmark de reference
require '../vendor/autoload.php';
session_start();
$database = new \Core\Database\Database('monframework');
$postTable = new \App\Blog\Table\PostTable($database);
$text = new \Core\Twig\TextExtension();
$posts = $postTable->getPaginatedPosts(10, isset($_GET['page']) ? $_GET['page'] :
    1);
function chunk_iterable($listOfThings, $size) {
    $chunk = 0;
    $chunks = array_fill(0, ceil(count($listOfThings) / $size) - 1, array());
    $index = 0;
    foreach($listOfThings as $thing) {
        if ($index && $index % $size == 0) $chunk++;
        $chunks[$chunk][] = $thing;
        $index++;
    }
    return $chunks;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title> Blog</title>
  <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
        integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ"
        crossorigin="anonymous">
  <style>
    body {
      padding-top: 5rem;
    }
  </style>
</head>
<body>

<nav class="navbar  navbar-toggleable-md fixed-top navbar-inverse bg-inverse">
  <a class="navbar-brand" href="#">Mon application</a>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/blog">Blog <span class="sr-only">(current)</span></a>
      </li>
    </ul>
      <?php if (!isset($_SESSION['auth.user'])): ?>
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="/login">Se connecter</a>
          </li>
          </li>
        </ul>
      <?php endif; ?>
  </div>
</nav>

<div class="container">

    <?php foreach (chunk_iterable($posts, 4) as $chunk): ?>
      <div class="row">
          <?php foreach ($chunk as $post): ?>
            <div class="col-sm-3">
              <div class="card">
                <div class="card-header"><?= $post->name; ?></div>
                <div class="card-block">
                  <p class="card-text">
                      <?= $text->excerpt($post->content); ?>
                  </p>
                  <p>
                    <a href="/blog/<?= $post->slug; ?>" class="btn btn-primary">
                      Voir l'article
                    </a>
                  </p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
      </div>
    <?php endforeach; ?>

    <?php
    $view = new \Pagerfanta\View\TwitterBootstrap4View();
    echo $view->render($posts, function ($page) {
        if ($page > 1) {
            return '/blog?page=' . $page;
        } else {
            return '/blog';
        }
    });
    ?>

</div><!-- /.container -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
        integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK"
        crossorigin="anonymous"></script>
</body>
</html>
