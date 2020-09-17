<?php

use booking\entities\admin\user\User;
use booking\entities\booking\ReviewInterface;
use booking\entities\message\Conversation;
use booking\entities\message\Dialog;
use yii\helpers\Url;


/* @var $review ReviewInterface */
/* @var $dialog Dialog */
/* @var $conversation Conversation */
/* @var $user_name string */

$url = \Yii::$app->params['adminHostInfo'];
$conversation = $dialog->lastConversation();
?>

<div class="mail-notice" style="color: #0b0b0b;">
    <table style="width: 100%;color: #0b0b0b;">
        <tr>
            <td></td>
            <td>
                <h2><?= 'Добрый день, ' ?><span style="color: #062b31"><?= $user_name ?></span>!</h2>
            </td>
        </tr>
        <tr>
            <td style="width: 25%"></td>
            <td style="width: 50%; text-align: justify; border: 0; font-size: 16px;">
                <?= 'У Вас новое сообщение ' ?>
                <a style="text-decoration: none; color: #0071c2;"
                   href="<?= $url . '/cabinet/dialog/conversation?id=' . $dialog->id ?>">
                    <?= $dialog->theme->caption ?>
                </a><br>
            </td>
            <td style="width: 25%"></td>
        </tr>
        <tr style="height: auto">
            <td style="width: 25%"></td>
            <td style="width: 50%; text-align: justify; border: 0; font-size: 16px; background-color: #b0b0b0; border-radius: 4px; border-color: #0b0b0b">
                <br>
                <span style="padding: 10px; margin: 10px">
                <?= $conversation->text ?>
                    </span>
                <p></p>
            </td>
            <td style="width: 25%"></td>
        </tr>
    </table>
</div>

