<?php

use booking\entities\booking\tours\Tours;
use booking\entities\Lang;
use booking\forms\booking\tours\ToursCommonForms;
use booking\helpers\ToursTypeHelper;
use kartik\widgets\FileInput;
//use mihaildev\ckeditor\CKEditor;
use shop\helpers\PriceHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $tours Tours*/


$this->title = 'Тур ' . $tours->name;
$this->params['id'] = $tours->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tours-view">
    <div class="card card-secondary">
        <div class="card-header with-border">Описание</div>
        <div class="card-body">
            <?= Yii::$app->formatter->asHtml($tours->description, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Категории</div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $tours,
                        'attributes' => [
                            [
                                'attribute' => 'type_id',
                                'value' => ArrayHelper::getValue($tours, 'type.name'),
                                'label' => 'Главная категория',
                            ],
                            [
                                'label' => 'Дополнительные категории',
                                'value' => implode(', ', ArrayHelper::getColumn($tours->types, 'name')),
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Расположение</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <input id="bookingaddressform-address" class="form-control" width="100%" value="<?= $tours->address->address?>" disabled>
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-latitude" class="form-control" width="100%" value="<?= $tours->address->latitude?>" disabled>
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-longitude" class="form-control" width="100%" value="<?= $tours->address->longitude?>" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div id="map-view" style="width: 100%; height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['/tours/common/update', 'id' => $tours->id]) ,['class' => 'btn btn-success']) ?>
    </div>
    

</div>

