<?php

use booking\entities\booking\funs\Fun;
use booking\entities\Lang;
use booking\forms\booking\ReviewForm;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\funs\WorkModeHelper;
use booking\helpers\SysHelper;
use frontend\assets\FunAsset;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\widgets\LegalWidget;
use frontend\widgets\RatingWidget;
use frontend\widgets\reviews\NewReviewFunWidget;
use frontend\widgets\reviews\ReviewsWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $fun Fun */
/* @var $reviewForm ReviewForm */

$this->registerMetaTag(['name' => 'description', 'content' => Html::encode(StringHelper::truncateWords(strip_tags($fun->getDescription()), 20))]);

$this->title = $fun->getName();
$this->params['breadcrumbs'][] = ['label' => Lang::t('Список развлечений'), 'url' => Url::to(['funs/index'])];
$this->params['breadcrumbs'][] = $this->title;

$this->params['fun'] = true;
//FunAsset::register($this);
MagnificPopupAsset::register($this);
MapAsset::register($this);
$mobile = SysHelper::isMobile();
$countReveiws = $fun->countReviews();
?>
<!-- ФОТО  -->
<div class="row" xmlns:fb="https://www.w3.org/1999/xhtml" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col-sm-12">
        <ul class="thumbnails">
            <?php foreach ($fun->photos as $i => $photo): ?>
                <?php if ($i == 0): ?>
                    <li>
                        <div itemscope itemtype="https://schema.org/ImageObject">
                            <a class="thumbnail" href="<?= $photo->getImageFileUrl('file') ?>">
                                <img src="<?= $photo->getThumbFileUrl('file', 'catalog_main'); ?>"
                                     alt="<?= $fun->getName() . '. ' . Lang::t($photo->alt) ?>" class="card-img-top"
                                     itemprop="contentUrl"/>
                            </a>
                            <meta itemprop="name" content="<?= $fun->getName() . '. ' . Lang::t($photo->alt) ?>">
                            <meta itemprop="description" content="<?= strip_tags($fun->getDescription()) ?>">
                        </div>
                    </li>
                <?php else: ?>
                    <li class="image-additional">
                        <div itemscope itemtype="https://schema.org/ImageObject">
                            <a class="thumbnail" href="<?= $photo->getImageFileUrl('file') ?>">&nbsp;
                                <img src="<?= $photo->getThumbFileUrl('file', 'catalog_additional'); ?>"
                                     alt="<?= $fun->getName() . '. ' . Lang::t($photo->alt) ?>" itemprop="contentUrl"/>
                            </a>
                            <meta itemprop="name" content="<?= $fun->getName() . '. ' . Lang::t($photo->alt) ?>">
                            <meta itemprop="description" content="<?= strip_tags($fun->getDescription()) ?>">
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
        <!-- Заголовок Развлечения-->
        <div class="row pb-3">
            <div class="col-12">
                <div class="d-flex align-items-center">
                    <div class="mr-auto">
                        <h1><?= Html::encode($fun->getName()) ?></h1>
                    </div>
                    <div class="btn-group">
                        <button type="button" data-toggle="tooltip" class="btn btn-info btn-wish"
                                title="<?= Lang::t('В избранное') ?>"
                                href="<?= Url::to(['/cabinet/wishlist/add-fun', 'id' => $fun->id]) ?>"
                                data-method="post">
                            <i class="fa fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Описание -->
        <div class="row">
            <div class="col-sm-12 params-tour text-justify">
                <?= Yii::$app->formatter->asHtml($fun->getDescription(), [
                    'Attr.AllowedRel' => array('nofollow'),
                    'HTML.SafeObject' => true,
                    'Output.FlashCompat' => true,
                    'HTML.SafeIframe' => true,
                    'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                ]) ?>

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
                    <?php if ($fun->baseCost->adult): ?>
                        <i class="fas fa-user"></i>&#160;&#160;<?= Lang::t('Взрослый билет') ?> <span
                                class="price-view">
                            <?= CurrencyHelper::get($fun->baseCost->adult) ?>
                        </span>
                    <?php endif; ?>
                </span>
                <p></p>
                <?php if ($fun->baseCost->child): ?>
                    <span class="params-item">
                    <i class="fas fa-child"></i>&#160;&#160;<?= Lang::t('Детский билет') ?>
                    <span class="price-view">
                        <?= CurrencyHelper::get($fun->baseCost->child) ?>
                    </span>
                </span>
                    <p></p>
                <?php endif; ?>
                <?php if ($fun->baseCost->preference): ?>
                    <span class="params-item">
                    <i class="fab fa-accessible-icon"></i>&#160;&#160;<?= Lang::t('Льготный билет') ?> <span
                                class="price-view">
                    <?= CurrencyHelper::get($fun->baseCost->preference) ?>
                    </span>
                </span>
                    <p></p>
                <?php endif; ?>

                <span class="params-item">
                    <i class="fas fa-star-of-life"></i>&#160;&#160;<?= Lang::t('Стоимость билета может меняться в зависимости от даты') ?>
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
                    <i class="fas fa-user-clock"></i>&#160;&#160;<?= Lang::t('Ограничения по возрасту') . ' ' . BookingHelper::ageLimit($fun->params->ageLimit) ?>
                </span>
                <span class="params-item">
                    <i class="fas fa-ban"></i>&#160;&#160;<?= BookingHelper::cancellation($fun->cancellation) ?>
                </span>
                <!-- Режим работы -->
                <span class="params-item">
                    <i class="fas fa-hot-tub"></i>&#160;&#160; <?= Lang::t('Режим работы') ?><br><?= WorkModeHelper::weekMode($fun->params->workMode) ?>
                </span>


            </div>
        </div>
        <!-- Характеристики -->
        <?php if ($fun->values): ?>
            <div class="row pt-4">
                <div class="col params-tour">
                    <div class="container-hr">
                        <hr/>
                        <div class="text-left-hr"><?= Lang::t('Характеристики') ?></div>
                    </div>
                    <?php foreach ($fun->values as $value): ?>
                        <span class="params-item">
                    <i class="fas fa-dot-circle"></i>&#160;&#160;
                    <?= Lang::t($value->characteristic->name) . ': ' . $value->value ?>
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
                    <?php foreach ($fun->extra as $extra): ?>
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
                <span id="ymap-params" data-api="<?= \Yii::$app->params['YandexAPI'] ?>"
                      data-lang="<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>"></span>
                <div class="container-hr">
                    <hr/>
                    <div class="text-left-hr"><?= Lang::t('Координаты') ?></div>
                </div>
                <div class="params-item-map">
                    <div class="row">
                        <div class="col-3">
                            <button class="btn btn-outline-secondary loader_ymap" type="button" data-toggle="collapse"
                                    data-target="#collapse-map"
                                    aria-expanded="false" aria-controls="collapse-map">
                                <i class="fas fa-map-marker-alt"></i>
                            </button>&#160;<?= Lang::t('Адрес') ?>:
                        </div>
                        <div class="col-9 align-self-center" id="address"><?= $fun->address->address ?></div>
                    </div>
                    <div class="collapse" id="collapse-map">
                        <div class="card card-body">

                            <input type="hidden" id="latitude" value="<?= $fun->address->latitude ?>">
                            <input type="hidden" id="longitude" value="<?= $fun->address->longitude ?>">
                            <div class="row">
                                <div id="map-fun-view" style="width: 100%; height: 300px"></div>
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
                    <?= ReviewsWidget::widget(['reviews' => $fun->reviews]); ?>
                </div>
                <?= NewReviewFunWidget::widget(['fun_id' => $fun->id]); ?>
            </div>
        </div>
    </div>
    <!-- КУПИТЬ БИЛЕТЫ -->
    <div class="col-sm-4 <?= $mobile ? ' ml-2' : '' ?>">
        <div class="row">
            <div class="col">
                <?php if ($fun->isActive()) {
                    echo $this->render('_booking', [
                        'fun' => $fun,
                    ]);
                } else {
                    echo '<span class="badge badge-danger" style="font-size: 16px">' . Lang::t('Мероприятие не активно.') . '<p></p>' . Lang::t('Бронирование недоступно.') . '</span>';
                }
                ?>
                <div class="rating">
                    <p>
                        <?= RatingWidget::widget(['rating' => $fun->rating]); ?>
                        <a href="#review">
                            <?= $countReveiws ?> <?= Lang::t('отзывов') ?>
                        </a>
                        &nbsp;
                    </p>
                    <hr>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <?= LegalWidget::widget(['legal' => $fun->legal]) ?>
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
