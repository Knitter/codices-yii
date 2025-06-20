<?php

declare(strict_types=1);

use App\Model\Account;
use Yiisoft\Html\Html;
use Yiisoft\Yii\Bootstrap5\Alert;

/**
 * @var \Yiisoft\View\View $this
 * @var \Yiisoft\Router\UrlGeneratorInterface $urlGenerator
 * @var Account $account
 */

$this->setTitle('View Account: ' . Html::encode($account->username));
?>

<h1>View Account: <?= Html::encode($account->username) ?></h1>

<p>
    <?= Html::a('Update', '/account/update/' . $account->id, ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Delete', '/account/delete/' . $account->id, [
        'class' => 'btn btn-danger',
        'data-method' => 'post',
        'data-confirm' => 'Are you sure you want to delete this account?',
    ]) ?>
    <?= Html::a('Back to List', '/account', ['class' => 'btn btn-secondary']) ?>
</p>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>ID</th>
                    <td><?= Html::encode($account->id) ?></td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td><?= Html::encode($account->username) ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= Html::encode($account->email) ?></td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td><?= Html::encode($account->name) ?></td>
                </tr>
                <tr>
                    <th>Active</th>
                    <td><?= $account->active ? 'Yes' : 'No' ?></td>
                </tr>
                <tr>
                    <th>Created On</th>
                    <td><?= Html::encode(date('Y-m-d H:i:s', $account->createdOn)) ?></td>
                </tr>
                <tr>
                    <th>Updated On</th>
                    <td><?= Html::encode(date('Y-m-d H:i:s', $account->updatedOn)) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<h2 class="mt-4">Related Data</h2>

<div class="accordion" id="accountRelatedData">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingPublishers">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePublishers" aria-expanded="false" aria-controls="collapsePublishers">
                Publishers
            </button>
        </h2>
        <div id="collapsePublishers" class="accordion-collapse collapse" aria-labelledby="headingPublishers" data-bs-parent="#accountRelatedData">
            <div class="accordion-body">
                <?php if (count($account->getPublishers()->all()) > 0): ?>
                    <ul class="list-group">
                        <?php foreach ($account->getPublishers()->all() as $publisher): ?>
                            <li class="list-group-item">
                                <?= Html::a(Html::encode($publisher->name), '/publisher/view/' . $publisher->id) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No publishers found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header" id="headingItems">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseItems" aria-expanded="false" aria-controls="collapseItems">
                Items
            </button>
        </h2>
        <div id="collapseItems" class="accordion-collapse collapse" aria-labelledby="headingItems" data-bs-parent="#accountRelatedData">
            <div class="accordion-body">
                <?php if (count($account->getItems()->all()) > 0): ?>
                    <ul class="list-group">
                        <?php foreach ($account->getItems()->all() as $item): ?>
                            <li class="list-group-item">
                                <?= Html::a(Html::encode($item->title), '/item/view/' . $item->id) ?>
                                <span class="badge bg-secondary"><?= Html::encode($item->type) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No items found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
