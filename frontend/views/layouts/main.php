<?php

/* @var $this \yii\web\View */
/* @var $content string */

use booking\entities\Lang;
use frontend\widgets\TopmenuWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <nav id="top">


                <?= TopmenuWidget::widget()?>

    </nav>


    <div id="common-home" class="container">
        <?= Breadcrumbs::widget([

            'homeLink' => [
                'label' => Lang::t('Главная'),
                'url' => Yii::$app->homeUrl,
                'title' => Lang::t('На главную'),
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h5>Информация</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?=Html::encode(Url::to(['/about']))?>">О Магазине</a></li>
                        <li><a href="<?=Html::encode(Url::to(['/delivery']))?>">Доставка</a></li>
                        <li><a href="<?=Html::encode(Url::to(['/policy']))?>">Политика конфиденциальности</a></li>
                        <li><a href="">Terms &amp; Conditions</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Customer Service</h5>
                    <ul class="list-unstyled">
                        <li><a href="">Contact Us</a></li>
                        <li><a href="">Returns</a></li>
                        <li><a href="">Site Map</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Extras</h5>
                    <ul class="list-unstyled">
                        <li><a href="">Brands</a></li>
                        <li><a href="">Gift Certificates</a></li>
                        <li><a href="">Affiliate</a></li>
                        <li><a href="">Specials</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Личный кабинет</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= Html::encode(Url::to(['/cabinet/default/index'])) ?>">Кабинет</a></li>
                        <li><a href="<?= Html::encode(Url::to(['/cabinet/order/index'])) ?>">Заказы</a></li>
                        <li><a href="<?= Html::encode(Url::to(['/cabinet/wishlist/index'])) ?>">Избранное</a></li>
                        <li><a href="">Newsletter</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <p><?= Lang::t('Разработано') ?> <a href="http://www.mycraft.site" target="_blank">Моисеенко Роман Александрович</a> &copy; 2020</p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    <script type="text/javascript"><!--
        $('#slideshow0').swiper({
            mode: 'horizontal',
            slidesPerView: 1,
            pagination: '.slideshow0',
            paginationClickable: true,
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            spaceBetween: 30,
            autoplay: 2500,
            autoplayDisableOnInteraction: true,
            loop: true
        });
        --></script>
    <script type="text/javascript"><!--
        $('#carousel0').swiper({
            mode: 'horizontal',
            slidesPerView: 5,
            pagination: '.carousel0',
            paginationClickable: true,
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            autoplay: 2500,
            loop: true
        });
        --></script>
    <script type="text/javascript"><!--
        $('#banner0').swiper({
            effect: 'fade',
            autoplay: 2500,
            autoplayDisableOnInteraction: false
        });
        --></script>
    </body>
    </html>
<?php $this->endPage() ?>