<?php

declare(strict_types=1);

use Codices\Asset\CodicesAsset;
use yii\helpers\Html;

/**
 * @var string $content
 * @var string|null $csrf
 * @var yii\web\View $this
 */

CodicesAsset::register($this);
$this->beginPage()
?><!DOCTYPE html>
<html lang="<?= Html::encode(Yii::$app->language) ?>" data-bs-theme="light">
<head>
    <meta charset="<?= Html::encode(Yii::$app->charset) ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <?php $this->head() ?>
</head>

<body class="d-flex flex-column min-vh-100">
<?php $this->beginBody() ?>

<main class="flex-grow-1 d-flex align-items-center">
    <?= $content ?>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Load saved theme or default to light
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', savedTheme);
    });
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
