<?php

use booking\entities\booking\BaseBooking;
use booking\entities\forum\Message;
use booking\entities\forum\Post;
use booking\entities\moving\FAQ;
use booking\entities\shops\order\Order;
use booking\entities\shops\order\StatusHistory;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\UserForumHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $post Post */


$count2 = count($post->messages);
$number_page = floor($count2 / (int)(\Yii::$app->params['paginationForum']));
/*$page = '';
if ($count2 > 0) $page = '?page=' . ($number_page + 1);

$url = \Yii::$app->params['frontendHostInfo'] . '/forum/post/' . $message->post_id . $page . '#' . $message->id;
*/
$url = Url::to(['/forum/post', 'id' => $post->id, 'page' => 1], true);
?>

<div class="mail-notice" style="color: #0b0b0b;">
    <table style="width: 100%; border: 0;color: #0b0b0b;">
        <tr>
            <td style="width: 25%"></td>
            <td style="text-align: right; width: 50%">
                <?= 'Новый Пост на форуме ' ?>:&#160;
                <a style="text-decoration: none; color: #0071c2;" href="<?= $url ?>">
                    <b><?= $post->caption ?></b>
                </a>
            </td>
            <td style="width: 25%"></td>
        </tr>
    </table>
    <table style="width: 100%;color: #0b0b0b;">
        <tr>
            <td></td>
            <td>
                <?= UserForumHelper::encodeBB($post->lastMessage->text) ?>
            </td>
        </tr>
    </table>
</div>
