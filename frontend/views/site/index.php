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
$this->registerMetaTag(['name' =>'description', 'content' => 'Отдых в Калининграде обзорные экскурсии по городу и замкам, развлечения, прогулки бронирование апартаментов квартир домов и прокат авто вело']);
$this->registerMetaTag(['name' =>'keywords', 'content' => 'экскурсии,туры,бронирование,развлечения,жилья,Калининград,отдых']);
$this->registerLinkTag(['rel' => "preload",  'as' => "image", 'href' => $images[0]]);

SwiperAsset::register($this);
?>
<header class="landing-header">
    <div class="container d-flex  justify-content-between"  style="align-items: center; display: flow-root">
        <div class="" style="float: left">
            <div id="Oplao" data-cl="white" data-id="33141" data-wd="200px" data-hg="80px" data-l="ru" data-c="554234"
                 data-t="C" data-w="m/s" data-p="hPa" data-wg="widget_3" class="170 80"></div>
            <script type="text/javascript" id="weather_widget" charset="UTF-8"
                    src="../js/weather_widget.js"></script> <!-- https://oplao.com/js/weather_widget.js -->

        </div>
        <div  style="align-items: center">
            <a href="/" class="landing-logo">
                <img src="<?= \Yii::$app->params['staticHostInfo'] . '/files/images/koenigs_ru.png' ?>" class="img-responsive">
            </a>
        </div>
        <div class="d-flex">
            <div class="mr-4">
                <a href="https://www.instagram.com/koenigs.ru" target="_blank"><span class="landing-top-contact"><i
                                class="fab fa-vk"></i></span></a>
            </div>
            <div class="mr-4">
                <a href="https://www.instagram.com/koenigs.ru" target="_blank"><span class="landing-top-contact"><i
                                class="fab fa-instagram"></i></span></a>
            </div>
            <div style="align-items: center">
                <span class="landing-top-contact"><i class="fas fa-phone"></i> +7911-471-0701</span>
            </div>
        </div>
    </div>

</header>
<?php

OwlCarouselWidget::begin([
    'container' => 'div',
    'containerOptions' => [
        'id' => 'container-id',
        'class' => 'container-class'
    ],
    'pluginOptions' => [
        'autoplay' => true,
        'autoplayTimeout' => 5000,
        'items' => 1,
        'loop' => true,
        'info' => true,
    ]
]);

$url_img_booking = \Yii::$app->params['staticHostInfo'] . '/files/images/landing/booking/'; //перенести куда нить в параметры

?>


<?php foreach ($images as $i => $image): ?>
    <div class="item-class">
        <img data-src="<?= $image ?>" class="lazyload" alt="На отдых в Калининградскую область">
        <div class="container">
            <div class="carousel-caption">
                <p class="landing-h1"><?= Lang::t('Кёнигсберг') ?></p>
                <?php if ($i == 0) { echo '<h1 class="landing-h2">';} else {echo '<p class="landing-h2">';} ?>
                    <span class="line-t"></span><?= Lang::t('На отдых в Калининградскую область') ?><span class="line-b"></span>
                <?php if ($i == 0) { echo '</h1>';} else {echo '</p>';} ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php OwlCarouselWidget::end(); ?>
<div class="landing-block-center">
    <div class="container">
        <h2 class="landing-title-h2"><span class="line-t-title"></span><?= Lang::t('Для гостей') ?><span class="line-b-title"></span></h2>

        <div class="row">

            <div class="col-3">
                <a href="<?= Url::to(['/tours']) ?>">
                    <img data-src="<?=$url_img_booking . 'tour.jpg'?>" class="img-responsive lazyload" width="100%" height="300px">
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


            <div class="col-3">
                <a href="<?= Url::to(['/stays']) ?>">
                    <img data-src="<?=$url_img_booking . 'stay.jpg'?>" class="img-responsive lazyload" width="100%" height="300px">
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

            <div class="col-3">
                <a href="<?= Url::to(['/funs']) ?>">
                    <img data-src="<?=$url_img_booking . 'fun.jpg'?>" class="img-responsive lazyload" width="100%" height="300px">
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

            <div class="col-3">
                <a href="<?= Url::to(['/cars']) ?>">
                    <img data-src="<?=$url_img_booking . 'car.jpg'?>" class="img-responsive lazyload" width="100%" height="300px">
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
</div>
<div class="landing-block-center">
    <div class="container">
        <h2 class="landing-title-h2"><span class="line-t-title"></span><?= Lang::t('О Калининградской области')?><span
                    class="line-b-title"></span></h2>
        <div class="row">
            <div class="col-12" style="font-size: 18px; text-align: justify; letter-spacing: 1px; line-height: 2">
                Калининградская область — самый западный регион России и единственный не имеющий сухопутной границей с Россией.
                Добраться к нам быстрее и дешевле будет на самолете, для этого потребуется только паспорт гражданина РФ.<br>
                История Калининградской области - это богатая история в которой оставили свой след племена Пруссии, рыцари Тевтонского ордена и советское прошлое.
                <br>
                На территории региона расположено много историко-культурных и архитектурных памятников, такие как форты, замки, кирхи и многое другое.
                Сегодня происходит восстановление многих памятников, а также создание новых архитектурных достопримечательностей, которые могут посетить туристы.
                Также имеются природные и заповедные парки, открытые для посещения гостями, а в теплые летние можно искупаться в балтийском море и погреться на песчаных пляжах.
                Или прогуляться по уютным улочкам приморских городов и посетить кафешки с домашней обстановкой. <br>А может Вам будет интересна история города или Вы хотели бы посетить необычные места,
                тогда можно совершить экскурсию с одним из наших гидов.<br>
            </div>
        </div>
        <div class="row pt-5">
            <div class="col-12">
                <?= BlogLandingWidget::widget(); ?>
            </div>
        </div>

    </div>
</div>


<!--div class="landing-block-center">
    <div class="container">
        <h2 class="landing-title-h2"><span class="line-t-title"></span>Отзывы Партнеры Ссылки<span
                    class="line-b-title"></span></h2>
    </div>
</div-->

<div class="landing-block-center">
    <div class="container">
        <h2 class="landing-title-h2"><span class="line-t-title"></span><?= Lang::t('Для туристических компаний') ?><span
                    class="line-b-title"></span></h2>
        <div class="row">
            <div class="col-12" style="font-size: 18px; text-align: justify; letter-spacing: 1px; line-height: 2">
                Если Вы оказываете различные туристические услуги для гостей и жителей нашего региона, то Вы можете разместить их на нашем сайте.
                Для размещения доступны следующие услуги: экскурсии, прокат транспортных средств, бронирование апартаментов/домов (целиком) и развлечения (активный, культурный отдых).
                <br> Зарегистрироваться можно по адресу <a href="https://admin.koenigs.ru" rel="=nofollow" target="_blank" >admin.koenigs.ru</a>.<br>
            </div>
        </div>
    </div>
</div>

<div class="landing-block-center">
    <div class="container">
        <h2 class="landing-title-h2"><span class="line-t-title"></span><?= Lang::t('Календарь событий') ?><span
                    class="line-b-title"></span></h2>
        <div id="nb_events">
            <script id="nbEventsScript" type="text/javascript"
                    src="https://widget.nbcrs.org/Js/Widget/loader.js?key=aa3ea4347e024444b40b50157ddef198&subKey=39930838">
            </script>
        </div>
    </div>
</div>