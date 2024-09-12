<?php

/**
 * Definierte Variablen (siehe Controller-Methode):
 * @var string $controllerName
 */

// übergeordnetes Template
$this->layout('base.html');

?>

<?php $this->start('body') ?>
<h1>Controller <?=$controllerName?></h1>
<p>Diese Seite wurde vom <?=$controllerName?> aufgerufen. Ist das nicht toll?</p>
<?php $this->stop()?>
