<?php

use booking\entities\Lang;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Недвижимость для переезжающих на ПМЖ в Калининград - стоимость жилья и земельных участков под строительство, побережье, рынок жилья';
$this->registerMetaTag(['name' => 'description', 'content' => 'Недвижимость для переезжающих на ПМЖ в Калининград, подбор домов, застройщиков']);

$this->params['canonical'] = Url::to(['/moving/realty'], true);
$this->params['breadcrumbs'][] = ['label' => 'На ПМЖ', 'url' => Url::to(['/moving'])];
$this->params['breadcrumbs'][] = 'Недвижимость';
?>
<h1>Обзор рынка недвижимости Калининградской области</h1>
<div class="pt-4"></div>
<div class="container params-moving pt-4 text-block">
    <?= $this->render('text_1'); ?>
    <?= $this->render('text_2'); ?>
    <?= $this->render('text_3'); ?>
</div>

