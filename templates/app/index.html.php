<?php

/**
 * Definierte Variablen (siehe Controller-Methode):
 * @var Response $response
 * @var string $controllerName
 * @var array $routes
 */

// übergeordnetes Template
use Core\Component\HttpComponent\Response;

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
        <p class="mt-3">
            <?php
                $json = json_encode([
                        "userId" => 0,
                    "username" => "bwagner"
                ],true);
            ?>
            <button
                    class="btn btn-primary ajax"
                    data-body="<?= htmlentities($json, ENT_QUOTES, 'UTF-8'); ?>"
                    data-func="list"
                    data-target="chars"
                    data-url="<?=$response->generateUrlFromRoute("api_chars_get")?>"
            >
                Charakter-Infos laden
            </button>
        </p>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Charaktere</h5>
            </div>
            <ul class="list-group list-group-flush" id="chars"></ul>
        </div>

    </article>
</section>
<?php $this->stop()?>
