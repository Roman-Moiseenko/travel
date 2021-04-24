<?php

use booking\entities\booking\BaseBooking;
use booking\entities\shops\order\Order;
use booking\helpers\CurrencyHelper;
use yii\helpers\Url;


/* @var $orders Order[] */
/* @var $count int */
?>
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-hourglass"></i>
        <span class="badge badge-success navbar-badge"><?= count($orders) ?></span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header"><?= count($orders) ?> Заказов</span>
        <?php foreach ($orders as $order): ?>
            <div class="dropdown-divider"></div>
            <div class="">
                <a href="<?= Url::to(['/shop/selling/view', 'id' => $order->id]) ?>" class="dropdown-item">
                    <div class="d-flex">
                        <div>
                            <img src="<?= $order->shop->mainPhoto->getThumbFileUrl('file', 'widget_list') ?>">
                        </div>
                        <div class="px-1 align-content-center">
                            <span style="white-space: pre-wrap !important; font-size: 12px; font-weight: 500;"> <?= $order->shop->name ?> </span>
                        </div>
                        <div class="ml-auto">
                            <span class="float-right text-muted text-sm"><?= CurrencyHelper::stat($order->payment->full_cost) ?></span>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
        <span class="dropdown-item dropdown-footer"></span>
    </div>
</li>
