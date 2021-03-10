<?php

use booking\entities\admin\Legal;
use booking\entities\booking\cars\Car;
use booking\helpers\BookingHelper;
use booking\helpers\cars\CarHelper;
use booking\helpers\StatusHelper;
use frontend\assets\MagnificPopupAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $car Car */


$this->title = 'Авто: ' . $car->name;
$this->params['breadcrumbs'][] = ['label' => 'Авто', 'url' => ['index']];

\yii\web\YiiAsset::register($this);
MagnificPopupAsset::register($this);
?>
    <div class="user-view">

        <p>
            <?php if ($car->isVerify()) {
                echo Html::a('Активировать', ['active', 'id' => $car->id], ['class' => 'btn btn-warning']);
            } ?>

            <?php
            //TODO Добавить отдельное окно с выбором причины блокировки ... ?
            if ($car->isLock()) {
                echo Html::a('Разблокировать', ['unlock', 'id' => $car->id], ['class' => 'btn btn-success']);
            } else {
                echo Html::a('Заблокировать', ['lock', 'id' => $car->id], ['class' => 'btn btn-danger']);
            }
            ?>

        </p>

        <div class="row" xmlns:fb="http://www.w3.org/1999/xhtml">
            <div class="col">
                <ul class="thumbnails">
                    <?php foreach ($car->photos as $i => $photo): ?>
                        <li class="image-additional"><a class="thumbnail"
                                                        href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>">
                                <img src="<?= $photo->getThumbFileUrl('file', 'catalog_additional'); ?>"
                                     alt="<?= $car->name; ?>"/>
                            </a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-body">

                <?= DetailView::widget([
                    'model' => $car,
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
                            'value' => Yii::$app->formatter->asHtml($car->description, [
                                'Attr.AllowedRel' => array('nofollow'),
                                'HTML.SafeObject' => true,
                                'Output.FlashCompat' => true,
                                'HTML.SafeIframe' => true,
                                'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                            ]),
                            'format' => 'raw',
                            'label' => 'Описание',
                        ],
                        [
                            'attribute' => 'name_en',
                            'format' => 'text',
                            'label' => 'Название (En)',
                        ],
                        [
                            'attribute' => 'description_en',
                            'value' => Yii::$app->formatter->asHtml($car->description_en, [
                                'Attr.AllowedRel' => array('nofollow'),
                                'HTML.SafeObject' => true,
                                'Output.FlashCompat' => true,
                                'HTML.SafeIframe' => true,
                                'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                            ]),
                            'format' => 'raw',
                            'label' => 'Описание (En)',
                        ],
                        [
                            'attribute' => 'type_id',
                            'value' => ArrayHelper::getValue($car, 'type.name'),
                            'label' => 'Категория',
                        ],
                        [
                            'label' => 'Ограничение по возрасту',
                            'value' => BookingHelper::ageLimit($car->params->age),
                        ],
                        [
                            'attribute' => 'cost',
                            'label' => 'Цена проката',
                        ],
                        [
                            'attribute' => 'params.min_rent',
                            'label' => 'Минимальное бронирование (сут)',
                        ],
                        [
                            'attribute' => 'params.license',
                            'label' => 'Водительские права',
                        ],
                        [
                            'attribute' => 'params.experience',
                            'label' => 'Стаж',
                        ],
                        [
                            'attribute' => 'params.delivery',
                            'value' => StatusHelper::yes_no($car->params->delivery, ['no' => 'warning']),
                            'format' => 'raw',
                            'label' => 'Доставка до адреса',
                        ],
                        [
                            'attribute' => 'legal_id',
                            'label' => 'Организация',
                            'value' => function () use ($car) {
                                $legal = Legal::findOne($car->legal_id);
                                return $legal ? Html::a($legal->name, ['legals/view', 'id' => $car->legal_id]) : '';
                            },
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'Провайдер',
                            'value' => function () use ($car) {
                                return Html::a($car->user->username, ['providers/view', 'id' => $car->user_id]);
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'cancellation',
                            'label' => 'Отмена брони',
                            'value' => BookingHelper::cancellation($car->cancellation),
                        ],
                    ],
                ]) ?>
            </div>
        </div>
        <!-- Координаты -->
        <div class="row pt-4">
            <div class="col-md-12">
                <div class="card card-secondary">
                    <div class="card-header with-border">Характеристики Авто</div>
                    <div class="card-body">
                        <table class="table table-adaptive table-striped table-bordered">
                            <tbody>
                            <?php foreach ($car->values as $value): ?>
                                <tr>
                                    <td data-label="Характеристика"><?= $value->characteristic->name ?></td>
                                    <td data-label="Значение"><?= $value->value ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-4">
            <div class="col-md-12">
                <div class="card card-secondary">
                    <div class="card-header with-border">Точки выдачи/приема Авто</div>
                    <div class="card-body">
                        <div id="count-points" data-count="<?= count($car->address)?>">
                            <?php foreach ($car->address as $i => $address): ?>
                                <input type="hidden" id="address-<?= ($i+1)?>" value="<?= $address->address?>">
                                <input type="hidden" id="latitude-<?= ($i+1)?>" value="<?= $address->latitude?>">
                                <input type="hidden" id="longitude-<?= ($i+1)?>" value="<?= $address->longitude?>">
                            <?php endforeach;?>
                        </div>
                        <div class="row">
                            <div id="map-car-view" style="width: 100%; height: 200px"></div>
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