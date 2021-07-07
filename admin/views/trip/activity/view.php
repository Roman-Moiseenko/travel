<?php

use booking\entities\booking\trips\activity\Activity;
use booking\entities\booking\trips\Trip;
use booking\helpers\CurrencyHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;


/* @var $this \yii\web\View */
/* @var $trip Trip|null */
/* @var $activity Activity */

$this->title = $activity->caption;
$this->params['id'] = $trip->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/trips']];
$this->params['breadcrumbs'][] = ['label' => $trip->name, 'url' => ['/trip/common', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = ['label' => 'Мероприятия', 'url' => ['/trip/activity', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = $activity->caption;
?>
<p>
    <?= Html::a('Редактировать', Url::to(['trip/activity/update', 'id' => $trip->id, 'activity_id' => $activity->id]), ['class' => 'btn btn-success']) ?>
</p>

<div class="card card-secondary">
    <div class="card-header with-border">Основные</div>
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $activity,
            'attributes' => [
                [
                    'attribute' => 'day',
                    'label' => 'День',
                ],
                [
                    'attribute' => 'time',
                    'label' => 'Врема',
                ],
                [
                    'attribute' => 'cost',
                    'value' => CurrencyHelper::stat($activity->cost),
                    'format' => 'raw',
                    'label' => 'Стоимость',
                ],
            ],
        ]) ?>
        <div class="pt-4">
        <?= Yii::$app->formatter->asHtml($activity->description, [
            'Attr.AllowedRel' => array('nofollow'),
            'HTML.SafeObject' => true,
            'Output.FlashCompat' => true,
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
        ]) ?>
        </div>
    </div>
</div>
<div class="card card-secondary">
    <div class="card-header with-border">Описание EN</div>
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $activity,
            'attributes' => [
                [
                    'attribute' => 'caption_en',
                    'label' => 'Заголовок (En)',
                ],
            ],
        ]) ?>
        <?= Yii::$app->formatter->asHtml($activity->description_en, [
            'Attr.AllowedRel' => array('nofollow'),
            'HTML.SafeObject' => true,
            'Output.FlashCompat' => true,
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
        ]) ?>
    </div>
</div>
<div class="card card-secondary">
    <div class="card-header with-border">Фото</div>
    <div class="card-body">
        <ul class="thumbnails">
            <?php foreach ($activity->photos as $i => $photo): ?>
                <li class="image-additional"><a class="thumbnail"
                                                href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>"
                                                target="_blank">
                        <img src="<?= $photo->getThumbFileUrl('file', 'cabinet_list'); ?>"
                             alt="<?= $activity->caption; ?>"/>
                    </a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-secondary">
            <div class="card-header with-border">Расположение</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <input id="bookingaddressform-address" class="form-control" width="100%" value="<?= $activity->address->address?>" disabled>
                    </div>
                    <div class="col-2">
                        <input id="bookingaddressform-latitude" class="form-control" width="100%" value="<?= $activity->address->latitude?>" disabled>
                    </div>
                    <div class="col-2">
                        <input id="bookingaddressform-longitude" class="form-control" width="100%" value="<?= $activity->address->longitude?>" disabled>
                    </div>
                </div>

                <div class="row">
                    <div id="map-view" style="width: 100%; height: 400px"></div>
                </div>
            </div>
        </div>
    </div>
</div>