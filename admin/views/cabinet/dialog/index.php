<?php

use booking\entities\Lang;
use booking\entities\message\Dialog;
use booking\helpers\BookingHelper;
use booking\helpers\MessageHelper;
use yii\helpers\Url;



/* @var $dialogs Dialog[] */

$js = <<<JS
jQuery(document).ready(function($) {
    $(".link-conversation").click(function() {
        window.location = $(this).data("href");
    });
});
JS;

$this->registerJs($js);


$this->title = Lang::t('Сообщения');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dialogs-list">
    <table class="table table-adaptive table-striped">
        <tbody class="">
        <?php foreach ($dialogs as $dialog): ?>
            <tr class="link link-conversation" data-href="<?= Url::to(['conversation', 'id' => $dialog->id])?>">
                <td data-label="" width="60px">
                    <?php if (($countNew = $dialog->countNewConversation()) == 0):?>
                        <i class="far fa-envelope-open"></i>
                    <?php else: ?>
                        <i class="fas fa-envelope"></i>
                        <span class="badge badge-danger"><?= $countNew?></span>
                    <?php endif; ?>
                </td>
                <td data-label="Получатель">
                    <?php if ($dialog->typeDialog == Dialog::PROVIDER_SUPPORT):?>
                        <span class="badge badge-info p-1" style="font-size: 100% !important;">Служба поддержки</span>
                    <?php else: ?>
                        <?php $booking = BookingHelper::getByNumber($dialog->optional) ?>
                        <?= $booking->getName()?>
                    <?php endif; ?>
                </td>
                <td data-label="Тема">
                    <?= $dialog->theme->caption ?>
                </td>
                <td data-label="Время" >
                    <?= date('d-m-Y H:i:s', $dialog->lastConversation()->created_at) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>