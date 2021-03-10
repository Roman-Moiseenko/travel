<?php

use booking\entities\admin\User;
use booking\entities\admin\Legal;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\tours\Tour;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use booking\helpers\StatusHelper;
use booking\helpers\tours\TourHelper;
use frontend\assets\MagnificPopupAsset;
use office\forms\ProviderLegalSearch;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $stay Stay */


$this->title = 'Жилище: ' . $stay->name;
$this->params['breadcrumbs'][] = ['label' => 'Жилища', 'url' => ['index']];

\yii\web\YiiAsset::register($this);
MagnificPopupAsset::register($this);
?>
    <div class="user-view">

        <p>
            <?php if ($stay->isVerify()) {
                echo Html::a('Активировать', ['active', 'id' => $stay->id], ['class' => 'btn btn-warning']);
            } ?>

            <?php
            //TODO Добавить отдельное окно с выбором причины блокировки ... ?
            if ($stay->isLock()) {
                echo Html::a('Разблокировать', ['unlock', 'id' => $stay->id], ['class' => 'btn btn-success']);
            } else {
                echo Html::a('Заблокировать', ['lock', 'id' => $stay->id], ['class' => 'btn btn-danger']);
            }
            ?>

        </p>

        <div class="row" xmlns:fb="http://www.w3.org/1999/xhtml">
            <div class="col">
                <ul class="thumbnails">
                    <?php foreach ($stay->photos as $i => $photo): ?>
                        <li class="image-additional"><a class="thumbnail"
                                                        href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>">
                                <img src="<?= $photo->getThumbFileUrl('file', 'catalog_additional'); ?>"
                                     alt="<?= $stay->name; ?>"/>
                            </a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-body">

                <?= DetailView::widget([
                    'model' => $stay,
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
                            'value' => Yii::$app->formatter->asHtml($stay->description, [
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
                            'value' => Yii::$app->formatter->asHtml($stay->description_en, [
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
                            'value' => ArrayHelper::getValue($stay, 'type.name'),
                            'label' => 'Категория',
                        ],
//TODO Добавить просмотр других параметров
                        [
                            'attribute' => 'cost_base',
                            'label' => 'Базовая цена в сутки',
                        ],

                        [
                            'attribute' => 'legal_id',
                            'label' => 'Организация',
                            'value' => function () use ($stay) {
                                $legal = Legal::findOne($stay->legal_id);
                                return $legal ? Html::a($legal->name, ['legals/view', 'id' => $stay->legal_id]) : '';
                            },
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'Провайдер',
                            'value' => function () use ($stay) {
                                return Html::a($stay->user->username, ['providers/view', 'id' => $stay->user_id]);
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'cancellation',
                            'label' => 'Отмена брони',
                            'value' => BookingHelper::cancellation($stay->cancellation),
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
                            </button>&#160;Адрес:
                        </div>
                        <div class="col-8">
                            <?= $stay->address->address; ?>
                        </div>
                    </div>
                    <div class="collapse" id="collapse-map">
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-8">
                                    <input id="bookingaddressform-address" class="form-control" width="100%"
                                           value="<?= $stay->address->address ?? ' ' ?>" type="hidden">
                                </div>
                                <div class="col-2">
                                    <input id="bookingaddressform-latitude" class="form-control" width="100%"
                                           value="<?= $stay->address->latitude ?? '' ?>" type="hidden">
                                </div>
                                <div class="col-2">
                                    <input id="bookingaddressform-longitude" class="form-control" width="100%"
                                           value="<?= $stay->address->longitude ?? '' ?>" type="hidden">
                                </div>
                            </div>

                            <div class="row">
                                <div id="map-view" style="width: 100%; height: 300px"></div>
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