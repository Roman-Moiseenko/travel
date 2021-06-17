<?php

use admin\widgest\StatusActionWidget;
use booking\entities\booking\trips\Trip;
use booking\helpers\BookingHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $trip Trip*/


$this->title = $trip->name;
$this->params['id'] = $trip->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/trips']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="form-group d-flex">
    <div>
        <?= StatusActionWidget::widget([
            'object_status' => $trip->status,
            'object_id' => $trip->id,
            'object_type' => BookingHelper::BOOKING_TYPE_TRIP,
        ]); ?>
    </div>
    <div class="ml-auto">
        <?= !empty($trip->public_at) ? ' Прошел модерацию <i class="far fa-calendar-alt"></i> ' . date('d-m-y', $trip->public_at) : ''?>
    </div>
</div>

<div class="trip-view">
    <div class="card card-secondary">
        <div class="card-header with-border">Описание</div>
        <div class="card-body">
            <?= Yii::$app->formatter->asHtml($trip->description, [
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
                'model' => $trip,
                'attributes' => [
                    [
                        'attribute' => 'name_en',
                        'label' => 'Наименование (En)',
                    ],
                ],
            ]) ?>
            <?= Yii::$app->formatter->asHtml($trip->description_en, [
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
                        'model' => $trip,
                        'attributes' => [
                            [
                                'attribute' => 'type_id',
                                'value' => ArrayHelper::getValue($trip, 'type.name'),
                                'label' => 'Главная категория',
                            ],
                            [
                                'label' => 'Дополнительные категории',
                                'value' => implode(', ', ArrayHelper::getColumn($trip->types, 'name')),
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['/trip/common/update', 'id' => $trip->id]) ,['class' => 'btn btn-success']) ?>
    </div>


</div>
