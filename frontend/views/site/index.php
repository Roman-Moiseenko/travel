<?php


use booking\entities\Lang;
use booking\entities\user\User;
use frontend\assets\SwiperAsset;
use frontend\widgets\BlogLandingWidget;
use frontend\widgets\RatingWidget;
use kv4nt\owlcarousel\OwlCarouselWidget;
use yii\helpers\Url;
use yii\web\JqueryAsset;

/* @var $this yii\web\View */
/* @var $images array */
/* @var $user User */
/* @var $region string */
$this->title = Lang::t('Калининград для туристов и гостей, экскурсии, апартаменты, развлечения, сувениры, на ПМЖ, земельные участки, недвижимость, прокат авто, авиабилеты');

$description = 'Отдых в Калининграде обзорные экскурсии по городу и замкам, развлечения, прогулки бронирование апартаментов квартир домов и прокат авто вело, переезд на ПМЖ, купить участок земли';
$this->registerMetaTag(['name' => 'description', 'content' => $description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $description]);

//$this->registerMetaTag(['name' => 'keywords', 'content' => 'экскурсии,туры,бронирование,развлечения,жилья,Калининград,отдых']);
$this->registerLinkTag(['rel' => "preload", 'as' => "image", 'href' => $images[0]]);
JqueryAsset::register($this);
SwiperAsset::register($this);
$script = <<<JS
$(document).ready(function() {
});
JS;
$this->registerJs($script);
?>

<header class="landing-header">
    <div class="container d-flex  justify-content-between" style="align-items: center; display: flow-root">
        <div class="" style="float: left">
            <div id="Oplao" data-cl="white" data-id="33141" data-wd="200px" data-hg="80px" data-l="ru" data-c="554234"
                 data-t="C" data-w="m/s" data-p="hPa" data-wg="widget_3" class="170 80"></div>
            <script type="text/javascript" id="weather_widget" charset="UTF-8"
                    src="../js/weather_widget.js"></script> <!-- https://oplao.com/js/weather_widget.js -->
        </div>
        <div style="align-items: center">
            <a href="/" class="landing-logo">
                <img src="<?= \Yii::$app->params['staticHostInfo'] . '/files/images/koenigs_ru.png' ?>"
                     class="img-responsive" alt="Портал бронирования экскурсий">
            </a>
        </div>
        <div class="d-flex">
            <div class="mr-4">
                <a href="https://vk.com/koenigsru" target="_blank" rel="nofollow"><span class="landing-top-contact"><i
                                class="fab fa-vk"></i></span></a>
            </div>
            <div class="mr-4">
                <a href="https://www.instagram.com/koenigs.ru" target="_blank" rel="nofollow"><span
                            class="landing-top-contact"><i class="fab fa-instagram"></i></span></a>
            </div>
            <div style="align-items: center" class="mr-4">
                <span class="landing-top-contact"><i
                            class="fas fa-phone"></i> <?= \Yii::$app->params['supportPhone']; ?></span>
            </div>
            <div style="align-items: center">
                <?php if ($user): ?>
                    <span class="landing-top-contact"><a href="<?= Url::to(['/cabinet/profile']) ?>"
                                                         title="<?= Lang::t('Кабинет') ?>" rel="nofollow"><i
                                    class="fas fa-user"></i></a></span>

                <?php else: ?>
                    <span class="landing-top-contact"><a href="<?= Url::to(['/login']) ?>"
                                                         title="<?= Lang::t('Войти') ?>" rel="nofollow"><i
                                    class="fas fa-sign-in-alt"></i></a></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<div class="item-responsive item-2-80by1">
    <div class="content-item">
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
        ?>
        <?php foreach ($images as $i => $image): ?>
            <div class="item-class">
                <img loading="lazy" src="<?= $image ?>" alt="На отдых в Калининградскую область">
                <div class="container">
                    <div class="carousel-caption">
                        <?php if ($i == 0) {
                            echo '<h1><p class="landing-h1">' . Lang::t('Калининград') . '</p>';
                            echo '<p class="landing-h2">';
                        } else {
                            echo '<p class="landing-h1">' . Lang::t('Калининград') . '</p>';
                            echo '<p class="landing-h2">';
                        } ?>
                        <span class="line-t"></span><?= Lang::t('для туристов и гостей') ?><span
                                class="line-b"></span>
                        <?php if ($i == 0) {
                            echo '</p></h1>';
                        } else {
                            echo '</p>';
                        } ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php OwlCarouselWidget::end(); ?>
    </div>
</div>
<div class="landing-block-center">
    <div class="container">
        <h2 class="landing-title-h2"><span class="line-t-title"></span><?= Lang::t('Для гостей') ?><span
                    class="line-b-title"></span></h2>
        <div class="row">
            <div class="col-sm-4 col-md-3 pt-4">
                <?= $this->render('_button', [
                    'url' => '/tours',
                    'img_name' => 'tour.jpg',
                    'img_alt' => 'Экскурсии в Калининграде',
                    'caption' => 'Экскурсии',
                ]) ?>
            </div>
            <div class="col-sm-4 col-md-3 pt-4">
                <?= $this->render('_button', [
                    'url' => '/stays',
                    'img_name' => 'stay.jpg',
                    'img_alt' => 'Бронирование жилья в Калининграде',
                    'caption' => 'Апартаменты',
                ]) ?>
            </div>
            <div class="col-sm-4 col-md-3 pt-4">
                <?= $this->render('_button', [
                    'url' => '/funs',
                    'img_name' => 'fun.jpg',
                    'img_alt' => 'Развлечения и отдых в Калининграде',
                    'caption' => 'Развлечения',
                ]) ?>
            </div>
            <div class="col-sm-4 col-md-3 pt-4">
                <?= $this->render('_button', [
                    'url' => '/cars',
                    'img_name' => 'car.jpg',
                    'img_alt' => 'Прокат авто в Калининграде',
                    'caption' => 'Прокат авто',
                ]) ?>
            </div>

            <div class="col-sm-4 col-md-3 pt-4">
                <?= $this->render('_button', [
                    'url' => '/foods',
                    'img_name' => 'food.jpg',
                    'img_alt' => 'Где поесть в Калининграде',
                    'caption' => 'Где поесть',
                ]) ?>
            </div>
            <div class="col-sm-4 col-md-3 pt-4">
                <?= $this->render('_button', [
                    'url' => '/shops',
                    'img_name' => 'shop.jpg',
                    'img_alt' => 'Что купить в Калининграде',
                    'caption' => 'Сувениры',
                ]) ?>
            </div>
            <div class="col-sm-4 col-md-3 pt-4">
                <?= $this->render('_button', [
                    'url' => '/post',
                    'img_name' => 'blog.jpg',
                    'img_alt' => 'Блог о Калининграде',
                    'caption' => 'Блог о Калининграде',
                ]) ?>
            </div>
            <div class="col-sm-4 col-md-3 pt-4">
                <?= $this->render('_button', [
                    'url' => '/moving',
                    'img_name' => 'moving.jpg',
                    'img_alt' => 'На ПМЖ в Калининграде',
                    'caption' => 'На ПМЖ',
                ]) ?>
            </div>
            <div class="col-sm-4 col-md-3 pt-4">
                <?= $this->render('_button', [
                    'url' => '/realtor',
                    'img_name' => 'land.jpg',
                    'img_alt' => 'Купить-продать землю и недвижимость в Калининграде',
                    'caption' => 'Земельные участки<br>Недвижимость',
                ]) ?>
            </div>
            <div class="col-sm-4 col-md-3 pt-4">
                <?= $this->render('_button', [
                    'url' => '/night',
                    'img_name' => 'night.jpg',
                    'img_alt' => 'Ночная жизнь в Калининграде',
                    'caption' => 'Ночная жизнь<br>Развлечения<br>Отдых',
                ]) ?>
            </div>
        </div>
    </div>
</div>
<div class="landing-block-center">
    <div class="container">
        <h2 class="landing-title-h2"><span class="line-t-title"></span><?= Lang::t('О Калининградской области') ?><span
                    class="line-b-title"></span></h2>
        <div class="row">
            <div class="col-12" style="font-size: 18px; text-align: justify; letter-spacing: 1px; line-height: 2;">
                <p class="indent">
                    Калининградская область — самый западный регион России и единственный не имеющий сухопутной границей
                    с
                    Россией.
                    Добраться к нам быстрее и дешевле будет на самолете, для этого потребуется только паспорт гражданина
                    РФ.</p>
                <p class="indent">
                    История Калининградской области - это богатая история в которой оставили свой след племена Пруссии,
                    рыцари Тевтонского ордена и советское прошлое.
                </p>
                <p class="indent">
                    На территории региона расположено много историко-культурных и архитектурных памятников, такие как
                    форты,
                    замки, кирхи и многое другое.
                    Сегодня происходит восстановление многих памятников, а также создание новых архитектурных
                    достопримечательностей, которые могут посетить туристы.
                    Также имеются природные и заповедные парки, открытые для посещения гостями, а в теплые летние можно
                    искупаться в балтийском море и погреться на песчаных пляжах.
                    Или прогуляться по уютным улочкам приморских городов и посетить кафешки с домашней обстановкой. </p>
                <p class="indent">А может Вам будет интересна история города или Вы хотели бы посетить необычные места,
                    тогда можно совершить экскурсию с одним из наших гидов.</p>
            </div>
        </div>
        <div class="row pt-5">
            <div class="col-12">
                <?= BlogLandingWidget::widget(); ?>
            </div>
        </div>
    </div>
</div>
<div class="landing-block-center">
    <div class="container">
        <h2 class="landing-title-h2"><span class="line-t-title"></span><?= Lang::t('Авиабилеты в Калининград') ?><span
                    class="line-b-title"></span></h2>
        <div class="row">
            <div class="col-12" style="font-size: 18px; text-align: justify; letter-spacing: 1px; line-height: 2;">
                <p class="indent">
                    Гости Калининградской области прилетают в аэропорт Храброво, носящий имя Елизоветы Петровны, который находится в 18 км от Калининграда.
                    Стоимость самых дешевых билетов из Москвы варьируется от 1499 руб в низкий сезон, и в высокий сезон от 5000 руб.
                    Количество авиакомпаний осуществляющих перевозки пассажиров в Калининград не менее 15.
                    Вы можете <a href="<?= Url::to(['/avia'])?>">приобрести авиабилет в Калининград</a> на любую из них.
                    </p>
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
                <p class="indent">
                    Если Вы оказываете различные туристические услуги для гостей и жителей нашего региона, то Вы можете
                    разместить их на нашем сайте.
                    Для размещения доступны следующие услуги: экскурсии, прокат транспортных средств, бронирование
                    апартаментов/домов (целиком) и развлечения (активный, культурный отдых).
                </p> Зарегистрироваться можно по адресу <a href="https://admin.koenigs.ru" rel="nofollow"
                                                           target="_blank">admin.koenigs.ru</a>.<br>
            </div>
        </div>
    </div>
</div>
<div class="landing-block-center">
    <div class="container">
        <!--h2 class="landing-title-h2"><span class="line-t-title"></span><?= Lang::t('Календарь событий') ?><span
                    class="line-b-title"></span></h2-->
        <div id="nb_events">
            <!--script id="nbEventsScript" type="text/javascript"  src="https://widget.nbcrs.org/Js/Widget/loader.js?key=aa3ea4347e024444b40b50157ddef198&subKey=39930838">
            </script-->
        </div>
    </div>
</div>
<div class="landing-block-center">
    <div class="container">
        <?= $this->render('_seo_text') ?>
    </div>
</div>

