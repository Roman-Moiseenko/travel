<?php


use booking\entities\Lang;
use frontend\assets\SwiperAsset;
use frontend\widgets\BlogLandingWidget;
use frontend\widgets\RatingWidget;
use kv4nt\owlcarousel\OwlCarouselWidget;
use yii\helpers\Url;
use yii\web\JqueryAsset;

/* @var $this yii\web\View */
/* @var $images array */
$this->title = Lang::t('Калининград для туристов и гостей, экскурсии, апартаменты, развлечения, сувениры, на ПМЖ, земельные участки, недвижимость, прокат авто, авиабилеты');
$description = 'Отдых в Калининграде обзорные экскурсии по городу и замкам, развлечения, прогулки бронирование апартаментов квартир домов и прокат авто вело, переезд на ПМЖ, купить участок земли';
$this->registerMetaTag(['name' =>'description', 'content' => $description]);
$this->registerMetaTag(['name' =>'og:description', 'content' => $description]);
//$this->registerMetaTag(['name' => 'keywords', 'content' => 'экскурсии,туры,бронирование,развлечения,жилья,Калининград,отдых']);
/* @var $region string */

//JqueryAsset::register($this);

//SwiperAsset::register($this);
?>
<div class="mobile-landing m-0 p-0">
    <div class="pt-2">
        <h1>
        <p class="landing-h1-mobile"><?= Lang::t('Калининград') ?></p>
        <p class="landing-h2" style="font-size: 14px !important; width: 100% !important;">
            <span class="line-t"></span><?= Lang::t('для туристов и гостей') ?><span class="line-b"></span>
        </p>
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
                'url' => '/funs',
                'img_name' => 'fun_mobile.jpg',
                'img_alt' => 'Развлечения и отдых в Калининграде',
                'caption' => 'Развлечения<br>Отдых',
            ]) ?>
            <?= $this->render('_button_mobile', [
                'url' => '/stays',
                'img_name' => 'stay_mobile.jpg',
                'img_alt' => 'Проживание в Калининграде',
                'caption' => 'Проживание',
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
                'caption' => 'Сувениры',
            ]) ?>
            <?= $this->render('_button_mobile', [
                'url' => '/post',
                'img_name' => 'blog_mobile.jpg',
                'img_alt' => 'Туристам о Калининграде',
                'caption' => 'Туристам о Калининграде',
            ]) ?>
            <?= $this->render('_button_mobile', [
                'url' => '/medicine',
                'img_name' => 'medicine_mobile.jpg',
                'img_alt' => 'Медицинский туризм в Калининграде',
                'caption' => 'Медицинский<br>туризм',
            ]) ?>
            <?= $this->render('_button_mobile', [
                'url' => '/moving',
                'img_name' => 'moving_mobile.jpg',
                'img_alt' => 'На ПМЖ в Калининград',
                'caption' => 'На ПМЖ',
            ]) ?>
            <?= $this->render('_button_mobile', [
                'url' => '/realtor',
                'img_name' => 'land_mobile.jpg',
                'img_alt' => 'Купить-продать землю и недвижимость в Калининграде',
                'caption' => 'Земельные участки<br>Недвижимость',
            ]) ?>
            <?= $this->render('_button_mobile', [
                'url' => '/night',
                'img_name' => 'night_mobile.jpg',
                'img_alt' => 'Ночная жизнь в Калининграде',
                'caption' => 'Ночная жизнь<br>Развлечения. Отдых',
            ]) ?>
            <?= $this->render('_button_mobile', [
                'url' => '/forum',
                'img_name' => 'forum_mobile.jpg',
                'img_alt' => 'Форум в Калининграде',
                'caption' => 'Форумы<br>На ПМЖ<br>Лечение<br>Туристам',
            ]) ?>
        </div>
    </div>
    <div class="landing-block-center">
        <div class="container">
            <div class="row pt-5">
                <div class="col-12">
                    <?= '';// BlogLandingWidget::widget(); ?>
                </div>
            </div>

        </div>
    </div>
    <!--div class="landing-block-center pb-2">
        <div class="container">
            <div class="p-2 landing-block-dark">
                <h2 class="landing-title-h2" style="font-size: 18px; color: #2980a5; padding-top: 10px !important;"></span><?= Lang::t('Для туристических компаний') ?></h2>
                <div class="row">
                    <div class="col-12"
                         style="font-size: 14px; color: white; text-align: justify;">
                        <p class="indent">
                        Если Вы оказываете различные туристические услуги для гостей и жителей нашего региона, то Вы
                        можете
                        разместить их на нашем сайте.
                        Для размещения доступны следующие услуги: экскурсии, прокат транспортных средств, бронирование
                        апартаментов/домов (целиком) и развлечения (активный, культурный отдых).
                        </p> Зарегистрироваться можно по адресу <a class="link" href="https://admin.koenigs.ru" rel="nofollow"
                                                                   target="_blank">admin.koenigs.ru</a>.<br>
                    </div>
                </div>
            </div>
        </div>
    </div-->
    <div class="landing-block-center pb-2">
        <div class="container">
            <?= $this->render('_seo_text', [
                    'mobile' => true,
            ]) ?>
        </div>
    </div>
</div>




