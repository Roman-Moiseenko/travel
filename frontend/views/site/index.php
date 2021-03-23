<?php


use booking\entities\Lang;
use kv4nt\owlcarousel\OwlCarouselWidget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $images array */
$this->title = Lang::t('На отдых в Калининград');
?>

<header class="landing-header">
    <div class="container d-flex  justify-content-between"  style="align-items: center; display: flow-root">
        <div class="" style="float: left">
            <div id="Oplao" data-cl="white" data-id="33141" data-wd="200px" data-hg="80px" data-l="ru" data-c="554234"
                 data-t="C" data-w="m/s" data-p="hPa" data-wg="widget_3" class="170 80"></div>
            <script type="text/javascript" id="weather_widget" charset="UTF-8"
                    src="https://oplao.com/js/weather_widget.js"></script>
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
        //    'itemsDesktop'      => [1199, 3],
        //   'itemsDesktopSmall' => [979, 3]
    ]
]);
?>


<?php foreach ($images as $image): ?>
    <div class="item-class">
        <img src="<?= $image ?>"
             alt="Image 1">
        <div class="container">
            <div class="carousel-caption">
                <h1 class="landing-h1">Кёнигсберг</h1>
                <p class="landing-h2">
                    <span class="line-t"></span>На отдых в Калининградскую область<span class="line-b"></span></p>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php OwlCarouselWidget::end(); ?>
<div class="landing-block-center">
    <div class="container">
        <h2 class="landing-title-h2"><span class="line-t-title"></span>Для гостей<span class="line-b-title"></span></h2>

        <div class="row" style="height: 250px">

            <div class="col-3" style="background-color: #0c525d; color: white; font-size: 22px">
                <a href="<?= Url::to(['/tours']) ?>">
                    Экскурсии
                </a>
            </div>


            <div class="col-3" style="background-color: #265d3c; color: white; font-size: 22px">
                <a href="<?= Url::to(['/stays']) ?>">Апартаменты</a>
            </div>


            <div class="col-3" style="background-color: #5d2c18; color: white; font-size: 22px">
                <a href="<?= Url::to(['/funs']) ?>">Развлечения</a>
            </div>


            <div class="col-3" style="background-color: #481a5d; color: white; font-size: 22px">
                <a href="<?= Url::to(['/cars']) ?>">Прокат Авто</a>
            </div>

        </div>
    </div>
</div>
<div class="landing-block-center">
    <div class="container">
        <h2 class="landing-title-h2"><span class="line-t-title"></span>О Калининградской области<span
                    class="line-b-title"></span></h2>
        <div class="row" style="height: 300px">
            <div class="col-12" style="background-color: #d4d4d4;font-size: 16px">
                Текст об области, 3 или 4 фото
            </div>
        </div>
        <div class="row" style="height: 100px">
            <div class="col-12">
                Карусель с постами блога
            </div>
        </div>

    </div>
</div>
<div class="landing-block-center">
    <div class="container">
        <h2 class="landing-title-h2"><span class="line-t-title"></span>Календарь событий<span
                    class="line-b-title"></span></h2>
        <div id="nb_events">
            <script id="nbEventsScript" type="text/javascript"
                    src="http://widget.nbcrs.org/Js/Widget/loader.js?key=aa3ea4347e024444b40b50157ddef198&subKey=39930838">
            </script>
        </div>
    </div>
</div>

<div class="landing-block-center">
    <div class="container">
        <h2 class="landing-title-h2"><span class="line-t-title"></span>Отзывы Партнеры Ссылки<span
                    class="line-b-title"></span></h2>
    </div>
</div>


<h1>Вас здесь не должно быть ... пока-что ;)</h1>