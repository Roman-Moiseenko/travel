<?php

use booking\entities\booking\tours\Tour;

/* @var $tour Tour */
$url = \Yii::$app->params['adminHostInfo'];
?>

<div class="mail-notice" style="color: #0b0b0b;">
    <table style="width: 100%;color: #0b0b0b;">
        <tr>
            <td></td>
            <td>
                <h2><?= 'Добрый день, ' ?><span style="color: #062b31"><?= $tour->user->username ?></span>!</h2>
            </td>
        </tr>
        <tr>
            <td style="width: 25%"></td>
            <td style="width: 50%; text-align: justify; border: 0; font-size: 16px;">
                <?= 'Сообщаем Вам, что Ваш объект ' ?>
                <a style="text-decoration: none; color: #0071c2;" href="<?= $url . '/tour/common?id=' . $tour->id ?>">
                    <?= $tour->name ?>
                </a><?= ' был заблокирован.' ?><br>
                <?= 'В случае, если Вы считаете, что блокировка произошла ошибочно, напишите нам в поддержку. ' .
                'Мы обязательно ответим.' ?>
            </td>
            <td style="width: 25%"></td>
        </tr>
    </table>
</div>