<?php

use booking\entities\admin\User;
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
/* @var $user User */

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
                <?php if($user->preferences->isForumUpdate()):?>
                    <th class="col_admin"></th>
                <?php endif; ?>

                <th class="col_img_mini"></th>
                <th class="col_forum">Тема</th>
                <th class="col_stat">Ответы</th>
                <th class="col_post">Последнее сообщение</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($dataProvider->getModels() as $post): ?>
                <tr class="row_link">
                    <?php if($user->preferences->isForumUpdate()):?>
                        <td class="col_admin">
                            <?php if($post->isFix()):?>
                                <a href="<?=Url::to(['forum/unfix-post', 'id' => $post->id])?>"><i class="fas fa-check-double"></i></a>
                            <?php else: ?>
                                <a href="<?=Url::to(['forum/fix-post', 'id' => $post->id])?>"><i class="fas fa-check"></i></a>
                            <?php endif; ?>
                            <?php if($user->preferences->isForumAdmin()):?>
                                <a href="<?=Url::to(['forum/remove-post', 'id' => $post->id])?>"><i class="fas fa-times"></i></a>
                            <?php endif; ?>
                            <?php if($post->isActive()):?>
                                <a href="<?=Url::to(['forum/lock-post', 'id' => $post->id])?>"><i class="fas fa-lock"></i></a>
                            <?php else: ?>
                                <a href="<?=Url::to(['forum/unlock-post', 'id' => $post->id])?>"><i class="fas fa-lock-open"></i></a>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>

                    <td class="col_img_mini <?= $post->isFix() ? 'col_fix' : '' ?>" onclick="window.location.href='<?= Url::to(['forum/post', 'id' => $post->id])?>'; return false">
                        <?= ForumHelper::isReadPost($post->id) ? '<i class="far fa-envelope-open"></i>' : '<i class="fas fa-envelope"></i>' ?>
                    </td>
                    <td class="col_forum" onclick="window.location.href='<?= Url::to(['forum/post', 'id' => $post->id])?>'; return false">
                        <div class="row_post">
                            <?= $post->isActive() ? '' : '<i class="fas fa-lock"></i> '?>
                            <?= $post->caption ?>
                        </div>
                    </td>
                    <td class="col_stat" onclick="window.location.href='<?= Url::to(['forum/post', 'id' => $post->id])?>'; return false">
                        <div><?= $post->count . ' сообщений' ?></div>
                    </td>
                    <td class="col_post" onclick="window.location.href='<?= Url::to(['forum/post', 'id' => $post->id])?>'; return false">
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
