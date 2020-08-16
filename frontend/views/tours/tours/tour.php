<?php

use booking\entities\booking\tours\Tour;
use booking\forms\booking\ReviewForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $tour Tour */

/* @var $reviewForm ReviewForm */

use booking\helpers\CurrencyHelper;
use booking\helpers\ToursHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\widgets\LegalWidget;
use frontend\widgets\RatingWidget;
use frontend\widgets\ReviewsToursWidget;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $tour->name;
$this->params['breadcrumbs'][] = ['label' => 'Список туров', 'url' => Url::to(['tours/index'])];
$this->params['breadcrumbs'][] = $this->title;

MagnificPopupAsset::register($this);
$countReveiws = $tour->countReviews();
?>
<!-- ФОТО  -->
<div class="row" xmlns:fb="http://www.w3.org/1999/xhtml">
    <div class="col">
        <ul class="thumbnails">
            <?php foreach ($tour->photos as $i => $photo): ?>
                <?php if ($i == 0): ?>
                    <li>
                        <a class="thumbnail" href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>">
                            <img src="<?= $photo->getThumbFileUrl('file', 'catalog_tours_main'); ?>"
                                 alt="<?= Html::encode($tour->name); ?>"/>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="image-additional">
                        <a class="thumbnail" href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>">&nbsp;
                            <img src="<?= $photo->getThumbFileUrl('file', 'catalog_tours_additional'); ?>"
                                 alt="<?= $tour->name; ?>"/>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<!-- ОПИСАНИЕ -->
<div class="row">
    <div class="col-8">
        <div class="row">
            <h1><?= Html::encode($tour->name) ?></h1> <!-- Заголовок тура-->
            <div class="col-8 params-tour">
                <p class="text-justify">
                    <?= \Yii::$app->formatter->asNtext($tour->description) ?>
                </p>
            </div>
            <div class="col-4">
                <?= LegalWidget::widget(['legal' => $tour->legal]) ?>
            </div>
        </div>
        <!-- Параметры -->
        <div class="row pt-4">
            <div class="col params-tour">
                <div class="container-hr">
                    <hr/>
                    <div class="text-left-hr">Параметры</div>
                </div>
                <span class="params-item">
                    <i class="far fa-clock"></i>&#160;&#160;<?= $tour->params->duration ?>
                </span>
                <span class="params-item">
                    <?php if ($tour->params->private) {
                        echo '<i class="fas fa-user"></i>&#160;&#160;Индивидуальный';
                    } else {
                        echo '<i class="fas fa-users"></i>&#160;&#160;Групповой';
                    }
                    ?>
                </span>
                <span class="params-item">
                    <i class="fas fa-user-friends"></i>&#160;&#160;<?= ToursHelper::group($tour->params->groupMin, $tour->params->groupMax) ?>
                </span>
                <span class="params-item">
                    <i class="fas fa-user-clock"></i>&#160;&#160;Ограничения по возрасту <?= ToursHelper::ageLimit($tour->params->agelimit) ?>
                </span>
                <span class="params-item">
                    <i class="fas fa-ban"></i>&#160;&#160;<?= ToursHelper::cancellation($tour->cancellation) ?>
                </span>
                <span class="params-item">
                    <i class="fas fa-layer-group"></i>&#160;&#160;
                                    <?php foreach ($tour->types as $type) {
                                        echo $type->name . ' | ';
                                    }
                                    echo $tour->type->name; ?>
                </span>
            </div>
        </div>
        <!-- Дополнения -->
        <div class="row pt-4">
            <div class="col">
                <div class="container-hr">
                    <hr/>
                    <div class="text-left-hr">Дополнения</div>
                </div>
                <table class="table table-bordered">
                    <tbody>
                    <?php foreach ($tour->extra as $extra): ?>
                        <?php if (!empty($extra->name)): ?>
                            <tr>
                                <th><?= Html::encode($extra->name) ?></th>
                                <td><?= Html::encode($extra->description) ?></td>
                                <td><?= Html::encode(CurrencyHelper::get($extra->cost)) ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Координаты -->
        <div class="row pt-4">
            <div class="col">
                <div class="container-hr">
                    <hr/>
                    <div class="text-left-hr">Координаты</div>
                </div>
                <div class="params-item-map">
                    Место сбора:&#160;
                    <button class="btn btn-outline-secondary" type="button" data-toggle="collapse"
                            data-target="#collapse-map"
                            aria-expanded="false" aria-controls="collapse-map">
                        <i class="fas fa-map-marker-alt"></i>
                    </button>
                    &#160;<?= $tour->params->beginAddress->address; ?>
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
                    Место окончания:&#160;
                    <button class="btn btn-outline-secondary" type="button" data-toggle="collapse"
                            data-target="#collapse-map-2"
                            aria-expanded="false" aria-controls="collapse-map-2">
                        <i class="fas fa-map-marker-alt"></i>
                    </button>
                    &#160;<?= $tour->params->endAddress->address; ?>
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
                    Место Проведение:&#160;
                    <button class="btn btn-outline-secondary" type="button" data-toggle="collapse"
                            data-target="#collapse-map-3"
                            aria-expanded="false" aria-controls="collapse-map-2">
                        <i class="fas fa-map-marker-alt"></i>
                    </button>
                    &#160;<?= $tour->address->address; ?>
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
        <!-- ОТЗЫВЫ -->
        <div class="row">
            <div class="col">
                <!-- Виджет подгрузки отзывов -->
                <div class="container-hr">
                    <hr/>
                    <div class="text-left-hr">Отзывы (<?= $countReveiws ?>)</div>
                </div>
                <div id="review">
                    <?= ReviewsToursWidget::widget(['tours' => $tour]); ?>
                </div>
                <button class="btn btn-outline-secondary" type="button" data-toggle="collapse"
                        data-target="#collapse-review"
                        aria-expanded="false" aria-controls="collapse-review">
                    Оставить отзыв
                </button>
                <div class="collapse" id="collapse-review">
                <?php if (Yii::$app->user->isGuest): ?>
                    <div class="card">
                        <div class="card-body">
                            Пожалуйста, <?= Html::a('авторизуйтесь', ['/auth/auth/login']) ?> для написания отзыва
                        </div>
                    </div>
                <?php else: ?>
                    <?php $form = ActiveForm::begin() ?>
                    <?= $form->field($reviewForm, 'vote')->dropDownList($reviewForm->voteList(), ['prompt' => '--- Выберите ---'])->label('Рейтинг'); ?>

                    <?= $form->field($reviewForm, 'text')->textarea(['rows' => 5])->label('Отзыв'); ?>

                    <div class="form-group">
                        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
                    </div>
                    <?php ActiveForm::end() ?>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- КУПИТЬ БИЛЕТЫ -->
    <div class="col-4">
        <div class="btn-group">
            <button type="button" data-toggle="tooltip" class="btn btn-default" title="В избранное"
                    href="<?= Url::to(['/cabinet/wishlist/add', 'id' => $tour->id]) ?>" data-method="post">
                <i class="fa fa-heart"></i>
            </button>
        </div>

        <?= $this->render('_booking', [
                'tour' => $tour,
]); ?>
        <div class="rating">
            <p>
                <?= RatingWidget::widget(['rating' => $tour->rating]); ?>
                <a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">
                    <?= $countReveiws ?> отзывов</a>
                &nbsp;/&nbsp;<a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">Написать
                    отзыв</a>
            </p>
            <hr>

            <div class="addthis_toolbox addthis_default_style"
                 data-url="https://demo.opencart.com/index.php?route=product/product&amp;product_id=47">
                <a class="addthis_button_facebook_like" fb:like:layout="button_count">
                </a> <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a>
                <a class="addthis_counter addthis_pill_style"></a></div>
            <script type="text/javascript"
                    src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>

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
