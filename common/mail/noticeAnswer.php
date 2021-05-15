<?php

use booking\entities\booking\BaseBooking;
use booking\entities\moving\FAQ;
use booking\entities\shops\order\Order;
use booking\entities\shops\order\StatusHistory;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $faq FAQ */
$url = Url::to(['/moving/faq/category', 'id' => $faq->category_id], true);
?>

<div class="mail-notice" style="color: #0b0b0b;">
    <table style="width: 100%; border: 0;color: #0b0b0b;">
        <tr>
            <td style="width: 25%"></td>
            <td style="text-align: right; width: 50%">
                <?= 'На Ваш Вопрос был получен ответ ' ?>:&#160;
                <a style="text-decoration: none; color: #0071c2;" href="<?= $url ?>">
                    <b>Посмотреть на сайте</b>
                </a>
            </td>
            <td style="width: 25%"></td>
        </tr>
    </table>
    <table style="width: 100%;color: #0b0b0b;">
        <tr>
            <td></td>
            <td>
                <?= $faq->question ?>
            </td>
        </tr>
        <tr>
            <td style="width: 25%"></td>
            <td style="width: 50%; text-align: justify; border: 0; font-size: 16px;">
                <?= $faq->answer ?>
            </td>
            <td style="width: 25%"></td>
        </tr>
    </table>
</div>
