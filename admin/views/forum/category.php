<?php

use booking\entities\forum\Category;
use booking\entities\forum\Post;
use booking\helpers\ForumHelper;
use yii\data\DataProviderInterface;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $category Category */
/* @var $dataProvider DataProviderInterface */
/* @var $post Post */

$this->title = $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => ['/forum']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-body">
        <p>
            <?= Html::a('Новая тема  <i class="fas fa-pen"></i>', Url::to(['forum/create-post', 'id' => $category->id]), ['class' => 'btn btn-info']) ?>
        </p>
        <table class="table table-striped">
            <thead>
            <tr>
                <th class="col_img"></th>
                <th class="col_forum">Тема</th>
                <th class="col_stat">Ответы</th>
                <th class="col_post">Последнее сообщение</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($dataProvider->getModels() as $post): ?>
                <tr class="row_link" onclick="window.location.href='<?= Url::to(['forum/post', 'id' => $post->id])?>'; return false">
                    <td class="col_img">
                        <?= ForumHelper::isReadPost($post->id) ? '<i class="far fa-envelope-open"></i>' : '<i class="fas fa-envelope"></i>' ?>
                    </td>
                    <td class="col_forum">
                        <div class="row_post">
                            <?= $post->caption ?>
                        </div>
                    </td>
                    <td class="col_stat">
                        <div><?= $post->count . ' сообщений' ?></div>
                    </td>
                    <td class="col_post">
                        <?= 'Сообщение ' . $post->lastMessage->user->username . ' от ' . date('Y-m-d', $post->lastMessage->created_at) ?>
                    </td>
                </tr>

            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="row">
            <div class="col-sm-6 text-left">
                <?= LinkPager::widget([
                    'pagination' => $dataProvider->getPagination(),
                ]) ?>
            </div>
            <div class="col-sm-6 text-right"><?= 'Показано ' . $dataProvider->getCount() . ' из ' . $dataProvider->getTotalCount() ?></div>
        </div>
    </div>
</div>
