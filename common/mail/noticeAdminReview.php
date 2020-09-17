<?php

use booking\entities\booking\ReviewInterface;


/* @var $review ReviewInterface */

$url = \Yii::$app->params['adminHostInfo'];


?>

<div class="mail-notice" style="color: #0b0b0b;">
    <table style="width: 100%;color: #0b0b0b;">
        <tr>
            <td></td>
            <td>
                <h2><?= 'Добрый день, ' ?><span style="color: #062b31"><?= $review->getLegal()->name ?></span>!</h2>
            </td>
        </tr>
        <tr>
            <td style="width: 25%"></td>
            <td style="width: 50%; text-align: justify; border: 0; font-size: 16px;">
                <?= 'У Вас новый отзыв на ' ?>
                <a style="text-decoration: none; color: #0071c2;" href="<?= $url . $review->getLinks()['admin'] ?>">
                    <?= $review->getName() ?>
                </a><br>
                <?= 'В случае, если отзыв имеет какое-либо нарушение, в том числе, содержит мат, экстремистские высказывания, ' .
                 'ссылки на стороние ресурсы и др., Вы можете подать петицию в службу поддержки. Жалобу можно подать из кабинета данного объекта в разделе "Отзывы".' ?>
            </td>
            <td style="width: 25%"></td>
        </tr>
    </table>
</div>
