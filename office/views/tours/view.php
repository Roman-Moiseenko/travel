<?php

use booking\entities\admin\User;
use booking\entities\admin\Legal;
use booking\entities\booking\tours\Tour;
use booking\entities\Lang;
use booking\helpers\StatusHelper;
use booking\helpers\ToursHelper;
use frontend\assets\MagnificPopupAsset;
use office\forms\ProviderLegalSearch;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $tour Tour */


$this->title = 'Тур: ' . $tour->name;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['index']];

\yii\web\YiiAsset::register($this);
MagnificPopupAsset::register($this);
?>
    <div class="user-view">

        <p>
            <?php if ($tour->status == StatusHelper::STATUS_VERIFY) {
                echo Html::a('Активировать', ['active', 'id' => $tour->id], ['class' => 'btn btn-warning']);
            } ?>

            <?php
            //TODO Добавить отдельное окно с выбором причины блокировки ... ?
            if ($tour->status == StatusHelper::STATUS_LOCK) {
                echo Html::a('Разблокировать', ['unlock', 'id' => $tour->id], ['class' => 'btn btn-success']);
            } else {
                echo Html::a('Заблокировать', ['lock', 'id' => $tour->id], ['class' => 'btn btn-danger']);
            }

            ?>

        </p>

        <div class="row" xmlns:fb="http://www.w3.org/1999/xhtml">
            <div class="col">
                <ul class="thumbnails">
                    <?php foreach ($tour->photos as $i => $photo): ?>
                        <li class="image-additional"><a class="thumbnail"
                                                        href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>">
                                <img src="<?= $photo->getThumbFileUrl('file', 'catalog_tours_additional'); ?>"
                                     alt="<?= $tour->name; ?>"/>
                            </a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-body">

                <?= DetailView::widget([
                    'model' => $tour,
                    'attributes' => [
                        [
                            'attribute' => 'id',
                            'label' => 'ID',
                        ],
                        [
                            'attribute' => 'name',
                            'format' => 'text',
                            'label' => 'Название',
                        ],
                        [
                            'attribute' => 'description',
                            'format' => 'ntext',
                            'label' => 'Описание',
                        ],

                        [
                            'attribute' => 'type_id',
                            'value' => ArrayHelper::getValue($tour, 'type.name'),
                            'label' => 'Главная категория',
                        ],
                        [
                            'label' => 'Дополнительные категории',
                            'value' => implode(', ', ArrayHelper::getColumn($tour->types, 'name')),
                        ],
                        [
                            'attribute' => 'params.duration',
                            'label' => 'Длительность (ч мин)',
                        ],
                        [
                            'attribute' => 'params.private',
                            'value' => ToursHelper::stringPrivate($tour->params->private),
                            'label' => 'Групповой/Индивидуальный',
                        ],
                        [
                            'attribute' => 'params.groupMin',
                            'label' => 'Минимальное кол-во в группе',
                        ],
                        [
                            'attribute' => 'params.groupMax',
                            'label' => 'Максимальное кол-во в группе',
                        ],
                        [
                            'label' => 'Ограничение по возрасту',
                            'value' => ToursHelper::ageLimit($tour->params->agelimit),
                        ],
                        [
                            'attribute' => 'baseCost.adult',
                            'label' => 'Билет для взрослых',
                        ],
                        [
                            'attribute' => 'baseCost.child',
                            'label' => 'Билет для детей',
                        ],
                        [
                            'attribute' => 'baseCost.preference',
                            'label' => 'Билет для льготных граждан',
                        ],
                        [
                            'attribute' => 'legal_id',
                            'label' => 'Организация',
                            'value' => function () use ($tour) {
                                $legal = Legal::findOne($tour->legal_id);
                                return $legal ? Html::a($legal->name, ['legals/view', 'id' => $tour->legal_id]) : '';
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'cancellation',
                            'label' => 'Отмена брони',
                            'value' => ToursHelper::cancellation($tour->cancellation),
                        ],
                    ],
                ]) ?>
            </div>
        </div>
        <!-- Координаты -->
        <div class="row pt-4">
            <div class="col">
                <div class="params-item-map">
                    <div class="row">
                        <div class="col-4">

                            <button class="btn btn-outline-secondary" type="button" data-toggle="collapse"
                                    data-target="#collapse-map"
                                    aria-expanded="false" aria-controls="collapse-map">
                                <i class="fas fa-map-marker-alt"></i>
                            </button>&#160;Место сбора:
                        </div>
                        <div class="col-8">
                            <?= $tour->params->beginAddress->address; ?>
                        </div>
                    </div>
                    <div class="collapse" id="collapse-map">
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-8">
                                    <input id="bookingaddressform-address" class="form-control" width="100%"
                                           value="<?= $tour->params->beginAddress->address ?? ' ' ?>" type="hidden">
                                </div>
                                <div class="col-2">
                                    <input id="bookingaddressform-latitude" class="form-control" width="100%"
                                           value="<?= $tour->params->beginAddress->latitude ?? '' ?>" type="hidden">
                                </div>
                                <div class="col-2">
                                    <input id="bookingaddressform-longitude" class="form-control" width="100%"
                                           value="<?= $tour->params->beginAddress->longitude ?? '' ?>" type="hidden">
                                </div>
                            </div>

                            <div class="row">
                                <div id="map-view" style="width: 100%; height: 300px"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="params-item-map">
                    <div class="row">
                        <div class="col-4">

                            <button class="btn btn-outline-secondary" type="button" data-toggle="collapse"
                                    data-target="#collapse-map-2"
                                    aria-expanded="false" aria-controls="collapse-map-2">
                                <i class="fas fa-map-marker-alt"></i>
                            </button>&#160;Место окончания:
                        </div>
                        <div class="col-8">
                            <?= $tour->params->endAddress->address; ?>
                        </div>
                    </div>
                    <div class="collapse" id="collapse-map-2">
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-8">
                                    <input id="bookingaddressform-address-2" class="form-control" width="100%"
                                           value="<?= $tour->params->endAddress->address ?? ' ' ?>" type="hidden">
                                </div>
                                <div class="col-2">
                                    <input id="bookingaddressform-latitude-2" class="form-control" width="100%"
                                           value="<?= $tour->params->endAddress->latitude ?? '' ?>" type="hidden">
                                </div>
                                <div class="col-2">
                                    <input id="bookingaddressform-longitude-2" class="form-control" width="100%"
                                           value="<?= $tour->params->endAddress->longitude ?? '' ?>" type="hidden">
                                </div>
                            </div>

                            <div class="row">
                                <div id="map-view-2" style="width: 100%; height: 300px"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="params-item-map">
                    <div class="row">
                        <div class="col-4">
                            <button class="btn btn-outline-secondary" type="button" data-toggle="collapse"
                                    data-target="#collapse-map-3"
                                    aria-expanded="false" aria-controls="collapse-map-2">
                                <i class="fas fa-map-marker-alt"></i>
                            </button>&#160;Место проведение:
                        </div>
                        <div class="col-8">
                            <?= $tour->address->address; ?>
                        </div>
                    </div>
                    <div class="collapse" id="collapse-map-3">
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-8">
                                    <input id="bookingaddressform-address-3" class="form-control" width="100%"
                                           value="<?= $tour->address->address ?? ' ' ?>" type="hidden">
                                </div>
                                <div class="col-2">
                                    <input id="bookingaddressform-latitude-3" class="form-control" width="100%"
                                           value="<?= $tour->address->latitude ?? '' ?>" type="hidden">
                                </div>
                                <div class="col-2">
                                    <input id="bookingaddressform-longitude-3" class="form-control" width="100%"
                                           value="<?= $tour->address->longitude ?? '' ?>" type="hidden">
                                </div>
                            </div>

                            <div class="row">
                                <div id="map-view-3" style="width: 100%; height: 300px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $js = <<<EOD
    $(document).ready(function() {
        $('.thumbnails').magnificPopup({
            type:'image',
            delegate: 'a',
            gallery: {
                enabled: true
            }
        });
    });
EOD;
$this->registerJs($js); ?>