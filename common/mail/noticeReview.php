<?php

use booking\entities\booking\BaseReview;
/* @var $review BaseReview */

$url = \Yii::$app->params['officeHostInfo'];
?>

<div class="mail-notice" style="color: #0b0b0b;">
    <table style="width: 100%;color: #0b0b0b;">
        <tr>
            <td></td>
            <td>
                <h2>Новый отзыв</h2>
            </td>
        </tr>
        <tr>
            <td style="width: 25%"></td>
            <td style="width: 50%; text-align: justify; border: 0; font-size: 16px;">
                <?= 'Новый отзыв на ' ?>
                <a style="text-decoration: none; color: #0071c2;" href="<?= $url . $review->getLinks()['office'] ?>">
                    <?= $review->getName() ?>
                </a><br>
                <p>
                    <?= $review->text ?>
                </p>
            </td>
            <td style="width: 25%"></td>
        </tr>
    </table>
</div>
