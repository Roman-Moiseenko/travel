<?php

use booking\entities\user\User;
use booking\entities\forum\Category;
use booking\entities\forum\Post;
use booking\helpers\SysHelper;
use booking\helpers\UserForumHelper;
use frontend\widgets\design\BtnEdit;
use yii\data\DataProviderInterface;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this \yii\web\View */
/* @var $category Category */
/* @var $dataProvider DataProviderInterface */
/* @var $post Post */
/* @var $user User */

$this->title = $category->name . ' На форуме Калининград для туристов и гостей - найди ответ на вопрос';
$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => Url::to(['/forum'])];
$this->params['breadcrumbs'][] = $category->name;
$mobile = SysHelper::isMobile();

?>
<h1 style="font-size: 20px !important;">Форум Калининграда <br> <?= $category->name ?></h1>
<p>
    <?php if ($user->preferences->isForumLock()): ?>
        <span>Вы не можете создавать новые темы, обратитесь к Модератору</span>
    <?php else: ?>
        <?= BtnEdit::widget([
            'url' => Url::to(['forum/create-post', 'id' => $category->id]),
            'caption' => 'Новая тема',
        ]) ?>
    <?php endif; ?>
</p>
<table class="table-forum table-striped">
    <tbody>
    <?php foreach ($dataProvider->getModels() as $post): ?>
        <tr class="row_link">
            <?php if ($user->preferences->isForumUpdate()): ?>
                <td class="col_admin">
                    <?php if ($post->isFix()): ?>
                        <a href="<?= Url::to(['forum/unfix-post', 'id' => $post->id]) ?>"><i
                                    class="fas fa-check-double"></i></a>
                    <?php else: ?>
                        <a href="<?= Url::to(['forum/fix-post', 'id' => $post->id]) ?>"><i
                                    class="fas fa-check"></i></a>
                    <?php endif; ?>
                    <?php if ($user->preferences->isForumAdmin()): ?>
                        <a href="<?= Url::to(['forum/remove-post', 'id' => $post->id]) ?>"
                           data-confirm="Удалить данную тему?" data-method="post"><i
                                    class="fas fa-times"></i></a>
                    <?php endif; ?>
                    <?php if ($post->isActive()): ?>
                        <a href="<?= Url::to(['forum/lock-post', 'id' => $post->id]) ?>"><i
                                    class="fas fa-lock"></i></a>
                    <?php else: ?>
                        <a href="<?= Url::to(['forum/unlock-post', 'id' => $post->id]) ?>"><i
                                    class="fas fa-lock-open"></i></a>
                    <?php endif; ?>
                </td>
            <?php endif; ?>

            <td class="col_img_mini <?= $post->isFix() ? 'col_fix' : '' ?>"
                onclick="window.location.href='<?= Url::to(['forum/post', 'id' => $post->id]) ?>'; return false">
                <?= UserForumHelper::isReadPost($post->id) ? '<i class="far fa-envelope-open"></i>' : '<i class="fas fa-envelope"></i>' ?>
            </td>
            <td class="col_forum_mobile"
                onclick="window.location.href='<?= Url::to(['forum/post', 'id' => $post->id]) ?>'; return false">
                <div class="row_post">
                    <?= $post->isActive() ? '' : '<i class="fas fa-lock"></i> ' ?>
                    <h2 class="row_post"><?= $post->caption ?></h2>
                </div>
                <div>
                    Ответы: <?= $post->count . ' <i class="fas fa-envelope-open-text"></i>' ?>
                </div>
                Последнее сообщение: <span
                        class="row_description"><?= $post->lastMessage->userName(true) . ' от ' . date('Y-m-d H:i', $post->lastMessage->lastDate()) ?></span>
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
