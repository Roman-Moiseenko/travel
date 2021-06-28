<?php

use booking\entities\Lang;
use frontend\assets\LandAsset;
use yii\helpers\Url;

/* @var $this \yii\web\View */
$this->title = 'Карта участков в Калининградской области';
$this->registerMetaTag(['name' => 'description', 'content' => 'Операции с землей в Калининграде - купля-продажа, инвестиции, закрытые сделки,']);

$this->params['canonical'] = Url::to(['/land/map'], true);
$this->params['breadcrumbs'][] = ['label' => 'Агентство', 'url' => Url::to(['/lands'])];

$this->params['breadcrumbs'][] = 'Карта участков';
LandAsset::register($this);



?>
<h1>Операции с землей в Калининграде</h1>
<div class="pt-4"></div>
<div class="indent text-justify p-4">
    Раздел находится в разработке
</div>
<span id="ymap-params" data-api="<?= \Yii::$app->params['YandexAPI'] ?>" data-lang="<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>"></span>
<div id="map-land" style="width: 100%; height: 600px;"></div>
<div class="indent text-justify p-4">
    СЕО текст
</div>