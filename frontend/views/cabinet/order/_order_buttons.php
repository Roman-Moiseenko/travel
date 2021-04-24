<?php
use booking\entities\shops\order\Order;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $order Order */

?>

<?php if ($order->isPrepare()): ?>
    <div class="d-flex">
        <div class="ml-2">
            <?= Html::a('Удалить', Url::to(['/cabinet/order/delete', 'id' => $order->id]), ['class' => 'btn btn-warning']) ?>
        </div>
        <div class="ml-auto">
            <?= Html::a('Оформить заказ >', Url::to(['/cabinet/order/new', 'id' => $order->id]), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php endif; ?>
<?php if ($order->isNew()): ?>
    <div class="d-flex">
        <div class="ml-2">
            <?= Html::a('Удалить', Url::to(['/cabinet/order/delete', 'id' => $order->id]), ['class' => 'btn btn-warning']) ?>
        </div>
        <div class="ml-auto">

        </div>
    </div>
<?php endif; ?>

<?php if ($order->isConfirmation()): ?>
    <div class="d-flex">
        <div class="ml-2">
            <?= Html::a('Удалить', Url::to(['/cabinet/order/delete', 'id' => $order->id]), ['class' => 'btn btn-warning']) ?>
        </div>
        <div class="ml-auto">
            <?= Html::a('Оплатить', Url::to(['/cabinet/yandexkassa/invoice-shop', 'id' => $order->id]), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
<?php endif; ?>


