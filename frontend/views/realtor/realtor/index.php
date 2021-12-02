<?php

use booking\entities\Lang;
use frontend\assets\LandAsset;
use frontend\widgets\info\AgentRealtorWidget;
use frontend\widgets\templates\ImageH2Widget;
use yii\helpers\Url;

/* @var $this \yii\web\View */
$this->title = 'Приобретем Вашу землю в Калининградской области. Соблюдаем Коммерческую тайну';
$description = 'Приобретем Вашу землю в Калининградской области. Соблюдаем Коммерческую тайну, полный сервис от проверки юридической чистоты, до разработки концепции и организации процесса девелопмента';
$this->registerMetaTag(['name' => 'description', 'content' => $description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $description]);

$this->params['canonical'] = Url::to(['/realtor/map'], true);
$this->params['breadcrumbs'][] = ['label' => 'Земля', 'url' => Url::to(['/realtor'])];
$this->params['breadcrumbs'][] = 'Покупка';
LandAsset::register($this);


?>
<h1>Деликатная покупка Ваших земельных участков в Калининградской области</h1>

<?= ImageH2Widget::widget([
    'directory' => 'realtor',
    'image_file' => 'land_01.jpg',
    'alt' => 'Деликатная купля-продажа земельных участков в Калининградской области',
]); ?>
<h2 class="pt-5">Выкупим дорого землю под МКД (ИЖД) или коммерческую недвижимость</h2>
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
    <!--p><i class="fas fa-phone"></i> 8-911-455-72-91</p>
    <p><i class="far fa-envelope"></i> <a href="mailto:yclaster@yandex.ru">yclaster@yandex.ru</a>
    </p-->
    <?= AgentRealtorWidget::widget() ?>
</div>
