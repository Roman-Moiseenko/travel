<?php

use booking\entities\Lang;
use booking\entities\realtor\Landowner;
use booking\helpers\Emoji;
use booking\helpers\SysHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\assets\MovingAsset;
use frontend\widgets\design\BtnGeo;
use frontend\widgets\GalleryWidget;
use frontend\widgets\info\BookingLandownerWidget;
use frontend\widgets\info\BrokerLandownerWidget;
use frontend\widgets\info\LandownerWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $landowner Landowner */

$this->registerMetaTag(['name' => 'description', 'content' => $landowner->meta->description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $landowner->meta->description]);

$this->title = $landowner->meta->title ? $landowner->meta->title : $landowner->name;
$this->params['breadcrumbs'][] = ['label' => 'Агентство', 'url' => Url::to(['/realtor'])];
$this->params['breadcrumbs'][] = ['label' => 'Участки', 'url' => Url::to(['/realtor/landowners'])];

$this->params['breadcrumbs'][] = $landowner->name;

$this->params['canonical'] = Url::to(['/realtor/landowners/view', 'id' => $landowner->id], true);


MagnificPopupAsset::register($this);
MapAsset::register($this);
$mobile = SysHelper::isMobile();
MovingAsset::register($this);
?>
<h1 class="pb-4"><?= $landowner->title ?></h1>
<!-- ФОТО  -->
<div class="pb-4 thumbnails gallery" style="margin-left: 0 !important;"
     xmlns:fb="https://www.w3.org/1999/xhtml" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <?php foreach ($landowner->photos as $i => $photo) {
        echo GalleryWidget::widget([
            'photo' => $photo,
            'iterator' => $i,
            'count' => count($landowner->photos),
            'name' => $landowner->name,
            'description' => $landowner->description,
        ]);
    } ?>
</div>
<div class="landowner-main">
    <div class="row">
        <div class="col-sm-12 landowner-main text-justify">
            <?= Yii::$app->formatter->asHtml($landowner->text, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>
    <!-- Как посмотреть сейчас . текст берется с виджета, далее будет браться с базы -->
    <?= BrokerLandownerWidget::widget(); ?>
    <!-- Забронировать осмотр -->
    <?= BookingLandownerWidget::widget([
            'landowner_id' => $landowner->id,
    ]); ?>
    <!-- Координаты -->
    <div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
        <div class="col <?= $mobile ? ' ml-2' : '' ?>">
                <span id="ymap-params" data-api="<?= \Yii::$app->params['YandexAPI'] ?>"
                      data-lang="<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>"></span>
            <div class="container-hr">
                <hr/>
                <div class="text-left-hr"><?= Lang::t('Координаты') ?></div>
            </div>
            <div class="params-item-map">
                <div class="row pb-2">
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <?= BtnGeo::widget([
                            'caption' => 'Показать на карте',
                            'target_id' => 'collapse-map',
                        ]) ?>
                    </div>
                    <div class="col-sm-6 col-md-8 col-lg-9 align-self-center"
                         id="address"><?= $landowner->address->address ?? '<span class="badge badge-info">' . Lang::t('Не указано') . '</span>' ?></div>
                </div>
                <div class="collapse" id="collapse-map">
                    <div class="card card-body card-map">
                        <div class="row">
                            <div class="col-8">
                                <input id="bookingaddressform-address" class="form-control" width="100%"
                                       value="<?= $landowner->address->address ?? '' ?>" type="hidden">
                            </div>
                            <div class="col-2">
                                <input id="bookingaddressform-latitude" class="form-control" width="100%"
                                       value="<?= $landowner->address->latitude ?? '' ?>" type="hidden">
                            </div>
                            <div class="col-2">
                                <input id="bookingaddressform-longitude" class="form-control" width="100%"
                                       value="<?= $landowner->address->longitude ?? '' ?>" type="hidden">
                            </div>
                        </div>
                        <div class="row">
                            <div id="map-view" style="width: 100%; height: 400px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Агентство -->
    <?= LandownerWidget::widget(); ?>
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
