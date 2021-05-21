<?php

use booking\entities\Lang;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Переезд на ПМЖ в Калининград - услуги, сервис, бизнес';
$this->registerMetaTag(['name' => 'description', 'content' => 'СЕО текст для переезда на ПМЖ в Калининград']);

$this->params['canonical'] = Url::to(['/moving'], true);

$image = \Yii::$app->params['staticHostInfo'] . '/files/images/moving/main_landing.jpg';
?>
<div class="item-responsive item-moving">
    <div class="content-item">
        <div class="item-class">
            <img data-src="<?= $image ?>" class="lazyload" alt="Переезд на ПМЖ в Калининград" width="100%">
            <div class="carousel-caption">
                <p class="landing-h1">Кёнигсберг</p>
                <h1 class="landing-h2">
                    <span class="line-t"></span><?= Lang::t('Переезд на ПМЖ в Калининград') ?><span
                            class="line-b"></span>
                </h1>
                <div class="container">
                    <div class="card"
                         style="background-color: rgba(255,255,255,0.8) !important;; border-radius: 20px">
                        <div class="card-body m-4 p-2"
                             style="text-align: justify; color: #000; text-shadow: 0 0 0">
                            <h2 style="text-align: center !important;">Как переехать в Калининград</h2>
                            <?= $this->render('_caption_text') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container pt-4 text-block">
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <?= $this->render('_menu_block', [
                'image' => 'menu-docs.jpg',
                'caption' => 'Документы для переезда',
                'text' => 'Раздел находится в разработке',
                'link' => Url::to(['/moving/docs'])
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6">
            <?= $this->render('_menu_block', [
                'image' => 'menu-housing.jpg',
                'caption' => 'Подбор недвижимости',
                'text' => 'Раздел находится в разработке',

                'link' => Url::to(['/moving/housing'])
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6">
            <?= $this->render('_menu_block', [
                'image' => 'menu-forum.jpg',
                'caption' => 'Форум. Отвечаем на вопросы',
                'text' => 'Раздел находится в разработке',

                'link' => Url::to(['/moving/faq'])
            ]) ?>
        </div>
    </div>
    <div class="row pt-3">
        <div class="col-md-4 col-sm-6">
            <?= $this->render('_menu_block', [
                'image' => 'menu-area.jpg',
                'caption' => 'Операции с землей',
                'text' => 'Раздел находится в разработке',
                'link' => Url::to(['/moving/ground'])
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6">
            <?= $this->render('_menu_block', [
                'image' => 'menu-bussines.jpg',
                'caption' => 'Приобретение готового бизнеса',
                'text' => 'Раздел находится в разработке',

                'link' => Url::to(['/moving/bussines'])
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6">

        </div>
    </div>

    <?= $this->render('text_1'); ?>
    <?= $this->render('text_2'); ?>
    <?= $this->render('text_3'); ?>
    <?= $this->render('text_4'); ?>

    <?=
    //TODO Добавить Комментарии
    '//TODO Добавить Комментарии'
    ?>
</div>
