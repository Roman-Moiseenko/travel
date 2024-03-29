<?php

use booking\entities\Lang;
use booking\entities\message\Conversation;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\entities\user\User;
use booking\forms\message\ConversationForm;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $dialog Dialog */
/* @var $conversations Conversation[] */
/* @var $model ConversationForm */
/* @var $currentUser string */

$this->title = $dialog->theme->caption;
$this->params['breadcrumbs'][] = ['label' => 'Сообщения от провайдеров', 'url' => Url::to(['/dialogs/provider'])];;
$this->params['breadcrumbs'][] = $this->title;

$who = $dialog->admin->personal->fullname->getFullname();
?>
<div class="conversation">
    <div class="dialog-caption">
            <div class="caption pb-2"><?= $who ?></div>
    </div>
    <div class="conversation-new pt-2">
        <?php $form = ActiveForm::begin() ?>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'text')->textarea(['rows' => 5])->label(Lang::t('Новое сообщение')); ?>
            </div>
        </div>
        <div class="input-group">
            <?= Html::submitButton(Lang::t('Отправить'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>
    <div class="card mt-2">
        <div class="card-body">
            <?php foreach ($conversations as $conversation): ?>
                <?php if ($currentUser == $conversation->author) {
                    $classFlex = 'flex-row-reverse';
                    $classCard = 'bg-info text-white';
                    $caption = 'Ответ';
                } else {
                    $classFlex = 'flex-row';
                    $classCard = 'bg-light';
                    $caption = $who;
                } ?>
            <div class="d-flex <?= $classFlex ?>">
                <div class="card <?= $classCard ?> mb-1" style="width: 40%">
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
    </div>
</div>

