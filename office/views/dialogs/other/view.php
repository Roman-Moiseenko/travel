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

$this->title = $dialog->theme->caption;
$this->params['breadcrumbs'][] = ['label' => 'Клиент-Провайдер', 'url' => Url::to(['/dialogs/client'])];;
$this->params['breadcrumbs'][] = $this->title;

$client = 'Клиент ' . $dialog->user->personal->fullname->getFullname() . ' (ID=' . $dialog->user_id . ')';
$provider = 'Провайдер ' . $dialog->admin->personal->fullname->getFullname() . ' (ID=' . $dialog->provider_id . ')';
?>
<div class="conversation">
    <div class="dialog-caption">
            <div class="caption pb-2"><?= $client . ' - ' . $provider ?></div>
    </div>
    <div class="card mt-2">
        <div class="card-body">
            <?php foreach ($conversations as $conversation): ?>
                <?php if (User::class == $conversation->author) {
                    $classFlex = 'flex-row-reverse';
                    $classCard = 'bg-info text-white';
                    $caption = $client;
                } else {
                    $classFlex = 'flex-row';
                    $classCard = 'bg-light';
                    $caption = $provider;
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

