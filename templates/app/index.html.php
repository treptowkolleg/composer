<?php

/**
 * Definierte Variablen (siehe Controller-Methode):
 * @var string $controllerName
 * @var array $routes
 */

// übergeordnetes Template
$this->layout('base.html');

?>

<?php $this->start('body') ?>
<section class="bg-light border-bottom">
    <div class="container">
        <h1>Hello World!</h1>
    </div>
</section>

<section>
    <article class="container">
        <p class="lead">Diese Seite wurde von <code><?=$controllerName?></code> aufgerufen.</p>
        <p>Bearbeite die Datei <code>/templates/app/index.html.php</code>, um den Inhalt anzupassen.</p>

        <p class="lead mt-5">Definierte Routen (aber nicht zwingend auch die Controller)</p>
        <?php foreach($routes as $route => $url): ?>
            <div><a href="<?=$url?>"><?=$route?></a></div>
        <?php endforeach;?>

        <p class="lead mt-5">Error 404 gefällig?</p>
        <a href="/bla/keks">Falscher Link</a>
    </article>
</section>
<?php $this->stop()?>
