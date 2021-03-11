<?php

use booking\entities\booking\cars\Car;
use booking\entities\Lang;
use booking\forms\booking\ReviewForm;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\SysHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\widgets\LegalWidget;
use frontend\widgets\RatingWidget;
use frontend\widgets\reviews\NewReviewCarWidget;
use frontend\widgets\reviews\ReviewsWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $car Car */
/* @var $reviewForm ReviewForm */

$this->registerMetaTag(['name' =>'description', 'content' => Html::encode(StringHelper::truncateWords(strip_tags($car->getDescription()), 20))]);

$this->title = $car->getName();
$this->params['breadcrumbs'][] = ['label' => Lang::t('Список авто'), 'url' => Url::to(['cars/index'])];
$this->params['breadcrumbs'][] = $this->title;

MagnificPopupAsset::register($this);
MapAsset::register($this);

$mobile = SysHelper::isMobile();

$countReveiws = $car->countReviews();
?>
<!-- ФОТО  -->
<div class="row" xmlns:fb="https://www.w3.org/1999/xhtml" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col-sm-12">
        <ul class="thumbnails">
            <?php foreach ($car->photos as $i => $photo): ?>
                <?php if ($i == 0): ?>
                    <li>
                        <div itemscope itemtype="https://schema.org/ImageObject">
                            <a class="thumbnail" href="<?= $photo->getImageFileUrl('file') ?>">
                            <img src="<?= $photo->getThumbFileUrl('file', 'catalog_main'); ?>"
                                 alt="<?= $car->getName() . '. ' . Lang::t($photo->alt) ?>" class="card-img-top" itemprop="contentUrl"/>
                            </a>
                        <meta itemprop="name" content="<?= $car->getName() . '. ' . Lang::t($photo->alt) ?>">
                        <meta itemprop="description" content="<?= strip_tags($car->getDescription()) ?>">
                        </div>
                    </li>
                <?php else: ?>
                    <li class="image-additional">
                        <div itemscope itemtype="https://schema.org/ImageObject">
                        <a class="thumbnail" href="<?= $photo->getImageFileUrl('file') ?>">&nbsp;
                            <img src="<?= $photo->getThumbFileUrl('file', 'catalog_additional'); ?>"
                                 alt="<?= $car->getName() . '. ' . Lang::t($photo->alt) ?>" itemprop="contentUrl"/>
                        </a>
                            <meta itemprop="name" content="<?= $car->getName() . '. ' . Lang::t($photo->alt) ?>">
                            <meta itemprop="description" content="<?= strip_tags($car->getDescription()) ?>">
                        </div>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<!-- ОПИСАНИЕ -->
<div class="row pt-2" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col-sm-8 <?= $mobile ? ' ml-2' : '' ?>">
        <!-- Заголовок авто-->
        <div class="row pb-3">
            <div class="col-12">
                <div class="d-flex align-items-center">
                    <div class="mr-auto">
                        <h1><?= Html::encode($car->getName()) ?></h1>
                    </div>
                    <div class="btn-group">
                        <button type="button" data-toggle="tooltip" class="btn btn-info btn-wish"
                                title="<?= Lang::t('В избранное') ?>"
                                href="<?= Url::to(['/cabinet/wishlist/add-car', 'id' => $car->id]) ?>"
                                data-method="post">
                            <i class="fa fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Описание -->
        <div class="row">
            <div class="col-sm-9 params-tour text-justify">
                <?= Yii::$app->formatter->asHtml($car->getDescription(), [
                    'Attr.AllowedRel' => array('nofollow'),
                    'HTML.SafeObject' => true,
                    'Output.FlashCompat' => true,
                    'HTML.SafeIframe' => true,
                    'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                ]) ?>

            </div>
            <div class="col-sm-3">
                <?= LegalWidget::widget(['legal' => $car->legal]) ?>
            </div>
        </div>
        <!-- Стоимость -->
        <div class="row pt-4">
            <div class="col params-tour">
                <div class="container-hr">
                    <hr/>
                    <div class="text-left-hr"><?= Lang::t('Стоимость') ?></div>
                </div>
                <span class="params-item">
                        <i class="fas fa-car"></i>&#160;&#160;<?= Lang::t('Цена в сутки') ?> <span
                                class="price-view">
                            <?= CurrencyHelper::get($car->cost) ?>
                        </span>
                    </span>
                <p></p>

                <span class="params-item">
                        <i class="fas fa-wallet"></i>&#160;&#160;<?= Lang::t('Залог') ?> <span
                            class="price-view">
                            <?= CurrencyHelper::get($car->deposit) ?>
                        </span>
                    </span>
                <p></p>
                <?php if ($car->discount_of_days):?>
                    <span class="params-item">
                        <i class="fas fa-percent"></i>&#160;&#160;<?= Lang::t('Скидка при прокате более чем на 3 суток') . ' - '?> <span
                                class="price-view">
                            <?= $car->discount_of_days . ' %' ?>
                        </span>
                    </span>
                    <p></p>
                <?php endif; ?>
                <span class="params-item">
                    <i class="fas fa-star-of-life"></i>&#160;&#160;<?= Lang::t('Стоимость проката может меняться в зависимости от даты') ?>
                </span>
            </div>
        </div>
        <!-- Параметры -->
        <div class="row pt-4">
            <div class="col params-tour">
                <div class="container-hr">
                    <hr/>
                    <div class="text-left-hr"><?= Lang::t('Параметры') ?></div>
                </div>
                <span class="params-item">
                    <i class="fas fa-hourglass-start"></i>&#160;&#160;
                    <?= Lang::t('Минимальное бронирование ') . $car->params->min_rent . Lang::t(' д')?>
                </span>
                <span class="params-item">
                    <i class="fas fa-id-card"></i>&#160;&#160;
                    <?= Lang::t('Категория прав: ') . (($car->params->license == 'none') ? Lang::t('не требуются') : $car->params->license)?>
                </span>
                <?php if ($car->params->experience != 0): ?>
                    <span class="params-item">
                    <i class="fas fa-walking"></i>&#160;&#160;
                    <?= Lang::t('Требуется стаж (лет): ') . $car->params->experience?>
                    </span>
                <?php endif; ?>
                <span class="params-item">
                    <i class="fas fa-user-clock"></i>&#160;&#160;<?= Lang::t('Ограничения по возрасту') . ' ' . BookingHelper::ageLimit($car->params->age) ?>
                </span>
                <span class="params-item">
                    <i class="fas fa-ban"></i>&#160;&#160;<?= BookingHelper::cancellation($car->cancellation) ?>
                </span>

            </div>
        </div>
        <!-- Характеристики -->
        <?php if ($car->values): ?>
        <div class="row pt-4">
            <div class="col params-tour">
                <div class="container-hr">
                    <hr/>
                    <div class="text-left-hr"><?= Lang::t('Характеристики') ?></div>
                </div>
                <?php foreach ($car->values as $value): ?>
                <span class="params-item">
                    <i class="fas fa-dot-circle"></i>&#160;&#160;
                    <?=  Lang::t($value->characteristic->name) . ': ' . $value->value ?>
                </span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        <!-- Дополнения -->
        <div class="row pt-4">
            <div class="col">
                <div class="container-hr">
                    <hr/>
                    <div class="text-left-hr"><?= Lang::t('Дополнения') ?></div>
                </div>
                <table class="table table-bordered">
                    <tbody>
                    <?php foreach ($car->extra as $extra): ?>
                        <?php if (!empty($extra->name)): ?>
                            <tr>
                                <th><?= Html::encode($extra->getName()) ?></th>
                                <td><?= Html::encode($extra->getDescription()) ?></td>
                                <td><?= CurrencyHelper::get($extra->cost) ?></td>
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
                    <div class="text-left-hr"><?= Lang::t('Координаты') ?></div>
                </div>
                <div class="params-item-map">
                    <div class="row">
                        <div class="col-4">
                            <button class="btn btn-outline-secondary" type="button" data-toggle="collapse"
                                    data-target="#collapse-map"
                                    aria-expanded="false" aria-controls="collapse-map">
                                <i class="fas fa-map-marker-alt"></i>
                            </button>&#160;<?= Lang::t('Точки проката') ?>:
                        </div>
                        <div class="col-8" id="address"></div>
                    </div>
                    <div class="collapse" id="collapse-map">
                        <div class="card card-body">
                            <div id="count-points" data-count="<?= count($car->address)?>">
                                <?php foreach ($car->address as $i => $address): ?>
                                    <input type="hidden" id="address-<?= ($i+1)?>" value="<?= $address->address?>">
                                    <input type="hidden" id="latitude-<?= ($i+1)?>" value="<?= $address->latitude?>">
                                    <input type="hidden" id="longitude-<?= ($i+1)?>" value="<?= $address->longitude?>">
                                <?php endforeach;?>
                            </div>
                            <div class="row">
                                <div id="map-car-view" style="width: 100%; height: 300px"></div>
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
                    <div class="text-left-hr"><?= Lang::t('Отзывы') . ' (' . $countReveiws . ')' ?></div>
                </div>
                <div id="review">
                    <?= ReviewsWidget::widget(['reviews' => $car->reviews]); ?>
                </div>
                <?= NewReviewCarWidget::widget(['car_id' => $car->id]); ?>
            </div>
        </div>
    </div>
    <!-- КУПИТЬ БИЛЕТЫ -->
    <div class="col-sm-4 <?= $mobile ? ' ml-2' : '' ?>">
        <?php if ($car->isActive()) {
            echo $this->render('_booking', [
            'car' => $car,
        ]);
        } else {
            echo '<span class="badge badge-danger" style="font-size: 16px">' . Lang::t('Прокат не активен.') . '<p></p>' . Lang::t('Бронирование недоступно.') . '</span>';
        }
        ?>
        <div class="rating">
            <p>
                <?= RatingWidget::widget(['rating' => $car->rating]); ?>
                <a href="#review">
                    <?= $countReveiws ?> <?= Lang::t('отзывов') ?>
                </a>
                &nbsp;
            </p>
            <hr>
        </div>
        <!-- Go to www.addthis.com/dashboard to customize your tools -->
        <div class="addthis_inline_share_toolbox"></div>
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
