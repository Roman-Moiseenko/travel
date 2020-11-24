<?php

use admin\widgest\LeftHelpWidget;
use admin\widgest\ProfileLeftBarWidget;
use booking\helpers\MessageHelper;
use yii\helpers\Url;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Koenigs.RU</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
         <?= ''//ProfileLeftBarWidget::widget()?>
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= Url::to('@static/files/images/logo-admin.jpg') ?>" class="img-circle elevation-2" alt="К объектам бронирования">
            </div>
            <div class="info">
                <a href="<?= Url::to(['/'])?>" class="d-block">Мои объекты</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <?= LeftHelpWidget::widget([
                    'page_id' => $this->params['page_id'],
            ]); ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>