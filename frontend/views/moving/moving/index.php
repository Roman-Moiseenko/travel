<?php

use booking\entities\Lang;
use booking\helpers\SysHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Переезд на ПМЖ в Калининград - услуги недвижимость бизнес форум вопросов ответов информация для переезжающих отзывы рекомендации советы';
$this->registerMetaTag(['name' => 'description', 'content' => 'Окажем помощь в организации переезда на ПМЖ в Калининград, 
подберем недвижимость, земельный учатосток. Организуем строительство собственного дома на земельном участке в Калининграде. 
Консультации инвестиций в бизнес в Калининграде ']);

$this->params['canonical'] = Url::to(['/moving'], true);
$mobile = SysHelper::isMobile();
$image = \Yii::$app->params['staticHostInfo'] . '/files/images/moving/main_landing.jpg';
?>

    <h1 class="py-4">Калининградская область. Переезд на ПМЖ</h1>
    <div class="card mt-4" style="background-color: rgba(255,255,255,0.8) !important; border-radius: 20px">
        <div class="card-body m-4 p-2" style="text-align: justify; color: #000; text-shadow: 0 0 0">
            <h2 style="text-align: center !important;">Как переехать в Калининград</h2>
            <?= $this->render('_caption_text') ?>
        </div>
    </div>
<div class="py-3 mt-3">
    <?php foreach ($categories as $category): ?>
        <?php if ($mobile) echo '<div class="pb-4">'; ?>
            <button type="button" data-toggle="tooltip" data-method="get" class="moving-menu-page" href="<?= Url::to(['moving/moving/view', 'slug' => $category->slug])?>"> <?= $category->title ?></button>
        <?php if ($mobile) echo '</div>'; ?>
    <?php endforeach; ?>
    <p class="pt-4">
    <?php foreach ($categories as $category): ?>
        <?php if ($mobile) echo '<div class="pb-4">'; ?>
        <a class="moving-menu-page" href="<?= Url::to(['moving/moving/view', 'slug' => $category->slug])?>"> <?= $category->title ?></a>
        <?php if ($mobile) echo '</div>'; ?>
    <?php endforeach; ?>

    </p>
</div>
<div class="container params-moving pt-4 text-block">

    <?= $this->render('text_1'); ?>
    <?= $this->render('text_2'); ?>
    <?= $this->render('text_3'); ?>
    <?= $this->render('text_4'); ?>
    <?= $this->render('text_5'); ?>

    <?= ''
    //TODO Добавить Комментарии
    ?>
</div>
