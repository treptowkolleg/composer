<?php

/**
 * Definierte Variablen (siehe Controller-Methode):
 * @var string $url
 */

// übergeordnetes Template
$this->layout('base.html');

?>

<?php $this->start('body') ?>
<section class="bg-light border-bottom">
    <div class="container">
        <h1>Error 404</h1>
    </div>
</section>

<section>
    <article class="container">
        <p class="lead">Die Adresse <a href="<?=$url?>"><?=$url?></a> ist nicht oder nicht mehr vorhanden!</p>
    </article>
</section>
<?php $this->stop()?>