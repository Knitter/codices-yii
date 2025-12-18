<?php

declare(strict_types=1);

/**
 * @var \yii\web\View $this
 * @var \Codices\View\Facade\ImportUploadForm $model
 * @var string $csrf
 */

use Codices\View\Facade\ImportUploadForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

if (!isset($csrf)) {
    $csrf = Yii::$app->request->getCsrfToken();
}

$this->title = Yii::t('codices', 'Import Items');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">
        <i class="bi bi-upload me-2"></i>
        <?= Html::encode($this->title) ?>
    </h1>
    <a href="<?= Url::to(['book/index']) ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Books
    </a>
    </div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'novalidate' => true]]); ?>
        <input type="hidden" name="_csrf" value="<?= Html::encode($csrf) ?>">
        <input type="hidden" name="stage" value="upload">

        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Format</label>
                <select name="format" class="form-select" id="import-format">
                    <option value="<?= ImportUploadForm::FORMAT_GENERIC_CSV ?>" selected>Generic CSV</option>
                    <option value="<?= ImportUploadForm::FORMAT_CODICES_JSON ?>">Codices JSON</option>
                    <option value="<?= ImportUploadForm::FORMAT_CALIBRE_CSV ?>">Calibre CSV</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">File</label>
                <input type="file" name="file" class="form-control" id="import-file" accept=".csv,.json" required>
                <div class="form-text">
                    Supported: Generic CSV (*.csv), Calibre CSV (*.csv), Codices JSON (*.json). For Generic CSV, see sample: <code>runtime\books.sample.csv</code>
                </div>
            </div>
            <div class="col-md-2 text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search me-1"></i> Preview
                </button>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<script>
    (function(){
        const fmt = document.getElementById('import-format');
        const file = document.getElementById('import-file');
        if (!fmt || !file) return;
        const updateAccept = () => {
            const v = fmt.value;
            if (v === '<?= ImportUploadForm::FORMAT_CODICES_JSON ?>') {
                file.setAttribute('accept', '.json');
            } else {
                file.setAttribute('accept', '.csv');
            }
        };
        fmt.addEventListener('change', updateAccept);
        updateAccept();
    })();
    </script>
