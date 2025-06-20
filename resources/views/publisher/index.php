<?php

declare(strict_types=1);

use App\Model\Publisher;
use Yiisoft\Data\Paginator\OffsetPaginator;
use Yiisoft\Html\Html;
use Yiisoft\Yii\Bootstrap5\Alert;

/**
 * @var \Yiisoft\View\View $this
 * @var \Yiisoft\Router\UrlGeneratorInterface $urlGenerator
 * @var OffsetPaginator $paginator
 * @var \Yiisoft\Router\CurrentRoute $currentRoute
 */

$this->setTitle('Publishers');
?>

<h1>Publishers</h1>

<p>
    <?= Html::a('Create Publisher', '/publisher/create', ['class' => 'btn btn-success']) ?>
</p>

<?php if ($paginator->getTotalItems() > 0): ?>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Website</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($paginator->read() as $publisher): ?>
                <?php /** @var Publisher $publisher */ ?>
                <tr>
                    <td><?= Html::encode($publisher->id) ?></td>
                    <td><?= Html::encode($publisher->name) ?></td>
                    <td>
                        <?php if (!empty($publisher->website)): ?>
                            <a href="<?= Html::encode($publisher->website) ?>"
                               target="_blank"><?= Html::encode($publisher->website) ?></a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= Html::a('View', '/publisher/view/' . $publisher->id, ['class' => 'btn btn-info btn-sm']) ?>
                        <?= Html::a('Update', '/publisher/update/' . $publisher->id, ['class' => 'btn btn-primary btn-sm']) ?>
                        <?= Html::a('Delete', '/publisher/delete/' . $publisher->id, [
                            'class' => 'btn btn-danger btn-sm',
                            'data-method' => 'post',
                            'data-confirm' => 'Are you sure you want to delete this publisher?',
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php
    // Display pagination
    echo \Yiisoft\Yii\Bootstrap5\Nav::widget()
        ->currentPath($currentRoute->getUri()->getPath())
        ->items($paginator->getPaginationLinks())
        ->options(['class' => 'justify-content-center'])
    ?>
<?php else: ?>
    <?= Alert::widget()->options(['class' => 'alert-info'])->body('No publishers found.') ?>
<?php endif; ?>
