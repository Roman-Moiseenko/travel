<?php

use booking\entities\forum\Section;
use booking\entities\user\User;
use booking\helpers\SysHelper;
use booking\helpers\UserForumHelper;
use yii\data\DataProviderInterface;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $section Section */
/* @var $user User */
/* @var $dataProvider DataProviderInterface */

$this->title = $section->caption . ' На форуме Калининград для туристов и гостей - найди ответ на вопрос';
$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => Url::to(['/forum'])];
$this->params['breadcrumbs'][] = $section->caption;
$this->params['canonical'] = Url::to(['/forum/view', 'slug' =>  $section->slug], true);

$mobile = SysHelper::isMobile();
?>

<h1 <?= $mobile ? 'style="font-size: 22px"' : '' ?>><?= $section->caption ?></h1>
<div class="card list-cart mt-4">
    <div class="card" style="border: 0 !important; border-radius: 7px !important;">
        <table class="table-forum">
            <tbody>
            <?php foreach ($section->categories as $category): ?>
                <?= $this->render($mobile ? '_row_category_mobile' : '_row_category', [
                    'category' => $category,
                ]) ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card list-cart mt-4">
    <div class="card-header">Последние обсуждаемые темы</div>
    <div class="card-body">
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
                    'user' => $user,
                    'post' => $post,
                ]) ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

