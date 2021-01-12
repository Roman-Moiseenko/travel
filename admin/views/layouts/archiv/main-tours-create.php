<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>
<?php $this->beginContent('@admin/views/layouts/template.php') ?>
    <!-- Navbar -->
    <?= ''//$this->render('navbar', ['assetDir' => $assetDir]) ?>
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <?= $this->render('content-create', ['content' => $content, 'assetDir' => $assetDir]) ?>
    <!-- /.content-wrapper -->
    <!-- Control Sidebar -->
    <?= ''//$this->render('control-sidebar') ?>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?= $this->render('footer') ?>
<?php $this->endContent() ?>
