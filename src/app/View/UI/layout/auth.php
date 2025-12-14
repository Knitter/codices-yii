<?php

declare(strict_types=1);

use Codices\Asset\CodicesAsset;
use Yiisoft\Html\Html;
//use Yiisoft\I18n\Locale;

/**
 * @var \Codices\ApplicationParameters $applicationParameters
 * @var Yiisoft\Aliases\Aliases $aliases
 * @var Yiisoft\Assets\AssetManager $assetManager
 * @var string $content
 * @var string|null $csrf
 * //* @var Locale $locale
 * @var Yiisoft\View\WebView $this
 * @var Yiisoft\Router\CurrentRoute $currentRoute
 * @var Yiisoft\Router\UrlGeneratorInterface $urlGenerator
 */

$assetManager->register(CodicesAsset::class);

$this->addCssFiles($assetManager->getCssFiles());
$this->addCssStrings($assetManager->getCssStrings());
$this->addJsFiles($assetManager->getJsFiles());
$this->addJsStrings($assetManager->getJsStrings());
$this->addJsVars($assetManager->getJsVars());

$this->beginPage()
?><!DOCTYPE html>
<html lang="<?php //= Html::encode($locale->language()) ?>" data-bs-theme="light">
<head>
    <meta charset="<?= Html::encode($applicationParameters->getCharset()) ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->getTitle()) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column min-vh-100">
<?php $this->beginBody() ?>

<!-- Main Content -->
<main class="flex-grow-1 d-flex align-items-center">
    <?= $content ?>
</main>

<!-- Theme Toggle Script -->
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
<?php $this->endPage() ?>
