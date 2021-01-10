<?php

use booking\entities\booking\BookingItemInterface;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use YandexCheckout\Request\Receipts\ReceiptResponseInterface;

/* @var $booking BookingItemInterface
 * @var $item ReceiptResponseInterface
 */
$kkt = \Yii::$app->params['kkt'];
?>
<div class="container">

        <!-- ШАПКА -->
    <table>
        <tr>
            <td align="center"><b><?= 'Кассовый чек №' . BookingHelper::number($booking) ?></b></td>
        </tr>
        <tr>
            <td align="center"><?= date('d-m-Y H:i', $item->registered_at->getTimestamp()) ?></td>
        </tr>
        <tr>
            <td align="center"><b><?= $kkt['firm'] ?></b></td>
        </tr>
        <tr>
            <td align="center"><b><?= 'ИНН ' . $kkt['INN'] ?></b></td>
        </tr>
        <tr>
            <td align="center"><?= $kkt['address'] ?></td>
        </tr>
    </table>
    <hr style="padding: 0; margin: 0"/>
    <hr style="padding: 0; margin: 3px"/>

    <!-- ЧЕК -->
    <table>
        <tr>
            <td colspan="3" align="center"><b>ПРИХОД</b></td>
        </tr>
        <tr>
            <th>№</th>
            <th align="center">Наименование</th>
            <th>Сумма</th>
        </tr>
        <tr>
            <td style="font-size: 10px">1.</td>
            <td align="center" style="font-size: 10px"><?= $booking->getName() . '   1x' . number_format(BookingHelper::merchant($booking), 2, ',', '') . '₽' ?></td>
            <td style="font-size: 10px"><?= number_format(BookingHelper::merchant($booking), 2, ',', '') . '₽' ?></td>
        </tr>

    </table>
    <p></p>
    <!-- ИТОГО -->
    <table>
        <tr>
            <th align="left" style="font-size: 16px" width="50%">ИТОГО</th>
            <th align="right" style="font-size: 16px"><?= number_format(BookingHelper::merchant($booking), 2, ',', '') . '₽' ?></th>
        </tr>
        <tr>
            <td align="left" style="font-size: 12px">Без НДС</th>
            <td align="right" style="font-size: 12px"><?= number_format(BookingHelper::merchant($booking), 2, ',', '') . '₽' ?></td>
        </tr>
        <tr>
            <td align="left" style="font-size: 12px">Безналичными</th>
            <td align="right" style="font-size: 12px"><?= number_format(BookingHelper::merchant($booking), 2, ',', '') . '₽' ?></td>
        </tr>
        <tr>
            <td style="font-size: 12px">Налогообложение</td>
            <td align="right" style="font-size: 12px"><?= $kkt['tax'] ?></td>
        </tr>
    </table>
    <hr/>
    <!-- ПОДВАЛ -->
    <table>
        <tr>
            <td width="40%">Номер ФД</td>
            <td align="right"><?= $item->fiscal_document_number ?></td>
        </tr>
        <tr>
            <td>ФПД</td>
            <td align="right"><?= $item->fiscal_attribute ?></td>
        </tr>
        <tr>
            <td>Рег. номер ККТ в ФНС</td>
            <td align="right"><?= $kkt['number-FNS'] ?></td>
        </tr>
        <tr>
            <td>Сер. номер ККТ</td>
            <td align="right"><?= $kkt['number-KKT'] ?></td>
        </tr>
        <tr>
            <td>Сер. номер ФН</td>
            <td align="right"><?= $item->fiscal_storage_number ?></td>
        </tr>
        <tr>
            <td>Адрес сайта ФНС</td>
            <td align="right"><?= $kkt['site-FNS'] ?></td>
        </tr>
        <tr>
            <td>Название ОФД</td>
            <td align="right"><?= $kkt['OFD'] ?></td>
        </tr>
        <tr>
            <td>Сайт ОФД для проверки чека</td>
            <td align="right"><?= $kkt['site-OFD'] ?></td>
        </tr>
        <tr>
            <td>ИНН ОФД</td>
            <td align="right"><?= $kkt['INN-OFD'] ?></td>
        </tr>
    </table>
    <!-- QR -->
    <table width="100%">
        <tr>
            <td align="center"><img src="<?= \Yii::$app->params['staticHostInfo'] . '/files/temp/qr.png' ?>"
                                        style="height: 100px; width: auto;"></td>
        </tr>
    </table>
    <hr/>
    <table width="100%">
        <tr>
            <td align="center">СПАСИБО!</td>
        </tr>
    </table>
</div>
