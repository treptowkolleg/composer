<?php

/**
 * @var object|null $meta enthält Meta-Daten der Website
 * @var object $response enthält Response-Daten des Controllers
 */

?>
<!doctype html>
<html lang="<?= $meta->get('lang') ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, viewport-fit=cover, initial-scale=1, maximum-scale=1">
        <meta name="description" content="<?= $meta->get('description') ?>">
        <meta name="author" content="<?= $meta->get('author') ?>">
        <?php if ($this->section('css')): ?>
            <?=$this->section('css')?>
        <?php else: ?>
            <link rel="stylesheet" href="<?= $response->generateUrlFromString('/assets/styles/app.css')?>">
        <?php endif ?>
        <script type="text/javascript" src="<?= $response->generateUrlFromString('/assets/scripts/app.js')?>"></script>
        <title><?= $meta->get('title') ?></title>
    </head>
    <body>
        <?=$this->section('body')?>
    </body>
</html>