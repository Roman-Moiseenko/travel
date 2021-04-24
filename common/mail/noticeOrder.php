<?php

use booking\entities\booking\BaseBooking;
use booking\entities\shops\order\Order;
use booking\entities\shops\order\StatusHistory;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $order Order */
$user = $order->shop->user;
$url = \Yii::$app->params['adminHostInfo'];

//TODO Доделать письмо

$status = $order->current_status;
?>

<div class="mail-notice" style="color: #0b0b0b;">
    <table style="width: 100%; border: 0;color: #0b0b0b;">
        <tr>
            <td style="width: 25%"></td>
            <td style="text-align: right; width: 50%">
                <?= 'Заказ ' ?>:&#160;
                <a style="text-decoration: none; color: #0071c2;" href="<?= $url . 'ССЫЛКА НА ЗАКАЗ В КАБИНЕТЕ' ?>">
                    <b><?= $order->number ?></b>
                </a>
            </td>
            <td style="width: 25%"></td>
        </tr>
    </table>
    <table style="width: 100%;color: #0b0b0b;">
        <tr>
            <td></td>
            <td>
                <h2><?= 'Добрый день, ' ?><span style="color: #062b31"><?= $order->shop->legal->name ?></span>!</h2>
            </td>
        </tr>
        <tr>
            <td style="width: 25%"></td>
            <td style="width: 50%; text-align: justify; border: 0; font-size: 16px;">
                <?php if ($status == StatusHistory::ORDER_NEW) {
                    echo 'Новый заказ, подтвердите Клиенту, что Вы исполните заказ, после чего будет произведена оплата';
                } ?>
                <?php if ($status == StatusHistory::ORDER_CONFIRMATION) {
                    echo 'Магазин подтвердил Ваш заказ, оплатите заказ в течение 3 рабочих дней';
                } ?>
                <?php if ($status == StatusHistory::ORDER_PAID) {
                    echo 'Клиент оплатил заказ';
                } ?>
                <a style="text-decoration: none; color: #0071c2;" href="<?= $url .  'ССЫЛКА НА ЗАКАЗ В КАБИНЕТЕ' ?>">
                    <?= 'Заказ #' . $order->number ?>
                </a>

                <?= 'Сумма заказа ' ?>: <b><?= CurrencyHelper::get($order->payment->full_cost) ?></b><br>
                <?php foreach ($order->items as $i => $item): ?>
                    <div class="pt-2 d-flex" style="font-size: 14px">
                        <div class="align-self-center p-2" style="font-weight: 600; color: #0c525d">
                            <?= $i + 1 ?>
                        </div>
                        <div class="align-self-center p-2">
                            <a href="<?= Url::to(['shop/catalog/product', 'id' => $item->product_id], true)?>"><?= $item->product->getName() ?></a>
                        </div>
                        <div class="align-self-center ml-auto">
                            <?= $item->quantity . ' шт x ' . CurrencyHelper::stat($item->product_cost) ?>
                        </div>
                    </div>
                <?php endforeach; ?>


            </td>
            <td style="width: 25%"></td>
        </tr>
    </table>
</div>
