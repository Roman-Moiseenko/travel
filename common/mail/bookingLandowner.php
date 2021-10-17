<?php


use booking\forms\realtor\BookingLandowner;

/* @var $form BookingLandowner */

?>

<div class="mail-notice" style="color: #0b0b0b;">
    <table style="width: 100%;color: #0b0b0b;">
        <tr>
            <td></td>
            <td>
                <h2><?= 'Заявка на бронирование осмотра - ' ?><span style="color: #062b31"><?= $form->Landowner()->name ?></span>!</h2>
            </td>
        </tr>
        <tr>
            <td style="width: 25%"></td>
            <td style="width: 50%; text-align: justify; border: 0; font-size: 16px;">
                <?= 'Клиент ' . $form->name ?><br>
                <?= 'Телефон ' . $form->phone ?><br>
                <?= 'Почта ' . $form->email ?><br>
                <?= 'Период ' . $form->period ?><br>
                <?= 'Пожелания ' . $form->wish ?><br>
            </td>
            <td style="width: 25%"></td>
        </tr>
    </table>
</div>
