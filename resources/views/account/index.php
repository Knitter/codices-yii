<?php

declare(strict_types=1);

use App\Model\Account;
use Yiisoft\Data\Paginator\OffsetPaginator;
use Yiisoft\Html\Html;
use Yiisoft\Yii\Bootstrap5\Alert;

/**
 * @var \Yiisoft\View\View $this
 * @var \Yiisoft\Router\UrlGeneratorInterface $urlGenerator
 * @var OffsetPaginator $paginator
 * @var \Yiisoft\Router\CurrentRoute $currentRoute
 */

$this->setTitle('Accounts');
?>

<h1>Accounts</h1>

<p>
    <?= Html::a('Create Account', '/account/create', ['class' => 'btn btn-success']) ?>
</p>

<?php if ($paginator->getTotalItems() > 0): ?>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paginator->read() as $account): ?>
                    <?php /** @var Account $account */ ?>
                    <tr>
                        <td><?= Html::encode($account->id) ?></td>
                        <td><?= Html::encode($account->username) ?></td>
                        <td><?= Html::encode($account->email) ?></td>
                        <td><?= Html::encode($account->name) ?></td>
                        <td><?= $account->active ? 'Yes' : 'No' ?></td>
                        <td>
                            <?= Html::a('View', '/account/view/' . $account->id, ['class' => 'btn btn-info btn-sm']) ?>
                            <?= Html::a('Update', '/account/update/' . $account->id, ['class' => 'btn btn-primary btn-sm']) ?>
                            <?= Html::a('Delete', '/account/delete/' . $account->id, [
                                'class' => 'btn btn-danger btn-sm',
                                'data-method' => 'post',
                                'data-confirm' => 'Are you sure you want to delete this account?',
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
    <?= Alert::widget()->options(['class' => 'alert-info'])->body('No accounts found.') ?>
<?php endif; ?>
