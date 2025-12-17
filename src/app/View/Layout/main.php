<?php

declare(strict_types=1);

/**
 * @var string $content
 * @var yii\web\View $this
 */

use Codices\Asset\CodicesAsset;
use yii\helpers\Html;

CodicesAsset::register($this);

$this->beginPage();
?><!DOCTYPE html>
<html lang="<?= Html::encode(Yii::$app->language) ?>" data-bs-theme="light">
<head>
    <meta charset="<?= Html::encode(Yii::$app->charset) ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column min-vh-100">
<?php $this->beginBody() ?>

<?= $this->render('_navigation') ?>

<main class="flex-grow-1">
    <div class="container my-4">
        <?= $content ?>
    </div>
</main>

<?= $this->render('_footer') ?>

<!-- Theme Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;
        const icon = themeToggle.querySelector('i');

        // Load saved theme or default to light
        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-bs-theme', savedTheme);
        updateIcon(savedTheme);

        themeToggle.addEventListener('click', function () {
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';

            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateIcon(newTheme);
        });

        function updateIcon(theme) {
            icon.className = theme === 'light' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
            themeToggle.title = theme === 'light' ? 'Switch to dark theme' : 'Switch to light theme';
        }
    });
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
