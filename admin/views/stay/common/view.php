<?php

use admin\widgest\StatusActionWidget;
use booking\entities\booking\stays\Stay;
use booking\helpers\BookingHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $stay Stay*/


$this->title = $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Жилье', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="form-group d-flex">
    <div>
        <?= StatusActionWidget::widget([
            'object_status' => $stay->status,
            'object_id' => $stay->id,
            'object_type' => BookingHelper::BOOKING_TYPE_STAY,
        ]); ?>
    </div>
    <div class="ml-auto">
        <?= !empty($stay->public_at) ? ' Прошел модерацию <i class="far fa-calendar-alt"></i> ' . date('d-m-y', $stay->public_at) : ''?>
    </div>
</div>

<div class="stay-view">
    <div class="card card-info">
        <div class="card-header with-border">Описание</div>
        <div class="card-body">
            <?= Yii::$app->formatter->asHtml($stay->description, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>
    <div class="card card-info">
        <div class="card-header with-border">Описание EN</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $stay,
                'attributes' => [
                    [
                        'attribute' => 'name_en',
                        'label' => 'Наименование (En)',
                    ],
                    [
                        'attribute' => 'type_id',
                        'value' => ArrayHelper::getValue($stay, 'type.name'),
                        'label' => 'Тип жилья',
                    ],
                ],
            ]) ?>
            <?= Yii::$app->formatter->asHtml($stay->description_en, [
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
            <div class="card card-info">
                <div class="card-header with-border">Расположение</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <input id="bookingaddressform-address" class="form-control" width="100%" value="<?= $stay->address->address?>" disabled>
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-latitude" class="form-control" width="100%" value="<?= $stay->address->latitude?>" disabled>
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-longitude" class="form-control" width="100%" value="<?= $stay->address->longitude?>" disabled>
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
        <?= Html::a('Редактировать', Url::to(['/stay/common/update', 'id' => $stay->id]) ,['class' => 'btn btn-success']) ?>
    </div>


</div>
