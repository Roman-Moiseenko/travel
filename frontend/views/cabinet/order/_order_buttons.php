<?php
use booking\entities\shops\order\Order;
use frontend\widgets\design\BtnCancel;
use frontend\widgets\design\BtnEdit;
use frontend\widgets\design\BtnPay;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $order Order */

?>

<?php if ($order->isPrepare()): ?>
    <div class="d-flex">
        <div class="ml-2">
            <?= BtnCancel::widget(['url' => Url::to(['/cabinet/order/delete', 'id' => $order->id]), 'caption' => 'Удалить'])?>
        </div>
        <div class="ml-auto">
            <?= BtnEdit::widget(['url' => Url::to(['/cabinet/order/new', 'id' => $order->id]), 'caption' => 'Оформить заказ']) ?>
        </div>
    </div>
<?php endif; ?>
<?php if ($order->isNew()): ?>
    <div class="d-flex">
        <div class="ml-2">
            <?= BtnCancel::widget(['url' => Url::to(['/cabinet/order/delete', 'id' => $order->id]), 'caption' => 'Удалить'])?>
        </div>
        <div class="ml-auto">

        </div>
    </div>
<?php endif; ?>

<?php if ($order->isConfirmation()): ?>
    <div class="d-flex">
        <div class="ml-2">
            <?= BtnCancel::widget(['url' => Url::to(['/cabinet/order/delete', 'id' => $order->id]), 'caption' => 'Удалить'])?>
        </div>
        <div class="ml-auto">
            <?= BtnPay::widget(['url' => Url::to(['/cabinet/yandexkassa/invoice-shop', 'id' => $order->id])]);// Html::a('Оплатить', Url::to(['/cabinet/yandexkassa/invoice-shop', 'id' => $order->id]), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
<?php endif; ?>


