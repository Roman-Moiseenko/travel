<?php

use admin\widgest\StatusActionWidget;
use booking\entities\booking\funs\Fun;
use booking\helpers\BookingHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $fun Fun*/


$this->title = $fun->name;
$this->params['id'] = $fun->id;
$this->params['breadcrumbs'][] = ['label' => 'Развлечения', 'url' => ['/funs']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="form-group d-flex">
    <div>
        <?= StatusActionWidget::widget([
            'object_status' => $fun->status,
            'object_id' => $fun->id,
            'object_type' => BookingHelper::BOOKING_TYPE_FUNS,
        ]); ?>
    </div>
    <div class="ml-auto">
        <?= !empty($fun->public_at) ? ' Прошел модерацию <i class="far fa-calendar-alt"></i> ' . date('d-m-y', $fun->public_at) : ''?>
    </div>
</div>

<div class="funs-view">
    <div class="card card-secondary">
        <div class="card-header with-border">Описание</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $fun,
                'attributes' => [
                    [
                        'attribute' => 'type_id',
                        'value' => ArrayHelper::getValue($fun, 'type.name'),
                        'label' => 'Категория',
                    ],
                ],
            ]) ?><br>
            <?= Yii::$app->formatter->asHtml($fun->description, [
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
                'model' => $fun,
                'attributes' => [
                    [
                        'attribute' => 'name_en',
                        'label' => 'Наименование (En)',
                    ],
                ],
            ]) ?>
            <?= Yii::$app->formatter->asHtml($fun->description_en, [
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
                <div class="card-header with-border">Расположение</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <input id="bookingaddressform-address" class="form-control" width="100%" value="<?= $fun->address->address?>" disabled>
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-latitude" class="form-control" width="100%" value="<?= $fun->address->latitude?>" disabled>
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-longitude" class="form-control" width="100%" value="<?= $fun->address->longitude?>" disabled>
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
        <?= Html::a('Редактировать', Url::to(['/fun/common/update', 'id' => $fun->id]) ,['class' => 'btn btn-success']) ?>
    </div>


</div>
