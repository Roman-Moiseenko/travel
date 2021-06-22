<?php

use admin\widgest\ProfileLeftBarWidget;
use booking\entities\booking\trips\Trip;
use booking\helpers\trips\TripHelper;
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
                    ['label' => 'Описание', 'icon' => 'align-justify', 'url' => ['/trip/common', 'id' => $this->params['id']], 'active' => $this->context->id == 'trip/common'],
                    ['label' => 'Фотографии', 'icon' => 'camera-retro', 'url' => ['/trip/photos', 'id' => $this->params['id']], 'active' => $this->context->id == 'trip/photos'],
                    ['label' => 'Видеообзоры', 'icon' => 'video', 'url' => ['/trip/videos', 'id' => $this->params['id']], 'active' => $this->context->id == 'trip/videos'],
                    ['label' => 'Параметры', 'iconStyle' => 'fab', 'icon' => 'wpforms', 'url' => ['/trip/params', 'id' => $this->params['id']], 'active' => $this->context->id == 'trip/params'],
                    ['label' => 'Проживание', 'icon' => 'laptop-house', 'url' => ['/trip/', 'id' => $this->params['id']], 'active' => $this->context->id == 'trip/'],
                    ['label' => 'Мероприятия', 'icon' => 'directions', 'url' => ['/trip/', 'id' => $this->params['id']], 'active' => $this->context->id == 'trip/'],

                    // ['label' => 'Дополнения', 'icon' => 'donate', 'url' => ['/trip/extra', 'id' => $this->params['id']], 'active' => $this->context->id == 'trip/extra'],
                    ['label' => 'Цены', 'icon' => 'money-check-alt', 'url' => ['/trip/finance', 'id' => $this->params['id']], 'active' => $this->context->id == 'trip/finance'],
                    ['label' => 'Календарь', 'iconStyle' => 'far', 'icon' => 'calendar-alt', 'url' => ['/trip/calendar', 'id' => $this->params['id']], 'active' => $this->context->id == 'trip/calendar'],
                    ['label' => 'Бронирования', 'icon' => 'calendar-alt', 'url' => ['/tour/booking', 'id' => $this->params['id']], 'active' => $this->context->id == 'trip/booking',
                        'badge' => '<span class="right badge badge-info">'. TripHelper::getCountActiveBooking($this->params['id']) . '</span>'],
                    ['label' => 'Отзывы', 'icon' => 'comment-dots', 'url' => ['/tour/review', 'id' => $this->params['id']], 'active' => $this->context->id == 'trip/review',
                        'badge' => '<span class="right badge badge-warning">'. TripHelper::getCountReview($this->params['id']) . '</span>'],
                    ['label' => 'Отчеты', 'icon' => 'chart-pie', 'url' => ['/trip/report', 'id' => $this->params['id']], 'active' => $this->context->id == 'trip/report'],
                    ['label' => 'Прямая продажа', 'icon' => 'hand-holding-usd', 'url' => ['/trip/selling', 'id' => $this->params['id']], 'active' => $this->context->id == 'trip/selling'],
                    ['label' => 'koenigs.ru', 'header' => true],
                    ['label' => 'Просмотр на сайте', 'iconStyle' => 'far', 'icon' => 'eye', 'url' => Url::to(\Yii::$app->params['frontendHostInfo'] . '/trip/' . Trip::findOne($this->params['id'])->slug)],

                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>