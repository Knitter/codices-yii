<?php

declare(strict_types=1);

/**
 * @var \yii\web\View $this
 * @var array{items: \Codices\Model\Publisher[], total: int, page: int, pageSize: int} $paginator
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('codices', 'Publishers');

$items = $paginator['items'] ?? [];
$total = (int)($paginator['total'] ?? 0);
$page = max(1, (int)($paginator['page'] ?? 1));
$pageSize = max(1, (int)($paginator['pageSize'] ?? 10));
$pages = max(1, (int)ceil($total / $pageSize));
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">
        <i class="bi bi-building me-2"></i>
        <?= Html::encode($this->title) ?>
    </h1>
    <a class="btn btn-primary" href="<?= Url::to(['publisher/add']) ?>">
        <i class="bi bi-plus-circle me-1"></i> Add Publisher
    </a>
    </div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                <tr>
                    <th class="px-4">Name</th>
                    <th class="text-end px-4" style="width: 160px">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!$items): ?>
                    <tr>
                        <td colspan="2" class="text-center text-muted py-4">No publishers found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($items as $publisher): ?>
                        <tr>
                            <td class="px-4">
                                <a href="<?= Url::to(['publisher/view', 'id' => $publisher->id]) ?>" class="text-decoration-none">
                                    <?= Html::encode($publisher->name) ?>
                                </a>
                            </td>
                            <td class="text-end px-4">
                                <a class="btn btn-sm btn-outline-secondary" href="<?= Url::to(['publisher/edit', 'id' => $publisher->id]) ?>">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a class="btn btn-sm btn-outline-danger ms-1" href="<?= Url::to(['publisher/delete', 'id' => $publisher->id]) ?>"
                                   onclick="return confirm('Delete this publisher?');">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if ($pages > 1): ?>
    <nav aria-label="Publishers pagination" class="mt-3">
        <ul class="pagination mb-0">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= Url::to(['publisher/index', 'page' => $page - 1]) ?>">Previous</a>
            </li>
            <?php for ($p = 1; $p <= $pages; $p++): ?>
                <li class="page-item <?= $p === $page ? 'active' : '' ?>">
                    <a class="page-link" href="<?= Url::to(['publisher/index', 'page' => $p]) ?>"><?= $p ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= $page >= $pages ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= Url::to(['publisher/index', 'page' => $page + 1]) ?>">Next</a>
            </li>
        </ul>
    </nav>
<?php endif; ?>
