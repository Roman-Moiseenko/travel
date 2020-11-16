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
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="copyright" content="Моисеенко Роман Александрович">
    <meta name="yandex-verification" content="7e8361bb699b88a1" />
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= \Yii::$app->params['GoogleAnalyticAPI'] ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', <?= \Yii::$app->params['GoogleAnalyticAPI'] ?>);
    </script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5f83859ccbf60e8b">
        var addthis_config = {data_ga_property: <?= \Yii::$app->params['GoogleAnalyticAPI'] ?>};
    </script>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=<?= \Yii::$app->params['YandexAPI']?>&lang=<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>" type="text/javascript">
    </script>
</head>
<body>
<?php $this->beginBody() ?>

<div id="common-home" class="container content-container">
    <?= $content ?>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

