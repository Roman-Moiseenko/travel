<?php



/* @var $this \yii\web\View */
/* @var $land  \booking\entities\realtor\land\Land */

use frontend\assets\LandAsset;
use frontend\widgets\info\AgentRealtorWidget;
use yii\helpers\Url;

$this->title = $land->meta->title;
$this->registerMetaTag(['name' => 'description', 'content' => $land->meta->description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $land->meta->description]);

$this->params['canonical'] = Url::to(['/realtor/map/view', 'slug' => $land->slug], true);
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

<div id="map-land" data-id="<?= $land->id ?>" style="width: 100%; height: 400px;"></div>


<h2 class="pt-5">Получить консультацию по инвестициям в земельный участок</h2>
<?= AgentRealtorWidget::widget() ?>
