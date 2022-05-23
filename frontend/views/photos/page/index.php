<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */

$description = 'Фото Калининграда и области, неизвестные достопримечательности и уникальные места. Эксклюзивные кадры от нашего фотографа';
$this->registerMetaTag(['name' =>'description', 'content' => $description]);
$this->registerMetaTag(['name' =>'og:description', 'content' => $description]);
$this->params['canonical'] = Url::to(['/post'], true);
$this->title = 'Калининградская область в фотографиях - редкие снимки удивительных мест';
$this->params['breadcrumbs'][] = 'Калининградская область в фотографиях';
?>

<h1>Калининград в фотографиях</h1>

<div class="row">
<?php foreach ($dataProvider->getModels() as $model): ?>
<div class="col-sm-6 col-md-4 col-lg-3">
    <div class="card">
        <div class="card-body">
            ФОТО <br>
            <?= $model->title ?>
            ОПИСАНИЕ <br>
            теги
        </div>
    </div>

</div>

<?php endforeach;?>
</div>
