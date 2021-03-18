<?php

use booking\entities\admin\User;
use booking\entities\booking\ReviewInterface;
use booking\entities\Lang;
use booking\entities\message\Conversation;
use booking\entities\message\Dialog;
use booking\helpers\BookingHelper;
use yii\helpers\Url;


/* @var $review ReviewInterface */
/* @var $dialog Dialog */
/* @var $conversation Conversation */
/* @var $user_name string */


$url = \Yii::$app->params['frontendHostInfo'];
$conversation = $dialog->lastConversation();
$lang = $dialog->user->preferences->lang;
?>

<div class="mail-notice" style="color: #0b0b0b;">
    <table style="width: 100%;color: #0b0b0b;">
        <tr>
            <td></td>
            <td>
                <h2><?= Lang::t('Добрый день', $lang) . ', ' ?><span style="color: #062b31"><?= $user_name ?></span>!</h2>
            </td>
        </tr>
        <tr>
            <td style="width: 25%"></td>
            <td style="width: 50%; text-align: justify; border: 0; font-size: 16px;">
                <?= Lang::t('У Вас новое сообщение', $lang) . ' ' ?>
                <a style="text-decoration: none; color: #0071c2;"
                   href="<?= $url . '/conversation?id=' . $dialog->id ?>">
                    <?= $dialog->theme->caption ?>
                </a>
                <?php if (!empty($dialog->optional)): ?>
                    <?= Lang::t('Номер брони', $lang) . ': ' ?>
                <?php $booking = BookingHelper::getByNumber($dialog->optional); ?>
                    <a href="<?= $url . $booking->getLinks()->frontend ?>"><?= $dialog->optional ?></a>
                <?php endif; ?>
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
        <tr style="height: auto">
            <td style="width: 25%"></td>
            <td style="width: 50%; text-align: justify; border: 0; font-size: 16px;">
                <br>
                <span style="padding: 10px; margin: 10px">
                <?php if (!empty($dialog->optional)): ?>
                    <a href="<?= $url . '/conversation?id=' . $dialog->id ?>"><?= Lang::t('Перейти к диалогу', $lang) ?></a>
                <?php endif; ?>
                    </span>
                <p></p>
            </td>
            <td style="width: 25%"></td>
        </tr>
    </table>
</div>


