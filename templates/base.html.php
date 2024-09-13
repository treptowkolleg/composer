<?php

/**
 * @var object|null $meta enthält Meta-Daten der Website
 * @var object $response enthält Response-Daten des Controllers
 * @var null|string $flash Flash Message Container
 */

?>
<!doctype html>
<html lang="<?= $meta->get('lang') ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, viewport-fit=cover, initial-scale=1, maximum-scale=1">
        <meta name="description" content="<?= $meta->get('description') ?>">
        <meta name="author" content="<?= $meta->get('author') ?>">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <?php if ($this->section('css')): ?>
            <?=$this->section('css')?>
        <?php else: ?>
            <link rel="stylesheet" href="<?= $response->generateUrlFromString('/assets/styles/app.css')?>">
        <?php endif ?>

        <title><?= $meta->get('title') ?></title>
    </head>
    <body>
        <?=$this->section('body')?>
        <?php echo $flash;?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script type="module" src="<?= $response->generateUrlFromString('/assets/scripts/app.js')?>"></script>
    </body>
</html>