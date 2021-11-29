<?php



/* @var $this \yii\web\View */
/* @var $land \booking\entities\realtor\land\Land */

use office\assets\LandAsset;

$this->title = 'Нарисовать Участок ' . $land->name;
$this->params['breadcrumbs'][] = ['label' => 'Инвестиционные участки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $land->name, 'url' => ['view', 'id' => $land->id]];
$this->params['breadcrumbs'][] = 'Нарисовать';
LandAsset::register($this);
?>


    <p>
    <div class="form-group">
        <button type="button" id="start-land" class="btn btn-info" data-dismiss="modal">Начать рисовать</button>
    </div>
        <span id="caption-edit" style="color: #333"></span>
        <button id="stop-land" class="btn btn-danger" style="display: none">Сохранить</button>
    </p>
    <p>
        <?= \yii\helpers\Html::a('Очистить', \yii\helpers\Url::to(['clear-points', 'id' => $land->id]), ['class' => 'btn btn-warning']) ?>
    </p>
    <div id="map-land" style="width: 100%; height: 700px;" data-id="<?= $land->id ?>"></div>

