<?php

use booking\entities\Lang;
use booking\helpers\SysHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Переезд на ПМЖ в Калининград - услуги недвижимость бизнес';
$this->registerMetaTag(['name' => 'description', 'content' => 'Окажем помощь в организации переезда на ПМЖ в Калининград, 
подберем недвижимость, земельный учатосток. Организуем строительство собственного дома на земельном участке в Калининграде. 
Консультации инвестиций в бизнес в Калининграде ']);

$this->params['canonical'] = Url::to(['/moving'], true);
$mobile = SysHelper::isMobile();
$image = \Yii::$app->params['staticHostInfo'] . '/files/images/moving/main_landing.jpg';
?>
<?php if ($mobile): ?>
    <h1 class="landing-moving-h1 pb-2" style="text-align: center !important;"><span
                style="font-size: 36px; text-align: center">Калининградская область</span><br>
        <span class="landing-h2">
                <span class="line-t"></span><?= Lang::t('Переезд на ПМЖ') ?><span
                    class="line-b"></span>
            </span>
    </h1>
    <div class="card"
         style="background-color: rgba(255,255,255,0.8) !important;; border-radius: 20px">
        <div class="card-body m-4 p-2"
             style="text-align: justify; color: #000; text-shadow: 0 0 0">
            <h2 style="text-align: center !important;">Как переехать в Калининград</h2>
            <?= $this->render('_caption_text') ?>
        </div>
    </div>
<?php else: ?>
    <div class="item-responsive item-moving">
        <div class="content-item">
            <div class="item-class">
                <div class="item-responsive item-4-3by1">
                    <div class="content-item">
                        <img src="<?= $image ?>" loading="lazy" alt="Переезд на ПМЖ в Калининград" width="100%">
                    </div>
                </div>
                <div class="carousel-caption">
                    <h1 class="landing-moving-h1 py-2">Калининградская область<br>
                        <span class="landing-h2">
                <span class="line-t"></span><?= Lang::t('Переезд на ПМЖ') ?><span
                                    class="line-b"></span>
            </span>
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
<?php endif; ?>

<div class="container params-moving pt-4 text-block">
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <?= $this->render('_menu_block', [
                'image' => 'menu-info.jpg',
                'caption' => 'Информация для переезжающих',
                'text' => 'Блок содержит ряд статей с полезной информацией для переезжающих на ПМЖ в Калининград',
                'link' => Url::to(['/moving/moving/view', 'slug' => 'info'])
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6">
            <?= $this->render('_menu_block', [
                'image' => 'menu-realty.jpg',
                'caption' => 'Подбор недвижимости',
                'text' => 'Обзор рынка недвижимости Калининградской области, подбор недвижимости в Калининграде',
                'link' => Url::to(['/moving/realty'])
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6">
            <?= $this->render('_menu_block', [
                'image' => 'menu-forum.jpg',
                'caption' => 'Форум. Отвечаем на вопросы',
                'text' => 'Задайте вопрос по интересующей Вас теме по переезду в Калининград и наши специалисты Вам ответят',
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
                'link' => Url::to(['/moving/land'])
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
            <?= '' /* $this->render('_menu_block', [
                'image' => 'menu-docs.jpg',
                'caption' => 'Документы для переезда',
                'text' => 'Раздел находится в разработке',
                'link' => Url::to(['/moving/docs'])
            ]) */?>
        </div>
    </div>
    <?= $this->render('text_1'); ?>
    <?= $this->render('text_2'); ?>
    <?= $this->render('text_3'); ?>
    <?= $this->render('text_4'); ?>
    <?= $this->render('text_5'); ?>

    <?= ''
    //TODO Добавить Комментарии
    ?>
</div>
