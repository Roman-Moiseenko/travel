<?php

use admin\widgest\ProfileLeftBarWidget;

use booking\entities\booking\stays\Stay;
use booking\helpers\stays\StayHelper;
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
        <?= ProfileLeftBarWidget::widget()?>
        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <?php
            echo \hail812\adminlte3\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Описание', 'icon' => 'align-justify', 'url' => ['/stay/common', 'id' => $this->params['id']], 'active' => $this->context->id == 'stay/common'],
                    ['label' => 'Удобства', 'icon' => 'blender-phone', 'url' => ['/stay/comfort', 'id' => $this->params['id']], 'active' => $this->context->id == 'stay/comfort'],
                    ['label' => 'Правила', 'icon' => 'bell', 'url' => ['/stay/rules', 'id' => $this->params['id']], 'active' => $this->context->id == 'stay/rules'],
                    ['label' => 'Окресности', 'icon' => 'mountain', 'url' => ['/stay/nearby', 'id' => $this->params['id']], 'active' => $this->context->id == 'stay/nearby'],
                    ['label' => 'Спальные места', 'icon' => 'bed', 'url' => ['/stay/bedrooms', 'id' => $this->params['id']], 'active' => $this->context->id == 'stay/bedrooms'],
                    ['label' => 'Параметры', 'iconStyle' => 'fab', 'icon' => 'wpforms', 'url' => ['/stay/params', 'id' => $this->params['id']], 'active' => $this->context->id == 'stay/params'],
                    ['label' => 'Дополнительные сборы', 'icon' => 'coins', 'url' => ['/stay/duty', 'id' => $this->params['id']], 'active' => $this->context->id == 'stay/duty'],
                    ['label' => 'Фотографии', 'icon' => 'camera-retro', 'url' => ['/stay/photos', 'id' => $this->params['id']], 'active' => $this->context->id == 'stay/photos'],
                    ['label' => 'Цены', 'icon' => 'money-check-alt', 'url' => ['/stay/finance', 'id' => $this->params['id']], 'active' => $this->context->id == 'stay/finance'],
                    ['label' => 'Календарь', 'iconStyle' => 'far', 'icon' => 'calendar-alt', 'url' => ['/stay/calendar', 'id' => $this->params['id']], 'active' => $this->context->id == 'stay/calendar'],
                    ['label' => 'Бронирования', 'icon' => 'calendar-alt', 'url' => ['/stay/booking', 'id' => $this->params['id']], 'active' => $this->context->id == 'stay/booking',
                        'badge' => '<span class="right badge badge-info">'. StayHelper::getCountActiveBooking($this->params['id']) . '</span>'],
                    ['label' => 'Отзывы', 'icon' => 'comment-dots', 'url' => ['/stay/review', 'id' => $this->params['id']], 'active' => $this->context->id == 'stay/review',
                        'badge' => '<span class="right badge badge-warning">'. StayHelper::getCountReview($this->params['id']) . '</span>'],
                    ['label' => 'Отчеты', 'icon' => 'chart-pie', 'url' => ['/stay/report', 'id' => $this->params['id']], 'active' => $this->context->id == 'stay/report'],
                    ['label' => 'Прямая продажа', 'icon' => 'hand-holding-usd', 'url' => ['/stay/selling', 'id' => $this->params['id']], 'active' => $this->context->id == 'stay/selling'],
                    ['label' => 'koenigs.ru', 'header' => true],
                    ['label' => 'Просмотр на сайте', 'iconStyle' => 'far', 'icon' => 'eye', 'url' => Url::to(\Yii::$app->params['frontendHostInfo'] . '/stay/' . Stay::findOne($this->params['id'])->slug)],

                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>