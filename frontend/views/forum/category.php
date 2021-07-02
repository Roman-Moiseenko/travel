<?php

use booking\entities\user\User;
use booking\entities\forum\Category;
use booking\entities\forum\Post;
use booking\helpers\SysHelper;
use frontend\widgets\design\BtnEdit;
use yii\data\DataProviderInterface;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this \yii\web\View */
/* @var $category Category */
/* @var $dataProvider DataProviderInterface */
/* @var $post Post */
/* @var $user User */

$this->title = $category->name . ' На форуме Калининград для туристов и гостей - найди ответ на вопрос';
$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => Url::to(['/forum'])];
$this->params['breadcrumbs'][] = ['label' => $category->section->caption, 'url' => Url::to(['/forum/view', 'slug' => $category->section->slug])];
$this->params['breadcrumbs'][] = $category->name;
$this->params['canonical'] = Url::to(['/forum/category', 'id' => $category->id], true);

$mobile = SysHelper::isMobile();

?>
<h1 <?= $mobile ? 'style="font-size: 20px !important;"' : '' ?>>Форум Калининграда. <?= $category->name ?></h1>
<p>
    <?php if ($user): ?>
        <?php if ($user->preferences->isForumLock()): ?>
            <span>Вы не можете создавать новые темы, обратитесь к Модератору</span>
        <?php else: ?>
            <?= BtnEdit::widget([
                'url' => Url::to(['forum/create-post', 'id' => $category->id]),
                'caption' => 'Новая тема',
            ]) ?>
        <?php endif; ?>
    <?php else: ?>
        <a href="<?= Url::to(['/login'])?>">Авторизуйтесь</a>, чтоб оставлять сообщения
    <?php endif; ?>
</p>
<table class="table table-borderless table-striped">
    <?php if (!$mobile): ?>
        <thead style="background-color: #666; color: white">
        <tr>
            <?php if ($user && $user->preferences->isForumUpdate()): ?>
                <th class="col_admin"></th>
            <?php endif; ?>
            <th class="col_img_mini"></th>
            <th class="col_forum">Тема</th>
            <th class="col_stat">Ответы</th>
            <th class="col_post">Последнее сообщение</th>
        </tr>
        </thead>
    <?php endif; ?>
    <tbody>
    <?php foreach ($dataProvider->getModels() as $post): ?>
        <?= $this->render($mobile ? '_row_post_mobile' : '_row_post', [
            'category' => $category,
            'user' => $user,
            'post' => $post,
        ]) ?>

    <?php endforeach; ?>
    </tbody>
</table>

<div class="row">
    <div class="col-sm-6 text-left">
        <?= LinkPager::widget([
            'pagination' => $dataProvider->getPagination(),
        ]) ?>
    </div>
    <?php if ($dataProvider->getPagination()->getPageCount() > 1): ?>
        <div class="col-sm-6 text-right"><?= 'Показано ' . $dataProvider->getCount() . ' из ' . $dataProvider->getTotalCount() ?></div>
    <?php endif; ?>
</div>

