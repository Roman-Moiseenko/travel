<?php

use booking\entities\Lang;
use booking\entities\shops\order\Order;
use booking\entities\shops\order\StatusHistory;
use booking\helpers\CurrencyHelper;
use booking\helpers\SysHelper;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $order Order */
/* @var $iterator integer */
?>

<div class="card list-cart">
    <a class="link-admin" data-toggle="collapse" href="#collapse-<?= $iterator ?>" role="button"
       aria-expanded="false" aria-controls="collapseExample">
    <div class="card-header">
        <div class="d-flex">
            <div class="m-2">
            <?= StatusHistory::toHtml($order->current_status) ?>
            </div>
            <div class="ml-auto my-2" style="color: #0c525d">
                <?= Lang::t('Заказ #') . $order->number . ' ' . Lang::t('от') . ' ' . date('d-m-Y', $order->created_at) ?>
            </div>
        </div>
        <div class="d-flex">
            <div class="m-2">
                <i class="fas fa-store"></i> <?= $order->shop->getName() ?>
            </div>
            <div class="ml-auto mt-2" style="font-size: 14px; font-weight: 600;">
            <?= CurrencyHelper::get($order->payment->getFull()) ?>
            </div>
        </div>
    </div>
    </a>
    <div class="collapse <?= $order->isPrepare() ? 'show' : ''?>" id="collapse-<?= $iterator ?>">
        <div class="card-body">
            <?php foreach ($order->items as $i => $item): ?>
                <div class="pt-2 d-flex" style="font-size: 14px">
                    <div class="align-self-center p-2" style="font-weight: 600; color: #0c525d">
                        <?= $i + 1 ?>
                    </div>
                    <div class="align-self-center p-2">
                        <a href="<?= Url::to(['shop/catalog/product', 'id' => $item->product_id])?>"><?= $item->product->getName() ?></a>
                    </div>
                </div>
                <div>
                    <div class="align-self-center">
                        <?= $item->quantity . ' шт x ' . CurrencyHelper::get($item->product_cost) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?= $this->render('_order_comment', [
            'order' => $order,
        ]) ?>
        <div class="card-footer"> <!-- или p-3 -->
            <?= $this->render('_order_buttons', [
                'order' => $order,
            ]) ?>
        </div>
    </div>
</div>
