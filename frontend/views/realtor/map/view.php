<?php



/* @var $this \yii\web\View */
/* @var $land  \booking\entities\realtor\land\Land */

use frontend\assets\LandAsset;
use yii\helpers\Url;

$this->title = 'Агентство Инвестиции в Калининградскую землю, деликатная купля-продажа участков для строительства дома и коммерческих зданий в области Карта участков';
$this->registerMetaTag(['name' => 'description', 'content' => 'Операции с землей в Калининграде - купля-продажа, инвестиции, закрытые сделки. Операции с землей в Калининграде - купля-продажа, инвестиции, закрытые сделки,']);

$this->params['canonical'] = Url::to(['/realtor/map'], true);
$this->params['breadcrumbs'][] = ['label' => 'Земля', 'url' => Url::to(['/realtor'])];
$this->params['breadcrumbs'][] = ['label' => 'Инвесторам', 'url' => Url::to(['/realtor/map'])];

$this->params['breadcrumbs'][] = $land->name;
LandAsset::register($this);
?>
<h1 class="pt-4 pb-2"><?= $land->title ?></h1>
<div class="item-responsive item-2-0by1">
    <div class="content-item">
        <img loading="lazy" src="<?=$land->getThumbFileUrl('photo', 'landing')?>" class="img-responsive-2" />
    </div>
</div>

<div class="params-moving pt-4">
    <?= $land->content ?>
</div>
<span id="ymap-params" data-api="<?= \Yii::$app->params['YandexAPI'] ?>" data-lang="ru_RU"></span>

<div id="map-land" data-id="<?= $land->id ?>" style="width: 100%; height: 600px;"></div>

<br>
Контакты позвоните
