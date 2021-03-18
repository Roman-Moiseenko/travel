<?php

use booking\entities\Lang;
use booking\entities\message\Conversation;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\forms\message\ConversationForm;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $dialog Dialog */
/* @var $conversations Conversation[] */
/* @var $model ConversationForm */

$this->title = Lang::t('Переписка') . '. ' . Lang::t($dialog->theme->caption);
$this->params['breadcrumbs'][] = ['label' => Lang::t('Сообщения'), 'url' => Url::to(['cabinet/dialog/index'])];;
$this->params['breadcrumbs'][] = $this->title;
if ($dialog->typeDialog == Dialog::CLIENT_PROVIDER) {
    $booking = BookingHelper::getByNumber($dialog->optional);
    $who = $booking->getLegal()->caption;
} else {
    $booking = null;
    $who = 'Служба поддержки';
}
?>
<div class="conversation">
    <div class="dialog-caption">
        <?php if ($dialog->typeDialog == Dialog::CLIENT_PROVIDER): ?>
            <div class="caption pb-2"><?= '№ бронирования: ' ?> <a
                        href="<?= $booking->getLinks()->frontend ?>"><?= $dialog->optional ?></a></div>
            <a href="<?= $booking->getLinks()->entities ?>" class="caption-list">
                <?= $booking->getName() ?>
            </a>
        <?php else: ?>
            <div class="caption pb-2"><?= Lang::t('Служба поддержки') ?></div>
        <?php endif; ?>
    </div>
    <div class="conversation-new pt-2">
        <?php $form = ActiveForm::begin() ?>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'text')->textarea(['rows' => 5])->label(Lang::t('Новое сообщение')); ?>
            </div>
        </div>
        <div class="input-group">
            <?= Html::submitButton(Lang::t('Отправить'), ['class' => 'btn-lg btn-primary']) ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>

    <div class="card mt-2">
        <div class="card-body">
            <?php foreach ($conversations as $conversation): ?>
                <?php if (get_class(\Yii::$app->user->identity) == $conversation->author) {
                    $classFlex = 'flex-row-reverse';
                    $classCard = 'bg-info text-white';
                    $caption = Lang::t('Мой запрос');
                } else {
                    $classFlex = 'flex-row';
                    $classCard = 'bg-light';
                    $caption = $who;
                } ?>
                <div class="d-flex <?= $classFlex ?>">
                    <div class="card <?= $classCard ?> mb-1" style="width: 40%;">
                        <div class="card-header p-1 d-flex">
                            <div>
                            <?= date('d-m-Y H:i:s', $conversation->created_at)?>
                            </div>
                            <div class="ml-auto"> <?=  $caption ?></div>
                        </div>
                        <div class="card-body p-2">
                            <p class="card-text"><?= $conversation->text ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if ($dialog->typeDialog == Dialog::CLIENT_PROVIDER): ?>
            <div class="card-footer">
                <a href="<?= Url::to(['cabinet/petition', 'id' => $dialog->id]) ?>"><?= Lang::t('Подать жалобу') ?></a>
            </div>
        <?php endif; ?>

    </div>


</div>

