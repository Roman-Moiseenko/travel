<?php

/* @var $this \yii\web\View */
/* @var $content string */
use booking\entities\Lang;
use frontend\widgets\AlertWidget;
use frontend\widgets\TopmenuWidget;
use yii\helpers\Html;
use yii\helpers\Url;
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
    <meta property="og:title" content="<?= Html::encode($this->title) ?>">
    <meta property="og:image" content="<?= \Yii::$app->params['staticHostInfo'] . '/files/images/logo-admin.jpg' ?>">
    <?php if (isset($this->params['canonical'])) {
        echo '<meta property="og:url" content="' . $this->params['canonical'] . '">' . PHP_EOL;
        echo '<link rel="canonical" href="' . $this->params['canonical'] . '">' . PHP_EOL;
    } ?>
    <?php $this->head() ?>
    <?php if (isset($this->params['notMap-MMMM'])): ?>
        <!--script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5f83859ccbf60e8b&async=1&domready=1">
            var addthis_config = {data_ga_property: <?= \Yii::$app->params['GoogleAnalyticAPI'] ?>};
        </script-->
        <script src="https://api-maps.yandex.ru/2.1/?apikey=<?= \Yii::$app->params['YandexAPI'] ?>&lang=<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>"
                type="text/javascript">
        </script>
    <?php endif ?>
    <script src="/js/lazysizes.min.js" async></script>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
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
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/70580203" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async
            src="https://www.googletagmanager.com/gtag/js?id=<?= \Yii::$app->params['GoogleAnalyticAPI'] ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', '<?= \Yii::$app->params['GoogleAnalyticAPI'] ?>');
    </script>
</head>
<body>
<?php $this->beginBody() ?>
<nav id="top"><?= TopmenuWidget::widget() ?></nav>
<div id="common-home" class="container content-container">
    <?= Breadcrumbs::widget([
        'options' => ['class' => 'breadcrumb-site'],
        'homeLink' => [
            'label' => Lang::t('Главная'),
            'url' => Yii::$app->homeUrl,
            'title' => Lang::t('На главную'),
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <?= AlertWidget::widget() ?>
    <?= $content ?>
</div>
<!-- Main Footer -->
<?= $this->render('footer') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

