<?php

/* @var $object string */
/* @var $username string */

?>

<div class="mail-notice" style="color: #0b0b0b;">
    <table style="width: 100%;color: #0b0b0b;">
        <tr>
            <td colspan="2">
                <h2>Активация нового объекта</span></h2>
            </td>
        </tr>
        <tr>
            <td style="width: 25%">Username</td>
            <td style="width: 50%; text-align: justify; border: 0; font-size: 16px;">
                <?= $username ?>
            </td>
        </tr>
        <tr>
            <td style="width: 25%">Объект</td>
            <td style="width: 50%; text-align: justify; border: 0; font-size: 16px;">
                <?= $object ?>
            </td>
        </tr>
    </table>
</div>

