<?php

use admin\widgest\StatusActionWidget;
use booking\entities\booking\tours\Tour;
use booking\helpers\BookingHelper;
use booking\helpers\StatusHelper;
use booking\helpers\tours\TourHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $tour Tour*/


$this->title = $tour->name;
$this->params['id'] = $tour->id;
$this->params['breadcrumbs'][] = ['label' => 'Экскурсии', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="form-group d-flex">
    <div>
        <?= StatusActionWidget::widget([
            'object_status' => $tour->status,
            'object_id' => $tour->id,
            'object_type' => BookingHelper::BOOKING_TYPE_TOUR,
        ]); ?>
    </div>
    <div class="ml-auto">
        <?= !empty($tour->public_at) ? ' Прошел модерацию <i class="far fa-calendar-alt"></i> ' . date('d-m-y', $tour->public_at) : ''?>
    </div>
</div>

<div class="tours-view">
    <div class="card card-secondary">
        <div class="card-header with-border">Описание</div>
        <div class="card-body">
            <?= Yii::$app->formatter->asHtml($tour->description, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Описание EN</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $tour,
                'attributes' => [
                    [
                        'attribute' => 'name_en',
                        'label' => 'Наименование (En)',
                    ],
                ],
            ]) ?>
            <?= Yii::$app->formatter->asHtml($tour->description_en, [
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
                        'model' => $tour,
                        'attributes' => [
                            [
                                'attribute' => 'type_id',
                                'value' => ArrayHelper::getValue($tour, 'type.name'),
                                'label' => 'Главная категория',
                            ],
                            [
                                'label' => 'Дополнительные категории',
                                'value' => implode(', ', ArrayHelper::getColumn($tour->types, 'name')),
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
                            <input id="bookingaddressform-address" class="form-control" width="100%" value="<?= $tour->address->address?>" disabled>
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-latitude" class="form-control" width="100%" value="<?= $tour->address->latitude?>" disabled>
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-longitude" class="form-control" width="100%" value="<?= $tour->address->longitude?>" disabled>
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
        <?= Html::a('Редактировать', Url::to(['/tour/common/update', 'id' => $tour->id]) ,['class' => 'btn btn-success']) ?>
    </div>


</div>
