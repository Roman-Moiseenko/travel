<?php

use booking\entities\Lang;
use frontend\assets\LandAsset;
use frontend\widgets\templates\ImageH2Widget;
use yii\helpers\Url;

/* @var $this \yii\web\View */
$this->title = 'Агентство Инвестиции в Калининградскую землю, деликатная купля-продажа участков для строительства дома и коммерческих зданий в области Карта участков';
$this->registerMetaTag(['name' => 'description', 'content' => 'Операции с землей в Калининграде - купля-продажа, инвестиции, закрытые сделки. Операции с землей в Калининграде - купля-продажа, инвестиции, закрытые сделки,']);

$this->params['canonical'] = Url::to(['/realtor/map'], true);
$this->params['breadcrumbs'][] = ['label' => 'Агентство', 'url' => Url::to(['/lands'])];

$this->params['breadcrumbs'][] = 'Карта участков';
LandAsset::register($this);



?>
<h1>Деликатная купля-продажа земельных участков в Калининградской области</h1>

<?= ImageH2Widget::widget([
    'directory' => 'land',
    'image_file' => 'land_01.jpg',
    'alt' => 'Деликатная купля-продажа земельных участков в Калининградской области',
]); ?>
<div class="container params-moving pt-4 text-block">
    <ul class="pt-4">
        <li>Соблюдение «коммерческой тайны» инвестирования</li>
        <li>Большая база и возможности для поиска инвестора и подбора земли под застройку и т.п.</li>
        <li>Полный сервис от проверки юридической чистоты diligence, до разработки концепции и организации процесса
            девелопмента. Все специалисты – эксперты и лучшие практики в регионе
        </li>
    </ul>

    <p class="indent text-justify">
        Ищем участки расположенные внутри или перед жилым массивом, у прилегающей магистрали с оживленным трафиком.
        Участок должен обладать хорошей обзорностью.
        В 100 метровой зоне не должно быть детских и школьных учебных заведений, так как предполагается торговля в т.ч.
        алкоголем.
    </p>
    <p class="indent text-justify">
        Участок должен быть свободен от подземных и воздушных коммуникаций, построек, а также от обременений и
        сервитутов, с возможностью подъезда фуры, грузоподъемностью 10 тонн.
        Участок должен быть не менее 0.5Га, с возможностью размещения здания (пятно застройки от 1300 кв. м) и
        количеством машиномест не менее 70.
    </p>
    <p><i class="fas fa-phone"></i> 8-911-455-72-91</p>
    <p><i class="far fa-envelope"></i> <a href="mailto:yclaster@yandex.ru">yclaster@yandex.ru</a>
    </p>
</div>

<span id="ymap-params" data-api="<?= \Yii::$app->params['YandexAPI'] ?>" data-lang="<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>"></span>
<div id="map-land" style="width: 100%; height: 600px;"></div>
<div class="indent text-justify p-4">
    ...
</div>