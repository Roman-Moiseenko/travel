<?php

/* @var $dialog Dialog */

/* @var $typeDialog integer */
/* @var $optional */

use booking\entities\Lang;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\helpers\BookingHelper;
use booking\helpers\DialogHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = Lang::t('Создать новый диалог');
$this->params['breadcrumbs'][] = $this->title;
$booking = BookingHelper::getByNumber($optional);
?>
<div class="dialog-caption">
    <?php if ($booking): ?>
        <div class="caption pb-2"><?= '№ бронирования: '?> <a href="<?= $booking->getLinks()['frontend'] ?>"><?= $optional ?></a></div>
        <a href="<?= $booking->getLinks()['entities'] ?>" class="caption-list">
            <?= $booking->getName() ?>
        </a>
    <?php else: ?>
        <div class="caption pb-2"><?= Lang::t('Служба поддержки') ?></div>
    <?php endif; ?>
</div>
<div class="dialog-new">
    <?php $form = ActiveForm::begin() ?>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'theme_id')->dropDownList(DialogHelper::getList($typeDialog), ['prompt' => '--- ' . Lang::t('Выберите') . ' ---'])->label(Lang::t('Тема сообщения')); ?>
            <?= $form->field($model, 'text')->textarea(['rows' => 7])->label(Lang::t('Сообщение')); ?>
        </div>
    </div>

    <div class="input-group">
        <?= Html::submitButton(Lang::t('Отправить'), ['class' => 'btn-lg btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>

