<?php

use booking\entities\Lang;
use frontend\assets\LandAsset;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Купить или продать готовый участок в Калининграде';
$this->registerMetaTag(['name' => 'description', 'content' => 'Купить или продать готовый участок в Калининграде. Разместить свое объявление или подобрать участок для ИЖС']);

$this->params['canonical'] = Url::to(['/moving/area'], true);
$this->params['breadcrumbs'][] = ['label' => 'На ПМЖ', 'url' => Url::to(['/moving'])];
$this->params['breadcrumbs'][] = 'Земля';
?>
<h1>Купля-продажа готовых участков в Калининграде</h1>
<div class="pt-4"></div>
<div class="indent text-justify p-4">
Раздел находится в разработке
</div>
