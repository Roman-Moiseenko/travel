<?php


use booking\entities\Lang;
use booking\entities\user\User;
use frontend\assets\SwiperAsset;
use frontend\widgets\BlogLandingWidget;
use frontend\widgets\menu\MainMenu;
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

$this->registerLinkTag(['rel' => "preload", 'as' => "image", 'href' => $images[0]]);
JqueryAsset::register($this);
SwiperAsset::register($this);

$this->params['not_container'] = true;
/*$script = <<<JS
$(document).ready(function() {
});
JS;
$this->registerJs($script);*/
$mobile = \booking\helpers\SysHelper::isMobile();
?>


    <!--div class="container d-flex  justify-content-between" style="align-items: center; display: flow-root">
        <div class="" style="float: left">
            <div id="Oplao" data-cl="white" data-id="33141" data-wd="200px" data-hg="80px" data-l="ru" data-c="554234"
                 data-t="C" data-w="m/s" data-p="hPa" data-wg="widget_3" class="170 80"></div>
            <script type="text/javascript" id="weather_widget" charset="UTF-8"
                    src="https://oplao.com/js/weather_widget.js"></script> <!-- https://oplao.com/js/weather_widget.js  ../js/weather_widget.js -->
        <!--/div>
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
            </div>
            <?php if (!empty(\Yii::$app->params['supportPhone'])): ?>
            <div style="align-items: center" class="mr-4">
                <span class="landing-top-contact"><i
                            class="fas fa-phone"></i> <?= \Yii::$app->params['supportPhone']; ?></span>
            </div>
            <?php endif; ?>
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
            </div-->
        <!--/div>
    </div-->


<?php if(!$mobile): ?>
    <div class="item-responsive item-2-80by1 with-top-header">
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
            </div>
        <?php endforeach; ?>
        <?php OwlCarouselWidget::end(); ?>
        <div class="container">
            <div class="carousel-caption">
                <h1><p class="landing-h1">Калининград</p>
                    <p class="landing-h2"><span class="line-t"></span>для туристов и гостей<span class="line-b"></span></p>
                </h1>
            </div>
        </div>
        </div>
    </div>
<?php else: ?>
    <h1 style="text-align: center; align-items: center;">Калининград для туристов</h1>
<?php endif;?>


<div class="landing-block-center ">
    <div class="container">
        <h2 class="<?= $mobile ? 'mobile-title-h2' : 'landing-title-h2' ?>"><span class="<?= $mobile ? '' : 'line-t-title'?>"></span>Для гостей<span class="<?= $mobile ? '' : 'line-b-title'?>"></span></h2>
        <?php if ($mobile): ?>
            <?php foreach ($buttons as $button):?>
                <?= $this->render('_button_mobile', $button) ?>
            <?php endforeach;?>
        <?php else: ?>
        <div class="row">
            <?php foreach ($buttons as $button):?>
                <div class="col-sm-4 col-md-3 pt-4">
                    <?= $this->render('_button', $button) ?>
                </div>
            <?php endforeach;?>
        </div>
        <?php endif; ?>
    </div>
</div>
<div class="landing-block-center">
    <div class="container">
        <h2 class="<?= $mobile ? 'mobile-title-h2' : 'landing-title-h2' ?>"><span class="<?= $mobile ? '' : 'line-t-title'?>"></span>О Калининградской области<span
                    class="<?= $mobile ? '' : 'line-b-title'?>"></span></h2>
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
                <?= ''//BlogLandingWidget::widget(); ?>
            </div>
        </div>
    </div>
</div>
<div class="landing-block-center">
    <div class="container">
        <h2 class="<?= $mobile ? 'mobile-title-h2' : 'landing-title-h2' ?>"><span class="<?= $mobile ? '' : 'line-t-title'?>"></span>Авиабилеты в Калининград<span class="<?= $mobile ? '' : 'line-b-title'?>"></span></h2>
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

