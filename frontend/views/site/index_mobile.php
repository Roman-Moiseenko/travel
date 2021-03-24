<?php


use booking\entities\Lang;
use frontend\assets\SwiperAsset;
use frontend\widgets\BlogLandingWidget;
use frontend\widgets\RatingWidget;
use kv4nt\owlcarousel\OwlCarouselWidget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $images array */
$this->title = Lang::t('На отдых в Калининград');
$this->registerMetaTag(['name' =>'description', 'content' => 'Отдых в Калининграде обзорные экскурсии по городу и замкам, развлечения, прогулки бронирование апартаментов квартир домов и прокат авто вело']);
$this->registerMetaTag(['name' =>'keywords', 'content' => 'экскурсии,туры,бронирование,развлечения,жилья,Калининград,отдых']);

$url_img_booking = \Yii::$app->params['staticHostInfo'] . '/files/images/landing/booking/'; //перенести куда нить в параметры
SwiperAsset::register($this);
?>

<div class="mobile-landing m-0 p-0">
    <div class="container">
        <div class="mt-5">
            <h1 class="landing-h1" style="font-size: 22px !important; text-align: center !important;"><?= Lang::t('Кёнигсберг') ?></h1>
            <p class="landing-h2" style="font-size: 14px !important;">
                <span class="line-t"></span><?= Lang::t('На отдых в Калининградскую область') ?><span class="line-b"></span></p>
        </div>
    </div>

    <div class="landing-block-center">
        <div class="container">
            <!--h2 class="landing-title-h2"><span class="line-t-title"></span><?= Lang::t('Для гостей') ?><span class="line-b-title"></span></h2-->

                <div class="col p-0 mb-2" style="border: white solid 2px">

                    <a href="<?= Url::to(['/tours']) ?>">
                        <img src="<?=$url_img_booking . 'tour_mobile.jpg'?>" class="img-responsive" width="100%" height="300px">
                        <div class="card-img-overlay d-flex flex-column">
                            <div>
                                <h3 class="card-title"
                                    style="color: white; text-shadow: black 2px 2px 1px"><?= Lang::t('Экскурсии') ?></h3>
                            </div>
                            <div class="mt-auto mb-3">
                                <?= RatingWidget::widget([
                                    'rating' => '5',
                                ])?>
                            </div>
                        </div>
                    </a>
                </div>


                <div class="col p-0 mb-2" style="border: white solid 2px">
                    <a href="<?= Url::to(['/stays']) ?>">
                        <img src="<?=$url_img_booking . 'stay_mobile.jpg'?>" class="img-responsive" width="100%" height="300px">
                        <div class="card-img-overlay d-flex flex-column">
                            <div>
                                <h3 class="card-title"
                                    style="color: white; text-shadow: black 2px 2px 1px"><?= Lang::t('Апартаменты') ?></h3>
                            </div>
                            <div class="mt-auto mb-3">
                                <?= RatingWidget::widget([
                                    'rating' => '5',
                                ])?>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col p-0 mb-2" style="border: white solid 2px">
                    <a href="<?= Url::to(['/funs']) ?>">
                        <img src="<?=$url_img_booking . 'fun_mobile.jpg'?>" class="img-responsive" width="100%" height="300px">
                        <div class="card-img-overlay d-flex flex-column">
                            <div>
                                <h3 class="card-title"
                                    style="color: white; text-shadow: black 2px 2px 1px"><?= Lang::t('Развлечения') ?></h3>
                            </div>
                            <div class="mt-auto mb-3">
                                <?= RatingWidget::widget([
                                    'rating' => '5',
                                ])?>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col p-0 mb-2" style="border: white solid 2px">
                    <a href="<?= Url::to(['/cars']) ?>">
                        <img src="<?=$url_img_booking . 'car_mobile.jpg'?>" class="img-responsive" width="100%" height="300px">
                        <div class="card-img-overlay d-flex flex-column">
                            <div>
                                <h3 class="card-title"
                                    style="color: white; text-shadow: black 2px 2px 1px"><?= Lang::t('Прокат авто') ?></h3>
                            </div>
                            <div class="mt-auto mb-3">
                                <?= RatingWidget::widget([
                                    'rating' => '5',
                                ])?>
                            </div>
                        </div>
                    </a>
                </div>


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


    <div class="landing-block-center">
        <div class="container">
            <h2 class="landing-title-h2" style="font-size: 18px; color: white"><span class="line-t-title"></span><?= Lang::t('Для туристических компаний') ?><span
                        class="line-b-title"></span></h2>
            <div class="row">
                <div class="col-12" style="font-size: 14px; color: white; text-align: justify; letter-spacing: 1px; line-height: 2">
                    Если Вы оказываете различные туристические услуги для гостей и жителей нашего региона, то Вы можете разместить их на нашем сайте.
                    Для размещения доступны следующие услуги: экскурсии, прокат транспортных средств, бронирование апартаментов/домов (целиком) и развлечения (активный, культурный отдых).
                    <br> Зарегистрироваться можно по адресу <a href="https://admin.koenigs.ru" rel="=nofollow" target="_blank" >admin.koenigs.ru</a>.<br>
                </div>
            </div>
        </div>
    </div>
</div>




