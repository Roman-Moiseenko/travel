<?php

/* @var $this \yii\web\View */

/* @var $content string */

use booking\entities\Lang;
use frontend\assets\CarAsset;
use frontend\assets\FunAsset;
use frontend\assets\TourAsset;
use frontend\widgets\AlertWidget;
use frontend\widgets\TopmenuWidget;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="author" href="https://koenigs.ru/humans.txt">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="copyright" content="Моисеенко Роман Александрович">
    <meta name="yandex-verification" content="7e8361bb699b88a1"/>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta property="og:type" content="website">
    <meta property="og:locale" content="<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>">
    <meta property="og:title" content="<?= Html::encode($this->title) ?>">
    <meta property="og:image" content="<?= \Yii::$app->params['staticHostInfo'] . '/files/images/logo-admin.jpg' ?>">
    <meta property="og:url" content="<?= \Yii::$app->params['frontendHostInfo'] ?>">

    <link rel="canonical" href="<?= \Yii::$app->params['frontendHostInfo'] ?>">

    <?php $this->head() ?>
    <script defer src="/js/lazysizes.min.js"></script>
    <!-- Yandex.Metrika counter -->
    <script defer type="text/javascript">
        var fired = false;

        window.addEventListener('scroll', () => {
            if (fired === false) {
                fired = true;

                setTimeout(() => {
                    console.log('Идет тестирование загрузки метрики');
                    (function (m, e, t, r, i, k, a) {
                        m[i] = m[i] || function () {
                            (m[i].a = m[i].a || []).push(arguments)
                        };
                        m[i].l = 1 * new Date();
                        k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
                    })
                    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
                    ym(70580203, "init", {
                        clickmap: true,
                        trackLinks: true,
                        accurateTrackBounce: true
                    });

                    window.dataLayer = window.dataLayer || [];
                    function gtag() {
                        dataLayer.push(arguments);
                    }
                    gtag('js', new Date());
                    gtag('config', '<?= \Yii::$app->params['GoogleAnalyticAPI'] ?>');

                    //TODO Свипер загрузаить
                }, 1000)
            }
        });
    </script>
        <script defer type="text/javascript">
        window.onReadyState = (e, t) => {
            const a = ["loading", "interactive", "complete"],
                o = a.slice(a.indexOf(e)),
                n = () => o.includes(document.readyState);
            n() ? t() : document.addEventListener("readystatechange", (() => n() && t()))
        };
        window.onReadyState("complete",function(){

            });
    </script>

    <div><img src="https://mc.yandex.ru/watch/70580203" style="position:absolute; left:-9999px;" alt="Яндекс Метрика"/></div>
    <!-- <noscript></noscript>  /Yandex.Metrika counter -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script defer
            src="https://www.googletagmanager.com/gtag/js?id=<?= \Yii::$app->params['GoogleAnalyticAPI'] ?>"></script>
    <script defer>

    </script>
</head>
<body>
<?php $this->beginBody() ?>
<div id="common-home" class="container-mobile content-container">
    <?= $content ?>
</div>
<!-- Main Footer -->
<?= $this->render('footer') ?>
<?php $this->endBody() ?>
<script type="text/javascript">
    let giftofspeed1 = document.createElement('link');
    giftofspeed1.rel = 'stylesheet';
    giftofspeed1.href = 'https://fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700&display=swap';
    giftofspeed1.type = 'text/css';
    let godefer1 = document.getElementsByTagName('link')[0];
    godefer1.parentNode.insertBefore(giftofspeed1, godefer1);

    let giftofspeed2 = document.createElement('link');
    giftofspeed2.rel = 'stylesheet';
    giftofspeed2.href = 'https://use.fontawesome.com/releases/v5.15.1/css/all.css';
    giftofspeed2.type = 'text/css';
    let godefer2 = document.getElementsByTagName('link')[0];
    godefer2.parentNode.insertBefore(giftofspeed2, godefer2);

    let giftofspeed3 = document.createElement('link');
    giftofspeed3.rel = 'stylesheet';
    giftofspeed3.href = '/css/bootstrap/bootstrap.css';
    giftofspeed3.type = 'text/css';
    let godefer3 = document.getElementsByTagName('link')[0];
    godefer3.parentNode.insertBefore(giftofspeed3, godefer3);

    let giftofspeed4 = document.createElement('link');
    giftofspeed4.rel = 'stylesheet';
    giftofspeed4.href = '/css/swiper.min.css';
    giftofspeed4.type = 'text/css';
    let godefer4 = document.getElementsByTagName('link')[0];
    godefer4.parentNode.insertBefore(giftofspeed4, godefer4);
</script>
<script src="/js/swiper.js"></script>
</body>
</html>
<?php $this->endPage() ?>

