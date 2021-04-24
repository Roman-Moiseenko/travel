<?php

use booking\entities\Lang;
use booking\entities\shops\order\DeliveryData;
use booking\entities\shops\order\Order;
use booking\entities\shops\order\StatusHistory;
use booking\helpers\shops\DeliveryHelper;

/* @var $order Order */

?>
<?php if ($order->deliveryData->method) {
    echo '<div class="p-3">';
    echo '<hr />';
    if ($order->deliveryData->method == DeliveryData::METHOD_POINT) {
        echo Lang::t('Самовывоз');
    }
    if ($order->deliveryData->method == DeliveryData::METHOD_CITY) {
        echo Lang::t('Доставка по городу: ') . $order->deliveryData->address_city . ', ' . $order->deliveryData->address_street;
    }
    if ($order->deliveryData->method == DeliveryData::METHOD_COMPANY) {
        echo Lang::t('Доставка по России Транспортной Компанией ') . DeliveryHelper::name($order->deliveryData->company) . '<br>';
        echo Lang::t('адрес доставки: ') . $order->deliveryData->address_city . ', ' . $order->deliveryData->address_street . '<br>';
        echo Lang::t('получатель: ') . $order->deliveryData->fullname . ', ' . $order->deliveryData->phone . '<br>';
    }
    echo '</div>';
}
?>
<?php if (!$order->isPrepare() && !$order->isNew()): ?>
    <hr/>
    <div class="m-2" style="font-weight: 600">
        <?= Lang::t('Комментарии Магазина к заказу:') ?>
    </div>
    <div class="m-2">
        <?php foreach ($order->statuses as $status): ?>
        <?php if ($status->comment != '' || $status->status == StatusHistory::ORDER_COMPLETED): ?>
            <div class="d-flex">
                <div class="m-2"><?= date('d-m-Y H:i', $status->created_at)?></div>
                <div class="m-2">
                    <?= ($status->status == StatusHistory::ORDER_COMPLETED)
                        ? '<a href="' . $order->getUploadedFileUrl('document'). '"><img src="' . $order->getThumbFileUrl('document', 'admin') .'"></a>'
                        : $status->comment?>
                </div>
            </div>
        <?php endif;?>

        <?php endforeach; ?>
    </div>
<?php endif; ?>


