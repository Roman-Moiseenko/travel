<?php

use booking\entities\admin\Contact;
use booking\entities\foods\Food;
use booking\entities\Lang;
use booking\forms\foods\ReviewFoodForm;
use booking\helpers\funs\WorkModeHelper;
use booking\helpers\SysHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\widgets\GalleryWidget;
use frontend\widgets\reviews\NewReviewFoodWidget;
use frontend\widgets\reviews\ReviewsFoodWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $food Food */
/* @var $model ReviewFoodForm */

$this->params['canonical'] = Url::to(['/foods/view', 'id' => $food->id], true);
$this->registerMetaTag(['name' => 'description', 'content' => $food->meta->description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $food->meta->description]);

$this->title = $food->meta->title ? Lang::t($food->meta->title) : $food->name;
$this->params['breadcrumbs'][] = ['label' => Lang::t('Где поесть'), 'url' => Url::to(['foods/index'])];
$this->params['breadcrumbs'][] = $food->name;

MagnificPopupAsset::register($this);
MapAsset::register($this);
$mobile = SysHelper::isMobile();
$countReveiws = $food->countReviews();
?>

    <!-- ФОТО  -->
    <div class="pb-4 thumbnails gallery" style="margin-left: 0 !important;"
         xmlns:fb="https://www.w3.org/1999/xhtml" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
        <?php foreach ($food->photos as $i => $photo) {
            echo GalleryWidget::widget([
                'photo' => $photo,
                'iterator' => $i,
                'count' => count($food->photos),
                'name' => $food->name,
                'description' => $food->description,
            ]);
        } ?>
    </div>
    <div class="row" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
        <div class="col-sm-12 <?= $mobile ? ' ml-2' : '' ?>">
            <!-- Заголовок заведения -->
            <div class="row pb-3">
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <div class="mr-auto">
                            <h1><?= Html::encode($food->name) ?></h1>
                        </div>
                        <div class="btn-group">
                            <button type="button" data-toggle="tooltip" class="btn btn-info btn-wish"
                                    title="<?= Lang::t('В избранное') ?>"
                                    href="<?= Url::to(['/cabinet/wishlist/add-food', 'id' => $food->id]) ?>"
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
                    <?= Yii::$app->formatter->asHtml($food->description, [
                        'Attr.AllowedRel' => array('nofollow'),
                        'HTML.SafeObject' => true,
                        'Output.FlashCompat' => true,
                        'HTML.SafeIframe' => true,
                        'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                    ]) ?>

                </div>
            </div>
            <!-- Параметры -->
            <div class="row pt-4">
                <div class="col params-tour">
                    <div class="params-item" style="display: block !important;">
                        <i class="fas fa-utensils"></i>&#160;&#160;
                        <?php foreach ($food->kitchens as $i => $kitchen) {
                            echo Lang::t($kitchen->name) . ($i < count($food->kitchens) - 1 ? ' | ' : '');
                        } ?>
                    </div>
                    <div class="params-item" style="display: block !important;">
                        <i class="fas fa-dungeon"></i>&#160;&#160;
                        <?php foreach ($food->categories as $i => $category) {
                            echo Lang::t($category->name) . ($i < count($food->categories) - 1 ? ' | ' : '');
                        } ?>
                    </div>
                </div>
            </div>
            <!-- Режим -->
            <div class="container-hr-food">
                <hr/>
                <div class="text-left-hr-food"><?= Lang::t('Режим работы') ?></div>
            </div>
            <div class="row">
                <div class="col params-tour">
                    <div class="params-item" style="display: block !important;">
                        <?php foreach ($food->workModes as $i => $workMode) {
                            if ($workMode->day_begin != '')
                                echo '' . WorkModeHelper::week($i) . ':&#160;<i class="far fa-clock"></i>&#160;' . $workMode->day_begin . ' - ' . $workMode->day_end . '<br>';
                        } ?>
                    </div>
                </div>
            </div>
            <!-- Контакты -->
            <div class="container-hr-food">
                <hr/>
                <div class="text-left-hr-food"><?= Lang::t('Контакты') ?></div>
            </div>
            <div class="row">
                <div class="col params-tour">
                    <div class="params-item" style="display: block !important;">
                        <?php foreach ($food->contactAssign as $contact): ?>
                            <p>
                                <img src="<?= $contact->contact->getThumbFileUrl('photo', 'list') ?>"/>&#160;
                                <?php if ($contact->contact->type == Contact::NO_LINK): ?>
                                    <?= Html::encode($contact->value) ?>
                                <?php else: ?>
                                    <a href="<?= $contact->contact->prefix . $contact->value ?>"
                                       target="_blank" rel="nofollow"><?= Html::encode($contact->value) ?></a>
                                <?php endif; ?>

                                &#160;<?= Html::encode($contact->description) ?>
                            </p>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <!-- Адрес -->
            <div class="container-hr-food">
                <hr/>
                <div class="text-left-hr-food"><?= Lang::t('Адреса') ?></div>
            </div>
            <div class="row pt-4">
                <div class="col params-tour">
                    <div class="params-item" style="display: block !important;">
                        <?php foreach ($food->addresses as $i => $address) {
                            echo '<p><i class="fas fa-map-marker-alt"></i>&#160;' . $address->address . '&#160;&#160;<i class="fas fa-phone-alt"></i>' . $address->phone . '</p>';
                        } ?>
                    </div>
                </div>
            </div>
            <!-- Карта -->
            <div class="row pt-4">
                <div class="col">
                <span id="ymap-params" data-api="<?= \Yii::$app->params['YandexAPI'] ?>"
                      data-lang="<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>"></span>
                    <span id="count-points" data-count="<?= count($food->addresses) ?>"></span>
                    <div class="params-item-map">
                        <div class="row">
                            <div class="col-4">

                                <button class="btn btn-outline-secondary loader_ymap" type="button"
                                        data-toggle="collapse"
                                        data-target="#collapse-map-3"
                                        aria-expanded="false" aria-controls="collapse-map-2">
                                    <i class="fas fa-map-marked-alt"></i>&#160;<?= Lang::t('Показать на карте') ?>
                                </button>
                                <?php foreach ($food->addresses as $i => $address): ?>
                                    <input type="hidden" id="address-<?=$i+1?>" value="<?= $address->address?>">
                                    <input type="hidden" id="phone-<?=$i+1?>" value="<?= $address->phone?>">
                                    <input type="hidden" id="latitude-<?=$i+1?>" value="<?= $address->latitude?>">
                                    <input type="hidden" id="longitude-<?=$i+1?>" value="<?= $address->longitude?>">
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="collapse" id="collapse-map-3">
                            <div class="card card-body">
                                <div class="row">
                                    <div id="map-food-view" style="width: 100%; height: 450px"></div>
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
                    <div class="container-hr-food">
                        <hr/>
                        <div class="text-left-hr-food"><?= Lang::t('Отзывы') . ' (' . $countReveiws . ')' ?></div>
                    </div>
                    <div id="review">
                        <?= ReviewsFoodWidget::widget(['reviews' => $food->reviews]); ?>
                    </div>
                    <div class="pt-2">
                        <?= NewReviewFoodWidget::widget(['food_id' => $food->id, 'reviewForm' => $model]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div itemscope itemtype="https://schema.org/Restaurant">
        <meta itemprop="name" content="<?= $food->name ?>">
        <link itemprop="image" href="<?= $food->mainPhoto->getThumbFileUrl('file', 'catalog_list') ?>">
        <div itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
            <meta itemprop="bestRating" content="5">
            <meta itemprop="worstRating" content="0">
            <meta itemprop="ratingValue" content="<?= $food->rating ?? 5 ?>">
            <meta itemprop="reviewCount" content="<?= count($food->reviews) + 1 ?>">
        </div>
        <?php foreach ($food->addresses as $address): ?>
        <div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
            <meta itemprop="streetAddress" content="<?= $address->address ?>">
            <meta itemprop="addressLocality" content="<?= $address->city ?>">
            <meta itemprop="addressRegion" content="Калининградская область">
        </div>
        <meta itemprop="telephone" content="<?= $address->phone ?>">
        <?php endforeach; ?>
        <?php foreach ($food->contactAssign as $contact)
             if ($contact->contact->type != Contact::NO_LINK)
                echo '<link itemprop="url" href="' . $contact->contact->prefix . $contact->value . '">' . PHP_EOL;
        ?>

    <?php foreach ($food->workModes as $i => $workMode)
        if ($workMode->day_begin != '')
            echo '<meta itemprop="openingHours" content="' . WorkModeHelper::week($i) . ' ' . $workMode->day_begin . '-' . $workMode->day_end . '">';
    ?>
        <?php foreach ($food->kitchens as $kitchen): ?>
            <meta itemprop="servesCuisine" content="<?= $kitchen->name?>">
        <?php endforeach; ?>

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