<?php

use booking\entities\moving\agent\Agent;
use booking\helpers\scr;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $agent Agent|null */

$this->title = 'Представитель ' . $agent->person->getShortname();
$this->params['breadcrumbs'][] = ['label' => 'Регионы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $agent->region->name, 'url' => ['view-region', 'id' => $agent->region->id]];
$this->params['breadcrumbs'][] = $agent->person->getShortname();
?>

<p>
    <?= Html::a('Редактировать', ['update-agent', 'id' => $agent->id], ['class' => 'btn btn-success']) ?>

</p>
<img class="img-responsive" src="<?= $agent->getThumbFileUrl('photo', 'profile') ?>"/>
<div class="card card-secondary">
    <div class="card-header with-border">Основные</div>
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $agent,
            'attributes' => [
                [
                    'attribute' => 'person_surname',
                    'value' => $agent->person->getFullname(),
                    'label' => 'ФИО',
                ],

                [
                    'attribute' => 'email',
                    'label' => 'Email',
                ],
                [
                    'attribute' => 'phone',
                    'label' => 'Телефон',
                ],
                [
                    'attribute' => 'type',
                    'value' => $agent->getStringType(),
                    'label' => 'Тип',
                ],

            ],
        ]) ?>
    </div>
</div>
<div class="card card-secondary">
    <div class="card-header with-border">Описание</div>
    <div class="card-body">
        <?= Yii::$app->formatter->asHtml($agent->description, [
            'Attr.AllowedRel' => array('nofollow'),
            'HTML.SafeObject' => true,
            'Output.FlashCompat' => true,
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
        ]) ?>
    </div>
</div>
<div class="card card-secondary">
    <div class="card-header with-border">Расположение</div>
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <input id="bookingaddressform-address" class="form-control" width="100%" value="<?= $agent->address->address?>" disabled>
            </div>
            <div class="col-2">
                <input id="bookingaddressform-latitude" class="form-control" width="100%" value="<?= $agent->address->latitude?>" disabled>
            </div>
            <div class="col-2">
                <input id="bookingaddressform-longitude" class="form-control" width="100%" value="<?= $agent->address->longitude?>" disabled>
            </div>
        </div>

        <div class="row">
            <div id="map-view" style="width: 100%; height: 400px" data-restrict="no"></div>
        </div>
    </div>
</div>