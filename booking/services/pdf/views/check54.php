<?php

use booking\entities\booking\BookingItemInterface;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use YandexCheckout\Request\Receipts\ReceiptResponseInterface;

/* @var $booking BookingItemInterface
 * @var $item ReceiptResponseInterface */

?>
<div class="container">

    <!-- ШАПКА -->
    <div class="row">
        <div style="text-align: center">
            <b><?= 'Кассовый чек №' . BookingHelper::number($booking) ?></b>
            <?= date('d-m-Y H:i', $item->registered_at->getTimestamp()) ?>
        </div>
    <!-- ЧЕК -->
    <!-- QR -->
    <!-- ПОДВАЛ -->

</div>
