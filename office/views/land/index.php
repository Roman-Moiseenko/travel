<?php


/* @var $this yii\web\View */

use office\assets\LandAsset;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Земельные участки';
$this->params['breadcrumbs'][] = $this->title;
LandAsset::register($this);
?>

<div>
    <p>
        <?= ''//Html::a('Создать Участок', Url::to(['create']), ['class' => 'btn btn-success'])  ?>
        <button id="add-land" class="btn btn-success" data-toggle="modal"
                data-target="#landModal">Создать Участок
        </button>
        <span id="caption-edit" style="color: #333"></span>
        <button id="stop-land" class="btn btn-danger" style="display: none">Сохранить</button>
    </p>
    <div id="map-land" style="width: 100%; height: 700px;"></div>
</div>
<div class="modal fade" id="landModal" tabindex="-1" role="dialog" aria-labelledby="translateModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="translateModalLabel">Земельный участок</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group field-landform-name required">
                    <label for="land-name">Название участка</label>
                    <input type="text" id="land-name" class="form-control" name="LandForm[name]" aria-required="true">

                </div>
                <div class="form-group field-landform-min_price required">
                    <label for="land-min_price">Мин.цена за 1га</label>
                    <input type="text" id="land-min_price" class="form-control" name="LandForm[min_price]"
                           aria-required="true">
                </div>

                <div class="form-group field-landform-count">
                    <label for="land-count">Кол-во участков</label>
                    <input type="text" id="land-count" class="form-control" name="LandForm[count]">
                </div>
            <div class="modal-footer">
                <div class="form-group">
                    <button type="button" id="start-land" class="btn btn-info" data-dismiss="modal">Начать рисовать</button>
                </div>
            </div>
        </div>
    </div>
</div>