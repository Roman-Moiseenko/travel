<?php

use booking\entities\touristic\fun\Fun;
use booking\entities\Lang;
use booking\entities\touristic\TouristicContact;
use booking\forms\booking\ReviewForm;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\Emoji;
use booking\helpers\funs\WorkModeHelper;
use booking\helpers\SysHelper;
use frontend\assets\FunAsset;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\widgets\design\BtnGeo;
use frontend\widgets\design\BtnWish;
use frontend\widgets\GalleryWidget;
use frontend\widgets\LegalWidget;
use frontend\widgets\RatingWidget;
use frontend\widgets\reviews\NewReviewFunWidget;
use frontend\widgets\reviews\ReviewsWidget;
use frontend\widgets\TouristicContactWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $fun Fun */
/* @var $reviewForm ReviewForm */

$this->registerMetaTag(['name' => 'description', 'content' => $fun->meta->description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $fun->meta->description]);

$this->title = $fun->meta->title ? Lang::t($fun->meta->title) : $fun->getName();
$this->params['breadcrumbs'][] = ['label' => 'Развлечения и мероприятия', 'url' => Url::to(['funs/index'])];
$this->params['breadcrumbs'][] = ['label' => $fun->category->name, 'url' => Url::to(['funs/category', 'id' => $fun->category_id])];
$this->params['breadcrumbs'][] = $fun->name;
$this->params['canonical'] = Url::to(['/funs/funs/fun', 'id' => $fun->id], true);

$this->params['fun'] = true;
//FunAsset::register($this);
MagnificPopupAsset::register($this);
MapAsset::register($this);
$mobile = SysHelper::isMobile();
$countReveiws = $fun->countReviews();
$this->params['emoji'] = Emoji::FUN;
?>
<!-- ФОТО  -->
<div class="pb-4 thumbnails gallery" style="margin-left: 0 !important;"
     xmlns:fb="https://www.w3.org/1999/xhtml" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <?php foreach ($fun->photos as $i => $photo) {
        echo GalleryWidget::widget([
            'photo' => $photo,
            'iterator' => $i,
            'count' => count($fun->photos),
            'name' => $fun->getName(),
            'description' => $fun->description,
        ]);
    } ?>
</div>
<!-- ОПИСАНИЕ -->

<!-- Заголовок Развлечения-->
<div class="row pb-3 pt-2"  <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col-12 <?= $mobile ? ' ml-2' : '' ?>">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h1><?= empty($fun->title) ? $fun->name : $fun->title ?></h1>
            </div>

            <?= ''; //TODO BtnWish::widget(['url' => Url::to(['/cabinet/wishlist/add-fun', 'id' => $fun->id]) ]) ?>
        </div>
    </div>
</div>
<!-- Описание -->
<div class="row" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col-sm-12 params-moving text-justify <?= $mobile ? ' ml-2' : '' ?>">
        <?= Yii::$app->formatter->asHtml($fun->content, [
            'Attr.AllowedRel' => array('nofollow'),
            'HTML.SafeObject' => true,
            'Output.FlashCompat' => true,
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
        ]) ?>

    </div>
</div>

<!-- Контакты -->
<div class="row" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
        <!-- Виджет подгрузки отзывов -->
        <div class="container-hr">
            <hr/>
            <div class="text-left-hr">Как с нами связаться</div>
        </div>
        <?= TouristicContactWidget::widget([
                'contact' => $fun->contact,
        ]) ?>

    </div>
</div>
<!-- Координаты -->
<div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
                <span id="ymap-params" data-api="<?= \Yii::$app->params['YandexAPI'] ?>"
                      data-lang="<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>"></span>
        <div class="container-hr">
            <hr/>
            <div class="text-left-hr">Где нас найти</div>
        </div>
        <div class="params-item-map">
            <div class="row pb-2">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <?= BtnGeo::widget([
                        'caption' => 'Адрес',
                        'target_id' => 'collapse-map',
                    ]) ?>
                </div>
                <div class="col-sm-6 col-md-8 col-lg-9 align-self-center" id="address"><?= $fun->address->address ?></div>
            </div>
            <div class="collapse" id="collapse-map">
                <div class="card card-body card-map">
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
<div class="row" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
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
