<?php

use yii\helpers\Url; ?>

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
            'link' => Url::to(['/forum/pereezd-na-pmzh'])
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
