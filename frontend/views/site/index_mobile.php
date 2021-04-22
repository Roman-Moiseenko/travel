<?php


use booking\entities\Lang;
use frontend\assets\SwiperAsset;
use frontend\widgets\BlogLandingWidget;
use frontend\widgets\RatingWidget;
use kv4nt\owlcarousel\OwlCarouselWidget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $images array */
$this->title = Lang::t('На отдых в Калининград - Кёнигсберг');
$description = 'Отдых в Калининграде обзорные экскурсии по городу и замкам, развлечения, прогулки бронирование апартаментов квартир домов и прокат авто вело';
$this->registerMetaTag(['name' =>'description', 'content' => $description]);
$this->registerMetaTag(['name' =>'og:description', 'content' => $description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'экскурсии,туры,бронирование,развлечения,жилья,Калининград,отдых']);

$url_img_booking = \Yii::$app->params['staticHostInfo'] . '/files/images/landing/booking/'; //перенести куда нить в параметры
SwiperAsset::register($this);
?>
<div class="mobile-landing m-0 p-0">
    <div class="pt-2">
        <p class="landing-h1"
            style="font-size: 22px !important; text-align: center !important;"><?= Lang::t('Кёнигсберг') ?></p>
        <h1 class="landing-h2" style="font-size: 14px !important; width: 100% !important;">
            <span class="line-t"></span><?= Lang::t('На отдых в Калининградскую область') ?><span class="line-b"></span>
        </h1>
    </div>
    <div class="landing-block-center">
        <div class="container">
            <?= $this->render('_button_mobile', [
                'url' => '/tours',
                'img_name' => 'tour_mobile.jpg',
                'img_alt' => 'Экскурсии в Калининграде',
                'caption' => 'Экскурсии',

            ]) ?>
            <?= $this->render('_button_mobile', [
                'url' => '/stays',
                'img_name' => 'stay_mobile.jpg',
                'img_alt' => 'Бронирование жилья в Калининграде',
                'caption' => 'Апартаменты',

            ]) ?>
            <?= $this->render('_button_mobile', [
                'url' => '/funs',
                'img_name' => 'fun_mobile.jpg',
                'img_alt' => 'Развлечения и отдых в Калининграде',
                'caption' => 'Развлечения',

            ]) ?>
            <?= $this->render('_button_mobile', [
                'url' => '/cars',
                'img_name' => 'car_mobile.jpg',
                'img_alt' => 'Прокат авто в Калининграде',
                'caption' => 'Прокат авто',

            ]) ?>
            <?= $this->render('_button_mobile', [
                'url' => '/foods',
                'img_name' => 'food_mobile.jpg',
                'img_alt' => 'Где поесть в Калининграде',
                'caption' => 'Где поесть',

            ]) ?>
            <?= $this->render('_button_mobile', [
                'url' => '/shops',
                'img_name' => 'shop_mobile.jpg',
                'img_alt' => 'Что купить в Калининграде',
                'caption' => 'Что купить',

            ]) ?>
        </div>
    </div>
    <div class="landing-block-center">
        <div class="container">
            <div class="row pt-5">
                <div class="col-12">
                    <?= BlogLandingWidget::widget(); ?>
                </div>
            </div>

        </div>
    </div>
    <div class="landing-block-center pb-2">
        <div class="container">
            <div class="p-2 landing-block-dark">
                <h2 class="landing-title-h2" style="font-size: 18px; color: #2980a5; padding-top: 10px !important;"></span><?= Lang::t('Для туристических компаний') ?></h2>
                <div class="row">
                    <div class="col-12"
                         style="font-size: 14px; color: white; text-align: justify;">
                        Если Вы оказываете различные туристические услуги для гостей и жителей нашего региона, то Вы
                        можете
                        разместить их на нашем сайте.
                        Для размещения доступны следующие услуги: экскурсии, прокат транспортных средств, бронирование
                        апартаментов/домов (целиком) и развлечения (активный, культурный отдых).
                        <br> Зарегистрироваться можно по адресу <a class="link" href="https://admin.koenigs.ru" rel="nofollow"
                                                                   target="_blank">admin.koenigs.ru</a>.<br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




