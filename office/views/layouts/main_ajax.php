<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

office\assets\AppAsset::register($this);
\hail812\adminlte3\assets\FontAwesomeAsset::register($this);
\hail812\adminlte3\assets\AdminLteAsset::register($this);
$local = \Yii::$app->params['local'] ?? false;
if (!$local)
    $this->registerCssFile('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700');

$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?php $this->head() ?>
</head>
<body class="hold-transition">
<?php $this->beginBody() ?>
    <?= $content?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
